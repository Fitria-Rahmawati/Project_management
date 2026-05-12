<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .form-card .card-header {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
        font-weight: 600;
        border-radius: 15px 15px 0 0 !important;
    }
    .form-card .card-body {
        padding: 30px;
    }
    .form-label {
        font-size: 13px;
        font-weight: 500;
        color: #555;
        margin-bottom: 8px;
    }
    .form-control, .form-select {
        border: 2px solid #eee;
        border-radius: 10px;
        padding: 10px 15px;
        font-size: 14px;
        transition: all 0.3s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        outline: none;
    }
    .btn-update {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
        color: white;
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
    }
    .required:after {
        content: " *";
        color: red;
    }
    .info-card {
        background: #f8f9ff;
        border-radius: 10px;
        padding: 15px;
        border-left: 4px solid #667eea;
        font-size: 13px;
        margin-bottom: 20px;
    }
    .current-info {
        background: #e8f5e9;
        border-radius: 10px;
        padding: 15px;
        border-left: 4px solid #28a745;
        margin-bottom: 20px;
    }
    .current-info i {
        color: #28a745;
        margin-right: 8px;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
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
    
    /* Button loading */
    .btn-loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2 text-warning"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="/admin/projects/<?= $project['id'] ?>" class="btn btn-info btn-sm me-2" id="btnDetail">
                    <i class="fas fa-eye me-2"></i>Detail
                </a>
                <a href="/admin/projects" class="btn btn-secondary btn-sm" id="btnBack">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
    
    <div class="current-info">
        <i class="fas fa-info-circle"></i>
        <strong>Sedang mengedit project:</strong> <?= esc($project['project_name']) ?>
        <br>
        <small class="text-muted">
            <i class="fas fa-tag me-1"></i> Tipe: <?= ucfirst($project['project_type']) ?> |
            <i class="fas fa-building me-1 ms-2"></i> Perusahaan: <?= esc($project['company_name'] ?? 'Internal') ?> |
            <i class="fas fa-user-tie me-1 ms-2"></i> PM: 
            <?php 
            $pmName = '';
            foreach($pms as $pm) {
                if($pm['id'] == $project['project_manager_id']) {
                    $pmName = $pm['first_name'] ?? $pm['username'];
                    break;
                }
            }
            echo esc($pmName);
            ?>
        </small>
    </div>
    
    <div class="card form-card">
        <div class="card-header">
            <i class="fas fa-edit me-2 text-warning"></i>
            Form Edit Project
        </div>
        <div class="card-body">
            <div class="info-card">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <strong>Informasi:</strong> Kolom dengan tanda <span class="text-danger">*</span> wajib diisi. 
                Tipe project <strong>tidak dapat diubah</strong> setelah project dibuat.
            </div>

            <form action="/admin/projects/update/<?= $project['id'] ?>" method="post" id="projectForm">
                <?= csrf_field() ?>
                <input type="hidden" name="_method" value="PUT">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="project_name" class="form-label required">Nama Project</label>
                            <input type="text" 
                                   class="form-control" 
                                   id="project_name" 
                                   name="project_name" 
                                   value="<?= old('project_name', esc($project['project_name'])) ?>" 
                                   placeholder="Contoh: Website Company Profile"
                                   required>
                            <div class="invalid-feedback">Nama project wajib diisi</div>
                            <small class="text-muted float-end" id="projectNameCounter">0/255</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Project</label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Jelaskan secara detail tentang project ini..."><?= old('description', esc($project['description'])) ?></textarea>
                            <small class="text-muted">Deskripsi opsional, namun disarankan untuk diisi</small>
                        </div>
                        
                        <div class="mb-3">
                            <label class="form-label">Tipe Project</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="project_type" 
                                               id="typeInternal" 
                                               value="internal"
                                               <?= ($project['project_type'] ?? 'internal') == 'internal' ? 'checked' : '' ?>
                                               disabled>
                                        <label class="form-check-label" for="typeInternal">
                                            <i class="fas fa-building me-2 text-primary"></i>
                                            Internal
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="project_type" 
                                               id="typeClient" 
                                               value="client"
                                               <?= ($project['project_type'] ?? '') == 'client' ? 'checked' : '' ?>
                                               disabled>
                                        <label class="form-check-label" for="typeClient">
                                            <i class="fas fa-user-tie me-2 text-success"></i>
                                            Client
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="project_type" value="<?= $project['project_type'] ?>">
                            <small class="text-muted">Tipe project tidak dapat diubah</small>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="company_id" class="form-label required">Perusahaan</label>
                            <select class="form-select" id="company_id" name="company_id" 
                                    <?= $project['project_type'] == 'internal' ? 'disabled' : '' ?>>
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach($companies as $company): ?>
                                    <option value="<?= $company['id'] ?>" 
                                        <?= (old('company_id', $project['company_id']) == $company['id']) ? 'selected' : '' ?>
                                        data-type="<?= $company['company_type'] ?>">
                                        <?= esc($company['company_name']) ?> (<?= ucfirst($company['company_type']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if($project['project_type'] == 'internal'): ?>
                                <input type="hidden" name="company_id" value="<?= $project['company_id'] ?>">
                                <small class="text-muted">Project internal menggunakan perusahaan internal</small>
                            <?php endif; ?>
                            <div class="invalid-feedback">Perusahaan wajib dipilih</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="project_manager_id" class="form-label required">Project Manager</label>
                            <select class="form-select" id="project_manager_id" name="project_manager_id" required>
                                <option value="">-- Pilih Project Manager --</option>
                                <?php foreach($pms as $pm): ?>
                                    <option value="<?= $pm['id'] ?>" 
                                        <?= (old('project_manager_id', $project['project_manager_id']) == $pm['id']) ? 'selected' : '' ?>>
                                        <?= esc($pm['first_name'] ?? $pm['username']) ?> <?= esc($pm['last_name'] ?? '') ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Project manager wajib dipilih</div>
                            <small class="text-muted">Pilih manager yang akan memimpin project</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label required">Tanggal Mulai</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="<?= old('start_date', $project['start_date']) ?>" 
                                           required>
                                    <div class="invalid-feedback">Tanggal mulai wajib diisi</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" 
                                           class="form-control" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="<?= old('end_date', $project['end_date']) ?>">
                                    <div class="invalid-feedback">Tanggal selesai harus setelah tanggal mulai</div>
                                    <small class="text-muted">Kosongkan jika belum ditentukan</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label required">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">-- Pilih Status --</option>
                                <option value="planning" <?= (old('status', $project['status']) == 'planning') ? 'selected' : '' ?>>Planning</option>
                                <option value="in_progress" <?= (old('status', $project['status']) == 'in_progress') ? 'selected' : '' ?>>In Progress</option>
                                <option value="completed" <?= (old('status', $project['status']) == 'completed') ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= (old('status', $project['status']) == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <div class="invalid-feedback">Status wajib dipilih</div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-12">
                        <div class="bg-light p-3 rounded">
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted d-block">
                                        <i class="far fa-clock me-1"></i> Dibuat pada: 
                                        <?= date('d/m/Y H:i', strtotime($project['created_at'] ?? 'now')) ?>
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block">
                                        <i class="far fa-edit me-1"></i> Terakhir diupdate: 
                                        <?= date('d/m/Y H:i', strtotime($project['updated_at'] ?? 'now')) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/projects" class="btn btn-secondary" id="btnCancel">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning btn-update" id="btnSubmit">
                        <i class="fas fa-save me-2"></i>
                        <span class="btn-text">Update Project</span>
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
        <div class="spinner-border text-warning" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Mengupdate project...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Mengupdate project...') {
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
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');
    const projectName = document.getElementById('project_name');
    const projectNameCounter = document.getElementById('projectNameCounter');
    
    // Project name counter
    if (projectName && projectNameCounter) {
        const initialLength = projectName.value.length;
        projectNameCounter.textContent = initialLength + '/255';
        
        projectName.addEventListener('input', function() {
            const length = this.value.length;
            projectNameCounter.textContent = length + '/255';
            if (length > 255) {
                projectNameCounter.classList.add('text-danger');
            } else {
                projectNameCounter.classList.remove('text-danger');
            }
        });
    }

    // Validate dates
    function validateDates() {
        if (startDate.value && endDate.value) {
            if (endDate.value < startDate.value) {
                endDate.classList.add('is-invalid');
                return false;
            } else {
                endDate.classList.remove('is-invalid');
            }
        }
        return true;
    }

    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);
    validateDates();
});

// Validasi form
function validateForm() {
    let isValid = true;
    
    // Reset error
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validasi nama project
    const projectName = document.getElementById('project_name');
    if (!projectName.value.trim() || projectName.value.trim().length < 3) {
        projectName.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi company (jika project type client)
    const companySelect = document.getElementById('company_id');
    const projectType = document.querySelector('input[name="project_type"]')?.value || '<?= $project['project_type'] ?>';
    if (projectType === 'client' && (!companySelect.value || companySelect.value === '')) {
        companySelect.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi project manager
    const pmSelect = document.getElementById('project_manager_id');
    if (!pmSelect.value) {
        pmSelect.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi start date
    const startDate = document.getElementById('start_date');
    if (!startDate.value) {
        startDate.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi end date > start date
    const endDate = document.getElementById('end_date');
    if (startDate.value && endDate.value && endDate.value < startDate.value) {
        endDate.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi status
    const status = document.getElementById('status');
    if (!status.value) {
        status.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Submit form dengan validasi, loading, dan konfirmasi
document.getElementById('projectForm')?.addEventListener('submit', function(e) {
    if (!validateForm()) {
        e.preventDefault();
        const firstError = document.querySelector('.is-invalid');
        if (firstError) {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            firstError.focus();
        }
        return false;
    }
    
    // Konfirmasi jika status diubah ke completed atau cancelled
    const status = document.getElementById('status').value;
    const currentStatus = '<?= $project['status'] ?>';
    
    if ((status === 'completed' || status === 'cancelled') && status !== currentStatus) {
        if (!confirm(`⚠️ PERINGATAN!\n\nAnda akan mengubah status project menjadi "${status}".\n\nPastikan semua issue dan task sudah diselesaikan.\n\nKlik OK untuk melanjutkan.`)) {
            e.preventDefault();
            return false;
        }
    }
    
    const btn = document.getElementById('btnSubmit');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    btn.classList.add('btn-loading');
    
    showLoading('Mengupdate project...');
});

// Loading untuk navigasi
document.getElementById('btnDetail')?.addEventListener('click', function(e) {
    showLoading('Memuat detail project...');
});
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar project...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar project...');
});

// Remove invalid class on input
document.querySelectorAll('input, select, textarea').forEach(el => {
    el.addEventListener('input', function() {
        this.classList.remove('is-invalid');
    });
    el.addEventListener('change', function() {
        this.classList.remove('is-invalid');
    });
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