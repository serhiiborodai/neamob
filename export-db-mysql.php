<?php
/**
 * Export SQLite DB to MySQL format with domain replacement
 * Usage: php export-db-mysql.php > neamob.sql
 */
$sqlitePath = __DIR__ . '/wp-content/database/.ht.sqlite';
$replacements = [
    'http://localhost:8080' => 'https://neamob.com',
    'https://nb.twyx.us'   => 'https://neamob.com',
    'http://nb.twyx.us'    => 'https://neamob.com',
];

$pdo = new PDO('sqlite:' . $sqlitePath);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tables = $pdo->query("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%' ORDER BY name")
    ->fetchAll(PDO::FETCH_COLUMN);

echo "-- WordPress database dump for neamob.com\n";
echo "-- Generated: " . date('Y-m-d H:i:s') . "\n";
echo "-- Target: MySQL 8, PHP 8.3\n\n";
echo "SET NAMES utf8mb4;\n";
echo "SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';\n";
echo "SET FOREIGN_KEY_CHECKS = 0;\n";
echo "SET @@SESSION.information_schema_stats_expiry = 0;\n\n";

foreach ($tables as $table) {
    if ($table === '_mysql_data_types_cache') continue;
    
    $createSql = $pdo->query("SELECT sql FROM sqlite_master WHERE name=" . $pdo->quote($table))->fetchColumn();
    if (!$createSql) continue;
    
    $createSql = preg_replace('/\s+ON CONFLICT \w+\s*/i', ' ', $createSql);
    $createSql = preg_replace('/\s+COLLATE NOCASE\s*/i', ' ', $createSql);
    $createSql = str_replace('AUTOINCREMENT', 'AUTO_INCREMENT', $createSql);
    $createSql = preg_replace('/\bINTEGER\b/i', 'INT', $createSql);
    $createSql = preg_replace('/\bTEXT\b/i', 'LONGTEXT', $createSql);
    $createSql = preg_replace('/\bBLOB\b/i', 'LONGBLOB', $createSql);
    $createSql = str_replace('"', '`', $createSql);
    $createSql = preg_replace('/\s+NOT NULL\s+ON CONFLICT[^,\)]*/i', ' NOT NULL', $createSql);
    $createSql = preg_replace('/DEFAULT\s+[\'"]?[\d\-: ]+[\'"]?\s*\)/i', ')', $createSql);
    // AUTO_INCREMENT: убрать DEFAULT 0 (Invalid default value)
    $createSql = preg_replace('/AUTO_INCREMENT\s+NOT NULL\s+DEFAULT\s+0/i', 'AUTO_INCREMENT', $createSql);
    $createSql = preg_replace('/AUTO_INCREMENT\s+DEFAULT\s+0/i', 'AUTO_INCREMENT', $createSql);
    // LONGTEXT/LONGBLOB: MySQL не позволяет DEFAULT — удалить (BLOB/TEXT can't have default value)
    $createSql = preg_replace('/(LONGTEXT|LONGBLOB)(\s+NOT NULL)?\s+DEFAULT\s+[^,\)]+/i', '$1$2', $createSql);
    if (stripos($createSql, 'ENGINE=') === false) {
        $createSql = rtrim(rtrim($createSql), ';') . ' ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;';
    }
    echo "DROP TABLE IF EXISTS `$table`;\n";
    echo $createSql . "\n\n";
    
    $rows = $pdo->query("SELECT * FROM `$table`")->fetchAll(PDO::FETCH_ASSOC);
    if (empty($rows)) continue;
    
    $columns = array_keys($rows[0]);
    $colList = '`' . implode('`,`', $columns) . '`';
    
    foreach ($rows as $row) {
        $values = [];
        foreach ($row as $v) {
            if ($v === null) {
                $values[] = 'NULL';
            } else {
                $values[] = $pdo->quote($v);
            }
        }
        $sql = "INSERT INTO `$table` ($colList) VALUES (" . implode(',', $values) . ");\n";
        $sql = str_replace(array_keys($replacements), array_values($replacements), $sql);
        echo $sql;
    }
    echo "\n";
}

echo "SET FOREIGN_KEY_CHECKS = 1;\n";
