<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .section-title {
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #f6c23e;
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
        color: #f6c23e;
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
    .form-control:focus, .form-select:focus {
        box-shadow: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-user-edit me-2 text-warning"></i>
            Edit Karyawan
        </h1>
        <a href="<?= base_url('admin/employees') ?>" class="btn btn-outline-secondary" id="btnKembali">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('admin/employees/update/' . $employee['id']) ?>" method="post" id="editEmployeeForm">
        <?= csrf_field() ?>
        
        <!-- Informasi Akun -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-key me-2"></i> Informasi Akun
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= old('username', $employee['username']) ?>" required>
                    <div class="invalid-feedback">Username wajib diisi</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $employee['email']) ?>" required>
                    <div class="invalid-feedback">Email wajib diisi dengan format yang valid</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password (Kosongkan jika tidak diubah)</label>
                    <input type="password" name="password" class="form-control" id="password">
                    <small class="text-muted">Minimal 6 karakter</small>
                    <div class="invalid-feedback">Password minimal 6 karakter</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="confirm_password" class="form-control" id="confirmPassword">
                    <div class="invalid-feedback">Konfirmasi password tidak cocok</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Akun</label>
                    <select name="is_active" class="form-select">
                        <option value="1" <?= $employee['is_active'] ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= !$employee['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-user me-2"></i> Informasi Pribadi
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" value="<?= old('first_name', $employee['first_name']) ?>" required>
                    <div class="invalid-feedback">Nama depan wajib diisi</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" class="form-control" value="<?= old('last_name', $employee['last_name']) ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="tel" name="phone" class="form-control" value="<?= old('phone', $employee['phone']) ?>">
                </div>
            </div>
        </div>

        <!-- Informasi Pekerjaan -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-briefcase me-2"></i> Informasi Pekerjaan
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Posisi/Jabatan <span class="text-danger">*</span></label>
                    <select name="position_id" class="form-select" required>
                        <option value="">-- Pilih Posisi --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>" <?= (old('position_id', $employee['position_id']) == $pos['id']) ? 'selected' : '' ?>>
                                <?= $pos['position_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Posisi wajib dipilih</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Departemen <span class="text-danger">*</span></label>
                    <select name="department_id" class="form-select" required>
                        <option value="">-- Pilih Departemen --</option>
                        <?php foreach($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= (old('department_id', $employee['department_id']) == $dept['id']) ? 'selected' : '' ?>>
                                <?= $dept['department_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <div class="invalid-feedback">Departemen wajib dipilih</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                    <input type="date" name="hire_date" class="form-control" value="<?= old('hire_date', $employee['hire_date']) ?>" required>
                    <div class="invalid-feedback">Tanggal bergabung wajib diisi</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Pekerjaan <span class="text-danger">*</span></label>
                    <select name="status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="permanent" <?= old('status', $employee['status']) == 'permanent' ? 'selected' : '' ?>>Permanent</option>
                        <option value="contract" <?= old('status', $employee['status']) == 'contract' ? 'selected' : '' ?>>Contract</option>
                        <option value="intern" <?= old('status', $employee['status']) == 'intern' ? 'selected' : '' ?>>Intern</option>
                        <option value="freelance" <?= old('status', $employee['status']) == 'freelance' ? 'selected' : '' ?>>Freelance</option>
                    </select>
                    <div class="invalid-feedback">Status pekerjaan wajib dipilih</div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="<?= base_url('admin/employees') ?>" class="btn btn-secondary" id="btnBatal">
                <i class="fas fa-times me-1"></i> Batal
            </a>
            <button type="submit" class="btn btn-warning" id="btnUpdate">
                <i class="fas fa-save me-1"></i> 
                <span class="btn-text">Update</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </div>
    </form>
</div>

<!-- Loading Overlay untuk Submit (Update) -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Menyimpan data...</p>
    </div>
</div>

<!-- Loading Overlay untuk Navigasi (Kembali/Batal) -->
<div class="page-loading-overlay" id="loadingNavigateOverlay" style="display: none;">
    <div class="loading-spinner">
        <div class="spinner-border text-secondary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p><i class="fas fa-spinner fa-spin me-2"></i> Mengalihkan halaman...</p>
    </div>
</div>

<script>
// Loading Overlay untuk Submit
function showLoading(message = 'Menyimpan data...') {
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

// Loading Overlay untuk Navigasi
function showNavigateLoading() {
    const overlay = document.getElementById('loadingNavigateOverlay');
    if (overlay) {
        overlay.style.display = 'flex';
    }
}

function hideNavigateLoading() {
    const overlay = document.getElementById('loadingNavigateOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Validasi form sebelum submit
function validateForm() {
    let isValid = true;
    const form = document.getElementById('editEmployeeForm');
    const inputs = form.querySelectorAll('input[required], select[required]');
    
    // Reset semua error
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validasi setiap input required
    inputs.forEach(input => {
        if (!input.value.trim()) {
            input.classList.add('is-invalid');
            isValid = false;
        }
    });
    
    // Validasi username minimal 3 karakter
    const username = document.querySelector('input[name="username"]');
    if (username && username.value.trim().length < 3) {
        username.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi email format
    const email = document.querySelector('input[name="email"]');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (email && !emailPattern.test(email.value.trim())) {
        email.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi password jika diisi
    const password = document.querySelector('input[name="password"]');
    const confirmPassword = document.querySelector('input[name="confirm_password"]');
    
    if (password && password.value.trim() !== '') {
        if (password.value.trim().length < 6) {
            password.classList.add('is-invalid');
            isValid = false;
        }
        if (confirmPassword && confirmPassword.value.trim() !== password.value.trim()) {
            confirmPassword.classList.add('is-invalid');
            isValid = false;
        }
    }
    
    // Validasi nama depan minimal 2 karakter
    const firstName = document.querySelector('input[name="first_name"]');
    if (firstName && firstName.value.trim().length < 2) {
        firstName.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Submit form dengan loading
document.getElementById('editEmployeeForm')?.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        // Scroll ke error pertama
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return false;
    }
    
    const btn = document.getElementById('btnUpdate');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.classList.add('btn-loading');
    
    showLoading('Menyimpan data karyawan...');
});

// Tombol Kembali - loading dengan tulisan mengalihkan halaman
document.getElementById('btnKembali')?.addEventListener('click', function(e) {
    e.preventDefault();
    showNavigateLoading();
    setTimeout(() => {
        window.location.href = this.getAttribute('href');
    }, 300);
});

// Tombol Batal - loading dengan tulisan mengalihkan halaman
document.getElementById('btnBatal')?.addEventListener('click', function(e) {
    e.preventDefault();
    showNavigateLoading();
    setTimeout(() => {
        window.location.href = this.getAttribute('href');
    }, 300);
});

// Validasi real-time untuk password
document.querySelector('input[name="password"]')?.addEventListener('input', function() {
    const confirm = document.querySelector('input[name="confirm_password"]');
    if (this.value.trim() !== '' && confirm && confirm.value.trim() !== '') {
        if (this.value.trim() !== confirm.value.trim()) {
            confirm.classList.add('is-invalid');
        } else {
            confirm.classList.remove('is-invalid');
        }
    }
});

document.querySelector('input[name="confirm_password"]')?.addEventListener('input', function() {
    const password = document.querySelector('input[name="password"]');
    if (password && password.value.trim() !== '') {
        if (this.value.trim() !== password.value.trim()) {
            this.classList.add('is-invalid');
        } else {
            this.classList.remove('is-invalid');
        }
    }
});

// Hapus class is-invalid saat user mengetik
document.querySelectorAll('input, select').forEach(el => {
    el.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
    el.addEventListener('change', function() {
        this.classList.remove('is-invalid');
    });
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
    hideNavigateLoading();
});

// Auto close alert setelah 5 detik
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>