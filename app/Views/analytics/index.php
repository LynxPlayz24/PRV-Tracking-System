<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
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

<!-- Charts Section -->
<div class="row mb-4 animate-fade-in-up stagger-3">
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
    
    <!-- We can add more charts here if needed, such as Degree Distribution or School Distribution -->
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    fetch('<?= $baseUrl ?>/analytics/chart-data')
        .then(response => response.json())
        .then(data => {
            // Status Chart
            const ctxStatus = document.getElementById('statusChart').getContext('2d');
            new Chart(ctxStatus, {
                type: 'doughnut',
                data: {
                    labels: data.status_distribution.labels,
                    datasets: [{
                        label: 'Students',
                        data: data.status_distribution.data,
                        backgroundColor: [
                            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796', '#5a5c69'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
            
            // Degree Chart
            const ctxDegree = document.getElementById('degreeChart').getContext('2d');
            new Chart(ctxDegree, {
                type: 'pie',
                data: {
                    labels: data.degree_distribution.labels,
                    datasets: [{
                        label: 'Students',
                        data: data.degree_distribution.data,
                        backgroundColor: [
                            '#f6c23e', '#e74a3b', '#36b9cc', '#1cc88a'
                        ],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { position: 'bottom' }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching chart data:', error));
});
</script>
