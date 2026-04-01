<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-project-diagram me-2 text-primary"></i>
            <?= $project['project_name'] ?>
        </h1>
        <a href="<?= base_url('staff/projects') ?>" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Project Info</h6>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr><th>Status</th><td><?= $project['status'] ?></td></tr>
                        <tr><th>Start Date</th><td><?= date('d M Y', strtotime($project['start_date'])) ?></td></tr>
                        <tr><th>End Date</th><td><?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : '-' ?></td></tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow mb-4">
                <div class="card-header bg-white d-flex justify-content-between">
                    <h6 class="mb-0">My Tasks in this Project</h6>
                    <a href="<?= base_url('staff/issues/create?project=' . $project['id']) ?>" class="btn btn-sm btn-danger">
                        <i class="fas fa-plus"></i> Report Issue
                    </a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr><th>Task</th><th>Status</th><th>Priority</th><th>Due Date</th><th>Aksi</th></tr>
                            </thead>
                            <tbody>
                                <?php foreach($tasks as $task): ?>
                                    <tr>
                                        <td><?= $task['title'] ?></td>
                                        <td><?= $task['status'] ?></td>
                                        <td><?= $task['priority'] ?></td>
                                        <td><?= date('d M Y', strtotime($task['due_date'])) ?></td>
                                        <td><a href="<?= base_url('staff/tasks/' . $task['id']) ?>" class="btn btn-sm btn-info">Detail</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>