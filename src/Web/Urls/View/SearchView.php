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
            'total'       => $response->total,
            'itemsPerPage'=> $itemsPerPage,
            'currentPage' => $currentPage,
            'firstname'   => !empty($_GET['firstname']) ? parent::escape($_GET['firstname']) : '',
            'lastname'    => !empty($_GET['lastname' ]) ? parent::escape($_GET['lastname' ]) : '',
            'email'       => !empty($_GET['email'    ]) ? parent::escape($_GET['email'    ]) : ''
        ];
    }

    public function render(): string
    {
        $template = $this->outputFormat == 'html' ? 'urls/findForm' : 'urls/list';
        return $this->twig->render("{$this->outputFormat}/$template.twig", $this->vars);
    }
}


