<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .task-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .status-todo { background: #6c757d; color: white; }
    .status-progress { background: #ffc107; color: #333; }
    .status-review { background: #17a2b8; color: white; }
    .status-done { background: #28a745; color: white; }
    .priority-high { color: #dc3545; font-weight: bold; }
    .priority-medium { color: #ffc107; }
    .priority-low { color: #28a745; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-tasks me-2 text-primary"></i>
            My Tasks
        </h1>
        <div>
            <button class="btn btn-success btn-sm me-2" onclick="exportTasks()">
                <i class="fas fa-file-excel me-2"></i>Export
            </button>
            <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-danger btn-sm">
                <i class="fas fa-exclamation-circle me-2"></i>Report Issue
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="get" action="<?= base_url('staff/tasks') ?>">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small">Status</label>
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="To Do" <?= ($status ?? '') == 'To Do' ? 'selected' : '' ?>>To Do</option>
                        <option value="In Progress" <?= ($status ?? '') == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="In Review" <?= ($status ?? '') == 'In Review' ? 'selected' : '' ?>>In Review</option>
                        <option value="Done" <?= ($status ?? '') == 'Done' ? 'selected' : '' ?>>Done</option>
                        <option value="Closed" <?= ($status ?? '') == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small">Priority</label>
                    <select name="priority" class="form-select form-select-sm">
                        <option value="">Semua Priority</option>
                        <option value="Highest" <?= ($priority ?? '') == 'Highest' ? 'selected' : '' ?>>Highest</option>
                        <option value="High" <?= ($priority ?? '') == 'High' ? 'selected' : '' ?>>High</option>
                        <option value="Medium" <?= ($priority ?? '') == 'Medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="Low" <?= ($priority ?? '') == 'Low' ? 'selected' : '' ?>>Low</option>
                        <option value="Lowest" <?= ($priority ?? '') == 'Lowest' ? 'selected' : '' ?>>Lowest</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label small">Search</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari task..." value="<?= $search ?? '' ?>">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="fas fa-list me-2"></i>Daftar Task</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Task</th>
                            <th>Project</th>
                            <th>Priority</th>
                            <th>Status</th>
                            <th>Due Date</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($tasks)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                    <p>Tidak ada task yang diassign</p>
                                    <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-sm btn-primary">
                                        Report Issue
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($tasks as $i => $task): ?>
                                <tr>
                                    <td class="text-center"><?= $i + 1 ?></td>
                                    <td>
                                        <strong><?= $task['title'] ?></strong>
                                        <br>
                                        <small class="text-muted">ID: #<?= $task['id'] ?></small>
                                    </td>
                                    <td><?= $task['project_name'] ?></td>
                                    <td class="priority-<?= strtolower($task['priority']) ?>">
                                        <?= $task['priority'] ?>
                                    </td>
                                    <td>
                                        <span class="task-status 
                                            <?= $task['status'] == 'To Do' ? 'status-todo' : 
                                                ($task['status'] == 'In Progress' ? 'status-progress' : 
                                                ($task['status'] == 'In Review' ? 'status-review' : 'status-done')) ?>">
                                            <?= $task['status'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($task['due_date']): ?>
                                            <i class="far fa-calendar me-1"></i>
                                            <?= date('d M Y', strtotime($task['due_date'])) ?>
                                            <?php if(strtotime($task['due_date']) < time() && $task['status'] != 'Done'): ?>
                                                <span class="badge bg-danger ms-1">Overdue</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('staff/tasks/' . $task['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Detail
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function exportTasks() {
    let status = document.querySelector('[name="status"]').value;
    let priority = document.querySelector('[name="priority"]').value;
    let search = document.querySelector('[name="search"]').value;
    window.location.href = `<?= base_url('staff/tasks/export') ?>?status=${status}&priority=${priority}&search=${search}`;
}
</script>

<?= $this->endSection() ?>