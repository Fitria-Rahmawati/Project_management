<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .client-header {
        margin-bottom: 30px;
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        padding: 30px;
        border-radius: 15px;
        color: white;
    }
    .client-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }
    .card-client {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border: 1px solid #edf2f7;
    }
    .progress-bar-custom {
        height: 12px;
        background: #eaecf4;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: #36b9cc;
        border-radius: 10px;
    }
    .btn-client-nav {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-decoration: none;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #e2e8f0;
        transition: all 0.3s;
    }
    .btn-client-nav:hover {
        background: #f7fafc;
        border-color: #36b9cc;
        color: #36b9cc;
        transform: translateY(-2px);
    }
    .project-card {
        background: white;
        border-radius: 12px;
        border: 1px solid #edf2f7;
        margin-bottom: 20px;
        transition: all 0.3s;
    }
    .project-card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .project-card .card-body {
        padding: 20px;
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
        line-height: 1.5;
    }
    .comment-date {
        font-size: 10px;
        color: #999;
    }
    .progress {
        height: 6px;
    }
    .badge-active {
        background: #d4edda;
        color: #155724;
    }
    .badge-completed {
        background: #cfe2ff;
        color: #084298;
    }
</style>

<div class="client-header">
    <h2>Welcome back, <?= session()->get('company_name') ?? session()->get('username') ?>!</h2>
    <p>Pantau perkembangan proyek dan sampaikan kendala Anda di sini.</p>
</div>

<!-- Alert Kontrak Akan Berakhir -->
<?php if(session()->getFlashdata('contract_warning')): ?>
    <div class="alert alert-warning alert-dismissible fade show">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <?= session()->getFlashdata('contract_warning') ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
<?php endif; ?>

<!-- Alert Sukses/Error -->
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

<!-- Statistik Cards -->
<div class="client-stats">
    <div class="card-client">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <small class="text-muted fw-bold">TOTAL PROYEK SAYA</small>
                <h3 class="mt-1 fw-bold"><?= count($myProjects ?? []) ?></h3>
            </div>
            <i class="fas fa-briefcase fa-2x text-info opacity-25"></i>
        </div>
        <div class="progress-wrapper mt-2">
            <div class="progress-info d-flex justify-content-between">
                <span>Overall Ongoing</span>
                <span>
                   <?php 
                   $ongoing = 0;
                   foreach($myProjects as $p) { 
                        if($p['status'] != 'completed') $ongoing++;
                    }
                    echo $ongoing;
                    ?> Active
                </span>
            </div>
            <div class="progress-bar-custom mt-1">
                <?php 
                $total = count($myProjects);
                $ongoing = 0;
                foreach($myProjects as $p) {
                    if($p['status'] != 'completed') $ongoing++;
                }
                $percent = $total > 0 ? round(($ongoing / $total) * 100, 2) : 0;
                ?>
                <div class="progress-fill" style="width: <?= $percent ?>%;"></div>
            </div>
        </div>
    </div>

    <div class="card-client">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted fw-bold">LAPORAN KENDALA</small>
                <h3 class="mt-1 fw-bold text-danger">
                    <?php 
                    $openIssues = 0;
                    foreach($projectProgress as $p) {
                        $openIssues += ($p['total_issues'] - $p['completed_issues']);
                    }
                    echo $openIssues;
                    ?>
                </h3>
                <small class="text-muted small">Butuh perhatian Anda</small>
            </div>
            <i class="fas fa-exclamation-circle fa-2x text-danger opacity-25"></i>
        </div>
    </div>
</div>

<!-- Daftar Proyek dengan Form Komentar -->
<h5 class="fw-bold mb-3">📋 Proyek Saya</h5>

<?php if(empty($myProjects)): ?>
    <div class="text-center py-5 bg-white rounded-3">
        <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
        <p class="text-muted">Belum ada proyek</p>
    </div>
<?php else: ?>
    <?php foreach($myProjects as $project): ?>
        <div class="project-card">
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h5 class="mb-0"><?= $project['project_name'] ?></h5>
                    <span class="badge <?= $project['status'] == 'completed' ? 'bg-success' : 'bg-warning' ?>">
                        <?= ucfirst($project['status'] ?? 'Active') ?>
                    </span>
                </div>
                
                <p class="text-muted small mb-2">
                    <i class="fas fa-calendar me-1"></i>
                    <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                    <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                </p>
                
                <!-- Progress Bar - menggunakan data dari projectProgress -->
                <?php 
                // Cari progress dari projectProgress berdasarkan project id
                $progressData = 0;
                foreach($projectProgress as $pp) {
                    if($pp['id'] == $project['id']) {
                        $totalIssues = $pp['total_issues'] ?? 0;
                        $completedIssues = $pp['completed_issues'] ?? 0;
                        $progressData = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
                        break;
                    }
                }
                ?>
                <div class="mb-3">
                    <div class="d-flex justify-content-between mb-1">
                        <small class="text-muted">Progress</small>
                        <small class="text-primary fw-bold"><?= $progressData ?>%</small>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-info" style="width: <?= $progressData ?>%"></div>
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
    <?php endforeach; ?>
<?php endif; ?>

<!-- Recent Activities Widget -->
<div class="card mt-4">
    <div class="card-header bg-white">
        <h5 class="mb-0">
            <i class="fas fa-history me-2 text-info"></i>
            Aktivitas Terbaru
        </h5>
    </div>
    <div class="card-body p-0">
        <?php if(empty($recentActivities ?? [])): ?>
            <div class="text-center py-4">
                <i class="fas fa-inbox fa-3x text-muted mb-2"></i>
                <p class="text-muted mb-0">Belum ada aktivitas</p>
            </div>
        <?php else: ?>
            <div class="list-group list-group-flush">
                <?php foreach($recentActivities as $activity): ?>
                    <div class="list-group-item">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <i class="fas fa-comment-dots me-2 text-primary"></i>
                                <span><?= esc($activity['activity']) ?></span>
                            </div>
                            <small class="text-muted">
                                <i class="fas fa-clock me-1"></i>
                                <?= date('d/m/Y H:i', strtotime($activity['created_at'])) ?>
                            </small>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Quick Access -->
<h5 class="fw-bold mb-3 mt-4">⚡ Akses Cepat</h5>

<div class="client-nav">
    <a href="<?= base_url('client/projects') ?>" class="btn-client-nav">
        <i class="fas fa-project-diagram fa-lg"></i>
        <span>Detail Proyek</span>
    </a>
    <a href="<?= base_url('client/progress') ?>" class="btn-client-nav">
        <i class="fas fa-chart-line fa-lg"></i>
        <span>Track Progress</span>
    </a>
    <a href="<?= base_url('client/issues/create') ?>" class="btn-client-nav">
        <i class="fas fa-headset fa-lg"></i>
        <span>Lapor Isu</span>
    </a>
    <a href="<?= base_url('client/issues') ?>" class="btn-client-nav">
        <i class="fas fa-list fa-lg"></i>
        <span>Riwayat Isu</span>
    </a>
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