<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .profile-header {
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
    .stat-box {
        text-align: center;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
    }
    .stat-box h3 { margin: 0; font-size: 24px; font-weight: bold; }
    .employee-avatar {
        width: 80px;
        height: 80px;
        font-size: 32px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="container-fluid">
    <div class="mb-3">
        <a href="<?= base_url('admin/employees') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Daftar
        </a>
        <a href="<?= base_url('admin/employees/edit/' . $employee['id']) ?>" class="btn btn-warning btn-sm">
            <i class="fas fa-edit me-1"></i> Edit
        </a>
        <a href="<?= base_url('admin/employees/reset-password/' . $employee['id']) ?>" class="btn btn-info btn-sm" onclick="return confirm('Reset password karyawan ini?')">
            <i class="fas fa-key me-1"></i> Reset Password
        </a>
    </div>

    <div class="profile-header">
        <div class="d-flex align-items-center">
            <div class="me-4">
                <div class="employee-avatar">
                    <?= strtoupper(substr($employee['first_name'], 0, 1) . substr($employee['last_name'] ?? '', 0, 1)) ?>
                </div>
            </div>
            <div>
                <h2 class="mb-1"><?= $employee['first_name'] . ' ' . ($employee['last_name'] ?? '') ?></h2>
                <p class="mb-0"><?= $employee['position_name'] ?? '-' ?> | <?= $employee['department_name'] ?? '-' ?></p>
                <span class="badge bg-white text-dark mt-2"><?= ucfirst($employee['status']) ?></span>
                <?php if($employee['is_active']): ?>
                    <span class="badge bg-success mt-2">Aktif</span>
                <?php else: ?>
                    <span class="badge bg-danger mt-2">Nonaktif</span>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h3><?= $totalTasks ?></h3>
                <small class="text-muted">Total Tugas</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3><?= $completedTasks ?></h3>
                <small class="text-muted">Tugas Selesai</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-spinner fa-2x text-warning mb-2"></i>
                <h3><?= $inProgressTasks ?></h3>
                <small class="text-muted">Sedang Dikerjakan</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-hourglass-half fa-2x text-danger mb-2"></i>
                <h3><?= $overdueTasks ?></h3>
                <small class="text-muted">Terlambat</small>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-user me-2 text-primary"></i> Informasi Pribadi</h5>
                <table class="table table-sm">
                    <tr><td width="35%">Nama Lengkap</td><td>: <?= $employee['first_name'] . ' ' . ($employee['last_name'] ?? '') ?></td></tr>
                    <tr><td>Username</td><td>: <?= $employee['username'] ?></td></tr>
                    <tr><td>Email</td><td>: <?= $employee['email'] ?></td></tr>
                    <tr><td>Telepon</td><td>: <?= $employee['phone'] ?? '-' ?></td></tr>
                    <tr><td>Alamat</td><td>: <?= $employee['address'] ?? '-' ?></td></tr>
                </table>
            </div>
        </div>
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3"><i class="fas fa-briefcase me-2 text-primary"></i> Informasi Pekerjaan</h5>
                <table class="table table-sm">
                    <tr><td width="35%">Posisi</td><td>: <?= $employee['position_name'] ?? '-' ?></td></tr>
                    <tr><td>Departemen</td><td>: <?= $employee['department_name'] ?? '-' ?></td></tr>
                    <tr><td>Status Pekerjaan</td><td>: <?= ucfirst($employee['status']) ?></td></tr>
                    <tr><td>Tanggal Bergabung</td><td>: <?= date('d F Y', strtotime($employee['hire_date'])) ?></td></tr>
                    <tr><td>Terdaftar Sejak</td><td>: <?= date('d F Y', strtotime($employee['user_created_at'])) ?></td></tr>
                </table>
            </div>
        </div>
    </div>

    <div class="info-card">
        <h5 class="mb-3"><i class="fas fa-tasks me-2 text-primary"></i> Tugas Terbaru</h5>
        <div class="table-responsive">
            <table class="table table-sm">
                <thead><tr><th>Proyek</th><th>Judul Tugas</th><th>Status</th><th>Prioritas</th><th>Deadline</th></tr></thead>
                <tbody>
                    <?php if(empty($recentTasks)): ?>
                        <tr><td colspan="5" class="text-center">Tidak ada tugas</td></tr>
                    <?php else: ?>
                        <?php foreach($recentTasks as $task): ?>
                            <tr>
                                <td><?= $task['project_name'] ?></td>
                                <td><?= $task['title'] ?></td>
                                <td>
                                    <span class="badge <?= $task['status'] == 'done' ? 'bg-success' : ($task['status'] == 'in_progress' ? 'bg-warning' : 'bg-secondary') ?>">
                                        <?= str_replace('_', ' ', ucfirst($task['status'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <span class="badge <?= $task['priority'] == 'high' ? 'bg-danger' : ($task['priority'] == 'medium' ? 'bg-warning' : 'bg-info') ?>">
                                        <?= ucfirst($task['priority']) ?>
                                    </span>
                                </td>
                                <td><?= $task['due_date'] ? date('d/m/Y', strtotime($task['due_date'])) : '-' ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>