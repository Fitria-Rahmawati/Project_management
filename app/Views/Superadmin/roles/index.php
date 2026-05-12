<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .role-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .role-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        padding: 15px 20px;
        color: white;
    }
    .role-header h5 {
        margin: 0;
        font-weight: 600;
    }
    .role-header small {
        opacity: 0.8;
        font-size: 12px;
    }
    .role-body {
        padding: 20px;
    }
    .permission-group {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
    }
    .permission-group h6 {
        margin: 0 0 10px 0;
        color: #667eea;
        font-weight: 600;
    }
    .permission-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
        margin: 3px;
    }
    .permission-badge.view {
        background: #e3f2fd;
        color: #1565c0;
    }
    .permission-badge.create {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .permission-badge.edit {
        background: #fff3e0;
        color: #e65100;
    }
    .permission-badge.delete {
        background: #ffebee;
        color: #c62828;
    }
    .permission-badge.manage {
        background: #f3e5f5;
        color: #6a1b9a;
    }
    .permission-badge.default {
        background: #eceff1;
        color: #455a64;
    }
    .stat-box {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-left: 4px solid #667eea;
    }
    .stat-box .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #333;
    }
    .stat-box .stat-label {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
    }
    .summary-cards {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    .summary-card {
        flex: 1;
        min-width: 150px;
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        border-top: 3px solid #667eea;
    }
    .summary-card h3 {
        margin: 0;
        font-size: 28px;
        font-weight: 700;
    }
    .summary-card p {
        margin: 5px 0 0;
        color: #888;
        font-size: 12px;
    }
    .btn-edit {
        background: #ffc107;
        border: none;
        padding: 5px 15px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s;
    }
    .btn-edit:hover {
        background: #e0a800;
        transform: translateY(-2px);
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
        color: #667eea;
        font-weight: 500;
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-shield-alt me-2 text-primary"></i>
                Manajemen Role & Hak Akses
            </h5>
            <a href="<?= base_url('superadmin/dashboard') ?>" class="btn btn-secondary btn-sm" id="btnBack">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
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

    <!-- Summary Cards -->
    <div class="summary-cards">
        <div class="summary-card">
            <h3><?= count($roles) ?></h3>
            <p>Total Role</p>
        </div>
        <div class="summary-card">
            <h3>
                <?php 
                $totalPermissions = 0;
                foreach($roles as $role) {
                    $totalPermissions += count($role['permissions']);
                }
                echo $totalPermissions;
                ?>
            </h3>
            <p>Total Permissions</p>
        </div>
        <div class="summary-card">
            <h3><?= round($totalPermissions / max(1, count($roles)), 1) ?></h3>
            <p>Avg Permissions/Role</p>
        </div>
    </div>

    <!-- Table -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="fas fa-table me-2 text-primary"></i>Daftar Role dan Permission</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th width="20">No</th>
                            <th width="150">Role</th>
                            <th>Permissions</th>
                            <th width="100">Total</th>
                            <th width="100">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($roles)): ?>
                            <tr>
                                <td colspan="5" class="text-center py-5 text-muted">
                                    <i class="fas fa-shield-alt fa-3x mb-3 d-block"></i>
                                    Belum ada data role
                                 </div>
                                 </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($roles as $index => $role): ?>
                                <?php 
                                $permissionCount = count($role['permissions']);
                                ?>
                                <tr>
                                    <td class="text-center"><?= $index + 1 ?></td>
                                    <td>
                                        <strong>
                                            <?php 
                                            $roleIcon = '';
                                            switch($role['name']) {
                                                case 'superadmin':
                                                    $roleIcon = 'fa-crown';
                                                    break;
                                                case 'admin':
                                                    $roleIcon = 'fa-user-shield';
                                                    break;
                                                case 'staff':
                                                    $roleIcon = 'fa-user-cog';
                                                    break;
                                                case 'client':
                                                    $roleIcon = 'fa-user-tie';
                                                    break;
                                                default:
                                                    $roleIcon = 'fa-user';
                                            }
                                            ?>
                                            <i class="fas <?= $roleIcon ?> me-2 text-primary"></i>
                                            <?= ucfirst($role['name']) ?>
                                        </strong>
                                     </div>
                                     </td>
                                    <td>
                                        <div style="max-height: 120px; overflow-y: auto;">
                                            <?php foreach($role['permissions'] as $perm): ?>
                                                <?php 
                                                $badgeClass = 'default';
                                                if(strpos($perm['name'], 'view') !== false) $badgeClass = 'view';
                                                elseif(strpos($perm['name'], 'create') !== false) $badgeClass = 'create';
                                                elseif(strpos($perm['name'], 'edit') !== false) $badgeClass = 'edit';
                                                elseif(strpos($perm['name'], 'delete') !== false) $badgeClass = 'delete';
                                                elseif(strpos($perm['name'], 'manage') !== false) $badgeClass = 'manage';
                                                ?>
                                                <span class="permission-badge <?= $badgeClass ?>">
                                                    <i class="fas fa-check-circle me-1"></i>
                                                    <?= ucfirst(str_replace('_', ' ', $perm['name'])) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                     </div>
                                     </td>
                                    <td class="text-center">
                                        <span class="badge bg-primary"><?= $permissionCount ?></span>
                                     </div>
                                     </td>
                                    <td class="text-center">
                                        <a href="/superadmin/roles/edit/<?= $role['id'] ?>" 
                                           class="btn btn-sm btn-warning btn-edit" 
                                           data-edit-link
                                           data-role="<?= $role['name'] ?>">
                                            <i class="fas fa-edit me-1"></i> Edit
                                        </a>
                                     </div>
                                     </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                <table>
            </div>
        </div>
    </div>

    <!-- Info Card -->
    <div class="card mt-4 border-info">
        <div class="card-header bg-info text-white">
            <i class="fas fa-info-circle me-2"></i>Informasi Hak Akses
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="permission-badge view">view</span>
                        <span class="ms-2 small">= Hanya melihat data</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="permission-badge create">create</span>
                        <span class="ms-2 small">= Menambah data</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="permission-badge edit">edit</span>
                        <span class="ms-2 small">= Mengubah data</span>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="d-flex align-items-center mb-2">
                        <span class="permission-badge delete">delete</span>
                        <span class="ms-2 small">= Menghapus data</span>
                    </div>
                </div>
            </div>
            <hr class="my-2">
            <div class="row">
                <div class="col-md-4">
                    <div class="d-flex align-items-center mb-2">
                        <span class="permission-badge manage">manage</span>
                        <span class="ms-2 small">= Manajemen penuh</span>
                    </div>
                </div>
                <div class="col-md-8">
                    <small class="text-muted">
                        <i class="fas fa-lightbulb me-1 text-warning"></i>
                        Tip: Klik tombol Edit pada role untuk mengubah hak akses yang dimiliki.
                    </small>
                </div>
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
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Memproses...') {
    const overlay = document.getElementById('loadingOverlay');
    const msgElement = document.getElementById('loadingMessage');
    if (overlay) {
        if (msgElement) msgElement.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Loading untuk tombol kembali
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke dashboard...');
});

// Loading untuk tombol edit
document.querySelectorAll('[data-edit-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const roleName = this.getAttribute('data-role') || 'Role';
        showLoading(`Membuka form edit ${roleName}...`);
    });
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto-hide flash messages
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>