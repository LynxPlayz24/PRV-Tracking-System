<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\Supervisor;
use App\Models\Examiner;

class StaffController extends Controller
{
    private Supervisor $supervisorModel;
    private Examiner $examinerModel;

    public function __construct()
    {
        $this->supervisorModel = new Supervisor();
        $this->examinerModel = new Examiner();
    }

    public function manage(): void
    {
        Middleware::requireAdmin();

        $this->generateCsrfToken();

        $data = [
            'pageTitle'   => 'Academic Staff',
            'currentPage' => 'staff',
            'supervisors' => $this->supervisorModel->getAll(),
            'examiners'   => $this->examinerModel->getAll(),
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
            'supervisor_name' => trim($this->input('supervisor_name', '')),
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
            'supervisor_name' => trim($this->input('supervisor_name', '')),
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
            'examiner_name'  => trim($this->input('examiner_name', '')),
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
            'examiner_name'  => trim($this->input('examiner_name', '')),
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
}
