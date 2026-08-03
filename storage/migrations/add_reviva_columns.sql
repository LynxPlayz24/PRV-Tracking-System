ALTER TABLE `viva_records`
    ADD COLUMN `reviva_internal_examiner_id` INT NULL DEFAULT NULL AFTER `honorarium_refreshment`,
    ADD COLUMN `reviva_external_examiner_id` INT NULL DEFAULT NULL AFTER `reviva_internal_examiner_id`,
    ADD COLUMN `reviva_panel_appointment_letter_date` DATE NULL DEFAULT NULL AFTER `reviva_external_examiner_id`,
    ADD COLUMN `reviva_thesis_to_panel_hard_copy_date` DATE NULL DEFAULT NULL AFTER `reviva_panel_appointment_letter_date`,
    ADD COLUMN `reviva_thesis_to_panel_soft_copy_date` DATE NULL DEFAULT NULL AFTER `reviva_thesis_to_panel_hard_copy_date`,
    ADD COLUMN `reviva_confirm_date_email_date` DATE NULL DEFAULT NULL AFTER `reviva_thesis_to_panel_soft_copy_date`,
    ADD COLUMN `reviva_invitation_letter_date` DATE NULL DEFAULT NULL AFTER `reviva_confirm_date_email_date`,
    ADD COLUMN `reviva_date` DATE NULL DEFAULT NULL AFTER `reviva_invitation_letter_date`,
    ADD COLUMN `reviva_chairperson_name` VARCHAR(255) NULL DEFAULT NULL AFTER `reviva_date`,
    ADD COLUMN `reviva_result` VARCHAR(255) NULL DEFAULT NULL AFTER `reviva_chairperson_name`;
