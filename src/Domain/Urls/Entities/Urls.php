<?php
/**
 * @copyright 2018-2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Entities;

class Urls
{
    // urls:
    public $id;
    public $person_id;
    public $code;
    public $original;

    public function __construct(?array $data=null)
    {
        if ($data) {
            if (!empty($data['id'       ])) { $this->id        = (int)$data['id'  ]; }
            if (!empty($data['person_id'])) { $this->person_id = $data['person_id']; }
            if (!empty($data['code'     ])) { $this->code      = $data['code'     ]; }
            if (!empty($data['original' ])) { $this->original  = $data['original' ]; }
        }
    }

    /*
    public function __toString()
    {
        //return "{$this->firstname} {$this->lastname}";
        return "{$this->code}";
    }

    public function jsonSerialize(): mixed
    {
        return array_merge((array)$this, ['fullname'=>$this->__toString()]);
    }
    */
    
    
}