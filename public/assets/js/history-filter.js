/**
 * History Filter & Diff Modal
 * Handles AJAX live filtering, pagination, and audit diff modal for /history.
 * Uses window.APP_URL (set globally in header.php) — no PHP in this file.
 */
document.addEventListener('DOMContentLoaded', function () {

    // ── DOM refs ──
    const filterForm  = document.getElementById('historyFilterForm');
    const tableBody   = document.getElementById('auditTableBody');
    const countBadge  = document.getElementById('auditCountBadge');
    const pagination  = document.getElementById('auditPagination');

    if (!filterForm || !tableBody) return; // not on history page

    const basePath = window.APP_URL || '';
    const apiUrl   = basePath + '/history/logs';

    // ── Badge maps ──
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

    // ── Helpers ──
    function escHtml(str) {
        const d = document.createElement('div');
        d.textContent = str || '';
        return d.innerHTML;
    }

    function formatDate(str) {
        const d = new Date(str.replace(' ', 'T'));
        return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' })
             + ', ' + d.toLocaleTimeString('en-GB', { hour: '2-digit', minute: '2-digit', hour12: true });
    }

    // ── Render ──
    function renderRows(logs) {
        if (!logs.length) {
            tableBody.innerHTML = `<tr><td colspan="7" class="text-center py-5 text-muted">
                <i class="bi bi-inbox fs-2 d-block mb-2 text-secondary"></i>
                No audit records found matching your filters.
            </td></tr>`;
            return;
        }

        tableBody.innerHTML = logs.map(function (log) {
            const action    = (log.action || '').toUpperCase();
            const actionCls = ACTION_BADGE[action] || 'bg-dark';
            const moduleCls = MODULE_BADGE[log.module] || 'border-dark text-dark';
            const hasChanges = log.old_values || log.new_values;

            let entityCell = '<span class="text-muted small">-</span>';
            if (log.entity_name) {
                entityCell = '<span class="fw-medium small text-dark">' + escHtml(log.entity_name) + '</span>';
                if (log.entity_id) entityCell += ' <span class="text-muted small">#' + parseInt(log.entity_id) + '</span>';
            } else if (log.entity_id) {
                entityCell = '<span class="text-muted small">ID #' + parseInt(log.entity_id) + '</span>';
            }

            const diffBtn = hasChanges
                ? '<button type="button" class="btn btn-sm btn-outline-primary py-1 px-2 btn-view-diff" data-id="' + log.id + '" data-bs-toggle="modal" data-bs-target="#diffModal" title="View Change Diff"><i class="bi bi-eye-fill me-1"></i>Diff</button>'
                : '<button type="button" class="btn btn-sm btn-light py-1 px-2 btn-view-diff text-muted" data-id="' + log.id + '" data-bs-toggle="modal" data-bs-target="#diffModal" title="View Details"><i class="bi bi-info-circle"></i></button>';

            return '<tr>'
                + '<td class="px-3 text-nowrap">'
                +   '<div class="fw-medium small text-dark">' + formatDate(log.created_at) + '</div>'
                +   '<div class="text-muted" style="font-size:.75rem">IP: ' + escHtml(log.ip_address || 'N/A') + '</div>'
                + '</td>'
                + '<td><div class="d-flex align-items-center">'
                +   '<div class="avatar-sm rounded-circle bg-light border text-primary d-flex align-items-center justify-content-center me-2" style="width:28px;height:28px;font-size:.75rem;font-weight:bold">'
                +     escHtml((log.user_name || 'U').charAt(0).toUpperCase())
                +   '</div>'
                +   '<span class="small fw-medium text-dark">' + escHtml(log.user_name || 'System') + '</span>'
                + '</div></td>'
                + '<td><span class="badge border bg-light ' + moduleCls + ' px-2 py-1 small">' + escHtml(log.module || '') + '</span></td>'
                + '<td><span class="badge ' + actionCls + ' px-2 py-1 small">' + action + '</span></td>'
                + '<td>' + entityCell + '</td>'
                + '<td><div class="small text-secondary" style="max-width:400px;word-break:break-word">' + escHtml(log.description || '') + '</div></td>'
                + '<td class="px-3 text-end">' + diffBtn + '</td>'
                + '</tr>';
        }).join('');
    }

    function renderPagination(page, totalPages, params) {
        if (totalPages <= 1) { pagination.innerHTML = ''; return; }

        function buildUrl(p) {
            const q = new URLSearchParams(Object.assign({}, params, { page: p }));
            return basePath + '/history?' + q.toString();
        }

        let pages = '';
        for (let p = Math.max(1, page - 2); p <= Math.min(totalPages, page + 2); p++) {
            pages += '<li class="page-item ' + (p === page ? 'active' : '') + '">'
                   + '<a class="page-link" href="' + buildUrl(p) + '">' + p + '</a></li>';
        }

        pagination.innerHTML = '<div class="card-footer bg-white border-top py-3 d-flex justify-content-between align-items-center">'
            + '<div class="small text-muted">Page <strong>' + page + '</strong> of <strong>' + totalPages + '</strong></div>'
            + '<nav aria-label="Audit log navigation"><ul class="pagination pagination-sm mb-0">'
            + '<li class="page-item ' + (page <= 1 ? 'disabled' : '') + '"><a class="page-link" href="' + buildUrl(page - 1) + '">Previous</a></li>'
            + pages
            + '<li class="page-item ' + (page >= totalPages ? 'disabled' : '') + '"><a class="page-link" href="' + buildUrl(page + 1) + '">Next</a></li>'
            + '</ul></nav></div>';
    }

    // ── Fetch ──
    let currentPage = 1;
    let debounceTimer;

    function getParams(page) {
        const fd = new FormData(filterForm);
        const params = {};
        for (const [k, v] of fd.entries()) {
            if (v.trim()) params[k] = v.trim();
        }
        params.page = page || currentPage;
        return params;
    }

    const fetchResults = function (page) {
        currentPage = page || 1;
        const params = getParams(currentPage);
        const qs = new URLSearchParams(params).toString();

        // Sync URL without reload
        try { history.pushState(null, '', basePath + '/history?' + qs); } catch (e) {}

        // Show loading state
        tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-muted">'
            + '<div class="spinner-border spinner-border-sm me-2"></div>Loading...</td></tr>';

        fetch(apiUrl + '?' + qs)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data.success) return;
                renderRows(data.logs);
                if (countBadge) countBadge.textContent = 'Showing ' + data.showing + ' of ' + data.totalLogs.toLocaleString() + ' events';
                renderPagination(data.page, data.totalPages, params);
            })
            .catch(function () {
                tableBody.innerHTML = '<tr><td colspan="7" class="text-center py-4 text-danger">Failed to load results.</td></tr>';
            });
    };

    // ── Filter event listeners ──
    filterForm.querySelectorAll('select, input[type="date"]').forEach(function (el) {
        el.addEventListener('change', function () { fetchResults(1); });
    });

    const kw = filterForm.querySelector('input[name="keyword"]');
    if (kw) {
        kw.addEventListener('input', function () {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(function () { fetchResults(1); }, 300);
        });
    }

    filterForm.addEventListener('submit', function (e) {
        e.preventDefault();
        fetchResults(1);
    });

    // ── Pagination click delegation ──
    document.addEventListener('click', function (e) {
        const link = e.target.closest('#auditPagination a.page-link');
        if (!link) return;
        e.preventDefault();
        const url = new URL(link.href);
        fetchResults(parseInt(url.searchParams.get('page')) || 1);
    });

    // ── Diff modal (event delegation — works on AJAX-loaded rows) ──
    document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-view-diff');
        if (!btn) return;

        const id      = btn.getAttribute('data-id');
        const spinner = document.getElementById('diffLoadingSpinner');
        const content = document.getElementById('diffContent');
        const diffTableContainer = document.getElementById('diffTableContainer');
        const rawContainer       = document.getElementById('rawContainer');

        if (!spinner) return;

        spinner.classList.remove('d-none');
        content.classList.add('d-none');

        fetch(basePath + '/history/detail/' + id)
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (!data.success) { alert(data.message || 'Error fetching audit details'); return; }

                const log = data.log;
                const meta = document.getElementById('diffModalMeta');
                if (meta) meta.textContent = 'Log #' + log.id + ' \u2022 ' + log.module + ' \u2022 ' + log.action;

                const descEl = document.getElementById('diffModalDesc');
                if (descEl) descEl.textContent = log.description || '';

                const userEl = document.getElementById('diffModalUser');
                if (userEl) userEl.textContent = (log.user_name || 'System') + ' \u2014 ' + log.created_at;

                if (data.diff && Object.keys(data.diff).length > 0) {
                    diffTableContainer.classList.remove('d-none');
                    rawContainer.classList.add('d-none');

                    const tbody = document.getElementById('diffTableBody');
                    tbody.innerHTML = '';

                    Object.keys(data.diff).forEach(function (field) {
                        const tr = document.createElement('tr');
                        const formatVal = function (v) {
                            if (v === null || v === undefined || v === '') return '<em class="text-muted">&lt;empty&gt;</em>';
                            if (typeof v === 'object') return escHtml(JSON.stringify(v));
                            return escHtml(String(v));
                        };
                        tr.innerHTML = '<td class="fw-semibold font-monospace text-secondary">' + escHtml(field) + '</td>'
                            + '<td class="bg-danger bg-opacity-10 text-danger">' + formatVal(data.diff[field].old) + '</td>'
                            + '<td class="bg-success bg-opacity-10 text-success fw-medium">' + formatVal(data.diff[field].new) + '</td>';
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
            })
            .catch(function () {
                alert('Failed to load details.');
            });
    });

});
