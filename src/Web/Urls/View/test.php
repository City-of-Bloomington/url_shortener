<?php
namespace Web\Urls\View;

use Web\View;

class test extends View
{
    public function render(): string
    {
        return $this->twig->render("{$this->outputFormat}/urls/testView.twig", $this->vars);
    }

    

}