<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<h3>Detail Project</h3>
<div class="card">
    <div class="card-body">
        <table class="table">
            <tr>
                <th width="200">Nama Project</th>
                <td><?= $projects['project_name'] ?></td>
            </tr>
            <tr>
                <th>Perusahaan</th>
                <td><?= $projects['company_name'] ?></td>
            </tr>

            <tr>
                <th>Project Manager</th>
                <td><?= $projects['pm_name'] ?></td>
            </tr>
            <tr>
                <th>Tanggal Mulai</th>
                <td><?= $projects['start_date'] ?></td>
            </tr>
        </tr>
        <tr>
            <th>Tanggal Selesai</th>
            <td><?= $projects['end_date'] ?></td>
        </tr>
        <tr>
            <th>Status</th>
            <td><?= $projects['status'] ?></td>
        </tr>
    </tr>
</table>
<a href="<?= base_url('admin/projects') ?>" class="btn btn-secondary">Kembali</a>

</div>
</div>

<?= $this->endSection() ?>