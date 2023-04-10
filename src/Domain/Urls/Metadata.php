<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls;

use Domain\Urls\DataStorage\UrlsRepository;

class Metadata
{
    private $repo;

    public function __construct(UrlsRepository $repository)
    {
        $this->repo = $repository;
    }

    public function usernames(): array { return $this->repo->usernames(); }
}
