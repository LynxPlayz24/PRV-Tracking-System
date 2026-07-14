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

INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. William Wilson', 'dr..william.wilson@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Olivia Hernandez', 'dr..olivia.hernandez@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. William Brown', 'dr..william.brown@uum.edu.my', 'Dept of IT');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Emma Anderson', 'dr..emma.anderson@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Fatimah Othman', 'dr..fatimah.othman@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Sophia Wilson', 'dr..sophia.wilson@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Mia Thomas', 'dr..mia.thomas@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Olivia Williams', 'dr..olivia.williams@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. William Wilson', 'dr..william.wilson@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. James Anderson', 'dr..james.anderson@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Jane Abdullah', 'dr..jane.abdullah@uum.edu.my', 'Dept of Education');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Michael Salleh', 'dr..michael.salleh@uum.edu.my', 'Dept of Law');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Aminah Wilson', 'dr..aminah.wilson@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Sophia Brown', 'dr..sophia.brown@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Emma Gonzalez', 'dr..emma.gonzalez@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. John Mohammad', 'dr..john.mohammad@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Mia Othman', 'dr..mia.othman@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. William Abdullah', 'dr..william.abdullah@uum.edu.my', 'Dept of Finance');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. David Davis', 'dr..david.davis@uum.edu.my', 'Dept of Management');
INSERT INTO `supervisors` (`supervisor_name`, `email`, `department`) VALUES ('Dr. Nur Rodriguez', 'dr..nur.rodriguez@uum.edu.my', 'Dept of IT');

INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. David Ibrahim', 'UUM', 'prof..david.ibrahim@uum.edu.my', '018-7577460');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Kamal Gonzalez', 'UM', 'prof..kamal.gonzalez@um.edu.my', '012-8901028');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Aminah Johnson', 'UPM', 'prof..aminah.johnson@upm.edu.my', '016-6655241');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Kamal Smith', 'UKM', 'prof..kamal.smith@ukm.edu.my', '016-3104730');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. John Thomas', 'UUM', 'prof..john.thomas@uum.edu.my', '016-1984375');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Muhammad Garcia', 'UKM', 'prof..muhammad.garcia@ukm.edu.my', '011-8204774');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Olivia Garcia', 'UKM', 'prof..olivia.garcia@ukm.edu.my', '012-6597833');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. David Johnson', 'UPM', 'prof..david.johnson@upm.edu.my', '019-5326495');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Sophia Thomas', 'UPM', 'prof..sophia.thomas@upm.edu.my', '019-3418436');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Isabella Gonzalez', 'USM', 'prof..isabella.gonzalez@usm.edu.my', '012-5420014');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Emma Salleh', 'USM', 'prof..emma.salleh@usm.edu.my', '012-5259024');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Jane Martinez', 'UKM', 'prof..jane.martinez@ukm.edu.my', '018-2663742');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Aminah Mohammad', 'UUM', 'prof..aminah.mohammad@uum.edu.my', '012-5348478');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Jane Johnson', 'UM', 'prof..jane.johnson@um.edu.my', '012-3033223');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Kamal Hernandez', 'UPM', 'prof..kamal.hernandez@upm.edu.my', '018-1016023');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Nur Anderson', 'UiTM', 'prof..nur.anderson@uitm.edu.my', '012-7173864');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Olivia Ibrahim', 'UUM', 'prof..olivia.ibrahim@uum.edu.my', '013-2120648');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Jane Ibrahim', 'USM', 'prof..jane.ibrahim@usm.edu.my', '010-5812768');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Ali Salleh', 'UM', 'prof..ali.salleh@um.edu.my', '011-9718192');
INSERT INTO `examiners` (`examiner_name`, `institution`, `email`, `phone`) VALUES ('Prof. Aminah Anderson', 'USM', 'prof..aminah.anderson@usm.edu.my', '019-2647611');

INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800001', 'Ahmad Wilson', 'MSc IT', 'IBS', 'DBA', 'Cohort 2023', '2023-11-24', 'A Study on the Impact of 124 Factors in IBS', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 13, 'Prof. Jane Wilson', '2025-01-12', '2025-01-17', '2025-01-17', 
                         '5%', '2025-01-20', '2025-01-25', '2025-01-29', '2025-02-04', '2025-02-05', 
                         '2025-02-09', '2025-02-25', '2025-03-01', '2025-04-05', 'Minor Corrections', '2025-04-09', 
                         1, '130', '500', '459', '85');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-06-30', '2025-06-19', 'In Progress', 'Dr. Hernandez', '2025-04-09', 'Received', 'Received',
                                 '2025-06-22', '2025-06-24', '2025-06-25',
                                 '13%', '2025-06-21', '2025-06-23', '2025-06-23', '2025-06-22', '2025-07-03', '2025-07-07', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800002', 'John Wilson', 'PhD Education', 'SBM', 'DBA', 'Cohort 2018', '2018-04-08', 'A Study on the Impact of 102 Factors in SBM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 19, 'Prof. William Abdullah', '2020-09-05', '2020-09-06', '2020-09-08', 
                         '22%', '2020-09-09', '2020-09-18', '2020-09-14', '2020-09-21', '2020-09-22', 
                         '2020-09-22', '2020-10-11', '2020-10-14', '2020-11-21', 'Re-viva', '2020-11-24', 
                         0, '134', '324', '335', '86');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-12-25', '2021-01-18', 'In Progress', 'Dr. Abdullah', '2020-11-22', 'Received', 'Received',
                                 '2021-01-21', '2021-01-22', '2021-01-24',
                                 '7%', '2021-01-22', '2021-01-23', '2021-01-24', '2021-01-24', '2021-02-04', '2021-02-07', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800003', 'Mia Ibrahim', 'MSc IT', 'SOE', 'PhD', 'Cohort 2023', '2023-04-19', 'A Study on the Impact of 312 Factors in SOE', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 10, 15, 'Prof. James Mohammad', '2025-02-25', '2025-02-27', '2025-03-01', 
                         '11%', '2025-03-03', '2025-03-06', '2025-03-06', '2025-03-16', '2025-03-21', 
                         '2025-03-21', '2025-04-07', '2025-04-10', '2025-05-08', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800004', 'Fatimah Martinez', 'MSc IT', 'SBM', 'DBA', 'Cohort 2020', '2020-11-28', 'A Study on the Impact of 416 Factors in SBM', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 16, 'Prof. Siti Gonzalez', '2022-12-13', '2022-12-14', '2022-12-14', 
                         '10%', '2022-12-17', '2022-12-25', '2022-12-22', '2023-01-01', '2023-01-02', 
                         '2023-01-03', '2023-01-18', '2023-01-21', '2023-02-22', 'Minor Corrections', '2023-02-26', 
                         0, '149', '492', '396', '71');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-04-07', '2023-05-03', 'Verified', 'Dr. Wilson', '2023-02-27', 'Received', 'Received',
                                 '2023-05-05', '2023-05-08', '2023-05-10',
                                 '10%', '2023-05-04', '2023-05-05', '2023-05-06', '2023-05-06', '2023-05-19', '2023-05-22', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2023-09-04', '2023-04-26', '2023-06-05', 'JIL/2023/8', '2023-07-14', 
                             'SENATE/2023/8', '2023-06-12', '2023-06-13', '2023-06-20', '2023-06-21', '2023-06-20', '2023-06-25', '2023-06-25');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800005', 'Ahmad Mohammad', 'DBA', 'SOE', 'PhD', 'Cohort 2020', '2020-11-08', 'A Study on the Impact of 370 Factors in SOE', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 12, 'Prof. Sophia Garcia', '2022-05-01', '2022-05-03', '2022-05-04', 
                         '11%', '2022-05-08', '2022-05-18', '2022-05-18', '2022-05-21', '2022-05-24', 
                         '2022-05-23', '2022-06-11', '2022-06-14', '2022-07-10', 'Major Corrections', '2022-07-15', 
                         1, '107', '410', '471', '72');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-08-30', '2022-08-02', 'Verified', 'Dr. Garcia', '2022-07-11', 'Received', 'Received',
                                 '2022-08-04', '2022-08-07', '2022-08-08',
                                 '15%', '2022-08-07', '2022-08-09', '2022-08-08', '2022-08-08', '2022-08-17', '2022-08-18', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-09-17', '2022-10-29', 'JIL/2022/4', NULL, 
                             NULL, '2022-11-05', '2022-11-08', '2022-11-14', '2022-11-21', '2022-11-15', '2022-11-21', '2022-11-19');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800006', 'Daniel Ibrahim', 'MSc Management', 'SBM', 'Masters', 'Cohort 2020', '2020-05-29', 'A Study on the Impact of 817 Factors in SBM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 13, 'Prof. Siti Lopez', '2022-12-03', '2022-12-07', '2022-12-09', 
                         '12%', '2022-12-11', '2022-12-14', '2022-12-17', '2022-12-25', '2022-12-27', 
                         '2022-12-29', '2023-01-16', '2023-01-18', '2023-02-27', 'Minor Corrections', '2023-03-01', 
                         0, '170', '334', '345', '61');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-05-09', '2023-03-26', 'Verified', 'Dr. Williams', '2023-03-04', 'Received', 'Received',
                                 '2023-03-28', '2023-03-31', '2023-04-01',
                                 '5%', '2023-03-27', '2023-03-30', '2023-03-29', '2023-03-29', '2023-04-13', '2023-04-15', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2023-05-15', '2023-06-26', 'JIL/2023/10', NULL, 
                             NULL, '2023-07-04', '2023-07-05', '2023-07-12', '2023-07-20', '2023-07-19', '2023-07-20', '2023-07-16');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800007', 'Emma Hassan', 'MSc Management', 'SOC', 'Masters', 'Cohort 2019', '2019-01-24', 'A Study on the Impact of 246 Factors in SOC', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 15, 'Prof. Olivia Rodriguez', '2021-02-25', '2021-03-01', '2021-03-03', 
                         '8%', '2021-03-04', '2021-03-10', '2021-03-11', '2021-03-16', '2021-03-17', 
                         '2021-03-20', '2021-04-01', '2021-04-05', '2021-05-11', 'Minor Corrections', '2021-05-17', 
                         1, '133', '325', '316', '81');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-07-21', '2021-07-05', 'In Progress', 'Dr. Brown', '2021-05-14', 'Received', 'Received',
                                 '2021-07-07', '2021-07-09', '2021-07-10',
                                 '11%', '2021-07-07', '2021-07-08', '2021-07-09', '2021-07-09', '2021-07-15', '2021-07-19', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800008', 'Sarah Brown', 'DBA', 'SOG', 'DBA', 'Cohort 2018', '2018-06-18', 'A Study on the Impact of 774 Factors in SOG', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 9, 19, 'Prof. Emma Rodriguez', '2020-09-12', '2020-09-13', '2020-09-13', 
                     '25%', '2020-09-17', '2020-09-18', '2020-09-22', '2020-09-23', '2020-09-26', 
                     '2020-09-26');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800009', 'Nur Ibrahim', 'MSc IT', 'SOC', 'DBA', 'Cohort 2021', '2021-10-29', 'A Study on the Impact of 575 Factors in SOC', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800010', 'Emma Garcia', 'PhD Education', 'SOE', 'PhD', 'Cohort 2021', '2021-06-20', 'A Study on the Impact of 572 Factors in SOE', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 11, 'Prof. Olivia Salleh', '2023-08-16', '2023-08-17', '2023-08-17', 
                         '24%', '2023-08-19', '2023-08-21', '2023-08-28', '2023-08-31', '2023-09-02', 
                         '2023-09-02', '2023-09-18', '2023-09-21', '2023-10-26', 'Pass', '2023-10-29', 
                         0, '179', '344', '433', '96');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-01-05', '2024-02-01', 'JIL/2024/5', NULL, 
                             NULL, '2024-02-08', '2024-02-11', '2024-02-20', '2024-02-16', '2024-02-20', '2024-02-19', '2024-02-25');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800011', 'Fatimah Jones', 'DBA', 'STHEM', 'PhD', 'Cohort 2023', '2023-11-03', 'A Study on the Impact of 210 Factors in STHEM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 10, 20, 'Prof. Fatimah Miller', '2025-03-01', '2025-03-02', '2025-03-03', 
                     '23%', '2025-03-05', '2025-03-14', '2025-03-15', '2025-03-20', '2025-03-24', 
                     '2025-03-22');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800012', 'Aminah Brown', 'MSc Accounting', 'IBS', 'Masters', 'Cohort 2018', '2018-10-05', 'A Study on the Impact of 544 Factors in IBS', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 7, 20, 'Prof. Aminah Miller', '2020-04-06', '2020-04-08', '2020-04-08', 
                     '25%', '2020-04-13', '2020-04-23', '2020-04-14', '2020-04-25', '2020-04-29', 
                     '2020-04-29');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800013', 'Sarah Hernandez', 'DBA', 'IBS', 'DBA', 'Cohort 2023', '2023-09-02', 'A Study on the Impact of 338 Factors in IBS', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 11, 'Prof. Muhammad Hassan', '2025-08-23', '2025-08-24', '2025-08-26', 
                         '21%', '2025-08-30', '2025-09-09', '2025-08-31', '2025-09-19', '2025-09-21', 
                         '2025-09-20', '2025-10-04', '2025-10-09', '2025-11-11', 'Fail', '2025-11-13', 
                         0, '155', '322', '382', '72');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2026-06-01', '2026-01-21', '2026-03-07', 'JIL/2026/4', '2026-04-17', 
                             'SENATE/2026/10', '2026-03-10', '2026-03-13', '2026-03-19', '2026-03-19', '2026-03-22', '2026-03-27', '2026-03-23');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800014', 'Siti Martinez', 'DBA', 'SBM', 'DBA', 'Cohort 2023', '2023-02-01', 'A Study on the Impact of 238 Factors in SBM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 8, 11, 'Prof. Isabella Salleh', '2025-06-23', '2025-06-27', '2025-06-29', 
                     '11%', '2025-07-01', '2025-07-02', '2025-07-09', '2025-07-17', '2025-07-19', 
                     '2025-07-22');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800015', 'Olivia Salleh', 'DBA', 'SBM', 'Masters', 'Cohort 2020', '2020-09-22', 'A Study on the Impact of 367 Factors in SBM', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800016', 'Fatimah Williams', 'PhD Finance', 'SOE', 'Masters', 'Cohort 2018', '2018-10-30', 'A Study on the Impact of 139 Factors in SOE', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800017', 'Ahmad Smith', 'PhD Education', 'SBM', 'PhD', 'Cohort 2022', '2022-05-02', 'A Study on the Impact of 591 Factors in SBM', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 1, 15, 'Prof. Aminah Wilson', '2024-11-24', '2024-11-27', '2024-11-28', 
                         '23%', '2024-11-29', '2024-12-01', '2024-12-06', '2024-12-09', '2024-12-12', 
                         '2024-12-10', '2024-12-20', '2024-12-25', '2025-01-28', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800018', 'James Hernandez', 'MSc Management', 'SOL', 'DBA', 'Cohort 2019', '2019-05-18', 'A Study on the Impact of 523 Factors in SOL', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 12, 'Prof. Muhammad Lopez', '2021-06-18', '2021-06-19', '2021-06-19', 
                         '23%', '2021-06-20', '2021-06-29', '2021-06-24', '2021-07-08', '2021-07-09', 
                         '2021-07-11', '2021-07-24', '2021-07-26', '2021-08-19', 'Minor Corrections', '2021-08-20', 
                         1, '115', '474', '378', '52');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-10-08', '2021-10-07', 'In Progress', 'Dr. Mohammad', '2021-08-23', 'Received', 'Received',
                                 '2021-10-09', '2021-10-10', '2021-10-12',
                                 '4%', '2021-10-09', '2021-10-10', '2021-10-11', '2021-10-11', '2021-10-18', '2021-10-21', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800019', 'Joseph Hassan', 'MSc IT', 'SBM', 'Masters', 'Cohort 2020', '2020-04-18', 'A Study on the Impact of 468 Factors in SBM', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 17, 'Prof. Michael Lopez', '2022-08-08', '2022-08-13', '2022-08-15', 
                         '12%', '2022-08-17', '2022-08-25', '2022-08-26', '2022-08-28', '2022-09-02', 
                         '2022-09-02', '2022-09-21', '2022-09-22', '2022-10-12', 'Major Corrections', '2022-10-18', 
                         1, '151', '409', '315', '67');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800020', 'Olivia Jones', 'DBA', 'SOC', 'DBA', 'Cohort 2022', '2022-06-11', 'A Study on the Impact of 180 Factors in SOC', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 13, 'Prof. Isabella Hernandez', '2024-10-07', '2024-10-08', '2024-10-08', 
                         '25%', '2024-10-11', '2024-10-14', '2024-10-13', '2024-10-20', '2024-10-21', 
                         '2024-10-21', '2024-11-08', '2024-11-10', '2024-12-12', 'Re-viva', '2024-12-16', 
                         0, '121', '371', '369', '97');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-02-24', '2025-02-04', 'Verified', 'Dr. Gonzalez', '2024-12-15', 'Received', 'Received',
                                 '2025-02-05', '2025-02-07', '2025-02-09',
                                 '3%', '2025-02-08', '2025-02-11', '2025-02-09', '2025-02-09', '2025-02-17', '2025-02-20', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2025-02-13', '2025-03-29', 'JIL/2025/2', NULL, 
                             NULL, '2025-04-05', '2025-04-06', '2025-04-15', '2025-04-12', '2025-04-12', '2025-04-19', '2025-04-18');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800021', 'Sophia Rodriguez', 'DBA', 'SOG', 'Masters', 'Cohort 2018', '2018-03-22', 'A Study on the Impact of 115 Factors in SOG', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 18, 'Prof. Sarah Thomas', '2020-05-05', '2020-05-07', '2020-05-09', 
                         '5%', '2020-05-12', '2020-05-13', '2020-05-19', '2020-05-28', '2020-05-31', 
                         '2020-05-31', '2020-06-13', '2020-06-18', '2020-07-12', 'Pass', '2020-07-15', 
                         1, '121', '398', '466', '67');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2020-09-13', '2020-10-21', 'JIL/2020/10', NULL, 
                             NULL, '2020-10-24', '2020-10-27', '2020-11-02', '2020-11-10', '2020-11-03', '2020-11-08', '2020-11-07');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800022', 'Joseph Mohammad', 'PhD Education', 'SOG', 'PhD', 'Cohort 2022', '2022-10-21', 'A Study on the Impact of 979 Factors in SOG', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 16, 'Prof. Isabella Martinez', '2024-08-21', '2024-08-25', '2024-08-27', 
                         '21%', '2024-08-30', '2024-09-06', '2024-09-03', '2024-09-14', '2024-09-17', 
                         '2024-09-19', '2024-10-05', '2024-10-08', '2024-11-17', 'Fail', '2024-11-20', 
                         0, '134', '345', '455', '94');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800023', 'Ali Garcia', 'MSc IT', 'STHEM', 'Masters', 'Cohort 2019', '2019-06-29', 'A Study on the Impact of 727 Factors in STHEM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 17, 'Prof. Aminah Williams', '2021-12-03', '2021-12-06', '2021-12-06', 
                         '12%', '2021-12-11', '2021-12-18', '2021-12-20', '2021-12-26', '2021-12-29', 
                         '2021-12-28', '2022-01-07', '2022-01-10', '2022-02-06', 'Major Corrections', '2022-02-08', 
                         1, '170', '433', '419', '55');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-04-06', '2022-03-26', 'Verified', 'Dr. Williams', '2022-02-11', 'Received', 'Received',
                                 '2022-03-27', '2022-03-28', '2022-03-30',
                                 '13%', '2022-03-30', '2022-04-02', '2022-04-01', '2022-04-02', '2022-04-15', '2022-04-16', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-04-10', '2022-06-05', 'JIL/2022/1', NULL, 
                             NULL, '2022-06-07', '2022-06-08', '2022-06-20', '2022-06-15', '2022-06-15', '2022-06-15', '2022-06-24');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800024', 'Joseph Ibrahim', 'MSc IT', 'SOL', 'PhD', 'Cohort 2018', '2018-09-26', 'A Study on the Impact of 909 Factors in SOL', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 1, 15, 'Prof. John Anderson', '2020-04-07', '2020-04-10', '2020-04-11', 
                     '20%', '2020-04-12', '2020-04-22', '2020-04-14', '2020-04-25', '2020-04-29', 
                     '2020-04-26');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800025', 'Jane Smith', 'DBA', 'SOE', 'Masters', 'Cohort 2023', '2023-02-06', 'A Study on the Impact of 508 Factors in SOE', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 1, 15, 'Prof. Kamal Williams', '2025-07-07', '2025-07-09', '2025-07-09', 
                         '9%', '2025-07-11', '2025-07-14', '2025-07-17', '2025-07-21', '2025-07-25', 
                         '2025-07-26', '2025-08-05', '2025-08-10', '2025-09-07', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800026', 'Sarah Hernandez', 'MSc IT', 'STHEM', 'DBA', 'Cohort 2023', '2023-03-06', 'A Study on the Impact of 601 Factors in STHEM', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 12, 'Prof. Olivia Johnson', '2025-06-22', '2025-06-26', '2025-06-27', 
                         '20%', '2025-07-01', '2025-07-11', '2025-07-11', '2025-07-21', '2025-07-22', 
                         '2025-07-26', '2025-08-08', '2025-08-13', '2025-09-04', 'Minor Corrections', '2025-09-10', 
                         1, '152', '488', '335', '98');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800027', 'John Davis', 'PhD Education', 'SOG', 'DBA', 'Cohort 2023', '2023-04-28', 'A Study on the Impact of 114 Factors in SOG', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 20, 'Prof. Mia Hernandez', '2025-11-28', '2025-11-30', '2025-12-02', 
                         '21%', '2025-12-04', '2025-12-07', '2025-12-09', '2025-12-18', '2025-12-23', 
                         '2025-12-19', '2026-01-08', '2026-01-13', '2026-02-17', 'Minor Corrections', '2026-02-20', 
                         1, '194', '469', '327', '80');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2026-03-30', '2026-04-10', 'In Progress', 'Dr. Brown', '2026-02-19', 'Received', 'Received',
                                 '2026-04-13', '2026-04-15', '2026-04-17',
                                 '1%', '2026-04-13', '2026-04-15', '2026-04-14', '2026-04-15', '2026-04-23', '2026-04-27', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800028', 'Siti Davis', 'DBA', 'SOG', 'Masters', 'Cohort 2021', '2021-10-10', 'A Study on the Impact of 405 Factors in SOG', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 16, 'Prof. Mia Hernandez', '2023-03-14', '2023-03-17', '2023-03-18', 
                         '22%', '2023-03-22', '2023-03-23', '2023-03-29', '2023-03-31', '2023-04-03', 
                         '2023-04-03', '2023-04-23', '2023-04-28', '2023-05-23', 'Major Corrections', '2023-05-24', 
                         1, '140', '377', '346', '68');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-07-19', '2023-08-01', 'Verified', 'Dr. Gonzalez', '2023-05-27', 'Received', 'Received',
                                 '2023-08-03', '2023-08-05', '2023-08-06',
                                 '12%', '2023-08-05', '2023-08-08', '2023-08-07', '2023-08-07', '2023-08-18', '2023-08-21', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2023-07-28', '2023-09-02', 'JIL/2023/3', NULL, 
                             NULL, '2023-09-08', '2023-09-09', '2023-09-22', '2023-09-23', '2023-09-18', '2023-09-19', '2023-09-26');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800029', 'Aminah Williams', 'MSc Management', 'STHEM', 'DBA', 'Cohort 2023', '2023-11-30', 'A Study on the Impact of 819 Factors in STHEM', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 7, 14, 'Prof. Jane Davis', '2025-12-01', '2025-12-02', '2025-12-03', 
                         '9%', '2025-12-06', '2025-12-11', '2025-12-15', '2025-12-22', '2025-12-24', 
                         '2025-12-24', '2026-01-05', '2026-01-09', '2026-01-29', 'Fail', '2026-02-01', 
                         0, '179', '420', '372', '65');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800030', 'James Othman', 'MSc Accounting', 'SOL', 'PhD', 'Cohort 2020', '2020-06-08', 'A Study on the Impact of 568 Factors in SOL', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 12, 'Prof. James Miller', '2022-02-09', '2022-02-12', '2022-02-13', 
                         '17%', '2022-02-18', '2022-02-27', '2022-02-21', '2022-03-03', '2022-03-06', 
                         '2022-03-05', '2022-03-21', '2022-03-22', '2022-04-28', 'Minor Corrections', '2022-05-02', 
                         1, '193', '343', '454', '68');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-06-30', '2022-05-21', 'Verified', 'Dr. Jones', '2022-05-02', 'Received', 'Received',
                                 '2022-05-23', '2022-05-24', '2022-05-26',
                                 '1%', '2022-05-24', '2022-05-27', '2022-05-26', '2022-05-27', '2022-06-07', '2022-06-09', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2022-10-27', '2022-07-03', '2022-07-31', 'JIL/2022/9', '2022-09-03', 
                             'SENATE/2022/5', '2022-08-08', '2022-08-10', '2022-08-24', '2022-08-22', '2022-08-17', '2022-08-21', '2022-08-28');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800031', 'Sophia Ibrahim', 'PhD Education', 'IBS', 'Masters', 'Cohort 2022', '2022-03-02', 'A Study on the Impact of 292 Factors in IBS', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 6, 11, 'Prof. John Salleh', '2024-04-26', '2024-04-27', '2024-04-27', 
                     '15%', '2024-04-29', '2024-05-08', '2024-05-01', '2024-05-13', '2024-05-15', 
                     '2024-05-17');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800032', 'Emma Mohammad', 'MSc Accounting', 'SOL', 'PhD', 'Cohort 2019', '2019-09-04', 'A Study on the Impact of 762 Factors in SOL', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800033', 'Emma Martinez', 'MSc IT', 'IBS', 'PhD', 'Cohort 2022', '2022-02-09', 'A Study on the Impact of 298 Factors in IBS', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 12, 'Prof. Joseph Ibrahim', '2024-04-01', '2024-04-02', '2024-04-04', 
                         '22%', '2024-04-06', '2024-04-13', '2024-04-11', '2024-04-23', '2024-04-28', 
                         '2024-04-27', '2024-05-14', '2024-05-17', '2024-06-22', 'Pass', '2024-06-23', 
                         0, '147', '491', '413', '63');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800034', 'John Johnson', 'DBA', 'SOG', 'DBA', 'Cohort 2020', '2020-04-26', 'A Study on the Impact of 368 Factors in SOG', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 8, 16, 'Prof. William Smith', '2022-06-23', '2022-06-28', '2022-06-29', 
                         '7%', '2022-06-30', '2022-07-05', '2022-07-02', '2022-07-15', '2022-07-19', 
                         '2022-07-17', '2022-07-31', '2022-08-02', '2022-08-28', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800035', 'Isabella Lopez', 'MSc Accounting', 'SOE', 'Masters', 'Cohort 2020', '2020-03-12', 'A Study on the Impact of 858 Factors in SOE', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800036', 'James Salleh', 'MSc Management', 'SOE', 'PhD', 'Cohort 2022', '2022-10-07', 'A Study on the Impact of 160 Factors in SOE', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 15, 'Prof. Isabella Rodriguez', '2024-04-22', '2024-04-24', '2024-04-24', 
                         '14%', '2024-04-29', '2024-04-30', '2024-04-30', '2024-05-09', '2024-05-13', 
                         '2024-05-12', '2024-05-26', '2024-05-30', '2024-06-21', 'Re-viva', '2024-06-28', 
                         1, '182', '445', '396', '80');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-07-27', '2024-08-23', 'Verified', 'Dr. Brown', '2024-06-24', 'Received', 'Received',
                                 '2024-08-24', '2024-08-27', '2024-08-29',
                                 '10%', '2024-08-25', '2024-08-28', '2024-08-27', '2024-08-27', '2024-09-07', '2024-09-09', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-08-22', '2024-09-28', 'JIL/2024/8', NULL, 
                             NULL, '2024-10-06', '2024-10-08', '2024-10-22', '2024-10-13', '2024-10-13', '2024-10-16', '2024-10-23');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800037', 'Isabella Hassan', 'PhD Finance', 'SOC', 'DBA', 'Cohort 2023', '2023-12-04', 'A Study on the Impact of 245 Factors in SOC', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 6, 16, 'Prof. Joseph Mohammad', '2025-02-05', '2025-02-10', '2025-02-12', 
                         '19%', '2025-02-17', '2025-02-27', '2025-02-23', '2025-03-05', '2025-03-06', 
                         '2025-03-07', '2025-03-20', '2025-03-23', '2025-04-25', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800038', 'Jane Williams', 'MSc IT', 'SOL', 'Masters', 'Cohort 2018', '2018-04-25', 'A Study on the Impact of 818 Factors in SOL', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 2, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 17, 'Prof. Michael Abdullah', '2020-06-15', '2020-06-16', '2020-06-16', 
                         '11%', '2020-06-19', '2020-06-26', '2020-06-27', '2020-06-29', '2020-07-01', 
                         '2020-07-02', '2020-07-20', '2020-07-24', '2020-08-14', 'Minor Corrections', '2020-08-21', 
                         1, '106', '469', '439', '69');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800039', 'Sarah Jones', 'MSc IT', 'STHEM', 'Masters', 'Cohort 2022', '2022-10-11', 'A Study on the Impact of 121 Factors in STHEM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 16, 'Prof. David Miller', '2024-12-07', '2024-12-12', '2024-12-13', 
                         '20%', '2024-12-17', '2024-12-27', '2024-12-18', '2025-01-01', '2025-01-05', 
                         '2025-01-05', '2025-01-21', '2025-01-22', '2025-02-13', 'Major Corrections', '2025-02-19', 
                         0, '200', '460', '354', '66');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-04-12', '2025-04-03', 'In Progress', 'Dr. Garcia', '2025-02-14', 'Received', 'Received',
                                 '2025-04-06', '2025-04-08', '2025-04-09',
                                 '2%', '2025-04-07', '2025-04-10', '2025-04-08', '2025-04-10', '2025-04-24', '2025-04-25', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800040', 'Isabella Williams', 'DBA', 'SOL', 'PhD', 'Cohort 2021', '2021-09-12', 'A Study on the Impact of 353 Factors in SOL', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 11, 'Prof. Emma Wilson', '2023-06-06', '2023-06-08', '2023-06-08', 
                         '9%', '2023-06-12', '2023-06-13', '2023-06-14', '2023-06-23', '2023-06-25', 
                         '2023-06-27', '2023-07-14', '2023-07-19', '2023-08-12', 'Minor Corrections', '2023-08-13', 
                         1, '125', '372', '325', '82');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-11-06', '2023-10-06', 'In Progress', 'Dr. Abdullah', '2023-08-13', 'Received', 'Received',
                                 '2023-10-08', '2023-10-10', '2023-10-11',
                                 '9%', '2023-10-07', '2023-10-09', '2023-10-09', '2023-10-09', '2023-10-19', '2023-10-22', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800041', 'Kamal Jones', 'PhD Finance', 'SOE', 'DBA', 'Cohort 2022', '2022-01-17', 'A Study on the Impact of 853 Factors in SOE', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 15, 'Prof. Joseph Brown', '2024-02-08', '2024-02-11', '2024-02-11', 
                         '25%', '2024-02-14', '2024-02-16', '2024-02-19', '2024-02-24', '2024-02-29', 
                         '2024-02-28', '2024-03-11', '2024-03-12', '2024-04-07', 'Re-viva', '2024-04-10', 
                         0, '118', '309', '306', '59');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-06-23', '2024-05-16', 'Verified', 'Dr. Salleh', '2024-04-10', 'Received', 'Received',
                                 '2024-05-19', '2024-05-21', '2024-05-23',
                                 '9%', '2024-05-20', '2024-05-21', '2024-05-21', '2024-05-22', '2024-05-27', '2024-05-30', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2024-09-18', '2024-06-20', '2024-07-08', 'JIL/2024/5', '2024-08-19', 
                             'SENATE/2024/1', '2024-07-15', '2024-07-16', '2024-07-31', '2024-07-25', '2024-07-23', '2024-07-21', '2024-08-03');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800042', 'Jane Jones', 'DBA', 'SOL', 'Masters', 'Cohort 2022', '2022-05-19', 'A Study on the Impact of 477 Factors in SOL', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 3, 18, 'Prof. Fatimah Othman', '2024-07-16', '2024-07-18', '2024-07-18', 
                         '25%', '2024-07-22', '2024-07-25', '2024-07-24', '2024-07-30', '2024-08-02', 
                         '2024-08-03', '2024-08-18', '2024-08-21', '2024-09-18', 'Re-viva', '2024-09-22', 
                         0, '198', '381', '399', '63');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-12-08', '2024-11-29', 'Verified', 'Dr. Garcia', '2024-09-19', 'Received', 'Received',
                                 '2024-12-02', '2024-12-05', '2024-12-06',
                                 '12%', '2024-12-03', '2024-12-05', '2024-12-06', '2024-12-06', '2024-12-18', '2024-12-19', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-12-05', '2024-12-28', 'JIL/2024/3', NULL, 
                             NULL, '2025-01-02', '2025-01-05', '2025-01-17', '2025-01-15', '2025-01-11', '2025-01-15', '2025-01-20');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800043', 'John Salleh', 'PhD Education', 'SOG', 'Masters', 'Cohort 2019', '2019-06-07', 'A Study on the Impact of 902 Factors in SOG', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 10, 20, 'Prof. Ali Hernandez', '2021-06-02', '2021-06-05', '2021-06-07', 
                     '9%', '2021-06-09', '2021-06-17', '2021-06-16', '2021-06-19', '2021-06-20', 
                     '2021-06-24');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800044', 'Kamal Jones', 'MSc Management', 'SOC', 'PhD', 'Cohort 2021', '2021-12-18', 'A Study on the Impact of 765 Factors in SOC', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 18, 'Prof. Olivia Johnson', '2023-01-11', '2023-01-13', '2023-01-13', 
                         '21%', '2023-01-16', '2023-01-19', '2023-01-26', '2023-02-02', '2023-02-04', 
                         '2023-02-03', '2023-02-20', '2023-02-24', '2023-04-03', 'Pass', '2023-04-06', 
                         0, '147', '465', '432', '58');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2023-10-03', '2023-06-12', '2023-07-05', 'JIL/2023/9', '2023-08-06', 
                             'SENATE/2023/4', '2023-07-15', '2023-07-17', '2023-07-24', '2023-07-27', '2023-07-23', '2023-07-24', '2023-07-29');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800045', 'Kamal Hernandez', 'PhD Finance', 'IBS', 'DBA', 'Cohort 2022', '2022-12-07', 'A Study on the Impact of 123 Factors in IBS', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 12, 'Prof. Muhammad Thomas', '2024-10-05', '2024-10-07', '2024-10-08', 
                         '8%', '2024-10-12', '2024-10-21', '2024-10-14', '2024-10-29', '2024-11-01', 
                         '2024-11-01', '2024-11-13', '2024-11-14', '2024-12-07', 'Major Corrections', '2024-12-08', 
                         0, '100', '425', '373', '93');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-02-08', '2024-12-28', 'In Progress', 'Dr. Hassan', '2024-12-08', 'Received', 'Received',
                                 '2024-12-29', '2024-12-30', '2025-01-01',
                                 '5%', '2024-12-30', '2025-01-02', '2025-01-01', '2025-01-02', '2025-01-15', '2025-01-17', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800046', 'Isabella Miller', 'MSc IT', 'SOG', 'DBA', 'Cohort 2021', '2021-03-24', 'A Study on the Impact of 675 Factors in SOG', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 15, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 12, 'Prof. Muhammad Anderson', '2023-02-05', '2023-02-10', '2023-02-12', 
                         '7%', '2023-02-13', '2023-02-20', '2023-02-20', '2023-03-01', '2023-03-05', 
                         '2023-03-04', '2023-03-20', '2023-03-25', '2023-04-29', 'Major Corrections', '2023-05-06', 
                         1, '160', '360', '324', '64');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-06-30', '2023-07-04', 'Verified', 'Dr. Williams', '2023-05-01', 'Received', 'Received',
                                 '2023-07-06', '2023-07-09', '2023-07-11',
                                 '11%', '2023-07-09', '2023-07-12', '2023-07-10', '2023-07-11', '2023-07-19', '2023-07-22', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2023-11-18', '2023-07-08', '2023-08-06', 'JIL/2023/1', '2023-09-24', 
                             'SENATE/2023/5', '2023-08-15', '2023-08-17', '2023-08-29', '2023-08-26', '2023-08-27', '2023-08-22', '2023-09-02');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800047', 'Muhammad Miller', 'PhD Education', 'SOC', 'PhD', 'Cohort 2019', '2019-05-14', 'A Study on the Impact of 579 Factors in SOC', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 10, 19, 'Prof. David Miller', '2021-07-25', '2021-07-30', '2021-08-01', 
                         '21%', '2021-08-03', '2021-08-13', '2021-08-04', '2021-08-18', '2021-08-22', 
                         '2021-08-20', '2021-09-06', '2021-09-08', '2021-10-07', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800048', 'Daniel Miller', 'PhD Finance', 'SOG', 'PhD', 'Cohort 2022', '2022-05-26', 'A Study on the Impact of 572 Factors in SOG', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 13, 'Prof. Ahmad Davis', '2024-06-16', '2024-06-20', '2024-06-21', 
                         '6%', '2024-06-25', '2024-06-27', '2024-06-29', '2024-07-03', '2024-07-06', 
                         '2024-07-08', '2024-07-24', '2024-07-28', '2024-09-01', 'Minor Corrections', '2024-09-02', 
                         1, '194', '375', '467', '97');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-11-17', '2024-10-19', 'In Progress', 'Dr. Lopez', '2024-09-05', 'Received', 'Received',
                                 '2024-10-22', '2024-10-24', '2024-10-26',
                                 '4%', '2024-10-23', '2024-10-26', '2024-10-26', '2024-10-25', '2024-11-04', '2024-11-05', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800049', 'Jane Smith', 'MSc Accounting', 'STHEM', 'PhD', 'Cohort 2022', '2022-10-17', 'A Study on the Impact of 280 Factors in STHEM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 5, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 11, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 12, 'Prof. Olivia Davis', '2024-04-05', '2024-04-10', '2024-04-12', 
                         '8%', '2024-04-15', '2024-04-20', '2024-04-21', '2024-04-28', '2024-05-01', 
                         '2024-05-02', '2024-05-13', '2024-05-17', '2024-06-18', 'Minor Corrections', '2024-06-25', 
                         0, '187', '357', '359', '82');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-08-24', '2024-08-06', 'Verified', 'Dr. Othman', '2024-06-20', 'Received', 'Received',
                                 '2024-08-09', '2024-08-12', '2024-08-14',
                                 '10%', '2024-08-09', '2024-08-10', '2024-08-11', '2024-08-10', '2024-08-24', '2024-08-25', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-08-29', '2024-09-19', 'JIL/2024/1', NULL, 
                             NULL, '2024-09-24', '2024-09-27', '2024-10-07', '2024-10-02', '2024-10-07', '2024-10-02', '2024-10-09');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800050', 'Muhammad Garcia', 'PhD Finance', 'SBM', 'PhD', 'Cohort 2022', '2022-06-16', 'A Study on the Impact of 688 Factors in SBM', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 8, 16, 'Prof. Joseph Hernandez', '2024-08-28', '2024-08-30', '2024-08-30', 
                         '24%', '2024-09-01', '2024-09-10', '2024-09-10', '2024-09-16', '2024-09-20', 
                         '2024-09-21', '2024-10-11', '2024-10-15', '2024-11-24', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800051', 'Aminah Thomas', 'DBA', 'IBS', 'DBA', 'Cohort 2018', '2018-03-23', 'A Study on the Impact of 314 Factors in IBS', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 11, 'Prof. Joseph Hassan', '2020-02-09', '2020-02-10', '2020-02-10', 
                         '15%', '2020-02-15', '2020-02-23', '2020-02-19', '2020-02-24', '2020-02-28', 
                         '2020-02-25', '2020-03-07', '2020-03-12', '2020-04-21', 'Minor Corrections', '2020-04-26', 
                         0, '118', '368', '415', '93');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-06-14', '2020-05-12', 'Verified', 'Dr. Jones', '2020-04-22', 'Received', 'Received',
                                 '2020-05-13', '2020-05-14', '2020-05-16',
                                 '4%', '2020-05-13', '2020-05-16', '2020-05-15', '2020-05-14', '2020-05-21', '2020-05-22', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2020-11-11', '2020-07-05', '2020-08-17', 'JIL/2020/4', '2020-09-23', 
                             'SENATE/2020/7', '2020-08-27', '2020-08-30', '2020-09-10', '2020-09-12', '2020-09-07', '2020-09-12', '2020-09-11');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800052', 'Siti Abdullah', 'PhD Finance', 'SOE', 'PhD', 'Cohort 2023', '2023-07-27', 'A Study on the Impact of 781 Factors in SOE', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 12, 'Prof. Siti Ibrahim', '2025-04-16', '2025-04-19', '2025-04-21', 
                         '22%', '2025-04-22', '2025-05-02', '2025-04-30', '2025-05-07', '2025-05-12', 
                         '2025-05-10', '2025-05-22', '2025-05-23', '2025-06-13', 'Pass', '2025-06-20', 
                         1, '116', '492', '459', '98');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2025-12-20', '2025-08-29', '2025-10-06', 'JIL/2025/4', '2025-11-13', 
                             'SENATE/2025/1', '2025-10-12', '2025-10-15', '2025-10-23', '2025-10-30', '2025-10-29', '2025-10-28', '2025-10-24');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800053', 'Aminah Thomas', 'MSc Management', 'IBS', 'Masters', 'Cohort 2020', '2020-01-04', 'A Study on the Impact of 562 Factors in IBS', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 14, 'Prof. Ahmad Brown', '2022-05-10', '2022-05-11', '2022-05-12', 
                         '6%', '2022-05-14', '2022-05-19', '2022-05-22', '2022-05-24', '2022-05-27', 
                         '2022-05-28', '2022-06-11', '2022-06-14', '2022-07-16', 'Minor Corrections', '2022-07-17', 
                         1, '144', '392', '335', '72');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-09-19', '2022-09-30', 'In Progress', 'Dr. Smith', '2022-07-18', 'Received', 'Received',
                                 '2022-10-02', '2022-10-03', '2022-10-05',
                                 '6%', '2022-10-01', '2022-10-02', '2022-10-03', '2022-10-02', '2022-10-14', '2022-10-18', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800054', 'Ahmad Anderson', 'PhD Finance', 'SOC', 'Masters', 'Cohort 2019', '2019-06-05', 'A Study on the Impact of 821 Factors in SOC', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 2, 12, 'Prof. David Mohammad', '2021-09-16', '2021-09-18', '2021-09-20', 
                         '16%', '2021-09-22', '2021-09-26', '2021-09-24', '2021-09-27', '2021-09-30', 
                         '2021-09-30', '2021-10-17', '2021-10-20', '2021-11-23', 'Re-viva', '2021-11-29', 
                         0, '162', '474', '464', '98');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-01-30', '2022-01-20', 'Verified', 'Dr. Garcia', '2021-11-28', 'Received', 'Received',
                                 '2022-01-22', '2022-01-25', '2022-01-26',
                                 '4%', '2022-01-21', '2022-01-23', '2022-01-23', '2022-01-23', '2022-02-04', '2022-02-06', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2022-06-01', '2022-01-22', '2022-03-02', 'JIL/2022/1', '2022-04-05', 
                             'SENATE/2022/6', '2022-03-09', '2022-03-12', '2022-03-25', '2022-03-24', '2022-03-18', '2022-03-22', '2022-03-28');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800055', 'Isabella Brown', 'PhD Education', 'SOG', 'DBA', 'Cohort 2020', '2020-11-23', 'A Study on the Impact of 487 Factors in SOG', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800056', 'Daniel Salleh', 'PhD Finance', 'IBS', 'PhD', 'Cohort 2022', '2022-10-16', 'A Study on the Impact of 481 Factors in IBS', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 17, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800057', 'Muhammad Anderson', 'MSc IT', 'IBS', 'Masters', 'Cohort 2020', '2020-06-11', 'A Study on the Impact of 844 Factors in IBS', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 19, 'Prof. Sarah Anderson', '2022-02-08', '2022-02-12', '2022-02-12', 
                         '13%', '2022-02-17', '2022-02-22', '2022-02-18', '2022-03-01', '2022-03-02', 
                         '2022-03-02', '2022-03-19', '2022-03-20', '2022-04-13', 'Minor Corrections', '2022-04-16', 
                         0, '190', '439', '328', '96');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-06-30', '2022-05-31', 'Verified', 'Dr. Anderson', '2022-04-18', 'Received', 'Received',
                                 '2022-06-03', '2022-06-04', '2022-06-05',
                                 '15%', '2022-06-05', '2022-06-08', '2022-06-06', '2022-06-08', '2022-06-14', '2022-06-15', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-06-23', '2022-08-04', 'JIL/2022/5', NULL, 
                             NULL, '2022-08-08', '2022-08-11', '2022-08-19', '2022-08-19', '2022-08-26', '2022-08-25', '2022-08-23');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800058', 'Joseph Lopez', 'MSc Accounting', 'SOG', 'Masters', 'Cohort 2021', '2021-06-14', 'A Study on the Impact of 885 Factors in SOG', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 20, 'Prof. Michael Ibrahim', '2023-05-27', '2023-06-01', '2023-06-01', 
                         '14%', '2023-06-04', '2023-06-12', '2023-06-14', '2023-06-19', '2023-06-21', 
                         '2023-06-21', '2023-07-03', '2023-07-08', '2023-07-30', 'Re-viva', '2023-08-04', 
                         1, '195', '406', '397', '58');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-09-28', '2023-09-19', 'In Progress', 'Dr. Hassan', '2023-07-31', 'Received', 'Received',
                                 '2023-09-22', '2023-09-25', '2023-09-27',
                                 '13%', '2023-09-21', '2023-09-23', '2023-09-24', '2023-09-23', '2023-10-02', '2023-10-04', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800059', 'Muhammad Othman', 'MSc Accounting', 'IBS', 'PhD', 'Cohort 2021', '2021-08-26', 'A Study on the Impact of 991 Factors in IBS', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 6, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 1, 12, 'Prof. Muhammad Thomas', '2023-05-03', '2023-05-04', '2023-05-04', 
                         '18%', '2023-05-06', '2023-05-07', '2023-05-13', '2023-05-14', '2023-05-17', 
                         '2023-05-18', '2023-05-28', '2023-06-02', '2023-07-05', 'Minor Corrections', '2023-07-12', 
                         0, '166', '451', '337', '92');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800060', 'Emma Jones', 'MSc Accounting', 'SOE', 'DBA', 'Cohort 2018', '2018-08-02', 'A Study on the Impact of 352 Factors in SOE', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 2, 12, 'Prof. Nur Gonzalez', '2020-03-01', '2020-03-03', '2020-03-05', 
                         '5%', '2020-03-07', '2020-03-17', '2020-03-09', '2020-03-19', '2020-03-24', 
                         '2020-03-20', '2020-04-08', '2020-04-10', '2020-05-11', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800061', 'Isabella Hassan', 'PhD Education', 'SOL', 'DBA', 'Cohort 2022', '2022-08-19', 'A Study on the Impact of 417 Factors in SOL', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800062', 'Aminah Mohammad', 'DBA', 'STHEM', 'PhD', 'Cohort 2020', '2020-09-30', 'A Study on the Impact of 387 Factors in STHEM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 18, 'Prof. Mia Jones', '2022-05-15', '2022-05-19', '2022-05-21', 
                         '22%', '2022-05-25', '2022-05-28', '2022-06-03', '2022-06-05', '2022-06-06', 
                         '2022-06-09', '2022-06-22', '2022-06-25', '2022-07-27', 'Minor Corrections', '2022-07-31', 
                         0, '142', '352', '443', '86');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-10-10', '2022-10-05', 'In Progress', 'Dr. Gonzalez', '2022-07-29', 'Received', 'Received',
                                 '2022-10-06', '2022-10-09', '2022-10-11',
                                 '8%', '2022-10-06', '2022-10-09', '2022-10-08', '2022-10-07', '2022-10-21', '2022-10-23', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800063', 'Sarah Gonzalez', 'DBA', 'SOG', 'Masters', 'Cohort 2021', '2021-10-26', 'A Study on the Impact of 447 Factors in SOG', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 8, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 4, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 5, 15, 'Prof. Joseph Thomas', '2023-01-11', '2023-01-16', '2023-01-17', 
                         '25%', '2023-01-19', '2023-01-26', '2023-01-25', '2023-02-02', '2023-02-05', 
                         '2023-02-06', '2023-02-17', '2023-02-19', '2023-03-26', 'Re-viva', '2023-03-29', 
                         0, '107', '315', '473', '80');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-04-25', '2023-05-11', 'Verified', 'Dr. Salleh', '2023-03-27', 'Received', 'Received',
                                 '2023-05-14', '2023-05-15', '2023-05-16',
                                 '1%', '2023-05-12', '2023-05-15', '2023-05-13', '2023-05-14', '2023-05-25', '2023-05-29', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2023-06-05', '2023-07-17', 'JIL/2023/9', NULL, 
                             NULL, '2023-07-18', '2023-07-20', '2023-07-30', '2023-07-25', '2023-07-27', '2023-07-31', '2023-08-03');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800064', 'Muhammad Mohammad', 'MSc Accounting', 'SOE', 'PhD', 'Cohort 2020', '2020-12-07', 'A Study on the Impact of 226 Factors in SOE', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 4, 13, 'Prof. Daniel Hassan', '2022-06-08', '2022-06-11', '2022-06-12', 
                     '22%', '2022-06-13', '2022-06-15', '2022-06-23', '2022-06-30', '2022-07-03', 
                     '2022-07-05');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800065', 'Muhammad Thomas', 'MSc IT', 'IBS', 'PhD', 'Cohort 2021', '2021-06-30', 'A Study on the Impact of 773 Factors in IBS', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 1, 19, 'Prof. Jane Ibrahim', '2023-11-28', '2023-12-03', '2023-12-05', 
                         '10%', '2023-12-10', '2023-12-16', '2023-12-12', '2023-12-24', '2023-12-29', 
                         '2023-12-28', '2024-01-17', '2024-01-20', '2024-02-17', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800066', 'David Hernandez', 'MSc IT', 'SBM', 'PhD', 'Cohort 2020', '2020-02-12', 'A Study on the Impact of 707 Factors in SBM', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 1, 'co');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800067', 'Mia Garcia', 'MSc Management', 'SOG', 'Masters', 'Cohort 2022', '2022-03-23', 'A Study on the Impact of 235 Factors in SOG', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 12, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 8, 14, 'Prof. John Mohammad', '2024-01-17', '2024-01-18', '2024-01-18', 
                         '25%', '2024-01-20', '2024-01-30', '2024-01-21', '2024-02-07', '2024-02-09', 
                         '2024-02-10', '2024-02-29', '2024-03-01', '2024-04-09', 'Pass', '2024-04-15', 
                         0, '128', '481', '443', '84');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800068', 'Siti Abdullah', 'MSc Management', 'SBM', 'Masters', 'Cohort 2018', '2018-12-20', 'A Study on the Impact of 236 Factors in SBM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 13, 'Prof. Fatimah Salleh', '2020-03-25', '2020-03-26', '2020-03-26', 
                         '19%', '2020-03-27', '2020-04-06', '2020-04-02', '2020-04-13', '2020-04-18', 
                         '2020-04-14', '2020-05-03', '2020-05-05', '2020-05-28', 'Minor Corrections', '2020-06-04', 
                         0, '120', '343', '329', '62');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2020-07-19', '2020-08-07', 'In Progress', 'Dr. Smith', '2020-06-02', 'Received', 'Received',
                                 '2020-08-09', '2020-08-10', '2020-08-11',
                                 '2%', '2020-08-10', '2020-08-13', '2020-08-12', '2020-08-12', '2020-08-26', '2020-08-29', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800069', 'Daniel Jones', 'DBA', 'SOG', 'PhD', 'Cohort 2023', '2023-01-04', 'A Study on the Impact of 286 Factors in SOG', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 6, 14, 'Prof. Mia Hernandez', '2025-12-21', '2025-12-26', '2025-12-26', 
                         '25%', '2025-12-31', '2026-01-01', '2026-01-02', '2026-01-12', '2026-01-16', 
                         '2026-01-17', '2026-01-29', '2026-01-31', '2026-02-21', 'Re-viva', '2026-02-26', 
                         0, '158', '305', '493', '55');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2026-04-30', '2026-04-11', 'In Progress', 'Dr. Ibrahim', '2026-02-25', 'Received', 'Received',
                                 '2026-04-13', '2026-04-16', '2026-04-18',
                                 '7%', '2026-04-13', '2026-04-14', '2026-04-14', '2026-04-16', '2026-04-26', '2026-04-28', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800070', 'Ahmad Othman', 'MSc IT', 'SOL', 'Masters', 'Cohort 2022', '2022-09-30', 'A Study on the Impact of 731 Factors in SOL', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 19, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 13, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 18, 'Prof. Ali Rodriguez', '2024-05-05', '2024-05-10', '2024-05-11', 
                         '6%', '2024-05-16', '2024-05-25', '2024-05-19', '2024-05-29', '2024-06-02', 
                         '2024-06-01', '2024-06-16', '2024-06-19', '2024-07-16', 'Minor Corrections', '2024-07-23', 
                         1, '133', '485', '391', '94');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800071', 'James Wilson', 'MSc Accounting', 'SOL', 'DBA', 'Cohort 2019', '2019-01-18', 'A Study on the Impact of 654 Factors in SOL', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 7, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 18, 'Prof. Sophia Johnson', '2021-05-04', '2021-05-06', '2021-05-08', 
                         '9%', '2021-05-13', '2021-05-14', '2021-05-16', '2021-05-20', '2021-05-23', 
                         '2021-05-22', '2021-06-06', '2021-06-08', '2021-07-05', 'Major Corrections', '2021-07-06', 
                         0, '133', '426', '465', '92');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2021-10-03', '2021-09-15', 'Verified', 'Dr. Anderson', '2021-07-07', 'Received', 'Received',
                                 '2021-09-16', '2021-09-19', '2021-09-21',
                                 '9%', '2021-09-17', '2021-09-20', '2021-09-18', '2021-09-18', '2021-10-01', '2021-10-05', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2021-09-22', '2021-10-15', 'JIL/2021/7', NULL, 
                             NULL, '2021-10-23', '2021-10-25', '2021-11-02', '2021-10-30', '2021-11-08', '2021-11-03', '2021-11-06');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800072', 'Joseph Lopez', 'MSc Management', 'SOL', 'DBA', 'Cohort 2022', '2022-04-04', 'A Study on the Impact of 468 Factors in SOL', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 10, 13, 'Prof. Ali Wilson', '2024-01-11', '2024-01-14', '2024-01-14', 
                         '16%', '2024-01-19', '2024-01-27', '2024-01-24', '2024-01-31', '2024-02-03', 
                         '2024-02-02', '2024-02-15', '2024-02-20', '2024-03-29', 'Minor Corrections', '2024-03-31', 
                         1, '127', '383', '369', '99');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2024-06-14', '2024-05-04', 'Verified', 'Dr. Thomas', '2024-04-02', 'Received', 'Received',
                                 '2024-05-07', '2024-05-10', '2024-05-12',
                                 '5%', '2024-05-08', '2024-05-11', '2024-05-11', '2024-05-09', '2024-05-19', '2024-05-21', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2024-06-05', '2024-07-12', 'JIL/2024/7', NULL, 
                             NULL, '2024-07-21', '2024-07-24', '2024-08-01', '2024-07-29', '2024-08-06', '2024-08-05', '2024-08-05');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800073', 'Ali Garcia', 'PhD Finance', 'STHEM', 'Masters', 'Cohort 2022', '2022-01-27', 'A Study on the Impact of 223 Factors in STHEM', 'Viva Scheduled');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 9, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`) 
                         VALUES (@student_id, 5, 16, 'Prof. Fatimah Mohammad', '2024-09-09', '2024-09-14', '2024-09-15', 
                         '9%', '2024-09-16', '2024-09-21', '2024-09-21', '2024-09-24', '2024-09-28', 
                         '2024-09-29', '2024-10-17', '2024-10-18', '2024-11-26', NULL);
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800074', 'Fatimah Brown', 'MSc Accounting', 'SOL', 'PhD', 'Cohort 2021', '2021-10-07', 'A Study on the Impact of 650 Factors in SOL', 'Viva Completed');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 19, 'Prof. Kamal Martinez', '2023-08-02', '2023-08-05', '2023-08-07', 
                         '19%', '2023-08-08', '2023-08-12', '2023-08-16', '2023-08-18', '2023-08-19', 
                         '2023-08-22', '2023-09-08', '2023-09-12', '2023-10-16', 'Major Corrections', '2023-10-18', 
                         1, '155', '486', '416', '97');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800075', 'Isabella Abdullah', 'MSc IT', 'SBM', 'Masters', 'Cohort 2020', '2020-07-16', 'A Study on the Impact of 928 Factors in SBM', 'Ready for Senate');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 10, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 7, 12, 'Prof. John Ibrahim', '2022-03-17', '2022-03-21', '2022-03-21', 
                         '16%', '2022-03-24', '2022-03-28', '2022-03-28', '2022-04-01', '2022-04-03', 
                         '2022-04-05', '2022-04-22', '2022-04-23', '2022-05-26', 'Re-viva', '2022-05-31', 
                         0, '108', '431', '383', '83');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2022-07-28', '2022-08-14', 'Verified', 'Dr. Smith', '2022-05-30', 'Received', 'Received',
                                 '2022-08-17', '2022-08-19', '2022-08-21',
                                 '11%', '2022-08-16', '2022-08-19', '2022-08-17', '2022-08-17', '2022-09-02', '2022-09-06', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Pending', 'Ready', NULL, '2022-07-25', '2022-09-11', 'JIL/2022/6', NULL, 
                             NULL, '2022-09-16', '2022-09-17', '2022-09-26', '2022-09-28', '2022-09-29', '2022-09-30', '2022-09-30');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800076', 'Fatimah Ibrahim', 'DBA', 'SOC', 'DBA', 'Cohort 2021', '2021-09-20', 'A Study on the Impact of 747 Factors in SOC', 'Graduated');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 9, 14, 'Prof. Muhammad Miller', '2023-06-13', '2023-06-16', '2023-06-16', 
                         '20%', '2023-06-17', '2023-06-25', '2023-06-18', '2023-06-26', '2023-07-01', 
                         '2023-06-27', '2023-07-07', '2023-07-11', '2023-08-20', 'Minor Corrections', '2023-08-23', 
                         0, '127', '419', '322', '97');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2023-10-24', '2023-10-14', 'Verified', 'Dr. Brown', '2023-08-23', 'Received', 'Received',
                                 '2023-10-16', '2023-10-18', '2023-10-19',
                                 '12%', '2023-10-19', '2023-10-20', '2023-10-20', '2023-10-21', '2023-10-28', '2023-10-29', 'Endorsed');
INSERT INTO `graduation` (`student_id`, `jil_status`, `senate_status`, `graduation_status`, `graduation_date`, `gais_keyin_date`,
                             `jil_meeting_date`, `jil_meeting_no`, `senate_meeting_date`, `senate_meeting_no`, `thesis_certification_date`, 
                             `final_thesis_form_date`, `hard_bound_copies_date`, `loose_copy_date`, `cd_copies_date`, `etd_form_date`, `sent_to_psb_date`) 
                             VALUES (@student_id, 'Approved', 'Approved', 'Graduated', '2024-02-07', '2023-11-02', '2023-11-30', 'JIL/2023/2', '2024-01-04', 
                             'SENATE/2024/7', '2023-12-10', '2023-12-13', '2023-12-26', '2023-12-19', '2023-12-27', '2023-12-19', '2023-12-30');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800077', 'Siti Hassan', 'PhD Finance', 'SBM', 'PhD', 'Cohort 2021', '2021-08-29', 'A Study on the Impact of 138 Factors in SBM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 3, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 14, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 8, 13, 'Prof. Mia Othman', '2023-05-25', '2023-05-28', '2023-05-28', 
                     '6%', '2023-06-01', '2023-06-04', '2023-06-10', '2023-06-19', '2023-06-22', 
                     '2023-06-22');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800078', 'Ali Abdullah', 'DBA', 'STHEM', 'DBA', 'Cohort 2022', '2022-07-14', 'A Study on the Impact of 965 Factors in STHEM', 'Corrections Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                         `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                         `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                         `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`, 
                         `confirm_date_email_date`, `invitation_letter_date`, `viva_date`, `viva_result`, `internal_examiner_report_date`, 
                         `best_thesis_candidate`, `honorarium_chairperson`, `honorarium_internal`, `honorarium_external`, `honorarium_refreshment`) 
                         VALUES (@student_id, 4, 14, 'Prof. Kamal Garcia', '2024-11-07', '2024-11-10', '2024-11-10', 
                         '20%', '2024-11-12', '2024-11-22', '2024-11-13', '2024-11-24', '2024-11-29', 
                         '2024-11-26', '2024-12-08', '2024-12-11', '2025-01-06', 'Minor Corrections', '2025-01-10', 
                         1, '152', '379', '419', '74');
INSERT INTO `corrections` (`student_id`, `correction_required`, `correction_deadline`, `correction_submission_date`, 
                                 `verification_status`, `reviewed_by`, `report_sent_to_student_date`, `internal_report_status`, `external_report_status`,
                                 `corrected_thesis_received_date`, `checklist_after_viva_date`, `correction_schedule_date`,
                                 `post_viva_turnitin_percentage`, `supervisor_endorsement_date`, `sent_to_internal_date`, 
                                 `sent_to_external_date`, `sent_to_supervisor_date`, `endorsement_from_examiner_date`, `abstract_received_date`, `final_result`) 
                                 VALUES (@student_id, 1, '2025-02-25', '2025-02-28', 'In Progress', 'Dr. Davis', '2025-01-11', 'Received', 'Received',
                                 '2025-03-03', '2025-03-05', '2025-03-06',
                                 '2%', '2025-03-02', '2025-03-03', '2025-03-03', '2025-03-05', '2025-03-13', '2025-03-14', 'Endorsed');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800079', 'Daniel Smith', 'MSc IT', 'STHEM', 'DBA', 'Cohort 2020', '2020-06-05', 'A Study on the Impact of 987 Factors in STHEM', 'Examiner Assigned');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 16, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'co');
INSERT INTO `viva_records` (`student_id`, `internal_examiner_id`, `external_examiner_id`, `chairperson_name`, 
                     `thesis_submission_email_date`, `draft_hard_copy_date`, `draft_soft_copy_date`, `turnitin_percentage`, 
                     `draft_submission_form_date`, `internal_examiner_email_date`, `external_examiner_email_date`, 
                     `panel_appointment_letter_date`, `thesis_to_panel_hard_copy_date`, `thesis_to_panel_soft_copy_date`) 
                     VALUES (@student_id, 8, 15, 'Prof. Aminah Mohammad', '2022-10-25', '2022-10-27', '2022-10-28', 
                     '8%', '2022-10-31', '2022-11-01', '2022-11-01', '2022-11-05', '2022-11-08', 
                     '2022-11-08');
INSERT INTO `students` (`matric_no`, `name`, `programme`, `school`, `degree_level`, `cohort`, `its_receipt_date`, `thesis_title`, `research_status`) VALUES ('800080', 'Mia Othman', 'MSc IT', 'SOC', 'DBA', 'Cohort 2023', '2023-10-01', 'A Study on the Impact of 156 Factors in SOC', 'Thesis Submitted');
SET @student_id = LAST_INSERT_ID();
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 20, 'main');
INSERT INTO `student_supervisors` (`student_id`, `supervisor_id`, `role`) VALUES (@student_id, 18, 'co');
