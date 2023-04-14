<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Controllers;

use Domain\Urls\Actions\Add\Request;

use Web\Urls\Views\AddView;
use Web\Controller;
use Web\View;

class AddController extends Controller
{
    public function __invoke(array $params): View
    {
        if (isset($_POST['code'])) {
            $add = $this->di->get('Domain\Urls\Actions\Add\Command');
            $req = new Request($_POST);
            $req->username = $_SESSION['USER']->username;
            $res = $add($req);

            if (!$res->errors) {
                header('Location: '.View::generateUrl('urls.view', ['id'=>$res->id]));
                exit();
            }
            else {
                $_SESSION['errorMessages'] = $res->errors;
            }
        }
        else {
            $req = new Request();
            $req->code = self::generateCode();
        }

        return new AddView($req, $res ?? null);
    }

    private static function generateCode(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code  = [];
        for ($i=0; $i<CODE_LENGTH; $i++) {
            $code[] = $chars[random_int(0, strlen($chars))];
        }
        return implode('', $code);
    }
}
