<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\List;

use Domain\Urls\Actions\Search\Request as SearchRequest;

class Controller extends \Web\Controller
{
    public function __invoke(array $params): \Web\View
    {
		$page     = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
        $search   = $this->di->get('Domain\Urls\Actions\Search\Command');
        $request  = new SearchRequest($_GET,
                                      $_GET['sort'] ?? 'updated desc',
                                      parent::ITEMS_PER_PAGE,
                                      $page);
        $response = $search($request);

        return new View($request,
                        $response,
                        $this->di->get('Domain\Urls\Metadata'));
    }
}
