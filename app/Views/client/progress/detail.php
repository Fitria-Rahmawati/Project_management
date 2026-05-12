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
        border-top-color: #36b9cc;
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
        color: #36b9cc;
        font-weight: 500;
    }

    .progress-header {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        padding: 25px;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
    }
    .stat-box {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .stat-box:hover {
        transform: translateY(-3px);
    }
    .priority-high { background: #e74a3b; color: white; }
    .priority-medium { background: #f6c23e; color: #333; }
    .priority-low { background: #1cc88a; color: white; }
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
        background: #36b9cc;
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
    .btn-lapor {
        background: #dc3545;
        border: none;
        padding: 5px 12px;
        border-radius: 6px;
        color: white;
        font-size: 12px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-lapor:hover {
        background: #c82333;
        transform: translateY(-2px);
        color: white;
    }
</style>

<div class="container-fluid">
    <!-- Tombol Kembali & Export -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="<?= base_url('client/progress') ?>" class="btn-back" id="btnBack">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Progress Report
        </a>
        <a href="<?= base_url('client/export-progress') ?>" class="btn-pdf" target="_blank" id="btnExport">
            <i class="fas fa-file-pdf me-2"></i> Export PDF
        </a>
    </div>

    <!-- Header -->
    <div class="progress-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1"><?= esc($project['project_name']) ?></h3>
                <p class="mb-0 opacity-75">Progress Detail</p>
            </div>
            <div class="text-center">
                <h2 class="mb-0"><?= $project['progress'] ?>%</h2>
                <small>Progress</small>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h3 class="mb-0"><?= $project['total_issues'] ?></h3>
                <small class="text-muted">Total Kendala</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3 class="mb-0"><?= $project['completed_issues'] ?></h3>
                <small class="text-muted">Kendala Selesai</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h3 class="mb-0"><?= $project['open_issues'] ?></h3>
                <small class="text-muted">Kendala Aktif</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                <h3 class="mb-0"><?= date('d/m/Y', strtotime($project['start_date'])) ?></h3>
                <small class="text-muted">Tanggal Mulai</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Chart Kendala per Status -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Kendala Berdasarkan Status</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Kendala per Prioritas -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Kendala Berdasarkan Prioritas</h6>
                </div>
                <div class="card-body">
                    <canvas id="priorityChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Aktivitas -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">
                <i class="fas fa-history me-2 text-info"></i>
                Timeline Aktivitas
            </h6>
        </div>
        <div class="card-body">
            <?php if(empty($timeline)): ?>
                <p class="text-muted text-center mb-0">Belum ada aktivitas</p>
            <?php else: ?>
                <?php foreach($timeline as $item): ?>
                    <div class="timeline-item">
                        <small class="text-muted"><?= date('d M Y H:i', strtotime($item['date'])) ?></small>
                        <p class="mb-0">
                            <?php if($item['type'] == 'issue'): ?>
                                <i class="fas fa-bug text-danger me-2"></i>
                            <?php else: ?>
                                <i class="fas fa-comment text-info me-2"></i>
                            <?php endif; ?>
                            <?= esc($item['description']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Daftar Kendala -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="fas fa-list me-2 text-primary"></i>
                Daftar Kendala
            </h6>
            <a href="<?= base_url('client/issues/create?project_id=' . $project['id']) ?>" class="btn-lapor" id="btnLapor">
                <i class="fas fa-plus me-1"></i> Lapor Kendala
            </a>
        </div>
        <div class="card-body">
            <?php if(empty($issues)): ?>
                <p class="text-muted text-center mb-0">Belum ada kendala</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Penerima</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($issues as $issue): ?>
                                <tr>
                                    <td><?= esc($issue['title']) ?></td>
                                    <td>
                                        <span class="badge <?= $issue['priority'] == 'high' ? 'bg-danger' : ($issue['priority'] == 'medium' ? 'bg-warning' : 'bg-success') ?>">
                                            <?= ucfirst($issue['priority']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $issue['status'] == 'done' ? 'bg-success' : ($issue['status'] == 'in_progress' ? 'bg-warning' : 'bg-secondary') ?>">
                                            <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                                        </span>
                                    </td>
                                    <td><?= $issue['assignee_name'] ?? '-' ?></td>
                                    <td><?= $issue['due_date'] ? date('d/m/Y', strtotime($issue['due_date'])) : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

// Chart Status
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = <?= json_encode($issuesByStatus) ?>;
const statusLabels = statusData.map(item => item.status);
const statusValues = statusData.map(item => item.total);

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#858796']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

// Chart Priority
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
const priorityData = <?= json_encode($issuesByPriority) ?>;
const priorityLabels = priorityData.map(item => item.priority);
const priorityValues = priorityData.map(item => item.total);

new Chart(priorityCtx, {
    type: 'bar',
    data: {
        labels: priorityLabels,
        datasets: [{
            label: 'Jumlah Kendala',
            data: priorityValues,
            backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a'],
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1,
                grid: {
                    color: '#e3e6f0'
                }
            },
            x: {
                grid: {
                    display: false
                }
            }
        }
    }
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke progress report...');
});
document.getElementById('btnExport')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file PDF...');
    setTimeout(() => {
        hideLoading();
    }, 2000);
});
document.getElementById('btnLapor')?.addEventListener('click', function(e) {
    showLoading('Membuka form laporan kendala...');
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto close alerts jika ada
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>