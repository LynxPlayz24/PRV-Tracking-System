<?php
namespace App\Core;

/**
 * App Class
 * Bootstrap the application: autoloading, session, route registration, dispatch.
 */
class App
{
    private Router $router;

    public function __construct()
    {
        $this->router = new Router();
        $this->registerRoutes();
    }

    /**
     * Register all application routes
     */
    private function registerRoutes(): void
    {
        // ── Authentication ──
        $this->router->get('/login',            'AuthController', 'login');
        $this->router->post('/login',           'AuthController', 'loginPost');
        $this->router->get('/forgot-password',  'AuthController', 'forgotPassword');
        $this->router->get('/logout',           'AuthController', 'logout');

        // ── Dashboard (Admin) ──
        $this->router->get('/',                     'DashboardController', 'index');
        $this->router->get('/dashboard',            'DashboardController', 'index');

        // ── Analytics (Admin) ──
        $this->router->get('/analytics',            'AnalyticsController', 'index');
        $this->router->get('/analytics/chart-data', 'AnalyticsController', 'chartData');

        // ── Search ──
        $this->router->get('/search',          'SearchController', 'index');
        $this->router->get('/search/live',     'SearchController', 'liveSearch');

        // ── Students ──
        $this->router->get('/student/{id}',    'StudentController', 'detail');
        $this->router->get('/students/create', 'StudentController', 'create');
        $this->router->post('/students/store', 'StudentController', 'store');
        $this->router->get('/students/manage', 'StudentController', 'manage');
        $this->router->get('/students/edit/{id}',   'StudentController', 'edit');
        $this->router->post('/students/update/{id}','StudentController', 'update');
        $this->router->post('/students/delete/{id}','StudentController', 'delete');
        $this->router->post('/students/bulk-delete', 'StudentController', 'bulkDelete');
        $this->router->post('/student/{id}/remarks', 'StudentController', 'addRemark');
        $this->router->post('/student/{id}/remarks/delete/{remarkId}', 'StudentController', 'deleteRemark');

        // ── Import (Admin) ──
        $this->router->get('/import',          'ImportController', 'index');
        $this->router->post('/import/upload',  'ImportController', 'upload');

        // ── Export ──
        $this->router->get('/export',              'ExportController', 'index');
        $this->router->post('/export/pdf',         'ExportController', 'exportPdf');
        $this->router->post('/export/excel',       'ExportController', 'exportExcel');
        $this->router->get('/export/pdf/{id}',     'ExportController', 'exportSinglePdf');
        $this->router->get('/export/excel/{id}',   'ExportController', 'exportSingleExcel');
        $this->router->post('/export/preview',     'ExportController', 'apiPreview');
        $this->router->post('/export/custom',      'ExportController', 'exportCustom');

        // ── Docx Templates ──
        $this->router->get('/docx-templates',          'DocxTemplateController', 'index');
        $this->router->post('/docx-templates/generate', 'DocxTemplateController', 'generate');

        // ── User Management (Admin) ──
        $this->router->get('/users',               'UserController', 'manage');
        $this->router->post('/users/store',        'UserController', 'store');
        $this->router->post('/users/role/{id}',    'UserController', 'updateRole');
        $this->router->post('/users/reset-password/{id}', 'UserController', 'resetPassword');
        $this->router->post('/users/delete/{id}',  'UserController', 'delete');

        // ── Academic Staff (Admin) ──
        $this->router->get('/staff',                       'StaffController', 'manage');
        $this->router->post('/staff/supervisors/store',    'StaffController', 'storeSupervisor');
        $this->router->post('/staff/supervisors/update/{id}', 'StaffController', 'updateSupervisor');
        $this->router->post('/staff/supervisors/delete/{id}', 'StaffController', 'deleteSupervisor');
        $this->router->post('/staff/examiners/store',      'StaffController', 'storeExaminer');
        $this->router->post('/staff/examiners/update/{id}',   'StaffController', 'updateExaminer');
        $this->router->post('/staff/examiners/delete/{id}',   'StaffController', 'deleteExaminer');
        $this->router->post('/staff/chairpersons/store',    'StaffController', 'storeChairperson');
        $this->router->post('/staff/chairpersons/update/{id}', 'StaffController', 'updateChairperson');
        $this->router->post('/staff/chairpersons/delete/{id}', 'StaffController', 'deleteChairperson');

        // ── Academic Staff AJAX APIs (Student Form Quick-Add) ──
        $this->router->post('/staff/api/supervisors/store', 'StaffController', 'apiStoreSupervisor');
        $this->router->post('/staff/api/examiners/store',   'StaffController', 'apiStoreExaminer');
        $this->router->post('/staff/api/chairpersons/store','StaffController', 'apiStoreChairperson');


        // ── Profile ──
        $this->router->get('/profile',         'ProfileController', 'index');
        $this->router->post('/profile/update', 'ProfileController', 'update');

        // ── Audit History (Admin) ──
        $this->router->get('/history',             'HistoryController', 'index');
        $this->router->get('/history/logs',        'HistoryController', 'apiLogs');
        $this->router->get('/history/detail/{id}', 'HistoryController', 'apiDetail');
    }

    /**
     * Run the application
     */
    public function run(): void
    {
        $uri    = $_SERVER['REQUEST_URI'] ?? '/';
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $this->router->dispatch($uri, $method);
    }
}
