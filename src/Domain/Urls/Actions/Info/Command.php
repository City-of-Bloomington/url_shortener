<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\Actions\Info;

use Domain\Urls\DataStorage\UrlsRepository;

class Command
{
    private $repo;

    public function __construct(UrlsRepository $repository)
    {
        $this->repo = $repository;
    }

    public function __invoke(int $id): Response
    {
        try {
            return new Response($this->repo->load($id));
        }
        catch (\Exception $e) {
            return new Response(null, [$e->getMessage()]);
        }
    }
}
