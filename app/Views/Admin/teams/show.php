<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5><?= $title ?></h5>
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <td>Project</td>
                <td>: <?= $team['project_name'] ?></td>
            </tr>
            <tr>
                <td>Member</td>
                <td>: <?= $team['employee_name'] ?></td>
            </tr>
            <tr>
                <td>Position</td>
                <td>: <?= $team['position_name'] ?></td>
            </tr>
        </table>
        <a href="/admin/teams" class="btn btn-secondary">Kembali</a>
    </div>
</div>
</div>

<?= $this->endSection() ?>