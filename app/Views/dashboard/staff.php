<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .task-card {
        border-left: 4px solid;
        margin-bottom: 10px;
        transition: all 0.3s;
    }
    .task-card:hover {
        transform: translateX(5px);
    }
    .priority-high { border-left-color: #dc3545; }
    .priority-medium { border-left-color: #ffc107; }
    .priority-low { border-left-color: #28a745; }
    .status-todo { background: #f8f9fa; }
    .status-progress { background: #fff3cd; }
    .status-done { background: #d4edda; }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
        <h1 class="h2">
            <i class="fas fa-tachometer-alt me-2 text-primary"></i>
            Dashboard Staff
        </h1>
        <div class="btn-toolbar">
            <div class="btn-group me-2">
                <button class="btn btn-sm btn-outline-secondary" onclick="window.print()">
                    <i class="fas fa-print"></i> Print
                </button>
            </div>
        </div>
    </div>

    <div class="alert alert-primary">
        <i class="fas fa-user-circle me-2"></i>
        Selamat datang, <strong><?= $full_name ?? session()->get('username') ?></strong>!
        <br><small>Berikut ringkasan tugas dan proyek Anda.</small>
    </div>

    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Total Tasks</h6>
                            <h2 class="mb-0"><?= $totalTasks ?? 0 ?></h2>
                        </div>
                        <i class="fas fa-tasks fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-warning text-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">In Progress</h6>
                            <h2 class="mb-0"><?= $inProgressTasks ?? 0 ?></h2>
                        </div>
                        <i class="fas fa-spinner fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">Completed</h6>
                            <h2 class="mb-0"><?= $completedTasks ?? 0 ?></h2>
                        </div>
                        <i class="fas fa-check-circle fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-3">
            <div class="card stat-card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h6 class="card-title">My Projects</h6>
                            <h2 class="mb-0"><?= $totalProjects ?? 0 ?></h2>
                        </div>
                        <i class="fas fa-project-diagram fa-3x opacity-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7">
            <div class="card shadow">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="mb-0"><i class="fas fa-tasks me-2"></i>My Recent Tasks</h6>
                    <a href="<?= base_url('staff/tasks') ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if(empty($recentTasks)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-check-circle fa-3x mb-3"></i>
                                <p>Tidak ada task</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($recentTasks as $task): ?>
                                <a href="<?= base_url('staff/tasks/' . $task['id']) ?>" class="list-group-item list-group-item-action task-card priority-<?= strtolower($task['priority']) ?>">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong><?= $task['title'] ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-project-diagram me-1"></i><?= $task['project_name'] ?>
                                                <i class="fas fa-calendar ms-2 me-1"></i><?= date('d M Y', strtotime($task['due_date'])) ?>
                                            </small>
                                        </div>
                                        <span class="badge <?= $task['status'] == 'Done' ? 'bg-success' : ($task['status'] == 'In Progress' ? 'bg-warning' : 'bg-secondary') ?>">
                                            <?= $task['status'] ?>
                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="mb-0"><i class="fas fa-project-diagram me-2"></i>My Projects</h6>
                    <a href="<?= base_url('staff/projects') ?>" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        <?php if(empty($myProjects)): ?>
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-folder-open fa-3x mb-3"></i>
                                <p>Belum ada proyek</p>
                            </div>
                        <?php else: ?>
                            <?php foreach($myProjects as $project): ?>
                                <a href="<?= base_url('staff/projects/' . $project['id']) ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <strong><?= $project['project_name'] ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar me-1"></i>
                                                <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                                                <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                                            </small>
                                        </div>
                                        <span class="badge <?= $project['status'] == 'completed' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= $project['status'] ?? 'Active' ?>
                                        </span>
                                    </div>
                                    <div class="progress mt-2" style="height: 5px;">
                                        <div class="progress-bar" style="width: <?= $project['progress'] ?? 0 ?>%"></div>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white">
                    <h6 class="mb-0"><i class="fas fa-bolt me-2 text-warning"></i>Quick Actions</h6>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('staff/tasks') ?>" class="btn btn-outline-primary me-2 mb-2">
                        <i class="fas fa-tasks me-2"></i>My Tasks
                    </a>
                    <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-outline-danger me-2 mb-2">
                        <i class="fas fa-exclamation-circle me-2"></i>Report Issue
                    </a>
                    <a href="<?= base_url('staff/projects') ?>" class="btn btn-outline-success me-2 mb-2">
                        <i class="fas fa-project-diagram me-2"></i>My Projects
                    </a>
                    <a href="<?= base_url('staff/issues') ?>" class="btn btn-outline-info me-2 mb-2">
                        <i class="fas fa-list me-2"></i>My Issues
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>