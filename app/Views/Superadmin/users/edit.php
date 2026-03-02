<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="container-fluid">
    <h4 class="mb-4">Edit User</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('superadmin/users/update/'.$user['id']) ?>" method="post">
                <?= csrf_field() ?>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" name="username"
                               value="<?= esc($user['username']) ?>"
                               class="form-control" required>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Email</label>
                        <input type="email" name="email"
                               value="<?= esc($user['email']) ?>"
                               class="form-control" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">
                            Password <small class="text-muted">(kosongkan jika tidak diubah)</small>
                        </label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Role</label>
                        <select name="role_id" class="form-select" required>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role['id'] ?>"
                                    <?= $role['id'] == $user['role_id'] ? 'selected' : '' ?>>
                                    <?= esc($role['name']) ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </div>

                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Company</label>
                        <select name="company_id" class="form-select">
                            <option value="">-- Tanpa Company --</option>
                            <?php foreach ($companies as $company): ?>
                                <option value="<?= $company['id'] ?>"
                                    <?= $company['id'] == $user['company_id'] ? 'selected' : '' ?>>
                                    <?= esc($company['company_name']) ?>
                                    (<?= ucfirst($company['company_type']) ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label class="form-label">Status</label>
                        <select name="is_active" class="form-select">
                            <option value="1" <?= $user['is_active'] ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= !$user['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="<?= base_url('superadmin/users') ?>" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" class="btn btn-primary">
                        Update User
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>