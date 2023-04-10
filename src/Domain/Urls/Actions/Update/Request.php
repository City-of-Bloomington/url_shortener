<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Update;

class Request
{
    public ?int    $id       = null;
    public ?string $code     = null;
    public ?string $original = null;
    public ?string $username = null;

    public function __construct(array $data=null)
    {
        foreach ($this as $k=>$v) {
            if (!empty($data[$k])) {
                switch ($k) {
                    case 'id':
                        $this->$k = (int)$data[$k];
                    break;

                    default:
                        $this->$k = trim($data[$k]);

                }
            }
        }
    }
}
