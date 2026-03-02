<style>
    /* Staff Dashboard Styles */
    .staff-header {
        margin-bottom: 30px;
    }

    .staff-header h2 {
        font-weight: 700;
        color: #2d3436;
    }

    .badge-staff {
        background: #f6c23e;
        color: #fff;
        font-size: 0.4em;
        padding: 5px 12px;
        border-radius: 50px;
        vertical-align: middle;
        text-transform: uppercase;
    }

    /* Stats Grid */
    .stats-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .staff-stat-card {
        background: white;
        padding: 20px;
        border-radius: 12px;
        border-left: 5px solid #f6c23e;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .staff-stat-card i {
        font-size: 2rem;
        color: #f6c23e;
        opacity: 0.5;
    }

    .stat-text h3 {
        margin: 0;
        font-size: 1.5rem;
        font-weight: 800;
    }

    .stat-text small {
        color: #b2bec3;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.7rem;
    }

    /* Task Section Layout */
    .dashboard-row {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
    }

    .task-list-mini {
        background: white;
        border-radius: 15px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .task-item {
        display: flex;
        align-items: center;
        padding: 12px;
        border-bottom: 1px solid #f1f2f6;
        transition: background 0.2s;
    }

    .task-item:hover { background: #fafafa; }

    .task-item i { margin-right: 15px; color: #f6c23e; }

    /* Shortcut Buttons */
    .staff-actions {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .btn-staff-action {
        background: white;
        padding: 15px;
        border-radius: 10px;
        text-decoration: none;
        color: #2d3436;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 12px;
        border: 1px solid #dfe6e9;
        transition: 0.3s;
    }

    .btn-staff-action:hover {
        background: #f6c23e;
        color: white;
        border-color: #f6c23e;
    }

    @media (max-width: 768px) {
        .dashboard-row { grid-template-columns: 1fr; }
    }
</style>

<div class="staff-header">
    <h2>Welcome back, <?= $username ?> <span class="badge-staff">Personal Staff</span></h2>
    <p class="text-muted">Siap untuk menyelesaikan target hari ini?</p>
</div>

<div class="stats-container">
    <div class="staff-stat-card">
        <i class="fas fa-tasks"></i>
        <div class="stat-text">
            <small>My Tasks</small>
            <h3><?= $myTasks ?></h3>
        </div>
    </div>
    <div class="staff-stat-card" style="border-left-color: #4e73df;">
        <i class="fas fa-project-diagram" style="color: #4e73df;"></i>
        <div class="stat-text">
            <small>My Projects</small>
            <h3><?= $myProjects ?></h3>
        </div>
    </div>
    <div class="staff-stat-card" style="border-left-color: #e74a3b;">
        <i class="fas fa-bug" style="color: #e74a3b;"></i>
        <div class="stat-text">
            <small>Pending Issues</small>
            <h3><?= $pendingIssues ?></h3>
        </div>
    </div>
</div>

<div class="dashboard-row">
    <div class="task-list-mini">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="fw-bold m-0">Tugas Terkini</h5>
            <a href="<?= base_url('staff/tasks') ?>" class="small text-decoration-none">Lihat Semua</a>
        </div>
        
        <div class="task-item">
            <i class="far fa-circle"></i>
            <div>
                <div class="fw-bold" style="font-size: 0.9rem;">Selesaikan Laporan Mingguan</div>
                <small class="text-muted">Deadline: Besok, 17:00</small>
            </div>
        </div>
        <div class="task-item">
            <i class="far fa-circle"></i>
            <div>
                <div class="fw-bold" style="font-size: 0.9rem;">Update Progress Bug #102</div>
                <small class="text-muted">Status: In Progress</small>
            </div>
        </div>
    </div>

    <div class="staff-actions">
        <h5 class="fw-bold mb-2">Aksi Cepat</h5>
        <a href="<?= base_url('staff/tasks') ?>" class="btn-staff-action">
            <i class="fas fa-list-ul"></i> Kelola Tugas
        </a>
        <a href="<?= base_url('staff/progress') ?>" class="btn-staff-action">
            <i class="fas fa-sync-alt"></i> Update Progres
        </a>
        <a href="<?= base_url('staff/issues') ?>" class="btn-staff-action">
            <i class="fas fa-exclamation-circle"></i> Laporkan Isu
        </a>
    </div>
</div>