<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$vivaYears   = $vivaYears ?? [];
$intakeYears = $intakeYears ?? [];

$months = [
    1=>'January',2=>'February',3=>'March',4=>'April',
    5=>'May',6=>'June',7=>'July',8=>'August',
    9=>'September',10=>'October',11=>'November',12=>'December'
];
$researchStatuses = [
    'Thesis Submitted','Examiner Assigned','Viva Scheduled',
    'Viva Completed','Corrections Submitted','Ready for Senate','Graduated'
];
?>
<!-- Analytics Content -->
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Analytics</div>
        <h1>Analytics Dashboard</h1>
    </div>
</div>

<!-- Primary Stat Cards -->
<div class="row g-4 mb-4 animate-fade-in-up stagger-1">
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-primary">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value"><?= number_format($stats['total_students']) ?></div>
            <div class="stat-label">Total Students</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-warning">
            <div class="stat-icon"><i class="bi bi-journal-text"></i></div>
            <div class="stat-value"><?= number_format($stats['pending_viva']) ?></div>
            <div class="stat-label">Pending Viva</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-danger">
            <div class="stat-icon"><i class="bi bi-pencil-square"></i></div>
            <div class="stat-value"><?= number_format($stats['awaiting_corrections']) ?></div>
            <div class="stat-label">Awaiting Corrections</div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-xl-3">
        <div class="stat-card stat-info">
            <div class="stat-icon"><i class="bi bi-file-earmark-check"></i></div>
            <div class="stat-value"><?= number_format($stats['ready_for_senate']) ?></div>
            <div class="stat-label">Ready for Senate</div>
        </div>
    </div>
</div>

<!-- Secondary Stat Cards -->
<div class="row g-4 mb-4 animate-fade-in-up stagger-2">
    <div class="col-12 col-md-4">
        <div class="stat-card bg-white border border-light">
            <div class="stat-icon text-success"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-value text-dark">RM <?= number_format($stats['total_viva_budget'], 2) ?></div>
            <div class="stat-label text-muted">Total Viva Budget Generated</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card bg-white border border-light">
            <div class="stat-icon text-primary"><i class="bi bi-person-lines-fill"></i></div>
            <div class="stat-value text-dark"><?= number_format($stats['total_supervisors_assigned']) ?></div>
            <div class="stat-label text-muted">Active Supervisor Assignments</div>
        </div>
    </div>
    <div class="col-12 col-md-4">
        <div class="stat-card bg-white border border-light">
            <div class="stat-icon text-purple" style="color: #6f42c1;"><i class="bi bi-person-video3"></i></div>
            <div class="stat-value text-dark"><?= number_format($stats['total_examiners_assigned']) ?></div>
            <div class="stat-label text-muted">Active Examiner Assignments</div>
        </div>
    </div>
</div>

<!-- ===== TOP PANEL ROLES SECTION ===== -->
<div class="card shadow-sm border-0 mb-4 animate-fade-in-up stagger-3">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="bi bi-person-badge-fill text-primary me-2"></i>Top Panel Roles
        </h5>
        <!-- Month/Year Filter -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <label class="form-label mb-0 text-muted small text-nowrap">Filter by Viva Date:</label>
            <select id="panelMonthFilter" class="form-select form-select-sm" style="width: auto; min-width: 130px;">
                <option value="">All Months</option>
                <?php foreach($months as $num => $name): ?>
                    <option value="<?= $num ?>"><?= $name ?></option>
                <?php endforeach; ?>
            </select>
            <select id="panelYearFilter" class="form-select form-select-sm" style="width: auto; min-width: 100px;">
                <option value="">All Years</option>
                <?php foreach($vivaYears as $yr): ?>
                    <option value="<?= $yr ?>"><?= $yr ?></option>
                <?php endforeach; ?>
            </select>
            <button class="btn btn-sm btn-outline-primary" id="panelFilterApply">
                <i class="bi bi-funnel me-1"></i>Apply
            </button>
        </div>
    </div>
    <div class="card-body">
        <div class="row g-4" id="panelRolesContainer">
            <!-- Populated via JS -->
            <div class="col-12 text-center py-4 text-muted" id="panelRolesLoading">
                <div class="spinner-border spinner-border-sm me-2" role="status"></div>Loading panel roles...
            </div>
        </div>
    </div>
</div>

<!-- ===== CHARTS SECTION ===== -->
<div class="row mb-4 animate-fade-in-up stagger-4">
    <!-- Status Distribution Chart -->
    <div class="col-12 col-lg-8">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart-fill text-primary me-2"></i>Students by Research Status</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0">
                <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-bar-chart-fill text-success me-2"></i>By Degree Level</h5>
            </div>
            <div class="card-body">
                <div style="position: relative; height: 350px; width: 100%;">
                    <canvas id="degreeChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ===== SCHOOL DISTRIBUTION CHART ===== -->
<div class="card shadow-sm border-0 mb-4 animate-fade-in-up stagger-5">
    <div class="card-header bg-white border-bottom-0 pt-4 pb-2 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h5 class="mb-0 fw-bold text-dark">
            <i class="bi bi-building me-2 text-warning"></i>School Enrollment Distribution
        </h5>
        <!-- Interactive Filters -->
        <div class="d-flex align-items-center gap-2 flex-wrap">
            <select id="schoolDegreeFilter" class="form-select form-select-sm" style="width: auto; min-width: 140px;">
                <option value="">All Levels</option>
                <option value="Masters">Master's</option>
                <option value="PhD">PhD</option>
                <option value="DBA">DBA</option>
            </select>
            <select id="schoolStatusFilter" class="form-select form-select-sm" style="width: auto; min-width: 180px;">
                <option value="">All Statuses</option>
                <?php foreach($researchStatuses as $rs): ?>
                    <option value="<?= $rs ?>"><?= $rs ?></option>
                <?php endforeach; ?>
            </select>
            <select id="schoolIntakeFilter" class="form-select form-select-sm" style="width: auto; min-width: 120px;">
                <option value="">All Intakes</option>
                <?php foreach($intakeYears as $yr): ?>
                    <option value="<?= $yr ?>"><?= $yr ?></option>
                <?php endforeach; ?>
            </select>
            <div class="btn-group btn-group-sm" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="schoolChartBar" title="Bar Chart">
                    <i class="bi bi-bar-chart-line"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="schoolChartPie" title="Pie Chart">
                    <i class="bi bi-pie-chart"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="card-body">
        <div style="position: relative; height: 320px; width: 100%;">
            <canvas id="schoolChart"></canvas>
        </div>
        <div id="schoolChartEmpty" class="text-center text-muted py-4" style="display:none;">
            <i class="bi bi-inbox fs-2 d-block mb-2"></i>No data for the selected filters.
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const baseUrl = '<?= $baseUrl ?>';
    let statusChartInst = null;
    let degreeChartInst = null;
    let schoolChartInst = null;
    let schoolChartType = 'bar';

    const schoolColors = [
        '#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b',
        '#858796','#5a5c69','#6f42c1','#fd7e14','#20c997'
    ];

    // ─── Render Top Panel Roles ───────────────────────────────────────────────
    function renderPanelRoles(data) {
        const container = document.getElementById('panelRolesContainer');
        const loading   = document.getElementById('panelRolesLoading');
        loading.style.display = 'none';

        const sections = [
            { key: 'supervisors',    label: 'Top Supervisors',    icon: 'bi-person-badge',    color: 'text-primary' },
            { key: 'co_supervisors', label: 'Top Co-Supervisors', icon: 'bi-people',           color: 'text-info' },
            { key: 'chairpersons',   label: 'Top Chairpersons',   icon: 'bi-person-workspace', color: 'text-success' },
            { key: 'examiners',      label: 'Top Examiners',      icon: 'bi-briefcase',        color: 'text-warning' },
        ];

        let html = '';
        sections.forEach(sec => {
            const rows = data[sec.key] || [];
            const listItems = rows.length > 0
                ? rows.map((r, i) => `
                    <div class="d-flex align-items-center justify-content-between py-2 ${i < rows.length-1 ? 'border-bottom' : ''}">
                        <div class="d-flex align-items-center gap-2">
                            <span class="badge bg-secondary rounded-pill fw-normal" style="min-width:24px;">${i+1}</span>
                            <span class="small fw-medium text-dark">${r.name}</span>
                        </div>
                        <span class="badge bg-light text-dark border small">${r.total} student${r.total != 1 ? 's' : ''}</span>
                    </div>`).join('')
                : '<div class="text-muted small py-2">No data available.</div>';

            html += `
                <div class="col-12 col-md-6 col-xl-3">
                    <div class="card border-0 bg-light h-100 p-3 rounded-3">
                        <h6 class="fw-bold mb-3 ${sec.color}">
                            <i class="bi ${sec.icon} me-2"></i>${sec.label}
                        </h6>
                        ${listItems}
                    </div>
                </div>`;
        });

        container.innerHTML = html;
    }

    // ─── Fetch & Render School Distribution Chart ─────────────────────────────
    function renderSchoolChart(labels, data) {
        const ctx = document.getElementById('schoolChart').getContext('2d');
        const empty = document.getElementById('schoolChartEmpty');

        if (schoolChartInst) { schoolChartInst.destroy(); schoolChartInst = null; }

        if (!labels.length) {
            document.getElementById('schoolChart').style.display = 'none';
            empty.style.display = 'block';
            return;
        }
        document.getElementById('schoolChart').style.display = '';
        empty.style.display = 'none';

        schoolChartInst = new Chart(ctx, {
            type: schoolChartType,
            data: {
                labels: labels,
                datasets: [{
                    label: 'Students',
                    data: data,
                    backgroundColor: schoolColors.slice(0, labels.length),
                    borderColor: schoolChartType === 'bar' ? '#fff' : '#fff',
                    borderWidth: schoolChartType === 'bar' ? 0 : 2,
                    borderRadius: schoolChartType === 'bar' ? 6 : 0,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: schoolChartType === 'bar' ? 'top' : 'right' },
                    tooltip: {
                        callbacks: {
                            label: ctx => ` ${ctx.parsed.y ?? ctx.parsed} students`
                        }
                    }
                },
                scales: schoolChartType === 'bar' ? {
                    y: { beginAtZero: true, ticks: { stepSize: 1 } }
                } : {}
            }
        });
    }

    // ─── Main fetch function ──────────────────────────────────────────────────
    function fetchChartData(params = {}) {
        const qs = new URLSearchParams(params).toString();
        return fetch(`${baseUrl}/analytics/chart-data${qs ? '?' + qs : ''}`)
            .then(r => r.json());
    }

    // ─── Initial load ─────────────────────────────────────────────────────────
    fetchChartData().then(data => {
        // Status chart
        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        statusChartInst = new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: data.status_distribution.labels,
                datasets: [{
                    label: 'Students',
                    data: data.status_distribution.data,
                    backgroundColor: ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796','#5a5c69'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'right' } }
            }
        });

        // Degree chart
        const ctxDegree = document.getElementById('degreeChart').getContext('2d');
        degreeChartInst = new Chart(ctxDegree, {
            type: 'pie',
            data: {
                labels: data.degree_distribution.labels,
                datasets: [{
                    label: 'Students',
                    data: data.degree_distribution.data,
                    backgroundColor: ['#f6c23e','#e74a3b','#36b9cc','#1cc88a'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // School chart
        renderSchoolChart(data.school_distribution.labels, data.school_distribution.data);

        // Panel roles
        renderPanelRoles(data.top_panel_roles);
    }).catch(err => console.error('Analytics fetch error:', err));

    // ─── School chart filters ─────────────────────────────────────────────────
    function refreshSchoolChart() {
        const params = {
            degree_level: document.getElementById('schoolDegreeFilter').value,
            status:       document.getElementById('schoolStatusFilter').value,
            intake_year:  document.getElementById('schoolIntakeFilter').value,
        };
        fetchChartData(params).then(data => {
            renderSchoolChart(data.school_distribution.labels, data.school_distribution.data);
        });
    }

    ['schoolDegreeFilter','schoolStatusFilter','schoolIntakeFilter'].forEach(id => {
        document.getElementById(id).addEventListener('change', refreshSchoolChart);
    });

    // Chart type toggle
    document.getElementById('schoolChartBar').addEventListener('click', function() {
        schoolChartType = 'bar';
        this.classList.add('active');
        document.getElementById('schoolChartPie').classList.remove('active');
        refreshSchoolChart();
    });
    document.getElementById('schoolChartPie').addEventListener('click', function() {
        schoolChartType = 'pie';
        this.classList.add('active');
        document.getElementById('schoolChartBar').classList.remove('active');
        refreshSchoolChart();
    });

    // ─── Panel roles filter ───────────────────────────────────────────────────
    document.getElementById('panelFilterApply').addEventListener('click', function() {
        const month = document.getElementById('panelMonthFilter').value;
        const year  = document.getElementById('panelYearFilter').value;
        const params = {};
        if (month) params.month = month;
        if (year)  params.year  = year;

        document.getElementById('panelRolesLoading').style.display = '';
        document.getElementById('panelRolesContainer').innerHTML =
            '<div class="col-12 text-center py-4 text-muted" id="panelRolesLoading"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Loading panel roles...</div>';

        fetchChartData(params).then(data => renderPanelRoles(data.top_panel_roles))
                               .catch(err => console.error(err));
    });
});
</script>
