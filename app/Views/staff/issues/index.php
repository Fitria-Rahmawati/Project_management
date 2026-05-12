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
        border-top-color: #0d6efd;
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
        color: #0d6efd;
        font-weight: 500;
    }

    /* Stats Cards */
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

    /* Badge Status */
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-todo { background: #e3e6f0; color: #5a5c69; }
    .badge-progress { background: #fff3e0; color: #e65100; }
    .badge-review { background: #e1f5fe; color: #006064; }
    .badge-done { background: #e3f9e9; color: #1cc88a; }

    /* Priority Badge */
    .priority-highest { background: #fee2e2; color: #e74a3b; }
    .priority-high { background: #fff3e0; color: #e65100; }
    .priority-medium { background: #e1f5fe; color: #006064; }
    .priority-low { background: #e8f0fe; color: #4e73df; }
    .priority-lowest { background: #e3e6f0; color: #5a5c69; }

    /* Responsive */
    @media (max-width: 992px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    @media (max-width: 768px) {
        .stats-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<div class="container-fluid">
    <div class="d-flex justify-content-between flex-wrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-list me-2 text-primary"></i>
            My Issues
        </h1>
        <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-danger btn-sm" id="btnCreate">
            <i class="fas fa-plus me-2"></i>Report New Issue
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

    <!-- Stats Cards -->
    <?php 
    $totalIssues = count($issues);
    $openIssues = 0;
    $inProgressIssues = 0;
    $doneIssues = 0;
    foreach($issues as $issue) {
        if($issue['status'] == 'To Do' || $issue['status'] == 'open') $openIssues++;
        elseif($issue['status'] == 'In Progress' || $issue['status'] == 'in_progress') $inProgressIssues++;
        elseif($issue['status'] == 'Done' || $issue['status'] == 'done') $doneIssues++;
    }
    ?>
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $totalIssues ?></h3>
                <p>Total Issues</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-list"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $openIssues ?></h3>
                <p>Open / To Do</p>
            </div>
            <div class="stat-icon orange"><i class="fas fa-clock"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $inProgressIssues ?></h3>
                <p>In Progress</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-spinner"></i></div>
        </div>
        <div class="stat-card">
            <div class="stat-info">
                <h3><?= $doneIssues ?></h3>
                <p>Completed</p>
            </div>
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>

    <!-- Issues Table -->
    <div class="card shadow">
        <div class="card-header bg-white">
            <h6 class="mb-0">Issues yang Anda laporkan</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="60">ID</th>
                            <th>Title</th>
                            <th width="80">Type</th>
                            <th>Project</th>
                            <th width="100">Status</th>
                            <th width="100">Priority</th>
                            <th width="100">Created</th>
                            <th width="80">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($issues)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 d-block"></i>
                                    <p>Belum ada issue yang dilaporkan</p>
                                    <a href="<?= base_url('staff/issues/create') ?>" class="btn btn-sm btn-primary" id="btnCreateFirst">Report Issue</a>
                                 </div>
                                 </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($issues as $issue): ?>
                                <?php
                                // Status badge class
                                $statusClass = 'badge-status ';
                                if($issue['status'] == 'To Do' || $issue['status'] == 'open') $statusClass .= 'badge-todo';
                                elseif($issue['status'] == 'In Progress' || $issue['status'] == 'in_progress') $statusClass .= 'badge-progress';
                                elseif($issue['status'] == 'In Review') $statusClass .= 'badge-review';
                                else $statusClass .= 'badge-done';
                                
                                // Priority badge class
                                $priorityClass = 'badge-status ';
                                $priority = strtolower($issue['priority']);
                                if($priority == 'highest') $priorityClass .= 'priority-highest';
                                elseif($priority == 'high') $priorityClass .= 'priority-high';
                                elseif($priority == 'medium') $priorityClass .= 'priority-medium';
                                elseif($priority == 'low') $priorityClass .= 'priority-low';
                                else $priorityClass .= 'priority-lowest';
                                ?>
                                <tr>
                                    <td class="text-center fw-bold">#<?= $issue['id'] ?></td>
                                    <td class="fw-bold"><?= esc($issue['title']) ?></td>
                                    <td>
                                        <?php 
                                        $typeIcon = '';
                                        $typeColor = '';
                                        switch($issue['issue_type']) {
                                            case 'task':
                                                $typeIcon = 'fa-check-circle';
                                                $typeColor = 'text-primary';
                                                break;
                                            case 'bug':
                                                $typeIcon = 'fa-bug';
                                                $typeColor = 'text-danger';
                                                break;
                                            case 'story':
                                                $typeIcon = 'fa-book';
                                                $typeColor = 'text-success';
                                                break;
                                            default:
                                                $typeIcon = 'fa-circle';
                                        }
                                        ?>
                                        <i class="fas <?= $typeIcon ?> <?= $typeColor ?> me-1"></i>
                                        <?= ucfirst($issue['issue_type']) ?>
                                     </div>
                                     </td>
                                    <td><?= esc($issue['project_name']) ?></td>
                                    <td><span class="<?= $statusClass ?>"><?= $issue['status'] ?></span></td>
                                    <td><span class="<?= $priorityClass ?>"><?= $issue['priority'] ?></span></td>
                                    <td><?= date('d/m/Y', strtotime($issue['created_at'])) ?></td>
                                    <td>
                                        <a href="<?= base_url('staff/issues/' . $issue['id']) ?>" class="btn btn-sm btn-info" title="Detail" data-detail-link data-id="<?= $issue['id'] ?>">
                                            <i class="fas fa-eye"></i>
                                        </a>
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

// Loading untuk tombol create
document.getElementById('btnCreate')?.addEventListener('click', function(e) {
    showLoading('Membuka form report issue...');
});
document.getElementById('btnCreateFirst')?.addEventListener('click', function(e) {
    showLoading('Membuka form report issue...');
});

// Loading untuk tombol detail
document.querySelectorAll('[data-detail-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        showLoading('Memuat detail issue...');
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