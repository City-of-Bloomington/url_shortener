<?php
/**
 * @copyright 2018-2019 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */


/** 
* database code 
*/


declare (strict_types=1);
namespace Web\Urls;


use Aura\SqlQuery\Common\SelectInterface;
use Domain\Urls\DataStorage\UrlsRepository;
use Domain\Urls\Entities\Urls;
use Domain\Urls\Actions\Search\Request as SearchRequest;
use Web\PdoRepository;

class PdoUrlsRepository extends PdoRepository implements UrlsRepository{

    const TABLE = 'urls';

    public static $DEFAULT_SORT = ['person_id', 'code'];
    public function columns()
    {
        static $columns;
        if (!$columns) { $columns = array_keys(get_class_vars('Domain\People\Entities\Person')); }
        return $columns;
    }

    public function load(int $person_id): Urls
    {
        $select = $this->queryFactory->newSelect();
        $select->cols($this->columns())->from(self::TABLE);
        $select->where('id=?', $person_id);
        $result = $this->performSelect($select);
        if (count($result['rows'])) {
            return new Urls($result['rows'][0]);
        }
        throw new \Exception('people/unknown');
    }


    public static function hydrate(array $row): Urls { return new Urls($row); }

    /**
     * Look for people using wildcard matching of fields
     */
    public function search(SearchRequest $req): array
    {
        $select = $this->queryFactory->newSelect();
        $select->cols($this->columns())->from(self::TABLE);

        foreach ($this->columns() as $f) {
            if (!empty($req->$f)) {
                $select->where("lower($f) like ?", strtolower($req->$f).'%');
            }
        }

        return parent::performHydratedSelect($select,
                                             __CLASS__.'::hydrate',
                                             self::$DEFAULT_SORT,
                                             $req->itemsPerPage,
                                             $req->currentPage);
    }

    /**
     * Saves a person and returns the ID for the person
     * 
     */
    public function save(Urls $person): int
    {
        return parent::saveToTable((array)$person, self::TABLE);
    }

    private function doSelect(SelectInterface $select, ?array $order=null, ?int $itemsPerPage=null, ?int $currentPage=null): array
    {
        $result = parent::performSelect($select, self::$DEFAULT_SORT, $itemsPerPage, $currentPage);

        $people = [];
        foreach ($result['rows'] as $r) { $people[] = new Urls($r); }
        $result['rows'] = $people;
        return $result;
    }
}
