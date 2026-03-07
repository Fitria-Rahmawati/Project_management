<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">Tambah Issue</div>
    <div class="card-body">
        <form action="<?= base_url('admin/issues/store') ?>" method="post">
            <input type="text" name="title" class="form-control mb-3" placeholder="Title">
            <select name="project_id" class="form-control mb-3">
                <?php foreach($projects as $p): ?>
                    <option value="<?= $p['id'] ?>">
                        <?= $p['project_name'] ?>
                    </option>
                    <?php endforeach ?>
                </select>
                <select name="assigned_to" class="form-control mb-3">
                    <?php foreach($employees as $e): ?>
                        <option value="<?= $e['id'] ?>">
                            <?= $e['first_name'] ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </select>
            <select name="priority" class="form-control mb-3">
                <option value="low">Low</option>
                <option value="medium">Medium</option>
                <option value="high">High</option>
            </select>
            <textarea name="description" class="form-control mb-3" placeholder="Description"></textarea>
            <button class="btn btn-success">Simpan</button>
            <a href="<?= base_url('admin/issues') ?>" class="btn btn-secondary">Kembali</a>
        </form>
    </div>
</div>

<?= $this->endSection() ?>