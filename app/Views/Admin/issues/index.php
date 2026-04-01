<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-exclamation-circle me-2 text-danger"></i>
            <?= $title ?? 'Manajemen Issues' ?>
        </h5>
        <div>
            <button class="btn btn-success btn-sm me-2" onclick="exportIssues()">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
            <a href="/admin/issues/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Buat Issue Baru
            </a>
        </div>
    </div>
    <div class="card-body">
        <!-- Flash Messages -->
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Filter Section -->
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <label class="form-label">Project</label>
                                <select class="form-select" id="filterProject">
                                    <option value="">Semua Project</option>
                                    <?php foreach($projects as $proj): ?>
                                        <option value="<?= $proj['id'] ?>"><?= $proj['project_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="filterType">
                                    <option value="">Semua Type</option>
                                    <option value="task">Task</option>
                                    <option value="bug">Bug</option>
                                    <option value="story">Story</option>
                                    <option value="epic">Epic</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="To Do">To Do</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="In Review">In Review</option>
                                    <option value="Done">Done</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Priority</label>
                                <select class="form-select" id="filterPriority">
                                    <option value="">Semua Priority</option>
                                    <option value="Highest">Highest</option>
                                    <option value="High">High</option>
                                    <option value="Medium">Medium</option>
                                    <option value="Low">Low</option>
                                    <option value="Lowest">Lowest</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Assignee</label>
                                <select class="form-select" id="filterAssignee">
                                    <option value="">Semua Assignee</option>
                                    <option value="unassigned">Unassigned</option>
                                    <?php foreach($users as $user): ?>
                                        <option value="<?= $user['id'] ?>"><?= $user['username'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-sm" onclick="applyFilters()">
                                    <i class="fas fa-filter me-2"></i>Apply Filter
                                </button>
                                <button class="btn btn-secondary btn-sm" onclick="resetFilters()">
                                    <i class="fas fa-undo me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Total Issues</h6>
                                <h3 class="mt-2 mb-0"><?= count($issues) ?></h3>
                            </div>
                            <i class="fas fa-exclamation-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">In Progress</h6>
                                <h3 class="mt-2 mb-0">
                                    <?= array_reduce($issues, function($c, $i) { 
                                        return $c + ($i['status'] == 'In Progress' ? 1 : 0); 
                                    }, 0) ?>
                                </h3>
                            </div>
                            <i class="fas fa-spinner fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-danger text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">High Priority</h6>
                                <h3 class="mt-2 mb-0">
                                    <?= array_reduce($issues, function($c, $i) { 
                                        return $c + (in_array($i['priority'], ['High', 'Highest']) ? 1 : 0); 
                                    }, 0) ?>
                                </h3>
                            </div>
                            <i class="fas fa-flag fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h6 class="mb-0">Completed</h6>
                                <h3 class="mt-2 mb-0">
                                    <?= array_reduce($issues, function($c, $i) { 
                                        return $c + (in_array($i['status'], ['Done', 'Closed']) ? 1 : 0); 
                                    }, 0) ?>
                                </h3>
                            </div>
                            <i class="fas fa-check-circle fa-3x opacity-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Issues Table -->
        <div class="table-responsive">
            <table class="table table-hover table-bordered" id="issuesTable">
                <thead class="table-light">
                    <tr>
                        <th>ID</th>
                        <th>Type</th>
                        <th>Title</th>
                        <th>Project</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Assignee</th>
                        <th>Reporter</th>
                        <th>Due Date</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($issues)): ?>
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <i class="fas fa-exclamation-circle fa-4x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada issue</p>
                                <a href="/admin/issues/create" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus me-2"></i>Buat Issue Pertama
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($issues as $issue): ?>
                            <tr class="issue-row" data-id="<?= $issue['id'] ?>" style="cursor: pointer;">
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
                                    <span class="badge bg-secondary">#<?= $issue['id'] ?></span>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
                                    <?php 
                                    $typeIcon = '';
                                    $typeClass = '';
                                    switch($issue['issue_type']) {
                                        case 'task':
                                            $typeIcon = 'fa-check-circle';
                                            $typeClass = 'text-primary';
                                            break;
                                        case 'bug':
                                            $typeIcon = 'fa-bug';
                                            $typeClass = 'text-danger';
                                            break;
                                        case 'story':
                                            $typeIcon = 'fa-book';
                                            $typeClass = 'text-success';
                                            break;
                                        case 'epic':
                                            $typeIcon = 'fa-layer-group';
                                            $typeClass = 'text-warning';
                                            break;
                                    }
                                    ?>
                                    <i class="fas <?= $typeIcon ?> <?= $typeClass ?> me-1"></i>
                                    <?= ucfirst($issue['issue_type']) ?>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
                                    <strong><?= $issue['title'] ?></strong>
                                    <?php if($issue['parent_issue_id']): ?>
                                        <br><small class="text-muted">Sub-task of #<?= $issue['parent_issue_id'] ?></small>
                                    <?php endif; ?>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)"><?= $issue['project_name'] ?></td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
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
                                    <span class="badge <?= $statusClass ?>">
                                        <?= $issue['status'] ?>
                                    </span>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
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
                                    <span class="badge <?= $priorityClass ?>">
                                        <?= $issue['priority'] ?>
                                    </span>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
                                    <?php if($issue['assignee_name']): ?>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 25px; height: 25px; font-size: 12px;">
                                                <?= strtoupper(substr($issue['assignee_name'], 0, 1)) ?>
                                            </div>
                                            <?= $issue['assignee_name'] ?>
                                        </div>
                                    <?php else: ?>
                                        <span class="text-muted">Unassigned</span>
                                    <?php endif; ?>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
                                    <div class="d-flex align-items-center">
                                        <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center me-2" 
                                             style="width: 25px; height: 25px; font-size: 12px;">
                                            <?= strtoupper(substr($issue['reporter_name'], 0, 1)) ?>
                                        </div>
                                        <?= $issue['reporter_name'] ?>
                                    </div>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)">
                                    <?php if($issue['due_date']): ?>
                                        <?php 
                                        $dueClass = '';
                                        if(strtotime($issue['due_date']) < time() && !in_array($issue['status'], ['Done', 'Closed'])) {
                                            $dueClass = 'text-danger fw-bold';
                                        }
                                        ?>
                                        <span class="<?= $dueClass ?>">
                                            <i class="far fa-calendar me-1"></i>
                                            <?= date('d M Y', strtotime($issue['due_date'])) ?>
                                        </span>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="/admin/issues/<?= $issue['id'] ?>" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/admin/issues/edit/<?= $issue['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/issues/delete/<?= $issue['id'] ?>" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus issue ini?')"
                                           title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
                </div>

        <!-- Pagination -->
        <?php if(isset($pager)): ?>
            <div class="mt-4">
                <?= $pager->links() ?>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript -->
<script>
function showDetail(id) {
    window.location.href = '/admin/issues/' + id;
}

function applyFilters() {
    const project = document.getElementById('filterProject').value;
    const type = document.getElementById('filterType').value;
    const status = document.getElementById('filterStatus').value;
    const priority = document.getElementById('filterPriority').value;
    const assignee = document.getElementById('filterAssignee').value;
    
    window.location.href = `/admin/issues?project=${project}&type=${type}&status=${status}&priority=${priority}&assignee=${assignee}`;
}

function resetFilters() {
    window.location.href = '/admin/issues';
}

function exportIssues() {
    window.location.href = '/admin/issues/export';
}

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