<?php
/**
 * @copyright 2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Controllers;

use Domain\Urls\Actions\Update\Request;
use Domain\Urls\Actions\Update\Response;
use Web\Urls\Views\UpdateView;
use Web\Controller;
use Web\View;


class UpdateController extends Controller
{
    public function __invoke(array $params): View
    {
        if (isset($params['id'])) {
            $info = $this->di->get('Domain\Urls\Actions\Info\Command');
            $ir   = $info((int)$params['id']);
            if ($ir->errors) {
                return new \Web\Views\NotFoundView();
            }
            $req = new Request((array)$ir->url);
        }


        if (isset($_POST['code'])) {
            $update = $this->di->get('Domain\Urls\Actions\Update\Command');
            $req    = new Request($_POST);
            $req->username = $_SESSION['USER']->username;
            $res    = $update($req);
            if (!isset($res->errors)) {
                header("Location: ".View::generateUrl('urls.view', ['id'=>$res->id]));
            }
            else {
                $_SESSION['errorMessages'] = $res->errors;
            }
        }

        return new UpdateView($req, $res ?? null);
    }

}

