<?php
namespace App\Models;

use App\Core\Database;

class Correction
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createOrUpdate(int $studentId, array $data): bool
    {
        $this->db->query('SELECT correction_id FROM corrections WHERE student_id = :id LIMIT 1');
        $this->db->bind(':id', $studentId);
        $existing = $this->db->single();

        $fields = [
            'correction_required' => 'correction_required',
            'correction_deadline' => 'correction_deadline',
            'correction_submission_date' => 'correction_submission_date',
            'verification_status' => 'verification_status',
            'reviewed_by' => 'reviewed_by',
            'report_sent_to_student_date' => 'report_sent_to_student_date',
            'internal_report_status' => 'internal_report_status',
            'external_report_status' => 'external_report_status',
            'corrected_thesis_received_date' => 'corrected_thesis_received_date',
            'checklist_after_viva_date' => 'checklist_after_viva_date',
            'correction_schedule_date' => 'correction_schedule_date',
            'post_viva_turnitin_percentage' => 'post_viva_turnitin_percentage',
            'supervisor_endorsement_date' => 'supervisor_endorsement_date',
            'sent_to_internal_date' => 'sent_to_internal_date',
            'sent_to_external_date' => 'sent_to_external_date',
            'sent_to_supervisor_date' => 'sent_to_supervisor_date',
            'endorsement_from_examiner_date' => 'endorsement_from_examiner_date',
            'abstract_received_date' => 'abstract_received_date',
            'final_result' => 'final_result'
        ];

        if ($existing) {
            $setClauses = [];
            foreach ($fields as $dbCol => $dataKey) {
                $setClauses[] = "$dbCol = :$dbCol";
            }
            $setString = implode(', ', $setClauses);
            $this->db->query("UPDATE corrections SET $setString WHERE student_id = :id");
        } else {
            $cols = implode(', ', array_keys($fields));
            $vals = implode(', ', array_map(fn($col) => ":$col", array_keys($fields)));
            $this->db->query("INSERT INTO corrections (student_id, $cols) VALUES (:id, $vals)");
        }

        $this->db->bind(':id', $studentId);
        foreach ($fields as $dbCol => $dataKey) {
            $val = $data[$dataKey] ?? null;
            if ($val === '') $val = null;
            
            // Handle special cases.
            // M9: Always derive correction_required from whether a deadline exists,
            // since the form never sends this field explicitly.
            if ($dbCol === 'correction_required') {
                $val = !empty($data['correction_deadline']) ? 1 : 0;
            }
            if ($dbCol === 'verification_status') $val = $val ?? 'Pending';
            
            $this->db->bind(":$dbCol", $val);
        }

        return $this->db->execute();
    }
}
