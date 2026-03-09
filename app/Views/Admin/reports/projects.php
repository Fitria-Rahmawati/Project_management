<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .progress-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .progress-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .project-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 15px;
    }
    .project-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }
    .project-type {
        font-size: 11px;
        padding: 3px 10px;
        border-radius: 12px;
    }
    .type-internal {
        background: #e3f2fd;
        color: #1565c0;
    }
    .type-client {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .progress {
        height: 8px;
        border-radius: 4px;
        background: #f0f0f0;
        margin: 10px 0;
    }
    .progress-bar {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 4px;
    }
    .stat-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }
    .stat-value {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    .table-report {
        font-size: 14px;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .summary-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-project-diagram me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="<?= base_url('admin/reports/export/projects') ?>" class="btn btn-success btn-sm me-2">
                    <i class="fas fa-file-export me-2"></i>Export CSV
                </a>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="summary-card">
                <h6 class="mb-0">Total Projects</h6>
                <h3 class="mt-2 mb-0"><?= count($projects) ?></h3>
                <small>Semua proyek</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h6 class="mb-0">Completed</h6>
                <h3 class="mt-2 mb-0">
                    <?php 
                    $completed = array_filter($projects, function($p) {
                        return $p['status'] == 'completed' || $p['status'] == 'Done';
                    });
                    echo count($completed);
                    ?>
                </h3>
                <small>Proyek selesai</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #ffc107, #fd7e14);">
                <h6 class="mb-0">In Progress</h6>
                <h3 class="mt-2 mb-0">
                    <?php 
                    $inProgress = array_filter($projects, function($p) {
                        return $p['status'] == 'in_progress' || $p['status'] == 'In Progress';
                    });
                    echo count($inProgress);
                    ?>
                </h3>
                <small>Proyek berjalan</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                <h6 class="mb-0">Overdue</h6>
                <h3 class="mt-2 mb-0">
                    <?php 
                    $overdue = array_filter($projects, function($p) {
                        return $p['overdue_issues'] > 0;
                    });
                    echo count($overdue);
                    ?>
                </h3>
                <small>Proyek dengan issue overdue</small>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if(empty($projects)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data proyek</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card progress-card">
                        <div class="card-body">
                            <div class="project-header">
                                <span class="project-name"><?= $project['project_name'] ?></span>
                                <span class="project-type <?= $project['project_type'] == 'internal' ? 'type-internal' : 'type-client' ?>">
                                    <?= ucfirst($project['project_type']) ?>
                                </span>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Progress</small>
                                    <small class="text-primary fw-bold"><?= $project['progress'] ?>%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $project['progress'] ?>%"></div>
                                </div>
                            </div>
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <div class="stat-label">Total</div>
                                    <div class="stat-value"><?= $project['total_issues'] ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-label">Completed</div>
                                    <div class="stat-value text-success"><?= $project['completed_issues'] + $project['closed_issues'] ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-label">Overdue</div>
                                    <div class="stat-value text-danger"><?= $project['overdue_issues'] ?></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <small class="text-muted d-block">
                                    <i class="fas fa-building me-2"></i><?= $project['company_name'] ?? 'Internal' ?>
                                </small>
                                <small class="text-muted d-block">
                                    <i class="fas fa-user-tie me-2"></i>PM: <?= $project['manager_name'] ?? '-' ?>
                                </small>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="badge-status 
                                    <?php 
                                    switch($project['status']) {
                                        case 'planning':
                                        case 'proposed':
                                            echo 'bg-secondary';
                                            break;
                                        case 'in_progress':
                                            echo 'bg-warning text-dark';
                                            break;
                                        case 'completed':
                                        case 'Done':
                                            echo 'bg-success';
                                            break;
                                        default:
                                            echo 'bg-info';
                                    }
                                    ?>">
                                    <?= ucfirst(str_replace('_', ' ', $project['status'])) ?>
                                </span>
                                <a href="<?= base_url('admin/projects/' . $project['id']) ?>" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
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