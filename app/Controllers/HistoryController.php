<?php
namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middleware;
use App\Models\AuditLog;

/**
 * HistoryController
 * Handles displaying and inspecting the audit logs / history trails.
 */
class HistoryController extends Controller
{
    private AuditLog $auditModel;

    public function __construct()
    {
        $this->auditModel = new AuditLog();
    }

    /**
     * Display Audit Logs page
     */
    public function index(): void
    {
        Middleware::requireAdmin();

        $page = max(1, (int)$this->param('page', 1));
        $limit = 25;
        $offset = ($page - 1) * $limit;

        $filters = [
            'keyword'   => trim((string)$this->param('keyword', '')),
            'module'    => trim((string)$this->param('module', '')),
            'action'    => trim((string)$this->param('action', '')),
            'date_from' => trim((string)$this->param('date_from', '')),
            'date_to'   => trim((string)$this->param('date_to', '')),
        ];

        // Clean empty filters
        $activeFilters = array_filter($filters, fn($v) => $v !== '');

        $logs       = $this->auditModel->getFiltered($activeFilters, $limit, $offset);
        $totalLogs  = $this->auditModel->countFiltered($activeFilters);
        $totalPages = (int)ceil($totalLogs / $limit);
        $stats      = $this->auditModel->getStats();
        $modules    = $this->auditModel->getDistinctModules();
        $actions    = $this->auditModel->getDistinctActions();

        $data = [
            'pageTitle'     => 'Audit History & Activity Logs',
            'currentPage'   => 'history',
            'logs'          => $logs,
            'totalLogs'     => $totalLogs,
            'page'          => $page,
            'totalPages'    => $totalPages,
            'limit'         => $limit,
            'filters'       => $filters,
            'stats'         => $stats,
            'modules'       => $modules,
            'actions'       => $actions,
            'baseUrl'       => rtrim($_ENV['APP_URL'] ?? '', '/'),
            'extraScripts'  => ['history-filter.js'],
        ];

        $this->view('layouts.header', $data);
        $this->view('layouts.sidebar', $data);
        $this->view('history.index', $data);
        $this->view('layouts.footer', $data);
    }

    /**
     * API endpoint to get detailed audit diff for modal
     */
    public function apiDetail(string $id): void
    {
        Middleware::requireAdmin();

        $log = $this->auditModel->getById((int)$id);

        if (!$log) {
            $this->jsonResponse(['success' => false, 'message' => 'Log entry not found'], 404);
            return;
        }

        $oldValues = $log['old_values'] ? json_decode($log['old_values'], true) : null;
        $newValues = $log['new_values'] ? json_decode($log['new_values'], true) : null;

        $diff = [];
        if (is_array($oldValues) && is_array($newValues)) {
            $diff = AuditLog::diff($oldValues, $newValues);
        }

        $this->jsonResponse([
            'success'   => true,
            'log'       => $log,
            'oldValues' => $oldValues,
            'newValues' => $newValues,
            'diff'      => $diff,
        ]);
    }

    /**
     * API endpoint to get filtered log rows (AJAX table updates)
     */
    public function apiLogs(): void
    {
        Middleware::requireAdmin();

        $page   = max(1, (int)$this->param('page', 1));
        $limit  = 25;
        $offset = ($page - 1) * $limit;

        $filters = array_filter([
            'keyword'   => trim((string)$this->param('keyword', '')),
            'module'    => trim((string)$this->param('module', '')),
            'action'    => trim((string)$this->param('action', '')),
            'date_from' => trim((string)$this->param('date_from', '')),
            'date_to'   => trim((string)$this->param('date_to', '')),
        ], fn($v) => $v !== '');

        $logs       = $this->auditModel->getFiltered($filters, $limit, $offset);
        $totalLogs  = $this->auditModel->countFiltered($filters);
        $totalPages = (int)ceil($totalLogs / $limit);

        $this->jsonResponse([
            'success'    => true,
            'logs'       => $logs,
            'totalLogs'  => $totalLogs,
            'page'       => $page,
            'totalPages' => $totalPages,
            'showing'    => count($logs),
        ]);
    }
}
