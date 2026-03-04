<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="text-center mt-5">
    <h1 class="text-danger">403</h1>
    <h3>Akses Ditolak</h3>
    <p>Kamu tidak memiliki izin untuk mengakses halaman ini.</p>
    <a href="/dashboard" class="btn btn-primary">Kembali ke Dashboard</a>
</div>

<?= $this->endSection() ?>