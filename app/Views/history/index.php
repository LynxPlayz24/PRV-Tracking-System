<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>

<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Audit History</div>
        <h1>Audit History & Activity Logs</h1>
        <p class="text-muted mb-0 small">Track all changes, actions, updates, and user activities across the system.</p>
    </div>
</div>

<!-- ── Quick Statistics Cards ── -->
<div class="row g-3 mb-4 animate-fade-in-up stagger-1">
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-primary bg-opacity-10 text-primary me-3">
                    <i class="bi bi-clock-history fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Total Logs</div>
                    <div class="fs-4 fw-bold text-dark"><?= number_format((int)($stats['total_logs'] ?? 0)) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-info bg-opacity-10 text-info me-3">
                    <i class="bi bi-calendar-event fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Today's Activity</div>
                    <div class="fs-4 fw-bold text-dark"><?= number_format((int)($stats['today_logs'] ?? 0)) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-warning bg-opacity-10 text-warning me-3">
                    <i class="bi bi-pencil-square fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Updates / Edits</div>
                    <div class="fs-4 fw-bold text-dark"><?= number_format((int)($stats['total_updates'] ?? 0)) ?></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-body p-3 d-flex align-items-center">
                <div class="rounded-3 p-3 bg-danger bg-opacity-10 text-danger me-3">
                    <i class="bi bi-trash3 fs-4"></i>
                </div>
                <div>
                    <div class="text-muted small">Deletions</div>
                    <div class="fs-4 fw-bold text-dark"><?= number_format((int)($stats['total_deletes'] ?? 0)) ?></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Filters Form ── -->
<div class="card shadow-sm border-0 mb-4 animate-fade-in-up stagger-2">
    <div class="card-body p-3">
        <form action="<?= $baseUrl ?>/history" method="GET" class="row g-2 align-items-end" id="historyFilterForm">
            <div class="col-12 col-md-3">
                <label class="form-label small text-muted mb-1">Search Keywords</label>
                <input type="text" name="keyword" class="form-control form-control-sm" placeholder="Search user, action, target..." value="<?= htmlspecialchars($filters['keyword'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1">Module / Area</label>
                <select name="module" class="form-select form-select-sm">
                    <option value="">All Modules</option>
                    <?php foreach ($modules as $m): ?>
                        <option value="<?= htmlspecialchars($m) ?>" <?= ($filters['module'] ?? '') === $m ? 'selected' : '' ?>>
                            <?= htmlspecialchars($m) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1">Action Type</label>
                <select name="action" class="form-select form-select-sm">
                    <option value="">All Actions</option>
                    <?php foreach ($actions as $a): ?>
                        <option value="<?= htmlspecialchars($a) ?>" <?= ($filters['action'] ?? '') === $a ? 'selected' : '' ?>>
                            <?= htmlspecialchars($a) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1">From Date</label>
                <input type="date" name="date_from" class="form-control form-control-sm" value="<?= htmlspecialchars($filters['date_from'] ?? '') ?>">
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label small text-muted mb-1">To Date</label>
                <input type="date" name="date_to" class="form-control form-control-sm" value="<?= htmlspecialchars($filters['date_to'] ?? '') ?>">
            </div>
            <div class="col-12 col-md-1 d-flex gap-1">
                <button type="submit" class="btn btn-sm btn-uum w-100" title="Apply Filters">
                    <i class="bi bi-funnel-fill"></i>
                </button>
                <a href="<?= $baseUrl ?>/history" class="btn btn-sm btn-outline-secondary" title="Reset Filters">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>
</div>

<!-- ── Audit Log Table ── -->
<div class="card shadow-sm border-0 animate-fade-in-up stagger-3">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold fs-6">
            <i class="bi bi-list-columns-reverse text-primary me-2"></i>Activity Stream
        </h5>
        <span class="badge bg-light text-dark border" id="auditCountBadge">
            Showing <?= count($logs) ?> of <?= number_format($totalLogs) ?> events
        </span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light text-muted fw-semibold">
                    <tr>
                        <th class="px-3 py-2 border-0" style="width: 170px;">Date & Time</th>
                        <th class="py-2 border-0" style="width: 150px;">User</th>
                        <th class="py-2 border-0" style="width: 110px;">Module</th>
                        <th class="py-2 border-0" style="width: 100px;">Action</th>
                        <th class="py-2 border-0" style="width: 200px;">Target Entity</th>
                        <th class="py-2 border-0">Description</th>
                        <th class="px-3 py-2 border-0 text-end" style="width: 110px;">Changes</th>
                    </tr>
                </thead>
                <tbody id="auditTableBody">
                    <?php if (empty($logs)): ?>
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                                No audit records found matching your filters.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($logs as $log): ?>
                            <?php
                            $actionUpper = strtoupper($log['action']);
                            $actionBadge = match ($actionUpper) {
                                'CREATE' => 'bg-success',
                                'UPDATE' => 'bg-warning text-dark',
                                'DELETE' => 'bg-danger',
                                'IMPORT' => 'bg-primary',
                                'LOGIN'  => 'bg-info text-dark',
                                'LOGOUT' => 'bg-secondary',
                                default  => 'bg-dark'
                            };

                            $moduleBadge = match ($log['module']) {
                                'Students' => 'border-primary text-primary',
                                'Staff'    => 'border-info text-info',
                                'Users'    => 'border-warning text-dark',
                                'Import'   => 'border-success text-success',
                                'Auth'     => 'border-secondary text-secondary',
                                default    => 'border-dark text-dark'
                            };

                            $hasChanges = !empty($log['old_values']) || !empty($log['new_values']);
                            ?>
                            <tr>
                                <td class="px-3 text-nowrap">
                                    <div class="fw-medium small text-dark">
                                        <?= date('d M Y, h:i A', strtotime($log['created_at'])) ?>
                                    </div>
                                    <div class="text-muted" style="font-size: 0.75rem;">
                                        IP: <?= htmlspecialchars($log['ip_address'] ?? 'N/A') ?>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm rounded-circle bg-light border text-primary d-flex align-items-center justify-content-center me-2" style="width: 28px; height: 28px; font-size: 0.75rem; font-weight: bold;">
                                            <?= strtoupper(substr($log['user_name'] ?? 'U', 0, 1)) ?>
                                        </div>
                                        <span class="small fw-medium text-dark"><?= htmlspecialchars($log['user_name'] ?? 'System') ?></span>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge border bg-light <?= $moduleBadge ?> px-2 py-1 small">
                                        <?= htmlspecialchars($log['module']) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $actionBadge ?> px-2 py-1 small">
                                        <?= htmlspecialchars($actionUpper) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if (!empty($log['entity_name'])): ?>
                                        <span class="fw-medium small text-dark"><?= htmlspecialchars($log['entity_name']) ?></span>
                                        <?php if (!empty($log['entity_id'])): ?>
                                            <span class="text-muted small">#<?= (int)$log['entity_id'] ?></span>
                                        <?php endif; ?>
                                    <?php elseif (!empty($log['entity_id'])): ?>
                                        <span class="text-muted small">ID #<?= (int)$log['entity_id'] ?></span>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="small text-secondary" style="max-width: 400px; word-break: break-word;">
                                        <?= htmlspecialchars($log['description']) ?>
                                    </div>
                                </td>
                                <td class="px-3 text-end">
                                    <?php if ($hasChanges): ?>
                                        <button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 btn-view-diff" 
                                                data-id="<?= $log['id'] ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#diffModal"
                                                title="View Change Diff">
                                            <i class="bi bi-eye-fill me-1"></i>Diff
                                        </button>
                                    <?php else: ?>
                                        <button type="button" class="btn btn-sm btn-light py-1 px-2 btn-view-diff text-muted"
                                                data-id="<?= $log['id'] ?>"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#diffModal"
                                                title="View Details">
                                            <i class="bi bi-info-circle"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ── Pagination ── -->
    <div id="auditPagination">
    <?php if ($totalPages > 1): ?>
        <div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
            <div class="small text-muted">
                Page <strong><?= $page ?></strong> of <strong><?= $totalPages ?></strong>
            </div>
            <nav aria-label="Audit log navigation">
                <ul class="pagination pagination-sm mb-0">
                    <?php
                    $queryParams = $filters;
                    $buildPageUrl = function($p) use ($baseUrl, $queryParams) {
                        $queryParams['page'] = $p;
                        return $baseUrl . '/history?' . http_build_query($queryParams);
                    };
                    ?>
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $buildPageUrl($page - 1) ?>">Previous</a>
                    </li>

                    <?php
                    $startPage = max(1, $page - 2);
                    $endPage   = min($totalPages, $page + 2);
                    for ($p = $startPage; $p <= $endPage; $p++):
                    ?>
                        <li class="page-item <?= $p === $page ? 'active' : '' ?>">
                            <a class="page-link" href="<?= $buildPageUrl($p) ?>"><?= $p ?></a>
                        </li>
                    <?php endfor; ?>

                    <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a class="page-link" href="<?= $buildPageUrl($page + 1) ?>">Next</a>
                    </li>
                </ul>
            </nav>
        </div>
    <?php endif; ?>
    </div>
</div>

<!-- ── Audit Diff Inspection Modal ── -->
<div class="modal fade" id="diffModal" tabindex="-1" aria-labelledby="diffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content shadow-lg border-0">
            <div class="modal-header border-0 pb-0">
                <div>
                    <h5 class="modal-title fw-bold" id="diffModalLabel">
                        <i class="bi bi-file-diff text-primary me-2"></i>Audit Change Details
                    </h5>
                    <div class="text-muted small" id="diffModalMeta">Loading details...</div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body pt-3">
                <div id="diffLoadingSpinner" class="text-center py-5">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <div id="diffContent" class="d-none">
                    <!-- Event Summary Card -->
                    <div class="bg-light p-3 rounded-3 mb-3 border">
                        <div class="row g-2 small">
                            <div class="col-sm-6">
                                <span class="text-muted">Initiated By:</span>
                                <strong id="diffUser" class="text-dark"></strong>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted">IP Address:</span>
                                <span id="diffIp" class="text-dark"></span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted">Timestamp:</span>
                                <span id="diffTime" class="text-dark"></span>
                            </div>
                            <div class="col-sm-6">
                                <span class="text-muted">Target Entity:</span>
                                <strong id="diffEntity" class="text-dark"></strong>
                            </div>
                            <div class="col-12">
                                <span class="text-muted">Summary:</span>
                                <span id="diffDesc" class="text-dark fw-medium"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Field Level Diff Table -->
                    <div id="diffTableContainer">
                        <h6 class="fw-bold mb-2 small text-uppercase tracking-wider text-muted">
                            <i class="bi bi-layout-split me-1"></i>Field Modifications (Before vs After)
                        </h6>
                        <div class="table-responsive border rounded-3">
                            <table class="table table-sm table-bordered align-middle mb-0" id="diffTable">
                                <thead class="table-light text-muted small">
                                    <tr>
                                        <th style="width: 25%;">Field</th>
                                        <th style="width: 37.5%;" class="bg-danger bg-opacity-10 text-danger">Original Value</th>
                                        <th style="width: 37.5%;" class="bg-success bg-opacity-10 text-success">New Value</th>
                                    </tr>
                                </thead>
                                <tbody id="diffTableBody" class="small"></tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Raw Snapshot Container (when full diff not applicable) -->
                    <div id="rawContainer" class="d-none mt-3">
                        <h6 class="fw-bold mb-2 small text-uppercase tracking-wider text-muted">
                            <i class="bi bi-code-square me-1"></i>Data Snapshot
                        </h6>
                        <pre class="bg-dark text-light p-3 rounded-3 small mb-0" style="max-height: 250px; overflow-y: auto;" id="rawJson"></pre>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const diffModal = document.getElementById('diffModal');
    const baseUrl = <?= json_encode($baseUrl) ?>;

    document.querySelectorAll('.btn-view-diff').forEach(btn => {
        btn.addEventListener('click', async () => {
            const id = btn.getAttribute('data-id');
            const spinner = document.getElementById('diffLoadingSpinner');
            const content = document.getElementById('diffContent');
            const diffTableContainer = document.getElementById('diffTableContainer');
            const rawContainer = document.getElementById('rawContainer');

            spinner.classList.remove('d-none');
            content.classList.add('d-none');

            try {
                const res = await fetch(`${baseUrl}/history/detail/${id}`);
                const data = await res.json();

                if (!data.success) {
                    alert(data.message || 'Error fetching audit details');
                    return;
                }

                const log = data.log;
                document.getElementById('diffModalMeta').textContent = `Log #${log.id} • ${log.module} • ${log.action}`;
                document.getElementById('diffUser').textContent = log.user_name || 'System';
                document.getElementById('diffIp').textContent = log.ip_address || 'N/A';
                document.getElementById('diffTime').textContent = log.created_at;
                document.getElementById('diffEntity').textContent = log.entity_name ? `${log.entity_name} (#${log.entity_id || 'N/A'})` : (log.entity_id ? `ID #${log.entity_id}` : 'N/A');
                document.getElementById('diffDesc').textContent = log.description;

                const tbody = document.getElementById('diffTableBody');
                tbody.innerHTML = '';

                const diff = data.diff;
                const diffKeys = Object.keys(diff || {});

                if (diffKeys.length > 0) {
                    diffTableContainer.classList.remove('d-none');
                    rawContainer.classList.add('d-none');

                    diffKeys.forEach(field => {
                        const tr = document.createElement('tr');
                        const formatVal = (v) => {
                            if (v === null || v === undefined || v === '') return '<em class="text-muted">&lt;empty&gt;</em>';
                            if (typeof v === 'object') return escapeHtml(JSON.stringify(v));
                            return escapeHtml(String(v));
                        };

                        tr.innerHTML = `
                            <td class="fw-semibold font-monospace text-secondary">${escapeHtml(field)}</td>
                            <td class="bg-danger bg-opacity-10 text-danger">${formatVal(diff[field].old)}</td>
                            <td class="bg-success bg-opacity-10 text-success fw-medium">${formatVal(diff[field].new)}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else if (data.oldValues || data.newValues) {
                    diffTableContainer.classList.add('d-none');
                    rawContainer.classList.remove('d-none');
                    const snapshot = data.newValues || data.oldValues;
                    document.getElementById('rawJson').textContent = JSON.stringify(snapshot, null, 2);
                } else {
                    diffTableContainer.classList.add('d-none');
                    rawContainer.classList.add('d-none');
                }

                spinner.classList.add('d-none');
                content.classList.remove('d-none');
            } catch (err) {
                console.error(err);
                alert('Failed to load details.');
            }
        });
    });

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // ── AJAX filter / pagination ──
    const filterForm   = document.getElementById('historyFilterForm');
    const tableBody    = document.getElementById('auditTableBody');
    const countBadge   = document.getElementById('auditCountBadge');
    const pagination   = document.getElementById('auditPagination');
    const baseUrl      = '<?= $baseUrl ?>';

    const ACTION_BADGE = {
        CREATE: 'bg-success',
        UPDATE: 'bg-warning text-dark',
        DELETE: 'bg-danger',
        IMPORT: 'bg-primary',
        LOGIN:  'bg-info text-dark',
        LOGOUT: 'bg-secondary',
    };
    const MODULE_BADGE = {
        Students: 'border-primary text-primary',
        Staff:    'border-info text-info',
        Users:    'border-warning text-dark',
        Import:   'border-success text-success',
        Auth:     'border-secondary text-secondary',
    };

    function formatDate(str) {
        const d = new Date(str.replace(' ', 'T'));
        return d.toLocaleDateString('en-GB', {day:'2-digit',month:'short',year:'numeric'})
             + ', ' + d.toLocaleTimeString('en-GB', {hour:'2-digit',minute:'2-digit',hour12:true});
    }

    function buildRows(logs) {
        if (!logs.length) {
            return `<tr><td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                No audit records found matching your filters.
            </td></tr>`;
        }
        return logs.map(log => {
            const action = (log.action || '').toUpperCase();
            const actionCls = ACTION_BADGE[action] || 'bg-dark';
            const moduleCls = MODULE_BADGE[log.module] || 'border-dark text-dark';
            const hasChanges = log.old_values || log.new_values;
            const avatar = escapeHtml((log.user_name || 'U').charAt(0).toUpperCase());
            const userName = escapeHtml(log.user_name || 'System');
            const ip = escapeHtml(log.ip_address || 'N/A');
            const module = escapeHtml(log.module || '');
            const desc = escapeHtml(log.description || '');

            let entityCell = '<span class="text-muted small">-</span>';
            if (log.entity_name) {
                entityCell = `<span class="fw-medium small text-dark">${escapeHtml(log.entity_name)}</span>`;
                if (log.entity_id) entityCell += ` <span class="text-muted small">#${parseInt(log.entity_id)}</span>`;
            } else if (log.entity_id) {
                entityCell = `<span class="text-muted small">ID #${parseInt(log.entity_id)}</span>`;
            }

            const diffBtn = hasChanges
                ? `<button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 btn-view-diff"
                        data-id="${log.id}" data-bs-toggle="modal" data-bs-target="#diffModal" title="View Change Diff">
                        <i class="bi bi-eye-fill me-1"></i>Diff
                   </button>`
                : `<button type="button" class="btn btn-sm btn-light py-1 px-2 btn-view-diff text-muted"
                        data-id="${log.id}" data-bs-toggle="modal" data-bs-target="#diffModal" title="View Details">
                        <i class="bi bi-info-circle"></i>
                   </button>`;

            return `<tr>
                <td class="px-3 text-nowrap">
                    <div class="fw-medium small text-dark">${formatDate(log.created_at)}</div>
                    <div class="text-muted" style="font-size:.75rem">IP: ${ip}</div>
                </td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm rounded-circle bg-light border text-primary d-flex align-items-center justify-content-center me-2" style="width:28px;height:28px;font-size:.75rem;font-weight:bold">${avatar}</div>
                        <span class="small fw-medium text-dark">${userName}</span>
                    </div>
                </td>
                <td><span class="badge border bg-light ${moduleCls} px-2 py-1 small">${module}</span></td>
                <td><span class="badge ${actionCls} px-2 py-1 small">${action}</span></td>
                <td>${entityCell}</td>
                <td><div class="small text-secondary" style="max-width:400px;word-break:break-word">${desc}</div></td>
                <td class="px-3 text-end">${diffBtn}</td>
            </tr>`;
        }).join('');
    }

    function buildPagination(page, totalPages, params) {
        if (totalPages <= 1) return '';
        const buildUrl = (p) => {
            const q = new URLSearchParams({...params, page: p});
            return baseUrl + '/history?' + q.toString();
        };
        let pages = '';
        for (let p = Math.max(1, page - 2); p <= Math.min(totalPages, page + 2); p++) {
            pages += `<li class="page-item ${p === page ? 'active' : ''}">
                <a class="page-link" href="${buildUrl(p)}">${p}</a></li>`;
        }
        return `<div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">
            <div class="small text-muted">Page <strong>${page}</strong> of <strong>${totalPages}</strong></div>
            <nav aria-label="Audit log navigation">
                <ul class="pagination pagination-sm mb-0">
                    <li class="page-item ${page <= 1 ? 'disabled' : ''}">
                        <a class="page-link" href="${buildUrl(page - 1)}">Previous</a></li>
                    ${pages}
                    <li class="page-item ${page >= totalPages ? 'disabled' : ''}">
                        <a class="page-link" href="${buildUrl(page + 1)}">Next</a></li>
                </ul>
            </nav>
        </div>`;
    }

    let currentPage = 1;
    let debounceTimer;

    function getParams(page) {
        const fd = new FormData(filterForm);
        const params = {};
        for (const [k, v] of fd.entries()) if (v.trim()) params[k] = v.trim();
        params.page = page || currentPage;
        return params;
    }

    function fetchLogs(page) {
        currentPage = page || 1;
        const params = getParams(currentPage);
        const qs = new URLSearchParams(params).toString();

        // Sync URL without reload
        history.pushState(null, '', baseUrl + '/history?' + qs);

        tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Loading...</td></tr>';

        fetch(baseUrl + '/history/logs?' + qs, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then(r => r.json())
            .then(data => {
                if (!data.success) return;
                tableBody.innerHTML = buildRows(data.logs);
                countBadge.textContent = `Showing ${data.showing} of ${data.totalLogs.toLocaleString()} events`;
                pagination.innerHTML  = buildPagination(data.page, data.totalPages, params);
            })
            .catch(() => {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Failed to load results.</td></tr>';
            });
    }

    if (filterForm) {
        filterForm.querySelectorAll('select, input[type="date"]').forEach(el => {
            el.addEventListener('change', () => fetchLogs(1));
        });
        const kw = filterForm.querySelector('input[name="keyword"]');
        if (kw) kw.addEventListener('input', () => { clearTimeout(debounceTimer); debounceTimer = setTimeout(() => fetchLogs(1), 500); });
        filterForm.addEventListener('submit', e => { e.preventDefault(); fetchLogs(1); });
    }

    // Pagination link interception (event delegation)
    document.addEventListener('click', e => {
        const link = e.target.closest('#auditPagination a.page-link');
        if (!link) return;
        e.preventDefault();
        const url = new URL(link.href);
        fetchLogs(parseInt(url.searchParams.get('page')) || 1);
    });
});
</script>
