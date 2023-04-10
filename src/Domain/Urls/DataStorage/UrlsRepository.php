<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\DataStorage;

use Domain\Urls\Entities\Url;
use Domain\Urls\Actions\Search\Request as SearchRequest;

interface UrlsRepository
{
    public function load(int $id): Url;
    public function search(SearchRequest $req): array;
    public function save(Url $code): int;

    public function usernames(): array;
}
