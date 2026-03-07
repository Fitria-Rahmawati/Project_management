<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between">
        <h5><?= $title ?></h5>
        <a href="/admin/teams/create" class="btn btn-primary btn-sm">+ Tambah Team</a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
            <?php endif; ?>
            <table class="table table-bordered table-striped"><thead>
                <tr>
                    <th>No</th>
                    <th>Project</th>
                    <th>Member</th>
                    <th>Position</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($teams as $key => $row): ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td><?= $row['project_name'] ?></td>
                        <td><?= $row['employee_name'] ?></td>
                        <td>
                            <span class="badge bg-info">
                                <?= $row['position_name'] ?>
                            </span>
                        </td>
                        <td>
                            <a href="/admin/teams/<?= $row['id'] ?>" class="btn btn-info btn-sm">Detail</a>
                            <a href="/admin/teams/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="/admin/teams/delete/<?= $row['id'] ?>" class="btn btn-danger btn-sm"onclick="return confirm('Hapus data?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
    <?= $this->endSection() ?>