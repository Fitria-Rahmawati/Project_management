<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 20px;
    }
    .stat-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .table-report {
        font-size: 14px;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-exclamation-circle me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="<?= base_url('admin/reports/export/issues') ?>" class="btn btn-success btn-sm me-2">
                    <i class="fas fa-file-export me-2"></i>Export CSV
                </a>
                <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    <div class="filter-card">
        <form method="get" action="<?= base_url('admin/reports/issues') ?>">
            <div class="row">
                <div class="col-md-4">
                    <div class="mb-3">
                        <label class="form-label">Project</label>
                        <select name="project_id" class="form-select">
                            <option value="">Semua Project</option>
                            <?php foreach($projects as $project): ?>
                                <option value="<?= $project['id'] ?>" <?= $filters['project_id'] == $project['id'] ? 'selected' : '' ?>>
                                    <?= $project['project_name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="date_from" class="form-control" value="<?= $filters['date_from'] ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="mb-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="date_to" class="form-control" value="<?= $filters['date_to'] ?>">
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <h6 class="mb-0">Total Issues</h6>
                <h3 class="mt-2 mb-0"><?= $stats['total'] ?></h3>
            </div>
        </div>
        <?php foreach($stats['by_status'] as $status => $count): ?>
        <div class="col-md-2">
            <div class="card">
                <div class="card-body">
                    <span class="badge-status 
                        <?php 
                        switch($status) {
                            case 'To Do': echo 'bg-secondary'; break;
                            case 'In Progress': echo 'bg-warning text-dark'; break;
                            case 'In Review': echo 'bg-info'; break;
                            case 'Done': echo 'bg-success'; break;
                            case 'Closed': echo 'bg-dark'; break;
                        }
                        ?>">
                        <?= $status ?>
                    </span>
                    <h5 class="mt-2 mb-0"><?= $count ?></h5>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-report">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Reporter</th>
                            <th>Assignee</th>
                            <th>Created</th>
                            <th>Due Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($issues)): ?>
                            <tr>
                                <td colspan="10" class="text-center py-5">
                                    <i class="fas fa-exclamation-circle fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data issue</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($issues as $issue): ?>
                                <tr>
                                    <td>#<?= $issue['id'] ?></td>
                                    <td>
                                        <a href="<?= base_url('admin/issues/' . $issue['id']) ?>">
                                            <?= $issue['title'] ?>
                                        </a>
                                    </td>
                                    <td>
                                        <?php 
                                        $typeIcon = '';
                                        switch($issue['issue_type']) {
                                            case 'task': echo '<i class="fas fa-check-circle text-primary"></i> Task'; break;
                                            case 'bug': echo '<i class="fas fa-bug text-danger"></i> Bug'; break;
                                            case 'story': echo '<i class="fas fa-book text-success"></i> Story'; break;
                                            case 'epic': echo '<i class="fas fa-layer-group text-warning"></i> Epic'; break;
                                        }
                                        ?>
                                    </td>
                                    <td><?= $issue['project_name'] ?></td>
                                    <td>
                                        <span class="badge-status 
                                            <?php 
                                            switch($issue['status']) {
                                                case 'To Do': echo 'bg-secondary'; break;
                                                case 'In Progress': echo 'bg-warning text-dark'; break;
                                                case 'In Review': echo 'bg-info'; break;
                                                case 'Done': echo 'bg-success'; break;
                                                case 'Closed': echo 'bg-dark'; break;
                                            }
                                            ?>">
                                            <?= $issue['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge-status 
                                            <?php 
                                            switch($issue['priority']) {
                                                case 'Highest': echo 'bg-danger'; break;
                                                case 'High': echo 'bg-warning text-dark'; break;
                                                case 'Medium': echo 'bg-info'; break;
                                                case 'Low': echo 'bg-secondary'; break;
                                                case 'Lowest': echo 'bg-light text-dark'; break;
                                            }
                                            ?>">
                                            <?= $issue['priority'] ?>
                                        </span>
                                    </td>
                                    <td><?= $issue['reporter_name'] ?? '-' ?></td>
                                    <td><?= $issue['assignee_name'] ?? 'Unassigned' ?></td>
                                    <td><?= date('d/m/Y', strtotime($issue['created_at'])) ?></td>
                                    <td>
                                        <?php if($issue['due_date']): ?>
                                            <?= date('d/m/Y', strtotime($issue['due_date'])) ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
                <?php if(empty($issues)): ?>
                    <div class="text-center my-4">
                        <i class="fas fa-exclamation-circle fa-2x text-muted mb-2"></i>
                        <p class="text-muted">
                            Tidak ada issue yang ditemukan.
                        </p>
                    </div>
                <?php endif; ?>
            </div>
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