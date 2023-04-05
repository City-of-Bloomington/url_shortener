<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Update;

class Request
{
    public function __construct(public int    $id,
                                public string $code,
                                public string $original,
                                public string $username) {}

    public static function fromArray(array $data): Request
    {
        return new Request($data['id'], $data['code'], $data['original'], $data['username']);
    }
}
