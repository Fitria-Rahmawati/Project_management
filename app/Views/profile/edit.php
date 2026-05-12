<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-section {
        margin-bottom: 25px;
    }
    .section-title {
        font-size: 18px;
        font-weight: 600;
        color: #667eea;
        margin-bottom: 20px;
        padding-bottom: 10px;
        border-bottom: 2px solid #e0e0e0;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .invalid-feedback {
        display: block;
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
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
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-user-edit me-2 text-primary"></i>
            Edit Profile
        </h1>
        <a href="<?= base_url('profile') ?>" class="btn btn-outline-secondary" id="btnKembali">
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

    <div class="form-card">
        <form action="<?= base_url('profile/update') ?>" method="post" id="editProfileForm">
            <?= csrf_field() ?>
            
            <div class="form-section">
                <h5 class="section-title">
                    <i class="fas fa-user me-2"></i> Informasi Pribadi
                </h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                        <input type="text" name="first_name" class="form-control" value="<?= old('first_name', $user['first_name']) ?>" required>
                        <div class="invalid-feedback">Nama depan wajib diisi</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Nama Belakang</label>
                        <input type="text" name="last_name" class="form-control" value="<?= old('last_name', $user['last_name']) ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                        <div class="invalid-feedback">Email wajib diisi dengan format yang valid</div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Telepon</label>
                        <input type="tel" name="phone" class="form-control" value="<?= old('phone', $user['phone']) ?>">
                    </div>
                </div>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('profile') ?>" class="btn btn-secondary" id="btnBatal">Batal</a>
                <button type="submit" class="btn btn-primary" id="btnUpdate">
                    <i class="fas fa-save me-1"></i>
                    <span class="btn-text">Simpan Perubahan</span>
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
        <p id="loadingMessage" class="mt-2 mb-0">Menyimpan data...</p>
    </div>
</div>

<script>
// Validasi form
function validateForm() {
    let isValid = true;
    
    // Reset error
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validasi nama depan
    const firstName = document.querySelector('input[name="first_name"]');
    if (!firstName.value.trim() || firstName.value.trim().length < 2) {
        firstName.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi email
    const email = document.querySelector('input[name="email"]');
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!email.value.trim() || !emailPattern.test(email.value.trim())) {
        email.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Loading functions
function showLoading(message = 'Menyimpan data...') {
    const overlay = document.getElementById('loadingOverlay');
    const msgElement = document.getElementById('loadingMessage');
    if (overlay) {
        if (msgElement) msgElement.textContent = message;
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

function showNavigateLoading() {
    const overlay = document.getElementById('loadingOverlay');
    const msgElement = document.getElementById('loadingMessage');
    if (overlay) {
        if (msgElement) msgElement.textContent = 'Mengalihkan halaman...';
        overlay.style.display = 'flex';
    }
}

// Submit form
document.getElementById('editProfileForm')?.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
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
    
    showLoading('Menyimpan perubahan profile...');
});

// Tombol navigasi
document.getElementById('btnKembali')?.addEventListener('click', function(e) {
    e.preventDefault();
    showNavigateLoading();
    setTimeout(() => {
        window.location.href = this.getAttribute('href');
    }, 200);
});

document.getElementById('btnBatal')?.addEventListener('click', function(e) {
    e.preventDefault();
    showNavigateLoading();
    setTimeout(() => {
        window.location.href = this.getAttribute('href');
    }, 200);
});

// Sembunyikan loading saat halaman selesai
window.addEventListener('load', function() {
    hideLoading();
});

// Auto close alert
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>