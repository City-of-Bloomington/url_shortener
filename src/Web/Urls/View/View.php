<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\View;

use Domain\Urls\Actions\Info\Response;

class View extends \Web\View
{
    public function __construct(Response $response)
    {
        parent::__construct();

        $this->vars = [
            'url' => $response->url
        ];
    }

    public function render(): string
    {
        return $this->twig->render("{$this->outputFormat}/urls/info.twig", $this->vars);
    }
}
