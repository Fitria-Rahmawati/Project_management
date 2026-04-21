<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .detail-header {
        background: linear-gradient(135deg, #e74a3b 0%, #c0392b 100%);
        padding: 25px;
        border-radius: 15px;
        color: white;
        margin-bottom: 25px;
    }
    .info-card {
        background: white;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
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
        background: #e74a3b;
    }
</style>

<div class="container-fluid">
    <!-- Tombol Kembali dan Export PDF -->
    <div class="mb-3 d-flex justify-content-between align-items-center">
        <a href="<?= base_url('client/issues') ?>" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
        <a href="<?= base_url('client/export-issue/' . $issue['id']) ?>" class="btn btn-danger btn-sm" target="_blank">
            <i class="fas fa-file-pdf me-1"></i> Export PDF
        </a>
    </div>

    <!-- Header -->
    <div class="detail-header">
        <div class="d-flex justify-content-between align-items-start">
            <div>
                <h3 class="mb-1"><?= esc($issue['title']) ?></h3>
                <p class="mb-0 opacity-75">
                    <i class="fas fa-folder me-1"></i> <?= esc($issue['project_name']) ?>
                </p>
            </div>
            <div class="text-end">
                <span class="badge bg-white text-dark px-3 py-2 mb-2">
                    <i class="fas fa-flag me-1"></i>
                    Prioritas: <?= ucfirst($issue['priority']) ?>
                </span>
                <br>
                <span class="badge <?= $issue['status'] == 'done' ? 'bg-success' : ($issue['status'] == 'in_progress' ? 'bg-warning' : 'bg-secondary') ?> px-3 py-2">
                    <?= str_replace('_', ' ', ucfirst($issue['status'])) ?>
                </span>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Deskripsi -->
            <div class="info-card">
                <h5 class="mb-3">
                    <i class="fas fa-align-left me-2 text-primary"></i>
                    Deskripsi Kendala
                </h5>
                <p><?= nl2br(esc((string)($issue['description'] ?? '-'))) ?></p>
            </div>

            <!-- Timeline / History -->
            <?php if(!empty($history)): ?>
                <div class="info-card">
                    <h5 class="mb-3">
                        <i class="fas fa-history me-2 text-primary"></i>
                        Riwayat Perubahan
                    </h5>
                    <?php foreach($history as $h): ?>
                        <div class="timeline-item">
                            <small class="text-muted"><?= date('d M Y H:i', strtotime($h['created_at'])) ?></small>
                            <p class="mb-0"><?= esc($h['description']) ?></p>
                            <?php if(isset($h['changed_by'])): ?>
                                <small class="text-muted">Oleh: <?= esc($h['changed_by']) ?></small>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <!-- Informasi -->
            <div class="info-card">
                <h5 class="mb-3">
                    <i class="fas fa-info-circle me-2 text-primary"></i>
                    Informasi
                </h5>
                <table class="table table-sm">
                    <tr>
                        <td width="40%">ID Kendala</td>
                        <td width="10%">:</td>
                        <td>#<?= $issue['id'] ?></td>
                    </tr>
                    <tr>
                        <td>Dilaporkan Oleh</td>
                        <td>:</td>
                        <td><?= $issue['reporter_name'] ?? session()->get('username') ?></td>
                    </tr>
                    <tr>
                        <td>Tanggal Lapor</td>
                        <td>:</td>
                        <td><?= date('d/m/Y H:i', strtotime($issue['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <td>Penerima</td>
                        <td>:</td>
                        <td><?= $issue['assignee_name'] ?? 'Belum ditugaskan' ?></td>
                    </tr>
                    <?php if($issue['due_date']): ?>
                    <tr>
                        <td>Deadline</td>
                        <td>:</td>
                        <td><?= date('d/m/Y', strtotime($issue['due_date'])) ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>