<?php
namespace App\Models;

use App\Core\Database;

class Graduation
{
    private Database $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function createOrUpdate(int $studentId, array $data): bool
    {
        $this->db->query('SELECT graduation_id FROM graduation WHERE student_id = :id LIMIT 1');
        $this->db->bind(':id', $studentId);
        $existing = $this->db->single();

        $fields = [
            'jil_status' => 'jil_status',
            'senate_status' => 'senate_status',
            'graduation_status' => 'graduation_status',
            'graduation_date' => 'graduation_date',
            'gais_keyin_date' => 'gais_keyin_date',
            'jil_meeting_date' => 'jil_meeting_date',
            'jil_meeting_no' => 'jil_meeting_no',
            'senate_meeting_date' => 'senate_meeting_date',
            'senate_meeting_no' => 'senate_meeting_no',
            'thesis_certification_date' => 'thesis_certification_date',
            'final_thesis_form_date' => 'final_thesis_form_date',
            'hard_bound_copies_date' => 'hard_bound_copies_date',
            'loose_copy_date' => 'loose_copy_date',
            'cd_copies_date' => 'cd_copies_date',
            'etd_form_date' => 'etd_form_date',
            'sent_to_psb_date' => 'sent_to_psb_date'
        ];

        if ($existing) {
            $setClauses = [];
            foreach ($fields as $dbCol => $dataKey) {
                $setClauses[] = "$dbCol = :$dbCol";
            }
            $setString = implode(', ', $setClauses);
            $this->db->query("UPDATE graduation SET $setString WHERE student_id = :id");
        } else {
            $cols = implode(', ', array_keys($fields));
            $vals = implode(', ', array_map(fn($col) => ":$col", array_keys($fields)));
            $this->db->query("INSERT INTO graduation (student_id, $cols) VALUES (:id, $vals)");
        }

        $this->db->bind(':id', $studentId);
        foreach ($fields as $dbCol => $dataKey) {
            $val = $data[$dataKey] ?? null;
            if ($val === '') $val = null;

            if ($dbCol === 'jil_status') $val = $val ?? 'Pending';
            if ($dbCol === 'senate_status') $val = $val ?? 'Pending';
            if ($dbCol === 'graduation_status') $val = $val ?? 'Not Ready';
            
            $this->db->bind(":$dbCol", $val);
        }

        return $this->db->execute();
    }
}
