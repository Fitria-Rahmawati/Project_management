<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-plus-circle me-2 text-success"></i>
            <?= $title ?>
        </h5>
        <a href="/admin/issues" class="btn btn-secondary btn-sm">
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
                            <?php if(isset($validation) && $validation->hasError('issue_type')): ?>
                                <div class="text-danger small mt-2"><?= $validation->getError('issue_type') ?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="project_id" class="form-label">Project <span class="text-danger">*</span></label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('project_id')) ? 'is-invalid' : '' ?>" 
                                        id="project_id" 
                                        name="project_id" 
                                        required>
                                    <option value="">-- Pilih Project --</option>
                                    <?php foreach($projects as $project): ?>
                                        <option value="<?= $project['id'] ?>" 
                                            <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
                                            <?= $project['project_name'] ?> 
                                            (<?= $project['project_type'] == 'internal' ? 'Internal' : 'Client' ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($validation) && $validation->hasError('project_id')): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('project_id') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('title')) ? 'is-invalid' : '' ?>" 
                                       id="title" 
                                       name="title" 
                                       value="<?= old('title') ?>" 
                                       placeholder="Contoh: Membuat halaman login"
                                       required>
                                <?php if(isset($validation) && $validation->hasError('title')): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('title') ?></div>
                                <?php endif; ?>
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
                                            #<?= $parent['id'] ?> - <?= $parent['title'] ?> (<?= $parent['status'] ?>)
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
                                                <?= $user['username'] ?> (<?= ucfirst($user['role_name'] ?? '') ?>)
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
                                <?php if(isset($validation) && $validation->hasError('priority')): ?>
                                    <div class="text-danger small"><?= $validation->getError('priority') ?></div>
                                <?php endif; ?>
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
                                <?php if(old('issue_type') == 'subtask'): ?>
                                    <li class="text-info">Subtask memerlukan parent issue</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/issues" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="fas fa-save me-2"></i>Buat Issue
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    if (!document.getElementById('issue_type').value) {
        selectType('task');
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
        document.getElementById('parent_issue_id').value = '';
    }
}

document.getElementById('title').addEventListener('keyup', function() {
    const length = this.value.length;
    const counter = document.getElementById('titleCounter');
    if (!counter) {
        const div = document.createElement('small');
        div.id = 'titleCounter';
        div.className = 'text-muted float-end';
        this.parentNode.appendChild(div);
    }
    document.getElementById('titleCounter').textContent = length + '/255';
});


setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>


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
</style>

<?= $this->endSection() ?>