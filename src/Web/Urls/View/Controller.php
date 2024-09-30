<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\View;

class Controller extends \Web\Controller
{
    public function __invoke(array $params): \Web\View
    {
        $info = $this->di->get('Domain\Urls\Actions\Info\Command');
        $res  = $info((int)$params['id']);
        if ($res->url) {
            return new View($res);
        }
        else {
            $_SESSION['errorMessages'] = $res->errors;
        }
        return new \Web\Views\NotFoundView();
    }
}
