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


        $this->vars = [
            'urls'         => $response->urls,
            'total'        => $response->total,
            'order'        => $request->order,
            'itemsPerPage' => $request->itemsPerPage,
            'currentPage'  => $request->currentPage,
            'code'         => !empty($_GET['code'     ]) ? parent::escape($_GET['code'     ]) : '',
            'id'           => !empty($_GET['id'       ]) ? parent::escape($_GET['id'       ]) : '',
            'username'     => !empty($_GET['username' ]) ? parent::escape($_GET['username' ]) : '',
            'original'     => !empty($_GET['original' ]) ? parent::escape($_GET['original' ]) : '',
            'query'        => !empty($_GET['query'    ]) ? parent::escape($_GET['query'    ]) : '',
            'usernames'    => $metadata->usernames(),
            'sorts'        => $valid_sorts,
            'CODE_LENGTH'  => CODE_LENGTH
        ];
    }

    public function render(): string
    {
        $template = $this->outputFormat == 'html' ? 'urls/findForm' : 'urls/list';
        return $this->twig->render("{$this->outputFormat}/$template.twig", $this->vars);
    }
}
