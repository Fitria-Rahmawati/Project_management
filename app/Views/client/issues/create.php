<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-section {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
</style>

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-plus-circle me-2 text-danger"></i>
            Lapor Kendala Baru
        </h1>
        <a href="<?= base_url('client/issues') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->get('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                <?php foreach(session()->get('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="form-section">
        <form action="<?= base_url('client/issues/store') ?>" method="post">
            <?= csrf_field() ?>
            
            <div class="mb-3">
                <label for="project_id" class="form-label fw-bold">
                    <i class="fas fa-folder me-1 text-primary"></i> Proyek <span class="text-danger">*</span>
                </label>
                <select name="project_id" id="project_id" class="form-select" required>
                    <option value="">-- Pilih Proyek --</option>
                    <?php foreach($projects as $project): ?>
                        <option value="<?= $project['id'] ?>" <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
                            <?= esc($project['project_name']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="title" class="form-label fw-bold">
                    <i class="fas fa-heading me-1 text-primary"></i> Judul Kendala <span class="text-danger">*</span>
                </label>
                <input type="text" name="title" id="title" class="form-control" 
                       value="<?= old('title') ?>" required>
                <small class="text-muted">Contoh: Bug pada halaman login, atau kendala akses fitur X</small>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label fw-bold">
                    <i class="fas fa-align-left me-1 text-primary"></i> Deskripsi <span class="text-danger">*</span>
                </label>
                <textarea name="description" id="description" rows="5" class="form-control" required><?= old('description') ?></textarea>
                <small class="text-muted">Jelaskan kendala yang Anda alami secara detail</small>
            </div>

            <div class="mb-4">
                <label for="priority" class="form-label fw-bold">
                    <i class="fas fa-flag me-1 text-primary"></i> Prioritas <span class="text-danger">*</span>
                </label>
                <select name="priority" id="priority" class="form-select" required>
                    <option value="">-- Pilih Prioritas --</option>
                    <option value="low" <?= old('priority') == 'low' ? 'selected' : '' ?>>🟢 Rendah</option>
                    <option value="medium" <?= old('priority') == 'medium' ? 'selected' : '' ?>>🟡 Sedang</option>
                    <option value="high" <?= old('priority') == 'high' ? 'selected' : '' ?>>🔴 Tinggi</option>
                </select>
            </div>

            <div class="d-flex justify-content-end gap-2">
                <a href="<?= base_url('client/issues') ?>" class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Batal
                </a>
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-paper-plane me-1"></i> Kirim Laporan
                </button>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>