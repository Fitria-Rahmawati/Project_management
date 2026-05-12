<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .info-card {
        background: #e8f0fe;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #4e73df;
    }
    .preview-username {
        background: #f8f9fc;
        border-radius: 10px;
        padding: 12px 15px;
        font-family: monospace;
        font-size: 14px;
        border: 1px solid #e3e6f0;
        font-weight: bold;
        color: #4e73df;
    }
    .role-section {
        display: none;
    }
    .role-section.active {
        display: block;
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
    .loading-overlay {
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
        padding: 20px 30px;
        border-radius: 15px;
        text-align: center;
    }
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        border: 1px solid #e3e6f0;
    }
    .form-section-title {
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 15px;
        padding-bottom: 8px;
        border-bottom: 2px solid #4e73df;
        color: #4e73df;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-user-plus me-2 text-primary"></i>
            Tambah User Baru
        </h4>
        <a href="<?= base_url('superadmin/users') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i> Kembali
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

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('superadmin/users/store') ?>" method="post" id="userForm">
        <?= csrf_field() ?>

        <!-- ==================== DATA DASAR ==================== -->
        <div class="form-section">
            <div class="form-section-title">
                <i class="fas fa-user-circle me-2"></i> Data Dasar
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" id="first_name" class="form-control" required>
                    <div class="invalid-feedback">Nama depan wajib diisi minimal 2 karakter</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" id="last_name" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <div class="invalid-feedback">Email wajib diisi dengan format yang valid</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Role <span class="text-danger">*</span></label>
                    <select name="role_id" id="role_id" class="form-select" required>
                        <option value="">-- Pilih Role --</option>
                        <?php if (isset($roles) && is_array($roles)): ?>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"><?= ucfirst($role['name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                    <div class="invalid-feedback">Role wajib dipilih</div>
                </div>
            </div>
        </div>

        <!-- ==================== FIELD STAFF/ADMIN ==================== -->
        <div id="staff_fields" class="form-section role-section">
            <div class="form-section-title">
                <i class="fas fa-briefcase me-2"></i> Data Karyawan (Staff/Admin)
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Departemen</label>
                    <select name="department_id" id="department_id" class="form-select">
                        <option value="">-- Pilih Departemen --</option>
                        <?php if(isset($departments)&& is_array($departments)): ?>
                            <?php foreach($departments as $dept): ?>
                                <option value="<?= $dept['id'] ?>"><?= esc((string) $dept['department_name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Posisi/Jabatan</label>
                    <select name="position_id" id="position_id" class="form-select">
                        <option value="">-- Pilih Posisi --</option>
                        <?php if(isset($positions)): ?>
                            <?php foreach($positions as $pos): ?>
                                <option value="<?= $pos['id'] ?>"><?= esc((string) $pos['position_name']) ?></option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" id="phone" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Bergabung</label>
                    <input type="date" name="hire_date" id="hire_date" class="form-control">
                </div>
            </div>
        </div>

        <!-- ==================== FIELD CLIENT ==================== -->
        <div id="client_fields" class="form-section role-section">
            <div class="form-section-title">
                <i class="fas fa-building me-2"></i> Data Perusahaan (Client)
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Perusahaan <span class="text-danger">*</span></label>
                    <select name="company_id" id="company_id" class="form-select">
                        <option value="">-- Pilih Perusahaan --</option>
                        <?php if (isset($companies) && is_array($companies)): ?>
                            <?php foreach ($companies as $company): ?>
                                <option value="<?= $company['id'] ?>"><?= esc((string) $company['company_name']) ?> (<?= ucfirst((string) $company['company_type']) ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                        <option value="new">+ Buat Perusahaan Baru</option>
                    </select>
                    <div class="invalid-feedback">Perusahaan wajib dipilih</div>
                </div>
                <div class="col-md-6 mb-3" id="new_company_field" style="display: none;">
                    <label class="form-label">Nama Perusahaan Baru <span class="text-danger">*</span></label>
                    <input type="text" name="new_company_name" id="new_company_name" class="form-control" placeholder="Masukkan nama perusahaan">
                    <div class="invalid-feedback">Nama perusahaan wajib diisi</div>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" id="phone_client" class="form-control">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status</label>
                    <select name="is_active" id="is_active" class="form-select">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- ==================== PERINGATAN ==================== -->
        <div class="alert alert-warning mt-3">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <strong>Perhatian:</strong>
            <ul class="mb-0 mt-2">
                <li>Password sementara akan dikirim otomatis ke email user</li>
                <li>Link undangan hanya berlaku 1 jam</li>
                <li>User wajib mengganti password saat pertama kali login</li>
            </ul>
        </div>

        <!-- ==================== TOMBOL ==================== -->
        <div class="d-flex justify-content-end gap-2 mt-4">
            <a href="<?= base_url('superadmin/users') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary" id="btnSubmit">
                <i class="fas fa-paper-plane me-2"></i>
                <span class="btn-text">Kirim Undangan</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </div>
    </form>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p class="mt-2 mb-0">Mengirim undangan...</p>
    </div>
</div>

<script>
// ==================== LOADING FUNCTIONS ====================
function showLoading() {
    document.getElementById('loadingOverlay').style.display = 'flex';
}
function hideLoading() {
    document.getElementById('loadingOverlay').style.display = 'none';
}

// ==================== TOGGLE ROLE SECTIONS ====================
const roleSelect = document.getElementById('role_id');
const staffFields = document.getElementById('staff_fields');
const clientFields = document.getElementById('client_fields');
const companySelect = document.getElementById('company_id');
const newCompanyField = document.getElementById('new_company_field');
const newCompanyName = document.getElementById('new_company_name');
const firstName = document.getElementById('first_name');
const lastName = document.getElementById('last_name');
const positionSelect = document.getElementById('position_id');
const previewSpan = document.getElementById('preview_username');

// Generate username preview
function generatePreview() {
    const roleText = roleSelect.options[roleSelect.selectedIndex]?.text.toLowerCase() || '';
    const firstNameVal = firstName.value.trim().toLowerCase().replace(/[^a-z0-9]/g, '');
    const lastNameVal = lastName.value.trim().toLowerCase().replace(/[^a-z0-9]/g, '');
    const positionVal = positionSelect.options[positionSelect.selectedIndex]?.text.toLowerCase().replace(/[^a-z0-9]/g, '_') || '';
    
    let companyVal = '';
    if (companySelect && companySelect.value) {
        if (companySelect.value === 'new') {
            companyVal = newCompanyName.value.trim().toLowerCase().replace(/[^a-z0-9]/g, '_');
        } else if (companySelect.value) {
            companyVal = companySelect.options[companySelect.selectedIndex]?.text.toLowerCase().split(' ')[0] || '';
        }
    }
    
    let username = firstNameVal || 'nama';
    
    if (roleText.includes('client')) {
        if (companyVal) username = firstNameVal + '.' + companyVal;
        else if (firstNameVal) username = firstNameVal;
    } else {
        if (positionVal) username = firstNameVal + '.' + positionVal;
        else if (lastNameVal) username = firstNameVal + '.' + lastNameVal;
        else if (firstNameVal) username = firstNameVal;
    }
    
    previewSpan.textContent = username || '-';
}

// Toggle sections based on role
function toggleSections() {
    const roleText = roleSelect.options[roleSelect.selectedIndex]?.text.toLowerCase() || '';
    
    staffFields.classList.remove('active');
    clientFields.classList.remove('active');
    staffFields.style.display = 'none';
    clientFields.style.display = 'none';
    
    if (roleText.includes('staff') || roleText.includes('admin')) {
        staffFields.classList.add('active');
        staffFields.style.display = 'block';
    } else if (roleText.includes('client')) {
        clientFields.classList.add('active');
        clientFields.style.display = 'block';
        toggleNewCompany();
    }
    generatePreview();
}

// Toggle new company field
function toggleNewCompany() {
    if (companySelect.value === 'new') {
        newCompanyField.style.display = 'block';
        newCompanyName.setAttribute('required', 'required');
    } else {
        newCompanyField.style.display = 'none';
        newCompanyName.removeAttribute('required');
        newCompanyName.value = '';
    }
    generatePreview();
}

// ==================== EVENT LISTENERS ====================
roleSelect.addEventListener('change', toggleSections);
firstName.addEventListener('input', generatePreview);
lastName.addEventListener('input', generatePreview);
if (positionSelect) positionSelect.addEventListener('change', generatePreview);
if (companySelect) companySelect.addEventListener('change', toggleNewCompany);
if (newCompanyName) newCompanyName.addEventListener('input', generatePreview);

// ==================== FORM VALIDATION ====================
function validateForm() {
    let isValid = true;
    
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    const firstNameVal = firstName.value.trim();
    const emailVal = document.getElementById('email').value.trim();
    const roleVal = roleSelect.value;
    const roleText = roleSelect.options[roleSelect.selectedIndex]?.text.toLowerCase() || '';
    
    if (!firstNameVal || firstNameVal.length < 2) {
        firstName.classList.add('is-invalid');
        isValid = false;
    }
    
    if (!emailVal) {
        document.getElementById('email').classList.add('is-invalid');
        isValid = false;
    }
    
    if (!roleVal) {
        roleSelect.classList.add('is-invalid');
        isValid = false;
    }
    
    if (roleText.includes('client')) {
        if (!companySelect.value || companySelect.value === '') {
            companySelect.classList.add('is-invalid');
            isValid = false;
        }
        if (companySelect.value === 'new' && !newCompanyName.value.trim()) {
            newCompanyName.classList.add('is-invalid');
            isValid = false;
        }
    }
    
    return isValid;
}

// Submit form
document.getElementById('userForm')?.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        const firstError = document.querySelector('.is-invalid');
        if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Mengirim...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    showLoading();
});

// Remove invalid class on input
firstName.addEventListener('input', () => firstName.classList.remove('is-invalid'));
document.getElementById('email').addEventListener('input', function() {
    this.classList.remove('is-invalid');
});
roleSelect.addEventListener('change', function() {
    this.classList.remove('is-invalid');
    toggleSections();
});
if (companySelect) companySelect.addEventListener('change', () => companySelect.classList.remove('is-invalid'));
if (newCompanyName) newCompanyName.addEventListener('input', () => newCompanyName.classList.remove('is-invalid'));

// Initialize
window.addEventListener('load', function() {
    hideLoading();
    toggleSections();
});

// Auto close alerts
setTimeout(() => {
    document.querySelectorAll('.alert-danger, .alert-success').forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>