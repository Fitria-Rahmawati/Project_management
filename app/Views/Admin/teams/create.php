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
        color: #0d6efd;
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
            <i class="fas fa-user-plus me-2"></i>
            <?= $title ?>
        </h5>
        <a href="/admin/teams" class="btn btn-secondary btn-sm" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        
        <form action="/admin/teams/store" method="post" id="teamForm">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="project_id" class="form-label">
                        <i class="fas fa-project-diagram me-2 text-primary"></i>Project <span class="text-danger">*</span>
                    </label>
                    <select name="project_id" id="project_id" class="form-select" required>
                        <option value="">-- Pilih Project --</option>
                        <?php foreach($projects as $project): ?>
                            <option value="<?= $project['id'] ?>" <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
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
                    <select name="user_id" id="user_id" class="form-select" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach($users as $user): ?>
                            <option value="<?= $user['id'] ?>" 
                                    data-role="<?= $user['role_name'] ?>"
                                    <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                                <?= esc($user['username']) ?> 
                                (<?= ucfirst($user['role_name']) ?>)
                                <?php if($user['role_name'] == 'client'): ?>
                                    - <?= esc($user['email']) ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Member wajib dipilih</div>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label for="role_in_project" class="form-label">
                        <i class="fas fa-tag me-2 text-primary"></i>Role dalam Project <span class="text-danger">*</span>
                    </label>
                    <select name="role_in_project" id="role_in_project" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="project_manager" <?= old('role_in_project') == 'project_manager' ? 'selected' : '' ?>>
                            <i class="fas fa-user-tie"></i> Project Manager
                        </option>
                        <option value="staff" <?= old('role_in_project') == 'staff' ? 'selected' : '' ?>>
                            <i class="fas fa-user-cog"></i> Staff
                        </option>
                        <option value="client" <?= old('role_in_project') == 'client' ? 'selected' : '' ?>>
                            <i class="fas fa-building"></i> Client
                        </option>
                    </select>
                    <div class="invalid-feedback">Role dalam project wajib dipilih</div>
                </div>
                
                <div class="col-md-6 mb-3" id="positionField" style="display: none;">
                    <label for="position_id" class="form-label">
                        <i class="fas fa-briefcase me-2 text-primary"></i>Posisi (Staff)
                    </label>
                    <select name="position_id" id="position_id" class="form-select">
                        <option value="">-- Pilih Posisi --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>" <?= old('position_id') == $pos['id'] ? 'selected' : '' ?>>
                                <?= esc($pos['position_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <div class="col-md-12 mb-3">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong><br>
                        - <strong>Project Manager:</strong> Memimpin project, bisa assign task<br>
                        - <strong>Staff:</strong> Mengerjakan task, update progress<br>
                        - <strong>Client:</strong> Melihat progress, report issue
                    </div>
                </div>
            </div>

            <hr>
            
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-eye me-2"></i>Preview Member Info
                            </h6>
                            <div id="previewInfo" class="text-muted">
                                Pilih project dan member untuk melihat info
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/teams" class="btn btn-secondary" id="btnCancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary" id="btnSubmit">
                    <i class="fas fa-save me-2"></i>
                    <span class="btn-text">Simpan Team Member</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </form>
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

document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_in_project');
    const positionField = document.getElementById('positionField');
    const userSelect = document.getElementById('user_id');
    const projectSelect = document.getElementById('project_id');
    const previewInfo = document.getElementById('previewInfo');

    roleSelect.addEventListener('change', function() {
        if (this.value === 'staff') {
            positionField.style.display = 'block';
        } else {
            positionField.style.display = 'none';
        }
        updatePreview();
    });
    
    userSelect.addEventListener('change', updatePreview);
    projectSelect.addEventListener('change', updatePreview);
    roleSelect.addEventListener('change', updatePreview);

    function updatePreview() {
        const projectId = projectSelect.value;
        const userId = userSelect.value;
        const role = roleSelect.value;
        
        if (!projectId || !userId || !role) {
            previewInfo.innerHTML = '<span class="text-muted">Pilih project dan member untuk melihat info</span>';
            return;
        }
        
        const projectText = projectSelect.options[projectSelect.selectedIndex]?.text || '';
        const userOption = userSelect.options[userSelect.selectedIndex];
        const userName = userOption?.text.split('(')[0] || '';
        const userRole = userOption?.dataset.role || '';

        let roleText = '';
        if (role === 'project_manager') roleText = 'Project Manager';
        else if (role === 'staff') roleText = 'Staff';
        else roleText = 'Client';

        let previewHtml = `
            <div class="row">
                <div class="col-md-6">
                    <strong>Project:</strong> ${escapeHtml(projectText)}<br>
                    <strong>Member:</strong> ${escapeHtml(userName)}
                </div>
                <div class="col-md-6">
                    <strong>Role Member:</strong> ${escapeHtml(userRole)}<br>
                    <strong>Role in Project:</strong> ${escapeHtml(roleText)}
                </div>
            </div>
        `;
        
        if ((role === 'client' && userRole !== 'client') || 
            (role === 'staff' && userRole !== 'staff' && userRole !== 'admin') ||
            (role === 'project_manager' && userRole !== 'admin' && userRole !== 'superadmin')) {
            previewHtml += `
                <div class="alert alert-warning mt-2 mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Perhatian: User dengan role "${escapeHtml(userRole)}" dipilih sebagai "${escapeHtml(roleText)}". 
                    Pastikan ini sesuai.
                </div>
            `;
        }

        previewInfo.innerHTML = previewHtml;
    }
    
    function escapeHtml(text) {
        if (!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    if (roleSelect.value) {
        roleSelect.dispatchEvent(new Event('change'));
    }
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
    
    // Validasi user
    const user = document.getElementById('user_id');
    if (!user.value) {
        user.classList.add('is-invalid');
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

// Submit form dengan validasi dan loading
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
    
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.classList.add('btn-loading');
    
    showLoading('Menyimpan team member...');
});

// Loading untuk navigasi
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
document.getElementById('user_id')?.addEventListener('change', function() {
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