<?php
/**
 * @copyright 2023-2024 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Redirect;

use Domain\Urls\Entities\Url;

class View extends \Web\View
{
    public function __construct(Url $url)
    {
        parent::__construct();

        $this->vars = ['url' => $url];
    }

    public function render(): string
    {
        return $this->twig->render("html/urls/preview.twig", $this->vars);
    }
}
