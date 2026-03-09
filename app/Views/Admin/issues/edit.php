<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2 text-warning"></i>
            <?= $title ?>
        </h5>
        <div>
            <a href="/admin/issues/<?= $issue['id'] ?>" class="btn btn-info btn-sm me-2">
                <i class="fas fa-eye me-2"></i>Detail
            </a>
            <a href="/admin/issues" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="card bg-light border-primary mb-4">
            <div class="card-body">
                <h6 class="card-title text-primary">
                    <i class="fas fa-info-circle me-2"></i>Informasi Issue Saat Ini
                </h6>
                <div class="row">
                    <div class="col-md-8">
                        <table class="table table-sm table-borderless">
                            <tr>
                                <th width="120">Issue #</th>
                                <td>: <span class="badge bg-secondary">#<?= $issue['id'] ?></span></td>
                            </tr>
                            <tr>
                                <th>Type</th>
                                <td>: 
                                    <?php 
                                    $typeIcon = '';
                                    $typeClass = '';
                                    switch($issue['issue_type']) {
                                        case 'task':
                                            $typeIcon = 'fa-check-circle';
                                            $typeClass = 'text-primary';
                                            $typeLabel = 'Task';
                                            break;
                                        case 'bug':
                                            $typeIcon = 'fa-bug';
                                            $typeClass = 'text-danger';
                                            $typeLabel = 'Bug';
                                            break;
                                        case 'story':
                                            $typeIcon = 'fa-book';
                                            $typeClass = 'text-success';
                                            $typeLabel = 'Story';
                                            break;
                                        case 'epic':
                                            $typeIcon = 'fa-layer-group';
                                            $typeClass = 'text-warning';
                                            $typeLabel = 'Epic';
                                            break;
                                        default:
                                            $typeIcon = 'fa-circle';
                                            $typeClass = 'text-secondary';
                                            $typeLabel = ucfirst($issue['issue_type']);
                                    }
                                    ?>
                                    <i class="fas <?= $typeIcon ?> <?= $typeClass ?> me-1"></i>
                                    <?= $typeLabel ?>
                                </td>
                            </tr>
                            <tr>
                                <th>Title</th>
                                <td>: <strong><?= $issue['title'] ?></strong></td>
                            </tr>
                            <tr>
                                <th>Status</th>
                                <td>: 
                                    <?php 
                                    $statusClass = '';
                                    switch($issue['status']) {
                                        case 'To Do':
                                            $statusClass = 'bg-secondary';
                                            break;
                                        case 'In Progress':
                                            $statusClass = 'bg-warning text-dark';
                                            break;
                                        case 'In Review':
                                            $statusClass = 'bg-info';
                                            break;
                                        case 'Done':
                                            $statusClass = 'bg-success';
                                            break;
                                        case 'Closed':
                                            $statusClass = 'bg-dark';
                                            break;
                                    }
                                    ?>
                                    <span class="badge <?= $statusClass ?>"><?= $issue['status'] ?></span>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">
                            <i class="far fa-clock me-1"></i> Created: <?= date('d M Y H:i', strtotime($issue['created_at'])) ?><br>
                            <i class="far fa-edit me-1"></i> Last Update: <?= date('d M Y H:i', strtotime($issue['updated_at'])) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="/admin/issues/update/<?= $issue['id'] ?>" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                <input type="text" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('title')) ? 'is-invalid' : '' ?>" 
                                       id="title" 
                                       name="title" 
                                       value="<?= old('title', $issue['title']) ?>" 
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
                                          rows="6"><?= old('description', $issue['description']) ?></textarea>
                                <small class="text-muted">Jelaskan issue secara detail</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-tasks me-2"></i>Status & Priority
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('status')) ? 'is-invalid' : '' ?>" 
                                        id="status" 
                                        name="status" 
                                        required>
                                    <option value="">-- Pilih Status --</option>
                                    <option value="To Do" <?= old('status', $issue['status']) == 'To Do' ? 'selected' : '' ?>>To Do</option>
                                    <option value="In Progress" <?= old('status', $issue['status']) == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="In Review" <?= old('status', $issue['status']) == 'In Review' ? 'selected' : '' ?>>In Review</option>
                                    <option value="Done" <?= old('status', $issue['status']) == 'Done' ? 'selected' : '' ?>>Done</option>
                                    <option value="Closed" <?= old('status', $issue['status']) == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                </select>
                                <?php if(isset($validation) && $validation->hasError('status')): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('status') ?></div>
                                <?php endif; ?>
                            </div>

                            <div class="mb-3">
                                <label for="priority" class="form-label">Priority <span class="text-danger">*</span></label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('priority')) ? 'is-invalid' : '' ?>" 
                                        id="priority" 
                                        name="priority" 
                                        required>
                                    <option value="">-- Pilih Priority --</option>
                                    <option value="Lowest" <?= old('priority', $issue['priority']) == 'Lowest' ? 'selected' : '' ?>>Lowest</option>
                                    <option value="Low" <?= old('priority', $issue['priority']) == 'Low' ? 'selected' : '' ?>>Low</option>
                                    <option value="Medium" <?= old('priority', $issue['priority']) == 'Medium' ? 'selected' : '' ?>>Medium</option>
                                    <option value="High" <?= old('priority', $issue['priority']) == 'High' ? 'selected' : '' ?>>High</option>
                                    <option value="Highest" <?= old('priority', $issue['priority']) == 'Highest' ? 'selected' : '' ?>>Highest</option>
                                </select>
                                <?php if(isset($validation) && $validation->hasError('priority')): ?>
                                    <div class="invalid-feedback"><?= $validation->getError('priority') ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

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
                                                <?= old('assignee_id', $issue['assignee_id']) == $user['id'] ? 'selected' : '' ?>>
                                                <?= $user['username'] ?> (<?= ucfirst($user['role_name'] ?? '') ?>)
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Pilih staff yang akan mengerjakan</small>
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
                                       value="<?= old('due_date', $issue['due_date']) ?>"
                                       min="<?= date('Y-m-d') ?>">
                            </div>

                            <div class="mb-3">
                                <label for="estimated_hours" class="form-label">Estimated Hours</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="estimated_hours" 
                                       name="estimated_hours" 
                                       value="<?= old('estimated_hours', $issue['estimated_hours']) ?>"
                                       step="0.5"
                                       min="0.5">
                                <small class="text-muted">Estimasi waktu pengerjaan (jam)</small>
                            </div>

                            <?php if($issue['actual_hours'] > 0): ?>
                            <div class="mb-3">
                                <label class="form-label">Actual Hours</label>
                                <input type="text" 
                                       class="form-control bg-light" 
                                       value="<?= $issue['actual_hours'] ?> hours" 
                                       readonly>
                                <small class="text-muted">Total waktu yang sudah dicatat</small>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <?php if($issue['issue_type'] == 'subtask' || !empty($parent_issues)): ?>
                    <div class="card mb-4">
                        <div class="card-header bg-light">
                            <i class="fas fa-link me-2"></i>Parent Issue
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="parent_issue_id" class="form-label">Parent Issue</label>
                                <select class="form-select" id="parent_issue_id" name="parent_issue_id">
                                    <option value="">-- No Parent --</option>
                                    <?php foreach($parent_issues as $parent): ?>
                                        <option value="<?= $parent['id'] ?>" 
                                            <?= old('parent_issue_id', $issue['parent_issue_id']) == $parent['id'] ? 'selected' : '' ?>>
                                            #<?= $parent['id'] ?> - <?= $parent['title'] ?> (<?= $parent['status'] ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <small class="text-muted">Untuk subtask, pilih parent issue</small>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>

            <hr>

            <div class="alert alert-warning mb-4">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Perhatian:</strong> Perubahan pada issue akan dicatat dalam history.
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/issues/<?= $issue['id'] ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-2"></i>Update Issue
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {

    const titleInput = document.getElementById('title');
    const statusSelect = document.getElementById('status');
    const prioritySelect = document.getElementById('priority');
    
    function updatePreview() {
        const previewTitle = document.querySelector('.card-title');
        const previewStatus = document.querySelector('.badge.bg-secondary, .badge.bg-warning.text-dark, .badge.bg-info, .badge.bg-success, .badge.bg-dark');
        const previewPriority = document.querySelector('.card-body .mb-3:nth-child(2)');

        if(previewTitle) {
            previewTitle.textContent = titleInput.value || 'Informasi Issue Saat Ini';
        }
        if(previewStatus) {
            let statusClass = '';
            switch(statusSelect.value) {
                case 'To Do':
                    statusClass = 'bg-secondary';
                    break;
                case 'In Progress':
                    statusClass = 'bg-warning text-dark';
                    break;
                case 'In Review':
                    statusClass = 'bg-info';
                    break;
                case 'Done':
                    statusClass = 'bg-success';
                    break;
                case 'Closed':
                    statusClass = 'bg-dark';
                    break;
            }
            previewStatus.className = `badge ${statusClass}`;
            previewStatus.textContent = statusSelect.value || 'No Status';
        }
        if(previewPriority) {
            previewPriority.textContent = `Priority: ${prioritySelect.value || 'No Priority'}`;
        }
    }
    
    titleInput.addEventListener('keyup', updatePreview);
    statusSelect.addEventListener('change', updatePreview);
    prioritySelect.addEventListener('change', updatePreview);
});

setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>