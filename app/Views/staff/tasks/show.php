<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .status-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: 500;
    }
    .priority-badge {
        padding: 6px 15px;
        border-radius: 20px;
        font-size: 13px;
    }
    .comment-box {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 15px;
        margin-bottom: 15px;
        border-left: 3px solid #667eea;
    }
    .timeline-item {
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-tasks me-2 text-primary"></i>
            Task Detail #<?= $task['id'] ?>
        </h1>
        <div>
            <a href="<?= base_url('staff/tasks') ?>" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><?= $task['title'] ?></h5>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-align-left me-2 text-primary"></i>Description</h6>
                    <p><?= nl2br($task['description'] ?? 'Tidak ada deskripsi') ?></p>
                    
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-muted">Project</small>
                            <div><?= $task['project_name'] ?></div>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Due Date</small>
                            <div><?= date('d F Y', strtotime($task['due_date'])) ?></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-sync-alt me-2 text-primary"></i>Update Status</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('staff/tasks/update-status/' . $task['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="row">
                            <div class="col-md-8">
                                <select name="status" class="form-select">
                                    <option value="To Do" <?= $task['status'] == 'To Do' ? 'selected' : '' ?>>To Do</option>
                                    <option value="In Progress" <?= $task['status'] == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="In Review" <?= $task['status'] == 'In Review' ? 'selected' : '' ?>>In Review</option>
                                    <option value="Done" <?= $task['status'] == 'Done' ? 'selected' : '' ?>>Done</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-save me-2"></i>Update Status
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="mb-0"><i class="fas fa-comments me-2 text-primary"></i>Comments</h6>
                    <button class="btn btn-sm btn-primary" onclick="toggleCommentForm()">
                        <i class="fas fa-plus me-2"></i>Add Comment
                    </button>
                </div>
                <div class="card-body">
                    <div id="commentForm" style="display: none;" class="mb-4">
                        <form action="<?= base_url('staff/tasks/comment/' . $task['id']) ?>" method="post">
                            <?= csrf_field() ?>
                            <textarea name="comment" class="form-control" rows="3" placeholder="Tulis komentar..." required></textarea>
                            <div class="text-end mt-2">
                                <button type="button" class="btn btn-sm btn-secondary" onclick="hideCommentForm()">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary">Kirim</button>
                            </div>
                        </form>
                    </div>

                    <?php if(empty($comments)): ?>
                        <p class="text-muted text-center py-3">Belum ada komentar</p>
                    <?php else: ?>
                        <?php foreach($comments as $comment): ?>
                            <div class="comment-box">
                                <div class="d-flex justify-content-between">
                                    <strong><?= $comment['user_name'] ?></strong>
                                    <small class="text-muted"><?= date('d M Y H:i', strtotime($comment['created_at'])) ?></small>
                                </div>
                                <p class="mb-0 mt-2"><?= nl2br($comment['comment']) ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-info-circle me-2 text-primary"></i>Task Info</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="status-badge 
                                    <?= $task['status'] == 'To Do' ? 'bg-secondary' : 
                                        ($task['status'] == 'In Progress' ? 'bg-warning' : 
                                        ($task['status'] == 'In Review' ? 'bg-info' : 'bg-success')) ?> text-white">
                                    <?= $task['status'] ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Priority</th>
                            <td>
                                <span class="priority-badge 
                                    <?= $task['priority'] == 'Highest' ? 'bg-danger' : 
                                        ($task['priority'] == 'High' ? 'bg-warning' : 
                                        ($task['priority'] == 'Medium' ? 'bg-info' : 'bg-secondary')) ?> text-white">
                                    <?= $task['priority'] ?>
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <th>Project</th>
                            <td><?= $task['project_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Reporter</th>
                            <td><?= $task['reporter_name'] ?></td>
                        </tr>
                        <tr>
                            <th>Created</th>
                            <td><?= date('d M Y H:i', strtotime($task['created_at'])) ?></td>
                        </tr>
                        <tr>
                            <th>Last Update</th>
                            <td><?= date('d M Y H:i', strtotime($task['updated_at'])) ?></td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-clock me-2 text-primary"></i>Time Tracking</h6>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('staff/tasks/log-time/' . $task['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label class="form-label">Hours Spent</label>
                            <input type="number" name="hours" class="form-control" step="0.5" min="0.5" placeholder="Contoh: 2.5" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description (Optional)</label>
                            <textarea name="description" class="form-control" rows="2" placeholder="Apa yang dikerjakan?"></textarea>
                        </div>
                        <button type="submit" class="btn btn-warning w-100">
                            <i class="fas fa-clock me-2"></i>Log Time
                        </button>
                    </form>
                    <hr>
                    <div class="text-center">
                        <small class="text-muted">Total Hours Logged</small>
                        <h4><?= $totalHours ?? 0 ?> hours</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function toggleCommentForm() {
    document.getElementById('commentForm').style.display = 'block';
}
function hideCommentForm() {
    document.getElementById('commentForm').style.display = 'none';
}
</script>

<?= $this->endSection() ?>