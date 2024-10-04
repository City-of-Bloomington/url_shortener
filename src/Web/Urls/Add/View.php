<?php
/**
 * @copyright 2024 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Add;

use Domain\Urls\Actions\Add\Request;
use Domain\Urls\Actions\Add\Response;
use Domain\Urls\Metadata;

class View extends \Web\View
{
    public function __construct(Request  $request,
                               ?Response $response=null)
    {
        parent::__construct();

        if ($response && $response->errors) {
            $_SESSION['errorMessages'] = $response->errors;
        }

        $this->vars = [
            'url'         => $request,
            'CODE_LENGTH' => CODE_LENGTH,
            'CODE_MIN'    => CODE_MIN,
            'CODE_MAX'    => CODE_MAX,
            // 'CODE_PATTERN'  => Metadata::VALID_CHARACTER_CLASS
            'pattern'     => sprintf('.{%d,%d}', CODE_MIN, CODE_MAX)
        ];
    }

    public function render(): string
    {
        return $this->twig->render('html/urls/addForm.twig', $this->vars);
    }
}
