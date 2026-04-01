<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-project-diagram me-2 text-primary"></i>
            My Projects
        </h1>
    </div>

    <div class="row">
        <?php if(empty($projects)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada proyek</p>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($projects as $project): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card shadow h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= $project['project_name'] ?></h5>
                            <p class="card-text small text-muted">
                                <i class="fas fa-calendar me-1"></i>
                                <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                                <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                            </p>
                            <div class="mb-2">
                                <small class="text-muted">Progress</small>
                                <div class="progress" style="height: 5px;">
                                    <div class="progress-bar" style="width: <?= $project['progress'] ?? 0 ?>%"></div>
                                </div>
                                <small><?= $project['progress'] ?? 0 ?>%</small>
                            </div>
                            <a href="<?= base_url('staff/projects/' . $project['id']) ?>" class="btn btn-sm btn-primary mt-2">
                                <i class="fas fa-eye"></i> Detail
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>