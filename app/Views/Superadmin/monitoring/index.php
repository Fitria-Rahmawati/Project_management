<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary: #4e73df;
        --success: #1cc88a;
        --warning: #f6c23e;
        --danger: #e74a3b;
        --info: #36b9cc;
        --dark-text: #5a5c69;
    }

    .monitoring-content {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
    }

    .page-title {
        font-weight: 700;
        color: var(--dark-text);
        margin-bottom: 5px;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin: 25px 0;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        border-bottom: 3px solid;
    }

    .stat-card.blue { border-bottom-color: var(--primary); }
    .stat-card.green { border-bottom-color: var(--success); }
    .stat-card.yellow { border-bottom-color: var(--warning); }
    .stat-card.red { border-bottom-color: var(--danger); }

    .stat-number {
        font-size: 2rem;
        font-weight: 700;
        color: var(--dark-text);
    }

    .stat-label {
        font-size: 0.8rem;
        color: #858796;
        margin-top: 5px;
    }

    .monitoring-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .monitoring-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        overflow: hidden;
    }

    .card-header {
        padding: 15px 20px;
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        font-weight: 700;
        color: var(--dark-text);
    }

    .card-header i {
        color: var(--primary);
        margin-right: 8px;
    }

    .card-body {
        padding: 0;
    }

    .list-item {
        padding: 12px 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .list-item:hover {
        background: #f8f9fc;
    }

    .badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-success { background: #e3f9e9; color: var(--success); }
    .badge-warning { background: #fff3e0; color: var(--warning); }
    .badge-danger { background: #fee2e2; color: var(--danger); }
    .badge-info { background: #e1f5fe; color: var(--info); }

    .progress-bar {
        width: 100%;
        height: 8px;
        background: #e3e6f0;
        border-radius: 10px;
        overflow: hidden;
        margin-top: 8px;
    }

    .progress-fill {
        height: 100%;
        background: var(--success);
        border-radius: 10px;
        transition: width 0.3s ease;
    }

    @media (max-width: 768px) {
        .monitoring-content {
            padding: 20px;
        }
        .monitoring-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<main class="monitoring-content">
    
    <h2 class="page-title">
        <i class="fas fa-chart-line me-2 text-primary"></i> Monitoring Sistem
    </h2>
    <p class="text-muted">Pantau seluruh aktivitas dan performa sistem</p>

    <div class="stats-grid">
        <div class="stat-card blue">
            <div class="stat-number"><?= $totalProjects ?? 0 ?></div>
            <div class="stat-label">Total Proyek</div>
        </div>
        <div class="stat-card green">
            <div class="stat-number"><?= $totalIssues ?? 0 ?></div>
            <div class="stat-label">Total Issues</div>
        </div>
        <div class="stat-card yellow">
            <div class="stat-number"><?= $totalUsers ?? 0 ?></div>
            <div class="stat-label">Total Users</div>
        </div>
        <div class="stat-card red">
            <div class="stat-number"><?= $totalCompanies ?? 0 ?></div>
            <div class="stat-label">Total Companies</div>
        </div>
    </div>

    <div class="monitoring-grid">
   
        <div class="monitoring-card">
            <div class="card-header">
                <i class="fas fa-chart-pie"></i> Proyek by Status
            </div>
            <div class="card-body">
                <?php if(empty($projectsByStatus)): ?>
                    <div class="list-item text-center text-muted">Belum ada data</div>
                <?php else: ?>
                    <?php foreach($projectsByStatus as $status): ?>
                    <div class="list-item">
                        <span><?= $status['status'] ?? 'Unknown' ?></span>
                        <span class="badge badge-info"><?= $status['total'] ?> proyek</span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="monitoring-card">
            <div class="card-header">
                <i class="fas fa-exclamation-circle"></i> Issues by Status
            </div>
            <div class="card-body">
                <?php if(empty($issuesByStatus)): ?>
                    <div class="list-item text-center text-muted">Belum ada data</div>
                <?php else: ?>
                    <?php foreach($issuesByStatus as $status): ?>
                    <div class="list-item">
                        <span><?= $status['status'] ?? 'Unknown' ?></span>
                        <span class="badge <?= $status['status'] == 'Done' ? 'badge-success' : ($status['status'] == 'In Progress' ? 'badge-warning' : 'badge-danger') ?>">
                            <?= $status['total'] ?> issues
                        </span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="monitoring-card">
            <div class="card-header">
                <i class="fas fa-flag"></i> Issues by Priority
            </div>
            <div class="card-body">
                <?php if(empty($issuesByPriority)): ?>
                    <div class="list-item text-center text-muted">Belum ada data</div>
                <?php else: ?>
                    <?php foreach($issuesByPriority as $priority): ?>
                    <div class="list-item">
                        <span><?= $priority['priority'] ?? 'Unknown' ?></span>
                        <span class="badge <?= $priority['priority'] == 'High' ? 'badge-danger' : ($priority['priority'] == 'Medium' ? 'badge-warning' : 'badge-success') ?>">
                            <?= $priority['total'] ?> issues
                        </span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="monitoring-card">
            <div class="card-header">
                <i class="fas fa-users"></i> User Activity
            </div>
            <div class="card-body">
                <div class="list-item">
                    <span>Total Users</span>
                    <span class="badge badge-info"><?= $userActivityStats['total'] ?? 0 ?></span>
                </div>
                <div class="list-item">
                    <span>Active Users</span>
                    <span class="badge badge-success"><?= $userActivityStats['active'] ?? 0 ?></span>
                </div>
                <div class="list-item">
                    <span>Inactive Users</span>
                    <span class="badge badge-danger"><?= $userActivityStats['inactive'] ?? 0 ?></span>
                </div>
                <div class="list-item">
                    <span>Active Rate</span>
                    <span class="badge badge-info"><?= $userActivityStats['active_percentage'] ?? 0 ?>%</span>
                </div>
            </div>
        </div>
    </div>

    <div class="monitoring-grid" style="margin-top: 20px;">
  
        <div class="monitoring-card">
            <div class="card-header">
                <i class="fas fa-clock text-danger"></i> Overdue Issues
            </div>
            <div class="card-body">
                <?php if(empty($overdueIssues)): ?>
                    <div class="list-item text-center text-muted">
                        Tidak ada issue terlambat
                    </div>
                <?php else: ?>
                    <?php foreach(array_slice($overdueIssues, 0, 5) as $issue): ?>
                    <div class="list-item">
                        <div>
                            <div class="fw-bold"><?= $issue['title'] ?? '-' ?></div>
                            <small class="text-muted"><?= $issue['project_name'] ?? '-' ?> | Assignee: <?= $issue['assignee_name'] ?? '-' ?></small>
                        </div>
                        <span class="badge badge-danger">Due: <?= date('d/m/Y', strtotime($issue['due_date'])) ?></span>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <div class="monitoring-card">
            <div class="card-header">
                <i class="fas fa-trophy text-warning"></i> Top Performing Staff
            </div>
            <div class="card-body">
                <?php if(empty($topStaff)): ?>
                    <div class="list-item text-center text-muted">
                        Belum ada data
                    </div>
                <?php else: ?>
                    <?php foreach($topStaff as $staff): ?>
                    <div class="list-item">
                        <div>
                            <div class="fw-bold"><?= ($staff['first_name'] ?? $staff['username']) . ' ' . ($staff['last_name'] ?? '') ?></div>
                            <small class="text-muted"><?= $staff['position_name'] ?? 'Staff' ?></small>
                        </div>
                        <div class="text-end">
                            <div><?= $staff['completed_issues'] ?? 0 ?> / <?= $staff['total_issues'] ?? 0 ?></div>
                            <div class="progress-bar" style="width: 80px;">
                                <div class="progress-fill" style="width: <?= ($staff['total_issues'] ?? 0) > 0 ? round((($staff['completed_issues'] ?? 0) / ($staff['total_issues'] ?? 1)) * 100) : 0 ?>%"></div>
                            </div>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="monitoring-card" style="margin-top: 20px;">
        <div class="card-header">
            <i class="fas fa-chart-line"></i> Project Progress
        </div>
        <div class="card-body">
            <?php if(empty($projectProgress)): ?>
                <div class="list-item text-center text-muted">Belum ada data proyek</div>
            <?php else: ?>
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Project</th>
                            <th>Company</th>
                            <th>Progress</th>
                            <th>Status</th>
                        </thead>
                    <tbody>
                        <?php foreach($projectProgress as $project): ?>
                         <tr>
                            <td><?= $project['project_name'] ?></td>
                            <td><?= $project['company_name'] ?? '-' ?></td>
                            <td>
                                <?php 
                                $total = $project['total_issues'];
                                $completed = $project['completed_issues'];
                                $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
                                ?>
                                <div class="d-flex align-items-center">
                                    <div class="progress-bar flex-grow-1 me-2" style="width: 100px;">
                                        <div class="progress-fill" style="width: <?= $percentage ?>%"></div>
                                    </div>
                                    <span><?= $percentage ?>%</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge <?= $project['status'] == 'Done' ? 'badge-success' : ($project['status'] == 'In Progress' ? 'badge-warning' : 'badge-danger') ?>">
                                    <?= $project['status'] ?? 'Unknown' ?>
                                </span>
                            </td>
                         </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>

</main>

<?= $this->endSection() ?>