<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* Loading Overlay */
    .page-loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-spinner {
        background: white;
        padding: 30px 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #0dcaf0;
        font-weight: 500;
    }
</style>

<div class="card shadow">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0">
            <i class="fas fa-eye me-2 text-info"></i>
            <?= $title ?>
        </h5>
        <div>
            <a href="/admin/teams/edit/<?= $team['id'] ?>" class="btn btn-warning btn-sm me-2" id="btnEdit">
                <i class="fas fa-edit me-2"></i>Edit
            </a>
            <a href="/admin/teams" class="btn btn-secondary btn-sm" id="btnBack">
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
                <h4><?= esc($team['member_name'] ?? $team['username']) ?></h4>
                <p class="text-muted"><?= esc($team['email']) ?></p>
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
                                        <td>: <strong><?= esc($team['project_name']) ?></strong></td>
                                    </tr>
                                    <tr>
                                        <th>Type</th>
                                        <td>: 
                                            <span class="badge <?= $team['project_type'] == 'internal' ? 'bg-secondary' : 'bg-success' ?>">
                                                <?= ucfirst($team['project_type']) ?>
                                            </span>
                                         </div>
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
                                        <td>: <?= esc($team['company_name'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Contact</th>
                                        <td>: <?= esc($team['contact_person'] ?? '-') ?></td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>: <?= esc($team['company_phone'] ?? '-') ?></td>
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
                                        <td>: <?= esc(($team['first_name'] ?? '') . ' ' . ($team['last_name'] ?? '')) ?>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Username</th>
                                        <td>: <?= esc($team['username']) ?>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td>: <?= esc($team['email']) ?>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Phone</th>
                                        <td>: <?= esc($team['phone'] ?? '-') ?>?</div>
                                         </td>
                                    </tr>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <?php if($team['role_in_project'] == 'staff'): ?>
                                <h6 class="text-primary"><i class="fas fa-briefcase me-2"></i>Job Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Position</th>
                                        <td>: <strong><?= esc($team['position_name'] ?? '-') ?></strong>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>: <?= esc($team['department_name'] ?? '-') ?>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Hire Date</th>
                                        <td>: <?= isset($team['hire_date']) ? date('d M Y', strtotime($team['hire_date'])) : '-' ?>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Status</th>
                                        <td>: 
                                            <span class="badge <?= ($team['employee_status'] ?? '') == 'permanent' ? 'bg-success' : 'bg-warning' ?>">
                                                <?= ucfirst($team['employee_status'] ?? '-') ?>
                                            </span>
                                         </div>
                                         </td>
                                    </tr>
                                ｜DSML｜
                                <?php elseif($team['role_in_project'] == 'client'): ?>
                                <h6 class="text-primary"><i class="fas fa-building me-2"></i>Company Information</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Company</th>
                                        <td>: <strong><?= esc($team['company_name'] ?? '-') ?></strong>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Contact Person</th>
                                        <td>: <?= esc($team['contact_person'] ?? '-') ?>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Company Phone</th>
                                        <td>: <?= esc($team['company_phone'] ?? '-') ?>?</div>
                                         </td>
                                    </tr>
                                </table>
                                <?php else: ?>
                                <h6 class="text-primary"><i class="fas fa-user-tie me-2"></i>Project Manager</h6>
                                <table class="table table-borderless">
                                    <tr>
                                        <th width="120">Position</th>
                                        <td>: <strong><?= esc($team['position_name'] ?? 'Project Manager') ?></strong>?</div>
                                         </td>
                                    </tr>
                                    <tr>
                                        <th>Department</th>
                                        <td>: <?= esc($team['department_name'] ?? 'Management') ?>?</div>
                                         </td>
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
                                    <h3 class="text-primary"><?= $totalTasks ?? 0 ?></h3>
                                    <small class="text-muted">Tasks Assigned</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-success"><?= $completedTasks ?? 0 ?></h3>
                                    <small class="text-muted">Tasks Completed</small>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border rounded p-3">
                                    <h3 class="text-warning"><?= $issuesReported ?? 0 ?></h3>
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

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-info" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Memproses...') {
    const overlay = document.getElementById('loadingOverlay');
    const msgElement = document.getElementById('loadingMessage');
    if (overlay) {
        if (msgElement) msgElement.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Loading untuk tombol edit
document.getElementById('btnEdit')?.addEventListener('click', function(e) {
    showLoading('Membuka form edit team member...');
});

// Loading untuk tombol kembali
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar team...');
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto-hide flash messages
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>