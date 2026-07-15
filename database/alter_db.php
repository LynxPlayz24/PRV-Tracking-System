<?php
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Core/Database.php';

use App\Core\Database;

$db = Database::getInstance();

try {
    $db->query("ALTER TABLE viva_records ADD COLUMN internal_examiner_status ENUM('Pending', 'Confirmed') DEFAULT 'Pending' AFTER internal_examiner_email_date");
    $db->execute();
    echo "Added internal_examiner_status\n";
} catch (Exception $e) {
    echo "Error (or already exists): " . $e->getMessage() . "\n";
}

try {
    $db->query("ALTER TABLE viva_records ADD COLUMN external_examiner_status ENUM('Pending', 'Confirmed') DEFAULT 'Pending' AFTER external_examiner_email_date");
    $db->execute();
    echo "Added external_examiner_status\n";
} catch (Exception $e) {
    echo "Error (or already exists): " . $e->getMessage() . "\n";
}
echo "Done.";
