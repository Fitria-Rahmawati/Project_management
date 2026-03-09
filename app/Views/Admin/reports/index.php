<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>
<style>
    .stat-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .chart-container {
        position: relative;
        height: 300px;
        margin: 20px 0;
    }
    .report-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        margin-bottom: 20px;
    }
    .report-card .card-header {
        background: white;
        border-bottom: 1px solid #eee;
        padding: 15px 20px;
        font-weight: 600;
        border-radius: 15px 15px 0 0 !important;
    }
    .report-card .card-header h6 {
        margin: 0;
        color: #333;
    }
    .report-card .card-body {
        padding: 20px;
    }
    .quick-report-item {
        padding: 15px;
        border: 1px solid #eee;
        border-radius: 10px;
        margin-bottom: 10px;
        transition: all 0.3s;
        cursor: pointer;
    }
    .quick-report-item:hover {
        background: #f8f9ff;
        border-color: #667eea;
    }
    .quick-report-item a {
        text-decoration: none;
        color: #333;
        display: flex;
        align-items: center;
    }
    .quick-report-icon {
        width: 45px;
        height: 45px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        margin-right: 15px;
    }
    .progress {
        height: 10px;
        border-radius: 5px;
    }
    .progress-bar {
        background: linear-gradient(135deg, #667eea, #764ba2);
    }
    .badge-status {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 500;
    }
</style>

<div class="container-fluid px-0">
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-chart-bar me-2 text-primary"></i>
                <?= $title ?>
            </h5>
            <div>
                <button class="btn btn-success btn-sm me-2" onclick="exportReport()">
                    <i class="fas fa-file-export me-2"></i>Export
                </button>
                <button class="btn btn-primary btn-sm" onclick="printReport()">
                    <i class="fas fa-print me-2"></i>Print
                </button>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Total Projects</span>
                            <h3 class="mt-2 mb-0"><?= $totalProjects ?></h3>
                            <small class="text-success">
                                <i class="fas fa-arrow-up me-1"></i>Active Projects
                            </small>
                        </div>
                        <div class="stat-icon bg-primary text-white">
                            <i class="fas fa-project-diagram"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Total Issues</span>
                            <h3 class="mt-2 mb-0"><?= $totalIssues ?></h3>
                            <small class="text-warning">
                                <i class="fas fa-clock me-1"></i><?= $overdueIssues ?> Overdue
                            </small>
                        </div>
                        <div class="stat-icon bg-warning text-white">
                            <i class="fas fa-exclamation-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Completed</span>
                            <h3 class="mt-2 mb-0"><?= $completedIssues ?></h3>
                            <small class="text-success">
                                <i class="fas fa-check-circle me-1"></i><?= $completionRate ?>% Complete
                            </small>
                        </div>
                        <div class="stat-icon bg-success text-white">
                            <i class="fas fa-check-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-3">
            <div class="card stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <span class="text-muted small">Team Members</span>
                            <h3 class="mt-2 mb-0"><?= $totalStaff ?? 0 ?></h3>
                            <small class="text-info">
                                <i class="fas fa-users me-1"></i>Active Staff
                            </small>
                        </div>
                        <div class="stat-icon bg-info text-white">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
        <div class="col-md-6 mb-4">
            <div class="report-card">
                <div class="card-header">
                    <h6><i class="fas fa-pie-chart me-2 text-primary"></i>Issues by Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="statusChart"></canvas>
                    </div>
                    <div class="row mt-3">
                        <?php foreach($issuesByStatus as $status): ?>
                            <div class="col-6 mb-2">
                                <span class="badge-status 
                                    <?php 
                                    switch($status['status']) {
                                        case 'To Do':
                                            echo 'bg-secondary';
                                            break;
                                        case 'In Progress':
                                            echo 'bg-warning text-dark';
                                            break;
                                        case 'In Review':
                                            echo 'bg-info';
                                            break;
                                        case 'Done':
                                            echo 'bg-success';
                                            break;
                                        case 'Closed':
                                            echo 'bg-dark';
                                            break;
                                    }
                                    ?>">
                                    <?= $status['status'] ?>: <?= $status['total'] ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="report-card">
                <div class="card-header">
                    <h6><i class="fas fa-chart-bar me-2 text-primary"></i>Issues by Priority</h6>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="priorityChart"></canvas>
                    </div>
                    <div class="row mt-3">
                        <?php foreach($issuesByPriority as $priority): ?>
                            <div class="col-6 mb-2">
                                <span class="badge-status 
                                    <?php 
                                    switch($priority['priority']) {
                                        case 'Highest':
                                            echo 'bg-danger';
                                            break;
                                        case 'High':
                                            echo 'bg-warning text-dark';
                                            break;
                                        case 'Medium':
                                            echo 'bg-info';
                                            break;
                                        case 'Low':
                                            echo 'bg-secondary';
                                            break;
                                        case 'Lowest':
                                            echo 'bg-light text-dark';
                                            break;
                                    }
                                    ?>">
                                    <?= $priority['priority'] ?>: <?= $priority['total'] ?>
                                </span>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="report-card">
                <div class="card-header">
                    <h6><i class="fas fa-bolt me-2 text-warning"></i>Quick Reports</h6>
                </div>
                <div class="card-body">
                    <div class="quick-report-item">
                        <a href="<?= base_url('admin/reports/projects') ?>">
                            <div class="quick-report-icon bg-primary text-white">
                                <i class="fas fa-project-diagram"></i>
                            </div>
                            <div>
                                <strong>Project Progress</strong>
                                <p class="mb-0 small text-muted">Lihat progress semua proyek</p>
                            </div>
                        </a>
                    </div>

                    <div class="quick-report-item">
                        <a href="<?= base_url('admin/reports/issues') ?>">
                            <div class="quick-report-icon bg-warning text-white">
                                <i class="fas fa-exclamation-circle"></i>
                            </div>
                            <div>
                                <strong>Issue Summary</strong>
                                <p class="mb-0 small text-muted">Statistik issues per status</p>
                            </div>
                        </a>
                    </div>

                    <div class="quick-report-item">
                        <a href="<?= base_url('admin/reports/team') ?>">
                            <div class="quick-report-icon bg-success text-white">
                                <i class="fas fa-users"></i>
                            </div>
                            <div>
                                <strong>Team Performance</strong>
                                <p class="mb-0 small text-muted">Kinerja staff per proyek</p>
                            </div>
                        </a>
                    </div>

                    <div class="quick-report-item">
                        <a href="<?= base_url('admin/reports/clients') ?>">
                            <div class="quick-report-icon bg-info text-white">
                                <i class="fas fa-building"></i>
                            </div>
                            <div>
                                <strong>Client Reports</strong>
                                <p class="mb-0 small text-muted">Progress proyek per client</p>
                            </div>
                        </a>
                    </div>

                    <div class="quick-report-item">
                        <a href="<?= base_url('admin/reports/export/issues') ?>">
                            <div class="quick-report-icon bg-secondary text-white">
                                <i class="fas fa-file-excel"></i>
                            </div>
                            <div>
                                <strong>Export Data</strong>
                                <p class="mb-0 small text-muted">Download laporan CSV</p>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        <div class="col-md-4 mb-4">
    <div class="report-card">
        <div class="card-header">
            <h6><i class="fas fa-clock me-2 text-danger"></i>Overdue Issues</h6>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php if(empty($overdueIssuesList)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <p class="text-muted">Tidak ada issue overdue</p>
                    </div>
                <?php else: ?>
                    <?php foreach($overdueIssuesList as $issue): ?>
                        <a href="<?= base_url('admin/issues/' . $issue['id']) ?>" class="list-group-item list-group-item-action">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <strong><?= $issue['title'] ?></strong>
                                    <br>
                                    <small class="text-muted">
                                        <i class="fas fa-project-diagram me-1"></i><?= $issue['project_name'] ?>
                                    </small>
                                </div>
                                <span class="badge bg-danger">
                                    <?= date('d M', strtotime($issue['due_date'])) ?>
                                </span>
                            </div>
                            <small class="text-danger">
                                <i class="fas fa-exclamation-triangle me-1"></i>
                                Overdue <?= floor((time() - strtotime($issue['due_date'])) / 86400) ?> hari
                            </small>
                        </a>
                    <?php endforeach; ?>
                    <div class="text-center p-3">
                        <a href="<?= base_url('admin/reports/issues?status=overdue') ?>" class="small">
                            Lihat semua >>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
            </div>
        </div>
<div class="col-md-4 mb-4">
    <div class="report-card">
        <div class="card-header">
            <h6><i class="fas fa-trophy me-2 text-warning"></i>Top Performers</h6>
        </div>
        <div class="card-body p-0">
            <div class="list-group list-group-flush">
                <?php if(empty($topStaff)): ?>
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Belum ada data</p>
                    </div>
                <?php else: ?>
                    <?php foreach($topStaff as $staff): ?>
                        <div class="list-group-item">
                            <div class="d-flex align-items-center">
                                <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" 
                                     style="width: 40px; height: 40px;">
                                    <?= strtoupper(substr($staff['first_name'] ?? $staff['username'], 0, 1)) ?>
                                </div>
                                <div class="flex-grow-1">
                                    <strong><?= $staff['first_name'] ?? $staff['username'] ?> <?= $staff['last_name'] ?? '' ?></strong>
                                    <br>
                                    <small class="text-muted"><?= $staff['position_name'] ?? 'Staff' ?></small>
                                </div>
                                <div class="text-center">
                                    <span class="badge bg-success"><?= $staff['completed'] ?></span>
                                    <br>
                                    <small class="text-muted">tasks</small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const statusCtx = document.getElementById('statusChart').getContext('2d');
new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: <?= json_encode(array_column($issuesByStatus, 'status')) ?>,
        datasets: [{
            data: <?= json_encode(array_column($issuesByStatus, 'total')) ?>,
            backgroundColor: [
                '#6c757d', 
                '#ffc107', 
                '#17a2b8', 
                '#28a745',
                '#343a40'  
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const priorityCtx = document.getElementById('priorityChart').getContext('2d');
new Chart(priorityCtx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($issuesByPriority, 'priority')) ?>,
        datasets: [{
            label: 'Jumlah Issues',
            data: <?= json_encode(array_column($issuesByPriority, 'total')) ?>,
            backgroundColor: [
                '#dc3545', 
                '#fd7e14', 
                '#ffc107', 
                '#6c757d', 
                '#adb5bd'  
            ],
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});

function exportReport() {
    window.location.href = '<?= base_url("admin/reports/export/summary") ?>';
}

function printReport() {
    window.print();
}

setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>