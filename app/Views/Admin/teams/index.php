<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .team-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
        margin-bottom: 20px;
    }
    .team-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .team-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 600;
        margin-right: 15px;
    }
    .team-info {
        flex: 1;
    }
    .team-name {
        font-size: 16px;
        font-weight: 600;
        color: #333;
        margin-bottom: 5px;
    }
    .team-role {
        font-size: 12px;
        color: #667eea;
        background: #f0f3ff;
        padding: 3px 10px;
        border-radius: 15px;
        display: inline-block;
    }
    .stat-label {
        font-size: 11px;
        color: #888;
        margin-bottom: 5px;
    }
    .stat-value {
        font-size: 18px;
        font-weight: 600;
        color: #333;
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .summary-card {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .filter-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
        padding: 20px;
    }
    .table-team {
        font-size: 14px;
    }
</style>

<div class="container-fluid px-0">

    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-users-cog me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <a href="/admin/teams/create" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i> Tambah Team
            </a>
        </div>
    </div>

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

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="summary-card">
                <h6 class="mb-0">Total Teams</h6>
                <h3 class="mt-2 mb-0"><?= count($teams) ?></h3>
                <small>Seluruh anggota tim</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #28a745, #20c997);">
                <h6 class="mb-0">Project Managers</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_reduce($teams, function($carry, $item) {
                        return $carry + ($item['role_in_project'] == 'project_manager' ? 1 : 0);
                    }, 0) ?>
                </h3>
                <small>Manager proyek</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #17a2b8, #0d6efd);">
                <h6 class="mb-0">Staff</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_reduce($teams, function($carry, $item) {
                        return $carry + ($item['role_in_project'] == 'staff' ? 1 : 0);
                    }, 0) ?>
                </h3>
                <small>Anggota tim</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="summary-card" style="background: linear-gradient(135deg, #fd7e14, #dc3545);">
                <h6 class="mb-0">Clients</h6>
                <h3 class="mt-2 mb-0">
                    <?= array_reduce($teams, function($carry, $item) {
                        return $carry + ($item['role_in_project'] == 'client' ? 1 : 0);
                    }, 0) ?>
                </h3>
                <small>Perusahaan klien</small>
            </div>
        </div>
    </div>

    <div class="row">
        <?php if(empty($teams)): ?>
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada data team</p>
                    <a href="/admin/teams/create" class="btn btn-primary btn-sm">
                        <i class="fas fa-plus me-2"></i>Tambah Team
                    </a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach($teams as $row): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card team-card">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="team-avatar">
                                    <?= strtoupper(substr($row['member_name'] ?? $row['username'], 0, 1)) ?>
                                </div>
                                <div class="team-info">
                                    <div class="team-name">
                                        <?= $row['member_name'] ?? $row['username'] ?>
                                    </div>
                                    <div class="team-role"><?= $row['role_in_project'] == 'project_manager' ? 'Project Manager' : ($row['role_in_project'] == 'staff' ? 'Staff' : 'Client') ?></div>
                                    <small class="text-muted d-block mt-1"><?= $row['email'] ?></small>
                                </div>
                            </div>

                            <div class="mb-2">
                                <small class="text-muted d-block">
                                    <i class="fas fa-project-diagram me-2"></i>
                                    <strong><?= $row['project_name'] ?></strong>
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-tag me-2"></i>
                                    <?= $row['project_type'] == 'internal' ? 'Internal' : 'Client' ?>
                                </small>
                            </div>

                            <div class="mt-2">
                                <?php if($row['role_in_project'] == 'staff'): ?>
                                    <span class="badge-status bg-secondary">
                                        <i class="fas fa-briefcase me-1"></i>
                                        <?= $row['position_name'] ?? '-' ?>
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-building me-1"></i>
                                        <?= $row['department_name'] ?? '-' ?>
                                    </small>
                                <?php elseif($row['role_in_project'] == 'client'): ?>
                                    <span class="badge-status bg-secondary">
                                        <i class="fas fa-building me-1"></i>
                                        <?= $row['company_name'] ?? '-' ?>
                                    </span>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-user-tie me-1"></i>
                                        <?= $row['contact_person'] ?? '-' ?>
                                    </small>
                                <?php else: ?>
                                    <span class="badge-status bg-secondary">
                                        <i class="fas fa-user-tie me-1"></i>
                                        Project Manager
                                    </span>
                                <?php endif; ?>
                            </div>

                            <div class="d-flex justify-content-between mt-3 pt-2 border-top">
                                <a href="/admin/teams/<?= $row['id'] ?>" class="btn btn-sm btn-info" title="Detail">
                                    <i class="fas fa-eye"></i> Detail
                                </a>
                                <a href="/admin/teams/edit/<?= $row['id'] ?>" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </a>
                                <a href="/admin/teams/delete/<?= $row['id'] ?>" class="btn btn-sm btn-danger" 
                                   onclick="return confirm('Yakin ingin menghapus member ini dari project?')" title="Hapus">
                                    <i class="fas fa-trash"></i> Hapus
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <div class="card shadow mt-4">
        <div class="card-header">
            <h6 class="mb-0"><i class="fas fa-table me-2"></i>Detail Anggota Tim</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-team">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Project</th>
                            <th>Member</th>
                            <th>Role in Project</th>
                            <th>Position/Company</th>
                            <th>Aksi</th>
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
                                    <td class="text-center"><?= $key+1 ?></td>
                                    <td>
                                        <strong><?= $row['project_name'] ?></strong>
                                        <br>
                                        <small class="text-muted">
                                            <?= $row['project_type'] == 'internal' ? '🏢 Internal' : '🤝 Client' ?>
                                        </small>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
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