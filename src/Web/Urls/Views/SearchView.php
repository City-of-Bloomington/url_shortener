<?php
/**
 * @copyright 2017-2021 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Views;

use Web\Paginator;
use Web\View;

use Domain\Urls\Actions\Search\Request;
use Domain\Urls\Actions\Search\Response;


class SearchView extends View
{
    /*
    
    public function render(): string
    {
        $template = $this->outputFormat == 'html' ? 'urls/testView' : 'urls/list';
        return $this->twig->render("{$this->outputFormat}/$template.twig", $this->vars);
    }
    */

    public function __construct(Request  $request,
                                Response $response,
                                int      $itemsPerPage,
                                int      $currentPage)
    {
        parent::__construct();

        if ($response->errors) {
            $_SESSION['errorMessages'] = $response->errors;
        }

        $this->vars = [
            'url'         => $response->urls,
            'total'        => $response->total,
            'itemsPerPage' => $itemsPerPage,
            'currentPage'  => $currentPage,
            'code'         => !empty($_GET['code'    ]) ? parent::escape($_GET['code'    ]) : '',
            'id'           => !empty($_GET['id'      ]) ? parent::escape($_GET['id'      ]) : '',
            'original'     => !empty($_GET['original']) ? parent::escape($_GET['original']) : ''
        ];
    }

    public function render(): string
    {
        $template = $this->outputFormat == 'html' ? 'urls/findForm' : 'urls/list';
        return $this->twig->render("{$this->outputFormat}/$template.twig", $this->vars);
    }
}



