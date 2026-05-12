<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }
    .timeline-item:after {
        content: '';
        position: absolute;
        left: -24px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #667eea;
        border: 2px solid white;
    }
    .timeline-item:last-child:before {
        display: none;
    }
    .status-badge {
        font-size: 14px;
        padding: 8px 15px;
        border-radius: 20px;
    }
    .priority-badge {
        font-size: 12px;
        padding: 5px 10px;
        border-radius: 15px;
    }
    .issue-type-icon {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }
    .detail-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .detail-card .card-header {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
        font-weight: 600;
        border-radius: 15px 15px 0 0 !important;
    }
    .detail-card .card-body {
        padding: 20px;
    }
    .info-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #333;
    }
    .comment-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 3px solid #667eea;
    }
    .comment-box .comment-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
        font-size: 13px;
    }
    .comment-box .comment-author {
        font-weight: 600;
        color: #667eea;
    }
    .comment-box .comment-date {
        color: #999;
    }
    .comment-box .comment-content {
        font-size: 14px;
        color: #333;
    }
    .activity-item {
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }
    .activity-item:last-child {
        border-bottom: none;
    }
    .activity-user {
        font-weight: 600;
        color: #667eea;
    }
    .activity-time {
        color: #999;
        font-size: 11px;
        margin-left: 10px;
    }
    .activity-field {
        background: #f0f0f0;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 11px;
        margin: 0 5px;
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
        color: #667eea;
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
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div class="d-flex align-items-center">
                <div class="issue-type-icon me-3 
                    <?php 
                    switch($issue['issue_type']) {
                        case 'task':
                            echo 'bg-primary text-white';
                            break;
                        case 'bug':
                            echo 'bg-danger text-white';
                            break;
                        case 'story':
                            echo 'bg-success text-white';
                            break;
                        case 'epic':
                            echo 'bg-warning text-white';
                            break;
                        default:
                            echo 'bg-secondary text-white';
                    }
                    ?>">
                    <?php 
                    switch($issue['issue_type']) {
                        case 'task':
                            echo '<i class="fas fa-check-circle"></i>';
                            break;
                        case 'bug':
                            echo '<i class="fas fa-bug"></i>';
                            break;
                        case 'story':
                            echo '<i class="fas fa-book"></i>';
                            break;
                        case 'epic':
                            echo '<i class="fas fa-layer-group"></i>';
                            break;
                        default:
                            echo '<i class="fas fa-circle"></i>';
                    }
                    ?>
                </div>
                <div>
                    <h5 class="mb-1">
                        <?= esc($issue['title']) ?>
                        <span class="badge bg-secondary ms-2">#<?= $issue['id'] ?></span>
                    </h5>
                    <div class="text-muted small">
                        <i class="far fa-clock me-1"></i> Dibuat <?= date('d M Y H:i', strtotime($issue['created_at'])) ?> 
                        oleh <strong><?= esc($issue['reporter_name']) ?></strong>
                        <?php if($issue['updated_at'] != $issue['created_at']): ?>
                            <span class="mx-2">•</span>
                            <i class="far fa-edit me-1"></i> Diupdate <?= date('d M Y H:i', strtotime($issue['updated_at'])) ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div>
                <a href="/admin/issues/edit/<?= $issue['id'] ?>" class="btn btn-warning btn-sm me-2" id="btnEdit">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="/admin/issues" class="btn btn-secondary btn-sm" id="btnBack">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Left Column - Main Content -->
        <div class="col-lg-8">
            <!-- Description Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi
                </div>
                <div class="card-body">
                    <?php if($issue['description']): ?>
                        <div class="p-3 bg-light rounded">
                          <?php 
$description = is_array($issue['description']) ? json_encode($issue['description']) : ($issue['description'] ?? '-');?>
                        </div>
                    <?php else: ?>
                        <p class="text-muted text-center py-3">Tidak ada deskripsi</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Activity & Comments Card -->
            <div class="detail-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-history me-2 text-primary"></i>Aktivitas & Komentar
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="showCommentForm()" id="btnShowComment">
                        <i class="fas fa-plus me-2"></i>Tambah Komentar
                    </button>
                </div>
                <div class="card-body">
                    <!-- Comment Form (hidden by default) -->
                    <div id="commentForm" style="display: none;" class="mb-4">
                        <form action="/admin/issues/comment/<?= $issue['id'] ?>" method="post" id="commentFormSubmit">
                            <?= csrf_field() ?>
                            <div class="mb-3">
                                <textarea class="form-control" name="comment" rows="3" placeholder="Tulis komentar..." required></textarea>
                                <div class="invalid-feedback">Komentar tidak boleh kosong</div>
                            </div>
                            <div class="text-end">
                                <button type="button" class="btn btn-secondary btn-sm me-2" onclick="hideCommentForm()">
                                    <i class="fas fa-times me-2"></i>Batal
                                </button>
                                <button type="submit" class="btn btn-primary btn-sm" id="btnSubmitComment">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span class="btn-text">Kirim</span>
                                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Activity Timeline -->
                    <?php if(empty($issue['logs'])): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-history fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada aktivitas</p>
                        </div>
                    <?php else: ?>
                        <div class="timeline">
                            <?php foreach($issue['logs'] as $log): ?>
                                <div class="timeline-item">
                                    <?php if(isset($log['new_status'])): ?>
                                        <!-- Status/Field Change -->
                                        <div class="activity-item">
                                            <span class="activity-user"><?= esc($log['user_name']) ?></span>
                                            <span class="activity-time"><?= date('d M H:i', strtotime($log['changed_at'])) ?></span>
                                            <div class="mt-2">
                                                <span class="activity-field"><?= esc($log['new_status']) ?></span>
                                                berubah dari 
                                                <span class="text-muted">"<?= esc($log['old_status']) ?>"</span> 
                                                menjadi 
                                                <span class="text-primary">"<?= esc($log['new_status']) ?>"</span>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <!-- Comment -->
                                        <div class="comment-box">
                                            <div class="comment-header">
                                                <span class="comment-author">
                                                    <i class="fas fa-user-circle me-2"></i><?= esc($log['user_name']) ?>
                                                </span>
                                                <span class="comment-date">
                                                    <i class="far fa-clock me-1"></i><?= date('d M Y H:i', strtotime($log['created_at'])) ?>
                                                </span>
                                            </div>
                                            <div class="comment-content">
                                              <?php 
$comment = is_array($log['comment']) ? json_encode($log['comment']) : ($log['comment'] ?? '-');
?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Right Column - Sidebar -->
        <div class="col-lg-4">
            <!-- Status Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-info-circle me-2 text-primary"></i>Status
                </div>
                <div class="card-body">
                    <div class="mb-4">
                        <div class="info-label">Current Status</div>
                        <div class="info-value">
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
                            <span class="badge <?= $statusClass ?> status-badge">
                                <i class="fas fa-circle me-2 small"></i><?= $issue['status'] ?>
                            </span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Quick Actions</div>
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-warning btn-sm" onclick="updateStatus('In Progress')" id="btnStartProgress">
                                <i class="fas fa-play me-2"></i>Start Progress
                            </button>
                            <button class="btn btn-outline-info btn-sm" onclick="updateStatus('In Review')" id="btnReview">
                                <i class="fas fa-code-branch me-2"></i>Ready for Review
                            </button>
                            <button class="btn btn-outline-success btn-sm" onclick="updateStatus('Done')" id="btnDone">
                                <i class="fas fa-check-circle me-2"></i>Mark Done
                            </button>
                            <button class="btn btn-outline-dark btn-sm" onclick="updateStatus('Closed')" id="btnClose">
                                <i class="fas fa-lock me-2"></i>Close Issue
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Details Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-tags me-2 text-primary"></i>Detail
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="info-label">Issue Type</td>
                            <td class="info-value">
                                <?php 
                                $typeBadge = '';
                                switch($issue['issue_type']) {
                                    case 'task':
                                        $typeBadge = 'bg-primary';
                                        $typeIcon = 'fa-check-circle';
                                        break;
                                    case 'bug':
                                        $typeBadge = 'bg-danger';
                                        $typeIcon = 'fa-bug';
                                        break;
                                    case 'story':
                                        $typeBadge = 'bg-success';
                                        $typeIcon = 'fa-book';
                                        break;
                                    case 'epic':
                                        $typeBadge = 'bg-warning';
                                        $typeIcon = 'fa-layer-group';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $typeBadge ?>">
                                    <i class="fas <?= $typeIcon ?> me-1"></i>
                                    <?= ucfirst($issue['issue_type']) ?>
                                </span>
                             </td>
                         </tr>
                         <tr>
                            <td class="info-label">Priority</td>
                            <td class="info-value">
                                <?php 
                                $priorityClass = '';
                                switch($issue['priority']) {
                                    case 'Highest':
                                        $priorityClass = 'bg-danger';
                                        break;
                                    case 'High':
                                        $priorityClass = 'bg-warning text-dark';
                                        break;
                                    case 'Medium':
                                        $priorityClass = 'bg-info';
                                        break;
                                    case 'Low':
                                        $priorityClass = 'bg-secondary';
                                        break;
                                    case 'Lowest':
                                        $priorityClass = 'bg-light text-dark';
                                        break;
                                }
                                ?>
                                <span class="badge <?= $priorityClass ?> priority-badge">
                                    <i class="fas fa-flag me-1"></i><?= $issue['priority'] ?>
                                </span>
                             </td>
                         </tr>
                         <tr>
                            <td class="info-label">Project</td>
                            <td class="info-value">
                                <a href="/admin/projects/<?= $issue['project_id'] ?>" class="text-decoration-none" id="linkProject">
                                    <i class="fas fa-project-diagram me-2 text-primary"></i><?= esc($issue['project_name']) ?>
                                </a>
                             </td>
                         </tr>
                        <?php if($issue['parent_issue_id']): ?>
                         <tr>
                            <td class="info-label">Parent Issue</td>
                            <td class="info-value">
                                <a href="/admin/issues/<?= $issue['parent_issue_id'] ?>" class="text-decoration-none" id="linkParent">
                                    <i class="fas fa-link me-2 text-primary"></i>#<?= $issue['parent_issue_id'] ?> - <?= esc($issue['parent']['title'] ?? '') ?>
                                </a>
                             </td>
                         </tr>
                        <?php endif; ?>
                     </table>
                </div>
            </div>

            <!-- Assignment Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-user-check me-2 text-primary"></i>Assignment
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="info-label">Reporter</div>
                        <div class="d-flex align-items-center mt-2">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                 style="width: 40px; height: 40px; background: linear-gradient(135deg, #667eea, #764ba2);">
                                <?= strtoupper(substr($issue['reporter_name'], 0, 1)) ?>
                            </div>
                            <div>
                                <div class="fw-bold"><?= esc($issue['reporter_name']) ?></div>
                                <div class="small text-muted"><?= esc($issue['reporter_email']) ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <div class="info-label">Assignee</div>
                        <?php if($issue['assignee_id']): ?>
                            <div class="d-flex align-items-center mt-2">
                                <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    <?= strtoupper(substr($issue['assignee_name'], 0, 1)) ?>
                                </div>
                                <div>
                                    <div class="fw-bold"><?= esc($issue['assignee_name']) ?></div>
                                    <div class="small text-muted"><?= esc($issue['assignee_email']) ?></div>
                                </div>
                            </div>
                        <?php else: ?>
                            <p class="text-muted mt-2">Unassigned</p>
                        <?php endif; ?>
                        
                        <button class="btn btn-outline-primary btn-sm w-100 mt-3" onclick="showAssignModal()" id="btnAssign">
                            <i class="fas fa-exchange-alt me-2"></i>Change Assignee
                        </button>
                    </div>
                </div>
            </div>

            <!-- Planning Card -->
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Planning
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                         <tr>
                            <td class="info-label">Due Date</td>
                            <td class="info-value">
                                <?php if($issue['due_date']): ?>
                                    <?php 
                                    $dueClass = '';
                                    if(strtotime($issue['due_date']) < time() && $issue['status'] != 'Done' && $issue['status'] != 'Closed') {
                                        $dueClass = 'text-danger fw-bold';
                                    }
                                    ?>
                                    <span class="<?= $dueClass ?>">
                                        <i class="far fa-calendar me-2"></i><?= date('d M Y', strtotime($issue['due_date'])) ?>
                                        <?php if($dueClass): ?>
                                            <span class="badge bg-danger ms-2">Overdue</span>
                                        <?php endif; ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">Not set</span>
                                <?php endif; ?>
                             </td>
                         </tr>
                         <tr>
                            <td class="info-label">Estimated Hours</td>
                            <td class="info-value">
                                <i class="fas fa-clock me-2 text-warning"></i>
                                <?= $issue['estimated_hours'] ?? '-' ?> hours
                             </td>
                         </tr>
                         <tr>
                            <td class="info-label">Actual Hours</td>
                            <td class="info-value">
                                <i class="fas fa-hourglass-half me-2 text-success"></i>
                                <?= $issue['actual_hours'] ?? '-' ?> hours
                             </td>
                         </tr>
                     </table>

                    <button class="btn btn-outline-warning btn-sm w-100 mt-2" onclick="showTimeModal()" id="btnLogTime">
                        <i class="fas fa-clock me-2"></i>Log Time
                    </button>
                </div>
            </div>

            <!-- Children Issues (Subtask) -->
            <?php if(!empty($issue['children'])): ?>
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-sitemap me-2 text-primary"></i>Subtasks
                </div>
                <div class="card-body p-0">
                    <ul class="list-group list-group-flush">
                        <?php foreach($issue['children'] as $child): ?>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <a href="/admin/issues/<?= $child['id'] ?>" class="text-decoration-none" data-child-link>
                                        <i class="fas fa-check-circle text-primary me-2"></i>
                                        <?= esc($child['title']) ?>
                                    </a>
                                </div>
                                <span class="badge <?= $child['status'] == 'Done' ? 'bg-success' : 'bg-warning' ?>">
                                    <?= $child['status'] ?>
                                </span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Assign Modal -->
<div class="modal fade" id="assignModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-check me-2 text-primary"></i>
                    Change Assignee
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/issues/assign/<?= $issue['id'] ?>" method="post" id="assignForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="assignee_id" class="form-label">Select Assignee</label>
                        <select name="assignee_id" id="assignee_id" class="form-select">
                            <option value="">-- Unassigned --</option>
                            <?php foreach($users as $user): ?>
                                <?php if(in_array($user['role_name'] ?? '', ['admin', 'staff', 'superadmin'])): ?>
                                    <option value="<?= $user['id'] ?>" 
                                        <?= $user['id'] == $issue['assignee_id'] ? 'selected' : '' ?>>
                                        <?= esc($user['username']) ?> (<?= ucfirst($user['role_name'] ?? '') ?>)
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="btnSaveAssign">
                        <i class="fas fa-save me-2"></i>
                        <span class="btn-text">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Time Log Modal -->
<div class="modal fade" id="timeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-clock me-2 text-warning"></i>
                    Log Time
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/issues/time/<?= $issue['id'] ?>" method="post" id="timeForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="hours" class="form-label">Hours Spent <span class="text-danger">*</span></label>
                        <input type="number" 
                               name="hours" 
                               id="hours" 
                               class="form-control" 
                               step="0.5" 
                               min="0.5" 
                               placeholder="Contoh: 2.5"
                               required>
                        <div class="invalid-feedback">Jam kerja wajib diisi minimal 0.5 jam</div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description (Optional)</label>
                        <textarea name="description" 
                                  id="description" 
                                  class="form-control" 
                                  rows="3" 
                                  placeholder="Apa yang dikerjakan?"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning" id="btnSaveTime">
                        <i class="fas fa-clock me-2"></i>
                        <span class="btn-text">Log Time</span>
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
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Memproses...') {
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

// Show/Hide Comment Form
function showCommentForm() {
    document.getElementById('commentForm').style.display = 'block';
}

function hideCommentForm() {
    document.getElementById('commentForm').style.display = 'none';
    document.getElementById('commentFormSubmit').reset();
}

// Show Modals
function showAssignModal() {
    new bootstrap.Modal(document.getElementById('assignModal')).show();
}

function showTimeModal() {
    new bootstrap.Modal(document.getElementById('timeModal')).show();
}

// Update Status with confirmation
function updateStatus(status) {
    if (confirm(`⚠️ PERINGATAN!\n\nUpdate status menjadi "${status}"?\n\nKlik OK untuk melanjutkan.`)) {
        showLoading(`Mengupdate status ke ${status}...`);
        setTimeout(() => {
            window.location.href = '/admin/issues/status/<?= $issue['id'] ?>?status=' + status;
        }, 200);
    }
}

// Validasi form komentar
document.getElementById('commentFormSubmit')?.addEventListener('submit', function(e) {
    const comment = this.querySelector('textarea[name="comment"]');
    if (!comment.value.trim()) {
        e.preventDefault();
        comment.classList.add('is-invalid');
        comment.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    
    const btn = document.getElementById('btnSubmitComment');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Mengirim...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    showLoading('Mengirim komentar...');
});

// Validasi form assign
document.getElementById('assignForm')?.addEventListener('submit', function(e) {
    const btn = document.getElementById('btnSaveAssign');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    showLoading('Mengupdate assignee...');
});

// Validasi form log time
document.getElementById('timeForm')?.addEventListener('submit', function(e) {
    const hours = document.getElementById('hours');
    if (!hours.value || parseFloat(hours.value) < 0.5) {
        e.preventDefault();
        hours.classList.add('is-invalid');
        hours.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }
    
    const btn = document.getElementById('btnSaveTime');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    showLoading('Menyimpan log time...');
});

// Loading untuk tombol navigasi
document.getElementById('btnEdit')?.addEventListener('click', function(e) {
    showLoading('Membuka form edit...');
});
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});
document.getElementById('linkProject')?.addEventListener('click', function(e) {
    showLoading('Memuat detail proyek...');
});
document.getElementById('linkParent')?.addEventListener('click', function(e) {
    showLoading('Memuat parent issue...');
});
document.querySelectorAll('[data-child-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        showLoading('Memuat subtask...');
    });
});

// Hapus class is-invalid saat user mengetik
document.querySelector('textarea[name="comment"]')?.addEventListener('input', function() {
    this.classList.remove('is-invalid');
});
document.getElementById('hours')?.addEventListener('input', function() {
    if (this.value && parseFloat(this.value) >= 0.5) {
        this.classList.remove('is-invalid');
    }
});

// Auto-hide flash messages
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});
</script>

<?= $this->endSection() ?>