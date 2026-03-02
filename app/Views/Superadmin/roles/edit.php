<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h4>Hak Akses: <?= $role['name'] ?></h4>

<form action="/superadmin/roles/update/<?= $role['id'] ?>" method="post">
<?= csrf_field() ?>

<?php foreach ($permissions as $group => $items): ?>
    <div class="card mb-3">
        <div class="card-header fw-bold text-capitalize">
            <?= str_replace('_', ' ', $group) ?>
        </div>

        <div class="card-body">
            <div class="row">
                <?php foreach ($items as $perm): ?>
                    <?php
                        $parts  = explode('.', $perm['slug']);
                        $action = $parts[1] ?? 'access';
                    ?>
                    <div class="col-md-4">
                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="permissions[]"
                                   value="<?= $perm['id'] ?>"
                                   id="perm<?= $perm['id'] ?>"
                                   <?= in_array($perm['id'], $rolePermissions) ? 'checked' : '' ?>>

                            <label class="form-check-label" for="perm<?= $perm['id'] ?>">
                                <?= ucfirst($action) ?>
                            </label>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<div class="mt-3">
    <button type="submit" class="btn btn-primary">Simpan</button>
    <a href="/superadmin/roles" class="btn btn-secondary">Kembali</a>
</div>
</form>

<?= $this->endSection() ?>