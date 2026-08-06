<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Supervisor;
use App\Models\Examiner;
use App\Models\Chairperson;

class StaffController extends Controller
{
    private Supervisor $supervisorModel;
    private Examiner $examinerModel;
    private Chairperson $chairpersonModel;

    public function __construct()
    {
        $this->supervisorModel = new Supervisor();
        $this->examinerModel = new Examiner();
        $this->chairpersonModel = new Chairperson();
    }

    public function manage(): void
    {
        Middleware::requireAdmin();

        $this->generateCsrfToken();

        $data = [
            'pageTitle'     => 'Academic Staff',
            'currentPage'   => 'staff',
            'supervisors'   => $this->supervisorModel->getAll(),
            'examiners'     => $this->examinerModel->getAll(),
            'chairpersons'  => $this->chairpersonModel->getAll(),
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('staff.manage', $data);
        $this->view('layouts.footer', $data);
    }

    // --- SUPERVISORS ---

    public function storeSupervisor(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        $data = [
            'supervisor_name' => strtoupper(trim($this->input('supervisor_name', ''))),
            'email'           => trim($this->input('email', '')),
            'phone'           => trim($this->input('phone', '')),
            'department'      => trim($this->input('department', '')),
        ];

        if (empty($data['supervisor_name'])) {
            $this->setFlash('danger', 'Supervisor name is required.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->supervisorModel->create($data)) {
            $this->setFlash('success', 'Supervisor added successfully.');
        } else {
            $this->setFlash('danger', 'Failed to add supervisor.');
        }

        $this->redirect($this->baseUrl() . '/staff');
    }



    public function updateSupervisor(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        $data = [
            'supervisor_name' => strtoupper(trim($this->input('supervisor_name', ''))),
            'email'           => trim($this->input('email', '')),
            'phone'           => trim($this->input('phone', '')),
            'department'      => trim($this->input('department', '')),
        ];

        if (empty($data['supervisor_name'])) {
            $this->setFlash('danger', 'Supervisor name is required.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->supervisorModel->update((int)$id, $data)) {
            $this->setFlash('success', 'Supervisor updated successfully.');
        } else {
            $this->setFlash('danger', 'Failed to update supervisor.');
        }

        $this->redirect($this->baseUrl() . '/staff');
    }

    public function deleteSupervisor(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->supervisorModel->delete((int)$id)) {
            $this->setFlash('success', 'Supervisor deleted successfully.');
        } else {
            $this->setFlash('danger', 'Failed to delete supervisor.');
        }

        $this->redirect($this->baseUrl() . '/staff');
    }

    // --- EXAMINERS ---

    public function storeExaminer(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        $data = [
            'examiner_name'  => strtoupper(trim($this->input('examiner_name', ''))),
            'email'          => trim($this->input('email', '')),
            'phone'          => trim($this->input('phone', '')),
            'institution'    => trim($this->input('institution', '')),
            'classification' => trim($this->input('classification', 'Internal')),
        ];

        if (empty($data['examiner_name'])) {
            $this->setFlash('danger', 'Examiner name is required.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->examinerModel->create($data)) {
            $this->setFlash('success', 'Examiner added successfully.');
        } else {
            $this->setFlash('danger', 'Failed to add examiner.');
        }

        $this->redirect($this->baseUrl() . '/staff#examiners');
    }

    public function updateExaminer(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        $data = [
            'examiner_name'  => strtoupper(trim($this->input('examiner_name', ''))),
            'email'          => trim($this->input('email', '')),
            'phone'          => trim($this->input('phone', '')),
            'institution'    => trim($this->input('institution', '')),
            'classification' => trim($this->input('classification', 'Internal')),
        ];

        if (empty($data['examiner_name'])) {
            $this->setFlash('danger', 'Examiner name is required.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->examinerModel->update((int)$id, $data)) {
            $this->setFlash('success', 'Examiner updated successfully.');
        } else {
            $this->setFlash('danger', 'Failed to update examiner.');
        }

        $this->redirect($this->baseUrl() . '/staff#examiners');
    }

    public function deleteExaminer(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->examinerModel->delete((int)$id)) {
            $this->setFlash('success', 'Examiner deleted successfully.');
        } else {
            $this->setFlash('danger', 'Failed to delete examiner.');
        }

        $this->redirect($this->baseUrl() . '/staff#examiners');
    }

    // --- CHAIRPERSONS ---

    public function storeChairperson(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        $data = [
            'chairperson_name' => trim($this->input('chairperson_name', '')),
            'email'            => trim($this->input('email', '')),
            'phone'            => trim($this->input('phone', '')),
            'department'       => trim($this->input('department', '')),
        ];

        if (empty($data['chairperson_name'])) {
            $this->setFlash('danger', 'Chairperson name is required.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->chairpersonModel->create($data)) {
            $this->setFlash('success', 'Chairperson added successfully.');
        } else {
            $this->setFlash('danger', 'Failed to add chairperson.');
        }

        $this->redirect($this->baseUrl() . '/staff#chairpersons');
    }

    public function updateChairperson(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        $data = [
            'chairperson_name' => trim($this->input('chairperson_name', '')),
            'email'            => trim($this->input('email', '')),
            'phone'            => trim($this->input('phone', '')),
            'department'       => trim($this->input('department', '')),
        ];

        if (empty($data['chairperson_name'])) {
            $this->setFlash('danger', 'Chairperson name is required.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->chairpersonModel->update((int)$id, $data)) {
            $this->setFlash('success', 'Chairperson updated successfully.');
        } else {
            $this->setFlash('danger', 'Failed to update chairperson.');
        }

        $this->redirect($this->baseUrl() . '/staff#chairpersons');
    }

    public function deleteChairperson(string $id): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->setFlash('danger', 'Invalid request.');
            $this->redirect($this->baseUrl() . '/staff');
            return;
        }

        if ($this->chairpersonModel->delete((int)$id)) {
            $this->setFlash('success', 'Chairperson deleted successfully.');
        } else {
            $this->setFlash('danger', 'Failed to delete chairperson.');
        }

        $this->redirect($this->baseUrl() . '/staff#chairpersons');
    }

    // --- AJAX APIs (No Redirection) ---

    public function apiStoreSupervisor(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 400);
            return;
        }

        $data = [
            'supervisor_name' => strtoupper(trim($this->input('supervisor_name', ''))),
            'email'           => trim($this->input('email', '')),
            'phone'           => trim($this->input('phone', '')),
            'department'      => trim($this->input('department', '')),
        ];

        if (empty($data['supervisor_name'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Supervisor name is required.'], 400);
            return;
        }

        $newId = $this->supervisorModel->create($data);
        if ($newId) {
            $this->jsonResponse([
                'success'        => true,
                'id'             => $newId,
                'name'           => $data['supervisor_name'],
                'new_csrf_token' => $this->generateCsrfToken(),
                'message'        => 'Supervisor added successfully.'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to add supervisor.'], 500);
        }
    }

    public function apiStoreExaminer(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 400);
            return;
        }

        $data = [
            'examiner_name'  => strtoupper(trim($this->input('examiner_name', ''))),
            'email'          => trim($this->input('email', '')),
            'phone'          => trim($this->input('phone', '')),
            'institution'    => trim($this->input('institution', '')),
            'classification' => trim($this->input('classification', 'Internal')),
        ];

        if (empty($data['examiner_name'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Examiner name is required.'], 400);
            return;
        }

        $newId = $this->examinerModel->create($data);
        if ($newId) {
            $this->jsonResponse([
                'success'        => true,
                'id'             => $newId,
                'name'           => $data['examiner_name'],
                'classification' => $data['classification'],
                'new_csrf_token' => $this->generateCsrfToken(),
                'message'        => 'Examiner added successfully.'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to add examiner.'], 500);
        }
    }

    public function apiStoreChairperson(): void
    {
        Middleware::requireAdmin();

        if (!$this->validateCsrfToken()) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 400);
            return;
        }

        $data = [
            'chairperson_name' => trim($this->input('chairperson_name', '')),
            'email'            => trim($this->input('email', '')),
            'phone'            => trim($this->input('phone', '')),
            'department'       => trim($this->input('department', '')),
        ];

        if (empty($data['chairperson_name'])) {
            $this->jsonResponse(['success' => false, 'message' => 'Chairperson name is required.'], 400);
            return;
        }

        $newId = $this->chairpersonModel->create($data);
        if ($newId) {
            $this->jsonResponse([
                'success'        => true,
                'id'             => $newId,
                'name'           => $data['chairperson_name'],
                'new_csrf_token' => $this->generateCsrfToken(),
                'message'        => 'Chairperson added successfully.'
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Failed to add chairperson.'], 500);
        }
    }
}

