<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Views;

use Web\Paginator;
use Web\View;

use Domain\Urls\Actions\Search\Request;
use Domain\Urls\Actions\Search\Response;
use Domain\Urls\Metadata;

class SearchView extends View
{
    public function __construct(Request  $request,
                                Response $response,
                                Metadata $metadata)
    {
        parent::__construct();

        if ($response->errors) {
            $_SESSION['errorMessages'] = $response->errors;
        }

        $valid_sorts = [
            'username', 'username desc',
            'created',   'created desc',
            'updated',   'updated desc',
            'hits',         'hits desc'
        ];

        $this->vars = (array)$request;
        $this->vars['urls'       ] = $response->urls;
        $this->vars['total'      ] = $response->total;
        $this->vars['usernames'  ] = $metadata->usernames();
        $this->vars['CODE_LENGTH'] = CODE_LENGTH;
        $this->vars['sorts'      ] = $valid_sorts;
    }

    public function render(): string
    {
        $template = $this->outputFormat == 'html' ? 'urls/findForm' : 'urls/list';
        return $this->twig->render("{$this->outputFormat}/$template.twig", $this->vars);
    }
}
