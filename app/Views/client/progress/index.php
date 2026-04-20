<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .stats-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: transform 0.3s;
    }
    .stats-card:hover {
        transform: translateY(-5px);
    }
    .progress-circle {
        width: 120px;
        height: 120px;
        margin: 0 auto;
    }
    .project-progress-card {
        border-left: 4px solid;
        margin-bottom: 15px;
        transition: all 0.3s;
    }
    .project-progress-card:hover {
        transform: translateX(5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .progress {
        height: 8px;
        border-radius: 4px;
    }
    .status-open { border-left-color: #e74a3b; }
    .status-progress { border-left-color: #f6c23e; }
    .status-done { border-left-color: #1cc88a; }
</style>

<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">
            <i class="fas fa-chart-line me-2 text-primary"></i>
            Progress Report
        </h1>
        <div class="text-muted">
            <i class="fas fa-calendar-alt me-1"></i>
            <?= date('d F Y') ?>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Statistik Cards -->
    <div class="row">
        <div class="col-md-3">
            <div class="stats-card text-center">
                <i class="fas fa-briefcase fa-2x text-info mb-2"></i>
                <h2 class="mb-0"><?= $totalProjects ?></h2>
                <small class="text-muted">Total Proyek</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <i class="fas fa-chart-simple fa-2x text-success mb-2"></i>
                <h2 class="mb-0"><?= $averageProgress ?>%</h2>
                <small class="text-muted">Rata-rata Progress</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <i class="fas fa-tasks fa-2x text-warning mb-2"></i>
                <h2 class="mb-0"><?= $totalIssuesAll ?></h2>
                <small class="text-muted">Total Kendala</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stats-card text-center">
                <i class="fas fa-check-circle fa-2x text-primary mb-2"></i>
                <h2 class="mb-0"><?= $overallCompletion ?>%</h2>
                <small class="text-muted">Penyelesaian Keseluruhan</small>
            </div>
        </div>
    </div>

    <!-- Grafik Progress Bulanan -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-chart-line me-2 text-info"></i>
                Tren Progress 6 Bulan Terakhir
            </h5>
        </div>
        <div class="card-body">
            <canvas id="progressChart" height="80"></canvas>
        </div>
    </div>

    <!-- Daftar Progress Proyek -->
    <div class="card">
        <div class="card-header bg-white">
            <h5 class="mb-0">
                <i class="fas fa-project-diagram me-2 text-primary"></i>
                Progress Per Proyek
            </h5>
        </div>
        <div class="card-body">
            <?php if(empty($projects)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada proyek</p>
                </div>
            <?php else: ?>
                <?php foreach($projects as $project): ?>
                    <?php
                    $statusClass = '';
                    if($project['progress'] >= 75) $statusClass = 'status-done';
                    elseif($project['progress'] >= 25) $statusClass = 'status-progress';
                    else $statusClass = 'status-open';
                    ?>
                    <div class="project-progress-card card <?= $statusClass ?>">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-4">
                                    <h6 class="mb-1"><?= esc($project['project_name']) ?></h6>
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <?= date('d M Y', strtotime($project['start_date'])) ?> - 
                                        <?= $project['end_date'] ? date('d M Y', strtotime($project['end_date'])) : 'Ongoing' ?>
                                    </small>
                                </div>
                                <div class="col-md-5">
                                    <div class="d-flex justify-content-between mb-1">
                                        <small>Progress</small>
                                        <small class="fw-bold text-primary"><?= $project['progress'] ?>%</small>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" style="width: <?= $project['progress'] ?>%"></div>
                                    </div>
                                    <div class="d-flex justify-content-between mt-2">
                                        <small class="text-muted">
                                            <i class="fas fa-check-circle text-success me-1"></i>
                                            Selesai: <?= $project['completed_issues'] ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="fas fa-clock text-warning me-1"></i>
                                            Tertunda: <?= $project['open_issues'] ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <a href="<?= base_url('client/progress/detail/' . $project['id']) ?>" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-chart-line me-1"></i> Detail Progress
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Grafik Progress Bulanan
const ctx = document.getElementById('progressChart').getContext('2d');
const monthlyData = <?= json_encode($monthlyProgress) ?>;

const labels = monthlyData.map(item => {
    const [year, month] = item.month.split('-');
    const monthNames = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
    return monthNames[parseInt(month) - 1] + ' ' + year;
});

const totalData = monthlyData.map(item => item.total);
const completedData = monthlyData.map(item => item.completed);

new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Total Kendala',
                data: totalData,
                borderColor: '#e74a3b',
                backgroundColor: 'rgba(231, 74, 59, 0.1)',
                tension: 0.3,
                fill: true
            },
            {
                label: 'Kendala Selesai',
                data: completedData,
                borderColor: '#1cc88a',
                backgroundColor: 'rgba(28, 200, 138, 0.1)',
                tension: 0.3,
                fill: true
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        plugins: {
            legend: {
                position: 'top',
            }
        }
    }
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