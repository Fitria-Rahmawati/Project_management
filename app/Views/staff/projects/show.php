<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== LOADING OVERLAY ==================== */
    .loading-overlay {
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
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner .spinner {
        width: 40px;
        height: 40px;
        border: 3px solid #e3e6f0;
        border-top-color: #4e73df;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #4e73df;
        font-weight: 500;
    }

    /* ==================== PROJECT HEADER ==================== */
    .project-header {
        background: linear-gradient(135deg, #4e73df, #764ba2);
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 25px;
        color: white;
        position: relative;
        overflow: hidden;
    }
    .project-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        pointer-events: none;
    }
    .project-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 8px;
    }
    .project-meta {
        font-size: 13px;
        opacity: 0.9;
    }

    /* ==================== STATS CARDS ==================== */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .stat-info h3 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        color: #5a5c69;
    }
    .stat-info p {
        font-size: 12px;
        color: #858796;
        margin: 5px 0 0;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-icon.blue { background: #e8f0fe; color: #4e73df; }
    .stat-icon.green { background: #e3f9e9; color: #1cc88a; }
    .stat-icon.orange { background: #fff3e0; color: #f6c23e; }
    .stat-icon.red { background: #fee2e2; color: #e74a3b; }

    /* ==================== INFO CARD ==================== */
    .info-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .info-card h6 {
        font-weight: 700;
        color: #5a5c69;
        margin-bottom: 15px;
        padding-bottom: 10px;
        border-bottom: 1px solid #e3e6f0;
    }
    .info-table {
        width: 100%;
    }
    .info-table td {
        padding: 8px 0;
        font-size: 14px;
    }
    .info-table td:first-child {
        width: 110px;
        font-weight: 600;
        color: #858796;
    }
    .info-table td:last-child {
        color: #5a5c69;
        font-weight: 500;
    }

    /* ==================== TASK TABLE ==================== */
    .task-table {
        width: 100%;
        border-collapse: collapse;
    }
    .task-table th {
        background: #f8f9fc;
        padding: 12px 15px;
        font-size: 12px;
        font-weight: 700;
        color: #5a5c69;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e3e6f0;
    }
    .task-table td {
        padding: 12px 15px;
        font-size: 13px;
        border-bottom: 1px solid #e3e6f0;
        vertical-align: middle;
    }
    .task-table tr:hover {
        background: #f8f9fc;
    }
    .badge-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-todo { background: #e3e6f0; color: #5a5c69; }
    .badge-progress { background: #fff3e0; color: #e65100; }
    .badge-review { background: #e1f5fe; color: #006064; }
    .badge-done { background: #e3f9e9; color: #1cc88a; }

    .priority-highest { background: #fee2e2; color: #e74a3b; }
    .priority-high { background: #fff3e0; color: #e65100; }
    .priority-medium { background: #e1f5fe; color: #006064; }
    .priority-low { background: #e8f0fe; color: #4e73df; }
    .priority-lowest { background: #e3e6f0; color: #5a5c69; }

    .btn-detail {
        background: #e8f0fe;
        color: #4e73df;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s;
        text-decoration: none;
    }
    .btn-detail:hover {
        background: #4e73df;
        color: white;
        transform: translateY(-2px);
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .project-header {
            padding: 20px;
        }
        .project-title {
            font-size: 20px;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-project-diagram me-2 text-primary"></i>
            Detail Proyek
        </h1>
        <a href="<?= base_url('staff/projects') ?>" class="btn btn-secondary btn-sm" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Project Header -->
    <div class="project-header">
        <div class="row align-items-center">
            <div class="col-md-8">
                <div class="project-title"><?= esc($project['project_name']) ?></div>
                <div class="project-meta">
                    <i class="fas fa-building me-1"></i> 
                    <?= $project['company_name'] ?? 'Perusahaan' ?>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <div class="project-meta">
                    <i class="fas fa-calendar me-1"></i>
                    <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                    <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <?php 
    $totalTasks = count($tasks);
    $completedTasks = 0;
    $inProgressTasks = 0;
    $todoTasks = 0;
    foreach($tasks as $task) {
        if($task['status'] == 'Done') $completedTasks++;
        elseif($task['status'] == 'In Progress') $inProgressTasks++;
        else $todoTasks++;
    }
    $completionRate = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;
    ?>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $totalTasks ?></h3>
                <p>Total Tasks</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-tasks"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $todoTasks ?></h3>
                <p>To Do</p>
            </div>
            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $inProgressTasks ?></h3>
                <p>In Progress</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-spinner"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $completionRate ?>%</h3>
                <p>Completion Rate</p>
            </div>
            <div class="stat-icon green"><i class="fas fa-chart-line"></i></div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <!-- Project Info Card -->
            <div class="info-card">
                <h6><i class="fas fa-info-circle me-2 text-primary"></i> Project Info</h6>
                <table class="info-table">
                    <tr><td>Status</td><td>
                        <span class="badge-status <?= $project['status'] == 'completed' ? 'badge-done' : ($project['status'] == 'in_progress' ? 'badge-progress' : 'badge-todo') ?>">
                            <?= ucfirst(str_replace('_', ' ', $project['status'])) ?>
                        </span>
                     </div>
                     </td>
                    <tr><td>Start Date</td><td><?= date('d M Y', strtotime($project['start_date'])) ?></div> </div>
                     </td>
                    <tr><td>End Date</td><td><?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : '-' ?></div> </div>
                     </tr>
                    <tr><td>Project Type</td><td><?= ucfirst($project['project_type'] ?? 'Internal') ?></div> </div>
                     </tr>
                    <?php if(!empty($project['company_name'])): ?>
                    <tr><td>Company</td><td><?= esc($project['company_name']) ?></div> </div>
                     </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>

        <div class="col-md-8">
            <!-- Tasks Card -->
            <div class="info-card">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0"><i class="fas fa-tasks me-2 text-primary"></i> My Tasks</h6>
                    <a href="<?= base_url('staff/issues/create?project=' . $project['id']) ?>" class="btn btn-sm btn-danger" id="btnReportIssue">
                        <i class="fas fa-plus me-1"></i> Report Issue
                    </a>
                </div>
                <div class="table-responsive">
                    <table class="task-table">
                        <thead>
                            <tr>
                                <th>Task Title</th>
                                <th>Status</th>
                                <th>Priority</th>
                                <th>Due Date</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(empty($tasks)): ?>
                                <tr>
                                    <td colspan="5" class="text-center py-4 text-muted">
                                        <i class="fas fa-inbox fa-2x mb-2 d-block"></i>
                                        Belum ada task dalam proyek ini
                                     </div>
                                     </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach($tasks as $task): ?>
                                    <?php
                                    $statusClass = '';
                                    if($task['status'] == 'To Do') $statusClass = 'badge-todo';
                                    elseif($task['status'] == 'In Progress') $statusClass = 'badge-progress';
                                    elseif($task['status'] == 'In Review') $statusClass = 'badge-review';
                                    else $statusClass = 'badge-done';
                                    
                                    $priorityClass = '';
                                    $priority = strtolower($task['priority']);
                                    if($priority == 'highest') $priorityClass = 'priority-highest';
                                    elseif($priority == 'high') $priorityClass = 'priority-high';
                                    elseif($priority == 'medium') $priorityClass = 'priority-medium';
                                    elseif($priority == 'low') $priorityClass = 'priority-low';
                                    else $priorityClass = 'priority-lowest';
                                    ?>
                                    <tr>
                                        <td class="fw-bold"><?= esc($task['title']) ?></td>
                                        <td><span class="badge-status <?= $statusClass ?>"><?= $task['status'] ?></span></td>
                                        <td><span class="badge-status <?= $priorityClass ?>"><?= $task['priority'] ?></span></td>
                                        <td><?= date('d M Y', strtotime($task['due_date'])) ?></td>
                                        <td>
                                            <a href="<?= base_url('staff/tasks/' . $task['id']) ?>" class="btn-detail" data-detail-link data-name="<?= esc($task['title']) ?>">
                                                <i class="fas fa-eye"></i> Detail
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
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner"></div>
        <p id="loadingMessage">Memuat data...</p>
    </div>
</div>

<script>
// Loading Overlay functions
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(message = 'Memuat data...') {
    if (loadingOverlay) {
        if (loadingMessage) loadingMessage.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        loadingOverlay.style.display = 'flex';
    }
}

function hideLoading() {
    if (loadingOverlay) {
        loadingOverlay.style.display = 'none';
    }
}

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar proyek...');
});
document.getElementById('btnReportIssue')?.addEventListener('click', function(e) {
    showLoading('Membuka form report issue...');
});

// Loading untuk tombol detail task
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const taskName = this.getAttribute('data-name') || 'Task';
        showLoading(`Memuat detail ${taskName}...`);
    });
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto close alerts
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>