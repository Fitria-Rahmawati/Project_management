<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .project-header {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        padding: 25px;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
    }
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .info-label {
        font-size: 12px;
        color: #6c757d;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 16px;
        font-weight: 600;
        color: #2d3748;
    }
    .progress {
        height: 8px;
        border-radius: 4px;
    }
    .comment-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-top: 15px;
        border-left: 3px solid #36b9cc;
    }
    .comment-text {
        font-size: 14px;
        margin-bottom: 8px;
        line-height: 1.5;
    }
    .comment-date {
        font-size: 11px;
        color: #999;
    }
    .issue-card {
        border-left: 3px solid;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .issue-card:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .priority-high {
        border-left-color: #e74a3b;
    }
    .priority-medium {
        border-left-color: #f6c23e;
    }
    .priority-low {
        border-left-color: #1cc88a;
    }
    .status-badge {
        padding: 3px 8px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
</style>

<div class="container-fluid">
    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="<?= base_url('client/projects') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar Proyek
        </a>
    </div>

    <!-- Header Proyek -->
    <div class="project-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1"><?= esc($project['project_name']) ?></h3>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-building me-1"></i> 
                    <?= session()->get('company_name') ?? 'Perusahaan Anda' ?>
                </p>
            </div>
            <span class="badge bg-white text-dark px-3 py-2">
                <i class="fas fa-chart-line me-1"></i>
                Progress: <?= $project['progress'] ?? 0 ?>%
            </span>
        </div>
    </div>

    <!-- Informasi Proyek -->
    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-label">Tanggal Mulai</div>
                <div class="info-value">
                    <i class="fas fa-calendar-alt me-2 text-info"></i>
                    <?= date('d F Y', strtotime($project['start_date'])) ?>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-label">Tanggal Berakhir</div>
                <div class="info-value">
                    <i class="fas fa-calendar-check me-2 text-warning"></i>
                    <?= $project['end_date'] ? date('d F Y', strtotime($project['end_date'])) : 'Belum ditentukan' ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="info-card">
                <div class="info-label">Deskripsi Proyek</div>
                <div class="info-value">
                    <?= nl2br(htmlspecialchars($project['description'])) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-label">Status Proyek</div>
                <div class="info-value">
                    <?php
                    $statusClass = '';
                    $statusText = '';
                    switch($project['status']) {
                        case 'active':
                        case 'in_progress':
                            $statusClass = 'bg-warning';
                            $statusText = 'Sedang Berjalan';
                            break;
                        case 'completed':
                            $statusClass = 'bg-success';
                            $statusText = 'Selesai';
                            break;
                        case 'on_hold':
                            $statusClass = 'bg-danger';
                            $statusText = 'Ditunda';
                            break;
                        default:
                            $statusClass = 'bg-secondary';
                            $statusText = ucfirst($project['status']);
                    }
                    ?>
                    <span class="badge <?= $statusClass ?> px-3 py-2">
                        <?= $statusText ?>
                    </span>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-card">
                <div class="info-label">Progress Pengerjaan</div>
                <div class="info-value">
                    <div class="d-flex justify-content-between mb-1">
                        <small><?= $project['progress'] ?? 0 ?>%</small>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: <?= $project['progress'] ?? 0 ?>%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Komentar -->
    <div class="info-card">
        <h5 class="mb-3">
            <i class="fas fa-comment-dots me-2 text-info"></i>
            Komentar / Masukan
        </h5>
        
        <form action="<?= base_url('client/projects/comment/' . $project['id']) ?>" method="post">
            <?= csrf_field() ?>
            <div class="mb-3">
                <textarea name="comment" class="form-control" rows="4" 
                          placeholder="Tulis komentar atau masukan Anda tentang proyek ini..."></textarea>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-paper-plane me-2"></i> Kirim Komentar
            </button>
        </form>
        
        <?php if(!empty($project['client_comments'])): ?>
            <div class="comment-section mt-4">
                <div class="d-flex align-items-center mb-2">
                    <i class="fas fa-user-circle me-2 text-info"></i>
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

    <!-- Daftar Issues/Kendala -->
    <div class="info-card">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">
                <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                Daftar Kendala / Issues
            </h5>
            <a href="<?= base_url('client/issues/create?project_id=' . $project['id']) ?>" class="btn btn-danger btn-sm">
                <i class="fas fa-plus me-1"></i> Lapor Kendala
            </a>
        </div>
        
        <?php if(empty($issues)): ?>
            <div class="text-center py-4">
                <i class="fas fa-check-circle fa-3x text-success mb-2"></i>
                <p class="text-muted mb-0">Belum ada kendala yang dilaporkan</p>
            </div>
        <?php else: ?>
            <?php foreach($issues as $issue): ?>
                <?php
                $priorityClass = '';
                $priorityText = '';
                switch($issue['priority']) {
                    case 'high':
                        $priorityClass = 'priority-high';
                        $priorityText = 'Tinggi';
                        break;
                    case 'medium':
                        $priorityClass = 'priority-medium';
                        $priorityText = 'Sedang';
                        break;
                    case 'low':
                        $priorityClass = 'priority-low';
                        $priorityText = 'Rendah';
                        break;
                    default:
                        $priorityClass = 'priority-medium';
                        $priorityText = ucfirst($issue['priority']);
                }
                
                $statusBadge = '';
                switch($issue['status']) {
                    case 'open':
                        $statusBadge = '<span class="status-badge bg-danger text-white">Open</span>';
                        break;
                    case 'in_progress':
                        $statusBadge = '<span class="status-badge bg-warning text-dark">In Progress</span>';
                        break;
                    case 'done':
                        $statusBadge = '<span class="status-badge bg-success text-white">Done</span>';
                        break;
                    default:
                        $statusBadge = '<span class="status-badge bg-secondary text-white">' . ucfirst($issue['status']) . '</span>';
                }
                ?>
                <div class="issue-card card <?= $priorityClass ?>">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1"><?= esc($issue['title']) ?></h6>
                                <p class="text-muted small mb-2"><?= esc($issue['description']) ?></p>
                                <div class="d-flex gap-3">
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
                            <div class="text-end">
                                <?= $statusBadge ?>
                                <div class="mt-1">
                                    <span class="badge bg-light text-dark">
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

<script>
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>