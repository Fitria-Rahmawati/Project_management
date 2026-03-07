<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h3><?= $title ?></h3>
<div class="row">
    <div class="col-md-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5>Total Project</h5>
                <h2><?= $projects ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <h5>Total Issues</h5>
                <h2><?= $issues ?></h2>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <h5>Total Users</h5>
                <h2><?= $users ?></h2>
            </div>
        </div>
    </div>
</div>
<br>
<h5>Total Users</h5>
<h2><?= $users ?></h2>
</div>
</div>
</div>

</div>

<br>

<h4>Status Issues</h4>
<table class="table table-bordered">
    <tr>
        <th>Open</th>
        <th>Progress</th>
        <th>Closed</th>
    </tr>
    <tr>
        <td><?= $open ?></td>
        <td><?= $progress ?></td>
        <td><?= $closed ?></td>
    </tr>
</table>

<?= $this->endSection() ?>