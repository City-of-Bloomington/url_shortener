<?php
/**
 * @copyright 2018-2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Users\Entities;

class User
{
    public $id;
    public $displayName;
    public $firstname;
    public $lastname;
    public $email;

    public $username;
    public $role;

    public function __construct(?array $data=null)
    {
        if ($data) {
            if (!empty($data['id'         ])) { $this->id          = (int)$data['id'  ]; }
            if (!empty($data['displayname'])) { $this->displayName = $data['displayname']; }
            if (!empty($data['firstname'  ])) { $this->firstname   = $data['firstname']; }
            if (!empty($data['lastname'   ])) { $this->lastname    = $data['lastname' ]; }
            if (!empty($data['email'      ])) { $this->email       = $data['email'    ]; }

            if (!empty($data['username'   ])) { $this->username    = $data['username' ]; }
            if (!empty($data['role'       ])) { $this->role        = $data['role'     ]; }
        }
    }

    public function getFullname(): string
    {
        return $this->displayName ?? "{$this->firstname} {$this->lastname}";
    }
}
