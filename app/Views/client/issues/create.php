<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-section {
        background: white;
        border-radius: 20px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
    
    /* Loading Overlay */
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
        padding: 30px 40px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #e74a3b;
        font-weight: 500;
    }
    .spinner-border {
        width: 40px;
        height: 40px;
        border: 3px solid #f3f3f3;
        border-top-color: #e74a3b;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    
    /* Button loading */
    .btn-loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }
    
    /* Required field */
    .required:after {
        content: " *";
        color: #dc3545;
    }
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-plus-circle me-2 text-danger"></i>
            Lapor Kendala Baru
        </h1>
        <a href="<?= base_url('client/issues') ?>" class="btn btn-outline-secondary" id="btnBack">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->get('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                <?php foreach(session()->get('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="form-section">
        <form action="<?= base_url('client/issues/store') ?>" method="post" id="issueForm">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="project_id" class="form-label fw-bold required">
                    <i class="fas fa-folder me-1 text-primary"></i> Proyek
                </label>
                <select name="project_id" id="project_id" class="form-select" required>
                    <option value="">-- Pilih Proyek --</option>
                    <?php foreach($projects as $project): ?>
                        <option value="<?= $project['id'] ?>" <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
                            <?= esc($project['project_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <div class="invalid-feedback">Proyek wajib dipilih</div>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label fw-bold required">
                    <i class="fas fa-heading me-1 text-primary"></i> Judul Kendala
                </label>
                <input type="text" name="title" id="title" class="form-control" 
                       value="<?= old('title') ?>" required>
                <div class="invalid-feedback">Judul kendala wajib diisi</div>
                <small class="text-muted">Contoh: Bug pada halaman login, atau kendala akses fitur X</small>
                <small class="text-muted float-end" id="titleCounter">0/255</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold required">
                    <i class="fas fa-align-left me-1 text-primary"></i> Deskripsi
                </label>
                <textarea name="description" id="description" rows="5" class="form-control" required><?= old('description') ?></textarea>
                <div class="invalid-feedback">Deskripsi kendala wajib diisi</div>
                <small class="text-muted">Jelaskan kendala yang Anda alami secara detail</small>
            </div>

            <div class="mb-4">
                <label for="priority" class="form-label fw-bold required">
                    <i class="fas fa-flag me-1 text-primary"></i> Prioritas
                </label>
                <select name="priority" id="priority" class="form-select" required>
                    <option value="">-- Pilih Prioritas --</option>
                    <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>🟢 Rendah</option>
                    <option value="medium" <?= old('priority') == 'medium' ? 'selected' : '' ?>>🟡 Sedang</option>
                    <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>🔴 Tinggi</option>
                </select>
                <div class="invalid-feedback">Prioritas wajib dipilih</div>
            </div>

            <div class="alert alert-info mb-4">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Informasi:</strong> Setelah melaporkan kendala, tim kami akan segera menindaklanjuti laporan Anda.
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('client/issues') ?>" class="btn btn-secondary" id="btnCancel">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-danger" id="btnSubmit">
                    <i class="fas fa-paper-plane me-1"></i>
                    <span class="btn-text">Kirim Laporan</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border"></div>
        <p id="loadingMessage" class="mt-3 mb-0">Mengirim laporan...</p>
    </div>
</div>

<script>
// Loading functions
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(msg = 'Mengirim laporan...') {
    if (loadingMessage) loadingMessage.textContent = msg;
    if (loadingOverlay) loadingOverlay.style.display = 'flex';
}

function hideLoading() {
    if (loadingOverlay) loadingOverlay.style.display = 'none';
}

// Title counter
const titleInput = document.getElementById('title');
const titleCounter = document.getElementById('titleCounter');

if (titleInput && titleCounter) {
    titleInput.addEventListener('input', function() {
        const length = this.value.length;
        titleCounter.textContent = length + '/255';
        if (length > 255) {
            titleCounter.classList.add('text-danger');
        } else {
            titleCounter.classList.remove('text-danger');
        }
    });
    // Initial counter
    titleCounter.textContent = (titleInput.value.length || 0) + '/255';
}

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
    
    // Validasi title
    const title = document.getElementById('title');
    if (!title.value.trim() || title.value.trim().length < 3) {
        title.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi description
    const description = document.getElementById('description');
    if (!description.value.trim() || description.value.trim().length < 10) {
        description.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi priority
    const priority = document.getElementById('priority');
    if (!priority.value) {
        priority.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Submit form dengan loading
document.getElementById('issueForm')?.addEventListener('submit', function(e) {
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
    btn.querySelector('.btn-text').textContent = 'Mengirim...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.classList.add('btn-loading');
    
    showLoading('Mengirim laporan kendala...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});

// Remove invalid class on input
document.getElementById('project_id')?.addEventListener('change', function() {
    this.classList.remove('is-invalid');
});
document.getElementById('title')?.addEventListener('input', function() {
    if (this.value.trim().length >= 3) {
        this.classList.remove('is-invalid');
    }
});
document.getElementById('description')?.addEventListener('input', function() {
    if (this.value.trim().length >= 10) {
        this.classList.remove('is-invalid');
    }
});
document.getElementById('priority')?.addEventListener('change', function() {
    if (this.value) {
        this.classList.remove('is-invalid');
    }
});

// Sembunyikan loading saat halaman selesai dimuat
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