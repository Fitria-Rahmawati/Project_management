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

    .detail-header {
        background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
        padding: 25px;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
    }
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .info-card:hover {
        transform: translateY(-3px);
    }
    .timeline-item {
        border-left: 2px solid #e0e0e0;
        padding-left: 20px;
        margin-bottom: 20px;
        position: relative;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #e74a3b;
    }
    .btn-back {
        background: #6c757d;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        color: white;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: #5a6268;
        transform: translateY(-2px);
        color: white;
    }
    .btn-pdf {
        background: #dc3545;
        border: none;
        padding: 8px 20px;
        border-radius: 8px;
        color: white;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-pdf:hover {
        background: #c82333;
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="container-fluid">
    <!-- Tombol Kembali dan Export PDF -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="<?= base_url('client/issues') ?>" class="btn-back" id="btnBack">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="<?= base_url('client/export-issue/' . $issue['id']) ?>" class="btn-pdf" target="_blank" id="btnExport">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
    </div>

    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1"><?= esc($issue['title']) ?></h3>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-folder me-1"></i> <?= esc($issue['project_name']) ?>
                </p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-dark px-3 py-2 mb-2">
                    <i class="fas fa-flag me-1"></i>
                    Prioritas: <?= ucfirst($issue['priority']) ?>
                </span>
                <br>
                <span class="badge <?= $issue['status'] == 'done' ? 'bg-success' : ($issue['status'] == 'in_progress' ? 'bg-warning' : 'bg-secondary') ?> px-3 py-2">
                    <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Deskripsi -->
            <div class="info-card">
                <h5 class="mb-3">
                    <i class="fas fa-align-left me-2 text-primary"></i>
                    Deskripsi Kendala
                </h5>
                <p><?= nl2br(esc((string)($issue['description'] ?? '-'))) ?></p>
            </div>

            <!-- Timeline / History -->
            <?php if(!empty($history)): ?>
                <div class="info-card">
                    <h5 class="mb-3">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Riwayat Perubahan
                    </h5>
                    <?php foreach($history as $h): ?>
                        <div class="timeline-item">
                            <small class="text-muted"><?= date('d M Y H:i', strtotime($h['created_at'])) ?></small>
                            <p class="mb-0"><?= esc($h['description']) ?></p>
                            <?php if(isset($h['changed_by'])): ?>
                                <small class="text-muted">Oleh: <?= esc($h['changed_by']) ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <!-- Informasi -->
            <div class="info-card">
                <h5 class="mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Informasi
                </h5>
                <table class="table table-sm">
                    <tr>
                        <td width="40%">ID Kendala</td>
                        <td width="10%">:</td>
                        <td>#<?= $issue['id'] ?></td>
                    </tr>
                    <tr>
                        <td>Dilaporkan Oleh</td>
                        <td>:</td>
                        <td><?= $issue['reporter_name'] ?? session()->get('username') ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lapor</td>
                        <td>:</td>
                        <td><?= date('d/m/Y H:i', strtotime($issue['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td>Penerima</td>
                        <td>:</td>
                        <td><?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?></td>
                    </tr>
                    <?php if($issue['due_date']): ?>
                    <tr>
                        <td>Deadline</td>
                        <td>:</td>
                        <td><?= date('d/m/Y', strtotime($issue['due_date'])) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
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

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar kendala...');
});

document.getElementById('btnExport')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file PDF...');
    setTimeout(() => {
        hideLoading();
    }, 2000);
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