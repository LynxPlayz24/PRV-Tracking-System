<?php
namespace App\Models;

use App\Core\Database;

class VivaRecord
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createOrUpdate(int $studentId, array $data): bool
    {
        $this->db->query('SELECT viva_id FROM viva_records WHERE student_id = :id LIMIT 1');
        $this->db->bind(':id', $studentId);
        $existing = $this->db->single();

        $fields = [
            'internal_examiner_id' => 'internal_examiner_id',
            'external_examiner_id' => 'external_examiner_id',
            'chairperson_name' => 'chairperson_name',
            'thesis_submission_email_date' => 'thesis_submission_email_date',
            'draft_hard_copy_date' => 'draft_hard_copy_date',
            'draft_soft_copy_date' => 'draft_soft_copy_date',
            'turnitin_percentage' => 'turnitin_percentage',
            'draft_submission_form_date' => 'draft_submission_form_date',
            'internal_examiner_email_date' => 'internal_examiner_email_date',
            'internal_examiner_status' => 'internal_examiner_status',
            'external_examiner_email_date' => 'external_examiner_email_date',
            'external_examiner_status' => 'external_examiner_status',
            'panel_appointment_letter_date' => 'panel_appointment_letter_date',
            'thesis_to_panel_hard_copy_date' => 'thesis_to_panel_hard_copy_date',
            'thesis_to_panel_soft_copy_date' => 'thesis_to_panel_soft_copy_date',
            'confirm_date_email_date' => 'confirm_date_email_date',
            'invitation_letter_date' => 'invitation_letter_date',
            'viva_date' => 'viva_date',
            'viva_result' => 'viva_result',
            'internal_examiner_report_date' => 'internal_examiner_report_date',
            'best_thesis_candidate' => 'best_thesis_candidate',
            'honorarium_chairperson' => 'honorarium_chairperson',
            'honorarium_internal' => 'honorarium_internal',
            'honorarium_external' => 'honorarium_external',
            'honorarium_refreshment' => 'honorarium_refreshment',
            // Re-viva fields
            'reviva_internal_examiner_id' => 'reviva_internal_examiner_id',
            'reviva_external_examiner_id' => 'reviva_external_examiner_id',
            'reviva_panel_appointment_letter_date' => 'reviva_panel_appointment_letter_date',
            'reviva_thesis_to_panel_hard_copy_date' => 'reviva_thesis_to_panel_hard_copy_date',
            'reviva_thesis_to_panel_soft_copy_date' => 'reviva_thesis_to_panel_soft_copy_date',
            'reviva_confirm_date_email_date' => 'reviva_confirm_date_email_date',
            'reviva_invitation_letter_date' => 'reviva_invitation_letter_date',
            'reviva_date' => 'reviva_date',
            'reviva_chairperson_name' => 'reviva_chairperson_name',
            'reviva_result' => 'reviva_result',
        ];

        if ($existing) {
            $setClauses = [];
            foreach ($fields as $dbCol => $dataKey) {
                $setClauses[] = "$dbCol = :$dbCol";
            }
            $setString = implode(', ', $setClauses);
            $this->db->query("UPDATE viva_records SET $setString WHERE student_id = :id");
        } else {
            $cols = implode(', ', array_keys($fields));
            $vals = implode(', ', array_map(fn($col) => ":$col", array_keys($fields)));
            $this->db->query("INSERT INTO viva_records (student_id, $cols) VALUES (:id, $vals)");
        }

        $this->db->bind(':id', $studentId);
        foreach ($fields as $dbCol => $dataKey) {
            $val = $data[$dataKey] ?? null;
            if ($val === '') $val = null;
            // Checkboxes: unchecked = absent from POST. Ensure 0 not null for tinyint.
            if ($dbCol === 'best_thesis_candidate') {
                $val = isset($data[$dataKey]) && $data[$dataKey] ? 1 : 0;
            }
            $this->db->bind(":$dbCol", $val);
        }

        return $this->db->execute();
    }
}
