<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use App\Core\Database;

try {
    $db = Database::getInstance();
    $db->query("ALTER TABLE `students` MODIFY COLUMN `degree_level` VARCHAR(100) NOT NULL DEFAULT 'Masters'");
    $db->execute();
    echo "Successfully updated students.degree_level column to VARCHAR(100)!\n";
} catch (\Throwable $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
