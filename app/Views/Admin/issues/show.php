<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Detail Issue</div>
    <div class="card-body">
        <h4><?= $issue['title'] ?></h4>
        <p><b>Project :</b> <?= $issue['project_name'] ?></p>
        <p><b>Assigned :</b> <?= $issue['employee_name'] ?></p>
        <p><b>Priority :</b> <?= $issue['priority'] ?></p>
        <p><b>Status :</b> <?= $issue['status'] ?></p>
        <p><?= $issue['description'] ?></p>
        <a href="<?= base_url('admin/issues') ?>" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<?= $this->endSection() ?>