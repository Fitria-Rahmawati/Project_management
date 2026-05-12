<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== LOADING OVERLAY ==================== */
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
    .loading-spinner .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e3e6f0;
        border-top-color: #dc3545;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #dc3545;
        font-weight: 500;
    }

    .form-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .issue-type-card {
        cursor: pointer;
        transition: all 0.3s;
        border: 2px solid #eee;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
    }
    .issue-type-card:hover {
        border-color: #667eea;
        background: #f8f9ff;
        transform: translateY(-3px);
    }
    .issue-type-card.selected {
        border-color: #667eea;
        background: #f0f3ff;
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
    .btn-submit {
        transition: all 0.3s;
    }
    .btn-submit:disabled {
        opacity: 0.7;
        cursor: wait;
        transform: none;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-exclamation-circle me-2 text-danger"></i>
            Report New Issue
        </h1>
        <a href="<?= base_url('staff/tasks') ?>" class="btn btn-secondary btn-sm" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
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

    <div class="row">
        <div class="col-md-8 mx-auto">
            <div class="card form-card">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Form Laporan Issue</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('staff/issues/store') ?>" method="post" id="issueForm">
                        <?= csrf_field() ?>
                        
                        <!-- Issue Type -->
                        <div class="mb-4">
                            <label class="form-label required">Issue Type <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="issue-type-card" onclick="selectType('task')" id="type-task">
                                        <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                                        <h6>Task</h6>
                                        <small>Pekerjaan biasa</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="issue-type-card" onclick="selectType('bug')" id="type-bug">
                                        <i class="fas fa-bug fa-2x text-danger mb-2"></i>
                                        <h6>Bug</h6>
                                        <small>Error / Masalah</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="issue-type-card" onclick="selectType('story')" id="type-story">
                                        <i class="fas fa-book fa-2x text-success mb-2"></i>
                                        <h6>Story</h6>
                                        <small>Fitur dari user</small>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="issue_type" id="issue_type" value="task">
                            <div class="invalid-feedback" id="typeError">Tipe issue wajib dipilih</div>
                        </div>

                        <!-- Project -->
                        <div class="mb-3">
                            <label class="form-label required">Project <span class="text-danger">*</span></label>
                            <select name="project_id" id="project_id" class="form-select" required>
                                <option value="">-- Pilih Project --</option>
                                <?php foreach($projects as $project): ?>
                                    <option value="<?= $project['id'] ?>" <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
                                        <?= esc($project['project_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">Project wajib dipilih</div>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label required">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title" class="form-control" placeholder="Judul issue..." value="<?= old('title') ?>" required>
                            <div class="invalid-feedback">Judul wajib diisi</div>
                            <small class="text-muted float-end" id="titleCounter">0/255</small>
                        </div>

                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label required">Description <span class="text-danger">*</span></label>
                            <textarea name="description" id="description" class="form-control" rows="5" placeholder="Jelaskan issue secara detail..."><?= old('description') ?></textarea>
                            <div class="invalid-feedback">Deskripsi wajib diisi</div>
                        </div>

                        <!-- Priority -->
                        <div class="mb-3">
                            <label class="form-label required">Priority <span class="text-danger">*</span></label>
                            <select name="priority" id="priority" class="form-select" required>
                                <option value="Lowest" <?= old('priority') == 'Lowest' ? 'selected' : '' ?>>Lowest</option>
                                <option value="Low" <?= old('priority') == 'Low' ? 'selected' : '' ?>>Low</option>
                                <option value="Medium" <?= old('priority', 'Medium') == 'Medium' ? 'selected' : '' ?>>Medium</option>
                                <option value="High" <?= old('priority') == 'High' ? 'selected' : '' ?>>High</option>
                                <option value="Highest" <?= old('priority') == 'Highest' ? 'selected' : '' ?>>Highest</option>
                            </select>
                            <div class="invalid-feedback">Prioritas wajib dipilih</div>
                        </div>

                        <!-- Due Date -->
                        <div class="mb-3">
                            <label class="form-label">Due Date (Optional)</label>
                            <input type="date" name="due_date" id="due_date" class="form-control" value="<?= old('due_date') ?>" min="<?= date('Y-m-d') ?>">
                            <div class="invalid-feedback">Tanggal deadline tidak boleh kurang dari hari ini</div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end">
                            <a href="<?= base_url('staff/tasks') ?>" class="btn btn-secondary me-2" id="btnCancel">Batal</a>
                            <button type="submit" class="btn btn-danger btn-submit" id="btnSubmit">
                                <i class="fas fa-paper-plane me-2"></i>
                                <span class="btn-text">Submit Issue</span>
                                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p id="loadingMessage">Mengirim laporan...</p>
    </div>
</div>

<script>
// Loading Overlay functions
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(message = 'Mengirim laporan...') {
    if (loadingOverlay) {
        if (loadingMessage) loadingMessage.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        loadingOverlay.style.display = 'flex';
    }
}

function hideLoading() {
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
}

// Select issue type
function selectType(type) {
    document.getElementById('issue_type').value = type;
    
    const cards = ['task', 'bug', 'story'];
    cards.forEach(t => {
        const card = document.getElementById(`type-${t}`);
        card.classList.remove('selected');
    });
    document.getElementById(`type-${type}`).classList.add('selected');
    
    // Remove error if exists
    document.getElementById('typeError')?.classList.remove('d-block');
}

// Initialize
selectType('task');

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
    titleCounter.textContent = (titleInput.value.length || 0) + '/255';
}

// Validasi form
function validateForm() {
    let isValid = true;
    
    // Reset errors
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    document.querySelectorAll('.invalid-feedback').forEach(el => {
        el.style.display = 'none';
    });
    
    // Validasi issue type
    const issueType = document.getElementById('issue_type');
    if (!issueType.value) {
        document.getElementById('typeError').style.display = 'block';
        isValid = false;
    }
    
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
    
    // Validasi due date
    const dueDate = document.getElementById('due_date');
    const today = new Date().toISOString().split('T')[0];
    if (dueDate.value && dueDate.value < today) {
        dueDate.classList.add('is-invalid');
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
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    
    showLoading('Mengirim laporan issue...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar task...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar task...');
});

// Hapus class is-invalid saat user input
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
    this.classList.remove('is-invalid');
});
document.getElementById('due_date')?.addEventListener('change', function() {
    const today = new Date().toISOString().split('T')[0];
    if (this.value >= today) {
        this.classList.remove('is-invalid');
    }
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto close alerts
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>