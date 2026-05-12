<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
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
        color: #36b9cc;
        font-weight: 500;
    }
    
    /* Tombol loading */
    .btn-loading {
        opacity: 0.7;
        cursor: wait;
        pointer-events: none;
    }
    
    /* Animasi fade out alert */
    .alert {
        transition: opacity 0.5s ease;
    }
</style>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-exclamation-circle me-2 text-danger"></i>
            <?= $title ?? 'Manajemen Issues' ?>
        </h5>
        <div>
            <button class="btn btn-success btn-sm me-2" onclick="exportIssues()" id="btnExport">
                <i class="fas fa-file-export me-2"></i>Export
            </button>
            <a href="/admin/issues/create" class="btn btn-primary btn-sm" id="btnCreate">
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

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
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
                                        <option value="<?= $proj['id'] ?>" <?= ($filters['project_id'] ?? '') == $proj['id'] ? 'selected' : '' ?>>
                                            <?= $proj['project_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Type</label>
                                <select class="form-select" id="filterType">
                                    <option value="">Semua Type</option>
                                    <option value="task" <?= ($filters['type'] ?? '') == 'task' ? 'selected' : '' ?>>Task</option>
                                    <option value="bug" <?= ($filters['type'] ?? '') == 'bug' ? 'selected' : '' ?>>Bug</option>
                                    <option value="story" <?= ($filters['type'] ?? '') == 'story' ? 'selected' : '' ?>>Story</option>
                                    <option value="epic" <?= ($filters['type'] ?? '') == 'epic' ? 'selected' : '' ?>>Epic</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Status</label>
                                <select class="form-select" id="filterStatus">
                                    <option value="">Semua Status</option>
                                    <option value="To Do" <?= ($filters['status'] ?? '') == 'To Do' ? 'selected' : '' ?>>To Do</option>
                                    <option value="In Progress" <?= ($filters['status'] ?? '') == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                                    <option value="In Review" <?= ($filters['status'] ?? '') == 'In Review' ? 'selected' : '' ?>>In Review</option>
                                    <option value="Done" <?= ($filters['status'] ?? '') == 'Done' ? 'selected' : '' ?>>Done</option>
                                    <option value="Closed" <?= ($filters['status'] ?? '') == 'Closed' ? 'selected' : '' ?>>Closed</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Priority</label>
                                <select class="form-select" id="filterPriority">
                                    <option value="">Semua Priority</option>
                                    <option value="Highest" <?= ($filters['priority'] ?? '') == 'Highest' ? 'selected' : '' ?>>Highest</option>
                                    <option value="High" <?= ($filters['priority'] ?? '') == 'High' ? 'selected' : '' ?>>High</option>
                                    <option value="Medium" <?= ($filters['priority'] ?? '') == 'Medium' ? 'selected' : '' ?>>Medium</option>
                                    <option value="Low" <?= ($filters['priority'] ?? '') == 'Low' ? 'selected' : '' ?>>Low</option>
                                    <option value="Lowest" <?= ($filters['priority'] ?? '') == 'Lowest' ? 'selected' : '' ?>>Lowest</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Assignee</label>
                                <select class="form-select" id="filterAssignee">
                                    <option value="">Semua Assignee</option>
                                    <option value="unassigned" <?= ($filters['assignee'] ?? '') == 'unassigned' ? 'selected' : '' ?>>Unassigned</option>
                                    <?php foreach($users as $user): ?>
                                        <option value="<?= $user['id'] ?>" <?= ($filters['assignee'] ?? '') == $user['id'] ? 'selected' : '' ?>>
                                            <?= $user['username'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-sm" onclick="applyFilters()" id="btnApplyFilter">
                                    <i class="fas fa-filter me-2"></i>Apply Filter
                                </button>
                                <button class="btn btn-secondary btn-sm" onclick="resetFilters()" id="btnResetFilter">
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
                                <a href="/admin/issues/create" class="btn btn-primary btn-sm" id="btnCreateFirst">
                                    <i class="fas fa-plus me-2"></i>Buat Issue Pertama
                                </a>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($issues as $issue): ?>
                            <tr class="issue-row" data-id="<?= $issue['id'] ?>">
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
                                    <strong><?= esc($issue['title']) ?></strong>
                                    <?php if($issue['parent_issue_id']): ?>
                                        <br><small class="text-muted">Sub-task of #<?= $issue['parent_issue_id'] ?></small>
                                    <?php endif; ?>
                                </td>
                                <td onclick="showDetail(<?= $issue['id'] ?>)"><?= esc($issue['project_name']) ?></td>
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
                                            <?= esc($issue['assignee_name']) ?>
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
                                        <?= esc($issue['reporter_name']) ?>
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
                                        <a href="/admin/issues/<?= $issue['id'] ?>" class="btn btn-info btn-sm" title="Detail" data-detail-link>
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/admin/issues/edit/<?= $issue['id'] ?>" class="btn btn-warning btn-sm" title="Edit" data-edit-link>
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="javascript:void(0)" 
                                           class="btn btn-danger btn-sm" 
                                           onclick="confirmDelete(<?= $issue['id'] ?>, '<?= addslashes($issue['title']) ?>')"
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

// Show detail
function showDetail(id) {
    showLoading('Memuat detail issue...');
    setTimeout(() => {
        window.location.href = '/admin/issues/' + id;
    }, 200);
}

// Apply filters
function applyFilters() {
    const project = document.getElementById('filterProject').value;
    const type = document.getElementById('filterType').value;
    const status = document.getElementById('filterStatus').value;
    const priority = document.getElementById('filterPriority').value;
    const assignee = document.getElementById('filterAssignee').value;
    
    showLoading('Menerapkan filter...');
    setTimeout(() => {
        window.location.href = `/admin/issues?project=${project}&type=${type}&status=${status}&priority=${priority}&assignee=${assignee}`;
    }, 200);
}

// Reset filters
function resetFilters() {
    showLoading('Merreset filter...');
    setTimeout(() => {
        window.location.href = '/admin/issues';
    }, 200);
}

// Export issues
function exportIssues() {
    showLoading('Menyiapkan file export...');
    setTimeout(() => {
        window.location.href = '/admin/issues/export';
        setTimeout(() => {
            hideLoading();
        }, 1000);
    }, 200);
}

// Confirm delete with SweetAlert-style
function confirmDelete(id, title) {
    if (confirm(`⚠️ PERINGATAN!\n\nYakin ingin menghapus issue "${title}"?\n\nData yang dihapus tidak dapat dikembalikan!\n\nKlik OK untuk menghapus.`)) {
        showLoading('Menghapus issue...');
        setTimeout(() => {
            window.location.href = '/admin/issues/delete/' + id;
        }, 200);
    }
}

// Loading untuk tombol create
document.getElementById('btnCreate')?.addEventListener('click', function(e) {
    showLoading('Membuka form create issue...');
});
document.getElementById('btnCreateFirst')?.addEventListener('click', function(e) {
    showLoading('Membuka form create issue...');
});

// Loading untuk tombol edit
document.querySelectorAll('[data-edit-link]').forEach(btn => {
    btn.addEventListener('click', function(e) {
        showLoading('Membuka form edit issue...');
    });
});

// Loading untuk tombol detail
document.querySelectorAll('[data-detail-link]').forEach(btn => {
    btn.addEventListener('click', function(e) {
        showLoading('Memuat detail issue...');
    });
});

// Loading untuk tombol filter
document.getElementById('btnApplyFilter')?.addEventListener('click', function(e) {
    showLoading('Menerapkan filter...');
});
document.getElementById('btnResetFilter')?.addEventListener('click', function(e) {
    showLoading('Merreset filter...');
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto close alert setelah 5 detik
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>