<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<main class="content">
    <h2>Monitoring Proyek</h2>

    <div class="table-responsive">
        <table id="projectsTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Proyek</th>
                    <th>Perusahaan</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($projects as $project): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $project['project_name'] ?></td>
                    <td><?= $project['company_name'] ?></td>
                    <td><?= $project['status'] ?></td>
                    <td>
                        <a href="<?= base_url('admin/projects/'.$project['id']) ?>">Lihat Detail</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>