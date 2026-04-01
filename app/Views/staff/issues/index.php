<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-list me-2 text-primary"></i>
            My Issues
        </h1>
        <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-danger btn-sm">
            <i class="fas fa-plus me-2"></i>Report New Issue
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white">
            <h6 class="mb-0">Issues yang Anda laporkan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Type</th>
                            <th>Project</th>
                            <th>Status</th>
                            <th>Priority</th>
                            <th>Created</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($issues)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3"></i>
                                    <p>Belum ada issue yang dilaporkan</p>
                                    <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-sm btn-primary">Report Issue</a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($issues as $issue): ?>
                                <tr>
                                    <td>#<?= $issue['id'] ?></td>
                                    <td><?= $issue['title'] ?></td>
                                    <td><?= ucfirst($issue['issue_type']) ?></td>
                                    <td><?= $issue['project_name'] ?></td>
                                    <td>
                                        <span class="badge <?= $issue['status'] == 'Done' ? 'bg-success' : 'bg-warning' ?>">
                                            <?= $issue['status'] ?>
                                        </span>
                                    </td>
                                    <td><?= $issue['priority'] ?></td>
                                    <td><?= date('d/m/Y', strtotime($issue['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('staff/issues/' . $issue['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
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

<?= $this->endSection() ?>