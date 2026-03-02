<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h4 class="mb-3">Manajemen Role & Hak Akses</h4>

<table class="table table-bordered">
    <thead class="table-dark">
        <tr>
            <th>Role</th>
            <th>Permissions</th>
            <th>Aksi</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($roles as $role): ?>
        <tr>
            <td><?= $role['name'] ?></td>
            <td>
                <?php foreach ($role['permissions'] as $perm): ?>
                    <span class="badge bg-primary"><?= $perm['name'] ?></span>
                <?php endforeach; ?>
            </td>
            <td>
                <a href="/superadmin/roles/edit/<?= $role['id'] ?>" class="btn btn-sm btn-warning">
                    Edit
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?= $this->endSection() ?>