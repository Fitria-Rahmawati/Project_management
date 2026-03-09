<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .team-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .team-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 600;
        margin-right: 15px;
    }
    .team-info {
        flex: 1;
    }
    .team-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .team-role {
        font-size: 12px;
        color: #667eea;
        background: #f0f3ff;
        padding: 3px 10px;
        border-radius: 15px;
        display: inline-block;
    }
    .stat-label {
        font-size: 11px;
        color: #888;
        margin-bottom: 5px;
    }
    .stat-value {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    .progress {
        height: 6px;
        border-radius: 3px;
        background: #f0f0f0;
    }
    .progress-bar {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 3px;
    }
    .summary-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .table-report {
        font-size: 14px;
    }
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 20px;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-users me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="<?= base_url('admin/reports/export/team') ?>" class="btn btn-success btn-sm me-2">
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
                <h6 class="mb-0">Total Staff</h6>
                <h3 class="mt-2 mb-0"><?= count($staff) ?></h3>
                <small>Anggota tim aktif</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h6 class="mb-0">Total Tasks</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_sum(array_column($staff, 'assigned_issues')) ?>
                </h3>
                <small>Semua task</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h6 class="mb-0">Completed</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_sum(array_column($staff, 'completed_issues')) + array_sum(array_column($staff, 'closed_issues')) ?>
                </h3>
                <small>Task selesai</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #dc3545, #c82333);">
                <h6 class="mb-0">Overdue</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_sum(array_column($staff, 'overdue_issues')) ?>
                </h3>
                <small>Task terlambat</small>
            </div>
        </div>
    </div>
    <div class="row">
        <?php if(empty($staff)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data staff</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($staff as $member): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card team-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="team-avatar">
                                    <?= strtoupper(substr($member['first_name'] ?? $member['username'], 0, 1)) ?>
                                </div>
                                <div class="team-info">
                                    <div class="team-name">
                                        <?= $member['first_name'] ?? $member['username'] ?> <?= $member['last_name'] ?? '' ?>
                                    </div>
                                    <div class="team-role"><?= $member['position_name'] ?? 'Staff' ?></div>
                                    <small class="text-muted d-block mt-1"><?= $member['email'] ?></small>
                                </div>
                            </div>
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <div class="stat-label">Assigned</div>
                                    <div class="stat-value"><?= $member['assigned_issues'] ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-label">Completed</div>
                                    <div class="stat-value text-success"><?= $member['completed_issues'] + $member['closed_issues'] ?></div>
                                </div>
                                <div class="col-4">
                                    <div class="stat-label">Overdue</div>
                                    <div class="stat-value text-danger"><?= $member['overdue_issues'] ?></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small class="text-muted">Completion Rate</small>
                                    <small class="text-primary fw-bold"><?= $member['completion_rate'] ?>%</small>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: <?= $member['completion_rate'] ?>%"></div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    <i class="fas fa-clock me-1"></i> Total Hours: <?= $member['total_hours'] ?? 0 ?>
                                </small>
                                <span class="badge-status bg-info">
                                    <?= ucfirst($member['role_name'] ?? 'staff') ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
    <div class="card shadow mt-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-table me-2"></i>Detail Kinerja Tim</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-report">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Posisi</th>
                            <th>Assigned</th>
                            <th>Completed</th>
                            <th>Overdue</th>
                            <th>Completion Rate</th>
                            <th>Total Hours</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($staff as $member): ?>
                            <tr>
                                <td>
                                    <strong><?= $member['first_name'] ?? $member['username'] ?> <?= $member['last_name'] ?? '' ?></strong>
                                </td>
                                <td><?= $member['email'] ?></td>
                                <td><?= $member['position_name'] ?? '-' ?></td>
                                <td class="text-center"><?= $member['assigned_issues'] ?></td>
                                <td class="text-center text-success"><?= $member['completed_issues'] + $member['closed_issues'] ?></td>
                                <td class="text-center text-danger"><?= $member['overdue_issues'] ?></td>
                                <td class="text-center">
                                    <span class="badge bg-<?= $member['completion_rate'] >= 70 ? 'success' : ($member['completion_rate'] >= 50 ? 'warning' : 'danger') ?>">
                                        <?= $member['completion_rate'] ?>%
                                    </span>
                                </td>
                                <td class="text-center"><?= $member['total_hours'] ?? 0 ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
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