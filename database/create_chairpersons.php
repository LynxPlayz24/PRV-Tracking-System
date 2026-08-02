<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
use App\Core\Database;
$db = Database::getInstance();
$db->query('CREATE TABLE IF NOT EXISTS chairpersons (
    chairperson_id INT AUTO_INCREMENT PRIMARY KEY,
    chairperson_name VARCHAR(200) NOT NULL,
    email VARCHAR(200) DEFAULT NULL,
    phone VARCHAR(50) DEFAULT NULL,
    department VARCHAR(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci');
$db->execute();
echo 'chairpersons table created.' . PHP_EOL;
