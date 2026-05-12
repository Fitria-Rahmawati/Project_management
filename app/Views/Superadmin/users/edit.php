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

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">Edit User</h4>
        <a href="<?= base_url('superadmin/users') ?>" class="btn btn-secondary btn-sm" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar
        </a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <?php if(session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <strong>Validasi gagal:</strong>
                    <ul class="mb-0 mt-2">
                        <?php foreach(session()->getFlashdata('errors') as $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
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
            
            <form action="<?= base_url('superadmin/users/update/'.$user['id']) ?>" method="post" id="editUserForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="POST">
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" name="username"
                               id="username"
                               value="<?= esc($user['username']) ?>"
                               class="form-control" 
                               required>
                        <div class="invalid-feedback">Username wajib diisi</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email"
                               id="email"
                               value="<?= esc($user['email']) ?>"
                               class="form-control" 
                               required>
                        <div class="invalid-feedback">Email wajib diisi dengan format yang valid</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            Password <small class="text-muted">(kosongkan jika tidak diubah)</small>
                        </label>
                        <input type="password" name="password" id="password" class="form-control">
                        <div class="invalid-feedback">Password minimal 6 karakter</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="confirm_password" id="confirm_password" class="form-control">
                        <div class="invalid-feedback">Konfirmasi password tidak cocok</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Role <span class="text-danger">*</span></label>
                        <select name="role_id" id="role_id" class="form-select" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"
                                    <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                                    <?= esc($role['name']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                        <div class="invalid-feedback">Role wajib dipilih</div>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <select name="company_id" id="company_id" class="form-select">
                            <option value="">-- Tanpa Company --</option>
                            <?php foreach ($companies as $company): ?>
                                <option value="<?= $company['id'] ?>"
                                    <?= $company['id'] == $user['company_id'] ? 'selected' : '' ?>>
                                    <?= esc($company['company_name']) ?>
                                    (<?= ucfirst($company['company_type']) ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="is_active" id="is_active" class="form-select">
                            <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= !$user['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('superadmin/users') ?>" class="btn btn-secondary" id="btnCancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary" id="btnSubmit">
                        <i class="fas fa-save me-2"></i>
                        <span class="btn-text">Update User</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
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

// Validasi form
function validateForm() {
    let isValid = true;
    
    // Reset error
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validasi username
    const username = document.getElementById('username');
    if (!username.value.trim() || username.value.trim().length < 3) {
        username.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi email
    const email = document.getElementById('email');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailPattern.test(email.value.trim())) {
        email.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi password (jika diisi)
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    
    if (password.value.trim() !== '') {
        if (password.value.trim().length < 6) {
            password.classList.add('is-invalid');
            isValid = false;
        }
        if (confirmPassword.value.trim() !== password.value.trim()) {
            confirmPassword.classList.add('is-invalid');
            isValid = false;
        }
    }
    
    // Validasi role
    const role = document.getElementById('role_id');
    if (!role.value) {
        role.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Submit form dengan validasi dan loading
document.getElementById('editUserForm')?.addEventListener('submit', function(e) {
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
    
    showLoading('Mengupdate user...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar user...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar user...');
});

// Validasi real-time
document.getElementById('username')?.addEventListener('input', function() {
    if (this.value.trim().length >= 3) {
        this.classList.remove('is-invalid');
    } else {
        this.classList.add('is-invalid');
    }
});

document.getElementById('email')?.addEventListener('input', function() {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (emailPattern.test(this.value.trim())) {
        this.classList.remove('is-invalid');
    } else {
        this.classList.add('is-invalid');
    }
});

document.getElementById('password')?.addEventListener('input', function() {
    if (this.value.trim() !== '') {
        if (this.value.trim().length < 6) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    } else {
        this.classList.remove('is-invalid');
    }
    
    // Cek konfirmasi password
    const confirm = document.getElementById('confirm_password');
    if (confirm.value.trim() !== '') {
        if (confirm.value.trim() !== this.value.trim()) {
            confirm.classList.add('is-invalid');
        } else {
            confirm.classList.remove('is-invalid');
        }
    }
});

document.getElementById('confirm_password')?.addEventListener('input', function() {
    const password = document.getElementById('password');
    if (password.value.trim() !== '') {
        if (this.value.trim() !== password.value.trim()) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    }
});

document.getElementById('role_id')?.addEventListener('change', function() {
    if (this.value) {
        this.classList.remove('is-invalid');
    }
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