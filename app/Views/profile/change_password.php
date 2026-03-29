<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-card {
        background: white;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        max-width: 500px;
        margin: 0 auto;
    }
    .form-label {
        font-weight: 500;
        margin-bottom: 8px;
    }
    .required:after {
        content: " *";
        color: red;
    }
</style>

<div class="container-fluid px-0">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0">
            <i class="fas fa-key me-2 text-primary"></i>
            Ganti Password
        </h4>
        <a href="<?= base_url('profile') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="form-card">
        <form action="<?= base_url('profile/update-password') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label class="form-label required">Password Saat Ini</label>
                <input type="password" name="current_password" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label class="form-label required">Password Baru</label>
                <input type="password" name="new_password" class="form-control" required>
                <small class="text-muted">Minimal 6 karakter</small>
            </div>
            
            <div class="mb-3">
                <label class="form-label required">Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <div class="border-top pt-3 mt-2">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Ganti Password
                </button>
                <a href="<?= base_url('profile') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>