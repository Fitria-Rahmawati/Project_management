<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .issue-type-card {
        cursor: pointer;
        transition: transform 0.2s;
    }
    .issue-type-card:hover {
        transform: translateY(-5px);
    }
    .issue-type-card .card {
        transition: all 0.3s;
    }
    .issue-type-card.selected .card {
        box-shadow: 0 5px 15px rgba(0,0,0,0.2);
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
        color: #28a745;
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

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2 text-success"></i>
            <?= $title ?>
        </h5>
        <a href="/admin/issues" class="btn btn-secondary btn-sm" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
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
        
        <form action="/admin/issues/store" method="post" id="createIssueForm">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-tag me-2"></i>Tipe Issue
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-md-3 mb-2">
                                    <div class="issue-type-card <?= old('issue_type') == 'task' ? 'selected' : '' ?>" 
                                         onclick="selectType('task')"
                                         id="type-task">
                                        <div class="card p-3 <?= old('issue_type') == 'task' ? 'border-primary bg-light' : '' ?>">
                                            <i class="fas fa-check-circle fa-3x text-primary mb-2"></i>
                                            <h6>Task</h6>
                                            <small class="text-muted">Pekerjaan biasa</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="issue-type-card <?= old('issue_type') == 'bug' ? 'selected' : '' ?>" 
                                         onclick="selectType('bug')"
                                         id="type-bug">
                                        <div class="card p-3 <?= old('issue_type') == 'bug' ? 'border-danger bg-light' : '' ?>">
                                            <i class="fas fa-bug fa-3x text-danger mb-2"></i>
                                            <h6>Bug</h6>
                                            <small class="text-muted">Error / Masalah</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="issue-type-card <?= old('issue_type') == 'story' ? 'selected' : '' ?>" 
                                         onclick="selectType('story')"
                                         id="type-story">
                                        <div class="card p-3 <?= old('issue_type') == 'story' ? 'border-success bg-light' : '' ?>">
                                            <i class="fas fa-book fa-3x text-success mb-2"></i>
                                            <h6>Story</h6>
                                            <small class="text-muted">Fitur dari user</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <div class="issue-type-card <?= old('issue_type') == 'epic' ? 'selected' : '' ?>" 
                                         onclick="selectType('epic')"
                                         id="type-epic">
                                        <div class="card p-3 <?= old('issue_type') == 'epic' ? 'border-warning bg-light' : '' ?>">
                                            <i class="fas fa-layer-group fa-3x text-warning mb-2"></i>
                                            <h6>Epic</h6>
                                            <small class="text-muted">Kumpulan story</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="issue_type" id="issue_type" value="<?= old('issue_type', 'task') ?>">
                            <div class="invalid-feedback" id="typeError">Tipe issue wajib dipilih</div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                <select class="form-select" id="project_id" name="project_id" required>
                                    <option value="">-- Pilih Project --</option>
                                    <?php foreach($projects as $project): ?>
                                        <option value="<?= $project['id'] ?>" 
                                            <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
                                            <?= esc($project['project_name']) ?> 
                                            (<?= $project['project_type'] == 'internal' ? 'Internal' : 'Client' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="invalid-feedback">Project wajib dipilih</div>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control" 
                                       id="title" 
                                       name="title" 
                                       value="<?= old('title') ?>" 
                                       placeholder="Contoh: Membuat halaman login"
                                       required>
                                <div class="invalid-feedback">Judul issue wajib diisi</div>
                                <small class="text-muted float-end" id="titleCounter">0/255</small>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" 
                                          id="description" 
                                          name="description" 
                                          rows="5" 
                                          placeholder="Jelaskan issue secara detail..."><?= old('description') ?></textarea>
                                <small class="text-muted">Deskripsi lengkap tentang issue ini</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4" id="parentIssueCard" style="display: none;">
                        <div class="card-header bg-light">
                            <i class="fas fa-link me-2"></i>Parent Issue
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="parent_issue_id" class="form-label">Parent Issue</label>
                                <select class="form-select" id="parent_issue_id" name="parent_issue_id">
                                    <option value="">-- No Parent --</option>
                                    <?php foreach($parent_issues as $parent): ?>
                                        <option value="<?= $parent['id'] ?>" <?= old('parent_issue_id') == $parent['id'] ? 'selected' : '' ?>>
                                            #<?= $parent['id'] ?> - <?= esc($parent['title']) ?> (<?= $parent['status'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Pilih parent issue jika ini adalah subtask</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-user-check me-2"></i>Assignment
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="assignee_id" class="form-label">Assign To</label>
                                <select class="form-select" id="assignee_id" name="assignee_id">
                                    <option value="">-- Unassigned --</option>
                                    <?php foreach($users as $user): ?>
                                        <?php if(in_array($user['role_name'] ?? '', ['admin', 'staff', 'superadmin'])): ?>
                                            <option value="<?= $user['id'] ?>" 
                                                <?= old('assignee_id') == $user['id'] ? 'selected' : '' ?>>
                                                <?= esc($user['username']) ?> (<?= ucfirst($user['role_name'] ?? '') ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Staff yang akan mengerjakan</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-flag me-2"></i>Priority
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <?php 
                                $priorities = ['Lowest', 'Low', 'Medium', 'High', 'Highest'];
                                foreach($priorities as $p): 
                                ?>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" 
                                           type="radio" 
                                           name="priority" 
                                           id="priority_<?= $p ?>" 
                                           value="<?= $p ?>"
                                           <?= old('priority', 'Medium') == $p ? 'checked' : '' ?>
                                           required>
                                    <label class="form-check-label" for="priority_<?= $p ?>">
                                        <?php 
                                        $badgeClass = '';
                                        switch($p) {
                                            case 'Highest': $badgeClass = 'bg-danger'; break;
                                            case 'High': $badgeClass = 'bg-warning text-dark'; break;
                                            case 'Medium': $badgeClass = 'bg-info'; break;
                                            case 'Low': $badgeClass = 'bg-secondary'; break;
                                            case 'Lowest': $badgeClass = 'bg-light text-dark'; break;
                                        }
                                        ?>
                                        <span class="badge <?= $badgeClass ?>"><?= $p ?></span>
                                    </label>
                                </div>
                                <?php endforeach; ?>
                                <div class="invalid-feedback" id="priorityError">Prioritas wajib dipilih</div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-calendar-alt me-2"></i>Planning
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="due_date" class="form-label">Due Date</label>
                                <input type="date" 
                                       class="form-control" 
                                       id="due_date" 
                                       name="due_date" 
                                       value="<?= old('due_date') ?>"
                                       min="<?= date('Y-m-d') ?>">
                                <div class="invalid-feedback">Tanggal deadline tidak valid</div>
                                <small class="text-muted">Target penyelesaian</small>
                            </div>

                            <div class="mb-3">
                                <label for="estimated_hours" class="form-label">Estimated Hours</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="estimated_hours" 
                                       name="estimated_hours" 
                                       value="<?= old('estimated_hours') ?>"
                                       step="0.5"
                                       min="0.5"
                                       placeholder="Contoh: 2.5">
                                <div class="invalid-feedback">Estimasi jam minimal 0.5 jam</div>
                                <small class="text-muted">Estimasi waktu pengerjaan (jam)</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card mb-4 bg-light">
                        <div class="card-body">
                            <h6><i class="fas fa-info-circle me-2 text-primary"></i>Informasi</h6>
                            <ul class="small text-muted ps-3 mb-0">
                                <li class="mb-1">Issue akan dibuat dengan status <strong>To Do</strong></li>
                                <li class="mb-1">Reporter akan diisi dengan akun Anda</li>
                                <li class="mb-1">Semua perubahan akan tercatat di history</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/issues" class="btn btn-secondary" id="btnCancel">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-success" id="btnSubmit">
                    <i class="fas fa-save me-2"></i>
                    <span class="btn-text">Buat Issue</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Membuat issue baru...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Membuat issue baru...') {
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
    if (!document.getElementById('issue_type').value) {
        selectType('task');
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
        const initialLength = titleInput.value.length;
        titleCounter.textContent = initialLength + '/255';
    }
});

function selectType(type) {
    document.getElementById('issue_type').value = type;
    
    const cards = ['task', 'bug', 'story', 'epic'];
    cards.forEach(t => {
        const element = document.getElementById(`type-${t}`);
        const card = element.querySelector('.card');
        if (t === type) {
            if (t === 'task') card.className = 'card p-3 border-primary bg-light';
            else if (t === 'bug') card.className = 'card p-3 border-danger bg-light';
            else if (t === 'story') card.className = 'card p-3 border-success bg-light';
            else if (t === 'epic') card.className = 'card p-3 border-warning bg-light';
        } else {
            card.className = 'card p-3';
        }
    });

    const parentCard = document.getElementById('parentIssueCard');
    if (type === 'subtask') {
        parentCard.style.display = 'block';
    } else {
        parentCard.style.display = 'none';
        const parentSelect = document.getElementById('parent_issue_id');
        if (parentSelect) parentSelect.value = '';
    }
}

// Validasi form
function validateForm() {
    let isValid = true;
    
    // Reset error
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid');
    });
    
    // Validasi tipe issue
    const issueType = document.getElementById('issue_type');
    if (!issueType.value) {
        document.getElementById('typeError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('typeError').style.display = 'none';
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
    
    // Validasi priority (radio button)
    const prioritySelected = document.querySelector('input[name="priority"]:checked');
    if (!prioritySelected) {
        document.getElementById('priorityError').style.display = 'block';
        isValid = false;
    } else {
        document.getElementById('priorityError').style.display = 'none';
    }
    
    // Validasi estimated hours
    const estimatedHours = document.getElementById('estimated_hours');
    if (estimatedHours.value && parseFloat(estimatedHours.value) < 0.5) {
        estimatedHours.classList.add('is-invalid');
        isValid = false;
    }
    
    // Validasi due date (tidak boleh kurang dari hari ini)
    const dueDate = document.getElementById('due_date');
    const today = new Date().toISOString().split('T')[0];
    if (dueDate.value && dueDate.value < today) {
        dueDate.classList.add('is-invalid');
        isValid = false;
    }
    
    return isValid;
}

// Submit form dengan validasi dan loading
document.getElementById('createIssueForm')?.addEventListener('submit', function(e) {
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
    
    showLoading('Membuat issue baru...');
});

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
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