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
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-edit me-2 text-warning"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="/admin/projects/<?= $project['id'] ?>" class="btn btn-info btn-sm me-2">
                    <i class="fas fa-eye me-2"></i>Detail
                </a>
                <a href="/admin/projects" class="btn btn-secondary btn-sm">
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
        <strong>Sedang mengedit project:</strong> <?= $project['project_name'] ?>
        <br>
        <small class="text-muted">
            <i class="fas fa-tag me-1"></i> Tipe: <?= ucfirst($project['project_type']) ?> |
            <i class="fas fa-building me-1 ms-2"></i> Perusahaan: <?= $project['company_name'] ?? 'Internal' ?> |
            <i class="fas fa-user-tie me-1 ms-2"></i> PM: 
            <?php 
            $pmName = '';
            foreach($pms as $pm) {
                if($pm['id'] == $project['project_manager_id']) {
                    $pmName = $pm['first_name'] ?? $pm['username'];
                    break;
                }
            }
            echo $pmName;
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
                                   class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['project_name']) ? 'is-invalid' : '' ?>" 
                                   id="project_name" 
                                   name="project_name" 
                                   value="<?= old('project_name', $project['project_name']) ?>" 
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
                                      placeholder="Jelaskan secara detail tentang project ini..."><?= old('description', $project['description']) ?></textarea>
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
                            <select class="form-select <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['company_id']) ? 'is-invalid' : '' ?>" 
                                    id="company_id" 
                                    name="company_id" 
                                    required
                                    <?= $project['project_type'] == 'internal' ? 'disabled' : '' ?>>
                                <option value="">-- Pilih Perusahaan --</option>
                                <?php foreach($companies as $company): ?>
                                    <option value="<?= $company['id'] ?>" 
                                        <?= (old('company_id', $project['company_id']) == $company['id']) ? 'selected' : '' ?>
                                        data-type="<?= $company['company_type'] ?>">
                                        <?= $company['company_name'] ?> (<?= ucfirst($company['company_type']) ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <?php if($project['project_type'] == 'internal'): ?>
                                <input type="hidden" name="company_id" value="<?= $project['company_id'] ?>">
                                <small class="text-muted">Project internal menggunakan perusahaan internal</small>
                            <?php endif; ?>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['company_id'] ?? '' ?>
                            </div>
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
                                        <?= (old('project_manager_id', $project['project_manager_id']) == $pm['id']) ? 'selected' : '' ?>>
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
                                           value="<?= old('start_date', $project['start_date']) ?>" 
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
                                           value="<?= old('end_date', $project['end_date']) ?>">
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['end_date'] ?? '' ?>
                                    </div>
                                    <small class="text-muted">Kosongkan jika belum ditentukan</small>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label required">Status</label>
                            <select class="form-select <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['status']) ? 'is-invalid' : '' ?>" 
                                    id="status" 
                                    name="status" 
                                    required>
                                <option value="">-- Pilih Status --</option>
                                <option value="planning" <?= (old('status', $project['status']) == 'planning') ? 'selected' : '' ?>>Planning</option>
                                <option value="in_progress" <?= (old('status', $project['status']) == 'in_progress') ? 'selected' : '' ?>>In Progress</option>
                                <option value="completed" <?= (old('status', $project['status']) == 'completed') ? 'selected' : '' ?>>Completed</option>
                                <option value="cancelled" <?= (old('status', $project['status']) == 'cancelled') ? 'selected' : '' ?>>Cancelled</option>
                            </select>
                            <div class="invalid-feedback">
                                <?= session()->getFlashdata('errors')['status'] ?? '' ?>
                            </div>
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
                    <a href="/admin/projects" class="btn btn-secondary">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-warning btn-update">
                        <i class="fas fa-save me-2"></i>Update Project
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const startDate = document.getElementById('start_date');
    const endDate = document.getElementById('end_date');

    function validateDates() {
        if (startDate.value && endDate.value) {
            if (endDate.value < startDate.value) {
                endDate.setCustomValidity('Tanggal selesai harus setelah tanggal mulai');
                endDate.classList.add('is-invalid');
                let feedback = endDate.nextElementSibling;
                if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                    feedback = document.createElement('div');
                    feedback.className = 'invalid-feedback';
                    endDate.parentNode.appendChild(feedback);
                }
                feedback.textContent = 'Tanggal selesai harus setelah tanggal mulai';
            } else {
                endDate.setCustomValidity('');
                endDate.classList.remove('is-invalid');
                let feedback = endDate.nextElementSibling;
                if (feedback && feedback.classList.contains('invalid-feedback')) {
                    feedback.remove();
                }
            }
        }
    }

    startDate.addEventListener('change', validateDates);
    endDate.addEventListener('change', validateDates);
    validateDates();
    const form = document.getElementById('projectForm');
    form.addEventListener('submit', function(e) {
        const status = document.getElementById('status').value;
        
        if (status === 'completed' || status === 'cancelled') {
            if (!confirm('Anda akan mengubah status project menjadi ' + status + '. Lanjutkan?')) {
                e.preventDefault();
            }
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