<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4><?= $title ?></h4>
        <a href="<?= base_url('admin/issues/create') ?>" class="btn btn-primary btn-sm">Tambah Issue</a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Title</th>
                    <th>Project</th>
                    <th>Assigned</th>
                    <th>Priority</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($issues as $i => $issue): ?>
                    <tr>
                        <td><?= $i+1 ?></td>
                        <td><?= $issue['title'] ?></td>
                        <td><?= $issue['project_name'] ?></td>
                        <td><?= $issue['employee_name'] ?></td>
                        <td><?= $issue['priority'] ?></td>
                        <td><?= $issue['status'] ?></td>
                        <td>
                            <a href="<?= base_url('admin/issues/'.$issue['id']) ?>"class="btn btn-info btn-sm">Detail</a>
                            <a href="<?= base_url('admin/issues/edit/'.$issue['id']) ?>"class="btn btn-warning btn-sm">Edit</a>
                            <a href="<?= base_url('admin/issues/delete/'.$issue['id']) ?>"class="btn btn-danger btn-sm"onclick="return confirm('Hapus issue?')">Delete</a>
                        </td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
</div>

<?= $this->endSection() ?>