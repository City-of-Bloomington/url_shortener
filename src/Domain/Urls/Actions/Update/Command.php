<?php
declare(strict_types=1);

namespace Domain\Urls\Actions\Update;

use Domain\Urls\DataStorage\UrlsRepository;
use Domain\Urls\Entities\Url;

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
            return new Response($errors);
        }

        try {
            $url = new Url((array)$req);
            $this->repo->save($url);
            return new Response();
        }
        catch (\Exception $e) {
            return new Response([$e->getMessage()]);
        }
    }

    private static function validate(Request $req): array
    {
        $errors = [];
        if (!$req->id)       { $errors[] = 'missingId';       }
        if (!$req->code)     { $errors[] = 'missingCode';     }
        if (!$req->original) { $errors[] = 'missingOriginal'; }
        if (!$req->username) { $errors[] = 'missingUsername'; }
        return $errors;
    }
}