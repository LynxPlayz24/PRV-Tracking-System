<!-- Search Page Content -->
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Students / Search</div>
        <h1>Search Students</h1>
    </div>
</div>

<div class="row animate-fade-in-up stagger-1">
    <!-- Filter Sidebar -->
    <div class="col-lg-3 mb-4">
        <div class="filter-panel">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <div class="filter-title mb-0"><i class="bi bi-funnel me-2"></i>Filters</div>
                <button type="button" class="btn btn-sm btn-link text-decoration-none" id="clearFiltersBtn">Clear All</button>
            </div>
            
            <form id="filterForm">
                <!-- Degree Level -->
                <div class="mb-3">
                    <label class="form-label">Degree Level</label>
                    <select class="form-select form-select-sm" name="degree" id="filterDegree">
                        <option value="">All Degrees</option>
                        <?php foreach($degrees as $d): ?>
                            <option value="<?= htmlspecialchars($d) ?>"><?= htmlspecialchars($d) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- School -->
                <div class="mb-3">
                    <label class="form-label">School</label>
                    <select class="form-select form-select-sm" name="school" id="filterSchool">
                        <option value="">All Schools</option>
                        <?php foreach($schools as $s): ?>
                            <option value="<?= htmlspecialchars($s) ?>"><?= htmlspecialchars($s) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <!-- Research Status -->
                <div class="mb-3">
                    <label class="form-label">Research Status</label>
                    <select class="form-select form-select-sm" name="research_status" id="filterStatus">
                        <option value="">All Statuses</option>
                        <?php foreach($statuses as $st): ?>
                            <option value="<?= htmlspecialchars($st) ?>"><?= htmlspecialchars($st) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Search Bar & Results -->
    <div class="col-lg-9">
        <!-- Search Input -->
        <div class="search-container mb-4 w-100 mx-0" style="max-width: 100%;">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="searchInput" class="search-input" placeholder="Search by name, matric no, school, supervisor, or thesis title...">
            <button id="clearSearchBtn" class="search-clear"><i class="bi bi-x-circle-fill"></i></button>
        </div>
        
        <!-- Results Loader -->
        <div id="searchLoader" class="text-center py-5" style="display:none;">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
        
        <!-- Results Table -->
        <div class="table-prvts" id="resultsContainer">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light text-muted fw-semibold">
                        <tr>
                            <th>Matric No</th>
                            <th>Student Name</th>
                            <th>Programme</th>
                            <th>Degree</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="resultsBody">
                        <!-- AJAX results will be injected here -->
                    </tbody>
                </table>
            </div>
            
            <!-- Empty State (hidden by default) -->
            <div id="emptyState" class="text-center py-5" style="display:none;">
                <div class="mb-3">
                    <i class="bi bi-search text-muted" style="font-size: 3rem; opacity: 0.5;"></i>
                </div>
                <h5 class="text-muted">No students found</h5>
                <p class="text-muted small">Try adjusting your search query or filters.</p>
            </div>
        </div>
    </div>
</div>
