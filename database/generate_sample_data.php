<?php

$schools = ['SOG', 'STHEM', 'SOL', 'SOE', 'IBS', 'SBM', 'SOC'];
$programmes = ['MSc IT', 'PhD Finance', 'DBA', 'MSc Management', 'PhD Education', 'MSc Accounting'];
$statuses = [
    'Thesis Submitted',
    'Examiner Assigned',
    'Viva Scheduled',
    'Viva Completed',
    'Corrections Submitted',
    'Ready for Senate',
    'Graduated'
];
$vivaResults = ['Pass', 'Minor Corrections', 'Major Corrections', 'Re-viva', 'Fail'];

$firstNames = ['Ahmad', 'Siti', 'Nur', 'Muhammad', 'Ali', 'Fatimah', 'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emma', 'Daniel', 'Olivia', 'James', 'Isabella', 'William', 'Sophia', 'Joseph', 'Mia'];
$lastNames = ['Abdullah', 'Mohammad', 'Ibrahim', 'Hassan', 'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas'];

$sql = "USE `prvts_db`;\n\n";

for ($i = 1; $i <= 80; $i++) {
    $matricNo = '8' . str_pad($i, 5, '0', STR_PAD_LEFT);
    $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    $school = $schools[array_rand($schools)];
    $programme = $programmes[array_rand($programmes)];
    $degreeLevel = ['Masters', 'PhD', 'DBA'][array_rand(['Masters', 'PhD', 'DBA'])];
    
    $yearStart = rand(2018, 2023);
    $cohort = "Cohort $yearStart";
    
    // Random dates
    $itsDate = date('Y-m-d', strtotime("$yearStart-01-01 +" . rand(0, 365) . " days"));
    
    $thesisTitle = "A Study on the Impact of " . rand(100, 999) . " Factors in " . $school;
    $status = $statuses[array_rand($statuses)];
    
    $sql .= "INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ";
    $sql .= "('$matricNo', '$name', '$programme', '$school', '$degreeLevel', '$cohort', '$itsDate', '$thesisTitle', '$status');\n";
    
    // Also create viva record if they are at or past Viva phase
    $vivaDate = 'NULL';
    $vivaResult = 'NULL';
    
    if (in_array($status, ['Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
        $vivaYear = rand(2023, 2025);
        $vivaDateStr = date('Y-m-d', strtotime("$vivaYear-01-01 +" . rand(0, 365) . " days"));
        $vivaDate = "'$vivaDateStr'";
        $vivaResult = "'" . $vivaResults[array_rand($vivaResults)] . "'";
    } elseif ($status == 'Viva Scheduled') {
        $vivaYear = 2026;
        $vivaDateStr = date('Y-m-d', strtotime("$vivaYear-08-01 +" . rand(0, 100) . " days"));
        $vivaDate = "'$vivaDateStr'";
    }
    
    if ($vivaDate !== 'NULL') {
        $sql .= "INSERT INTO `viva_records` (`student_id`, `viva_date`, `viva_result`) VALUES ";
        // We use LAST_INSERT_ID()
        $sql .= "(LAST_INSERT_ID(), $vivaDate, $vivaResult);\n";
    }
}

file_put_contents(__DIR__ . '/sample_data.sql', $sql);
echo "Generated sample_data.sql successfully.\n";
