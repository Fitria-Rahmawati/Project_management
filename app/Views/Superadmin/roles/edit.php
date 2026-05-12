<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .role-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
    }
    .role-header h2 {
        margin: 0 0 5px 0;
        font-size: 24px;
    }
    .role-header p {
        margin: 0;
        opacity: 0.9;
        font-size: 14px;
    }
    .permission-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        overflow: hidden;
    }
    .permission-card .card-header {
        background: #f8f9fa;
        border-bottom: 2px solid #667eea;
        padding: 15px 20px;
        font-weight: 600;
    }
    .permission-card .card-header i {
        color: #667eea;
        margin-right: 8px;
    }
    .permission-card .card-body {
        padding: 20px;
    }
    .permission-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 12px;
    }
    .permission-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        background: #f8f9fa;
        border-radius: 10px;
        transition: all 0.3s;
    }
    .permission-item:hover {
        background: #e8f0fe;
        transform: translateX(5px);
    }
    .permission-item .form-check-input {
        width: 18px;
        height: 18px;
        cursor: pointer;
        margin-right: 10px;
    }
    .permission-item .form-check-label {
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .permission-badge {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 500;
    }
    .badge-view {
        background: #e3f2fd;
        color: #1565c0;
    }
    .badge-create {
        background: #e8f5e9;
        color: #2e7d32;
    }
    .badge-edit {
        background: #fff3e0;
        color: #e65100;
    }
    .badge-delete {
        background: #ffebee;
        color: #c62828;
    }
    .badge-manage {
        background: #f3e5f5;
        color: #6a1b9a;
    }
    .btn-save {
        background: linear-gradient(135deg, #28a745, #20c997);
        border: none;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(40, 167, 69, 0.3);
    }
    .btn-back {
        background: #6c757d;
        border: none;
        padding: 10px 25px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }
    .summary-card {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .summary-card .number {
        font-size: 32px;
        font-weight: 700;
        color: #667eea;
    }
    .summary-card .label {
        font-size: 12px;
        color: #888;
        margin-top: 5px;
    }
    .action-buttons {
        display: flex;
        justify-content: flex-end;
        gap: 15px;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e0e0e0;
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
        color: #28a745;
        font-weight: 500;
    }
    
    /* Checkbox custom */
    .form-check-input:checked {
        background-color: #28a745;
        border-color: #28a745;
    }
    .select-all-row {
        background: #f0f3ff;
        padding: 12px 20px;
        border-radius: 10px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-shield-alt me-2 text-primary"></i>
                Edit Hak Akses Role
            </h5>
            <a href="<?= base_url('superadmin/roles') ?>" class="btn btn-secondary btn-sm" id="btnBack">
                <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Role
            </a>
        </div>
    </div>

    <!-- Role Header -->
    <div class="role-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2>
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
                    <i class="fas <?= $roleIcon ?> me-2"></i>
                    <?= ucfirst($role['name']) ?>
                </h2>
                <p>Atur hak akses untuk role <?= ucfirst($role['name']) ?> dengan memilih permission yang tersedia di bawah ini.</p>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="col-6">
                        <div class="summary-card">
                            <div class="number"><?= count($rolePermissions) ?></div>
                            <div class="label">Permission Aktif</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="summary-card">
                            <div class="number">
                                <?php 
                                // Hitung total semua permission
                                $totalPermissions = 0;
                                foreach($permissions as $groupItems) {
                                    $totalPermissions += count($groupItems);
                                }
                                echo $totalPermissions;
                                ?>
                            </div>
                            <div class="label">Total Tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
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

      <form action="<?= base_url('superadmin/roles/update/'.$role['id']) ?>" method="post" id="editRoleForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="POST">

        <?php foreach ($permissions as $group => $items): ?>
            <div class="permission-card">
                <div class="card-header">
                    <?php 
                    $groupIcon = '';
                    $groupTitle = str_replace('_', ' ', $group);
                    if(strpos($group, 'projects') !== false) $groupIcon = 'fa-project-diagram';
                    elseif(strpos($group, 'issues') !== false) $groupIcon = 'fa-exclamation-circle';
                    elseif(strpos($group, 'teams') !== false) $groupIcon = 'fa-users';
                    elseif(strpos($group, 'reports') !== false) $groupIcon = 'fa-chart-line';
                    elseif(strpos($group, 'profile') !== false) $groupIcon = 'fa-user';
                    else $groupIcon = 'fa-cog';
                    ?>
                    <i class="fas <?= $groupIcon ?> me-2"></i>
                    <?= ucfirst($groupTitle) ?>
                </div>
                <div class="card-body">
                    <div class="select-all-row">
                        <span>
                            <i class="fas fa-check-circle text-primary me-2"></i>
                            <strong>Pilih Semua</strong>
                        </span>
                        <button type="button" class="btn btn-sm btn-outline-primary select-all-btn" data-group="<?= $group ?>">
                            <i class="fas fa-check-double me-1"></i> Pilih Semua
                        </button>
                    </div>
                    <div class="permission-grid" id="group-<?= $group ?>">
                        <?php foreach ($items as $perm): ?>
                            <?php
                                $parts  = explode('.', $perm['slug']);
                                $action = $parts[1] ?? 'access';
                                $badgeClass = '';
                                if(strpos($action, 'view') !== false) $badgeClass = 'badge-view';
                                elseif(strpos($action, 'create') !== false) $badgeClass = 'badge-create';
                                elseif(strpos($action, 'edit') !== false) $badgeClass = 'badge-edit';
                                elseif(strpos($action, 'delete') !== false) $badgeClass = 'badge-delete';
                                elseif(strpos($action, 'manage') !== false) $badgeClass = 'badge-manage';
                            ?>
                            <div class="permission-item">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="permissions[]" 
                                       value="<?= $perm['id'] ?>"
                                       id="perm<?= $perm['id'] ?>"
                                       <?= in_array($perm['id'], $rolePermissions) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="perm<?= $perm['id'] ?>">
                                    <span class="permission-badge <?= $badgeClass ?>">
                                        <?= ucfirst($action) ?>
                                    </span>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>

        <div class="action-buttons">
            <a href="<?= base_url('superadmin/roles') ?>" class="btn btn-secondary btn-back" id="btnCancel">
                <i class="fas fa-times me-2"></i>Batal
            </a>
            <button type="submit" class="btn btn-success btn-save" id="btnSubmit">
                <i class="fas fa-save me-2"></i>
                <span class="btn-text">Simpan Perubahan</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Menyimpan perubahan...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Menyimpan perubahan...') {
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

// Select All functionality
document.querySelectorAll('.select-all-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const group = this.getAttribute('data-group');
        const groupContainer = document.getElementById(`group-${group}`);
        const checkboxes = groupContainer.querySelectorAll('input[type="checkbox"]');
        const allChecked = Array.from(checkboxes).every(cb => cb.checked);
        
        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });
        
        this.innerHTML = !allChecked ? 
            '<i class="fas fa-times me-1"></i> Hapus Semua' : 
            '<i class="fas fa-check-double me-1"></i> Pilih Semua';
    });
});

// Submit form dengan loading
document.getElementById('editRoleForm')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.classList.add('btn-loading');
    
    showLoading('Menyimpan perubahan hak akses...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar role...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar role...');
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