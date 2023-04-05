<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Search;

class Response 
{
    public function __construct(public ?array $urls  = [],
                                public ?int   $total = null,
                                public ?array $errors = []) {}
}
