<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Add;

class Request
{
    public ?string $code     = null;
    public ?string $original = null;
    public ?string $username = null;

    public function __construct(array $data=null)
    {
        foreach ($this as $k=>$v) {
            if (!empty($data[$k])) { $this->$k = $data[$k]; }
        }
    }
}
