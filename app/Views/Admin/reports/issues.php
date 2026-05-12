<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 20px;
    }
    .stat-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .table-report {
        font-size: 14px;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
    }
    
    /* Loading Overlay */
    .page-loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-spinner {
        background: white;
        padding: 30px 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #667eea;
        font-weight: 500;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-exclamation-circle me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="<?= base_url('admin/reports/export/issues') ?>" class="btn btn-success btn-sm me-2" id="btnExportCSV">
                    <i class="fas fa-file-export me-2"></i>Export CSV
                </a>
                <a href="<?= base_url('admin/reports/export-issues') ?>" class="btn btn-danger btn-sm me-2" target="_blank" id="btnExportPDF">
                    <i class="fas fa-file-pdf me-2"></i>PDF
                </a>
                <a href="<?= base_url('admin/issues') ?>" class="btn btn-secondary btn-sm" id="btnBack">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    
    <div class="filter-card">
        <form method="get" action="<?= base_url('admin/reports/issues') ?>" id="filterForm">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select" id="filterProject">
                            <option value="">Semua Project</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?= $project['id'] ?>" <?= ($filters['project_id'] ?? '') == $project['id'] ? 'selected' : '' ?>>
                                    <?= esc($project['project_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-control" id="dateFrom" value="<?= $filters['date_from'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="form-control" id="dateTo" value="<?= $filters['date_to'] ?? '' ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control" id="btnFilter">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
            <?php if(!empty($filters['project_id']) || !empty($filters['date_from']) || !empty($filters['date_to'])): ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <a href="<?= base_url('admin/reports/issues') ?>" class="btn btn-sm btn-secondary" id="btnReset">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h6 class="mb-0">Total Issues</h6>
                <h3 class="mt-2 mb-0"><?= $stats['total'] ?? 0 ?></h3>
            </div>
        </div>
        <?php foreach($stats['by_status'] as $status => $count): ?>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <span class="badge-status 
                        <?php 
                        switch($status) {
                            case 'To Do': echo 'bg-secondary'; break;
                            case 'In Progress': echo 'bg-warning text-dark'; break;
                            case 'In Review': echo 'bg-info'; break;
                            case 'Done': echo 'bg-success'; break;
                            case 'Closed': echo 'bg-dark'; break;
                            default: echo 'bg-secondary';
                        }
                        ?>">
                        <?= esc($status) ?>
                    </span>
                    <h5 class="mt-2 mb-0"><?= $count ?></h5>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-report">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Reporter</th>
                            <th>Assignee</th>
                            <th>Created</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($issues)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data issue</p>
                                 </div>
                                 </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($issues as $issue): ?>
                                <tr>
                                    <td class="text-center">#<?= $issue['id'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/issues/' . $issue['id']) ?>" class="text-decoration-none" data-issue-link>
                                            <?= esc($issue['title']) ?>
                                        </a>
                                     </div>
                                     </td>
                                    <td>
                                        <?php 
                                        switch($issue['issue_type']) {
                                            case 'task': echo '<i class="fas fa-check-circle text-primary"></i> Task'; break;
                                            case 'bug': echo '<i class="fas fa-bug text-danger"></i> Bug'; break;
                                            case 'story': echo '<i class="fas fa-book text-success"></i> Story'; break;
                                            case 'epic': echo '<i class="fas fa-layer-group text-warning"></i> Epic'; break;
                                            default: echo '-';
                                        }
                                        ?>
                                     </div>
                                     </td>
                                    <td><?= esc($issue['project_name']) ?></div>
                                     </td>
                                    <td>
                                        <span class="badge-status 
                                            <?php 
                                            switch($issue['status']) {
                                                case 'To Do': echo 'bg-secondary'; break;
                                                case 'In Progress': echo 'bg-warning text-dark'; break;
                                                case 'In Review': echo 'bg-info'; break;
                                                case 'Done': echo 'bg-success'; break;
                                                case 'Closed': echo 'bg-dark'; break;
                                                default: echo 'bg-secondary';
                                            }
                                            ?>">
                                            <?= esc($issue['status']) ?>
                                        </span>
                                     </div>
                                     </td>
                                    <td>
                                        <span class="badge-status 
                                            <?php 
                                            switch($issue['priority']) {
                                                case 'Highest': echo 'bg-danger'; break;
                                                case 'High': echo 'bg-warning text-dark'; break;
                                                case 'Medium': echo 'bg-info'; break;
                                                case 'Low': echo 'bg-secondary'; break;
                                                case 'Lowest': echo 'bg-light text-dark'; break;
                                                default: echo 'bg-secondary';
                                            }
                                            ?>">
                                            <?= esc($issue['priority']) ?>
                                        </span>
                                     </div>
                                     </td>
                                    <td><?= esc($issue['reporter_name'] ?? '-') ?></div>
                                     </td>
                                    <td><?= esc($issue['assignee_name'] ?? 'Unassigned') ?></div>
                                     </td>
                                    <td><?= date('d/m/Y', strtotime($issue['created_at'])) ?></div>
                                     </td>
                                    <td>
                                        <?php if($issue['due_date']): ?>
                                            <?= date('d/m/Y', strtotime($issue['due_date'])) ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                     </div>
                                     </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if(empty($issues)): ?>
                    <div class="text-center my-4">
                        <i class="fas fa-exclamation-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted">Tidak ada issue yang ditemukan.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Memproses...') {
    const overlay = document.getElementById('loadingOverlay');
    const msgElement = document.getElementById('loadingMessage');
    if (overlay) {
        if (msgElement) msgElement.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Validasi tanggal
function validateDates() {
    const dateFrom = document.getElementById('dateFrom')?.value;
    const dateTo = document.getElementById('dateTo')?.value;
    
    if (dateFrom && dateTo && dateFrom > dateTo) {
        alert('Tanggal "Sampai" harus lebih besar atau sama dengan "Dari Tanggal"');
        return false;
    }
    return true;
}

// Submit filter dengan loading
document.getElementById('filterForm')?.addEventListener('submit', function(e) {
    if (!validateDates()) {
        e.preventDefault();
        return false;
    }
    showLoading('Menerapkan filter...');
});

// Reset filter dengan loading
document.getElementById('btnReset')?.addEventListener('click', function(e) {
    showLoading('Merreset filter...');
});

// Loading untuk tombol export
document.getElementById('btnExportCSV')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file Excel...');
    setTimeout(() => {
        hideLoading();
    }, 2000);
});

document.getElementById('btnExportPDF')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file PDF...');
    setTimeout(() => {
        hideLoading();
    }, 2000);
});

// Loading untuk tombol kembali
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke halaman reports...');
});

// Loading untuk link detail issue
document.querySelectorAll('[data-issue-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        showLoading('Memuat detail issue...');
    });
});

// Validasi tanggal real-time
document.getElementById('dateTo')?.addEventListener('change', function() {
    const dateFrom = document.getElementById('dateFrom')?.value;
    const dateTo = this.value;
    if (dateFrom && dateTo && dateFrom > dateTo) {
        this.classList.add('is-invalid');
    } else {
        this.classList.remove('is-invalid');
    }
});

// Sembunyikan loading saat halaman selesai
window.addEventListener('load', function() {
    hideLoading();
});

// Auto-hide flash messages
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>