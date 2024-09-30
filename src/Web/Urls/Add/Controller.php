<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Add;

use Domain\Urls\Actions\Add\Request;

class Controller extends \Web\Controller
{
    public function __invoke(array $params): \Web\View
    {
        if (isset($_POST['code'])) {
            $add = $this->di->get('Domain\Urls\Actions\Add\Command');
            $req = new Request($_POST);
            $req->username = $_SESSION['USER']->username;
            $res = $add($req);

            if (!$res->errors) {
                header('Location: '.\Web\View::generateUrl('urls.view', ['id'=>$res->id]));
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

        return new View($req, $res ?? null);
    }

    private static function generateCode(): string
    {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code  = [];
        for ($i=0; $i<CODE_LENGTH; $i++) {
            $code[] = $chars[random_int(0, strlen($chars)-1)];
        }
        return implode('', $code);
    }
}
