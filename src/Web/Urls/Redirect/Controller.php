<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Redirect;

class Controller extends \Web\Controller
{
    public function __invoke(array $params): \Web\View
    {
        $repo = $this->di->get('Domain\Urls\DataStorage\UrlsRepository');
        try {
            $repo->incrementHits($params['code']);
            $url = $repo->load($params['code']);
            if ($url->preview) {
                return new View($url);
            }
            header('Location: '.$url->original);
            exit();
        }
        catch (\Exception $e) {
            return new \Web\Views\NotFoundView();
        }
    }
}
