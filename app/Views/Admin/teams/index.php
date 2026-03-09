<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-users-cog me-2"></i>
            <?= $title ?>
        </h5>
        <a href="/admin/teams/create" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i> Tambah Team
        </a>
    </div>
    <div class="card-body">
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>
                <?= session()->getFlashdata('error') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover">
                <thead class="table-primary">
                    <tr>
                        <th width="50">No</th>
                        <th>Project</th>
                        <th>Member</th>
                        <th>Role in Project</th>
                        <th>Position/Company</th>
                        <th width="200">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($teams)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-users-slash fa-3x text-muted mb-3"></i>
                                <p class="text-muted">Belum ada data team</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach($teams as $key => $row): ?>
                            <tr>
                                <td><?= $key+1 ?></td>
                                <td>
                                    <strong><?= $row['project_name'] ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <?= $row['project_type'] == 'internal' ? '🏢 Internal' : '🤝 Client' ?>
                                    </small>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2" 
                                             style="width: 35px; height: 35px; background: linear-gradient(135deg, #667eea, #764ba2);">
                                            <?= strtoupper(substr($row['member_name'] ?? $row['username'], 0, 1)) ?>
                                        </div>
                                        <div>
                                            <strong><?= $row['member_name'] ?? $row['username'] ?></strong>
                                            <br>
                                            <small class="text-muted"><?= $row['email'] ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <?php 
                                    $roleClass = '';
                                    $roleIcon = '';
                                    if($row['role_in_project'] == 'project_manager'):
                                        $roleClass = 'bg-warning text-dark';
                                        $roleIcon = 'fa-user-tie';
                                    elseif($row['role_in_project'] == 'staff'):
                                        $roleClass = 'bg-info';
                                        $roleIcon = 'fa-user-cog';
                                    elseif($row['role_in_project'] == 'client'):
                                        $roleClass = 'bg-success';
                                        $roleIcon = 'fa-building';
                                    endif;
                                    ?>
                                    <span class="badge <?= $roleClass ?>">
                                        <i class="fas <?= $roleIcon ?> me-1"></i>
                                        <?= str_replace('_', ' ', ucfirst($row['role_in_project'])) ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if($row['role_in_project'] == 'staff'): ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-briefcase me-1"></i>
                                            <?= $row['position_name'] ?? '-' ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-building me-1"></i>
                                            <?= $row['department_name'] ?? '-' ?>
                                        </small>
                                    <?php elseif($row['role_in_project'] == 'client'): ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-building me-1"></i>
                                            <?= $row['company_name'] ?? '-' ?>
                                        </span>
                                        <br>
                                        <small class="text-muted">
                                            <i class="fas fa-user-tie me-1"></i>
                                            <?= $row['contact_person'] ?? '-' ?>
                                        </small>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">
                                            <i class="fas fa-user-tie me-1"></i>
                                            Project Manager
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="/admin/teams/<?= $row['id'] ?>" class="btn btn-info btn-sm" title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="/admin/teams/edit/<?= $row['id'] ?>" class="btn btn-warning btn-sm" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="/admin/teams/delete/<?= $row['id'] ?>" class="btn btn-danger btn-sm" 
                                           onclick="return confirm('Yakin ingin menghapus member ini dari project?')" title="Hapus">
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
        <div class="row mt-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body">
                        <h6>Total Teams</h6>
                        <h4><?= count($teams) ?></h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body">
                        <h6>Project Managers</h6>
                        <h4>
                            <?= array_reduce($teams, function($carry, $item) {
                                return $carry + ($item['role_in_project'] == 'project_manager' ? 1 : 0);
                            }, 0) ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body">
                        <h6>Staff</h6>
                        <h4>
                            <?= array_reduce($teams, function($carry, $item) {
                                return $carry + ($item['role_in_project'] == 'staff' ? 1 : 0);
                            }, 0) ?>
                        </h4>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body">
                        <h6>Clients</h6>
                        <h4>
                            <?= array_reduce($teams, function($carry, $item) {
                                return $carry + ($item['role_in_project'] == 'client' ? 1 : 0);
                            }, 0) ?>
                        </h4>
                    </div>
                </div>
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