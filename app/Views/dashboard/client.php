<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .client-header {
        margin-bottom: 30px;
        background: linear-gradient(135deg, #36b9cc 0%, #258391 100%);
        padding: 30px;
        border-radius: 15px;
        color: white;
    }
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
    }
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
    }
    .btn-client-nav {
        background: white;
        padding: 20px;
        border-radius: 12px;
        text-decoration: none;
        color: #4a5568;
        display: flex;
        align-items: center;
        gap: 15px;
        border: 1px solid #e2e8f0;
    }
    .btn-client-nav:hover {
        background: #f7fafc;
        border-color: #36b9cc;
        color: #36b9cc;
    }
</style>

<div class="client-header">
    <h2>Welcome back, <?= session()->get('username') ?>!</h2>
    <p>Pantau perkembangan proyek dan sampaikan kendala Anda di sini.</p>
</div>

<div class="client-stats">
    <div class="card-client">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <small class="text-muted fw-bold">TOTAL PROYEK SAYA</small>
                <h3 class="mt-1 fw-bold"><?= count($myProjects ?? []) ?></h3>
            </div>
            <i class="fas fa-briefcase fa-2x text-info opacity-25"></i>
        </div>
        <div class="progress-wrapper">
            <div class="progress-info">
                <span>Overall Ongoing</span>
                <span>
                    <?php 
                    $ongoing = 0;
                    foreach($myProjects as $p) {
                        if($p['status'] != 'completed') $ongoing++;
                    }
                    echo $ongoing;
                    ?> Active
                </span>
            </div>
            <div class="progress-bar-custom">
                <?php 
                $total = count($myProjects);
                $ongoing = 0;
                foreach($myProjects as $p) {
                    if($p['status'] != 'completed') $ongoing++;
                }
                $percent = $total > 0 ? round(($ongoing / $total) * 100, 2) : 0;
                ?>
                <div class="progress-fill" style="width: <?= $percent ?>%;"></div>
            </div>
        </div>
    </div>

    <div class="card-client">
        <div class="d-flex justify-content-between">
            <div>
                <small class="text-muted fw-bold">LAPORAN KENDALA</small>
                <h3 class="mt-1 fw-bold text-danger">
                    <?php 
                    $openIssues = 0;
                    foreach($projectProgress as $p) {
                        $openIssues += ($p['total_issues'] - $p['completed_issues']);
                    }
                    echo $openIssues;
                    ?>
                </h3>
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
    <a href="<?= base_url('client/reports') ?>" class="btn-client-nav">
        <i class="fas fa-chart-line"></i>
        <span>Track Progress</span>
    </a>
    <a href="<?= base_url('client/issues/create') ?>" class="btn-client-nav">
        <i class="fas fa-headset"></i>
        <span>Lapor Isu</span>
    </a>
    <a href="<?= base_url('client/issues') ?>" class="btn-client-nav">
        <i class="fas fa-list"></i>
        <span>Riwayat Isu</span>
    </a>
</div>

<?= $this->endSection() ?>