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
    .btn-submit {
        background: linear-gradient(135deg, #667eea, #764ba2);
        border: none;
        padding: 12px 30px;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
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
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-plus-circle me-2 text-success"></i>
                <?= $title ?>
            </h5>
            <a href="/admin/projects" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
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
    <div class="card form-card">
        <div class="card-header">
            <i class="fas fa-project-diagram me-2 text-primary"></i>
            Form Tambah Project Baru
        </div>
        <div class="card-body">
            <div class="info-card">
                <i class="fas fa-info-circle me-2 text-primary"></i>
                <strong>Informasi:</strong> Kolom dengan tanda <span class="text-danger">*</span> wajib diisi.
            </div>

            <form action="/admin/projects/store" method="post" id="projectForm">
                <?= csrf_field() ?>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="project_name" class="form-label required">Nama Project</label>
                            <input type="text" 
                                   class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['project_name']) ? 'is-invalid' : '' ?>" 
                                   id="project_name" 
                                   name="project_name" 
                                   value="<?= old('project_name') ?>" 
                                   placeholder="Contoh: Website Company Profile"
                                   required>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['project_name'] ?? '' ?>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi Project</label>
                            <textarea class="form-control" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      placeholder="Jelaskan secara detail tentang project ini..."><?= old('description') ?></textarea>
                            <small class="text-muted">Deskripsi opsional, namun disarankan untuk diisi</small>
                        </div>
                        <div class="mb-3">
                            <label class="form-label required">Tipe Project</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" 
                                               type="radio" 
                                               name="project_type" 
                                               id="typeInternal" 
                                               value="internal"
                                               <?= old('project_type', 'internal') == 'internal' ? 'checked' : '' ?>
                                               required>
                                        <label class="form-check-label" for="typeInternal">
                                            <i class="fas fa-building me-2 text-primary"></i>
                                            Internal
                                            <small class="text-muted d-block">Project untuk internal perusahaan</small>
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
                                               <?= old('project_type') == 'client' ? 'checked' : '' ?>
                                               required>
                                        <label class="form-check-label" for="typeClient">
                                            <i class="fas fa-user-tie me-2 text-success"></i>
                                            Client
                                            <small class="text-muted d-block">Project untuk klien eksternal</small>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <?php if(session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['project_type'])): ?>
                                <div class="text-danger small mt-1"><?= session()->getFlashdata('errors')['project_type'] ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3" id="companyField">
                            <label for="company_id" class="form-label required">Perusahaan</label>
                            <select class="form-select <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['company_id']) ? 'is-invalid' : '' ?>" 
                                    id="company_id" 
                                    name="company_id" 
                                    required>
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach($companies as $company): ?>
                                    <option value="<?= $company['id'] ?>" 
                                        <?= old('company_id') == $company['id'] ? 'selected' : '' ?>
                                        data-type="<?= $company['company_type'] ?>">
                                        <?= $company['company_name'] ?> (<?= ucfirst($company['company_type']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['company_id'] ?? '' ?>
                            </div>
                            <small class="text-muted" id="companyHelp">Pilih perusahaan untuk project ini</small>
                        </div>
                        <div class="mb-3">
                            <label for="project_manager_id" class="form-label required">Project Manager</label>
                            <select class="form-select <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['project_manager_id']) ? 'is-invalid' : '' ?>" 
                                    id="project_manager_id" 
                                    name="project_manager_id" 
                                    required>
                                <option value="">-- Pilih Project Manager --</option>
                                <?php foreach($pms as $pm): ?>
                                    <option value="<?= $pm['id'] ?>" 
                                        <?= old('project_manager_id') == $pm['id'] ? 'selected' : '' ?>>
                                        <?= $pm['first_name'] ?? $pm['username'] ?> <?= $pm['last_name'] ?? '' ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['project_manager_id'] ?? '' ?>
                            </div>
                            <small class="text-muted">Pilih manager yang akan memimpin project</small>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label required">Tanggal Mulai</label>
                                    <input type="date" 
                                           class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['start_date']) ? 'is-invalid' : '' ?>" 
                                           id="start_date" 
                                           name="start_date" 
                                           value="<?= old('start_date') ?>" 
                                           required>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['start_date'] ?? '' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">Tanggal Selesai</label>
                                    <input type="date" 
                                           class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['end_date']) ? 'is-invalid' : '' ?>" 
                                           id="end_date" 
                                           name="end_date" 
                                           value="<?= old('end_date') ?>">
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['end_date'] ?? '' ?>
                                    </div>
                                    <small class="text-muted">Kosongkan jika belum ditentukan</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label required">Status Awal</label>
                            <select class="form-select <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['status']) ? 'is-invalid' : '' ?>" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="planning" <?= old('status') == 'planning' ? 'selected' : '' ?>>Planning</option>
                                <option value="in_progress" <?= old('status') == 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                <option value="completed" <?= old('status') == 'completed' ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= old('status') == 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['status'] ?? '' ?>
                            </div>
                            <small class="text-muted">Status awal project</small>
                        </div>
                    </div>
                </div>
                <hr class="my-4">
                <div class="d-flex justify-content-end gap-2">
                    <a href="/admin/projects" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-submit">
                        <i class="fas fa-save me-2"></i>Simpan Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const typeInternal = document.getElementById('typeInternal');
    const typeClient = document.getElementById('typeClient');
    const companyField = document.getElementById('companyField');
    const companySelect = document.getElementById('company_id');
    const companyHelp = document.getElementById('companyHelp');

    function toggleCompanyField() {
        if (typeClient.checked) {
            companyField.style.display = 'block';
            companySelect.required = true;
            companyHelp.textContent = 'Pilih perusahaan client untuk project ini';
        } else {
            companyField.style.display = 'none';
            companySelect.required = false;
            companySelect.value = ''; 
            companyHelp.textContent = 'Project internal tidak memerlukan perusahaan';
        }
    }
    typeInternal.addEventListener('change', toggleCompanyField);
    typeClient.addEventListener('change', toggleCompanyField);
    toggleCompanyField();
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    function validateDates() {
        if (startDate.value && endDate.value) {
            if (endDate.value < startDate.value) {
                endDate.setCustomValidity('Tanggal selesai harus setelah tanggal mulai');
            } else {
                endDate.setCustomValidity('');
            }
        }
    }

    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);
    companySelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption && selectedOption.dataset.type === 'client') {
            console.log('Selected client company, PM list will be filtered');
        }
    });
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