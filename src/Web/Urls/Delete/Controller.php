<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Delete;

class Controller extends \Web\Controller
{
    public function __invoke(array $params): \Web\View
    {
        $delete = $this->di->get('Domain\Urls\Actions\Delete\Command');
        $res    = $delete((int)$params['id']);
        $return = $res->errors ? \Web\View::generateUrl('urls.view', ['id'=>$params['id']])
                               : \Web\View::generateUrl('urls.index');
        header("Location: $return");
        exit();
    }
}
