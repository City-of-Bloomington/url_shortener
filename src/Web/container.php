<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license http://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
use Aura\Di\ContainerBuilder;
use Domain\Urls\Entities\Urls;

$builder = new ContainerBuilder();
$DI = $builder->newInstance();

$DI->set('db.default', \Web\Database::getConnection($DATABASES['default'], 'default'));

//---------------------------------------------------------
// Declare database repositories
//---------------------------------------------------------
$repos = [
    'Urls'
];
foreach ($repos as $t) {
    $DI->params[ "Web\\$t\\Pdo{$t}Repository"]["pdo"] = $DI->lazyGet('db.default');
    $DI->set("Domain\\$t\\DataStorage\\{$t}Repository",
    $DI->lazyNew("Web\\$t\\Pdo{$t}Repository"));
}

//---------------------------------------------------------
// Metadata providers
//---------------------------------------------------------
$DI->params[ 'Domain\Urls\Metadata']['repository'] = $DI->lazyGet('Domain\Urls\DataStorage\UrlsRepository');
$DI->set(    'Domain\Urls\Metadata',
$DI->lazyNew('Domain\Urls\Metadata'));

//---------------------------------------------------------
// Services
//---------------------------------------------------------

//---------------------------------------------------------
// Use Cases
//---------------------------------------------------------

// URLS
foreach (['Add', 'Delete', 'Info', 'Search', 'Update'] as $a) {
    $DI->params[ "Domain\\Urls\\Actions\\$a\\Command"]["repository"] = $DI->lazyGet('Domain\Urls\DataStorage\UrlsRepository');
    $DI->set(    "Domain\\Urls\\Actions\\$a\\Command",
    $DI->lazyNew("Domain\\Urls\\Actions\\$a\\Command"));
}
