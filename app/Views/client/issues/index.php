<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .stats-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        transition: transform 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-3px);
    }
    .issue-card {
        border-left: 3px solid;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .issue-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .priority-high { border-left-color: #e74a3b; }
    .priority-medium { border-left-color: #f6c23e; }
    .priority-low { border-left-color: #1cc88a; }
    .status-open { background: #e74a3b; }
    .status-in_progress { background: #f6c23e; color: #333; }
    .status-done { background: #1cc88a; }
</style>

<div class="container-fluid">
   
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
            Riwayat Kendala
        </h1>
        <a href="<?= base_url('client/issues/create') ?>" class="btn btn-danger">
            <i class="fas fa-plus me-2"></i>Lapor Kendala Baru
        </a>
    </div>

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

    <div class="row">
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h2 class="mb-0"><?= $totalIssues ?></h2>
                <small class="text-muted">Total Kendala</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-clock fa-2x text-danger mb-2"></i>
                <h2 class="mb-0"><?= $openIssues ?></h2>
                <small class="text-muted">Menunggu</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-spinner fa-2x text-warning mb-2"></i>
                <h2 class="mb-0"><?= $inProgressIssues ?></h2>
                <small class="text-muted">Dikerjakan</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h2 class="mb-0"><?= $doneIssues ?></h2>
                <small class="text-muted">Selesai</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Daftar Kendala</h5>
        </div>
        <div class="card-body">
            <?php if(empty($issues)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-check-circle fa-4x text-success mb-3"></i>
                    <p class="text-muted">Belum ada kendala yang dilaporkan</p>
                    <a href="<?= base_url('client/issues/create') ?>" class="btn btn-primary">
                        <i class="fas fa-plus me-1"></i> Lapor Kendala
                    </a>
                </div>
            <?php else: ?>
                <?php foreach($issues as $issue): ?>
                    <?php
                    $priorityClass = '';
                    switch($issue['priority']) {
                        case 'high': $priorityClass = 'priority-high'; break;
                        case 'medium': $priorityClass = 'priority-medium'; break;
                        case 'low': $priorityClass = 'priority-low'; break;
                    }
                    
                    $statusBadge = '';
                    switch($issue['status']) {
                        case 'open': $statusBadge = 'status-open'; break;
                        case 'in_progress': $statusBadge = 'status-in_progress'; break;
                        case 'done': $statusBadge = 'status-done'; break;
                    }
                    ?>
                    <div class="issue-card card <?= $priorityClass ?>">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <h6 class="mb-0"><?= esc($issue['title']) ?></h6>
                                        <span class="badge <?= $statusBadge ?>">
                                            <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                                        </span>
                                    </div>
                                    <p class="text-muted small mb-2">
                                        <i class="fas fa-folder me-1"></i> <?= esc($issue['project_name']) ?>
                                    </p>
                                    <p class="small mb-0"><?= esc(substr($issue['description'], 0, 100)) ?>...</p>
                                    <div class="d-flex gap-3 mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-flag me-1"></i>
                                            Prioritas: <?= ucfirst($issue['priority']) ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-user me-1"></i>
                                            Penerima: <?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            <?= date('d/m/Y', strtotime($issue['created_at'])) ?>
                                        </small>
                                    </div>
                                </div>
                                <a href="<?= base_url('client/issues/' . $issue['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
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