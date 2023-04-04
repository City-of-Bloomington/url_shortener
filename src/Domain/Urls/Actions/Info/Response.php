<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Info;

use Domain\Urls\Entities\Url;

class Response
{
    public function __construct(public ?Url $url=null, public ?array $errors=[])
    {
    }
}
