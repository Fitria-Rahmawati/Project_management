<style>
    /* Dashboard Specific Styles */
    .admin-header {
        margin-bottom: 30px;
    }
    
    .admin-header h2 {
        color: #2d3436;
        font-weight: 700;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .badge-admin {
        background: #1cc88a;
        color: white;
        font-size: 0.4em;
        padding: 5px 12px;
        border-radius: 50px;
        vertical-align: middle;
        text-transform: uppercase;
    }

    /* Card Styling */
    .dashboard-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }

    .card-stat {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 4px solid transparent;
        transition: all 0.3s ease;
    }

    .card-stat:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    }

    .stat-content h4 {
        margin: 0;
        font-size: 0.85rem;
        color: #b2bec3;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .stat-content .number {
        font-size: 2rem;
        font-weight: 800;
        color: #2d3436;
        margin: 5px 0;
    }

    .stat-icon {
        font-size: 2.5rem;
        opacity: 0.2;
    }

    /* Color Variants */
    .card-projects { border-bottom-color: #4e73df; }
    .card-employees { border-bottom-color: #1cc88a; }
    .card-active { border-bottom-color: #f6c23e; }
    .card-progress { border-bottom-color: #36b9cc; }

    /* Shortcut Buttons */
    .admin-shortcuts {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(180px, 1fr));
        gap: 15px;
    }

    .btn-admin-shortcut {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-decoration: none;
        color: #2d3436;
        font-weight: 600;
        text-align: center;
        border: 1px solid #dfe6e9;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 10px;
    }

    .btn-admin-shortcut:hover {
        background: #4e73df;
        color: white;
        border-color: #4e73df;
    }

    .btn-admin-shortcut i {
        font-size: 1.5rem;
    }
</style>

<div class="admin-header">
    <h2>
        Welcome, <?= $username ?> 
        <span class="badge-admin">Admin Perusahaan</span>
    </h2>
    <p class="text-muted">Pantau operasional tim dan status proyek Anda dari sini.</p>
</div>

<div class="dashboard-cards">
    <div class="card-stat card-projects">
        <div class="stat-content">
            <h4>Total Projects</h4>
            <div class="number"><?= $totalProjects ?></div>
        </div>
        <i class="fas fa-layer-group stat-icon text-primary"></i>
    </div>

    <div class="card-stat card-employees">
        <div class="stat-content">
            <h4>Total Employees</h4>
            <div class="number"><?= $totalEmployees ?></div>
        </div>
        <i class="fas fa-users stat-icon text-success"></i>
    </div>

    <div class="card-stat card-active">
        <div class="stat-content">
            <h4>Active Now</h4>
            <div class="number"><?= $activeEmployees ?></div>
        </div>
        <i class="fas fa-user-check stat-icon text-warning"></i>
    </div>

    <div class="card-stat card-progress">
        <div class="stat-content">
            <h4>In Progress</h4>
            <div class="number"><?= $inProgressProjects ?></div>
        </div>
        <i class="fas fa-spinner fa-spin stat-icon text-info"></i>
    </div>
</div>

<h4 class="mb-3 fw-bold" style="color: #2d3436;">Manajemen Cepat</h4>
<div class="admin-shortcuts">
    <a href="<?= base_url('admin/projects') ?>" class="btn-admin-shortcut">
        <i class="fas fa-folder-open"></i>
        <span>Proyek</span>
    </a>
    <a href="<?= base_url('admin/teams') ?>" class="btn-admin-shortcut">
        <i class="fas fa-users-cog"></i>
        <span>Tim Projek</span>
    </a>
    <a href="<?= base_url('admin/issues') ?>" class="btn-admin-shortcut">
        <i class="fas fa-exclamation-triangle"></i>
        <span>Laporan Isu</span>
    </a>
    <a href="<?= base_url('admin/reports') ?>" class="btn-admin-shortcut">
        <i class="fas fa-file-invoice"></i>
        <span>Laporan Kerja</span>
    </a>
</div>