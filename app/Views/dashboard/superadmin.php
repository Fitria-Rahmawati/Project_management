<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    :root {
        --primary: #4e73df;
        --success: #1cc88a;
        --warning: #f6c23e;
        --info: #36b9cc;
        --danger: #e74a3b;
        --dark-text: #5a5c69;
        --light-text: #b7b9cc;
    }

    .dashboard-content {
        padding: 30px;
        background-color: #f8f9fc;
        min-height: 100vh;
        font-family: 'Nunito', sans-serif;
    }

    .welcome-text {
        color: var(--dark-text);
        font-weight: 700;
        margin-bottom: 5px;
        font-size: 1.75rem;
    }

    .role-badge {
        font-size: 0.5em;
        vertical-align: middle;
        background: #eaecf4;
        color: var(--primary);
        padding: 4px 12px;
        border-radius: 20px;
        margin-left: 10px;
    }

    .subtitle {
        color: #858796;
        margin-bottom: 0;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        gap: 20px;
        margin: 25px 0;
    }

    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        border-left: 5px solid;
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-3px);
    }

    .stat-card.companies { border-left-color: var(--primary); }
    .stat-card.users { border-left-color: var(--success); }
    .stat-card.active { border-left-color: var(--warning); }
    .stat-card.projects { border-left-color: var(--info); }

    .stat-info .stat-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        margin-bottom: 8px;
    }

    .stat-label.blue { color: var(--primary); }
    .stat-label.green { color: var(--success); }
    .stat-label.yellow { color: var(--warning); }
    .stat-label.cyan { color: var(--info); }

    .stat-number {
        font-size: 1.8rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
        line-height: 1.2;
    }

    .stat-icon {
        font-size: 2.5rem;
        color: #dddfeb;
        opacity: 0.8;
    }
    .section-title {
        margin: 35px 0 20px 0;
        font-weight: 700;
        color: var(--dark-text);
        font-size: 1.25rem;
    }

    .section-title i {
        color: var(--primary);
        margin-right: 8px;
    }

    .shortcut-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .btn-quick {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 25px 15px;
        background: white;
        border-radius: 12px;
        text-decoration: none;
        color: var(--dark-text);
        font-weight: 600;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .btn-quick:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
        transform: translateY(-3px);
    }

    .btn-quick i {
        font-size: 2rem;
        margin-bottom: 12px;
    }

    .btn-quick:hover i {
        color: white;
    }

    .btn-quick span {
        font-size: 0.9rem;
    }
    .recent-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .recent-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        overflow: hidden;
    }

    .recent-header {
        padding: 15px 20px;
        background: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
        font-weight: 700;
        color: var(--dark-text);
    }

    .recent-header i {
        color: var(--primary);
        margin-right: 8px;
    }

    .recent-list {
        padding: 0;
        margin: 0;
        list-style: none;
    }

    .recent-item {
        padding: 12px 20px;
        border-bottom: 1px solid #f0f0f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background 0.2s ease;
    }

    .recent-item:hover {
        background: #f8f9fc;
    }

    .recent-item .item-info {
        flex: 1;
    }

    .recent-item .item-title {
        font-weight: 600;
        color: var(--dark-text);
        margin-bottom: 4px;
    }

    .recent-item .item-meta {
        font-size: 0.7rem;
        color: #858796;
    }

    .recent-item .item-badge {
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
    }

    .badge-active { background: #e3f9e9; color: var(--success); }
    .badge-inactive { background: #fee2e2; color: var(--danger); }
    .badge-pending { background: #fff3e0; color: var(--warning); }

    .view-all {
        padding: 12px 20px;
        text-align: center;
        background: #f8f9fc;
    }

    .view-all a {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.85rem;
        font-weight: 600;
    }

    .view-all a:hover {
        text-decoration: underline;
    }

    @media (max-width: 768px) {
        .dashboard-content {
            padding: 20px;
        }
        .welcome-text {
            font-size: 1.5rem;
        }
        .stats-grid {
            grid-template-columns: 1fr;
        }
        .shortcut-grid {
            grid-template-columns: repeat(2, 1fr);
        }
        .recent-grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<main class="dashboard-content">

    <div class="d-flex justify-content-between align-items-center flex-wrap mb-4">
        <div>
            <h2 class="welcome-text">
                Welcome, <?= $username ?? 'Super Admin' ?>
                <span class="role-badge"><?= strtoupper($role ?? 'SUPERADMIN') ?></span>
            </h2>
            <p class="subtitle">Berikut adalah ringkasan data sistem Anda hari ini.</p>
        </div>
        <div class="mt-2 mt-md-0">
            <span class="text-muted">
                <i class="fas fa-calendar-alt me-1"></i> <?= date('l, d F Y') ?>
            </span>
        </div>
    </div>

    <div class="stats-grid">
        <div class="stat-card companies">
            <div class="stat-info">
                <div class="stat-label blue">TOTAL COMPANIES</div>
                <div class="stat-number"><?= $totalCompanies ?? 0 ?></div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-building"></i>
            </div>
        </div>

        <div class="stat-card users">
            <div class="stat-info">
                <div class="stat-label green">TOTAL USERS</div>
                <div class="stat-number"><?= $totalUsers ?? 0 ?></div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>

        <div class="stat-card active">
            <div class="stat-info">
                <div class="stat-label yellow">ACTIVE USERS</div>
                <div class="stat-number"><?= $activeUsers ?? 0 ?></div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>

        <div class="stat-card projects">
            <div class="stat-info">
                <div class="stat-label cyan">TOTAL PROJECTS</div>
                <div class="stat-number"><?= $totalProjects ?? 0 ?></div>
            </div>
            <div class="stat-icon">
                <i class="fas fa-project-diagram"></i>
            </div>
        </div>
    </div>

    <div class="section-title">
        <i class="fas fa-bolt"></i> Quick Access
    </div>
    <div class="shortcut-grid">
        <a href="<?= base_url('superadmin/companies') ?>" class="btn-quick">
            <i class="fas fa-building text-primary"></i>
            <span>Companies</span>
        </a>
        <a href="<?= base_url('superadmin/users') ?>" class="btn-quick">
            <i class="fas fa-user-cog text-success"></i>
            <span>Users</span>
        </a>
        <a href="<?= base_url('superadmin/roles') ?>" class="btn-quick">
            <i class="fas fa-shield-alt text-warning"></i>
            <span>Role & Permissions</span>
        </a>
        <a href="<?= base_url('superadmin/monitoring') ?>" class="btn-quick">
            <i class="fas fa-chart-line text-info"></i>
            <span>Monitoring</span>
        </a>
        <a href="<?= base_url('superadmin/settings') ?>" class="btn-quick">
            <i class="fas fa-cog text-secondary"></i>
            <span>Settings</span>
        </a>
    </div>

    <div class="section-title">
        <i class="fas fa-history"></i> Recent Activity
    </div>
    <div class="recent-grid">
    
        <div class="recent-card">
            <div class="recent-header">
                <i class="fas fa-user-plus"></i> New Users
            </div>
            <ul class="recent-list">
                <?php if(!empty($recentUsers) && count($recentUsers) > 0): ?>
                    <?php foreach($recentUsers as $user): ?>
                        <li class="recent-item">
                            <div class="item-info">
                                <div class="item-title"><?= $user['username'] ?? '-' ?></div>
                                <div class="item-meta">
                                    <i class="fas fa-envelope me-1"></i> <?= $user['email'] ?? '-' ?>
                                </div>
                            </div>
                            <span class="item-badge badge-<?= ($user['status'] ?? 'active') == 'active' ? 'active' : 'inactive' ?>">
                                <?= ($user['status'] ?? 'active') == 'active' ? 'Active' : 'Inactive' ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="recent-item">
                        <div class="item-info text-muted text-center w-100">
                            Belum ada user baru
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="view-all">
                <a href="<?= base_url('superadmin/users') ?>">View All Users →</a>
            </div>
        </div>

        <div class="recent-card">
            <div class="recent-header">
                <i class="fas fa-building"></i> New Companies
            </div>
            <ul class="recent-list">
                <?php if(!empty($recentCompanies) && count($recentCompanies) > 0): ?>
                    <?php foreach($recentCompanies as $company): ?>
                        <li class="recent-item">
                            <div class="item-info">
                                <div class="item-title"><?= $company['company_name'] ?? '-' ?></div>
                                <div class="item-meta">
                                    <i class="fas fa-envelope me-1"></i> <?= $company['email'] ?? '-' ?>
                                </div>
                            </div>
                            <span class="item-badge badge-<?= ($company['status'] ?? 'active') == 'active' ? 'active' : 'inactive' ?>">
                                <?= ($company['status'] ?? 'active') == 'active' ? 'Active' : 'Inactive' ?>
                            </span>
                        </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="recent-item">
                        <div class="item-info text-muted text-center w-100">
                            Belum ada company baru
                        </div>
                    </li>
                <?php endif; ?>
            </ul>
            <div class="view-all">
                <a href="<?= base_url('superadmin/companies') ?>">View All Companies →</a>
            </div>
        </div>
    </div>

</main>

<?= $this->endSection() ?>