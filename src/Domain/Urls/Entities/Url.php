<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Entities;

class Url
{
    public ?int       $id       = null;
    public ?string    $username = null;
    public ?string    $code     = null;
    public ?string    $original = null;
    public ?string    $title    = null;
    public ?\DateTime $created  = null;
    public ?\DateTime $updated  = null;
    public ?int       $hits     = null;
    public ?bool      $preview  = null;

    public function __construct(?array $data=null)
    {
        if ($data) {
            foreach ($this as $k=>$v) {
                if (!empty($data[$k])) {
                    switch ($k) {
                        case 'preview':
                            $this->$k = $data[$k] ? true : false;
                        break;

                        case 'id':
                        case 'hits':
                            $this->$k = (int)$data[$k];
                        break;

                        case 'created':
                        case 'updated':
                            $this->$k = new \DateTime($data[$k]);
                        break;

                        default:
                            $this->$k = $data[$k];
                    }
                }
            }
        }
    }
}
