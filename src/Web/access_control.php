<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Acl;

use Laminas\Permissions\Acl\Acl;
use Laminas\Permissions\Acl\Role\GenericRole as Role;
use Laminas\Permissions\Acl\Resource\GenericResource as Resource;

use Laminas\Permissions\Acl\ProprietaryInterface;
use Laminas\Permissions\Acl\Resource\ResourceInterface;
use Laminas\Permissions\Acl\Role\RoleInterface;
use Laminas\Permissions\Acl\Assertion\OwnershipAssertion;

$ACL = new Acl();
$ACL->addRole(new Role('Anonymous'))
    ->addRole(new Role('Staff'),     'Anonymous')
    ->addRole(new Role('Administrator'));
/**
 * Create resources for all the routes
 */
foreach (array_keys($ROUTES->getMap()->getRoutes()) as $r) {
    list($resource, $permission) = explode('.', $r);
    if (!$ACL->hasResource($resource)) {
         $ACL->addResource(new Resource($resource));
    }
}
// Permissions for unauthenticated browsing
$ACL->allow(null, 'login');
$ACL->allow(null, 'urls', ['redirect', 'qrcode']);

$ACL->allow('Staff', 'help', 'help');

$ACL->allow('Staff', 'home', 'index');
$ACL->allow('Staff', 'urls', ['add', 'index', 'view', 'qrcode']);
$ACL->allow('Staff', 'urls', ['update', 'delete'], new OwnershipAssertion());

$ACL->allow('Administrator');

class User implements RoleInterface, ProprietaryInterface
{
    public function __construct(protected string $username, protected string $role) {}

    public function getRoleId () { return $this->role;     }
    public function getOwnerId() { return $this->username; }
}

class ResourceData implements ResourceInterface, ProprietaryInterface
{
    public function __construct(protected string $resource, protected string $username) {}

    public function getResourceId() { return $this->resource; }
    public function getOwnerId()    { return $this->username; }
}
