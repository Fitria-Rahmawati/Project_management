<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .progress-header {
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        padding: 25px;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
    }
    .stat-box {
        background: white;
        border-radius: 12px;
        padding: 15px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .priority-high { background: #e74a3b; color: white; }
    .priority-medium { background: #f6c23e; color: #333; }
    .priority-low { background: #1cc88a; color: white; }
    .timeline-item {
        border-left: 2px solid #e0e0e0;
        padding-left: 20px;
        margin-bottom: 20px;
        position: relative;
    }
    .timeline-item::before {
        content: '';
        position: absolute;
        left: -6px;
        top: 0;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #36b9cc;
    }
</style>

<div class="container-fluid">
    <!-- Tombol Kembali -->
    <div class="mb-3">
        <a href="<?= base_url('client/progress') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali ke Progress Report
        </a>
    </div>
<a href="<?= base_url('client/export-progress') ?>" class="btn btn-danger" target="_blank">
    <i class="fas fa-file-pdf me-2"></i> Export PDF
</a>
    <!-- Header -->
    <div class="progress-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1"><?= esc($project['project_name']) ?></h3>
                <p class="mb-0 opacity-75">Progress Detail</p>
            </div>
            <div class="text-center">
                <h2 class="mb-0"><?= $project['progress'] ?>%</h2>
                <small>Progress</small>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-tasks fa-2x text-primary mb-2"></i>
                <h3 class="mb-0"><?= $project['total_issues'] ?></h3>
                <small class="text-muted">Total Kendala</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-check-circle fa-2x text-success mb-2"></i>
                <h3 class="mb-0"><?= $project['completed_issues'] ?></h3>
                <small class="text-muted">Kendala Selesai</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-clock fa-2x text-warning mb-2"></i>
                <h3 class="mb-0"><?= $project['open_issues'] ?></h3>
                <small class="text-muted">Kendala Aktif</small>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-box">
                <i class="fas fa-calendar fa-2x text-info mb-2"></i>
                <h3 class="mb-0"><?= date('d/m/Y', strtotime($project['start_date'])) ?></h3>
                <small class="text-muted">Tanggal Mulai</small>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Chart Kendala per Status -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Kendala Berdasarkan Status</h6>
                </div>
                <div class="card-body">
                    <canvas id="statusChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Chart Kendala per Prioritas -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-white">
                    <h6 class="mb-0">Kendala Berdasarkan Prioritas</h6>
                </div>
                <div class="card-body">
                    <canvas id="priorityChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Timeline Aktivitas -->
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">
                <i class="fas fa-history me-2 text-info"></i>
                Timeline Aktivitas
            </h6>
        </div>
        <div class="card-body">
            <?php if(empty($timeline)): ?>
                <p class="text-muted text-center mb-0">Belum ada aktivitas</p>
            <?php else: ?>
                <?php foreach($timeline as $item): ?>
                    <div class="timeline-item">
                        <small class="text-muted"><?= date('d M Y H:i', strtotime($item['date'])) ?></small>
                        <p class="mb-0">
                            <?php if($item['type'] == 'issue'): ?>
                                <i class="fas fa-bug text-danger me-2"></i>
                            <?php else: ?>
                                <i class="fas fa-comment text-info me-2"></i>
                            <?php endif; ?>
                            <?= esc($item['description']) ?>
                        </p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Daftar Kendala -->
    <div class="card">
        <div class="card-header bg-white d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <i class="fas fa-list me-2 text-primary"></i>
                Daftar Kendala
            </h6>
            <a href="<?= base_url('client/issues/create?project_id=' . $project['id']) ?>" class="btn btn-danger btn-sm">
                <i class="fas fa-plus me-1"></i> Lapor Kendala
            </a>
        </div>
        <div class="card-body">
            <?php if(empty($issues)): ?>
                <p class="text-muted text-center mb-0">Belum ada kendala</p>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Prioritas</th>
                                <th>Status</th>
                                <th>Penerima</th>
                                <th>Deadline</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($issues as $issue): ?>
                                <tr>
                                    <td><?= esc($issue['title']) ?></td>
                                    <td>
                                        <span class="badge <?= $issue['priority'] == 'high' ? 'bg-danger' : ($issue['priority'] == 'medium' ? 'bg-warning' : 'bg-success') ?>">
                                            <?= ucfirst($issue['priority']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge <?= $issue['status'] == 'Done' ? 'bg-success' : ($issue['status'] == 'in_progress' ? 'bg-warning' : 'bg-secondary') ?>">
                                            <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                                        </span>
                                    </td>
                                    <td><?= $issue['assignee_name'] ?? '-' ?></td>
                                    <td><?= $issue['due_date'] ? date('d/m/Y', strtotime($issue['due_date'])) : '-' ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Chart Status
const statusCtx = document.getElementById('statusChart').getContext('2d');
const statusData = <?= json_encode($issuesByStatus) ?>;
const statusLabels = statusData.map(item => item.status);
const statusValues = statusData.map(item => item.total);

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: statusLabels,
        datasets: [{
            data: statusValues,
            backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a', '#36b9cc', '#858796']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true
    }
});

// Chart Priority
const priorityCtx = document.getElementById('priorityChart').getContext('2d');
const priorityData = <?= json_encode($issuesByPriority) ?>;
const priorityLabels = priorityData.map(item => item.priority);
const priorityValues = priorityData.map(item => item.total);

new Chart(priorityCtx, {
    type: 'bar',
    data: {
        labels: priorityLabels,
        datasets: [{
            label: 'Jumlah Kendala',
            data: priorityValues,
            backgroundColor: ['#e74a3b', '#f6c23e', '#1cc88a'],
            borderRadius: 5
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: true,
        scales: {
            y: {
                beginAtZero: true,
                stepSize: 1
            }
        }
    }
});
</script>

<?= $this->endSection() ?>