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
    .detail-page {
        padding: 20px;
        background: var(--bg);
        min-height: 100vh;
    }

    /* ==================== HEADER CARD ==================== */
    .header-card {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .btn-back {
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 8px 18px;
        border-radius: 10px;
        color: var(--gray);
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: var(--border);
        color: var(--dark);
    }
    .btn-export {
        background: var(--danger-light);
        border: none;
        padding: 8px 18px;
        border-radius: 10px;
        color: var(--danger);
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-export:hover {
        background: var(--danger);
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== PROJECT HEADER ==================== */
    .project-header {
        background: linear-gradient(135deg, var(--info), #1d7a8a);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 25px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .project-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .project-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .project-company {
        font-size: 13px;
        opacity: 0.9;
        margin-bottom: 15px;
    }
    .progress-badge {
        background: rgba(255,255,255,0.2);
        padding: 8px 16px;
        border-radius: 30px;
        font-size: 14px;
        font-weight: 600;
    }

    /* ==================== INFO GRID ==================== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .info-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .info-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .info-label i {
        font-size: 12px;
    }
    .info-value {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
    }
    .progress-wrapper {
        margin-top: 15px;
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

    /* ==================== DETAIL SECTION ==================== */
    .detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
        margin-bottom: 25px;
    }
    .detail-header {
        padding: 18px 25px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .detail-header i {
        font-size: 20px;
        color: var(--primary);
    }
    .detail-header h5 {
        margin: 0;
        font-weight: 700;
        color: var(--dark);
    }
    .detail-body {
        padding: 25px;
    }
    .description-text {
        background: var(--bg);
        padding: 20px;
        border-radius: 12px;
        line-height: 1.6;
        color: var(--dark);
    }

    /* ==================== COMMENT SECTION ==================== */
    .comment-box {
        background: var(--bg);
        border-radius: 16px;
        padding: 20px;
        margin-top: 20px;
        border-left: 4px solid var(--info);
    }
    .comment-header {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }
    .comment-header i {
        font-size: 18px;
        color: var(--info);
    }
    .comment-header strong {
        color: var(--dark);
    }
    .comment-text {
        color: var(--dark);
        line-height: 1.5;
        margin-bottom: 10px;
    }
    .comment-date {
        font-size: 11px;
        color: var(--gray);
    }
    .btn-submit {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        color: white;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
    }
    .btn-submit:disabled {
        opacity: 0.7;
        cursor: wait;
        transform: none;
    }

    /* ==================== ISSUE CARD ==================== */
    .issue-card {
        background: white;
        border-left: 4px solid;
        border-radius: 12px;
        margin-bottom: 15px;
        transition: all 0.3s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .issue-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .priority-high { border-left-color: var(--danger); }
    .priority-medium { border-left-color: var(--warning); }
    .priority-low { border-left-color: var(--success); }
    .issue-title {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 5px;
    }
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
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
        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .detail-page { padding: 15px; }
        .info-grid { grid-template-columns: 1fr; }
        .project-header { padding: 20px; }
        .project-title { font-size: 20px; }
        .header-card { flex-direction: column; }
        .btn-back, .btn-export { width: 100%; justify-content: center; }
    }
</style>

<div class="detail-page">
    <!-- Header Card -->
    <div class="header-card">
        <a href="<?= base_url('client/projects') ?>" class="btn-back" id="btnBack">
            <i class="fas fa-arrow-left"></i> Kembali ke Daftar Proyek
        </a>
        <a href="<?= base_url('client/export-project/' . $project['id']) ?>" class="btn-export" target="_blank" id="btnExport">
            <i class="fas fa-file-pdf"></i> Export PDF
        </a>
    </div>

    <!-- Project Header -->
    <div class="project-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="project-title"><?= esc($project['project_name']) ?></div>
                <div class="project-company">
                    <i class="fas fa-building me-1"></i> 
                    <?= session()->get('company_name') ?? 'Perusahaan Anda' ?>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <span class="progress-badge">
                    <i class="fas fa-chart-line me-1"></i>
                    Progress: <?= $project['progress'] ?? 0 ?>%
                </span>
            </div>
        </div>
    </div>

    <!-- Info Grid -->
    <div class="info-grid">
        <div class="info-card">
            <div class="info-label"><i class="fas fa-calendar-alt text-info"></i> TANGGAL MULAI</div>
            <div class="info-value"><?= date('d F Y', strtotime($project['start_date'])) ?></div>
        </div>
        <div class="info-card">
            <div class="info-label"><i class="fas fa-calendar-check text-warning"></i> TANGGAL BERAKHIR</div>
            <div class="info-value"><?= $project['end_date'] ? date('d F Y', strtotime($project['end_date'])) : 'Belum ditentukan' ?></div>
        </div>
        <div class="info-card">
            <div class="info-label"><i class="fas fa-tag text-primary"></i> STATUS PROYEK</div>
            <div class="info-value">
                <?php
                $statusClass = '';
                $statusText = '';
                switch($project['status']) {
                    case 'active':
                    case 'in_progress':
                        $statusClass = 'badge bg-warning text-dark';
                        $statusText = 'Sedang Berjalan';
                        break;
                    case 'completed':
                        $statusClass = 'badge bg-success';
                        $statusText = 'Selesai';
                        break;
                    case 'on_hold':
                        $statusClass = 'badge bg-danger';
                        $statusText = 'Ditunda';
                        break;
                    default:
                        $statusClass = 'badge bg-secondary';
                        $statusText = ucfirst($project['status']);
                }
                ?>
                <span class="<?= $statusClass ?> px-3 py-2"><?= $statusText ?></span>
            </div>
        </div>
        <div class="info-card">
            <div class="info-label"><i class="fas fa-chart-line text-primary"></i> PROGRESS</div>
            <div class="info-value">
                <div class="d-flex justify-content-between mb-1">
                    <small><?= $project['progress'] ?? 0 ?>%</small>
                </div>
                <div class="progress">
                    <div class="progress-bar" style="width: <?= $project['progress'] ?? 0 ?>%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Deskripsi -->
    <div class="detail-card">
        <div class="detail-header">
            <i class="fas fa-align-left"></i>
            <h5>Deskripsi Proyek</h5>
        </div>
        <div class="detail-body">
            <div class="description-text">
                <?= nl2br(htmlspecialchars($project['description'] ?? '-')) ?>
            </div>
        </div>
    </div>

    <!-- Komentar -->
    <div class="detail-card">
        <div class="detail-header">
            <i class="fas fa-comment-dots text-info"></i>
            <h5>Komentar / Masukan</h5>
        </div>
        <div class="detail-body">
            <form action="<?= base_url('client/projects/comment/' . $project['id']) ?>" method="post" id="commentForm">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <textarea name="comment" class="form-control" rows="4" 
                              placeholder="Tulis komentar atau masukan Anda tentang proyek ini..." 
                              style="border-radius: 12px; border: 2px solid var(--border);"></textarea>
                </div>
                <button type="submit" class="btn-submit" id="btnComment">
                    <i class="fas fa-paper-plane me-2"></i> Kirim Komentar
                </button>
            </form>
            
            <?php if(!empty($project['client_comments'])): ?>
                <div class="comment-box">
                    <div class="comment-header">
                        <i class="fas fa-user-circle"></i>
                        <strong>Komentar Anda Sebelumnya</strong>
                    </div>
                    <div class="comment-text">
                        <?= nl2br(htmlspecialchars($project['client_comments'])) ?>
                    </div>
                    <div class="comment-date">
                        <i class="fas fa-clock me-1"></i>
                        Terakhir diperbarui: <?= date('d/m/Y H:i', strtotime($project['comments_updated_at'])) ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Daftar Issues -->
    <div class="detail-card">
        <div class="detail-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-exclamation-triangle text-danger"></i>
                <h5 class="d-inline-block ms-2">Daftar Kendala / Issues</h5>
            </div>
            <a href="<?= base_url('client/issues/create?project_id=' . $project['id']) ?>" class="btn btn-danger btn-sm" id="btnLapor">
                <i class="fas fa-plus me-1"></i> Lapor Kendala
            </a>
        </div>
        <div class="detail-body">
            <?php if(empty($issues)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p class="text-muted mb-0">Belum ada kendala yang dilaporkan</p>
                </div>
            <?php else: ?>
                <?php foreach($issues as $issue): ?>
                    <?php
                    $priorityClass = '';
                    $priorityText = '';
                    $priorityIcon = '';
                    switch($issue['priority']) {
                        case 'high':
                            $priorityClass = 'priority-high';
                            $priorityText = 'Tinggi';
                            $priorityIcon = 'fa-arrow-up';
                            break;
                        case 'medium':
                            $priorityClass = 'priority-medium';
                            $priorityText = 'Sedang';
                            $priorityIcon = 'fa-minus';
                            break;
                        case 'low':
                            $priorityClass = 'priority-low';
                            $priorityText = 'Rendah';
                            $priorityIcon = 'fa-arrow-down';
                            break;
                        default:
                            $priorityClass = 'priority-medium';
                            $priorityText = ucfirst($issue['priority']);
                            $priorityIcon = 'fa-tag';
                    }
                    
                    $statusBadge = '';
                    $statusClass = '';
                    switch($issue['status']) {
                        case 'open':
                            $statusBadge = '<span class="badge-status bg-danger text-white"><i class="fas fa-circle me-1"></i>Open</span>';
                            break;
                        case 'in_progress':
                            $statusBadge = '<span class="badge-status bg-warning text-dark"><i class="fas fa-spinner fa-spin me-1"></i>In Progress</span>';
                            break;
                        case 'done':
                            $statusBadge = '<span class="badge-status bg-success text-white"><i class="fas fa-check-circle me-1"></i>Done</span>';
                            break;
                        default:
                            $statusBadge = '<span class="badge-status bg-secondary text-white">' . ucfirst($issue['status']) . '</span>';
                    }
                    ?>
                    <div class="issue-card card <?= $priorityClass ?>">
                        <div class="card-body p-3">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="issue-title"><?= esc($issue['title']) ?></div>
                                    <p class="text-muted small mb-2"><?= esc($issue['description']) ?></p>
                                    <div class="d-flex flex-wrap gap-3">
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            Penerima: <?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?>
                                        </small>
                                        <?php if($issue['due_date']): ?>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                Deadline: <?= date('d M Y', strtotime($issue['due_date'])) ?>
                                            </small>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col-md-4 text-md-end mt-2 mt-md-0">
                                    <?= $statusBadge ?>
                                    <div class="mt-1">
                                        <span class="badge bg-light text-dark">
                                            <i class="fas <?= $priorityIcon ?> me-1"></i>
                                            Prioritas: <?= $priorityText ?>
                                        </span>
                                    </div>
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

// Validasi dan loading untuk form komentar
document.getElementById('commentForm')?.addEventListener('submit', function(e) {
    const comment = this.querySelector('textarea[name="comment"]');
    if (!comment.value.trim()) {
        e.preventDefault();
        alert('Komentar tidak boleh kosong!');
        comment.focus();
        return false;
    }
    
    const btn = document.getElementById('btnComment');
    btn.disabled = true;
    btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> Mengirim...';
    showLoading('Mengirim komentar...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar proyek...');
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