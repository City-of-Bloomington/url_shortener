<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 * @see https://auraphp.com/packages/3.x/Sql/
 */
declare (strict_types=1);
namespace Web\Urls;

use Aura\SqlQuery\Common\SelectInterface;
use Domain\Urls\DataStorage\UrlsRepository;
use Domain\Urls\Entities\Url;
use Domain\Urls\Actions\Search\Request as SearchRequest;
use Web\PdoRepository;

class PdoUrlsRepository extends PdoRepository implements UrlsRepository
{
    const TABLE = 'urls';
    public static $DEFAULT_SORT = ['username', 'code'];

    public function columns()
    {
        static $columns;
        if (!$columns) { $columns = array_keys(get_class_vars('Domain\Urls\Entities\Url')); }
        return $columns;
    }

    /**
     * @param int|string $id  Either the ID or Code value
     */
    public function load($id): Url
    {
        $select = $this->queryFactory->newSelect();
        $select->cols($this->columns())->from(self::TABLE);

        if (is_numeric($id)) { $select->where(  'id=?', $id); }
        else                 { $select->where('code=?', $id); }

        $result = $this->performSelect($select);
        if (count($result['rows'])) {
            return self::hydrate($result['rows'][0]);
        }
        throw new \Exception('url/unknown');
    }

    public static function hydrate(array $row): Url
    {
        return new Url($row);
    }

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

    public function save(Url $url): int
    {
        $data = (array)$url;
        unset($data['created']);
        unset($data['updated']);
        return parent::saveToTable($data, self::TABLE);
    }

    public function delete(int $id)
    {
        $delete = $this->pdo->prepare('delete from urls where id=?');
        $delete->execute([$id]);
    }

    private function doSelect(SelectInterface $select, ?array $order=null, ?int $itemsPerPage=null, ?int $currentPage=null): array
    {
        $result = parent::performSelect($select, self::$DEFAULT_SORT, $itemsPerPage, $currentPage);

        $urls = [];
        foreach ($result['rows'] as $r) { $urls[] = new Url($r); }
        $result['rows'] = $urls;
        return $result;
    }

    
}
