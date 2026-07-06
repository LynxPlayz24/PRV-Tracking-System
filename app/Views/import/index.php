<?php
$baseUrl = rtrim($_ENV['APP_URL'] ?? '', '/');
?>
<div class="page-header animate-fade-in-up">
    <div>
        <div class="breadcrumb text-muted">PRVTS / Admin / Import</div>
        <h1>Import Students</h1>
    </div>
</div>

<div class="row animate-fade-in-up stagger-1">
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header bg-light">Upload Excel File</div>
            <div class="card-body">
                
                <div class="alert alert-info" style="font-size:0.85rem;">
                    <strong><i class="bi bi-info-circle me-1"></i>Template Instructions</strong><br>
                    Please ensure your Excel file (.xlsx or .csv) has the following columns in order (first row is treated as header):
                    <ol class="mb-0 mt-2 text-dark">
                        <li><strong>Matric Number</strong> (Required)</li>
                        <li><strong>Full Name</strong> (Required)</li>
                        <li><strong>Programme</strong></li>
                        <li><strong>School</strong></li>
                        <li><strong>Degree Level</strong> (e.g. Masters, PhD, DBA)</li>
                    </ol>
                </div>

                <form action="<?= $baseUrl ?>/import/upload" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                    
                    <div class="mb-4">
                        <label for="excelFile" class="form-label">Select File</label>
                        <input class="form-control" type="file" id="excelFile" name="excel_file" accept=".xlsx,.xls,.csv" required>
                    </div>

                    <button type="submit" class="btn btn-uum w-100">
                        <i class="bi bi-upload me-2"></i>Upload and Import
                    </button>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-6">
        <div class="card border-0 bg-transparent shadow-none">
            <div class="card-body px-0 text-center text-muted pt-5">
                <i class="bi bi-file-earmark-spreadsheet" style="font-size:5rem;opacity:0.3"></i>
                <h5 class="mt-3">Batch Import</h5>
                <p class="small">Upload an Excel sheet to quickly populate your database with new students. Duplicates based on Matric Number will be automatically skipped.</p>
            </div>
        </div>
    </div>
</div>
