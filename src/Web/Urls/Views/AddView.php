<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Web\Urls\Views;

use Domain\Urls\Actions\Add\Request;
use Domain\Urls\Actions\Add\Response;
use Domain\Urls\Metadata;
use Web\View;

class AddView extends View
{
    public function __construct(Request  $request,
                               ?Response $response=null)
    {
        parent::__construct();

        if ($response && $response->errors) {
            $_SESSION['errorMessages'] = $response->errors;
        }

        $this->vars = [
            'code'          => $request->code,
            'original'      => $request->original,
            'preview'       => $request->preview,
            'CODE_LENGTH'   => CODE_LENGTH,
            'CODE_PATTERN'  => Metadata::VALID_CHARACTER_CLASS
        ];
    }

    public function render(): string
    {
        return $this->twig->render('html/urls/addForm.twig', $this->vars);
    }
}
