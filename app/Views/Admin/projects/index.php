<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5><?= $title ?></h5>
        <a href="/admin/projects/create" class="btn btn-primary btn-sm">
            + Tambah Project
        </a>
    </div>

    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif; ?>

        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Project</th>
                    <th>Company</th>
                    <th>Project Manager</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($projects as $key => $row): ?>
                <tr>
                    <td><?= $key+1 ?></td>
                    <td><?= $row['project_name'] ?></td>
                    <td><?= $row['company_name'] ?></td>
                    <td><?= $row['pm_name'] ?></td>
                    <td>
                        <span class="badge bg-info">
                            <?= $row['status'] ?>
                        </span>
                    </td>
                    <td>
                        <a href="/admin/projects/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="/admin/projects/delete/<?= $row['id'] ?>" class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus?')">Hapus</a>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
</div>

<?= $this->endSection() ?>