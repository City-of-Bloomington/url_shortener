<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare(strict_types=1);

namespace Domain\Urls\Actions\Update;

class Response
{
    public array $errors;

    public function __construct(array $errors = [])
    {
        $this->errors = $errors;
    }
}