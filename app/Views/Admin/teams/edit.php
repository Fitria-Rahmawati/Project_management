<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-edit me-2 text-warning"></i>
            <?= $title ?>
        </h5>
        <div>
            <a href="/admin/teams/<?= $team['id'] ?>" class="btn btn-info btn-sm me-2">
                <i class="fas fa-eye me-2"></i>Detail
            </a>
            <a href="/admin/teams" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <form action="/admin/teams/update/<?= $team['id'] ?>" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-12 mb-4">
                    <div class="card bg-light border-primary">
                        <div class="card-body">
                            <h6 class="card-title text-primary">
                                <i class="fas fa-info-circle me-2"></i>Current Member Information
                            </h6>
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-2" 
                                         style="width: 80px; height: 80px; font-size: 32px; background: linear-gradient(135deg, #667eea, #764ba2);">
                                        <?= strtoupper(substr($team['member_name'] ?? $team['username'], 0, 1)) ?>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <table class="table table-sm table-borderless">
                                        <tr>
                                            <th width="150">Username</th>
                                            <td>: <strong><?= $team['username'] ?></strong></td>
                                        </tr>
                                        <tr>
                                            <th>Email</th>
                                            <td>: <?= $team['email'] ?></td>
                                        </tr>
                                        <tr>
                                            <th>Role System</th>
                                            <td>: 
                                                <span class="badge bg-info"><?= ucfirst($team['role_name'] ?? '') ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Role in Project</th>
                                            <td>: 
                                                <?php 
                                                $roleClass = '';
                                                if($team['role_in_project'] == 'project_manager') $roleClass = 'bg-warning text-dark';
                                                elseif($team['role_in_project'] == 'staff') $roleClass = 'bg-info';
                                                else $roleClass = 'bg-success';
                                                ?>
                                                <span class="badge <?= $roleClass ?>">
                                                    <?= str_replace('_', ' ', ucfirst($team['role_in_project'])) ?>
                                                </span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="project_id" class="form-label">
                        <i class="fas fa-project-diagram me-2 text-primary"></i>Project *
                    </label>
                    <select name="project_id" id="project_id" class="form-select <?= ($validation->hasError('project_id')) ? 'is-invalid' : '' ?>" required>
                        <option value="">-- Pilih Project --</option>
                        <?php foreach($projects as $project): ?>
                            <option value="<?= $project['id'] ?>" 
                                <?= ($project['id'] == $team['project_id']) ? 'selected' : '' ?>>
                                <?= $project['project_name'] ?> 
                                (<?= $project['project_type'] == 'internal' ? 'Internal' : 'Client' ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if($validation->hasError('project_id')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('project_id') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="user_id" class="form-label">
                        <i class="fas fa-user me-2 text-primary"></i>Member *
                    </label>
                    <input type="text" class="form-control" value="<?= $team['username'] ?> (<?= ucfirst($team['role_name'] ?? '') ?>)" readonly>
                    <input type="hidden" name="user_id" value="<?= $team['user_id'] ?>">
                    <small class="text-muted">User tidak dapat diubah, silakan hapus dan tambah baru jika perlu</small>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="role_in_project" class="form-label">
                        <i class="fas fa-tag me-2 text-primary"></i>Role dalam Project *
                    </label>
                    <select name="role_in_project" id="role_in_project" class="form-select <?= ($validation->hasError('role_in_project')) ? 'is-invalid' : '' ?>" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="project_manager" <?= ($team['role_in_project'] == 'project_manager') ? 'selected' : '' ?>>
                            <i class="fas fa-user-tie"></i> Project Manager
                        </option>
                        <option value="staff" <?= ($team['role_in_project'] == 'staff') ? 'selected' : '' ?>>
                            <i class="fas fa-user-cog"></i> Staff
                        </option>
                        <option value="client" <?= ($team['role_in_project'] == 'client') ? 'selected' : '' ?>>
                            <i class="fas fa-building"></i> Client
                        </option>
                    </select>
                    <?php if($validation->hasError('role_in_project')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('role_in_project') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3" id="positionField" style="<?= ($team['role_in_project'] == 'staff') ? 'display: block;' : 'display: none;' ?>">
                    <label for="position_id" class="form-label">
                        <i class="fas fa-briefcase me-2 text-primary"></i>Posisi (Staff)
                    </label>
                    <select name="position_id" id="position_id" class="form-select">
                        <option value="">-- Pilih Posisi --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>" 
                                <?= ($pos['id'] == ($team['position_id'] ?? '')) ? 'selected' : '' ?>>
                                <?= $pos['position_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Mengubah role dapat mempengaruhi akses member ini dalam project.
                        <?php if($team['role_in_project'] == 'project_manager'): ?>
                        <br>Member ini adalah <strong>Project Manager</strong>. Pastikan ada PM lain sebelum mengubah role.
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <hr>
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/teams" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    <i class="fas fa-save me-2"></i>Update Team Member
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_in_project');
    const positionField = document.getElementById('positionField');
    const positionSelect = document.getElementById('position_id');
    roleSelect.addEventListener('change', function() {
        if (this.value === 'staff') {
            positionField.style.display = 'block';
            positionSelect.required = true;
        } else {
            positionField.style.display = 'none';
            positionSelect.required = false;
        }
    });
});
</script>

<?= $this->endSection() ?>