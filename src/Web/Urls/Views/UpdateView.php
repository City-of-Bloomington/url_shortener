<?php
/**
 * @copyright 2019-2021 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);

namespace Web\Urls\Views;

use Domain\Urls\Actions\Update\Request;
use Domain\Urls\Actions\Update\Response;
use Domain\Urls\Metadata;

use Web\View;

class UpdateView extends View
{
    public function __construct(Request $request, ?Response $response=null)
    {
        parent::__construct();

        if ($response && $response->errors) {
            $_SESSION['errorMessages'] = $response->errors;
        }

        $this->vars = [
            'id'          => $request->id,
            'code'        => $request->code,
            'original'    => $request->original,
            'preview'     => $request->preview,
            'CODE_LENGTH' => CODE_LENGTH,
            'CODE_PATTERN'  => Metadata::VALID_CHARACTER_CLASS
        ];
    }

    public function render(): string
    {
        return $this->twig->render("{$this->outputFormat}/urls/updateForm.twig", $this->vars);
    }
}
