<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header">
        <h5><?= $title ?></h5>
    </div>
    <div class="card-body">
        <form action="/teams/store" method="post">
            <div class="mb-3">
                <label>Project</label>
                <select name="project_id" class="form-control" required>
                    <option value="">-- Pilih Project --</option>
                    <?php foreach($projects as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['project_name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <option value="">-- Pilih Employee --</option>
                    <?php foreach($employees as $e): ?>
                        <option value="<?= $e['id'] ?>">
                            <?= $e['first_name'] ?> <?= $e['last_name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Position</label>
                <select name="position_id" class="form-control" required>
                    <option value="">-- Pilih Position --</option>
                    <?php foreach($positions as $p): ?>
                        <option value="<?= $p['id'] ?>">
                            <?= $p['position_name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>
            <button class="btn btn-primary">Simpan</button>
            <a href="/admin/teams" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>
<?= $this->endSection() ?>