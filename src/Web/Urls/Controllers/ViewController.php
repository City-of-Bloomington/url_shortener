<?php
/**
 * @copyright 2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Controllers;

use Domain\Urls\Entities\Person;
use Domain\Urls\Actions\Info\Request as InfoRequest;
use Web\Urls\Views\InfoView;
use Web\Controller;
use Web\View;

class ViewController extends Controller
{
    public function __invoke(array $parms): View
    {
        if (!empty($_REQUEST['id'])) {
            $info = $this->di->get('Domain\Urls\Actions\Info\Command');
            $res  = $info((int)$_REQUEST['id']);
            if ($res->person) {
                return new InfoView($res);
            }
            else {
                $_SESSION['errorMessages'] = $res->errors;
            }
        }
        return new \Web\Views\NotFoundView();
    }
}
