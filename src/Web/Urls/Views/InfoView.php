<?php
/**
 * @copyright 2016-2021 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Views;

use Web\View;

// use Domain\Urls\Actions\Info\Response as InfoResponse;


class InfoView extends View
{
    
    public function render(): string
    {
        return $this->twig->render("{$this->outputFormat}/urls/info.twig", $this->vars);
    }
}


