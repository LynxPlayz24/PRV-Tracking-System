<?php
/**
 * Quick Add Academic Staff Modals for Student Form
 * Submits via AJAX to JSON API endpoints without page redirects.
 */
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$csrf = $_SESSION['csrf_token'] ?? '';
?>

<!-- Quick Add Supervisor Modal -->
<div class="modal fade" id="quickAddSupervisorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/api/supervisors/store" method="POST" class="modal-content bg-white" id="quickFormSupervisor">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Quick Add Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" class="quick-add-csrf" value="<?= $csrf ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="supervisor_name" required placeholder="e.g. Prof. Dr. Ahmad">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="e.g. supervisor@uum.edu.my">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="e.g. +60 12-345 6789">
                </div>
                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" name="department" placeholder="e.g. School of Computing">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-uum">Save & Select</button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Add Examiner Modal -->
<div class="modal fade" id="quickAddExaminerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/api/examiners/store" method="POST" class="modal-content bg-white" id="quickFormExaminer">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Quick Add Examiner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" class="quick-add-csrf" value="<?= $csrf ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="examiner_name" required placeholder="e.g. Dr. Siti Aminah">
                </div>
                <div class="mb-3">
                    <label class="form-label">Classification <span class="text-danger">*</span></label>
                    <select class="form-select" name="classification" id="quickExaminerClassification" required>
                        <option value="Internal">Internal Examiner</option>
                        <option value="External">External Examiner</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="e.g. examiner@university.edu.my">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="e.g. +60 19-876 5432">
                </div>
                <div class="mb-3">
                    <label class="form-label">Institution</label>
                    <input type="text" class="form-control" name="institution" placeholder="e.g. Universiti Utara Malaysia">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-uum">Save & Select</button>
            </div>
        </form>
    </div>
</div>

<!-- Quick Add Chairperson Modal -->
<div class="modal fade" id="quickAddChairpersonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/api/chairpersons/store" method="POST" class="modal-content bg-white" id="quickFormChairperson">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Quick Add Chairperson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" class="quick-add-csrf" value="<?= $csrf ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="chairperson_name" required placeholder="e.g. Prof. Dr. Ahmad">
                </div>
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" placeholder="e.g. chair@uum.edu.my">
                </div>
                <div class="mb-3">
                    <label class="form-label">Phone Number</label>
                    <input type="text" class="form-control" name="phone" placeholder="e.g. +60 12-345 6789">
                </div>
                <div class="mb-3">
                    <label class="form-label">Department</label>
                    <input type="text" class="form-control" name="department" placeholder="e.g. School of Government">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-uum">Save & Select</button>
            </div>
        </form>
    </div>
</div>

<script>
(function() {
    function refreshCsrfTokens(newToken) {
        // Update all quick-add modal tokens
        document.querySelectorAll('.quick-add-csrf').forEach(function(input) {
            input.value = newToken;
        });
        // Also update the main student form token (rotated by the API call)
        const mainFormToken = document.querySelector('#studentForm input[name="csrf_token"]');
        if (mainFormToken) mainFormToken.value = newToken;
    }

    function initQuickStaffForms() {
        function setupForm(formId, modalId, onSaved) {
            const form = document.getElementById(formId);
            if (!form) return;
            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const submitBtn = form.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';

                const formData = new FormData(form);

                try {
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: { 'X-Requested-With': 'XMLHttpRequest' }
                    });
                    const data = await response.json();
                    if (data.success) {
                        // Refresh CSRF token in all modals immediately
                        if (data.new_csrf_token) {
                            refreshCsrfTokens(data.new_csrf_token);
                        }
                        onSaved(data);
                        const modalEl = document.getElementById(modalId);
                        const bsModal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                        if (bsModal) bsModal.hide();
                        form.reset();
                    } else {
                        alert(data.message || 'Error saving staff member.');
                    }
                } catch (err) {
                    console.error(err);
                    alert('Error processing request.');
                } finally {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = originalText;
                }
            });
        }

        // 1. Quick Add Supervisor
        setupForm('quickFormSupervisor', 'quickAddSupervisorModal', function(data) {
            // Add to main supervisors and auto-select
            const mainSel = $('select[name="main_supervisors[]"]');
            if (mainSel.find('option[value="' + data.id + '"]').length === 0) {
                mainSel.append(new Option(data.name, data.id, true, true));
            }
            mainSel.trigger('change.select2');

            // Add to co-supervisors (not selected by default)
            const coSel = $('select[name="co_supervisors[]"]');
            if (coSel.find('option[value="' + data.id + '"]').length === 0) {
                coSel.append(new Option(data.name, data.id, false, false));
            }
            coSel.trigger('change.select2');

            // Add to chairperson optgroup
            let optgroup = $('#chairpersonSelect optgroup[label="Supervisors"]');
            if (optgroup.length && optgroup.find('option[value="' + data.name + '"]').length === 0) {
                optgroup.append(new Option(data.name, data.name, false, false));
            }
        });

        // 2. Quick Add Examiner
        setupForm('quickFormExaminer', 'quickAddExaminerModal', function(data) {
            const isInternal = data.classification === 'Internal';
            const targetSelect = isInternal ? $('#internal_examiners') : $('#external_examiners');
            
            if (targetSelect.find('option[value="' + data.id + '"]').length === 0) {
                const option = new Option(data.name, data.id, true, true);
                $(option).attr('data-name', data.name);
                targetSelect.append(option);
            }
            targetSelect.trigger('change');
        });

        // 3. Quick Add Chairperson
        setupForm('quickFormChairperson', 'quickAddChairpersonModal', function(data) {
            let optgroup = $('#chairpersonSelect optgroup[label="Chairpersons"]');
            if (!optgroup.length) {
                optgroup = $('<optgroup label="Chairpersons"></optgroup>').appendTo('#chairpersonSelect');
            }
            if (optgroup.find('option[value="' + data.name + '"]').length === 0) {
                optgroup.append(new Option(data.name, data.name, false, false));
            }
            $('#chairpersonSelect').val(data.name).trigger('change');
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initQuickStaffForms);
    } else {
        initQuickStaffForms();
    }
})();
</script>
