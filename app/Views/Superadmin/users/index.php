<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 20px;
    }
    .badge-role {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
</style>

<div class="container-fluid px-0">
    <!-- Header -->
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-users-cog me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <a href="/superadmin/users/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Tambah User
            </a>
        </div>
    </div>
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <div class="filter-card">
        <form method="get" action="<?= base_url('superadmin/users') ?>">
            <div class="row">
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label">Cari User</label>
                        <input type="text" 
                               name="keyword" 
                               class="form-control" 
                               placeholder="Cari berdasarkan username atau email"
                               value="<?= $keyword ?>">
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="mb-3">
                        <label class="form-label">Tipe Perusahaan</label>
                        <select name="company_type" class="form-select">
                            <option value="">Semua</option>
                            <option value="internal" <?= $companyType == 'internal' ? 'selected' : '' ?>>Internal</option>
                            <option value="client" <?= $companyType == 'client' ? 'selected' : '' ?>>Client</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="mb-3">
                        <label class="form-label">&nbsp;</label>
                        <button type="submit" class="btn btn-primary form-control">
                            <i class="fas fa-filter me-2"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
            <?php if($keyword || $companyType): ?>
                <div class="row mt-2">
                    <div class="col-12">
                        <a href="<?= base_url('superadmin/users') ?>" class="btn btn-sm btn-secondary">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>
    <div class="card shadow">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Perusahaan</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($users)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Tidak ada data user</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($users as $index => $user): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td>
                                        <strong><?= $user['username'] ?></strong>
                                    </td>
                                    <td><?= $user['email'] ?></td>
                                    <td>
                                        <?php 
                                        $roleClass = '';
                                        switch($user['role_name']) {
                                            case 'superadmin':
                                                $roleClass = 'bg-danger';
                                                break;
                                            case 'admin':
                                                $roleClass = 'bg-warning text-dark';
                                                break;
                                            case 'staff':
                                                $roleClass = 'bg-info';
                                                break;
                                            case 'client':
                                                $roleClass = 'bg-success';
                                                break;
                                            default:
                                                $roleClass = 'bg-secondary';
                                        }
                                        ?>
                                        <span class="badge <?= $roleClass ?> p-2">
                                            <?= ucfirst($user['role_name'] ?? 'Unknown') ?>
                                        </span>
                                    </td>
                                    <td><?= $user['company_name'] ?? '-' ?></td>
                                    <td>
                                        <?php if($user['company_type']): ?>
                                            <span class="badge <?= $user['company_type'] == 'internal' ? 'bg-secondary' : 'bg-primary' ?>">
                                                <?= ucfirst($user['company_type']) ?>
                                            </span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $user['is_active'] ? 'bg-success' : 'bg-secondary' ?>">
                                            <?= $user['is_active'] ? 'Aktif' : 'Non-Aktif' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group">
                                            <a href="/superadmin/users/edit/<?= $user['id'] ?>" 
                                               class="btn btn-warning btn-sm" 
                                               title="Edit">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                           
                                            <a href="/superadmin/users/delete/<?= $user['id'] ?>" 
                                               class="btn btn-danger btn-sm" 
                                               onclick="return confirm('Yakin ingin menghapus user ini?')"
                                               title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>