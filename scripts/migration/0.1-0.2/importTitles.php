<?php
/**
 * @copyright 2023 City of Bloomington, Indiana
 * @license https://www.gnu.org/licenses/agpl.txt GNU/AGPL, see LICENSE
 */
declare (strict_types=1);
$conf   = include './config.php';
$pdo    = new \PDO("$conf[driver]:dbname=$conf[name];host=$conf[host]", $conf['user'], $conf['pass'], $conf['opts']);
$update = $pdo->prepare("update urls set title=? where code=?");
$csv    = fopen('./urls.csv', 'r');
while ($row = fgetcsv($csv)) {
    $update->execute([
        $row[1],
        $row[0]
    ]);
}
