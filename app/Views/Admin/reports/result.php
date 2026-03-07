<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header d-flex justify-content-between">
        <h4><?= $title ?></h4>
        <button onclick="window.print()" class="btn btn-success btn-sm">Print</button>
        <a href="<?= base_url('admin/reports') ?>" class="btn btn-secondary btn-sm">Kembali</a>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <?php foreach(array_keys($reports[0]) as $col): ?>
                        <th><?= $col ?></th>
                        <?php endforeach ?>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($reports as $row): ?>
                        <tr>
                            <?php foreach($row as $value): ?>
                                <td><?= $value ?></td>
                                <?php endforeach ?>
                            </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>

<?= $this->endSection() ?>