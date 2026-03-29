<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .profile-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
    }
    .avatar-placeholder {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: rgba(255,255,255,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        border: 4px solid white;
    }
    .info-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .info-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 16px;
        font-weight: 500;
        color: #333;
    }
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    @media (max-width: 768px) {
        .profile-header {
            text-align: center;
        }
        .action-buttons {
            justify-content: center;
            margin-top: 20px;
        }
    }
</style>

<div class="container-fluid px-0">
  
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="profile-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="d-flex align-items-center flex-wrap">
                    <div class="me-4">
                        <div class="avatar-placeholder">
                            <i class="fas fa-user-circle"></i>
                        </div>
                    </div>
                    <div>
                        <h2 class="mb-1"><?= $user['first_name'] ?? $user['username'] ?> <?= $user['last_name'] ?? '' ?></h2>
                        <p class="mb-2">
                            <i class="fas fa-envelope me-2"></i> <?= $user['email'] ?>
                            <br>
                            <i class="fas fa-briefcase me-2"></i> <?= $user['position_name'] ?? 'Staff' ?>
                            <span class="mx-2">|</span>
                            <i class="fas fa-building me-2"></i> <?= $user['department_name'] ?? '-' ?>
                        </p>
                        <span class="badge bg-light text-dark">
                            <i class="fas fa-user-tag me-1"></i> <?= $user['role_name'] ?? 'User' ?>
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="action-buttons justify-content-md-end">
                    <a href="<?= base_url('profile/edit') ?>" class="btn btn-light">
                        <i class="fas fa-edit me-2"></i>Edit Profile
                    </a>
                    <a href="<?= base_url('profile/change-password') ?>" class="btn btn-outline-light">
                        <i class="fas fa-key me-2"></i>Change Password
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3">
                    <i class="fas fa-user me-2 text-primary"></i>
                    Informasi Pribadi
                </h5>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Nama Depan</div>
                        <div class="info-value"><?= $user['first_name'] ?? '-' ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Nama Belakang</div>
                        <div class="info-value"><?= $user['last_name'] ?? '-' ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Email</div>
                        <div class="info-value"><?= $user['email'] ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Telepon</div>
                        <div class="info-value"><?= $user['phone'] ?? '-' ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="info-card">
                <h5 class="mb-3">
                    <i class="fas fa-briefcase me-2 text-primary"></i>
                    Informasi Pekerjaan
                </h5>
                <div class="row">
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Username</div>
                        <div class="info-value"><?= $user['username'] ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Role</div>
                        <div class="info-value"><?= $user['role_name'] ?? '-' ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Posisi</div>
                        <div class="info-value"><?= $user['position_name'] ?? '-' ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Departemen</div>
                        <div class="info-value"><?= $user['department_name'] ?? '-' ?></div>
                    </div>
                    <div class="col-sm-6 mb-3">
                        <div class="info-label">Tanggal Bergabung</div>
                        <div class="info-value"><?= date('d F Y', strtotime($user['created_at'])) ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>