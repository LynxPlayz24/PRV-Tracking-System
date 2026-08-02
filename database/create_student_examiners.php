<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
use App\Core\Database;
$db = Database::getInstance();

// 1. student_examiners
$db->query("CREATE TABLE IF NOT EXISTS student_examiners (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    examiner_id INT NOT NULL,
    role ENUM('Internal', 'External') NOT NULL DEFAULT 'Internal',
    email_date DATE DEFAULT NULL,
    status ENUM('Pending', 'Confirmed') DEFAULT 'Pending',
    report_date DATE DEFAULT NULL,
    UNIQUE KEY uk_student_examiner (student_id, examiner_id),
    CONSTRAINT fk_se_student FOREIGN KEY (student_id) REFERENCES students(student_id) ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_se_examiner FOREIGN KEY (examiner_id) REFERENCES examiners(examiner_id) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
$db->execute();
echo "student_examiners table ready.\n";
