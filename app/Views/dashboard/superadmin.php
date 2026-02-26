<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<p>Selamat datang, <strong><?= session('role') ?></strong></p>

<h3>Dashboard Superadmin</h3>

<div class="grid">
    <div class="card">
        <h4>Total Perusahaan</h4>
        <p><?= 12 ?></p>
    </div>

    <div class="card">
        <h4>Total User</h4>
        <p><?= 100 ?></p>
    </div>

    <div class="card">
        <h4>Total Proyek</h4>
        <p><?= 50 ?></p>
    </div>

    <div class="card">
        <h4>Status Sistem</h4>
        <p>Normal</p>
    </div>
</div>

<p style="margin-top:20px">
    Superadmin memiliki akses penuh untuk monitoring data, pengelolaan user, dan pengaturan sistem.
</p>

<?= $this->endSection() ?>