<?php
/**
 * A example class for working with entries in LDAP.
 *
 * This class is written specifically for the City of Bloomington's
 * LDAP layout.  If you are going to be doing LDAP authentication
 * with your own LDAP server, you will probably need to customize
 * the fields used in this class.
 *
 * To implement your own identity class, you should create a class
 * in SITE_HOME/Classes.  The SITE_HOME directory does not get
 * overwritten during an upgrade.  The namespace for your class
 * should be Site\Classes\
 *
 * You can use this class as a starting point for your own implementation.
 * You will ned to change the namespace to Site\Classes.  You might also
 * want to change the name of the class to suit your own needs.
 *
 * @copyright 2011-2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
namespace Site;

use Web\Authentication\AuthenticationInterface;
use Web\Authentication\ExternalIdentity;

#ldap_set_option(NULL, LDAP_OPT_DEBUG_LEVEL, 7);

class Employee implements AuthenticationInterface
{
	private static $connection;
	private $config;


	public function __construct(array $config)
	{
        $this->config = $config;
	}

	public function identify(string $username): ?ExternalIdentity
	{
		$this->openConnection();

		$result = ldap_search(
			self::$connection,
			$this->config['base_dn'],
			$this->config['username_attribute']."=$username"
		);
		if (ldap_count_entries(self::$connection,$result)) {
			$entries = ldap_get_entries(self::$connection, $result);
			$entry = $entries[0];
			return new ExternalIdentity([
                'username'  => $username,
                'firstname' => $this->get('firstname', $entry),
                'lastname'  => $this->get('lastname',  $entry),
                'email'     => $this->get('email',     $entry)
			]);
		}
		else {
			throw new \Exception('ldap/unknownUser');
		}
	}

	public function authenticate(string $username, string $password): bool
	{
		$bindUser = sprintf(str_replace('{username}','%s',$this->config['user_binding']),$username);

		$connection = ldap_connect($this->config['server']) or die('ldap/connectionFailed');
		ldap_set_option($connection, LDAP_OPT_PROTOCOL_VERSION, 3);
		if (ldap_bind($connection,$bindUser,$password)) {
			return true;
		}
	}

	/**
	 * Creates the connection to the LDAP server
	 */
	private function openConnection()
	{
		if (!self::$connection) {
			if (self::$connection = ldap_connect($this->config['server'])) {
				ldap_set_option(self::$connection, LDAP_OPT_PROTOCOL_VERSION,3);
				ldap_set_option(self::$connection, LDAP_OPT_REFERRALS, 0);
				if (!empty($this->config['admin_binding'])) {
					if (!ldap_bind(
							self::$connection,
							$this->config['admin_binding'],
							$this->config['admin_pass']
						)) {
						throw new \Exception(ldap_error(self::$connection));
					}
				}
				else {
					if (!ldap_bind(self::$connection)) {
						throw new \Exception(ldap_error(self::$connection));
					}
				}
			}
			else {
				throw new \Exception(ldap_error(self::$connection));
			}
		}
	}

	/**
	 * Maps Domain fields to LDAP fields
	 * $fieldmap[DOMAIN_FIELD] = LDAP_FIELD
	 */
	public static $fieldmap = [
        'username'  => 'cn',
        'firstname' => 'givenname',
        'lastname'  => 'sn',
        'email'     => 'mail',
        'phone'     => 'telephonenumber',
        'address'   => 'postaladdress',
        'city'      => 'l',
        'state'     => 'st',
        'zip'       => 'postalcode'
	];

	/**
	 * Returns the first scalar value from the entry's field
	 *
	 * @param  string $field Domain fieldname
	 * @return string        Ldap entry value
	 */
	private function get(string $field, array $entry): ?string
	{
        $key = self::$fieldmap[$field];
        return isset($entry[$key][0]) ? $entry[$key][0] : null;
	}
}
