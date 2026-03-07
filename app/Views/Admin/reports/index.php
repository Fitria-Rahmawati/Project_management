<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h4>Laporan Sistem</h4>
</div>
<div class="card-body">
    <form action="<?= base_url('admin/reports/generate') ?>" method="get">
        <div class="mb-3">
            <label>Jenis Laporan</label>
            <select name="type" class="form-control">
                <option value="projects">Laporan Project</option>
                <option value="issues">Laporan Issues</option>
                <option value="teams">Laporan Tim Project</option>
            </select>
        </div>
        <button class="btn btn-primary">Generate Laporan</button>
    </form>
</div>

</div>

<?= $this->endSection() ?>