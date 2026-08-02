<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Core\Database;

$db = Database::getInstance();

try {
    $db->query("ALTER TABLE corrections ADD COLUMN colgis_jil_meeting_date DATE DEFAULT NULL AFTER abstract_received_date");
    $db->execute();
    echo "Added colgis_jil_meeting_date column." . PHP_EOL;
} catch (\Throwable $e) {
    echo "colgis_jil_meeting_date already exists or skipped: " . $e->getMessage() . PHP_EOL;
}

try {
    $db->query("ALTER TABLE corrections ADD COLUMN colgis_jil_meeting_no VARCHAR(100) DEFAULT NULL AFTER colgis_jil_meeting_date");
    $db->execute();
    echo "Added colgis_jil_meeting_no column." . PHP_EOL;
} catch (\Throwable $e) {
    echo "colgis_jil_meeting_no already exists or skipped: " . $e->getMessage() . PHP_EOL;
}

echo "Migration completed." . PHP_EOL;
