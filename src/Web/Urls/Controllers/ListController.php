<?php
/**
 * Returns a list of people
 *
 * @copyright 2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Controllers;

use Domain\Urls\Actions\Search\Request as SearchRequest;
use Web\Urls\Views\SearchView;
use Web\Controller;
use Web\View;
// use Web\Urls\View\test;

class ListController extends Controller
{
    public function __invoke(array $params): View
    {
        // echo '--> ListController';
		$page   = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        // echo '$page';
        $search   = $this->di->get('Domain\Urls\Actions\Search\Command');
        // echo '$search';
        $request  = new SearchRequest($_GET, null, parent::ITEMS_PER_PAGE, $page);
        // echo '$request';
        $response = $search($request);

        return new SearchView($request, $response, parent::ITEMS_PER_PAGE, $page);
    
    }

}
