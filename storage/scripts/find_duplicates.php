<?php
/**
 * Read-only script to detect duplicate/dirty Supervisor and Examiner records.
 */

$pdo = new PDO('mysql:host=localhost;dbname=prvts_db;charset=utf8mb4', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

function normalizeName(string $name): string {
    // Remove inline emails and phone numbers if any
    $clean = preg_replace('/[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}/', '', $name);
    $clean = preg_replace('/01\d[\d\s\-]{6,}/', '', $clean);
    // Remove numbered prefixes like 1), 2), 1., 2.
    $clean = preg_replace('/\b\d+[\)\.]\s*/', '', $clean);
    // Remove common titles/honorifics
    $titles = [
        'assoc. prof.', 'prof. madya', 'prof. dato\'', 'prof. datin', 'prof. dr.', 'prof.',
        'assoc prof', 'prof madya', 'dr.', 'dr', 'ts.', 'ir.', 'hj.', 'hjh.', 'dato\'', 'datin'
    ];
    $clean = strtolower($clean);
    foreach ($titles as $t) {
        $clean = str_replace($t, '', $clean);
    }
    // Remove punctuation & extra whitespace
    $clean = preg_replace('/[^a-z0-9\s]/', '', $clean);
    $clean = preg_replace('/\s+/', ' ', $clean);
    return trim($clean);
}

function checkDirtyName(string $name): bool {
    return (bool)preg_match('/\b\d+[\)\.]\s*/', $name) || str_contains($name, '@') || preg_match('/01\d[\d\s\-]{6,}/', $name);
}

echo "=== PRVTS DUPLICATE & DIRTY RECORD SCAN REPORT ===\n\n";

// ----------------------------------------------------
// 1. SUPERVISORS SCAN
// ----------------------------------------------------
echo "--------------------------------------------------\n";
echo "1. SUPERVISORS ANALYSIS\n";
echo "--------------------------------------------------\n";

$supStmt = $pdo->query("SELECT s.*, 
    (SELECT COUNT(*) FROM student_supervisors ss WHERE ss.supervisor_id = s.supervisor_id) AS student_count
    FROM supervisors s ORDER BY supervisor_name ASC");
$supervisors = $supStmt->fetchAll(PDO::FETCH_ASSOC);

$supGroups = [];
$dirtySupervisors = [];

foreach ($supervisors as $sup) {
    if (checkDirtyName($sup['supervisor_name'])) {
        $dirtySupervisors[] = $sup;
    }
    $norm = normalizeName($sup['supervisor_name']);
    if ($norm === '') $norm = strtolower(trim($sup['supervisor_name']));
    $supGroups[$norm][] = $sup;
}

$supDupCount = 0;
foreach ($supGroups as $norm => $group) {
    if (count($group) > 1) {
        $supDupCount++;
        echo "\n[Supervisor Duplicate Group #{$supDupCount}] Normalized Key: \"{$norm}\"\n";
        foreach ($group as $idx => $item) {
            echo sprintf("  - ID: %-5d | Students: %-2d | Name: %-45s | Email: %-25s | Dept: %s\n",
                $item['supervisor_id'],
                $item['student_count'],
                $item['supervisor_name'],
                $item['email'] ?: '-',
                $item['department'] ?: '-'
            );
        }
    }
}

if ($supDupCount === 0) {
    echo "No exact/near-match duplicate supervisors found.\n";
}

if (!empty($dirtySupervisors)) {
    echo "\n[Dirty/Combined Supervisor Records]: " . count($dirtySupervisors) . " found\n";
    foreach ($dirtySupervisors as $d) {
        echo sprintf("  - ID: %-5d | Students: %-2d | Name: %s\n", $d['supervisor_id'], $d['student_count'], $d['supervisor_name']);
    }
}


// ----------------------------------------------------
// 2. EXAMINERS SCAN
// ----------------------------------------------------
echo "\n--------------------------------------------------\n";
echo "2. EXAMINERS ANALYSIS\n";
echo "--------------------------------------------------\n";

$exStmt = $pdo->query("SELECT e.*, 
    (SELECT COUNT(*) FROM student_examiners se WHERE se.examiner_id = e.examiner_id) AS student_count
    FROM examiners e ORDER BY examiner_name ASC");
$examiners = $exStmt->fetchAll(PDO::FETCH_ASSOC);

$exGroups = [];
$dirtyExaminers = [];

foreach ($examiners as $ex) {
    if (checkDirtyName($ex['examiner_name'])) {
        $dirtyExaminers[] = $ex;
    }
    $norm = normalizeName($ex['examiner_name']);
    if ($norm === '') $norm = strtolower(trim($ex['examiner_name']));
    $exGroups[$norm][] = $ex;
}

$exDupCount = 0;
foreach ($exGroups as $norm => $group) {
    if (count($group) > 1) {
        $exDupCount++;
        echo "\n[Examiner Duplicate Group #{$exDupCount}] Normalized Key: \"{$norm}\"\n";
        foreach ($group as $idx => $item) {
            echo sprintf("  - ID: %-5d | Class: %-8s | Students: %-2d | Name: %-45s | Email: %-25s | Inst: %s\n",
                $item['examiner_id'],
                $item['classification'],
                $item['student_count'],
                $item['examiner_name'],
                $item['email'] ?: '-',
                $item['institution'] ?: '-'
            );
        }
    }
}

if ($exDupCount === 0) {
    echo "No exact/near-match duplicate examiners found.\n";
}

if (!empty($dirtyExaminers)) {
    echo "\n[Dirty/Combined Examiner Records]: " . count($dirtyExaminers) . " found\n";
    foreach ($dirtyExaminers as $d) {
        echo sprintf("  - ID: %-5d | Students: %-2d | Name: %s\n", $d['examiner_id'], $d['student_count'], $d['examiner_name']);
    }
}

echo "\n=== END OF REPORT ===\n";
