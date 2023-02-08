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
    public function __construct(Request  $request,
                                Response $response,
                                int      $itemsPerPage,
                                int      $currentPage)
    {
        parent::__construct();
        // if $response -> error
        // handle any Errors here | |
        //                        v v
        
        //                        ^ ^
    }
    */
    

    public function render(): string
    {
        $template = $this->outputFormat == 'html' ? 'urls/testView' : 'urls/list';
        return $this->twig->render("{$this->outputFormat}/$template.twig", $this->vars);
    }
}