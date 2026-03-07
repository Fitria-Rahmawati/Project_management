<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header">
        <h5><?= $title ?></h5>
    </div>
    <div class="card-body">
        <form action="/teams/update/<?= $team['id'] ?>" method="post">
            <div class="mb-3">
                <label>Project</label>
                <select name="project_id" class="form-control" required>
                    <?php foreach($projects as $p): ?>
                        <option value="<?= $p['id'] ?>" 
                        <?= $p['id'] == $team['project_id'] ? 'selected' : '' ?>>
                        <?= $p['project_name'] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </div>
            <div class="mb-3">
                <label>Employee</label>
                <select name="employee_id" class="form-control" required>
                    <?php foreach($employees as $e): ?>
                        <option value="<?= $e['id'] ?>"
                        <?= $e['id'] == $team['employee_id'] ? 'selected' : '' ?>>
                        <?= $e['first_name'] ?>
                        <?= $e['last_name'] ?>
                    </option>
                    <?php endforeach ?>
                </select>
            </div>
        </select>
    </div>
    <div class="mb-3">
        <label>Position</label>
        <select name="position_id" class="form-control" required>
            <?php foreach($positions as $pos): ?>
                <option value="<?= $pos['id'] ?>"
                <?= $pos['id'] == $team['position_id'] ? 'selected' : '' ?>>
                <?= $pos['position_name'] ?>
            </option>
            <?php endforeach ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Update</button>
    <a href="/admin/teams" class="btn btn-secondary">Kembali</a>
</form>
</div>
</div>

<?= $this->endSection() ?>