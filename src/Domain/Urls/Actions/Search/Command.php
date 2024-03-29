<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Search;

use Domain\Urls\DataStorage\UrlsRepository;
use Domain\Urls\Entities\Urls;

class Command
{
    private $repo;

    public function __construct(UrlsRepository $repository)
    {
        $this->repo = $repository;
    }

    public function __invoke(Request $req): Response
    {
        try {
            $result = $this->repo->search($req);
            return new Response($result['rows'], $result['total']);
        }
        catch (\Exception $e) {
            return new Response([], null, [$e->getMessage()]);
        }
    }
}
