<style>
    /* Client Dashboard Specific */
    .client-header {
        margin-bottom: 30px;
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        padding: 30px;
        border-radius: 15px;
        color: white;
        box-shadow: 0 4px 15px rgba(54, 185, 204, 0.3);
    }

    .client-header h2 { margin: 0; font-weight: 700; }
    .client-header p { margin: 5px 0 0 0; opacity: 0.9; }

    /* Stats Grid */
    .client-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 35px;
    }

    .card-client {
        background: white;
        padding: 25px;
        border-radius: 15px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.02);
        border: 1px solid #edf2f7;
        transition: all 0.3s ease;
    }

    .card-client:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }

    /* Progress Bar Custom */
    .progress-wrapper { margin-top: 15px; }
    .progress-info { display: flex; justify-content: space-between; margin-bottom: 8px; font-weight: 600; }
    .progress-bar-custom {
        height: 12px;
        background: #eaecf4;
        border-radius: 10px;
        overflow: hidden;
    }
    .progress-fill {
        height: 100%;
        background: #36b9cc;
        border-radius: 10px;
        transition: width 1s ease-in-out;
    }

    /* Shortcut Grid */
    .client-nav {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 15px;
    }

    .btn-client-nav {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-decoration: none;
        color: #4a5568;
        font-weight: 600;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #e2e8f0;
        transition: all 0.2s;
    }

    .btn-client-nav:hover {
        background: #f7fafc;
        border-color: #36b9cc;
        color: #36b9cc;
    }

    .btn-client-nav i {
        width: 40px;
        height: 40px;
        background: #f0fdfa;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        color: #36b9cc;
    }
</style>

<div class="client-header">
    <h2>Welcome back, <?= $username ?>!</h2>
    <p>Pantau perkembangan proyek dan sampaikan kendala Anda di sini.</p>
</div>

<div class="client-stats">
    <div class="card-client">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <small class="text-muted fw-bold">TOTAL PROYEK SAYA</small>
                <h3 class="mt-1 fw-bold"><?= $myProjects ?></h3>
            </div>
            <i class="fas fa-briefcase fa-2x text-info opacity-25"></i>
        </div>
        <div class="progress-wrapper">
            <div class="progress-info">
                <span>Overall Ongoing</span>
                <span><?= $ongoingProjects ?> Active</span>
            </div>
            <div class="progress-bar-custom">
                <div class="progress-fill" style="width: 70%;"></div>
            </div>
        </div>
    </div>

    <div class="card-client">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted fw-bold">LAPORAN KENDALA</small>
                <h3 class="mt-1 fw-bold text-danger"><?= $pendingIssues ?? 0 ?></h3>
                <small class="text-muted small">Butuh perhatian Anda</small>
            </div>
            <i class="fas fa-exclamation-circle fa-2x text-danger opacity-25"></i>
        </div>
    </div>
</div>

<h5 class="fw-bold mb-3">Akses Cepat</h5>

<div class="client-nav">
    <a href="<?= base_url('client/projects') ?>" class="btn-client-nav">
        <i class="fas fa-project-diagram"></i>
        <span>Detail Proyek</span>
    </a>
    <a href="<?= base_url('client/progress') ?>" class="btn-client-nav">
        <i class="fas fa-chart-line"></i>
        <span>Track Progress</span>
    </a>
    <a href="<?= base_url('client/issues') ?>" class="btn-client-nav">
        <i class="fas fa-headset"></i>
        <span>Lapor Isu</span>
    </a>
</div>