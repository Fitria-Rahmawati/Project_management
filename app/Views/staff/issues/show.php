<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
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
</style>

<div class="container-fluid">
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="<?= base_url('staff/issues') ?>" class="btn btn-outline-secondary btn-sm" id="btnBack">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

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
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-align-left me-2 text-primary"></i> Deskripsi Kendala</h5>
                <?php 
                $description = $issue['description'] ?? '-';
                if (is_array($description)) $description = '-';
                ?>
            <?php 
$description = $issue['description'] ?? '-';
// Jika description adalah array, ubah menjadi string
if (is_array($description)) {
    $description = '-';
}
?>
            <?php if(!empty($history)): ?>
                <div class="info-card">
                    <h5 class="mb-3"><i class="fas fa-history me-2 text-primary"></i> Riwayat Perubahan</h5>
                    <?php foreach($history as $h): ?>
                        <div class="timeline-item">
                            <small class="text-muted"><?= date('d M Y H:i', strtotime($h['changed_at'])) ?></small>
                            <p class="mb-0">
                                <?php if($h['old_status'] && $h['new_status']): ?>
                                    Status berubah dari "<?= $h['old_status'] ?>" menjadi "<?= $h['new_status'] ?>"
                                <?php else: ?>
                                    <?= $h['old_status'] ?>
                                <?php endif; ?>
                            </p>
                            <small class="text-muted">Oleh: <?= $h['user_name'] ?? 'System' ?></small>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-info-circle me-2 text-primary"></i> Informasi</h5>
                <table class="table table-sm">
                    <tr><td width="40%">ID Kendala</td><td>: #<?= $issue['id'] ?></td></tr>
                    <tr><td>Dilaporkan Oleh</td><td>: <?= $issue['reporter_name'] ?? session()->get('username') ?></td></tr>
                    <tr><td>Tanggal Lapor</td><td>: <?= date('d/m/Y H:i', strtotime($issue['created_at'])) ?></td></tr>
                    <tr><td>Penerima</td><td>: <?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?></td></tr>
                    <?php if($issue['due_date']): ?>
                    <tr><td>Deadline</td><td>: <?= date('d/m/Y', strtotime($issue['due_date'])) ?></td></tr>
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
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(message = 'Memuat data...') {
    if (loadingOverlay) {
        loadingMessage.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        loadingOverlay.style.display = 'flex';
    }
}

function hideLoading() {
    if (loadingOverlay) loadingOverlay.style.display = 'none';
}

document.getElementById('btnBack')?.addEventListener('click', () => showLoading('Kembali ke daftar...'));
window.addEventListener('load', hideLoading);
setTimeout(() => {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => new bootstrap.Alert(alert).close());
}, 5000);
</script>

<?= $this->endSection() ?>