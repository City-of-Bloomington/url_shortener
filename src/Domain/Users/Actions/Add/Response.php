<?php
/**
 * @copyright 2022 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Users\Actions\Add;

class Response
{
    public $id;
    public $errors = [];

    public function __construct(?int $id=null, ?array $errors=null)
    {
        if ($id    ) { $this->id     = $id;     }
        if ($errors) { $this->errors = $errors; }
    }
}
