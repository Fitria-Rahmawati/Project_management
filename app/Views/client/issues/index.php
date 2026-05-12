<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== LOADING OVERLAY ==================== */
    .loading-overlay {
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
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e3e6f0;
        border-top-color: #e74a3b;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #e74a3b;
        font-weight: 500;
    }

    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        transition: transform 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-3px);
    }
    .issue-card {
        border-left: 3px solid;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .issue-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .priority-high { border-left-color: #e74a3b; }
    .priority-medium { border-left-color: #f6c23e; }
    .priority-low { border-left-color: #1cc88a; }
    .status-open { background: #e74a3b; }
    .status-in_progress { background: #f6c23e; color: #333; }
    .status-done { background: #1cc88a; }
    .btn-lapor {
        background: #dc3545;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        transition: all 0.3s;
    }
    .btn-lapor:hover {
        background: #c82333;
        transform: translateY(-2px);
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
            Riwayat Kendala
        </h1>
        <a href="<?= base_url('client/issues/create') ?>" class="btn btn-danger btn-lapor" id="btnCreate">
            <i class="fas fa-plus me-2"></i>Lapor Kendala Baru
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h2 class="mb-0"><?= $totalIssues ?></h2>
                <small class="text-muted">Total Kendala</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                <h2 class="mb-0"><?= $openIssues ?></h2>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-spinner fa-2x text-warning mb-2"></i>
                <h2 class="mb-0"><?= $inProgressIssues ?></h2>
                <small class="text-muted">Dikerjakan</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h2 class="mb-0"><?= $doneIssues ?></h2>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
    </div>

    <!-- Daftar Issues -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar Kendala</h5>
        </div>
        <div class="card-body">
            <?php if(empty($issues)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p class="text-muted">Belum ada kendala yang dilaporkan</p>
                    <a href="<?= base_url('client/issues/create') ?>" class="btn btn-primary" id="btnCreateFirst">
                        <i class="fas fa-plus me-1"></i> Lapor Kendala
                    </a>
                </div>
            <?php else: ?>
                <?php foreach($issues as $issue): ?>
                    <?php
                    $priorityClass = '';
                    switch($issue['priority']) {
                        case 'high': $priorityClass = 'priority-high'; break;
                        case 'medium': $priorityClass = 'priority-medium'; break;
                        case 'low': $priorityClass = 'priority-low'; break;
                    }
                    
                    $statusBadge = '';
                    switch($issue['status']) {
                        case 'open': $statusBadge = 'status-open'; break;
                        case 'in_progress': $statusBadge = 'status-in_progress'; break;
                        case 'done': $statusBadge = 'status-done'; break;
                    }
                    ?>
                    <div class="issue-card card <?= $priorityClass ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="mb-0"><?= esc($issue['title']) ?></h6>
                                        <span class="badge <?= $statusBadge ?>">
                                            <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-folder me-1"></i> <?= esc($issue['project_name']) ?>
                                    </p>
                                    <p class="small mb-0"><?= esc(substr($issue['description'], 0, 100)) ?>...</p>
                                    <div class="d-flex gap-3 mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-flag me-1"></i>
                                            Prioritas: <?= ucfirst($issue['priority']) ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            Penerima: <?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?= date('d/m/Y', strtotime($issue['created_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                                <a href="<?= base_url('client/issues/' . $issue['id']) ?>" class="btn btn-sm btn-outline-primary" data-detail-link data-id="<?= $issue['id'] ?>">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p id="loadingMessage">Memuat data...</p>
    </div>
</div>

<script>
// Loading Overlay functions
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(message = 'Memuat data...') {
    if (loadingOverlay) {
        if (loadingMessage) loadingMessage.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        loadingOverlay.style.display = 'flex';
    }
}

function hideLoading() {
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
}

// Loading untuk tombol create
document.getElementById('btnCreate')?.addEventListener('click', function(e) {
    showLoading('Membuka form laporan kendala...');
});
document.getElementById('btnCreateFirst')?.addEventListener('click', function(e) {
    showLoading('Membuka form laporan kendala...');
});

// Loading untuk tombol detail
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        showLoading('Memuat detail kendala...');
    });
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto close alerts
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>