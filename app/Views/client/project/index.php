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

    /* ==================== PAGE LAYOUT ==================== */
    .projects-page {
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
    .btn-report {
        background: linear-gradient(135deg, var(--danger), #c0392b);
        border: none;
        padding: 10px 24px;
        border-radius: 12px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        text-decoration: none;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-report:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(231, 74, 59, 0.3);
        color: white;
    }

    /* ==================== STATS ==================== */
    .stats-row {
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
        color: var(--dark);
    }
    .stat-info p {
        font-size: 12px;
        color: var(--gray);
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
    .stat-icon.blue { background: var(--primary-light); color: var(--primary); }
    .stat-icon.green { background: var(--success-light); color: var(--success); }
    .stat-icon.orange { background: var(--warning-light); color: var(--warning); }
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
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .project-name {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    .badge-custom {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-active { background: var(--success-light); color: var(--success); }
    .badge-completed { background: var(--primary-light); color: var(--primary); }
    .badge-pending { background: var(--warning-light); color: var(--warning); }
    .card-body-custom {
        padding: 20px;
    }
    .date-info {
        font-size: 12px;
        color: var(--gray);
        margin-bottom: 15px;
    }
    .date-info i {
        margin-right: 6px;
        width: 16px;
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
    .btn-detail {
        background: var(--primary-light);
        color: var(--primary);
        border: none;
        padding: 8px 16px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s;
        width: 100%;
        margin-bottom: 15px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .btn-detail:hover {
        background: var(--primary);
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== COMMENT SECTION ==================== */
    .comment-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    .comment-header small {
        font-size: 11px;
        color: var(--gray);
    }
    .comment-header small i {
        margin-right: 4px;
    }
    .comment-input-group {
        display: flex;
        gap: 10px;
        margin-bottom: 12px;
    }
    .comment-input-group textarea {
        flex: 1;
        padding: 10px 12px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 13px;
        resize: none;
        transition: all 0.3s;
        font-family: inherit;
    }
    .comment-input-group textarea:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }
    .btn-send {
        background: var(--primary);
        border: none;
        padding: 0 18px;
        border-radius: 12px;
        color: white;
        transition: all 0.3s;
        cursor: pointer;
    }
    .btn-send:hover {
        background: #2e59d9;
        transform: translateY(-2px);
    }
    .btn-send:disabled {
        opacity: 0.6;
        cursor: wait;
        transform: none;
    }
    .comment-box {
        background: var(--bg);
        border-radius: 12px;
        padding: 12px;
        margin-top: 12px;
        border-left: 3px solid var(--info);
    }
    .comment-text {
        font-size: 13px;
        color: var(--dark);
        margin-bottom: 6px;
        line-height: 1.4;
    }
    .comment-date {
        font-size: 10px;
        color: var(--gray);
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

    /* ==================== ALERT ==================== */
    .alert {
        border-radius: 12px;
        border: none;
    }
    .alert-success {
        background: var(--success-light);
        color: var(--success);
    }
    .alert-danger {
        background: var(--danger-light);
        color: var(--danger);
    }
    .alert-warning {
        background: var(--warning-light);
        color: var(--warning);
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .stats-row {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .projects-page { padding: 15px; }
        .header-card { padding: 20px; flex-direction: column; text-align: center; }
        .stats-row { grid-template-columns: 1fr; }
        .btn-report { width: 100%; justify-content: center; }
        .comment-input-group { flex-direction: column; }
        .btn-send { padding: 10px; }
    }
</style>

<div class="projects-page">
    <!-- Header -->
    <div class="header-card">
        <div class="header-title">
            <h1><i class="fas fa-project-diagram me-2" style="color: var(--primary);"></i> My Projects</h1>
            <p>Kelola dan pantau proyek Anda</p>
        </div>
        <a href="<?= base_url('client/issues/create') ?>" class="btn-report" id="btnReport">
            <i class="fas fa-exclamation-circle me-2"></i> Report Issue
        </a>
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

    <?php if(session()->getFlashdata('contract_warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-triangle me-2"></i> <?= session()->getFlashdata('contract_warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Row -->
    <?php 
    $totalProjects = count($projects);
    $completedProjects = 0;
    $activeProjects = 0;
    $totalProgress = 0;
    foreach($projects as $p) {
        if($p['status'] == 'completed') $completedProjects++;
        else $activeProjects++;
        $totalProgress += $p['progress'] ?? 0;
    }
    $avgProgress = $totalProjects > 0 ? round($totalProgress / $totalProjects, 1) : 0;
    ?>
    <div class="stats-row">
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
                    <p>Anda belum memiliki proyek apapun</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="project-card card">
                        <div class="card-header-custom">
                            <h6 class="project-name"><?= esc($project['project_name']) ?></h6>
                            <span class="badge-custom <?= $project['status'] == 'completed' ? 'badge-completed' : ($project['status'] == 'active' || $project['status'] == 'in_progress' ? 'badge-active' : 'badge-pending') ?>">
                                <?= ucfirst($project['status'] ?? 'Active') ?>
                            </span>
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
                            
                            <a href="<?= base_url('client/projects/' . $project['id']) ?>" class="btn-detail" data-detail-link data-name="<?= esc($project['project_name']) ?>">
                                <i class="fas fa-eye me-2"></i> Detail Proyek
                            </a>
                            
                            <!-- Komentar Section -->
                            <div class="border-top pt-3">
                                <div class="comment-header">
                                    <small><i class="fas fa-comment-dots me-1"></i> Beri Komentar</small>
                                    <?php if(!empty($project['client_comments'])): ?>
                                        <small><i class="fas fa-history me-1"></i> <?= date('d/m/Y H:i', strtotime($project['comments_updated_at'])) ?></small>
                                    <?php endif; ?>
                                </div>
                                
                                <form action="<?= base_url('client/projects/comment/' . $project['id']) ?>" method="post" class="comment-form">
                                    <?= csrf_field() ?>
                                    <div class="comment-input-group">
                                        <textarea name="comment" rows="2" placeholder="Tulis komentar atau masukan Anda..." required></textarea>
                                        <button type="submit" class="btn-send">
                                            <i class="fas fa-paper-plane"></i>
                                        </button>
                                    </div>
                                </form>
                                
                                <?php if(!empty($project['client_comments'])): ?>
                                    <div class="comment-box">
                                        <div class="comment-text">
                                            <?= nl2br(htmlspecialchars($project['client_comments'])) ?>
                                        </div>
                                        <div class="comment-date">
                                            <i class="fas fa-clock me-1"></i>
                                            Dikirim: <?= date('d/m/Y H:i', strtotime($project['comments_updated_at'])) ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
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

// Loading state untuk form komentar
document.querySelectorAll('.comment-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        const textarea = this.querySelector('textarea');
        if (!textarea.value.trim()) {
            e.preventDefault();
            alert('Komentar tidak boleh kosong!');
            textarea.focus();
            return false;
        }
        
        const btn = this.querySelector('button[type="submit"]');
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        showLoading('Mengirim komentar...');
    });
});

// Loading untuk tombol detail
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const projectName = this.getAttribute('data-name') || 'Project';
        showLoading(`Memuat detail ${projectName}...`);
    });
});

// Loading untuk tombol report
document.getElementById('btnReport')?.addEventListener('click', function(e) {
    showLoading('Membuka form laporan...');
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