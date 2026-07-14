<?php

$schools = ['SOG', 'STHEM', 'SOL', 'SOE', 'IBS', 'SBM', 'SOC'];
$programmes = ['MSc IT', 'PhD Finance', 'DBA', 'MSc Management', 'PhD Education', 'MSc Accounting'];
$vivaResults = ['Pass', 'Minor Corrections', 'Major Corrections', 'Re-viva', 'Fail'];

$firstNames = ['Ahmad', 'Siti', 'Nur', 'Muhammad', 'Ali', 'Fatimah', 'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emma', 'Daniel', 'Olivia', 'James', 'Isabella', 'William', 'Sophia', 'Joseph', 'Mia', 'Kamal', 'Aminah'];
$lastNames = ['Abdullah', 'Mohammad', 'Ibrahim', 'Hassan', 'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Hernandez', 'Lopez', 'Gonzalez', 'Wilson', 'Anderson', 'Thomas', 'Salleh', 'Othman'];
$institutions = ['UUM', 'USM', 'UM', 'UKM', 'UPM', 'UiTM'];
$departments = ['Dept of Management', 'Dept of IT', 'Dept of Finance', 'Dept of Law', 'Dept of Education'];

function randomDate($startYear, $startDayOffset, $maxDays) {
    return date('Y-m-d', strtotime("$startYear-01-01 +$startDayOffset days +" . rand(0, $maxDays) . " days"));
}

function randomSequentialDate($prevDate, $minDays, $maxDays) {
    if (!$prevDate) return null;
    return date('Y-m-d', strtotime("$prevDate +" . rand($minDays, $maxDays) . " days"));
}

$sql = "USE `prvts_db`;\n\n";
$sql .= "SET FOREIGN_KEY_CHECKS=0;\n";
$sql .= "TRUNCATE TABLE `graduation`;\n";
$sql .= "TRUNCATE TABLE `corrections`;\n";
$sql .= "TRUNCATE TABLE `viva_records`;\n";
$sql .= "TRUNCATE TABLE `student_supervisors`;\n";
$sql .= "TRUNCATE TABLE `supervisors`;\n";
$sql .= "TRUNCATE TABLE `examiners`;\n";
$sql .= "TRUNCATE TABLE `students`;\n";
$sql .= "SET FOREIGN_KEY_CHECKS=1;\n\n";

// Generate Supervisors
for ($i = 1; $i <= 20; $i++) {
    $name = 'Dr. ' . $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    $email = strtolower(str_replace(' ', '.', $name)) . '@uum.edu.my';
    $dept = $departments[array_rand($departments)];
    $sql .= "INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('$name', '$email', '$dept');\n";
}
$sql .= "\n";

// Generate Examiners
for ($i = 1; $i <= 20; $i++) {
    $name = 'Prof. ' . $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    $inst = $institutions[array_rand($institutions)];
    $email = strtolower(str_replace(' ', '.', $name)) . '@' . strtolower($inst) . '.edu.my';
    $phone = '01' . rand(0,9) . '-' . rand(1000000, 9999999);
    $sql .= "INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('$name', '$inst', '$email', '$phone');\n";
}
$sql .= "\n";

// Controlled Distribution of Statuses
$statusDistribution = array_merge(
    array_fill(0, 10, 'Thesis Submitted'),
    array_fill(0, 10, 'Examiner Assigned'),
    array_fill(0, 10, 'Viva Scheduled'),
    array_fill(0, 10, 'Viva Completed'),
    array_fill(0, 15, 'Corrections Submitted'),
    array_fill(0, 15, 'Ready for Senate'),
    array_fill(0, 10, 'Graduated')
);
shuffle($statusDistribution);

// Generate Students and Related Data
for ($i = 1; $i <= 80; $i++) {
    $matricNo = '8' . str_pad($i, 5, '0', STR_PAD_LEFT);
    $name = $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
    $school = $schools[array_rand($schools)];
    $programme = $programmes[array_rand($programmes)];
    $degreeLevel = ['Masters', 'PhD', 'DBA'][array_rand(['Masters', 'PhD', 'DBA'])];
    
    $yearStart = rand(2018, 2023);
    $cohort = "Cohort $yearStart";
    
    $itsDate = randomDate($yearStart, 0, 365);
    $thesisTitle = "A Study on the Impact of " . rand(100, 999) . " Factors in " . $school;
    $status = $statusDistribution[$i - 1]; // Use distributed statuses to guarantee coverage
    
    $sql .= "INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ";
    $sql .= "('$matricNo', '$name', '$programme', '$school', '$degreeLevel', '$cohort', '$itsDate', '$thesisTitle', '$status');\n";
    $sql .= "SET @student_id = LAST_INSERT_ID();\n";
    
    // Assign Supervisor
    $sup1 = rand(1, 20);
    $sql .= "INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, $sup1, 'main');\n";
    
    if (rand(0, 1)) {
        $sup2 = rand(1, 20);
        if ($sup1 != $sup2) {
            $sql .= "INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, $sup2, 'co');\n";
        }
    }
    
    // VIVA RECORD
    if (in_array($status, ['Examiner Assigned', 'Viva Scheduled', 'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
        $intExam = rand(1, 10);
        $extExam = rand(11, 20);
        $chairperson = 'Prof. ' . $firstNames[array_rand($firstNames)] . ' ' . $lastNames[array_rand($lastNames)];
        
        $thesisSubDate = randomDate($yearStart + 2, 0, 365);
        $draftHardCopyDate = randomSequentialDate($thesisSubDate, 1, 5);
        $draftSoftCopyDate = randomSequentialDate($draftHardCopyDate, 0, 2);
        $turnitin = rand(5, 25) . '%';
        $draftSubFormDate = randomSequentialDate($draftSoftCopyDate, 1, 5);
        
        $intExamEmailDate = randomSequentialDate($draftSubFormDate, 1, 10);
        $extExamEmailDate = randomSequentialDate($draftSubFormDate, 1, 10);
        $panelApptDate = randomSequentialDate(max($intExamEmailDate, $extExamEmailDate), 1, 10);
        
        $thesisPanelHard = randomSequentialDate($panelApptDate, 1, 5);
        $thesisPanelSoft = randomSequentialDate($panelApptDate, 1, 5);
        
        $vivaDateStr = 'NULL';
        $vivaResult = 'NULL';
        
        if (in_array($status, ['Viva Scheduled', 'Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
            $confirmDateEmail = randomSequentialDate($thesisPanelSoft, 10, 20);
            $invitationLetterDate = randomSequentialDate($confirmDateEmail, 1, 5);
            $vivaDateRaw = randomSequentialDate($invitationLetterDate, 20, 40);
            $vivaDateStr = "'$vivaDateRaw'";
            
            if (in_array($status, ['Viva Completed', 'Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
                $vivaResultRaw = $vivaResults[array_rand($vivaResults)];
                if ($status == 'Corrections Submitted' && in_array($vivaResultRaw, ['Pass', 'Fail'])) {
                    $vivaResultRaw = 'Minor Corrections'; // override so corrections logic runs properly
                }
                $vivaResult = "'$vivaResultRaw'";
                $intReportDate = randomSequentialDate($vivaDateRaw, 1, 7);
                $bestThesis = rand(0, 1);
                
                $honChair = rand(100, 200);
                $honInt = rand(300, 500);
                $honExt = rand(300, 500);
                $honRef = rand(50, 100);
                
                $sql .= "INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, $intExam, $extExam, '$chairperson', '$thesisSubDate', '$draftHardCopyDate', '$draftSoftCopyDate', 
                         '$turnitin', '$draftSubFormDate', '$intExamEmailDate', '$extExamEmailDate', '$panelApptDate', '$thesisPanelHard', 
                         '$thesisPanelSoft', '$confirmDateEmail', '$invitationLetterDate', $vivaDateStr, $vivaResult, '$intReportDate', 
                         $bestThesis, '$honChair', '$honInt', '$honExt', '$honRef');\n";
                         
                // CORRECTIONS RECORD
                if (in_array($status, ['Corrections Submitted', 'Ready for Senate', 'Graduated'])) {
                    if ($vivaResultRaw != 'Pass' && $vivaResultRaw != 'Fail') {
                        $corrDeadline = randomSequentialDate($vivaDateRaw, 30, 90);
                        $corrSubDate = randomSequentialDate($vivaDateRaw, 20, 80);
                        $verStatus = (in_array($status, ['Ready for Senate', 'Graduated'])) ? "'Verified'" : "'In Progress'";
                        
                        $reviewedBy = "'Dr. " . $lastNames[array_rand($lastNames)] . "'";
                        $reportSentToStudentDate = randomSequentialDate($vivaDateRaw, 1, 5);
                        $internalReportStatus = "'Received'";
                        $externalReportStatus = "'Received'";
                        $correctedThesisReceivedDate = randomSequentialDate($corrSubDate, 1, 3);
                        $checklistAfterVivaDate = randomSequentialDate($correctedThesisReceivedDate, 1, 3);
                        $correctionScheduleDate = randomSequentialDate($checklistAfterVivaDate, 1, 2);
                        
                        $postTurnitin = rand(1, 15) . '%';
                        $supEndorse = randomSequentialDate($corrSubDate, 1, 5);
                        $sentToInt = randomSequentialDate($supEndorse, 1, 3);
                        $sentToExt = randomSequentialDate($supEndorse, 1, 3);
                        $sentToSupDate = randomSequentialDate($supEndorse, 1, 3);
                        $endorseExam = randomSequentialDate(max($sentToInt, $sentToExt), 5, 14);
                        
                        $abstractReceivedDate = randomSequentialDate($endorseExam, 1, 4);
                        $finalResult = "'Endorsed'";
                        
                        $sql .= "INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '$corrDeadline', '$corrSubDate', $verStatus, $reviewedBy, '$reportSentToStudentDate', $internalReportStatus, $externalReportStatus,
                                 '$correctedThesisReceivedDate', '$checklistAfterVivaDate', '$correctionScheduleDate',
                                 '$postTurnitin', '$supEndorse', '$sentToInt', '$sentToExt', '$sentToSupDate', '$endorseExam', '$abstractReceivedDate', $finalResult);\n";
                    }
                }
                
                // GRADUATION RECORD
                if (in_array($status, ['Ready for Senate', 'Graduated'])) {
                    $gradStatus = ($status == 'Graduated') ? "'Graduated'" : "'Ready'";
                    $jilStatus = "'Approved'";
                    $senateStatus = ($status == 'Graduated') ? "'Approved'" : "'Pending'";
                    
                    $gaisKeyinDate = randomSequentialDate($vivaDateRaw, 60, 80);
                    $jilDate = randomSequentialDate($vivaDateRaw, 90, 120);
                    $jilNo = "JIL/" . date('Y', strtotime($jilDate)) . "/" . rand(1, 10);
                    
                    $senateDate = ($status == 'Graduated') ? "'" . randomSequentialDate($jilDate, 30, 60) . "'" : "NULL";
                    $senateNo = ($status == 'Graduated') ? "'SENATE/" . date('Y', strtotime(str_replace("'", "", $senateDate))) . "/" . rand(1, 10) . "'" : "NULL";
                    $gradDate = ($status == 'Graduated') ? "'" . randomSequentialDate(str_replace("'", "", $senateDate), 30, 60) . "'" : "NULL";
                    
                    $thesisCert = randomSequentialDate($jilDate, 1, 10);
                    $finalThesisFormDate = randomSequentialDate($thesisCert, 1, 3);
                    $hardBound = randomSequentialDate($finalThesisFormDate, 5, 15);
                    $looseCopy = randomSequentialDate($finalThesisFormDate, 5, 15);
                    $cdCopies = randomSequentialDate($finalThesisFormDate, 5, 15);
                    $etdFormDate = randomSequentialDate($finalThesisFormDate, 5, 15);
                    $sentToPsbDate = randomSequentialDate($hardBound, 1, 5);
                    
                    $sql .= "INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, $jilStatus, $senateStatus, $gradStatus, $gradDate, '$gaisKeyinDate', '$jilDate', '$jilNo', $senateDate, 
                             $senateNo, '$thesisCert', '$finalThesisFormDate', '$hardBound', '$looseCopy', '$cdCopies', '$etdFormDate', '$sentToPsbDate');\n";
                }
                
            } else {
                // Scheduled but not completed
                $sql .= "INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, $intExam, $extExam, '$chairperson', '$thesisSubDate', '$draftHardCopyDate', '$draftSoftCopyDate', 
                         '$turnitin', '$draftSubFormDate', '$intExamEmailDate', '$extExamEmailDate', '$panelApptDate', '$thesisPanelHard', 
                         '$thesisPanelSoft', '$confirmDateEmail', '$invitationLetterDate', $vivaDateStr, NULL);\n";
            }
        } else {
            // Examiner Assigned but not scheduled yet
            $sql .= "INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, $intExam, $extExam, '$chairperson', '$thesisSubDate', '$draftHardCopyDate', '$draftSoftCopyDate', 
                     '$turnitin', '$draftSubFormDate', '$intExamEmailDate', '$extExamEmailDate', '$panelApptDate', '$thesisPanelHard', 
                     '$thesisPanelSoft');\n";
        }
    }
}

file_put_contents(__DIR__ . '/sample_data.sql', $sql);
echo "Generated comprehensive sample_data.sql successfully.\n";
