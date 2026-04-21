<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-section {
        background: white;
        border-radius: 12px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .section-title {
        border-bottom: 2px solid #e0e0e0;
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: bold;
        color: #36b9cc;
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-user-plus me-2 text-primary"></i>
            Tambah Karyawan
        </h1>
        <a href="<?= base_url('admin/employees') ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <?php if(session()->getFlashdata('errors')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <ul class="mb-0">
                <?php foreach(session()->getFlashdata('errors') as $error): ?>
                    <li><?= $error ?></li>
                <?php endforeach; ?>
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="<?= base_url('employees/store') ?>" method="post">
        <?= csrf_field() ?>
        
        <!-- Informasi Akun -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-key me-2"></i> Informasi Akun
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username <span class="text-danger">*</span></label>
                    <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required>
                    <small class="text-muted">Minimal 6 karakter</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Konfirmasi Password <span class="text-danger">*</span></label>
                    <input type="password" name="confirm_password" class="form-control" required>
                </div>
            </div>
        </div>

        <!-- Informasi Pribadi -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-user me-2"></i> Informasi Pribadi
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Depan <span class="text-danger">*</span></label>
                    <input type="text" name="first_name" class="form-control" value="<?= old('first_name') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Nama Belakang</label>
                    <input type="text" name="last_name" class="form-control" value="<?= old('last_name') ?>">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telepon</label>
                    <input type="text" name="phone" class="form-control" value="<?= old('phone') ?>">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Alamat</label>
                    <textarea name="address" class="form-control" rows="3"><?= old('address') ?></textarea>
                </div>
            </div>
        </div>

        <!-- Informasi Pekerjaan -->
        <div class="form-section">
            <h5 class="section-title">
                <i class="fas fa-briefcase me-2"></i> Informasi Pekerjaan
            </h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Posisi/Jabatan <span class="text-danger">*</span></label>
                    <select name="position_id" class="form-select" required>
                        <option value="">-- Pilih Posisi --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>" <?= old('position_id') == $pos['id'] ? 'selected' : '' ?>>
                                <?= $pos['position_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Departemen <span class="text-danger">*</span></label>
                    <select name="department_id" class="form-select" required>
                        <option value="">-- Pilih Departemen --</option>
                        <?php foreach($departments as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= old('department_id') == $dept['id'] ? 'selected' : '' ?>>
                                <?= $dept['department_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tanggal Bergabung <span class="text-danger">*</span></label>
                    <input type="date" name="hire_date" class="form-control" value="<?= old('hire_date') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Status Pekerjaan <span class="text-danger">*</span></label>
                    <select name="employment_status" class="form-select" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="permanent" <?= old('employment_status') == 'permanent' ? 'selected' : '' ?>>Permanent</option>
                        <option value="contract" <?= old('employment_status') == 'contract' ? 'selected' : '' ?>>Contract</option>
                        <option value="intern" <?= old('employment_status') == 'intern' ? 'selected' : '' ?>>Intern</option>
                        <option value="freelance" <?= old('employment_status') == 'freelance' ? 'selected' : '' ?>>Freelance</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            <a href="<?= base_url('employees') ?>" class="btn btn-secondary">Batal</a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Simpan
            </button>
        </div>
    </form>
</div>

<?= $this->endSection() ?>