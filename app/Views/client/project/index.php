<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .project-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .project-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .progress {
        height: 8px;
        border-radius: 4px;
    }
    .badge-active {
        background: #d4edda;
        color: #155724;
    }
    .badge-completed {
        background: #cfe2ff;
        color: #084298;
    }
    .comment-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 12px;
        margin-top: 12px;
        border-left: 3px solid #36b9cc;
    }
    .comment-text {
        font-size: 13px;
        margin-bottom: 5px;
    }
    .comment-date {
        font-size: 10px;
        color: #999;
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-project-diagram me-2 text-primary"></i>
            My Projects
        </h1>
        <a href="<?= base_url('client/issues/create') ?>" class="btn btn-danger btn-sm">
            <i class="fas fa-exclamation-circle me-2"></i>Report Issue
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

    <!-- Alert Kontrak Akan Berakhir -->
    <?php if(session()->getFlashdata('contract_warning')): ?>
        <div class="alert alert-warning alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('contract_warning') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Projects Grid -->
    <div class="row">
        <?php if(empty($projects)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada proyek</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card project-card h-100">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title mb-0"><?= $project['project_name'] ?></h5>
                                <span class="badge <?= $project['status'] == 'completed' ? 'bg-success' : 'bg-warning' ?>">
                                    <?= ucfirst($project['status'] ?? 'Active') ?>
                                </span>
                            </div>
                            
                            <p class="text-muted small mb-2">
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                                <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                            </p>
                            
                            <!-- Progress Bar -->
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Progress</small>
                                    <small class="text-primary fw-bold"><?= $project['progress'] ?? 0 ?>%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar bg-info" style="width: <?= $project['progress'] ?? 0 ?>%"></div>
                                </div>
                            </div>
                            
                            <!-- Link Detail -->
                            <a href="<?= base_url('client/projects/' . $project['id']) ?>" class="btn btn-sm btn-outline-primary mb-3">
                                <i class="fas fa-eye"></i> Detail Proyek
                            </a>
                            
                            <!-- ========== FORM KOMENTAR ========== -->
                            <div class="mt-3 pt-3 border-top">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-comment-dots me-1"></i> Beri Komentar
                                    </small>
                                    <?php if(!empty($project['client_comments'])): ?>
                                        <small class="text-muted">
                                            <i class="fas fa-history me-1"></i> 
                                            <?= date('d/m/Y H:i', strtotime($project['comments_updated_at'])) ?>
                                        </small>
                                    <?php endif; ?>
                                </div>
                                
                                <form action="<?= base_url('client/projects/comment/' . $project['id']) ?>" method="post">
                                    <?= csrf_field() ?>
                                    <div class="input-group">
                                        <textarea name="comment" class="form-control" rows="2" 
                                                  placeholder="Tulis komentar atau masukan Anda..." style="resize: none;"></textarea>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-paper-plane"></i> Kirim
                                        </button>
                                    </div>
                                </form>
                                
                                <?php if(!empty($project['client_comments'])): ?>
                                    <div class="comment-section mt-2">
                                        <div class="comment-text">
                                            <?= nl2br($project['client_comments']) ?>
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