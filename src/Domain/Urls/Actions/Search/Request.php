<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Search;

class Request
{
    public $code;
    public $id;
    public $username;
    public $original;
    public $preview;
    public $query;

    public $order;
    public $itemsPerPage;
    public $currentPage;

    public function __construct(?array $data=null, ?string $order=null, ?int $itemsPerPage=null, ?int $currentPage=null)
    {
        if ($data)  {
            if (!empty($data['id'       ])) { $this->id   = (int)$data['id'       ]; }
            if (!empty($data['username' ])) { $this->username  = $data['username' ]; }
            if (!empty($data['code'     ])) { $this->code      = $data['code'     ]; }
            if (!empty($data['original' ])) { $this->original  = $data['original' ]; }
            if (!empty($data['query'    ])) { $this->query     = $data['query'    ]; }

            if (isset($data['preview'])) {
                if ($data['preview'])         { $this->preview = true;  }
                if ($data['preview']==0
                 || $data['preview']===false) { $this->preview = false; }
            }
        }
        if ($order       ) { $this->order        = $order;        }
        if ($itemsPerPage) { $this->itemsPerPage = $itemsPerPage; }
        if ($currentPage ) { $this->currentPage  = $currentPage;  }
    }
}
