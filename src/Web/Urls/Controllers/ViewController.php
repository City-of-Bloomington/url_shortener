<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Controllers;

use Domain\Urls\Actions\Info\Request as InfoRequest;
use Web\Urls\Views\InfoView;
use Web\Controller;
use Web\View;

class ViewController extends Controller
{
    public function __invoke(array $params): View
    {
            $info = $this->di->get('Domain\Urls\Actions\Info\Command');
            $res  = $info((int)$params['id']);
            if ($res->url) {
                return new InfoView($res);
            }
            else {
                $_SESSION['errorMessages'] = $res->errors;
            }
        return new \Web\Views\NotFoundView();
    }
}
