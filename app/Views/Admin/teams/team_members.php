<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h5><?= $title ?></h5>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Name</th>
                    <th>Position</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($members as $key=>$m): ?>
                    <tr>
                        <td><?= $key+1 ?></td>
                        <td><?= $m['first_name'] ?></td>
                        <td><?= $m['name'] ?></td>
                    </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
<?= $this->endSection() ?>