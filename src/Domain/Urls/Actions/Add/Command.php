<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Add;

use Domain\Urls\DataStorage\UrlsRepository;
use Domain\Urls\Entities\Url;
use Domain\Urls\Metadata;

class Command
{
    private $repo;

    public function __construct(UrlsRepository $repository)
    {
        $this->repo = $repository;
    }

    public function __invoke(Request $req): Response
    {
        $errors = self::validate($req);
        if ($errors) {
            return new Response(null, $errors);
        }

        try {
            $id = $this->repo->save(new Url((array)$req));
            return new Response($id);
        }
        catch (\Exception $e) {
            return new Response(null, [$e->getMessage()]);
        }
    }


    private static function validate(Request $req): array
    {
        $errors = [];
        if (!$req->code    ) { $errors[] = 'missingCode';     }
        if (!$req->original) { $errors[] = 'missingOriginal'; }
        if (!$req->username) { $errors[] = 'missingUsername'; }

        if (strlen($req->code) !== CODE_LENGTH) { $errors[] = 'invalidCodeLength'; }

        if (preg_match("/[^{Metadata::VALID_CHARACTER_CLASS}]+/", $req->code)) {
            $errors[] = 'invalidCodeCharacters';
        }

        return $errors;
    }
}
