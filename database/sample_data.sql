USE `prvts_db`;

SET FOREIGN_KEY_CHECKS=0;
TRUNCATE TABLE `graduation`;
TRUNCATE TABLE `corrections`;
TRUNCATE TABLE `viva_records`;
TRUNCATE TABLE `student_supervisors`;
TRUNCATE TABLE `supervisors`;
TRUNCATE TABLE `examiners`;
TRUNCATE TABLE `students`;
SET FOREIGN_KEY_CHECKS=1;

INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Daniel Miller', 'dr..daniel.miller@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Jane Miller', 'dr..jane.miller@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Fatimah Gonzalez', 'dr..fatimah.gonzalez@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Daniel Salleh', 'dr..daniel.salleh@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Nur Mohammad', 'dr..nur.mohammad@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Sarah Martinez', 'dr..sarah.martinez@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Mia Anderson', 'dr..mia.anderson@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Jane Brown', 'dr..jane.brown@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Emma Hernandez', 'dr..emma.hernandez@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Daniel Salleh', 'dr..daniel.salleh@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Mia Thomas', 'dr..mia.thomas@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Isabella Rodriguez', 'dr..isabella.rodriguez@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Emma Anderson', 'dr..emma.anderson@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Sarah Martinez', 'dr..sarah.martinez@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. William Gonzalez', 'dr..william.gonzalez@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Aminah Wilson', 'dr..aminah.wilson@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. David Salleh', 'dr..david.salleh@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Michael Rodriguez', 'dr..michael.rodriguez@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. John Gonzalez', 'dr..john.gonzalez@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Mia Hassan', 'dr..mia.hassan@uum.edu.my', 'Dept of Law');

INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Kamal Rodriguez', 'UM', 'prof..kamal.rodriguez@um.edu.my', '015-9500825');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. John Jones', 'UM', 'prof..john.jones@um.edu.my', '012-6894751');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Joseph Johnson', 'UM', 'prof..joseph.johnson@um.edu.my', '015-1167736');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Sarah Jones', 'USM', 'prof..sarah.jones@usm.edu.my', '017-7750793');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Michael Wilson', 'UM', 'prof..michael.wilson@um.edu.my', '011-9515221');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Muhammad Salleh', 'UPM', 'prof..muhammad.salleh@upm.edu.my', '012-6019773');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. David Johnson', 'UPM', 'prof..david.johnson@upm.edu.my', '013-1194077');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Ali Jones', 'UKM', 'prof..ali.jones@ukm.edu.my', '015-1564975');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. William Othman', 'UM', 'prof..william.othman@um.edu.my', '011-3417430');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Ali Mohammad', 'UiTM', 'prof..ali.mohammad@uitm.edu.my', '014-8876531');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Sophia Othman', 'UKM', 'prof..sophia.othman@ukm.edu.my', '013-2758898');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Siti Johnson', 'UPM', 'prof..siti.johnson@upm.edu.my', '011-8303955');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Sophia Garcia', 'UM', 'prof..sophia.garcia@um.edu.my', '011-5575086');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Joseph Brown', 'UM', 'prof..joseph.brown@um.edu.my', '010-7854081');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. David Lopez', 'UPM', 'prof..david.lopez@upm.edu.my', '011-8645080');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Fatimah Williams', 'UiTM', 'prof..fatimah.williams@uitm.edu.my', '016-2354533');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. William Wilson', 'UUM', 'prof..william.wilson@uum.edu.my', '010-2651493');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Ahmad Williams', 'UiTM', 'prof..ahmad.williams@uitm.edu.my', '014-1337939');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. James Miller', 'UUM', 'prof..james.miller@uum.edu.my', '018-8606114');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Sarah Rodriguez', 'UiTM', 'prof..sarah.rodriguez@uitm.edu.my', '017-9819015');

INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800001', 'William Hassan', 'DBA', 'SOG', 'PhD', 'Cohort 2019', '2019-01-02', 'A Study on the Impact of 591 Factors in SOG', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 19, 'Prof. Siti Smith', '2021-04-23', '2021-04-26', '2021-04-28', 
                         '24%', '2021-04-29', '2021-05-02', 'Confirmed', '2021-04-30', 'Confirmed', '2021-05-03', '2021-05-07', 
                         '2021-05-08', '2021-05-27', '2021-05-28', '2021-06-24', 'Pass', '2021-06-30', 
                         1, '180', '350', '316', '99');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2022-01-16', '2021-08-30', '2021-10-07', 'JIL/2021/7', '2021-11-25', 
                             'SENATE/2021/10', '2021-10-13', '2021-10-15', '2021-10-27', '2021-10-30', '2021-10-28', '2021-10-29', '2021-10-29');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800002', 'Mia Rodriguez', 'MSc IT', 'STHEM', 'DBA', 'Cohort 2021', '2021-10-20', 'A Study on the Impact of 320 Factors in STHEM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 19, 'Prof. Sophia Abdullah', '2023-05-22', '2023-05-23', '2023-05-24', 
                         '10%', '2023-05-29', '2023-06-04', 'Confirmed', '2023-05-30', 'Confirmed', '2023-06-13', '2023-06-16', 
                         '2023-06-14', '2023-06-24', '2023-06-26', '2023-07-24', 'Minor Corrections', '2023-07-27', 
                         1, '121', '494', '300', '82');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-09-15', '2023-09-17', 'Verified', 'Dr. Anderson', '2023-07-28', 'Received', 'Received',
                                 '2023-09-18', '2023-09-21', '2023-09-22',
                                 '5%', '2023-09-22', '2023-09-25', '2023-09-25', '2023-09-23', '2023-10-04', '2023-10-08', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2023-09-25', '2023-10-26', 'JIL/2023/5', NULL, 
                             NULL, '2023-10-27', '2023-10-28', '2023-11-06', '2023-11-11', '2023-11-06', '2023-11-12', '2023-11-10');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800003', 'James Rodriguez', 'MSc Accounting', 'SOL', 'PhD', 'Cohort 2021', '2021-01-10', 'A Study on the Impact of 585 Factors in SOL', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 10, 20, 'Prof. John Martinez', '2023-05-11', '2023-05-14', '2023-05-15', 
                         '25%', '2023-05-20', '2023-05-21', 'Confirmed', '2023-05-26', 'Confirmed', '2023-05-29', '2023-06-02', 
                         '2023-06-03', '2023-06-19', '2023-06-22', '2023-07-21', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800004', 'Jane Abdullah', 'DBA', 'SOE', 'PhD', 'Cohort 2020', '2020-03-18', 'A Study on the Impact of 907 Factors in SOE', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 13, 'Prof. Aminah Hassan', '2022-12-15', '2022-12-17', '2022-12-19', 
                         '16%', '2022-12-24', '2022-12-30', 'Confirmed', '2022-12-27', 'Confirmed', '2023-01-07', '2023-01-10', 
                         '2023-01-11', '2023-01-24', '2023-01-29', '2023-03-09', 'Pass', '2023-03-16', 
                         1, '182', '444', '344', '73');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2023-05-15', '2023-06-09', 'JIL/2023/8', NULL, 
                             NULL, '2023-06-10', '2023-06-13', '2023-06-22', '2023-06-26', '2023-06-25', '2023-06-19', '2023-06-25');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800005', 'Joseph Thomas', 'MSc Management', 'SOC', 'Masters', 'Cohort 2020', '2020-01-04', 'A Study on the Impact of 504 Factors in SOC', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 17, 'Prof. Kamal Davis', '2022-10-08', '2022-10-13', '2022-10-14', 
                         '14%', '2022-10-18', '2022-10-23', 'Confirmed', '2022-10-28', 'Confirmed', '2022-11-01', '2022-11-02', 
                         '2022-11-03', '2022-11-17', '2022-11-18', '2022-12-24', 'Re-viva', '2022-12-28', 
                         1, '178', '411', '363', '55');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800006', 'Nur Hassan', 'PhD Education', 'SBM', 'PhD', 'Cohort 2020', '2020-09-30', 'A Study on the Impact of 522 Factors in SBM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 15, 'Prof. Sophia Mohammad', '2022-09-06', '2022-09-07', '2022-09-09', 
                         '14%', '2022-09-10', '2022-09-12', 'Confirmed', '2022-09-13', 'Confirmed', '2022-09-14', '2022-09-19', 
                         '2022-09-19', '2022-10-06', '2022-10-08', '2022-11-17', 'Major Corrections', '2022-11-24', 
                         1, '147', '315', '429', '82');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-02-08', '2023-01-01', 'In Progress', 'Dr. Mohammad', '2022-11-20', 'Received', 'Received',
                                 '2023-01-03', '2023-01-04', '2023-01-05',
                                 '11%', '2023-01-02', '2023-01-04', '2023-01-04', '2023-01-05', '2023-01-17', '2023-01-18', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800007', 'Sarah Gonzalez', 'MSc Management', 'STHEM', 'PhD', 'Cohort 2022', '2022-12-29', 'A Study on the Impact of 867 Factors in STHEM', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 6, 12, 'Prof. Michael Martinez', '2024-11-15', '2024-11-17', '2024-11-17', 
                         '9%', '2024-11-22', '2024-12-01', 'Confirmed', '2024-11-27', 'Confirmed', '2024-12-08', '2024-12-13', 
                         '2024-12-13', '2024-12-24', '2024-12-26', '2025-01-24', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800008', 'Joseph Salleh', 'MSc IT', 'SOG', 'DBA', 'Cohort 2022', '2022-05-30', 'A Study on the Impact of 673 Factors in SOG', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800009', 'Sarah Miller', 'PhD Education', 'SOC', 'Masters', 'Cohort 2018', '2018-08-04', 'A Study on the Impact of 895 Factors in SOC', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 1, 18, 'Prof. William Davis', '2020-10-18', '2020-10-20', '2020-10-22', 
                         '22%', '2020-10-24', '2020-10-31', 'Confirmed', '2020-10-26', 'Confirmed', '2020-11-02', '2020-11-04', 
                         '2020-11-06', '2020-11-16', '2020-11-19', '2020-12-28', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800010', 'Kamal Ibrahim', 'MSc Accounting', 'SOG', 'Masters', 'Cohort 2021', '2021-03-06', 'A Study on the Impact of 534 Factors in SOG', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 8, 15, 'Prof. David Abdullah', '2023-11-16', '2023-11-18', '2023-11-19', 
                     '9%', '2023-11-20', '2023-11-25', 'Confirmed', '2023-11-30', 'Pending', '2023-12-07', '2023-12-10', 
                     '2023-12-12');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800011', 'David Ibrahim', 'MSc Management', 'SOE', 'PhD', 'Cohort 2022', '2022-07-23', 'A Study on the Impact of 548 Factors in SOE', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 14, 'Prof. Kamal Jones', '2024-10-31', '2024-11-01', '2024-11-02', 
                         '24%', '2024-11-04', '2024-11-10', 'Confirmed', '2024-11-14', 'Confirmed', '2024-11-17', '2024-11-20', 
                         '2024-11-19', '2024-12-02', '2024-12-06', '2025-01-02', 'Fail', '2025-01-05', 
                         1, '188', '418', '451', '74');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-07-25', '2025-03-16', '2025-04-29', 'JIL/2025/7', '2025-06-08', 
                             'SENATE/2025/7', '2025-05-01', '2025-05-02', '2025-05-09', '2025-05-07', '2025-05-09', '2025-05-15', '2025-05-14');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800012', 'James Hernandez', 'MSc Accounting', 'SOL', 'Masters', 'Cohort 2020', '2020-01-15', 'A Study on the Impact of 181 Factors in SOL', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 20, 'Prof. Daniel Wilson', '2022-09-04', '2022-09-07', '2022-09-08', 
                         '5%', '2022-09-09', '2022-09-10', 'Confirmed', '2022-09-15', 'Confirmed', '2022-09-24', '2022-09-29', 
                         '2022-09-27', '2022-10-10', '2022-10-13', '2022-11-19', 'Major Corrections', '2022-11-20', 
                         1, '100', '410', '481', '99');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800013', 'Sarah Rodriguez', 'DBA', 'SBM', 'Masters', 'Cohort 2020', '2020-11-26', 'A Study on the Impact of 512 Factors in SBM', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 4, 13, 'Prof. Mia Othman', '2022-09-19', '2022-09-23', '2022-09-25', 
                         '20%', '2022-09-28', '2022-10-01', 'Confirmed', '2022-10-01', 'Confirmed', '2022-10-08', '2022-10-11', 
                         '2022-10-09', '2022-10-25', '2022-10-28', '2022-11-18', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800014', 'Ali Abdullah', 'MSc Accounting', 'SOC', 'Masters', 'Cohort 2020', '2020-11-27', 'A Study on the Impact of 486 Factors in SOC', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 20, 'Prof. Ahmad Othman', '2022-02-19', '2022-02-21', '2022-02-23', 
                         '19%', '2022-02-26', '2022-03-03', 'Confirmed', '2022-02-28', 'Confirmed', '2022-03-08', '2022-03-09', 
                         '2022-03-13', '2022-03-23', '2022-03-26', '2022-05-02', 'Minor Corrections', '2022-05-09', 
                         0, '129', '353', '315', '54');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-06-05', '2022-05-28', 'In Progress', 'Dr. Hernandez', '2022-05-06', 'Received', 'Received',
                                 '2022-05-31', '2022-06-02', '2022-06-04',
                                 '12%', '2022-05-30', '2022-06-01', '2022-05-31', '2022-06-01', '2022-06-12', '2022-06-16', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800015', 'David Anderson', 'MSc Management', 'SOE', 'DBA', 'Cohort 2023', '2023-08-23', 'A Study on the Impact of 459 Factors in SOE', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 18, 'Prof. Ahmad Ibrahim', '2025-03-20', '2025-03-21', '2025-03-22', 
                         '25%', '2025-03-23', '2025-03-24', 'Confirmed', '2025-04-02', 'Confirmed', '2025-04-04', '2025-04-06', 
                         '2025-04-06', '2025-04-18', '2025-04-22', '2025-05-14', 'Re-viva', '2025-05-19', 
                         0, '111', '432', '316', '57');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800016', 'Olivia Wilson', 'MSc IT', 'SOC', 'Masters', 'Cohort 2020', '2020-11-17', 'A Study on the Impact of 548 Factors in SOC', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 17, 'Prof. William Anderson', '2022-07-19', '2022-07-21', '2022-07-21', 
                         '25%', '2022-07-22', '2022-07-25', 'Confirmed', '2022-07-28', 'Confirmed', '2022-08-06', '2022-08-07', 
                         '2022-08-09', '2022-08-28', '2022-08-30', '2022-09-25', 'Minor Corrections', '2022-09-28', 
                         1, '174', '403', '302', '92');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-11-10', '2022-10-25', 'Verified', 'Dr. Miller', '2022-09-26', 'Received', 'Received',
                                 '2022-10-26', '2022-10-29', '2022-10-31',
                                 '7%', '2022-10-29', '2022-11-01', '2022-10-31', '2022-10-31', '2022-11-12', '2022-11-15', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-12-14', '2023-01-02', 'JIL/2023/4', NULL, 
                             NULL, '2023-01-10', '2023-01-12', '2023-01-23', '2023-01-23', '2023-01-22', '2023-01-25', '2023-01-26');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800017', 'James Jones', 'MSc IT', 'SOL', 'PhD', 'Cohort 2019', '2019-06-08', 'A Study on the Impact of 523 Factors in SOL', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 7, 20, 'Prof. Siti Hernandez', '2021-07-18', '2021-07-22', '2021-07-22', 
                     '20%', '2021-07-23', '2021-07-29', 'Confirmed', '2021-07-30', 'Pending', '2021-08-09', '2021-08-12', 
                     '2021-08-13');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800018', 'James Rodriguez', 'MSc Management', 'SOC', 'PhD', 'Cohort 2023', '2023-07-01', 'A Study on the Impact of 217 Factors in SOC', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 13, 'Prof. Jane Miller', '2025-04-17', '2025-04-19', '2025-04-19', 
                         '8%', '2025-04-22', '2025-04-28', 'Confirmed', '2025-04-25', 'Confirmed', '2025-05-08', '2025-05-13', 
                         '2025-05-09', '2025-05-25', '2025-05-29', '2025-07-02', 'Pass', '2025-07-06', 
                         1, '166', '440', '404', '85');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2025-09-09', '2025-10-09', 'JIL/2025/10', NULL, 
                             NULL, '2025-10-18', '2025-10-21', '2025-11-04', '2025-10-26', '2025-10-27', '2025-10-27', '2025-11-06');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800019', 'Aminah Lopez', 'MSc IT', 'SBM', 'PhD', 'Cohort 2022', '2022-12-13', 'A Study on the Impact of 816 Factors in SBM', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800020', 'William Othman', 'MSc Accounting', 'STHEM', 'DBA', 'Cohort 2018', '2018-01-03', 'A Study on the Impact of 644 Factors in STHEM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 16, 'Prof. Ali Gonzalez', '2020-01-18', '2020-01-21', '2020-01-21', 
                         '20%', '2020-01-24', '2020-01-29', 'Confirmed', '2020-01-29', 'Confirmed', '2020-02-06', '2020-02-10', 
                         '2020-02-10', '2020-03-01', '2020-03-03', '2020-04-07', 'Pass', '2020-04-12', 
                         0, '162', '416', '358', '60');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2020-06-23', '2020-07-08', 'JIL/2020/4', NULL, 
                             NULL, '2020-07-15', '2020-07-17', '2020-07-30', '2020-07-31', '2020-07-24', '2020-07-28', '2020-08-04');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800021', 'David Johnson', 'PhD Finance', 'IBS', 'PhD', 'Cohort 2019', '2019-10-19', 'A Study on the Impact of 340 Factors in IBS', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 7, 13, 'Prof. Jane Wilson', '2021-02-01', '2021-02-05', '2021-02-06', 
                         '23%', '2021-02-10', '2021-02-15', 'Confirmed', '2021-02-12', 'Confirmed', '2021-02-18', '2021-02-21', 
                         '2021-02-23', '2021-03-06', '2021-03-07', '2021-04-02', 'Minor Corrections', '2021-04-03', 
                         0, '131', '410', '324', '69');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-06-05', '2021-06-15', 'Verified', 'Dr. Abdullah', '2021-04-06', 'Received', 'Received',
                                 '2021-06-17', '2021-06-19', '2021-06-20',
                                 '9%', '2021-06-19', '2021-06-22', '2021-06-21', '2021-06-21', '2021-07-04', '2021-07-06', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2021-06-15', '2021-07-30', 'JIL/2021/3', NULL, 
                             NULL, '2021-07-31', '2021-08-03', '2021-08-16', '2021-08-16', '2021-08-12', '2021-08-17', '2021-08-20');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800022', 'James Rodriguez', 'MSc Accounting', 'SOE', 'PhD', 'Cohort 2023', '2023-07-30', 'A Study on the Impact of 653 Factors in SOE', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 11, 'Prof. Sophia Martinez', '2025-01-24', '2025-01-29', '2025-01-29', 
                         '10%', '2025-01-30', '2025-02-01', 'Confirmed', '2025-02-06', 'Confirmed', '2025-02-14', '2025-02-18', 
                         '2025-02-16', '2025-02-28', '2025-03-05', '2025-04-09', 'Re-viva', '2025-04-10', 
                         0, '139', '497', '384', '67');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800023', 'Siti Johnson', 'PhD Education', 'SOG', 'DBA', 'Cohort 2021', '2021-01-05', 'A Study on the Impact of 239 Factors in SOG', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800024', 'Sophia Jones', 'MSc IT', 'SOC', 'Masters', 'Cohort 2023', '2023-07-05', 'A Study on the Impact of 434 Factors in SOC', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800025', 'Jane Jones', 'MSc IT', 'SBM', 'Masters', 'Cohort 2021', '2021-08-07', 'A Study on the Impact of 812 Factors in SBM', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800026', 'Michael Hassan', 'PhD Finance', 'SOG', 'DBA', 'Cohort 2018', '2018-10-10', 'A Study on the Impact of 399 Factors in SOG', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 15, 'Prof. Aminah Abdullah', '2020-09-23', '2020-09-27', '2020-09-27', 
                         '7%', '2020-10-02', '2020-10-08', 'Confirmed', '2020-10-11', 'Confirmed', '2020-10-19', '2020-10-24', 
                         '2020-10-24', '2020-11-12', '2020-11-13', '2020-12-21', 'Fail', '2020-12-24', 
                         1, '151', '412', '302', '71');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2021-07-14', '2021-02-28', '2021-03-26', 'JIL/2021/5', '2021-05-16', 
                             'SENATE/2021/7', '2021-04-01', '2021-04-02', '2021-04-09', '2021-04-17', '2021-04-17', '2021-04-08', '2021-04-12');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800027', 'John Brown', 'MSc IT', 'SBM', 'Masters', 'Cohort 2021', '2021-10-25', 'A Study on the Impact of 388 Factors in SBM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 7, 15, 'Prof. Mia Johnson', '2023-12-25', '2023-12-27', '2023-12-27', 
                     '10%', '2024-01-01', '2024-01-11', 'Pending', '2024-01-09', 'Confirmed', '2024-01-15', '2024-01-17', 
                     '2024-01-20');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800028', 'David Williams', 'DBA', 'SOG', 'DBA', 'Cohort 2023', '2023-10-31', 'A Study on the Impact of 811 Factors in SOG', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 13, 'Prof. Joseph Johnson', '2025-02-05', '2025-02-08', '2025-02-10', 
                         '16%', '2025-02-14', '2025-02-23', 'Confirmed', '2025-02-19', 'Confirmed', '2025-02-24', '2025-03-01', 
                         '2025-03-01', '2025-03-11', '2025-03-16', '2025-04-25', 'Major Corrections', '2025-05-02', 
                         0, '140', '426', '304', '62');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-07-16', '2025-07-02', 'Verified', 'Dr. Othman', '2025-04-27', 'Received', 'Received',
                                 '2025-07-05', '2025-07-06', '2025-07-07',
                                 '13%', '2025-07-07', '2025-07-08', '2025-07-08', '2025-07-09', '2025-07-18', '2025-07-20', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-11-26', '2025-07-01', '2025-08-15', 'JIL/2025/6', '2025-10-05', 
                             'SENATE/2025/2', '2025-08-22', '2025-08-25', '2025-08-31', '2025-08-30', '2025-09-05', '2025-08-31', '2025-09-02');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800029', 'Ali Smith', 'PhD Finance', 'SBM', 'PhD', 'Cohort 2021', '2021-02-27', 'A Study on the Impact of 572 Factors in SBM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 19, 'Prof. William Smith', '2023-11-08', '2023-11-10', '2023-11-11', 
                         '24%', '2023-11-15', '2023-11-22', 'Confirmed', '2023-11-16', 'Confirmed', '2023-11-24', '2023-11-29', 
                         '2023-11-27', '2023-12-16', '2023-12-17', '2024-01-25', 'Major Corrections', '2024-01-29', 
                         0, '156', '497', '371', '70');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-04-21', '2024-03-11', 'Verified', 'Dr. Martinez', '2024-01-26', 'Received', 'Received',
                                 '2024-03-12', '2024-03-14', '2024-03-15',
                                 '15%', '2024-03-12', '2024-03-15', '2024-03-14', '2024-03-14', '2024-03-21', '2024-03-25', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-04-05', '2024-05-18', 'JIL/2024/1', NULL, 
                             NULL, '2024-05-27', '2024-05-28', '2024-06-06', '2024-06-07', '2024-06-12', '2024-06-03', '2024-06-07');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800030', 'Isabella Rodriguez', 'PhD Finance', 'STHEM', 'Masters', 'Cohort 2021', '2021-02-17', 'A Study on the Impact of 459 Factors in STHEM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 3, 11, 'Prof. Sarah Mohammad', '2023-06-13', '2023-06-17', '2023-06-19', 
                     '14%', '2023-06-24', '2023-07-01', 'Pending', '2023-07-03', 'Pending', '2023-07-10', '2023-07-14', 
                     '2023-07-12');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800031', 'Daniel Davis', 'DBA', 'SOE', 'DBA', 'Cohort 2022', '2022-03-10', 'A Study on the Impact of 736 Factors in SOE', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 15, 'Prof. Siti Rodriguez', '2024-06-30', '2024-07-05', '2024-07-07', 
                         '25%', '2024-07-08', '2024-07-18', 'Confirmed', '2024-07-17', 'Confirmed', '2024-07-28', '2024-08-02', 
                         '2024-07-31', '2024-08-13', '2024-08-17', '2024-09-09', 'Minor Corrections', '2024-09-13', 
                         1, '126', '453', '303', '60');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-10-20', '2024-11-12', 'In Progress', 'Dr. Jones', '2024-09-11', 'Received', 'Received',
                                 '2024-11-14', '2024-11-17', '2024-11-18',
                                 '12%', '2024-11-17', '2024-11-18', '2024-11-19', '2024-11-19', '2024-11-26', '2024-11-28', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800032', 'Sophia Othman', 'PhD Finance', 'SOG', 'PhD', 'Cohort 2019', '2019-01-20', 'A Study on the Impact of 664 Factors in SOG', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 8, 17, 'Prof. Nur Othman', '2021-07-27', '2021-07-30', '2021-07-30', 
                     '13%', '2021-08-03', '2021-08-10', 'Pending', '2021-08-05', 'Confirmed', '2021-08-12', '2021-08-13', 
                     '2021-08-17');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800033', 'Joseph Hernandez', 'PhD Finance', 'SOG', 'DBA', 'Cohort 2019', '2019-02-22', 'A Study on the Impact of 384 Factors in SOG', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 20, 'Prof. Joseph Ibrahim', '2021-12-26', '2021-12-30', '2021-12-31', 
                         '16%', '2022-01-05', '2022-01-13', 'Confirmed', '2022-01-09', 'Confirmed', '2022-01-18', '2022-01-21', 
                         '2022-01-22', '2022-02-07', '2022-02-10', '2022-03-22', 'Pass', '2022-03-24', 
                         0, '180', '401', '487', '51');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-05-29', '2022-06-20', 'JIL/2022/10', NULL, 
                             NULL, '2022-06-29', '2022-07-02', '2022-07-11', '2022-07-14', '2022-07-16', '2022-07-15', '2022-07-15');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800034', 'Michael Othman', 'MSc Accounting', 'SBM', 'Masters', 'Cohort 2023', '2023-04-27', 'A Study on the Impact of 484 Factors in SBM', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800035', 'Ahmad Hassan', 'DBA', 'SOL', 'PhD', 'Cohort 2022', '2022-12-07', 'A Study on the Impact of 763 Factors in SOL', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 17, 'Prof. Jane Rodriguez', '2024-07-28', '2024-08-01', '2024-08-02', 
                         '20%', '2024-08-07', '2024-08-10', 'Confirmed', '2024-08-15', 'Confirmed', '2024-08-24', '2024-08-29', 
                         '2024-08-27', '2024-09-09', '2024-09-13', '2024-10-07', 'Fail', '2024-10-13', 
                         0, '189', '462', '500', '72');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-12-26', '2025-01-20', 'JIL/2025/9', NULL, 
                             NULL, '2025-01-28', '2025-01-29', '2025-02-12', '2025-02-11', '2025-02-06', '2025-02-12', '2025-02-17');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800036', 'Fatimah Jones', 'PhD Education', 'IBS', 'PhD', 'Cohort 2023', '2023-05-13', 'A Study on the Impact of 870 Factors in IBS', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 11, 'Prof. Joseph Lopez', '2025-03-12', '2025-03-17', '2025-03-17', 
                         '12%', '2025-03-21', '2025-03-29', 'Confirmed', '2025-03-24', 'Confirmed', '2025-04-08', '2025-04-10', 
                         '2025-04-11', '2025-04-27', '2025-05-02', '2025-05-24', 'Minor Corrections', '2025-05-28', 
                         0, '138', '443', '428', '75');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-07-15', '2025-06-26', 'In Progress', 'Dr. Miller', '2025-05-26', 'Received', 'Received',
                                 '2025-06-29', '2025-07-02', '2025-07-03',
                                 '1%', '2025-06-30', '2025-07-02', '2025-07-01', '2025-07-03', '2025-07-09', '2025-07-11', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800037', 'Nur Salleh', 'MSc IT', 'SOL', 'PhD', 'Cohort 2019', '2019-05-18', 'A Study on the Impact of 452 Factors in SOL', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 11, 'Prof. James Garcia', '2021-01-29', '2021-02-02', '2021-02-04', 
                         '20%', '2021-02-09', '2021-02-11', 'Confirmed', '2021-02-19', 'Confirmed', '2021-02-20', '2021-02-25', 
                         '2021-02-25', '2021-03-09', '2021-03-10', '2021-03-30', 'Minor Corrections', '2021-04-03', 
                         0, '152', '451', '322', '63');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-05-18', '2021-06-06', 'In Progress', 'Dr. Mohammad', '2021-04-01', 'Received', 'Received',
                                 '2021-06-07', '2021-06-08', '2021-06-10',
                                 '4%', '2021-06-09', '2021-06-11', '2021-06-12', '2021-06-10', '2021-06-25', '2021-06-26', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800038', 'Jane Garcia', 'MSc Management', 'IBS', 'Masters', 'Cohort 2022', '2022-11-12', 'A Study on the Impact of 428 Factors in IBS', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 17, 'Prof. Ali Smith', '2024-05-04', '2024-05-06', '2024-05-08', 
                         '6%', '2024-05-12', '2024-05-15', 'Confirmed', '2024-05-17', 'Confirmed', '2024-05-27', '2024-05-31', 
                         '2024-05-30', '2024-06-16', '2024-06-21', '2024-07-29', 'Major Corrections', '2024-08-05', 
                         1, '148', '309', '422', '54');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-10-22', '2024-08-21', 'Verified', 'Dr. Rodriguez', '2024-08-03', 'Received', 'Received',
                                 '2024-08-24', '2024-08-25', '2024-08-27',
                                 '9%', '2024-08-22', '2024-08-24', '2024-08-25', '2024-08-23', '2024-09-04', '2024-09-07', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-02-20', '2024-10-12', '2024-11-14', 'JIL/2024/6', '2025-01-01', 
                             'SENATE/2025/9', '2024-11-24', '2024-11-27', '2024-12-09', '2024-12-12', '2024-12-07', '2024-12-07', '2024-12-13');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800039', 'Joseph Lopez', 'PhD Finance', 'SOC', 'PhD', 'Cohort 2020', '2020-03-03', 'A Study on the Impact of 764 Factors in SOC', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800040', 'James Hassan', 'PhD Education', 'IBS', 'DBA', 'Cohort 2018', '2018-12-26', 'A Study on the Impact of 887 Factors in IBS', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 15, 'Prof. Emma Gonzalez', '2020-08-29', '2020-09-01', '2020-09-02', 
                         '19%', '2020-09-07', '2020-09-17', 'Confirmed', '2020-09-17', 'Confirmed', '2020-09-22', '2020-09-27', 
                         '2020-09-24', '2020-10-04', '2020-10-06', '2020-11-04', 'Major Corrections', '2020-11-06', 
                         0, '127', '409', '499', '60');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-12-06', '2020-12-02', 'In Progress', 'Dr. Martinez', '2020-11-08', 'Received', 'Received',
                                 '2020-12-05', '2020-12-08', '2020-12-10',
                                 '11%', '2020-12-04', '2020-12-05', '2020-12-07', '2020-12-06', '2020-12-13', '2020-12-16', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800041', 'Fatimah Gonzalez', 'MSc Management', 'IBS', 'DBA', 'Cohort 2020', '2020-10-12', 'A Study on the Impact of 381 Factors in IBS', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 9, 13, 'Prof. Mia Abdullah', '2022-10-17', '2022-10-20', '2022-10-21', 
                         '24%', '2022-10-26', '2022-11-04', 'Confirmed', '2022-10-29', 'Confirmed', '2022-11-07', '2022-11-08', 
                         '2022-11-09', '2022-11-27', '2022-12-02', '2022-12-22', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800042', 'Ahmad Garcia', 'MSc Management', 'SBM', 'PhD', 'Cohort 2018', '2018-08-14', 'A Study on the Impact of 624 Factors in SBM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 11, 'Prof. William Anderson', '2020-08-07', '2020-08-12', '2020-08-13', 
                         '11%', '2020-08-15', '2020-08-18', 'Confirmed', '2020-08-17', 'Confirmed', '2020-08-22', '2020-08-24', 
                         '2020-08-25', '2020-09-05', '2020-09-09', '2020-09-29', 'Major Corrections', '2020-10-01', 
                         1, '172', '368', '357', '88');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-11-05', '2020-11-02', 'In Progress', 'Dr. Thomas', '2020-10-03', 'Received', 'Received',
                                 '2020-11-04', '2020-11-07', '2020-11-09',
                                 '10%', '2020-11-06', '2020-11-09', '2020-11-07', '2020-11-08', '2020-11-18', '2020-11-21', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800043', 'John Smith', 'DBA', 'SOG', 'PhD', 'Cohort 2023', '2023-12-21', 'A Study on the Impact of 601 Factors in SOG', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 17, 'Prof. Emma Ibrahim', '2025-07-31', '2025-08-02', '2025-08-04', 
                         '10%', '2025-08-09', '2025-08-17', 'Confirmed', '2025-08-10', 'Confirmed', '2025-08-19', '2025-08-24', 
                         '2025-08-23', '2025-09-04', '2025-09-09', '2025-10-08', 'Fail', '2025-10-11', 
                         1, '133', '363', '364', '83');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800044', 'Emma Johnson', 'MSc IT', 'IBS', 'DBA', 'Cohort 2018', '2018-12-11', 'A Study on the Impact of 257 Factors in IBS', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 13, 'Prof. Isabella Williams', '2020-06-11', '2020-06-16', '2020-06-18', 
                         '18%', '2020-06-23', '2020-07-01', 'Confirmed', '2020-06-30', 'Confirmed', '2020-07-03', '2020-07-07', 
                         '2020-07-07', '2020-07-20', '2020-07-21', '2020-08-28', 'Minor Corrections', '2020-09-04', 
                         0, '185', '338', '335', '57');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-10-31', '2020-10-22', 'Verified', 'Dr. Rodriguez', '2020-08-31', 'Received', 'Received',
                                 '2020-10-24', '2020-10-27', '2020-10-29',
                                 '12%', '2020-10-27', '2020-10-29', '2020-10-30', '2020-10-30', '2020-11-06', '2020-11-09', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2020-11-09', '2020-12-04', 'JIL/2020/4', NULL, 
                             NULL, '2020-12-09', '2020-12-12', '2020-12-17', '2020-12-21', '2020-12-20', '2020-12-25', '2020-12-21');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800045', 'Ahmad Thomas', 'DBA', 'SOL', 'Masters', 'Cohort 2021', '2021-04-14', 'A Study on the Impact of 449 Factors in SOL', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800046', 'James Jones', 'PhD Finance', 'SOE', 'DBA', 'Cohort 2023', '2023-07-17', 'A Study on the Impact of 233 Factors in SOE', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 12, 'Prof. James Gonzalez', '2025-10-24', '2025-10-26', '2025-10-27', 
                         '25%', '2025-10-31', '2025-11-04', 'Confirmed', '2025-11-05', 'Confirmed', '2025-11-06', '2025-11-11', 
                         '2025-11-07', '2025-11-21', '2025-11-26', '2025-12-23', 'Major Corrections', '2025-12-25', 
                         1, '127', '335', '374', '89');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2026-02-02', '2026-01-28', 'In Progress', 'Dr. Rodriguez', '2025-12-25', 'Received', 'Received',
                                 '2026-01-30', '2026-02-01', '2026-02-03',
                                 '10%', '2026-01-29', '2026-01-30', '2026-01-31', '2026-01-31', '2026-02-11', '2026-02-14', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800047', 'Mia Rodriguez', 'MSc Accounting', 'IBS', 'DBA', 'Cohort 2019', '2019-06-15', 'A Study on the Impact of 299 Factors in IBS', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 19, 'Prof. Olivia Ibrahim', '2021-01-26', '2021-01-28', '2021-01-28', 
                         '23%', '2021-02-02', '2021-02-06', 'Confirmed', '2021-02-06', 'Confirmed', '2021-02-14', '2021-02-19', 
                         '2021-02-17', '2021-03-08', '2021-03-11', '2021-04-17', 'Pass', '2021-04-22', 
                         0, '182', '452', '413', '70');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2021-06-26', '2021-07-31', 'JIL/2021/6', NULL, 
                             NULL, '2021-08-08', '2021-08-10', '2021-08-18', '2021-08-18', '2021-08-17', '2021-08-25', '2021-08-19');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800048', 'David Hassan', 'MSc Management', 'SOL', 'Masters', 'Cohort 2018', '2018-01-02', 'A Study on the Impact of 182 Factors in SOL', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 13, 'Prof. Mia Garcia', '2020-10-18', '2020-10-23', '2020-10-24', 
                         '19%', '2020-10-27', '2020-11-06', 'Confirmed', '2020-11-05', 'Confirmed', '2020-11-15', '2020-11-18', 
                         '2020-11-19', '2020-11-29', '2020-12-04', '2021-01-13', 'Minor Corrections', '2021-01-14', 
                         1, '100', '449', '341', '99');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-02-14', '2021-02-27', 'In Progress', 'Dr. Abdullah', '2021-01-15', 'Received', 'Received',
                                 '2021-03-02', '2021-03-04', '2021-03-06',
                                 '13%', '2021-03-03', '2021-03-04', '2021-03-04', '2021-03-06', '2021-03-15', '2021-03-17', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800049', 'Fatimah Abdullah', 'PhD Education', 'SOC', 'PhD', 'Cohort 2018', '2018-08-16', 'A Study on the Impact of 547 Factors in SOC', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 18, 'Prof. Mia Salleh', '2020-02-19', '2020-02-20', '2020-02-21', 
                         '12%', '2020-02-25', '2020-03-04', 'Confirmed', '2020-03-04', 'Confirmed', '2020-03-11', '2020-03-15', 
                         '2020-03-14', '2020-03-24', '2020-03-27', '2020-04-30', 'Re-viva', '2020-05-02', 
                         1, '188', '441', '476', '53');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-07-20', '2020-06-22', 'Verified', 'Dr. Garcia', '2020-05-01', 'Received', 'Received',
                                 '2020-06-24', '2020-06-25', '2020-06-26',
                                 '8%', '2020-06-24', '2020-06-27', '2020-06-27', '2020-06-26', '2020-07-06', '2020-07-07', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2020-07-01', '2020-08-07', 'JIL/2020/9', NULL, 
                             NULL, '2020-08-14', '2020-08-15', '2020-08-29', '2020-08-25', '2020-08-25', '2020-08-29', '2020-09-02');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800050', 'David Wilson', 'DBA', 'IBS', 'PhD', 'Cohort 2019', '2019-06-24', 'A Study on the Impact of 316 Factors in IBS', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800051', 'William Wilson', 'PhD Education', 'STHEM', 'DBA', 'Cohort 2022', '2022-12-17', 'A Study on the Impact of 971 Factors in STHEM', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 16, 'Prof. Ahmad Jones', '2024-03-01', '2024-03-04', '2024-03-06', 
                         '10%', '2024-03-08', '2024-03-16', 'Confirmed', '2024-03-17', 'Confirmed', '2024-03-22', '2024-03-26', 
                         '2024-03-26', '2024-04-07', '2024-04-11', '2024-05-13', 'Re-viva', '2024-05-20', 
                         0, '116', '461', '375', '98');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800052', 'Emma Hassan', 'MSc Accounting', 'SOE', 'Masters', 'Cohort 2022', '2022-05-01', 'A Study on the Impact of 661 Factors in SOE', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 19, 'Prof. David Othman', '2024-06-24', '2024-06-26', '2024-06-26', 
                         '9%', '2024-06-28', '2024-06-29', 'Confirmed', '2024-07-03', 'Confirmed', '2024-07-13', '2024-07-16', 
                         '2024-07-14', '2024-07-31', '2024-08-03', '2024-08-31', 'Major Corrections', '2024-09-05', 
                         1, '115', '323', '331', '61');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-11-06', '2024-11-18', 'Verified', 'Dr. Ibrahim', '2024-09-02', 'Received', 'Received',
                                 '2024-11-20', '2024-11-21', '2024-11-22',
                                 '4%', '2024-11-19', '2024-11-21', '2024-11-20', '2024-11-22', '2024-11-28', '2024-11-30', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-03-20', '2024-11-10', '2024-12-02', 'JIL/2024/10', '2025-01-20', 
                             'SENATE/2025/1', '2024-12-10', '2024-12-11', '2024-12-16', '2024-12-24', '2024-12-19', '2024-12-19', '2024-12-21');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800053', 'Emma Davis', 'PhD Education', 'SOC', 'PhD', 'Cohort 2019', '2019-03-15', 'A Study on the Impact of 485 Factors in SOC', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 17, 'Prof. Mia Anderson', '2022-01-01', '2022-01-03', '2022-01-03', 
                         '19%', '2022-01-05', '2022-01-14', 'Confirmed', '2022-01-06', 'Confirmed', '2022-01-16', '2022-01-17', 
                         '2022-01-19', '2022-02-07', '2022-02-11', '2022-03-05', 'Fail', '2022-03-10', 
                         0, '135', '434', '495', '65');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-05-16', '2022-06-21', 'JIL/2022/7', NULL, 
                             NULL, '2022-06-26', '2022-06-29', '2022-07-14', '2022-07-14', '2022-07-04', '2022-07-13', '2022-07-16');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800054', 'Sophia Othman', 'MSc Management', 'IBS', 'DBA', 'Cohort 2020', '2020-05-18', 'A Study on the Impact of 816 Factors in IBS', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 7, 12, 'Prof. Nur Miller', '2022-12-21', '2022-12-24', '2022-12-25', 
                     '13%', '2022-12-28', '2023-01-02', 'Pending', '2023-01-05', 'Confirmed', '2023-01-11', '2023-01-13', 
                     '2023-01-14');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800055', 'Nur Rodriguez', 'PhD Finance', 'SOL', 'Masters', 'Cohort 2020', '2020-03-19', 'A Study on the Impact of 118 Factors in SOL', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 17, 'Prof. Siti Rodriguez', '2022-01-20', '2022-01-25', '2022-01-27', 
                         '20%', '2022-01-29', '2022-02-05', 'Confirmed', '2022-01-31', 'Confirmed', '2022-02-13', '2022-02-16', 
                         '2022-02-14', '2022-02-26', '2022-02-27', '2022-03-21', 'Major Corrections', '2022-03-25', 
                         0, '170', '451', '433', '64');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-06-02', '2022-05-14', 'In Progress', 'Dr. Anderson', '2022-03-23', 'Received', 'Received',
                                 '2022-05-15', '2022-05-18', '2022-05-20',
                                 '7%', '2022-05-15', '2022-05-17', '2022-05-18', '2022-05-17', '2022-05-30', '2022-06-02', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800056', 'David Wilson', 'DBA', 'SOG', 'Masters', 'Cohort 2019', '2019-11-11', 'A Study on the Impact of 169 Factors in SOG', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 9, 12, 'Prof. Mia Ibrahim', '2021-03-22', '2021-03-26', '2021-03-28', 
                         '8%', '2021-03-31', '2021-04-02', 'Confirmed', '2021-04-09', 'Confirmed', '2021-04-17', '2021-04-20', 
                         '2021-04-22', '2021-05-08', '2021-05-09', '2021-05-31', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800057', 'Ahmad Gonzalez', 'PhD Education', 'SOG', 'PhD', 'Cohort 2020', '2020-03-13', 'A Study on the Impact of 106 Factors in SOG', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 4, 11, 'Prof. Daniel Salleh', '2022-08-30', '2022-08-31', '2022-09-02', 
                         '16%', '2022-09-03', '2022-09-04', 'Confirmed', '2022-09-13', 'Confirmed', '2022-09-21', '2022-09-22', 
                         '2022-09-22', '2022-10-11', '2022-10-15', '2022-11-20', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800058', 'William Mohammad', 'PhD Finance', 'STHEM', 'DBA', 'Cohort 2018', '2018-09-17', 'A Study on the Impact of 513 Factors in STHEM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 3, 13, 'Prof. James Mohammad', '2020-08-09', '2020-08-11', '2020-08-12', 
                     '19%', '2020-08-16', '2020-08-25', 'Confirmed', '2020-08-21', 'Pending', '2020-08-31', '2020-09-05', 
                     '2020-09-05');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800059', 'Jane Hassan', 'MSc IT', 'STHEM', 'PhD', 'Cohort 2023', '2023-05-30', 'A Study on the Impact of 528 Factors in STHEM', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 17, 'Prof. Muhammad Smith', '2025-11-28', '2025-12-03', '2025-12-03', 
                         '17%', '2025-12-08', '2025-12-12', 'Confirmed', '2025-12-11', 'Confirmed', '2025-12-18', '2025-12-21', 
                         '2025-12-19', '2026-01-03', '2026-01-07', '2026-02-09', 'Re-viva', '2026-02-12', 
                         1, '164', '400', '472', '96');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800060', 'Aminah Mohammad', 'MSc Management', 'SBM', 'DBA', 'Cohort 2018', '2018-03-18', 'A Study on the Impact of 834 Factors in SBM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 13, 'Prof. John Garcia', '2020-12-27', '2021-01-01', '2021-01-01', 
                         '6%', '2021-01-02', '2021-01-10', 'Confirmed', '2021-01-10', 'Confirmed', '2021-01-12', '2021-01-16', 
                         '2021-01-14', '2021-01-25', '2021-01-27', '2021-02-26', 'Minor Corrections', '2021-02-28', 
                         0, '111', '332', '349', '63');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-04-27', '2021-05-02', 'In Progress', 'Dr. Hassan', '2021-03-01', 'Received', 'Received',
                                 '2021-05-04', '2021-05-07', '2021-05-08',
                                 '10%', '2021-05-04', '2021-05-05', '2021-05-05', '2021-05-05', '2021-05-14', '2021-05-18', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800061', 'Nur Thomas', 'DBA', 'SBM', 'Masters', 'Cohort 2022', '2022-04-05', 'A Study on the Impact of 849 Factors in SBM', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 19, 'Prof. Fatimah Salleh', '2024-04-20', '2024-04-21', '2024-04-23', 
                         '22%', '2024-04-25', '2024-04-27', 'Confirmed', '2024-05-05', 'Confirmed', '2024-05-10', '2024-05-12', 
                         '2024-05-11', '2024-05-27', '2024-06-01', '2024-06-25', 'Re-viva', '2024-06-26', 
                         0, '142', '348', '395', '89');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800062', 'Olivia Wilson', 'MSc IT', 'STHEM', 'DBA', 'Cohort 2020', '2020-09-16', 'A Study on the Impact of 329 Factors in STHEM', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 15, 'Prof. Sophia Ibrahim', '2022-04-07', '2022-04-10', '2022-04-11', 
                         '7%', '2022-04-15', '2022-04-19', 'Confirmed', '2022-04-18', 'Confirmed', '2022-04-20', '2022-04-22', 
                         '2022-04-22', '2022-05-03', '2022-05-05', '2022-06-10', 'Minor Corrections', '2022-06-16', 
                         0, '139', '404', '435', '55');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-08-10', '2022-07-09', 'Verified', 'Dr. Thomas', '2022-06-13', 'Received', 'Received',
                                 '2022-07-11', '2022-07-12', '2022-07-13',
                                 '3%', '2022-07-14', '2022-07-17', '2022-07-16', '2022-07-16', '2022-07-26', '2022-07-27', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2022-11-21', '2022-08-18', '2022-09-18', 'JIL/2022/1', '2022-10-20', 
                             'SENATE/2022/5', '2022-09-24', '2022-09-25', '2022-09-30', '2022-10-06', '2022-09-30', '2022-09-30', '2022-10-05');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800063', 'Mia Brown', 'MSc Management', 'SOC', 'DBA', 'Cohort 2021', '2021-01-04', 'A Study on the Impact of 833 Factors in SOC', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 13, 'Prof. Sophia Othman', '2023-07-24', '2023-07-28', '2023-07-30', 
                         '17%', '2023-08-02', '2023-08-06', 'Confirmed', '2023-08-03', 'Confirmed', '2023-08-11', '2023-08-12', 
                         '2023-08-15', '2023-09-04', '2023-09-06', '2023-10-03', 'Minor Corrections', '2023-10-04', 
                         1, '134', '358', '443', '95');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-12-07', '2023-11-25', 'In Progress', 'Dr. Mohammad', '2023-10-07', 'Received', 'Received',
                                 '2023-11-28', '2023-11-30', '2023-12-02',
                                 '8%', '2023-11-29', '2023-12-01', '2023-11-30', '2023-12-01', '2023-12-08', '2023-12-09', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800064', 'Daniel Johnson', 'DBA', 'STHEM', 'DBA', 'Cohort 2023', '2023-06-12', 'A Study on the Impact of 404 Factors in STHEM', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 16, 'Prof. David Thomas', '2025-08-07', '2025-08-08', '2025-08-09', 
                         '25%', '2025-08-14', '2025-08-22', 'Confirmed', '2025-08-17', 'Confirmed', '2025-08-25', '2025-08-27', 
                         '2025-08-29', '2025-09-13', '2025-09-15', '2025-10-08', 'Pass', '2025-10-15', 
                         0, '107', '471', '334', '99');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2026-04-21', '2025-12-10', '2026-01-23', 'JIL/2026/1', '2026-03-06', 
                             'SENATE/2026/8', '2026-01-31', '2026-02-01', '2026-02-15', '2026-02-10', '2026-02-08', '2026-02-09', '2026-02-19');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800065', 'Daniel Thomas', 'PhD Education', 'IBS', 'Masters', 'Cohort 2023', '2023-07-30', 'A Study on the Impact of 342 Factors in IBS', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800066', 'Kamal Smith', 'PhD Education', 'STHEM', 'PhD', 'Cohort 2018', '2018-05-08', 'A Study on the Impact of 266 Factors in STHEM', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 5, 12, 'Prof. David Davis', '2020-11-14', '2020-11-19', '2020-11-19', 
                         '11%', '2020-11-22', '2020-11-28', 'Confirmed', '2020-11-24', 'Confirmed', '2020-12-06', '2020-12-07', 
                         '2020-12-10', '2020-12-25', '2020-12-28', '2021-01-29', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800067', 'Emma Lopez', 'MSc IT', 'SOE', 'DBA', 'Cohort 2022', '2022-01-06', 'A Study on the Impact of 354 Factors in SOE', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 19, 'Prof. Emma Gonzalez', '2024-10-11', '2024-10-13', '2024-10-13', 
                         '6%', '2024-10-16', '2024-10-19', 'Confirmed', '2024-10-26', 'Confirmed', '2024-10-27', '2024-10-31', 
                         '2024-10-30', '2024-11-17', '2024-11-21', '2024-12-29', 'Minor Corrections', '2024-12-30', 
                         0, '116', '303', '410', '79');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-02-03', '2025-01-27', 'In Progress', 'Dr. Smith', '2025-01-02', 'Received', 'Received',
                                 '2025-01-30', '2025-02-02', '2025-02-04',
                                 '12%', '2025-01-31', '2025-02-01', '2025-02-02', '2025-02-02', '2025-02-10', '2025-02-12', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800068', 'Michael Lopez', 'MSc IT', 'SOC', 'Masters', 'Cohort 2022', '2022-03-13', 'A Study on the Impact of 832 Factors in SOC', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 20, 'Prof. Ali Williams', '2024-01-16', '2024-01-17', '2024-01-18', 
                         '20%', '2024-01-22', '2024-01-25', 'Confirmed', '2024-01-31', 'Confirmed', '2024-02-06', '2024-02-09', 
                         '2024-02-07', '2024-02-24', '2024-02-27', '2024-03-19', 'Pass', '2024-03-25', 
                         1, '158', '410', '303', '60');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-05-19', '2024-07-07', 'JIL/2024/8', NULL, 
                             NULL, '2024-07-10', '2024-07-12', '2024-07-22', '2024-07-25', '2024-07-26', '2024-07-21', '2024-07-27');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800069', 'James Garcia', 'PhD Finance', 'IBS', 'Masters', 'Cohort 2018', '2018-11-30', 'A Study on the Impact of 400 Factors in IBS', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 11, 'Prof. Daniel Miller', '2020-11-09', '2020-11-14', '2020-11-15', 
                         '7%', '2020-11-17', '2020-11-21', 'Confirmed', '2020-11-18', 'Confirmed', '2020-11-24', '2020-11-29', 
                         '2020-11-29', '2020-12-16', '2020-12-19', '2021-01-24', 'Fail', '2021-01-30', 
                         1, '131', '314', '489', '52');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800070', 'Siti Jones', 'MSc IT', 'SOG', 'DBA', 'Cohort 2020', '2020-09-23', 'A Study on the Impact of 822 Factors in SOG', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 3, 14, 'Prof. Muhammad Mohammad', '2022-11-27', '2022-12-01', '2022-12-03', 
                     '24%', '2022-12-07', '2022-12-09', 'Confirmed', '2022-12-13', 'Pending', '2022-12-22', '2022-12-24', 
                     '2022-12-24');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800071', 'Michael Smith', 'PhD Education', 'SBM', 'PhD', 'Cohort 2023', '2023-08-03', 'A Study on the Impact of 597 Factors in SBM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 9, 15, 'Prof. Nur Lopez', '2025-02-02', '2025-02-04', '2025-02-05', 
                     '20%', '2025-02-10', '2025-02-16', 'Pending', '2025-02-13', 'Pending', '2025-02-20', '2025-02-24', 
                     '2025-02-25');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800072', 'Kamal Davis', 'PhD Finance', 'SBM', 'Masters', 'Cohort 2022', '2022-11-23', 'A Study on the Impact of 396 Factors in SBM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 18, 'Prof. Olivia Garcia', '2024-06-23', '2024-06-26', '2024-06-27', 
                         '8%', '2024-07-01', '2024-07-07', 'Confirmed', '2024-07-07', 'Confirmed', '2024-07-14', '2024-07-17', 
                         '2024-07-19', '2024-08-06', '2024-08-09', '2024-08-31', 'Minor Corrections', '2024-09-06', 
                         0, '188', '365', '435', '82');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-10-05', '2024-10-11', 'In Progress', 'Dr. Smith', '2024-09-05', 'Received', 'Received',
                                 '2024-10-12', '2024-10-15', '2024-10-16',
                                 '11%', '2024-10-16', '2024-10-17', '2024-10-17', '2024-10-19', '2024-10-23', '2024-10-26', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800073', 'Siti Smith', 'MSc Management', 'SOL', 'Masters', 'Cohort 2019', '2019-08-04', 'A Study on the Impact of 548 Factors in SOL', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 2, 17, 'Prof. David Ibrahim', '2021-09-03', '2021-09-05', '2021-09-06', 
                         '15%', '2021-09-11', '2021-09-12', 'Confirmed', '2021-09-15', 'Confirmed', '2021-09-19', '2021-09-24', 
                         '2021-09-22', '2021-10-11', '2021-10-13', '2021-11-03', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800074', 'Jane Othman', 'MSc Management', 'SOG', 'Masters', 'Cohort 2020', '2020-10-17', 'A Study on the Impact of 392 Factors in SOG', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 14, 'Prof. Nur Salleh', '2022-01-29', '2022-02-03', '2022-02-04', 
                         '13%', '2022-02-06', '2022-02-07', 'Confirmed', '2022-02-10', 'Confirmed', '2022-02-20', '2022-02-24', 
                         '2022-02-21', '2022-03-06', '2022-03-07', '2022-04-06', 'Re-viva', '2022-04-13', 
                         1, '119', '348', '331', '92');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800075', 'Fatimah Abdullah', 'MSc Management', 'SBM', 'DBA', 'Cohort 2023', '2023-07-15', 'A Study on the Impact of 740 Factors in SBM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`,
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 2, 18, 'Prof. Siti Williams', '2025-11-26', '2025-12-01', '2025-12-02', 
                     '9%', '2025-12-06', '2025-12-16', 'Pending', '2025-12-11', 'Pending', '2025-12-23', '2025-12-27', 
                     '2025-12-25');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800076', 'John Hassan', 'PhD Finance', 'SOC', 'Masters', 'Cohort 2020', '2020-12-13', 'A Study on the Impact of 981 Factors in SOC', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 12, 'Prof. Joseph Ibrahim', '2022-06-11', '2022-06-16', '2022-06-16', 
                         '15%', '2022-06-20', '2022-06-27', 'Confirmed', '2022-06-26', 'Confirmed', '2022-07-07', '2022-07-09', 
                         '2022-07-09', '2022-07-19', '2022-07-23', '2022-08-16', 'Minor Corrections', '2022-08-19', 
                         0, '165', '350', '312', '91');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-09-29', '2022-09-18', 'In Progress', 'Dr. Hassan', '2022-08-20', 'Received', 'Received',
                                 '2022-09-20', '2022-09-23', '2022-09-24',
                                 '9%', '2022-09-20', '2022-09-23', '2022-09-21', '2022-09-21', '2022-10-05', '2022-10-06', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800077', 'Joseph Brown', 'DBA', 'SOE', 'Masters', 'Cohort 2020', '2020-06-09', 'A Study on the Impact of 320 Factors in SOE', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 7, 14, 'Prof. Nur Hernandez', '2022-02-19', '2022-02-21', '2022-02-21', 
                         '6%', '2022-02-25', '2022-03-07', 'Confirmed', '2022-02-28', 'Confirmed', '2022-03-09', '2022-03-10', 
                         '2022-03-10', '2022-03-30', '2022-04-03', '2022-05-08', 'Major Corrections', '2022-05-09', 
                         1, '191', '413', '327', '97');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-06-21', '2022-06-19', 'Verified', 'Dr. Mohammad', '2022-05-09', 'Received', 'Received',
                                 '2022-06-20', '2022-06-21', '2022-06-22',
                                 '6%', '2022-06-24', '2022-06-25', '2022-06-27', '2022-06-25', '2022-07-10', '2022-07-13', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-07-17', '2022-08-11', 'JIL/2022/6', NULL, 
                             NULL, '2022-08-15', '2022-08-17', '2022-08-29', '2022-08-30', '2022-08-29', '2022-08-27', '2022-09-03');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800078', 'Siti Othman', 'MSc IT', 'SOC', 'Masters', 'Cohort 2020', '2020-11-15', 'A Study on the Impact of 591 Factors in SOC', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 4, 12, 'Prof. Isabella Rodriguez', '2022-06-16', '2022-06-18', '2022-06-19', 
                         '22%', '2022-06-21', '2022-06-29', 'Confirmed', '2022-06-23', 'Confirmed', '2022-07-04', '2022-07-07', 
                         '2022-07-05', '2022-07-25', '2022-07-28', '2022-08-18', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800079', 'Kamal Williams', 'PhD Education', 'SOG', 'DBA', 'Cohort 2022', '2022-07-15', 'A Study on the Impact of 576 Factors in SOG', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 15, 'Prof. Ali Johnson', '2024-09-15', '2024-09-18', '2024-09-20', 
                         '7%', '2024-09-23', '2024-09-28', 'Confirmed', '2024-09-29', 'Confirmed', '2024-10-01', '2024-10-03', 
                         '2024-10-06', '2024-10-23', '2024-10-26', '2024-11-27', 'Major Corrections', '2024-12-03', 
                         0, '143', '416', '446', '70');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-01-25', '2024-12-30', 'Verified', 'Dr. Miller', '2024-11-29', 'Received', 'Received',
                                 '2025-01-01', '2025-01-04', '2025-01-06',
                                 '8%', '2025-01-04', '2025-01-07', '2025-01-06', '2025-01-05', '2025-01-13', '2025-01-17', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-07-01', '2025-02-01', '2025-03-13', 'JIL/2025/2', '2025-05-11', 
                             'SENATE/2025/10', '2025-03-22', '2025-03-25', '2025-03-30', '2025-04-08', '2025-04-04', '2025-04-02', '2025-04-01');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800080', 'William Rodriguez', 'MSc Management', 'SOG', 'PhD', 'Cohort 2023', '2023-02-09', 'A Study on the Impact of 377 Factors in SOG', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `internal_examiner_status`, `external_examiner_email_date`, `external_examiner_status`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 19, 'Prof. Daniel Davis', '2025-02-22', '2025-02-24', '2025-02-26', 
                         '11%', '2025-02-28', '2025-03-04', 'Confirmed', '2025-03-02', 'Confirmed', '2025-03-06', '2025-03-07', 
                         '2025-03-09', '2025-03-21', '2025-03-25', '2025-04-26', 'Pass', '2025-05-02', 
                         0, '146', '450', '500', '93');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-11-09', '2025-07-07', '2025-08-05', 'JIL/2025/4', '2025-09-29', 
                             'SENATE/2025/1', '2025-08-08', '2025-08-10', '2025-08-18', '2025-08-21', '2025-08-19', '2025-08-16', '2025-08-20');
