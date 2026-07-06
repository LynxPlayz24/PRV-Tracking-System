<?php
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;

$file = 'prv_records.xlsx';
$spreadsheet = IOFactory::load($file);
$worksheet = $spreadsheet->getActiveSheet();
$rows = $worksheet->toArray();

$headerRow = null;
$secondHeaderRow = null;
foreach ($rows as $index => $row) {
    $rowString = strtolower(implode(' ', array_map('strval', $row)));
    if (str_contains($rowString, 'nama pelajar')) {
        $headerRow = $row;
        $secondHeaderRow = $rows[$index + 1] ?? [];
        break;
    }
}

// Concatenate rows
$combinedHeader = [];
foreach ($headerRow as $i => $col) {
    $col1 = trim(strval($col));
    $col2 = trim(strval($secondHeaderRow[$i] ?? ''));
    $combinedHeader[$i] = trim($col1 . ' ' . $col2);
}


function mapHeaders(array $header): array
{
    $map = [
        'matric_no' => -1, 'name' => -1, 'programme' => -1, 'school' => -1, 'degree_level' => -1, 
        'thesis_title' => -1, 'cohort' => -1, 'its_receipt_date' => -1,
        'supervisor_1' => -1, 'supervisor_2' => -1, 'supervisor_3' => -1,
        'jil_meeting_date' => -1, 'thesis_submission_email_date' => -1, 'draft_hard_copy_date' => -1,
        'draft_soft_copy_date' => -1, 'turnitin_percentage' => -1, 'draft_submission_form_date' => -1,
        'internal_examiner_email_date' => -1, 'external_examiner_email_date' => -1, 'panel_appointment_letter_date' => -1,
        'thesis_to_panel_hard_copy_date' => -1, 'thesis_to_panel_soft_copy_date' => -1, 'confirm_date_email_date' => -1,
        'invitation_letter_date' => -1, 'viva_date' => -1, 'chairperson_name' => -1, 'internal_examiner_name' => -1,
        'internal_examiner_report_date' => -1, 'external_examiner_name' => -1, 'viva_result' => -1,
        'correction_deadline' => -1, 'reviewed_by' => -1, 'best_thesis_candidate' => -1, 'report_sent_to_student_date' => -1,
        'internal_report_status' => -1, 'external_report_status' => -1, 'honorarium_chairperson' => -1,
        'honorarium_internal' => -1, 'honorarium_external' => -1, 'honorarium_refreshment' => -1,
        'corrected_thesis_received_date' => -1, 'checklist_after_viva_date' => -1, 'correction_schedule_date' => -1,
        'post_viva_turnitin_percentage' => -1, 'supervisor_endorsement_date' => -1, 'sent_to_internal_date' => -1,
        'sent_to_external_date' => -1, 'sent_to_supervisor_date' => -1, 'endorsement_from_examiner_date' => -1,
        'abstract_received_date' => -1, 'final_result' => -1, 'gais_keyin_date' => -1, 'senate_meeting_date' => -1,
        'senate_status' => -1, 'thesis_certification_date' => -1, 'final_thesis_form_date' => -1, 
        'hard_bound_copies_date' => -1, 'loose_copy_date' => -1, 'cd_copies_date' => -1, 'etd_form_date' => -1,
        'sent_to_psb_date' => -1, 'graduation_date' => -1
    ];

    foreach ($header as $index => $colName) {
        if (!is_string($colName)) continue;
        $col = strtolower(trim(str_replace(["\n", "\r"], ' ', $colName)));

        // 1. Student Info
        if ($map['matric_no'] === -1 && (str_contains($col, 'matrik') || str_contains($col, 'matric'))) $map['matric_no'] = $index;
        elseif ($map['name'] === -1 && (str_contains($col, 'nama pelajar') || str_contains($col, 'student name'))) $map['name'] = $index;
        elseif ($map['programme'] === -1 && str_contains($col, 'program')) $map['programme'] = $index;
        elseif ($map['school'] === -1 && (str_contains($col, 'school') || str_contains($col, 'pengajian'))) $map['school'] = $index;
        elseif ($map['degree_level'] === -1 && (str_contains($col, 'level of degree') || str_contains($col, 'degree'))) $map['degree_level'] = $index;
        elseif ($map['thesis_title'] === -1 && (str_contains($col, 'tajuk') || str_contains($col, 'title'))) $map['thesis_title'] = $index;
        elseif ($map['cohort'] === -1 && (str_contains($col, 'cohort') || str_contains($col, 'thesis/cohort'))) $map['cohort'] = $index;

        // 2. Supervision
        elseif ($map['its_receipt_date'] === -1 && (str_contains($col, 'penerimaan its') || str_contains($col, 'tarikh penerimaan its'))) $map['its_receipt_date'] = $index;
        elseif ($map['supervisor_1'] === -1 && (str_contains($col, 'penyelia 1') || str_contains($col, 'main supervisor'))) $map['supervisor_1'] = $index;
        elseif ($map['supervisor_2'] === -1 && (str_contains($col, 'penyelia 2') || str_contains($col, 'co-supervisor 1'))) $map['supervisor_2'] = $index;
        elseif ($map['supervisor_3'] === -1 && (str_contains($col, 'penyelia 3') || str_contains($col, 'co-supervisor 2'))) $map['supervisor_3'] = $index;
        elseif ($map['jil_meeting_date'] === -1 && (str_contains($col, 'mesyuarat jil') || str_contains($col, 'bil. jil'))) $map['jil_meeting_date'] = $index;
        elseif ($map['thesis_submission_email_date'] === -1 && str_contains($col, 'emel thesis submission')) $map['thesis_submission_email_date'] = $index;
        elseif ($map['draft_hard_copy_date'] === -1 && str_contains($col, '4 hard copy')) $map['draft_hard_copy_date'] = $index;
        elseif ($map['draft_soft_copy_date'] === -1 && (str_contains($col, 'soft copy') && !str_contains($col, 'panel'))) $map['draft_soft_copy_date'] = $index;
        elseif ($map['turnitin_percentage'] === -1 && (str_contains($col, 'turnitin (%)') && !str_contains($col, 'selepas'))) $map['turnitin_percentage'] = $index;
        elseif ($map['draft_submission_form_date'] === -1 && str_contains($col, 'borang submission of draft')) $map['draft_submission_form_date'] = $index;

        // 3. Panel & Viva
        elseif ($map['internal_examiner_email_date'] === -1 && (str_contains($col, 'pemeriksa dalam') && str_contains($col, 'persetujuan'))) $map['internal_examiner_email_date'] = $index;
        elseif ($map['external_examiner_email_date'] === -1 && (str_contains($col, 'pemeriksa luar') && str_contains($col, 'persetujuan'))) $map['external_examiner_email_date'] = $index;
        elseif ($map['panel_appointment_letter_date'] === -1 && str_contains($col, 'surat pelantikan panel')) $map['panel_appointment_letter_date'] = $index;
        elseif ($map['thesis_to_panel_hard_copy_date'] === -1 && (str_contains($col, 'hard copy') && str_contains($col, 'panel'))) $map['thesis_to_panel_hard_copy_date'] = $index;
        elseif ($map['thesis_to_panel_soft_copy_date'] === -1 && str_contains($col, 'soft copy')) $map['thesis_to_panel_soft_copy_date'] = $index; // Fallback for 2nd soft copy
        elseif ($map['confirm_date_email_date'] === -1 && str_contains($col, 'confirm tarikh')) $map['confirm_date_email_date'] = $index;
        elseif ($map['invitation_letter_date'] === -1 && str_contains($col, 'surat jemputan')) $map['invitation_letter_date'] = $index;
        elseif ($map['viva_date'] === -1 && (str_contains($col, 'tarikh viva-voce') || str_contains($col, 'viva date') || str_contains($col, 'tarkh viva-voce'))) $map['viva_date'] = $index;
        elseif ($map['chairperson_name'] === -1 && (str_contains($col, 'nama pengerusi') || str_contains($col, 'chairperson'))) $map['chairperson_name'] = $index;
        elseif ($map['internal_examiner_name'] === -1 && (str_contains($col, 'nama pemeriksa dalam') && !str_contains($col, 'penilaian'))) $map['internal_examiner_name'] = $index;
        elseif ($map['internal_examiner_report_date'] === -1 && str_contains($col, 'laporan penilaian pemeriksa dalam')) $map['internal_examiner_report_date'] = $index;
        elseif ($map['external_examiner_name'] === -1 && str_contains($col, 'nama pemeriksa luar')) $map['external_examiner_name'] = $index;
        elseif ($map['viva_result'] === -1 && (str_contains($col, 'keputusan') && !str_contains($col, 'akhir') && !str_contains($col, 'jil') && !str_contains($col, 'senat'))) $map['viva_result'] = $index;

        // 4. Post-Viva
        elseif ($map['correction_deadline'] === -1 && str_contains($col, 'tarikh akhir pembetulan')) $map['correction_deadline'] = $index;
        elseif ($map['reviewed_by'] === -1 && str_contains($col, 'semakan pembetulan oleh')) $map['reviewed_by'] = $index;
        elseif ($map['best_thesis_candidate'] === -1 && str_contains($col, 'calon tesis terbaik')) $map['best_thesis_candidate'] = $index;
        elseif ($map['report_sent_to_student_date'] === -1 && str_contains($col, 'hantar laporan pemeriksaan')) $map['report_sent_to_student_date'] = $index;
        elseif ($map['internal_report_status'] === -1 && (str_contains($col, 'laporan pemeriksa dalam') && !str_contains($col, 'nama') && !str_contains($col, 'tarikh'))) $map['internal_report_status'] = $index;
        elseif ($map['external_report_status'] === -1 && (str_contains($col, 'laporan pemeriksa luar') && !str_contains($col, 'nama') && !str_contains($col, 'tarikh'))) $map['external_report_status'] = $index;
        elseif ($map['honorarium_chairperson'] === -1 && str_contains($col, 'chairperson')) $map['honorarium_chairperson'] = $index; // Row 2 header
        elseif ($map['honorarium_internal'] === -1 && (str_contains($col, 'honorarium') && str_contains($col, 'dalam'))) $map['honorarium_internal'] = $index;
        elseif ($map['honorarium_external'] === -1 && str_contains($col, 'pemeriksa luar') && $index > $map['honorarium_internal']) $map['honorarium_external'] = $index; // Row 2 header after internal
        elseif ($map['honorarium_refreshment'] === -1 && (str_contains($col, 'refreshment') || str_contains($col, 'bayaran t&t'))) $map['honorarium_refreshment'] = $index;

        // 5. Corrected Thesis
        elseif ($map['corrected_thesis_received_date'] === -1 && (str_contains($col, 'tesis pembetulan') && !str_contains($col, 'penghantaran'))) $map['corrected_thesis_received_date'] = $index;
        elseif ($map['checklist_after_viva_date'] === -1 && str_contains($col, 'checklist after viva')) $map['checklist_after_viva_date'] = $index;
        elseif ($map['correction_schedule_date'] === -1 && str_contains($col, 'jadual pembetulan')) $map['correction_schedule_date'] = $index;
        elseif ($map['post_viva_turnitin_percentage'] === -1 && (str_contains($col, 'turnitin') && str_contains($col, 'berkaitan'))) $map['post_viva_turnitin_percentage'] = $index;
        elseif ($map['supervisor_endorsement_date'] === -1 && str_contains($col, 'pengesahan pembetulan oleh penyelia')) $map['supervisor_endorsement_date'] = $index;
        elseif ($map['sent_to_internal_date'] === -1 && (str_contains($col, 'penghantaran') && str_contains($col, 'pemeriksa dalam'))) $map['sent_to_internal_date'] = $index;
        elseif ($map['sent_to_external_date'] === -1 && str_contains($col, 'pemeriksa luar') && $index > $map['sent_to_internal_date']) $map['sent_to_external_date'] = $index; // Following internal
        elseif ($map['sent_to_supervisor_date'] === -1 && str_contains($col, 'penyelia') && $index > $map['sent_to_internal_date']) $map['sent_to_supervisor_date'] = $index; // Following internal
        elseif ($map['endorsement_from_examiner_date'] === -1 && str_contains($col, 'pengesahan pembetulan dari pemeriksa')) $map['endorsement_from_examiner_date'] = $index;
        elseif ($map['abstract_received_date'] === -1 && str_contains($col, 'abstrak')) $map['abstract_received_date'] = $index;
        elseif ($map['final_result'] === -1 && str_contains($col, 'keputusan akhir')) $map['final_result'] = $index;

        // 6. Graduation
        elseif ($map['gais_keyin_date'] === -1 && str_contains($col, 'gais')) $map['gais_keyin_date'] = $index;
        elseif ($map['senate_meeting_date'] === -1 && str_contains($col, 'kemasukan ke senat')) $map['senate_meeting_date'] = $index;
        elseif ($map['senate_status'] === -1 && str_contains($col, 'keputusan senat')) $map['senate_status'] = $index;
        elseif ($map['thesis_certification_date'] === -1 && str_contains($col, 'perakuan tesis')) $map['thesis_certification_date'] = $index;
        elseif ($map['final_thesis_form_date'] === -1 && str_contains($col, 'final thesis form')) $map['final_thesis_form_date'] = $index;
        elseif ($map['hard_bound_copies_date'] === -1 && (str_contains($col, 'bound') || str_contains($col, 'hard binding'))) $map['hard_bound_copies_date'] = $index;
        elseif ($map['loose_copy_date'] === -1 && str_contains($col, 'loose copy')) $map['loose_copy_date'] = $index;
        elseif ($map['cd_copies_date'] === -1 && str_contains($col, 'cd')) $map['cd_copies_date'] = $index;
        elseif ($map['etd_form_date'] === -1 && str_contains($col, 'etd form')) $map['etd_form_date'] = $index;
        elseif ($map['sent_to_psb_date'] === -1 && str_contains($col, 'hantar ke psb')) $map['sent_to_psb_date'] = $index;
        elseif ($map['graduation_date'] === -1 && str_contains($col, 'tarikh graduasi')) $map['graduation_date'] = $index;
    }
    return $map;
}

$map = mapHeaders($combinedHeader);

// Check if any mapping is -1 (missing)
$missing = [];
foreach ($map as $key => $index) {
    if ($index === -1) {
        $missing[] = $key;
    } else {
        echo str_pad($key, 35) . " => Found at Col $index ({$combinedHeader[$index]})\n";
    }
}

echo "\n--- ALL HEADERS ---\n";
foreach ($combinedHeader as $i => $h) {
    if (!empty(trim($h))) {
        echo "[$i] $h\n";
    }
}


if (!empty($missing)) {
    echo "\nWARNING! The following fields could NOT be mapped:\n";
    foreach ($missing as $m) {
        echo "- $m\n";
    }
} else {
    echo "\nAll fields mapped successfully!\n";
}
