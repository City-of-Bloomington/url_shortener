<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Delete;

use Domain\Urls\DataStorage\UrlsRepository;
use Domain\Urls\Entities\Url;

class Command
{
    private UrlsRepository $repo;

    public function __construct(private UrlsRepository $repository)
    {
        $this->repo = $repository;
    }

    public function __invoke(int $id): Response
    {
        try {
            $this->repo->delete($id);
            return new Response();
        }
        catch (\Exception $e) {
            return new Response([$e->getMessage()]);
        }
    }
}
