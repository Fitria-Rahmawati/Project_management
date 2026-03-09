<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-eye me-2 text-info"></i>
            <?= $title ?>
        </h5>
        <div>
            <a href="/admin/teams/edit/<?= $team['id'] ?>" class="btn btn-warning btn-sm me-2">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="/admin/teams" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>
    </div>
    <div class="card-body">
  
        <?php if(session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <?= session()->getFlashdata('success') ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-md-3 text-center">
                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-3" 
                     style="width: 120px; height: 120px; font-size: 48px; background: linear-gradient(135deg, #667eea, #764ba2);">
                    <?= strtoupper(substr($team['member_name'] ?? $team['username'], 0, 1)) ?>
                </div>
                <h4><?= $team['member_name'] ?? $team['username'] ?></h4>
                <p class="text-muted"><?= $team['email'] ?></p>
                <?php 
                $roleBadge = '';
                $roleIcon = '';
                if($team['role_in_project'] == 'project_manager'):
                    $roleBadge = 'bg-warning text-dark';
                    $roleIcon = 'fa-user-tie';
                elseif($team['role_in_project'] == 'staff'):
                    $roleBadge = 'bg-info';
                    $roleIcon = 'fa-user-cog';
                else:
                    $roleBadge = 'bg-success';
                    $roleIcon = 'fa-building';
                endif;
                ?>
                <span class="badge <?= $roleBadge ?> p-2 mb-2">
                    <i class="fas <?= $roleIcon ?> me-1"></i>
                    <?= str_replace('_', ' ', ucfirst($team['role_in_project'])) ?>
                </span>
                <br>
                <span class="badge bg-secondary">
                    <i class="fas fa-tag me-1"></i>
                    System Role: <?= ucfirst($team['role_name'] ?? '') ?>
                </span>
            </div>

            <div class="col-md-9">
  
                <div class="card mb-3 border-primary">
                    <div class="card-header bg-primary text-white">
                        <i class="fas fa-project-diagram me-2"></i>Project Information
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Project</th>
                                        <td>: <strong><?= $team['project_name'] ?></strong></td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>: 
                                            <span class="badge <?= $team['project_type'] == 'internal' ? 'bg-secondary' : 'bg-success' ?>">
                                                <?= ucfirst($team['project_type']) ?>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Start Date</th>
                                        <td>: <?= date('d M Y', strtotime($team['start_date'])) ?></td>
                                    </tr>
                                    <tr>
                                        <th>End Date</th>
                                        <td>: <?= date('d M Y', strtotime($team['end_date'])) ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Company</th>
                                        <td>: <?= $team['company_name'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact</th>
                                        <td>: <?= $team['contact_person'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>: <?= $team['company_phone'] ?? '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <i class="fas fa-user-circle me-2"></i>Member Details
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary"><i class="fas fa-id-card me-2"></i>Personal Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Full Name</th>
                                        <td>: <?= ($team['first_name'] ?? '') . ' ' . ($team['last_name'] ?? '') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>: <?= $team['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: <?= $team['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>: <?= $team['phone'] ?? '-' ?></td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <?php if($team['role_in_project'] == 'staff'): ?>
                                <h6 class="text-primary"><i class="fas fa-briefcase me-2"></i>Job Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Position</th>
                                        <td>: <strong><?= $team['position_name'] ?? '-' ?></strong></td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>: <?= $team['department_name'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Hire Date</th>
                                        <td>: <?= isset($team['hire_date']) ? date('d M Y', strtotime($team['hire_date'])) : '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>: 
                                            <span class="badge <?= ($team['employee_status'] ?? '') == 'permanent' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= ucfirst($team['employee_status'] ?? '-') ?>
                                            </span>
                                        </td>
                                    </tr>
                                </table>
                                <?php elseif($team['role_in_project'] == 'client'): ?>
                                <h6 class="text-primary"><i class="fas fa-building me-2"></i>Company Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Company</th>
                                        <td>: <strong><?= $team['company_name'] ?? '-' ?></strong></td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person</th>
                                        <td>: <?= $team['contact_person'] ?? '-' ?></td>
                                    </tr>
                                    <tr>
                                        <th>Company Phone</th>
                                        <td>: <?= $team['company_phone'] ?? '-' ?></td>
                                    </tr>
                                </table>
                                <?php else: ?>
                                <h6 class="text-primary"><i class="fas fa-user-tie me-2"></i>Project Manager</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Position</th>
                                        <td>: <strong><?= $team['position_name'] ?? 'Project Manager' ?></strong></td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>: <?= $team['department_name'] ?? 'Management' ?></td>
                                    </tr>
                                </table>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3 border-success">
                    <div class="card-header bg-success text-white">
                        <i class="fas fa-chart-line me-2"></i>Activity Summary
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-primary">0</h3>
                                    <small class="text-muted">Tasks Assigned</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-success">0</h3>
                                    <small class="text-muted">Tasks Completed</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-warning">0</h3>
                                    <small class="text-muted">Issues Reported</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-info"><?= date('d M Y', strtotime($team['created_at'] ?? 'now')) ?></h3>
                                    <small class="text-muted">Member Since</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>