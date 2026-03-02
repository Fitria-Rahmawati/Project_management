<style>
    :root {
        --primary: #4e73df;
        --success: #1cc88a;
        --warning: #f6c23e;
        --info: #36b9cc;
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

    /* Grid System */
    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-top: 25px;
    }

    /* Card Styling */
    .stat-card {
        background: white;
        border-radius: 12px;
        padding: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
        border-left: 5px solid;
        transition: transform 0.2s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-card.companies { border-left-color: var(--primary); }
    .stat-card.users { border-left-color: var(--success); }
    .stat-card.active { border-left-color: var(--warning); }

    .stat-label {
        font-size: 0.7rem;
        font-weight: 800;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .stat-label.blue { color: var(--primary); }
    .stat-label.green { color: var(--success); }
    .stat-label.yellow { color: var(--warning); }

    .stat-number {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--dark-text);
        margin: 0;
    }

    /* Quick Access */
    .section-title {
        margin-top: 45px;
        font-weight: 700;
        color: var(--dark-text);
    }

    .shortcut-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
        gap: 15px;
        margin-top: 20px;
    }

    .btn-quick {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: white;
        border-radius: 10px;
        text-decoration: none;
        color: var(--dark-text);
        font-weight: 600;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        border: 1px solid #e3e6f0;
        transition: all 0.3s ease;
    }

    .btn-quick:hover {
        background: var(--primary);
        color: white;
        border-color: var(--primary);
    }

    .btn-quick i {
        font-size: 1.5rem;
        margin-bottom: 10px;
    }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<main class="dashboard-content">

    <h2 class="welcome-text">
        Welcome, <?= $username ?> 
        <span class="role-badge"><?= strtoupper($role) ?></span>
    </h2>
    <p class="text-muted">Berikut adalah ringkasan data sistem Anda hari ini.</p>

    <div class="stats-grid">
        <div class="stat-card companies">
            <div>
                <div class="stat-label blue">Total Companies</div>
                <div class="stat-number"><?= $totalCompanies ?></div>
            </div>
            <i class="fas fa-building fa-2x" style="color: #dddfeb;"></i>
        </div>

        <div class="stat-card users">
            <div>
                <div class="stat-label green">Total Users</div>
                <div class="stat-number"><?= $totalUsers ?></div>
            </div>
            <i class="fas fa-users fa-2x" style="color: #dddfeb;"></i>
        </div>

        <div class="stat-card active">
            <div>
                <div class="stat-label yellow">Active Users</div>
                <div class="stat-number"><?= $activeUsers ?></div>
            </div>
            <i class="fas fa-user-check fa-2x" style="color: #dddfeb;"></i>
        </div>
    </div>

    <h4 class="section-title">Quick Access</h4>
    <div class="shortcut-grid">
        <a href="<?= base_url('superadmin/companies') ?>" class="btn-quick">
            <i class="fas fa-city text-primary"></i>
            Companies
        </a>
        <a href="<?= base_url('superadmin/users') ?>" class="btn-quick">
            <i class="fas fa-user-cog text-success"></i>
            Users
        </a>
        <a href="<?= base_url('superadmin/roles') ?>" class="btn-quick">
            <i class="fas fa-shield-alt text-warning"></i>
            Role & Permissions
        </a>
        <a href="<?= base_url('superadmin/projects') ?>" class="btn-quick">
            <i class="fas fa-project-diagram text-info"></i>
            Monitoring
        </a>
    </div>

</main>