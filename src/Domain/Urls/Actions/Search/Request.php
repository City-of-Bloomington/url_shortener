<?php
/**
 * @copyright 2018-2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Search;

class Request {
    public string $code;
    public $id;
    public $person_id;
    public $original;

    public function __construct(?array $data=null, ?array $order=null, ?int $itemsPerPage=null, ?int $currentPage=null)
    {
        if ($data) 
        {
            if (!empty($data['id'       ])) { $this->id   = (int)$data['id'       ]; }
            if (!empty($data['person_id'])) { $this->person_id = $data['person_id']; }
            if (!empty($data['code'     ])) { $this->code      = $data['code'     ]; }
            if (!empty($data['original' ])) { $this->original  = $data['original' ]; }
        }
    }
}
