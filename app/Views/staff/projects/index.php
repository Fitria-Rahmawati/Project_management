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
        border-top-color: #4e73df;
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
        color: #4e73df;
        font-weight: 500;
    }

    /* ==================== STATS CARDS ==================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .stat-info h3 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        color: #5a5c69;
    }
    .stat-info p {
        font-size: 12px;
        color: #858796;
        margin: 5px 0 0;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-icon.blue { background: #e8f0fe; color: #4e73df; }
    .stat-icon.green { background: #e3f9e9; color: #1cc88a; }
    .stat-icon.orange { background: #fff3e0; color: #f6c23e; }
    .stat-icon.purple { background: #f3e5f5; color: #9c27b0; }

    /* ==================== PROJECT CARD ==================== */
    .project-card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: all 0.3s;
        margin-bottom: 20px;
        overflow: hidden;
    }
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    .card-header-custom {
        padding: 18px 20px;
        border-bottom: 1px solid #e3e6f0;
        background: white;
    }
    .project-name {
        font-size: 16px;
        font-weight: 700;
        color: #5a5c69;
        margin: 0;
    }
    .card-body-custom {
        padding: 20px;
    }
    .date-info {
        font-size: 12px;
        color: #858796;
        margin-bottom: 15px;
    }
    .date-info i {
        margin-right: 6px;
    }
    .progress-wrapper {
        margin-bottom: 15px;
    }
    .progress-label {
        display: flex;
        justify-content: space-between;
        margin-bottom: 6px;
    }
    .progress-label span:first-child {
        font-size: 11px;
        color: #858796;
    }
    .progress-label span:last-child {
        font-size: 12px;
        font-weight: 700;
        color: #36b9cc;
    }
    .progress {
        height: 8px;
        border-radius: 10px;
        background: #e3e6f0;
    }
    .progress-bar {
        background: linear-gradient(135deg, #36b9cc, #258391);
        border-radius: 10px;
    }
    .btn-detail {
        background: #e8f0fe;
        color: #4e73df;
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
        text-align: center;
        display: inline-block;
        text-decoration: none;
    }
    .btn-detail:hover {
        background: #4e73df;
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== EMPTY STATE ==================== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        background: white;
        border-radius: 20px;
    }
    .empty-state i {
        font-size: 64px;
        color: #e3e6f0;
        margin-bottom: 20px;
    }
    .empty-state h4 {
        font-size: 18px;
        color: #5a5c69;
        margin-bottom: 8px;
    }
    .empty-state p {
        color: #858796;
        margin-bottom: 20px;
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-project-diagram me-2 text-primary"></i>
            My Projects
        </h1>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <?php 
    $totalProjects = count($projects);
    $activeProjects = 0;
    $completedProjects = 0;
    $totalProgress = 0;
    foreach($projects as $p) {
        if($p['status'] == 'completed' || $p['status'] == 'Done') {
            $completedProjects++;
        } else {
            $activeProjects++;
        }
        $totalProgress += $p['progress'] ?? 0;
    }
    $avgProgress = $totalProjects > 0 ? round($totalProgress / $totalProjects, 1) : 0;
    ?>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $totalProjects ?></h3>
                <p>Total Proyek</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-folder"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $activeProjects ?></h3>
                <p>Proyek Aktif</p>
            </div>
            <div class="stat-icon green"><i class="fas fa-play-circle"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $completedProjects ?></h3>
                <p>Proyek Selesai</p>
            </div>
            <div class="stat-icon purple"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $avgProgress ?>%</h3>
                <p>Rata-rata Progress</p>
            </div>
            <div class="stat-icon orange"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>

    <!-- Projects Grid -->
    <div class="row">
        <?php if(empty($projects)): ?>
            <div class="col-12">
                <div class="empty-state">
                    <i class="fas fa-folder-open"></i>
                    <h4>Belum Ada Proyek</h4>
                    <p>Anda belum ditugaskan ke proyek apapun</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="project-card card">
                        <div class="card-header-custom">
                            <h6 class="project-name"><?= esc($project['project_name']) ?></h6>
                        </div>
                        <div class="card-body-custom">
                            <div class="date-info">
                                <i class="fas fa-calendar-alt"></i>
                                <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                                <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                            </div>
                            
                            <div class="progress-wrapper">
                                <div class="progress-label">
                                    <span>Progress</span>
                                    <span><?= $project['progress'] ?? 0 ?>%</span>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $project['progress'] ?? 0 ?>%"></div>
                                </div>
                            </div>
                            
                            <a href="<?= base_url('staff/projects/' . $project['id']) ?>" class="btn-detail" data-detail-link data-name="<?= esc($project['project_name']) ?>">
                                <i class="fas fa-eye me-2"></i> Detail Proyek
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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

// Loading untuk tombol detail
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const projectName = this.getAttribute('data-name') || 'Project';
        showLoading(`Memuat detail ${projectName}...`);
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