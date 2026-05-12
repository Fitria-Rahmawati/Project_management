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
    .stats-card:hover { transform: translateY(-3px); }
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
    
    /* Loading Overlay */
    .page-loading-overlay {
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
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #36b9cc;
        font-weight: 500;
    }
    .btn-loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }
    .btn-loading .spinner-border {
        display: inline-block !important;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-users me-2 text-primary"></i>
            Daftar Karyawan
        </h1>
        <a href="<?= base_url('admin/employees/create') ?>" class="btn btn-primary" id="btnTambah">
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
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('admin/employees/show/' . $emp['id']) ?>" class="btn btn-sm btn-info" title="Detail">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?= base_url('admin/employees/edit/' . $emp['id']) ?>" class="btn btn-sm btn-warning" title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-danger" title="Nonaktifkan" onclick="confirmDeactivate('<?= $emp['id'] ?>', '<?= addslashes($emp['first_name'] . ' ' . ($emp['last_name'] ?? '')) ?>')">
                                                <i class="fas fa-trash"></i>
                                            </button>
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

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p><i class="fas fa-spinner fa-spin me-2"></i> Memproses...</p>
    </div>
</div>

<script>

function showLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function confirmDeactivate(id, name) {
    if (confirm(`⚠️ PERINGATAN!\n\nYakin ingin menonaktifkan karyawan "${name}"?\n\nKaryawan yang dinonaktifkan tidak akan bisa login dan tidak akan menerima tugas baru.\n\nTindakan ini dapat dibatalkan dengan mengaktifkan kembali melalui edit data.\n\nKlik OK untuk melanjutkan.`)) {
       
        showLoading();
        window.location.href = '<?= base_url('admin/employees/delete/') ?>' + id;
    }
}


document.getElementById('btnTambah')?.addEventListener('click', function(e) {
    showLoading();
});


document.querySelectorAll('.btn-info, .btn-warning').forEach(btn => {
    btn.addEventListener('click', function(e) {
        showLoading();
    });
});


window.addEventListener('load', function() {
    hideLoading();
});


setTimeout(function() {
    hideLoading();
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }, 5000);
    });
}, 1000);
</script>

<?= $this->endSection() ?>