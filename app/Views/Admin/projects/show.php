<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .detail-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .detail-card .card-header {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
        font-weight: 600;
        border-radius: 15px 15px 0 0 !important;
    }
    .detail-card .card-body {
        padding: 20px;
    }
    .info-label {
        font-size: 12px;
        color: #888;
        margin-bottom: 5px;
    }
    .info-value {
        font-size: 14px;
        font-weight: 500;
        color: #333;
    }
    .project-header {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
    }
    .project-title {
        font-size: 24px;
        font-weight: 600;
        margin-bottom: 10px;
    }
    .project-type {
        font-size: 12px;
        background: rgba(255,255,255,0.2);
        padding: 5px 15px;
        border-radius: 20px;
        display: inline-block;
    }
    .team-avatar {
        width: 45px;
        height: 45px;
        border-radius: 50%;
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        font-weight: 600;
    }
    .stat-box {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
        border: 1px solid #eee;
    }
    .stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #667eea;
        margin-bottom: 5px;
    }
    .stat-label {
        font-size: 11px;
        color: #888;
        text-transform: uppercase;
    }
    .timeline {
        position: relative;
        padding-left: 30px;
    }
    .timeline-item {
        position: relative;
        padding-bottom: 20px;
    }
    .timeline-item:before {
        content: '';
        position: absolute;
        left: -20px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e0e0e0;
    }
    .timeline-item:after {
        content: '';
        position: absolute;
        left: -24px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #667eea;
        border: 2px solid white;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
    .progress {
        height: 8px;
        border-radius: 4px;
    }
    .progress-bar {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    
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
        color: #667eea;
        font-weight: 500;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-eye me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <a href="/admin/projects/edit/<?= $project['id'] ?>" class="btn btn-warning btn-sm me-2" id="btnEdit">
                    <i class="fas fa-edit me-2"></i>Edit
                </a>
                <a href="/admin/projects" class="btn btn-secondary btn-sm" id="btnBack">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>
    
    <div class="project-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="project-title">
                    <?= esc($project['project_name']) ?>
                    <span class="project-type ms-3">
                        <i class="fas <?= $project['project_type'] == 'internal' ? 'fa-building' : 'fa-user-tie' ?> me-1"></i>
                        <?= ucfirst($project['project_type']) ?>
                    </span>
                </div>
                <div class="row mt-3">
                    <div class="col-md-4">
                        <small class="opacity-75">Start Date</small>
                        <div class="fw-bold">
                            <i class="far fa-calendar me-2"></i>
                            <?= date('d F Y', strtotime($project['start_date'])) ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small class="opacity-75">End Date</small>
                        <div class="fw-bold">
                            <i class="far fa-calendar-check me-2"></i>
                            <?= $project['end_date'] ? date('d F Y', strtotime($project['end_date'])) : 'Not Set' ?>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <small class="opacity-75">Status</small>
                        <div class="fw-bold">
                            <?php 
                            $statusClass = '';
                            switch($project['status']) {
                                case 'planning': $statusClass = 'bg-secondary'; break;
                                case 'in_progress': $statusClass = 'bg-warning text-dark'; break;
                                case 'completed': $statusClass = 'bg-success'; break;
                                case 'cancelled': $statusClass = 'bg-danger'; break;
                                default: $statusClass = 'bg-info';
                            }
                            ?>
                            <span class="badge <?= $statusClass ?> p-2">
                                <?= ucfirst(str_replace('_', ' ', $project['status'])) ?>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-end">
                <div class="stat-box bg-white">
                    <div class="stat-number"><?= count($team) ?></div>
                    <div class="stat-label">Team Members</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-align-left me-2 text-primary"></i>Deskripsi Project
                </div>
                <div class="card-body">
                    <?php if($project['description']): ?>
                      <?php 
$description = is_array($project['description']) ? json_encode($project['description']) : ($project['description'] ?? '-');?>
                    <?php else: ?>
                        <p class="text-muted">Tidak ada deskripsi</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-users me-2 text-primary"></i>Team Members
                    </div>
                    <button class="btn btn-primary btn-sm" onclick="openAddMemberModal()" id="btnAddMember">
                        <i class="fas fa-plus me-2"></i>Tambah Member
                    </button>
                </div>
                <div class="card-body">
                    <?php if(empty($team)): ?>
                        <div class="text-center py-5">
                            <i class="fas fa-users-slash fa-4x text-muted mb-3"></i>
                            <p class="text-muted">Belum ada team member</p>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Member</th>
                                        <th>Email</th>
                                        <th>Role in Project</th>
                                        <th>Posisi</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($team as $member): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="team-avatar me-3">
                                                        <?= strtoupper(substr($member['first_name'] ?? $member['username'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <strong><?= esc($member['first_name'] ?? $member['username']) ?> <?= esc($member['last_name'] ?? '') ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?= esc($member['username']) ?></small>
                                                    </div>
                                                </div>
                                             </div>
                                             </td>
                                            <td><?= esc($member['email']) ?></div>
                                             </td>
                                            <td>
                                                <?php 
                                                $roleClass = '';
                                                $roleIcon = '';
                                                switch($member['role_in_project'] ?? 'staff') {
                                                    case 'project_manager':
                                                        $roleClass = 'bg-warning text-dark';
                                                        $roleIcon = 'fa-user-tie';
                                                        $roleText = 'Project Manager';
                                                        break;
                                                    case 'staff':
                                                        $roleClass = 'bg-info';
                                                        $roleIcon = 'fa-user-cog';
                                                        $roleText = 'Staff';
                                                        break;
                                                    case 'client':
                                                        $roleClass = 'bg-success';
                                                        $roleIcon = 'fa-building';
                                                        $roleText = 'Client';
                                                        break;
                                                    default:
                                                        $roleClass = 'bg-secondary';
                                                        $roleIcon = 'fa-user';
                                                        $roleText = ucfirst($member['role_in_project'] ?? 'Staff');
                                                }
                                                ?>
                                                <span class="badge <?= $roleClass ?> p-2">
                                                    <i class="fas <?= $roleIcon ?> me-1"></i>
                                                    <?= $roleText ?>
                                                </span>
                                             </div>
                                             </td>
                                            <td>
                                                <?= esc($member['position_name'] ?? '-') ?>
                                                <?php if($member['department_name']): ?>
                                                    <br><small class="text-muted"><?= esc($member['department_name']) ?></small>
                                                <?php endif; ?>
                                             </div>
                                             </td>
                                            <td>
                                                <button class="btn btn-sm btn-danger" onclick="removeMember(<?= $member['id'] ?>, '<?= addslashes($member['first_name'] ?? $member['username']) ?>')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                             </div>
                                             </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-exclamation-circle me-2 text-primary"></i>Recent Issues
                    </div>
                    <a href="/admin/issues?project=<?= $project['id'] ?>" class="btn btn-sm btn-outline-primary" id="btnAllIssues">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <?php 
                    $db = \Config\Database::connect();
                    $recentIssues = $db->table('issues')
                        ->select('issues.*, reporter.username as reporter_name, assignee.username as assignee_name')
                        ->join('users reporter', 'reporter.id = issues.reporter_id', 'left')
                        ->join('users assignee', 'assignee.id = issues.assignee_id', 'left')
                        ->where('project_id', $project['id'])
                        ->orderBy('created_at', 'DESC')
                        ->limit(5)
                        ->get()
                        ->getResultArray();
                    ?>
                    
                    <?php if(empty($recentIssues)): ?>
                        <p class="text-muted text-center py-3">Belum ada issues</p>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach($recentIssues as $issue): ?>
                                <a href="/admin/issues/<?= $issue['id'] ?>" class="list-group-item list-group-item-action" data-issue-link>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>#<?= $issue['id'] ?> - <?= esc($issue['title']) ?></strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-user me-1"></i><?= esc($issue['reporter_name'] ?? 'Unknown') ?>
                                                <i class="fas fa-calendar ms-2 me-1"></i><?= date('d/m/Y', strtotime($issue['created_at'])) ?>
                                            </small>
                                        </div>
                                        <?php 
                                        $issueClass = '';
                                        switch($issue['status']) {
                                            case 'To Do': $issueClass = 'bg-secondary'; break;
                                            case 'In Progress': $issueClass = 'bg-warning text-dark'; break;
                                            case 'Done': $issueClass = 'bg-success'; break;
                                            default: $issueClass = 'bg-info';
                                        }
                                        ?>
                                        <span class="badge <?= $issueClass ?>">
                                            <?= $issue['status'] ?>
                                        </span>
                                    </div>
                                </a>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-building me-2 text-primary"></i>Informasi Perusahaan
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="team-avatar mx-auto mb-3" style="width: 70px; height: 70px; font-size: 28px;">
                            <?= strtoupper(substr($project['company_name'] ?? 'I', 0, 1)) ?>
                        </div>
                        <h5><?= esc($project['company_name'] ?? 'Internal') ?></h5>
                        <span class="badge <?= ($project['company_type'] ?? '') == 'client' ? 'bg-success' : 'bg-secondary' ?>">
                            <?= ucfirst($project['company_type'] ?? 'internal') ?>
                        </span>
                    </div>

                    <?php if($project['company_type'] == 'client'): ?>
                        <hr>
                        <div class="info-item mb-3">
                            <div class="info-label">Contact Person</div>
                            <div class="info-value">
                                <i class="fas fa-user-tie me-2 text-primary"></i>
                                <?= esc($project['contact_person'] ?? '-') ?>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="info-label">Company Email</div>
                            <div class="info-value">
                                <i class="fas fa-envelope me-2 text-primary"></i>
                                <?= esc($project['company_email'] ?? '-') ?>
                            </div>
                        </div>
                        <div class="info-item mb-3">
                            <div class="info-label">Company Phone</div>
                            <div class="info-value">
                                <i class="fas fa-phone me-2 text-primary"></i>
                                <?= esc($project['company_phone'] ?? '-') ?>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-user-tie me-2 text-primary"></i>Project Manager
                </div>
                <div class="card-body">
                    <?php 
                    $pmName = $project['manager_first_name'] ?? $project['manager_username'] ?? '-';
                    if($pmName != '-'): 
                    ?>
                        <div class="d-flex align-items-center">
                            <div class="team-avatar me-3" style="width: 60px; height: 60px; font-size: 24px;">
                                <?= strtoupper(substr($pmName, 0, 1)) ?>
                            </div>
                            <div>
                                <h5 class="mb-1"><?= esc($pmName) ?> <?= esc($project['manager_last_name'] ?? '') ?></h5>
                                <small class="text-muted d-block">
                                    <i class="fas fa-envelope me-1"></i> <?= esc($project['manager_username'] ?? '') ?>
                                </small>
                            </div>
                        </div>
                    <?php else: ?>
                        <p class="text-muted">Belum ada project manager</p>
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-chart-pie me-2 text-primary"></i>Statistik
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php 
                        $totalIssues = 0;
                        $completedIssues = 0;
                        $inProgressIssues = 0;
                        
                        foreach($issueStats as $stat) {
                            $totalIssues += $stat['total'];
                            if($stat['status'] == 'Done' || $stat['status'] == 'Closed') {
                                $completedIssues += $stat['total'];
                            }
                            if($stat['status'] == 'In Progress') {
                                $inProgressIssues += $stat['total'];
                            }
                        }
                        
                        $progress = $totalIssues > 0 ? round(($completedIssues / $totalIssues) * 100, 2) : 0;
                        ?>
                        
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="stat-number"><?= $totalIssues ?></div>
                                <div class="stat-label">Total Issues</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-box">
                                <div class="stat-number text-success"><?= $completedIssues ?></div>
                                <div class="stat-label">Completed</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <small>Progress</small>
                            <small class="fw-bold"><?= $progress ?>%</small>
                        </div>
                        <div class="progress">
                            <div class="progress-bar" style="width: <?= $progress ?>%"></div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted d-block mb-2">Issue by Status</small>
                        <?php foreach($issueStats as $stat): ?>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge-status 
                                    <?php 
                                    switch($stat['status']) {
                                        case 'To Do': echo 'bg-secondary'; break;
                                        case 'In Progress': echo 'bg-warning text-dark'; break;
                                        case 'Done': echo 'bg-success'; break;
                                        case 'Closed': echo 'bg-dark'; break;
                                        default: echo 'bg-info';
                                    }
                                    ?>">
                                    <?= $stat['status'] ?>
                                </span>
                                <span><?= $stat['total'] ?></span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
            
            <div class="detail-card">
                <div class="card-header">
                    <i class="fas fa-calendar-alt me-2 text-primary"></i>Timeline
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <small class="text-muted">Created At</small>
                            <div class="fw-bold"><?= date('d F Y H:i', strtotime($project['created_at'] ?? 'now')) ?></div>
                        </div>
                        <div class="timeline-item">
                            <small class="text-muted">Last Updated</small>
                            <div class="fw-bold"><?= date('d F Y H:i', strtotime($project['updated_at'] ?? 'now')) ?></div>
                        </div>
                        <?php if($project['start_date']): ?>
                        <div class="timeline-item">
                            <small class="text-muted">Start Date</small>
                            <div class="fw-bold"><?= date('d F Y', strtotime($project['start_date'])) ?></div>
                        </div>
                        <?php endif; ?>
                        <?php if($project['end_date']): ?>
                        <div class="timeline-item">
                            <small class="text-muted">End Date</small>
                            <div class="fw-bold"><?= date('d F Y', strtotime($project['end_date'])) ?></div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah Member -->
<div class="modal fade" id="addMemberModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2 text-primary"></i>
                    Tambah Team Member
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="/admin/projects/<?= $project['id'] ?>/add-member" method="post" id="addMemberForm">
                <?= csrf_field() ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Pilih User <span class="text-danger">*</span></label>
                        <select name="user_id" class="form-select" id="selectUser" required>
                            <option value="">-- Pilih User --</option>
                            <?php 
                            $userModel = new \App\Models\UserModel();
                            $users = $userModel->findAll();
                            foreach($users as $user): 
                            ?>
                                <option value="<?= $user['id'] ?>"><?= esc($user['username']) ?> (<?= esc($user['email']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                        <div class="invalid-feedback">User wajib dipilih</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Role dalam Project <span class="text-danger">*</span></label>
                        <select name="role_in_project" class="form-select" id="selectRole" required>
                            <option value="">-- Pilih Role --</option>
                            <option value="staff">Staff</option>
                            <option value="project_manager">Project Manager</option>
                            <option value="client">Client</option>
                        </select>
                        <div class="invalid-feedback">Role wajib dipilih</div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSubmitMember">
                        <i class="fas fa-save me-2"></i>
                        <span class="btn-text">Tambah</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-primary" role="status" style="width: 3rem; height: 3rem;">
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

// Modal functions
function openAddMemberModal() {
    new bootstrap.Modal(document.getElementById('addMemberModal')).show();
}

// Remove member with confirmation
function removeMember(memberId, memberName) {
    if (confirm(`⚠️ PERINGATAN!\n\nYakin ingin menghapus member "${memberName}" dari project ini?\n\nKlik OK untuk melanjutkan.`)) {
        showLoading('Menghapus member dari project...');
        setTimeout(() => {
            window.location.href = '/admin/projects/remove-member/<?= $project['id'] ?>/' + memberId;
        }, 200);
    }
}

// Validasi form tambah member
document.getElementById('addMemberForm')?.addEventListener('submit', function(e) {
    let isValid = true;
    
    const user = document.getElementById('selectUser');
    if (!user.value) {
        user.classList.add('is-invalid');
        isValid = false;
    } else {
        user.classList.remove('is-invalid');
    }
    
    const role = document.getElementById('selectRole');
    if (!role.value) {
        role.classList.add('is-invalid');
        isValid = false;
    } else {
        role.classList.remove('is-invalid');
    }
    
    if (!isValid) {
        e.preventDefault();
        return false;
    }
    
    const btn = document.getElementById('btnSubmitMember');
    btn.disabled = true;
    btn.querySelector('.btn-text').textContent = 'Menyimpan...';
    btn.querySelector('.spinner-border').classList.remove('d-none');
    showLoading('Menambahkan member...');
});

// Loading untuk navigasi
document.getElementById('btnEdit')?.addEventListener('click', function(e) {
    showLoading('Membuka form edit project...');
});
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar project...');
});
document.getElementById('btnAllIssues')?.addEventListener('click', function(e) {
    showLoading('Memuat daftar issues...');
});
document.querySelectorAll('[data-issue-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        showLoading('Memuat detail issue...');
    });
});
document.getElementById('btnAddMember')?.addEventListener('click', function(e) {
    // Reset form modal
    document.getElementById('selectUser').value = '';
    document.getElementById('selectRole').value = '';
});

// Remove invalid class on input
document.getElementById('selectUser')?.addEventListener('change', function() {
    this.classList.remove('is-invalid');
});
document.getElementById('selectRole')?.addEventListener('change', function() {
    this.classList.remove('is-invalid');
});

// Sembunyikan loading saat halaman selesai
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