<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-user-plus me-2"></i>
            <?= $title ?>
        </h5>
        <a href="/admin/teams" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>
        <form action="/admin/teams/store" method="post">
            <?= csrf_field() ?>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="project_id" class="form-label">
                        <i class="fas fa-project-diagram me-2 text-primary"></i>Project *
                    </label>
                    <select name="project_id" id="project_id" class="form-select <?= ($validation->hasError('project_id')) ? 'is-invalid' : '' ?>" required>
                        <option value="">-- Pilih Project --</option>
                        <?php foreach($projects as $project): ?>
                            <option value="<?= $project['id'] ?>" <?= old('project_id') == $project['id'] ? 'selected' : '' ?>>
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
                    <select name="user_id" id="user_id" class="form-select <?= ($validation->hasError('user_id')) ? 'is-invalid' : '' ?>" required>
                        <option value="">-- Pilih User --</option>
                        <?php foreach($users as $user): ?>
                            <option value="<?= $user['id'] ?>" 
                                    data-role="<?= $user['role_name'] ?>"
                                    <?= old('user_id') == $user['id'] ? 'selected' : '' ?>>
                                <?= $user['username'] ?> 
                                (<?= ucfirst($user['role_name']) ?>)
                                <?php if($user['role_name'] == 'client'): ?>
                                    - <?= $user['email'] ?>
                                <?php endif; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if($validation->hasError('user_id')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('user_id') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="role_in_project" class="form-label">
                        <i class="fas fa-tag me-2 text-primary"></i>Role dalam Project *
                    </label>
                    <select name="role_in_project" id="role_in_project" class="form-select <?= ($validation->hasError('role_in_project')) ? 'is-invalid' : '' ?>" required>
                        <option value="">-- Pilih Role --</option>
                        <option value="project_manager" <?= old('role_in_project') == 'project_manager' ? 'selected' : '' ?>>
                            <i class="fas fa-user-tie"></i> Project Manager
                        </option>
                        <option value="staff" <?= old('role_in_project') == 'staff' ? 'selected' : '' ?>>
                            <i class="fas fa-user-cog"></i> Staff
                        </option>
                        <option value="client" <?= old('role_in_project') == 'client' ? 'selected' : '' ?>>
                            <i class="fas fa-building"></i> Client
                        </option>
                    </select>
                    <?php if($validation->hasError('role_in_project')): ?>
                        <div class="invalid-feedback">
                            <?= $validation->getError('role_in_project') ?>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-md-6 mb-3" id="positionField" style="display: none;">
                    <label for="position_id" class="form-label">
                        <i class="fas fa-briefcase me-2 text-primary"></i>Posisi (Staff)
                    </label>
                    <select name="position_id" id="position_id" class="form-select">
                        <option value="">-- Pilih Posisi --</option>
                        <?php foreach($positions as $pos): ?>
                            <option value="<?= $pos['id'] ?>" <?= old('position_id') == $pos['id'] ? 'selected' : '' ?>>
                                <?= $pos['position_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        <strong>Informasi:</strong><br>
                        - <strong>Project Manager:</strong> Memimpin project, bisa assign task<br>
                        - <strong>Staff:</strong> Mengerjakan task, update progress<br>
                        - <strong>Client:</strong> Melihat progress, report issue
                    </div>
                </div>
            </div>

            <hr>
            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="card bg-light">
                        <div class="card-body">
                            <h6 class="card-title">
                                <i class="fas fa-eye me-2"></i>Preview Member Info
                            </h6>
                            <div id="previewInfo" class="text-muted">
                                Pilih project dan member untuk melihat info
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-end gap-2">
                <a href="/admin/teams" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>Simpan Team Member
                </button>
            </div>
        </form>
    </div>
</div>

<!-- JavaScript untuk Dynamic Fields -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.getElementById('role_in_project');
    const positionField = document.getElementById('positionField');
    const userSelect = document.getElementById('user_id');
    const projectSelect = document.getElementById('project_id');
    const previewInfo = document.getElementById('previewInfo');

    roleSelect.addEventListener('change', function() {
        if (this.value === 'staff') {
            positionField.style.display = 'block';
        } else {
            positionField.style.display = 'none';
        }
        updatePreview();
    });
    userSelect.addEventListener('change', updatePreview);
    projectSelect.addEventListener('change', updatePreview);
    roleSelect.addEventListener('change', updatePreview);

    function updatePreview() {
        const projectId = projectSelect.value;
        const userId = userSelect.value;
        const role = roleSelect.value;
        
        if (!projectId || !userId || !role) {
            previewInfo.innerHTML = '<span class="text-muted">Pilih project dan member untuk melihat info</span>';
            return;
        }
        const projectText = projectSelect.options[projectSelect.selectedIndex]?.text || '';
        const userOption = userSelect.options[userSelect.selectedIndex];
        const userName = userOption?.text.split('(')[0] || '';
        const userRole = userOption?.dataset.role || '';

        let roleText = '';
        if (role === 'project_manager') roleText = 'Project Manager';
        else if (role === 'staff') roleText = 'Staff';
        else roleText = 'Client';

        let previewHtml = `
            <div class="row">
                <div class="col-md-6">
                    <strong>Project:</strong> ${projectText}<br>
                    <strong>Member:</strong> ${userName}
                </div>
                <div class="col-md-6">
                    <strong>Role Member:</strong> ${userRole}<br>
                    <strong>Role in Project:</strong> ${roleText}
                </div>
            </div>
        `;
        if ((role === 'client' && userRole !== 'client') || 
            (role === 'staff' && userRole !== 'staff' && userRole !== 'admin') ||
            (role === 'project_manager' && userRole !== 'admin' && userRole !== 'superadmin')) {
            previewHtml += `
                <div class="alert alert-warning mt-2 mb-0">
                    <i class="fas fa-exclamation-triangle"></i>
                    Perhatian: User dengan role "${userRole}" dipilih sebagai "${roleText}". 
                    Pastikan ini sesuai.
                </div>
            `;
        }

        previewInfo.innerHTML = previewHtml;
    }
    if (roleSelect.value) {
        roleSelect.dispatchEvent(new Event('change'));
    }
});
</script>

<?= $this->endSection() ?>