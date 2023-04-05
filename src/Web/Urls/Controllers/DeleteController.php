<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Controllers;

use Web\Controller;
use Web\View;

class DeleteController extends Controller
{
    public function __invoke(array $params): View
    {
        $delete = $this->di->get('Domain\Urls\Actions\Delete\Command');
        $res    = $delete((int)$params['id']);
        $return = $res->errors ? View::generateUrl('urls.view', ['id'=>$params['id']])
                               : View::generateUrl('urls.index');
        header("Location: $return");
        exit();
    }
}
