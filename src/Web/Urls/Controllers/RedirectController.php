<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Controllers;

use Web\Controller;
use Web\View;

class RedirectController extends Controller
{
    public function __invoke(array $params): View
    {
        $repo = $this->di->get('Domain\Urls\DataStorage\UrlsRepository');
        try {
            $url = $repo->load($params['code']);
            header('Location: '.$url->original);
            exit();
        }
        catch (\Exception $e) {
            return new \Web\Views\NotFoundView();
        }
    }
}