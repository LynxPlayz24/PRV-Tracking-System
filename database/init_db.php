<?php

require_once 'c:/xampp/htdocs/PRV_Tracking_System/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable('c:/xampp/htdocs/PRV_Tracking_System');
$dotenv->load();

use App\Core\Database;

$config = require 'c:/xampp/htdocs/PRV_Tracking_System/config/database.php';

$rawPdo = new \PDO("mysql:host={$config['host']};port={$config['port']}", $config['username'], $config['password'], $config['options']);
$rawPdo->exec("DROP DATABASE IF EXISTS prvts_db; CREATE DATABASE prvts_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci; USE prvts_db;");

$schemaFile = 'c:/xampp/htdocs/PRV_Tracking_System/database/schema.sql';
$sql = file_get_contents($schemaFile);

$rawPdo->exec("SET FOREIGN_KEY_CHECKS = 0;");
$statements = array_filter(array_map('trim', explode(';', $sql)));
foreach ($statements as $stmt) {
    if (!empty($stmt)) {
        $rawPdo->exec($stmt);
    }
}
$rawPdo->exec("SET FOREIGN_KEY_CHECKS = 1;");

echo "Database schema cleanly created!\n";

