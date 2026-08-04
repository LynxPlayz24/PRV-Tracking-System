<?php
/**
 * Shared Academic Staff Add Modals
 * Included in staff/manage.php and students/create.php
 */
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
$csrf = $_SESSION['csrf_token'] ?? '';
?>

<!-- Add Supervisor Modal -->
<div class="modal fade" id="addSupervisorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/supervisors/store" method="POST" class="modal-content bg-white" id="formAddSupervisor">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add New Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
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
                <button type="submit" class="btn btn-uum">Save Supervisor</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Examiner Modal -->
<div class="modal fade" id="addExaminerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/examiners/store" method="POST" class="modal-content bg-white" id="formAddExaminer">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add New Examiner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
                <div class="mb-3">
                    <label class="form-label">Full Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="examiner_name" required placeholder="e.g. Dr. Siti Aminah">
                </div>
                <div class="mb-3">
                    <label class="form-label">Classification <span class="text-danger">*</span></label>
                    <select class="form-select" name="classification" id="modalExaminerClassification" required>
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
                <button type="submit" class="btn btn-uum">Save Examiner</button>
            </div>
        </form>
    </div>
</div>

<!-- Add Chairperson Modal -->
<div class="modal fade" id="addChairpersonModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="<?= $baseUrl ?>/staff/chairpersons/store" method="POST" class="modal-content bg-white" id="formAddChairperson">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-person-plus me-2"></i>Add New Chairperson</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
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
                <button type="submit" class="btn btn-uum">Save Chairperson</button>
            </div>
        </form>
    </div>
</div>
