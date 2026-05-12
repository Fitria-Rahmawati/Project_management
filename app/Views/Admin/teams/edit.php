<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
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
        color: #fd7e14;
        font-weight: 500;
    }
    
    /* Validasi styling */
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
    }
    
    /* Button loading */
    .btn-loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }
</style>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2 text-warning"></i>
            <?= $title ?>
        </h5>
        <div>
            <a href="/admin/teams/<?= $team['id'] ?>" class="btn btn-info btn-sm me-2" id="btnDetail">
                <i class="fas fa-eye me-2"></i>Detail
            </a>
            <a href="/admin/teams" class="btn btn-secondary btn-sm" id="btnBack">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form action="/admin/teams/update/<?= $team['id'] ?>" method="post" id="teamForm">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">

            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card bg-light border-primary">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>Current Member Information
                            </h6>
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-2" 
                                         style="width: 80px; height: 80px; font-size: 32px; background: linear-gradient(135deg, #667eea, #764ba2);">
                                        <?= strtoupper(substr($team['member_name'] ?? $team['username'], 0, 1)) ?>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th width="150">Username</th>
                                            <td>: <strong><?= esc($team['username']) ?></strong></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>: <?= esc($team['email']) ?></td>
                                        </tr>
                                        <tr>
                                            <th>Role System</th>
                                            <td>: 
                                                <span class="badge bg-info"><?= ucfirst($team['role_name'] ?? '') ?></span>
                                             </div>
                                             </td>
                                        </tr>
                                        <tr>
                                            <th>Role in Project</th>
                                            <td>: 
                                                <?php 
                                                $roleClass = '';
                                                if($team['role_in_project'] == 'project_manager') $roleClass = 'bg-warning text-dark';
                                                elseif($team['role_in_project'] == 'staff') $roleClass = 'bg-info';
                                                else $roleClass = 'bg-success';
                                                ?>
                                                <span class="badge <?= $roleClass ?>">
                                                    <?= str_replace('_', ' ', ucfirst($team['role_in_project'])) ?>
                                                </span>
                                             </div>
                                             </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="project_id" class="form-label">
                        <i class="fas fa-project-diagram me-2 text-primary"></i>Project <span class="text-danger">*</span>
                    </label>
                    <select name="project_id" id="project_id" class="form-select" required>
                        <option value="">-- Pilih Project --</option>
                        <?php foreach($projects as $project): ?>
                            <option value="<?= $project['id'] ?>" 
                                <?= ($project['id'] == $team['project_id']) ? 'selected' : '' ?>>
                                <?= esc($project['project_name']) ?> 
                                (<?= $project['project_type'] == 'internal' ? 'Internal' : 'Client' ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Project wajib dipilih</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">
                        <i class="fas fa-user me-2 text-primary"></i>Member <span class="text-danger">*</span>
                    </label>
                    <input type="text" class="form-control bg-light" value="<?= esc($team['username']) ?> (<?= ucfirst($team['role_name'] ?? '') ?>)" readonly>
                    <input type="hidden" name="user_id" value="<?= $team['user_id'] ?>">
                    <small class="text-muted">User tidak dapat diubah, silakan hapus dan tambah baru jika perlu</small>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="role_in_project" class="form-label">
                        <i class="fas fa-tag me-2 text-primary"></i>Role dalam Project <span class="text-danger">*</span>
                    </label>
                    <select name="role_in_project" id="role_in_project" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="project_manager" <?= ($team['role_in_project'] == 'project_manager') ? 'selected' : '' ?>>
                            <i class="fas fa-user-tie"></i> Project Manager
                        </option>
                        <option value="staff" <?= ($team['role_in_project'] == 'staff') ? 'selected' : '' ?>>
                            <i class="fas fa-user-cog"></i> Staff
                        </option>
                        <option value="client" <?= ($team['role_in_project'] == 'client') ? 'selected' : '' ?>>
                            <i class="fas fa-building"></i> Client
                        </option>
                    </select>
                    <div class="invalid-feedback">Role dalam project wajib dipilih</div>
                </div>
                
                <div class="col-md-6 mb-3" id="positionField" style="<?= ($team['role_in_project'] == 'staff') ? 'display: block;' : 'display: none;' ?>">
                    <label for="position_id" class="form-label">
                        <i class="fas fa-briefcase me-2 text-primary"></i>Posisi (Staff)
                    </label>
                    <select name="position_id" id="position_id" class="form-select">
                        <option value="">-- Pilih Posisi --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>" 
                                <?= ($pos['id'] == ($team['position_id'] ?? '')) ? 'selected' : '' ?>>
                                <?= esc($pos['position_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Mengubah role dapat mempengaruhi akses member ini dalam project.
                        <?php if($team['role_in_project'] == 'project_manager'): ?>
                        <br>Member ini adalah <strong>Project Manager</strong>. Pastikan ada PM lain sebelum mengubah role.
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/teams" class="btn btn-secondary" id="btnCancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-warning" id="btnSubmit">
                    <i class="fas fa-save me-2"></i>
                    <span class="btn-text">Update Team Member</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
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

document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_in_project');
    const positionField = document.getElementById('positionField');
    const positionSelect = document.getElementById('position_id');
    
    roleSelect.addEventListener('change', function() {
        if (this.value === 'staff') {
            positionField.style.display = 'block';
            positionSelect.required = true;
        } else {
            positionField.style.display = 'none';
            positionSelect.required = false;
            positionSelect.value = '';
        }
    });
});

// Validasi form
function validateForm() {
    let isValid = true;
    
    // Reset error
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validasi project
    const project = document.getElementById('project_id');
    if (!project.value) {
        project.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi role
    const role = document.getElementById('role_in_project');
    if (!role.value) {
        role.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Submit form dengan konfirmasi dan loading
document.getElementById('teamForm')?.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return false;
    }
    
    // Konfirmasi jika mengubah role
    const currentRole = '<?= $team['role_in_project'] ?>';
    const newRole = document.getElementById('role_in_project').value;
    
    if (currentRole !== newRole) {
        if (!confirm(`⚠️ PERINGATAN!\n\nAnda akan mengubah role member ini dari "${currentRole}" menjadi "${newRole}".\n\nPerubahan ini akan mempengaruhi akses member.\n\nKlik OK untuk melanjutkan.`)) {
            e.preventDefault();
            return false;
        }
    }
    
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.classList.add('btn-loading');
    
    showLoading('Mengupdate team member...');
});

// Loading untuk navigasi
document.getElementById('btnDetail')?.addEventListener('click', function(e) {
    showLoading('Memuat detail team member...');
});
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar team...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar team...');
});

// Remove invalid class on change
document.getElementById('project_id')?.addEventListener('change', function() {
    this.classList.remove('is-invalid');
});
document.getElementById('role_in_project')?.addEventListener('change', function() {
    this.classList.remove('is-invalid');
});

// Sembunyikan loading saat halaman selesai
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