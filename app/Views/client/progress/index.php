<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== VARIABLES ==================== */
    :root {
        --primary: #4e73df;
        --primary-light: #e8f0fe;
        --success: #1cc88a;
        --success-light: #e3f9e9;
        --warning: #f6c23e;
        --warning-light: #fff3e0;
        --danger: #e74a3b;
        --danger-light: #fee2e2;
        --info: #36b9cc;
        --info-light: #e1f5fe;
        --dark: #5a5c69;
        --gray: #858796;
        --border: #e3e6f0;
        --bg: #f8f9fc;
    }

    /* ==================== PAGE LAYOUT ==================== */
    .progress-page {
        padding: 20px;
        background: var(--bg);
        min-height: 100vh;
    }

    /* ==================== HEADER ==================== */
    .header-card {
        background: white;
        border-radius: 20px;
        padding: 25px 30px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .header-title h1 {
        font-size: 24px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 5px 0;
    }
    .header-title p {
        font-size: 13px;
        color: var(--gray);
        margin: 0;
    }
    .date-badge {
        background: var(--bg);
        padding: 8px 18px;
        border-radius: 30px;
        color: var(--gray);
        font-size: 13px;
        font-weight: 500;
    }

    /* ==================== STATS CARDS ==================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stats-card {
        background: white;
        border-radius: 20px;
        padding: 22px 20px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border-bottom: 3px solid transparent;
    }
    .stats-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .stats-card.blue { border-bottom-color: var(--primary); }
    .stats-card.green { border-bottom-color: var(--success); }
    .stats-card.orange { border-bottom-color: var(--warning); }
    .stats-card.purple { border-bottom-color: #9c27b0; }
    .stats-card i {
        font-size: 32px;
        margin-bottom: 12px;
        display: inline-block;
    }
    .stats-card h2 {
        font-size: 32px;
        font-weight: 700;
        margin: 0;
        color: var(--dark);
    }
    .stats-card small {
        font-size: 12px;
        color: var(--gray);
    }

    /* ==================== CHART CARD ==================== */
    .chart-card {
        background: white;
        border-radius: 20px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .chart-header {
        padding: 18px 25px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .chart-header i {
        font-size: 20px;
        color: var(--info);
    }
    .chart-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--dark);
    }
    .chart-body {
        padding: 25px;
    }
    canvas {
        max-height: 300px;
        width: 100%;
    }

    /* ==================== PROJECT PROGRESS CARD ==================== */
    .project-card {
        background: white;
        border-radius: 20px;
        margin-bottom: 15px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
        border-left: 4px solid;
        overflow: hidden;
    }
    .project-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .project-card.status-done { border-left-color: var(--success); }
    .project-card.status-progress { border-left-color: var(--warning); }
    .project-card.status-open { border-left-color: var(--danger); }
    .project-body {
        padding: 20px;
    }
    .project-info h6 {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 5px 0;
    }
    .project-date {
        font-size: 12px;
        color: var(--gray);
    }
    .progress-wrapper {
        margin: 15px 0;
    }
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .progress-label span:first-child {
        font-size: 11px;
        color: var(--gray);
    }
    .progress-label span:last-child {
        font-size: 12px;
        font-weight: 700;
        color: var(--info);
    }
    .progress {
        height: 8px;
        border-radius: 10px;
        background: var(--border);
    }
    .progress-bar {
        background: linear-gradient(135deg, var(--info), #1d7a8a);
        border-radius: 10px;
    }
    .stats-badge {
        display: flex;
        gap: 15px;
        margin-top: 10px;
    }
    .stats-badge span {
        font-size: 12px;
        color: var(--gray);
    }
    .stats-badge span i {
        margin-right: 4px;
    }
    .stats-badge .text-success i { color: var(--success); }
    .stats-badge .text-warning i { color: var(--warning); }
    .btn-detail {
        background: var(--primary-light);
        color: var(--primary);
        border: none;
        padding: 8px 20px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-detail:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== EMPTY STATE ==================== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state i {
        font-size: 64px;
        color: var(--border);
        margin-bottom: 20px;
    }
    .empty-state h4 {
        font-size: 18px;
        color: var(--dark);
        margin-bottom: 8px;
    }
    .empty-state p {
        color: var(--gray);
        margin-bottom: 20px;
    }

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
        border: 3px solid var(--border);
        border-top-color: var(--primary);
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
        color: var(--primary);
        font-weight: 500;
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .progress-page { padding: 15px; }
        .header-card { padding: 20px; flex-direction: column; text-align: center; }
        .stats-grid { grid-template-columns: 1fr; }
        .project-body .row { flex-direction: column; text-align: center; }
        .btn-detail { margin-top: 15px; width: 100%; }
        .stats-badge { justify-content: center; }
    }
</style>

<div class="progress-page">
    <!-- Header -->
    <div class="header-card">
        <div class="header-title">
            <h1><i class="fas fa-chart-line me-2" style="color: var(--primary);"></i> Progress Report</h1>
            <p>Pantau perkembangan proyek Anda</p>
        </div>
        <div class="date-badge">
            <i class="fas fa-calendar-alt me-2"></i> <?= date('d F Y') ?>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Grid -->
    <div class="stats-grid">
        <div class="stats-card blue">
            <i class="fas fa-briefcase text-info"></i>
            <h2><?= $totalProjects ?></h2>
            <small>Total Proyek</small>
        </div>
        <div class="stats-card green">
            <i class="fas fa-chart-line text-success"></i>
            <h2><?= $averageProgress ?>%</h2>
            <small>Rata-rata Progress</small>
        </div>
        <div class="stats-card orange">
            <i class="fas fa-tasks text-warning"></i>
            <h2><?= $totalIssuesAll ?></h2>
            <small>Total Kendala</small>
        </div>
        <div class="stats-card purple">
            <i class="fas fa-check-circle text-primary"></i>
            <h2><?= $overallCompletion ?>%</h2>
            <small>Penyelesaian Keseluruhan</small>
        </div>
    </div>

    <!-- Chart Card -->
    <div class="chart-card">
        <div class="chart-header">
            <i class="fas fa-chart-line"></i>
            <h5>Tren Progress 6 Bulan Terakhir</h5>
        </div>
        <div class="chart-body">
            <canvas id="progressChart" height="80"></canvas>
        </div>
    </div>

    <!-- Projects Progress List -->
    <div class="chart-card">
        <div class="chart-header">
            <i class="fas fa-project-diagram"></i>
            <h5>Progress Per Proyek</h5>
        </div>
        <div class="chart-body" style="padding: 0 25px 25px 25px;">
            <?php if(empty($projects)): ?>
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h4>Belum Ada Proyek</h4>
                    <p>Anda belum memiliki proyek</p>
                </div>
            <?php else: ?>
                <?php foreach($projects as $project): ?>
                    <?php
                    $statusClass = '';
                    if($project['progress'] >= 75) $statusClass = 'status-done';
                    elseif($project['progress'] >= 25) $statusClass = 'status-progress';
                    else $statusClass = 'status-open';
                    ?>
                    <div class="project-card <?= $statusClass ?>">
                        <div class="project-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h6><?= esc($project['project_name']) ?></h6>
                                    <div class="project-date">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                                        <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="progress-wrapper">
                                        <div class="progress-label">
                                            <span>Progress</span>
                                            <span><?= $project['progress'] ?>%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" style="width: <?= $project['progress'] ?>%"></div>
                                        </div>
                                    </div>
                                    <div class="stats-badge">
                                        <span class="text-success"><i class="fas fa-check-circle"></i> Selesai: <?= $project['completed_issues'] ?></span>
                                        <span class="text-warning"><i class="fas fa-clock"></i> Tertunda: <?= $project['open_issues'] ?></span>
                                    </div>
                                </div>
                                <div class="col-md-3 text-md-end">
                                    <a href="<?= base_url('client/progress/detail/' . $project['id']) ?>" class="btn-detail" data-detail-link data-name="<?= esc($project['project_name']) ?>">
                                        <i class="fas fa-chart-line me-1"></i> Detail Progress
                                    </a>
                                </div>
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

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Progress Bulanan
const ctx = document.getElementById('progressChart').getContext('2d');
const monthlyData = <?= json_encode($monthlyProgress) ?>;

const labels = monthlyData.map(item => {
    const [year, month] = item.month.split('-');
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    return monthNames[parseInt(month) - 1] + ' ' + year;
});

const totalData = monthlyData.map(item => item.total);
const completedData = monthlyData.map(item => item.completed);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total Kendala',
                data: totalData,
                borderColor: '#e74a3b',
                backgroundColor: 'rgba(231, 74, 59, 0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#e74a3b'
            },
            {
                label: 'Kendala Selesai',
                data: completedData,
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#1cc88a'
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
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

// Loading Overlay functions
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(message = 'Memuat data...') {
    if (loadingOverlay) {
        if (loadingMessage) loadingMessage.textContent = message;
        loadingOverlay.style.display = 'flex';
    }
}

function hideLoading() {
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
}

// Loading untuk tombol detail
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const projectName = this.getAttribute('data-name') || 'Project';
        showLoading(`Memuat detail progress ${projectName}...`);
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