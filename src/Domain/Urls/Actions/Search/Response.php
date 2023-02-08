<?php
/**
 * @copyright 2018-2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Search;

class Response 
{
    public array $urls = [];
    public $errors = [];
    public $total  = 0;

    public function __construct(array $urls, int $total=null, array $errors=null)
    {
        $this->urls = $urls;
        $this->total  = $total;
        $this->errors = $errors;

    }
}