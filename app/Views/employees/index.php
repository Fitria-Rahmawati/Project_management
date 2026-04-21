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
    }
    .stats-card h2 { margin: 0; font-size: 28px; font-weight: bold; }
    .employee-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #36b9cc;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-users me-2 text-primary"></i>
            Daftar Karyawan
        </h1>
        <a href="<?= base_url('admin/employees/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>Tambah Karyawan
        </a>
    </div>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-6">
            <div class="stats-card">
                <i class="fas fa-users fa-2x text-primary mb-2"></i>
                <h2><?= $totalEmployees ?></h2>
                <small class="text-muted">Total Karyawan</small>
            </div>
        </div>
        <div class="col-md-6">
            <div class="stats-card">
                <i class="fas fa-user-check fa-2x text-success mb-2"></i>
                <h2><?= $activeEmployees ?></h2>
                <small class="text-muted">Karyawan Aktif</small>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">Data Karyawan</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Posisi</th>
                            <th>Departemen</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($employees)): ?>
                            <tr><td colspan="7" class="text-center">Belum ada data karyawan</td></tr>
                        <?php else: ?>
                            <?php $no=1; foreach($employees as $emp): ?>
                                <?php $initials = strtoupper(substr($emp['first_name'], 0, 1) . substr($emp['last_name'] ?? '', 0, 1)); ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="employee-avatar me-2"><?= $initials ?></div>
                                            <div>
                                                <strong><?= $emp['first_name'] . ' ' . ($emp['last_name'] ?? '') ?></strong><br>
                                                <small class="text-muted">@<?= $emp['username'] ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= $emp['email'] ?></td>
                                    <td><?= $emp['position_name'] ?? '-' ?></td>
                                    <td><?= $emp['department_name'] ?? '-' ?></td>
                                    <td>
                                        <?php if($emp['is_active']): ?>
                                            <span class="badge bg-success">Aktif</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Nonaktif</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('admin/employees/show/' . $emp['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('admin/employees/edit/' . $emp['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('admin/employees/delete/' . $emp['id']) ?>" class="btn btn-sm btn-danger" title="Nonaktifkan" onclick="return confirm('Yakin ingin menonaktifkan karyawan ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                     </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>