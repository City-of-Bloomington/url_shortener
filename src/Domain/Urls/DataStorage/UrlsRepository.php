<?php
/**
 * @copyright 2018-2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
namespace Domain\Urls\DataStorage;

use Domain\Urls\Entities\Urls;   // change Person --> Urls
use Domain\Urls\Actions\Search\Request as SearchRequest;

interface UrlsRepository
{
    public function load(int $person_id): Urls;
    public function search(SearchRequest $req): array;
    public function save(Urls $code): int;

    //public function load(int $person_id): Urls;
    //public function search(SearchRequest $req): array;
    //public function save(Urls $person): int;
}
