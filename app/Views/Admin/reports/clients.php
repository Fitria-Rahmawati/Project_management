<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .client-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .client-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .client-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        padding: 20px;
        position: relative;
    }
    .client-avatar {
        width: 70px;
        height: 70px;
        border-radius: 50%;
        background: white;
        color: #667eea;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
        font-weight: 600;
        margin-bottom: 15px;
        border: 3px solid rgba(255,255,255,0.3);
    }
    .client-name {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .client-type {
        font-size: 12px;
        background: rgba(255,255,255,0.2);
        padding: 3px 12px;
        border-radius: 20px;
        display: inline-block;
    }
    .client-body {
        padding: 20px;
    }
    .info-item {
        margin-bottom: 12px;
    }
    .info-label {
        font-size: 11px;
        color: #888;
        margin-bottom: 3px;
    }
    .info-value {
        font-size: 14px;
        color: #333;
        font-weight: 500;
    }
    .stat-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        border: 1px solid #eee;
    }
    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
    }
    .stat-label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
    }
    .progress {
        height: 8px;
        border-radius: 4px;
        background: #f0f0f0;
    }
    .progress-bar {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 4px;
    }
    .summary-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .table-report {
        font-size: 14px;
    }
    .project-item {
        border-left: 3px solid #667eea;
        padding-left: 15px;
        margin-bottom: 15px;
    }
    .project-name {
        font-size: 14px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .project-meta {
        font-size: 12px;
        color: #888;
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
    
    /* Button loading */
    .btn-loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-building me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="<?= base_url('admin/reports/export/clients') ?>" class="btn btn-success btn-sm me-2" id="btnExportExcel">
                    <i class="fas fa-file-export me-2"></i>Export CSV
                </a>
                <a href="<?= base_url('admin/reports/export-client') ?>" class="btn btn-danger btn-sm me-2" target="_blank" id="btnExportPDF">
                    <i class="fas fa-file-pdf me-2"></i>PDF
                </a>
                <a href="<?= base_url('admin/clients') ?>" class="btn btn-secondary btn-sm" id="btnBack">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="summary-card">
                <h6 class="mb-0">Total Clients</h6>
                <h3 class="mt-2 mb-0"><?= count($clients) ?></h3>
                <small>Perusahaan client aktif</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h6 class="mb-0">Total Projects</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_sum(array_column($clients, 'total_projects')) ?>
                </h3>
                <small>Proyek client</small>
            </div>
        </div>
        <div class="col-md-4">
            <div class="summary-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h6 class="mb-0">Total Issues</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_sum(array_column($clients, 'total_issues')) ?>
                </h3>
                <small>Issues dari client</small>
            </div>
        </div>
    </div>
    
    <div class="row">
        <?php if(empty($clients)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-building fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data client</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($clients as $client): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="client-card">
                        <div class="client-header">
                            <div class="client-avatar">
                                <?= strtoupper(substr($client['company_name'], 0, 1)) ?>
                            </div>
                            <div class="client-name"><?= esc($client['company_name']) ?></div>
                            <div class="client-type"><?= ucfirst($client['company_type'] ?? 'client') ?></div>
                        </div>
                        <div class="client-body">
                            <div class="info-item">
                                <div class="info-label">Contact Person</div>
                                <div class="info-value">
                                    <i class="fas fa-user-tie me-2 text-primary"></i>
                                    <?= esc($client['contact_person'] ?? '-') ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Email</div>
                                <div class="info-value">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    <?= esc($client['email'] ?? '-') ?>
                                </div>
                            </div>
                            <div class="info-item">
                                <div class="info-label">Telepon</div>
                                <div class="info-value">
                                    <i class="fas fa-phone me-2 text-primary"></i>
                                    <?= esc($client['phone'] ?? '-') ?>
                                </div>
                            </div>
                            <div class="row mt-4 mb-3">
                                <div class="col-4">
                                    <div class="stat-box">
                                        <div class="stat-number"><?= $client['total_projects'] ?></div>
                                        <div class="stat-label">Projects</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <div class="stat-number"><?= $client['total_issues'] ?></div>
                                        <div class="stat-label">Issues</div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-box">
                                        <div class="stat-number">
                                            <?php 
                                            $completed = ($client['completed_issues'] ?? 0) + ($client['closed_issues'] ?? 0);
                                            echo $completed;
                                            ?>
                                        </div>
                                        <div class="stat-label">Completed</div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            $totalIssues = $client['total_issues'] ?? 0;
                            $completedIssues = ($client['completed_issues'] ?? 0) + ($client['closed_issues'] ?? 0);
                            $completionRate = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
                            ?>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Completion Rate</small>
                                    <small class="text-primary fw-bold"><?= $completionRate ?>%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $completionRate ?>%"></div>
                                </div>
                            </div>
                            <a href="<?= base_url('admin/clients/' . $client['id']) ?>" class="btn btn-outline-primary btn-sm w-100 mt-2" data-detail-link data-id="<?= $client['id'] ?>">
                                <i class="fas fa-eye me-2"></i>Lihat Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    
    <div class="card shadow mt-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-table me-2"></i>Detail Data Client</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-report">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Perusahaan</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Total Projects</th>
                            <th>Total Issues</th>
                            <th>Completed</th>
                            <th>Progress</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($clients)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-4">Tidak ada data client</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($clients as $index => $client): 
                                $totalIssues = $client['total_issues'] ?? 0;
                                $completedIssues = ($client['completed_issues'] ?? 0) + ($client['closed_issues'] ?? 0);
                                $completionRate = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
                            ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= esc($client['company_name']) ?></strong>
                                     </div>
                                     </td>
                                    <td><?= esc($client['contact_person'] ?? '-') ?></td>
                                    <td><?= esc($client['email'] ?? '-') ?></td>
                                    <td><?= esc($client['phone'] ?? '-') ?></td>
                                    <td class="text-center"><?= $client['total_projects'] ?? 0 ?></td>
                                    <td class="text-center"><?= $client['total_issues'] ?? 0 ?></td>
                                    <td class="text-center text-success"><?= $completedIssues ?></td>
                                    <td class="text-center">
                                        <span class="badge bg-<?= $completionRate >= 70 ? 'success' : ($completionRate >= 50 ? 'warning' : 'danger') ?>">
                                            <?= $completionRate ?>%
                                        </span>
                                     </div>
                                     </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
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

// Loading untuk tombol export CSV
document.getElementById('btnExportExcel')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file Excel...');
    setTimeout(() => {
        window.location.href = this.getAttribute('href');
        setTimeout(() => {
            hideLoading();
        }, 1000);
    }, 200);
});

// Loading untuk tombol export PDF
document.getElementById('btnExportPDF')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file PDF...');
    // PDF akan terbuka di tab baru, loading akan hilang setelah beberapa detik
    setTimeout(() => {
        hideLoading();
    }, 2000);
});

// Loading untuk tombol kembali
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke halaman reports...');
});

// Loading untuk tombol lihat detail
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const clientName = this.closest('.client-card')?.querySelector('.client-name')?.innerText || 'Client';
        showLoading(`Memuat detail ${clientName}...`);
    });
});

// Sembunyikan loading saat halaman selesai dimuat
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