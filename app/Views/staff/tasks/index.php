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

    /* ==================== FILTER CARD ==================== */
    .filter-card {
        background: white;
        border-radius: 16px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .filter-card label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: #858796;
        margin-bottom: 6px;
        display: block;
    }

    /* ==================== TASK STATUS BADGES ==================== */
    .task-status {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        display: inline-block;
    }
    .status-todo { background: #e3e6f0; color: #5a5c69; }
    .status-progress { background: #fff3e0; color: #e65100; }
    .status-review { background: #e1f5fe; color: #006064; }
    .status-done { background: #e3f9e9; color: #1cc88a; }

    /* ==================== PRIORITY STYLES ==================== */
    .priority-highest { color: #e74a3b; font-weight: 700; }
    .priority-high { color: #e65100; font-weight: 600; }
    .priority-medium { color: #006064; }
    .priority-low { color: #4e73df; }
    .priority-lowest { color: #858796; }

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

    .btn-detail {
        background: #e8f0fe;
        color: #4e73df;
        padding: 6px 12px;
        border-radius: 8px;
        font-size: 12px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .btn-detail:hover {
        background: #4e73df;
        color: white;
        transform: translateY(-2px);
    }

    .overdue-badge {
        background: #fee2e2;
        color: #e74a3b;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 10px;
        font-weight: 600;
        margin-left: 8px;
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
        .filter-card .row {
            flex-direction: column;
        }
    }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-tasks me-2 text-primary"></i>
            My Tasks
        </h1>
        <div>
            <button class="btn btn-success btn-sm me-2" id="btnExport">
                <i class="fas fa-file-excel me-2"></i>Export
            </button>
            <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-danger btn-sm" id="btnReport">
                <i class="fas fa-exclamation-circle me-2"></i>Report Issue
            </a>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Cards -->
    <?php 
    $totalTasks = count($tasks);
    $todoTasks = 0;
    $inProgressTasks = 0;
    $doneTasks = 0;
    $overdueTasks = 0;
    $today = time();
    
    foreach($tasks as $task) {
        if($task['status'] == 'To Do') $todoTasks++;
        elseif($task['status'] == 'In Progress') $inProgressTasks++;
        elseif($task['status'] == 'Done') $doneTasks++;
        
        if($task['due_date'] && strtotime($task['due_date']) < $today && $task['status'] != 'Done') {
            $overdueTasks++;
        }
    }
    $completionRate = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100, 1) : 0;
    ?>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $totalTasks ?></h3>
                <p>Total Tasks</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-list"></i></div>
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

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="get" action="<?= base_url('staff/tasks') ?>" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label">STATUS</label>
                    <select name="status" class="form-select form-select-sm" id="filterStatus">
                        <option value="">Semua Status</option>
                        <option value="To Do" <?= ($status ?? '') == 'To Do' ? 'selected' : '' ?>>To Do</option>
                        <option value="In Progress" <?= ($status ?? '') == 'In Progress' ? 'selected' : '' ?>>In Progress</option>
                        <option value="In Review" <?= ($status ?? '') == 'In Review' ? 'selected' : '' ?>>In Review</option>
                        <option value="Done" <?= ($status ?? '') == 'Done' ? 'selected' : '' ?>>Done</option>
                        <option value="Closed" <?= ($status ?? '') == 'Closed' ? 'selected' : '' ?>>Closed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">PRIORITY</label>
                    <select name="priority" class="form-select form-select-sm" id="filterPriority">
                        <option value="">Semua Priority</option>
                        <option value="Highest" <?= ($priority ?? '') == 'Highest' ? 'selected' : '' ?>>Highest</option>
                        <option value="High" <?= ($priority ?? '') == 'High' ? 'selected' : '' ?>>High</option>
                        <option value="Medium" <?= ($priority ?? '') == 'Medium' ? 'selected' : '' ?>>Medium</option>
                        <option value="Low" <?= ($priority ?? '') == 'Low' ? 'selected' : '' ?>>Low</option>
                        <option value="Lowest" <?= ($priority ?? '') == 'Lowest' ? 'selected' : '' ?>>Lowest</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">SEARCH</label>
                    <input type="text" name="search" class="form-control form-control-sm" placeholder="Cari judul task..." value="<?= $search ?? '' ?>" id="searchInput">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-sm w-100" id="btnFilter">
                        <i class="fas fa-filter me-2"></i>Filter
                    </button>
                </div>
            </div>
            <?php if(!empty($status) || !empty($priority) || !empty($search)): ?>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="<?= base_url('staff/tasks') ?>" class="btn btn-sm btn-secondary" id="btnReset">
                            <i class="fas fa-times me-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <!-- Tasks Table -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <h6 class="mb-0"><i class="fas fa-list me-2 text-primary"></i> Daftar Task</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="task-table">
                    <thead>
                        <tr>
                            <th width="50">#</th>
                            <th>Task</th>
                            <th>Project</th>
                            <th width="100">Priority</th>
                            <th width="110">Status</th>
                            <th width="120">Due Date</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($tasks)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i class="fas fa-check-circle fa-3x mb-3 d-block"></i>
                                    <p>Tidak ada task yang diassign</p>
                                    <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-sm btn-primary" id="btnReportFirst">Report Issue</a>
                                 </div>
                                 </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($tasks as $i => $task): ?>
                                <?php
                                $priorityClass = '';
                                $priority = strtolower($task['priority']);
                                if($priority == 'highest') $priorityClass = 'priority-highest';
                                elseif($priority == 'high') $priorityClass = 'priority-high';
                                elseif($priority == 'medium') $priorityClass = 'priority-medium';
                                elseif($priority == 'low') $priorityClass = 'priority-low';
                                else $priorityClass = 'priority-lowest';
                                
                                $statusClass = '';
                                if($task['status'] == 'To Do') $statusClass = 'status-todo';
                                elseif($task['status'] == 'In Progress') $statusClass = 'status-progress';
                                elseif($task['status'] == 'In Review') $statusClass = 'status-review';
                                else $statusClass = 'status-done';
                                
                                $isOverdue = ($task['due_date'] && strtotime($task['due_date']) < time() && $task['status'] != 'Done');
                                ?>
                                <tr>
                                    <td class="text-center fw-bold"><?= $i + 1 ?></td>
                                    <td>
                                        <div class="fw-bold"><?= esc($task['title']) ?></div>
                                        <small class="text-muted">ID: #<?= $task['id'] ?></small>
                                     </div>
                                     </td>
                                    <td><?= esc($task['project_name']) ?>?</div>
                                     </td>
                                    <td class="<?= $priorityClass ?> fw-bold"><?= $task['priority'] ?></div>
                                     </td>
                                    <td><span class="task-status <?= $statusClass ?>"><?= $task['status'] ?></span></div>
                                     </td>
                                    <td>
                                        <?php if($task['due_date']): ?>
                                            <i class="far fa-calendar me-1"></i>
                                            <?= date('d M Y', strtotime($task['due_date'])) ?>
                                            <?php if($isOverdue): ?>
                                                <span class="overdue-badge"><i class="fas fa-exclamation-triangle me-1"></i>Overdue</span>
                                            <?php endif; ?>
                                        <?php else: ?>
                                            <span class="text-muted">-</span>
                                        <?php endif; ?>
                                     </div>
                                     </td>
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

// Export function
function exportTasks() {
    const status = document.getElementById('filterStatus')?.value || '';
    const priority = document.getElementById('filterPriority')?.value || '';
    const search = document.getElementById('searchInput')?.value || '';
    showLoading('Menyiapkan file export...');
    setTimeout(() => {
        window.location.href = `<?= base_url('staff/tasks/export') ?>?status=${status}&priority=${priority}&search=${search}`;
        setTimeout(() => hideLoading(), 1500);
    }, 200);
}

// Loading untuk tombol export
document.getElementById('btnExport')?.addEventListener('click', exportTasks);

// Loading untuk tombol report
document.getElementById('btnReport')?.addEventListener('click', function(e) {
    showLoading('Membuka form report issue...');
});
document.getElementById('btnReportFirst')?.addEventListener('click', function(e) {
    showLoading('Membuka form report issue...');
});

// Loading untuk filter
document.getElementById('btnFilter')?.addEventListener('click', function(e) {
    showLoading('Menerapkan filter...');
});
document.getElementById('btnReset')?.addEventListener('click', function(e) {
    showLoading('Merreset filter...');
});

// Loading untuk tombol detail
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