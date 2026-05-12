<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== VARIABLES ==================== */
    :root {
        --primary: #4e73df;
        --primary-light: #e8f0fe;
        --success: #1cc88a;
        --success-light: #e3f9e9;
        --warning: #f6c23e;
        --warning-light: #fff3e0;
        --danger: #e74a3b;
        --danger-light: #fee2e2;
        --info: #36b9cc;
        --info-light: #e1f5fe;
        --dark: #5a5c69;
        --gray: #858796;
        --border: #e3e6f0;
        --bg: #f8f9fc;
    }

    /* ==================== PAGE LAYOUT ==================== */
    .edit-page {
        padding: 20px;
        background: var(--bg);
        min-height: 100vh;
    }

    /* ==================== HEADER CARD ==================== */
    .header-card {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .header-title h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 5px 0;
    }
    .header-title p {
        font-size: 13px;
        color: var(--gray);
        margin: 0;
    }
    .btn-back {
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 10px 20px;
        border-radius: 10px;
        color: var(--gray);
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-back:hover {
        background: var(--border);
        color: var(--dark);
        text-decoration: none;
    }

    /* ==================== FORM CARD ==================== */
    .form-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .form-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
    }
    .form-header h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    .form-header p {
        font-size: 12px;
        color: var(--gray);
        margin: 5px 0 0;
    }
    .form-body {
        padding: 25px;
    }

    /* ==================== FORM GROUP ==================== */
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-size: 13px;
        font-weight: 600;
        color: var(--dark);
        margin-bottom: 8px;
        display: block;
    }
    .form-group label i {
        width: 20px;
        color: var(--primary);
        margin-right: 6px;
    }
    .form-group input,
    .form-group select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid var(--border);
        border-radius: 12px;
        font-size: 14px;
        transition: all 0.3s;
        background: white;
    }
    .form-group input:focus,
    .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
    }
    .form-group input[readonly] {
        background: var(--bg);
        cursor: not-allowed;
    }
    .form-text {
        font-size: 11px;
        color: var(--gray);
        margin-top: 5px;
        display: block;
    }

    /* ==================== SECTION HEADER ==================== */
    .section-header {
        background: var(--bg);
        padding: 12px 20px;
        margin: 25px 0 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .section-header i {
        font-size: 18px;
        color: var(--primary);
    }
    .section-header h5 {
        font-size: 15px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }

    /* ==================== ACTION BUTTONS ==================== */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .btn-update {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        border: none;
        padding: 12px 30px;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
    }
    .btn-cancel {
        background: white;
        border: 2px solid var(--border);
        padding: 12px 30px;
        border-radius: 12px;
        color: var(--gray);
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        text-decoration: none;
    }
    .btn-cancel:hover {
        background: var(--bg);
        border-color: var(--danger);
        color: var(--danger);
    }

    /* ==================== ALERT ==================== */
    .alert-custom {
        padding: 15px 20px;
        border-radius: 12px;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .alert-danger {
        background: var(--danger-light);
        color: var(--danger);
        border-left: 4px solid var(--danger);
    }
    .alert-success {
        background: var(--success-light);
        color: var(--success);
        border-left: 4px solid var(--success);
    }

    /* ==================== LOADING ==================== */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .loading-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid var(--border);
        border-top-color: var(--warning);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 15px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .edit-page { padding: 15px; }
        .header-card { flex-direction: column; text-align: center; }
        .action-buttons { flex-direction: column; }
        .btn-update, .btn-cancel { justify-content: center; }
    }
</style>

<div class="edit-page">
    <!-- Header -->
    <div class="header-card">
        <div class="header-title">
            <h2><i class="fas fa-edit me-2" style="color: var(--warning);"></i> Edit Perusahaan</h2>
            <p>Perbarui informasi data perusahaan</p>
        </div>
        <a href="<?= base_url('superadmin/companies') ?>" class="btn-back" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert-custom alert-danger">
            <i class="fas fa-exclamation-circle fa-lg"></i>
            <span><?= session()->getFlashdata('error') ?></span>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert-custom alert-success">
            <i class="fas fa-check-circle fa-lg"></i>
            <span><?= session()->getFlashdata('success') ?></span>
        </div>
    <?php endif; ?>

    <!-- Form Card -->
    <div class="form-card">
        <div class="form-header">
            <h4><i class="fas fa-building me-2 text-primary"></i> Form Edit Perusahaan</h4>
            <p>Lengkapi data perusahaan dengan benar</p>
        </div>
        
        <div class="form-body">
            <form action="<?= base_url('superadmin/companies/update/' . $company['id']) ?>" method="post" id="editForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="POST">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Nama Perusahaan <span class="text-danger">*</span></label>
                            <input type="text" name="company_name" value="<?= esc($company['company_name']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Tipe Perusahaan <span class="text-danger">*</span></label>
                            <select name="company_type" id="company_type" required>
                                <option value="internal" <?= $company['company_type'] === 'internal' ? 'selected' : '' ?>>🏢 Internal</option>
                                <option value="client" <?= $company['company_type'] === 'client' ? 'selected' : '' ?>>🤝 Client</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Contact Person</label>
                            <input type="text" name="contact_person" value="<?= esc($company['contact_person']) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <input type="email" name="email" value="<?= esc($company['email']) ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Telepon</label>
                            <input type="text" name="phone" value="<?= esc($company['phone']) ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-toggle-on"></i> Status Perusahaan</label>
                            <select name="is_active">
                                <option value="1" <?= $company['is_active'] ? 'selected' : '' ?>>✅ Aktif</option>
                                <option value="0" <?= !$company['is_active'] ? 'selected' : '' ?>>❌ Nonaktif</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Contract Section (Khusus Client) -->
                <div class="section-header" id="contractSection" style="display: none;">
                    <i class="fas fa-file-contract"></i>
                    <h5>INFORMASI KONTRAK</h5>
                </div>

                <div class="row" id="contractFields" style="display: none;">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-alt"></i> Tanggal Mulai Kontrak</label>
                            <input type="date" name="contract_start" value="<?= old('contract_start', $company['contract_start'] ?? '') ?>">
                            <small class="form-text">Kosongkan jika tidak ada</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-calendar-check"></i> Tanggal Berakhir Kontrak</label>
                            <input type="date" name="contract_end" value="<?= old('contract_end', $company['contract_end'] ?? '') ?>">
                            <small class="form-text">Kosongkan jika tidak ada</small>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label><i class="fas fa-chart-line"></i> Status Kontrak</label>
                            <select name="contract_status">
                                <option value="active" <?= (old('contract_status', $company['contract_status'] ?? '') == 'active') ? 'selected' : '' ?>>✅ Aktif</option>
                                <option value="expiring_soon" <?= (old('contract_status', $company['contract_status'] ?? '') == 'expiring_soon') ? 'selected' : '' ?>>⚠️ Akan Berakhir</option>
                                <option value="expired" <?= (old('contract_status', $company['contract_status'] ?? '') == 'expired') ? 'selected' : '' ?>>❌ Berakhir</option>
                                <option value="renewed" <?= (old('contract_status', $company['contract_status'] ?? '') == 'renewed') ? 'selected' : '' ?>>🔄 Diperpanjang</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <button type="submit" class="btn-update" id="btnSubmit">
                        <i class="fas fa-save"></i> <span class="btn-text">Simpan Perubahan</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                    <a href="<?= base_url('superadmin/companies') ?>" class="btn-cancel" id="btnCancel">
                        <i class="fas fa-times"></i> Batal
                    </a>
                </div>

            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-card">
        <div class="loading-spinner"></div>
        <p id="loadingMessage">Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(msg = 'Memproses...') {
    loadingMessage.textContent = msg;
    loadingOverlay.style.display = 'flex';
}

function hideLoading() {
    loadingOverlay.style.display = 'none';
}

// Toggle contract fields based on company type
const companyType = document.getElementById('company_type');
const contractSection = document.getElementById('contractSection');
const contractFields = document.getElementById('contractFields');

function toggleContractFields() {
    if (companyType.value === 'client') {
        contractSection.style.display = 'flex';
        contractFields.style.display = 'flex';
    } else {
        contractSection.style.display = 'none';
        contractFields.style.display = 'none';
    }
}

// Initial call
toggleContractFields();

// On change
companyType.addEventListener('change', toggleContractFields);

// Form submit with loading
document.getElementById('editForm')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    showLoading('Menyimpan perubahan...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', hideLoading);

// Auto close alert
setTimeout(() => {
    document.querySelectorAll('.alert-custom').forEach(alert => {
        alert.style.opacity = '0';
        setTimeout(() => alert.remove(), 300);
    });
}, 5000);
</script>

<?= $this->endSection() ?>