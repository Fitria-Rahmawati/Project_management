<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .detail-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px;
        margin-bottom: 20px;
    }
    .detail-header {
        border-bottom: 2px solid #667eea;
        padding-bottom: 15px;
        margin-bottom: 20px;
    }
    .detail-header h4 {
        margin: 0;
        color: #333;
    }
    .detail-row {
        display: flex;
        margin-bottom: 15px;
        padding: 10px 0;
        border-bottom: 1px solid #eee;
    }
    .detail-label {
        width: 180px;
        font-weight: 600;
        color: #555;
    }
    .detail-value {
        flex: 1;
        color: #333;
    }
    .badge-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }
    .btn-back {
        background: #6c757d;
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
    }
    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        display: inline-block;
        margin-right: 10px;
    }
</style>

<div class="detail-card">
    <div class="detail-header">
        <h4>
            <i class="fas fa-building me-2 text-primary"></i>
            Detail Perusahaan
        </h4>
    </div>

    <div class="detail-row">
        <div class="detail-label">Nama Perusahaan</div>
        <div class="detail-value"><?= esc($company['company_name']) ?></div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Tipe Perusahaan</div>
        <div class="detail-value">
            <span class="badge-status <?= $company['company_type'] == 'client' ? 'bg-primary' : 'bg-secondary' ?>">
                <?= ucfirst($company['company_type']) ?>
            </span>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Contact Person</div>
        <div class="detail-value"><?= esc($company['contact_person']) ?? '-' ?></div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Email</div>
        <div class="detail-value"><?= esc($company['email']) ?? '-' ?></div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Telepon</div>
        <div class="detail-value"><?= esc($company['phone']) ?? '-' ?></div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Status</div>
        <div class="detail-value">
            <span class="badge-status <?= $company['is_active'] ? 'bg-success' : 'bg-danger' ?>">
                <?= $company['is_active'] ? 'Aktif' : 'Nonaktif' ?>
            </span>
        </div>
    </div>

    <hr>

    <h5 class="mb-3"><i class="fas fa-file-contract me-2 text-primary"></i>Informasi Kontrak</h5>

    <div class="detail-row">
        <div class="detail-label">Tanggal Mulai Kontrak</div>
        <div class="detail-value">
            <?= !empty($company['contract_start']) ? date('d/m/Y', strtotime($company['contract_start'])) : '-' ?>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Tanggal Berakhir Kontrak</div>
        <div class="detail-value">
            <?= !empty($company['contract_end']) ? date('d/m/Y', strtotime($company['contract_end'])) : '-' ?>
        </div>
    </div>

    <div class="detail-row">
        <div class="detail-label">Status Kontrak</div>
        <div class="detail-value">
            <?php 
            $statusClass = '';
            $statusText = '';
            switch($company['contract_status']) {
                case 'active':
                    $statusClass = 'bg-success';
                    $statusText = 'Aktif';
                    break;
                case 'expiring_soon':
                    $statusClass = 'bg-warning text-dark';
                    $statusText = 'Akan Berakhir';
                    break;
                case 'expired':
                    $statusClass = 'bg-danger';
                    $statusText = 'Berakhir';
                    break;
                case 'renewed':
                    $statusClass = 'bg-info';
                    $statusText = 'Diperpanjang';
                    break;
                default:
                    $statusClass = 'bg-secondary';
                    $statusText = '-';
            }
            ?>
            <span class="badge-status <?= $statusClass ?>"><?= $statusText ?></span>
        </div>
    </div>

    <?php 
    // Hitung sisa hari kontrak jika ada
    if(!empty($company['contract_end'])):
        $today = time();
        $end = strtotime($company['contract_end']);
        $daysLeft = floor(($end - $today) / (60 * 60 * 24));
        
        if($daysLeft >= 0 && $daysLeft <= 30):
    ?>
        <div class="alert alert-warning mt-3">
            <i class="fas fa-clock me-2"></i>
            Kontrak akan berakhir dalam <strong><?= $daysLeft ?></strong> hari.
            <?php if($daysLeft <= 7): ?>
                <br><small>Segera lakukan perpanjangan kontrak!</small>
            <?php endif; ?>
        </div>
    <?php 
        elseif($daysLeft < 0):
    ?>
        <div class="alert alert-danger mt-3">
            <i class="fas fa-exclamation-circle me-2"></i>
            Kontrak sudah berakhir sejak <?= abs($daysLeft) ?> hari yang lalu.
            <br><small>Client tidak dapat login sampai kontrak diperpanjang.</small>
        </div>
    <?php 
        endif;
    endif; 
    ?>

    <div class="mt-4">
        <a href="<?= base_url('superadmin/companies/edit/' . $company['id']) ?>" class="btn-edit">
            <i class="fas fa-edit me-2"></i>Edit Perusahaan
        </a>
        <a href="<?= base_url('superadmin/companies') ?>" class="btn-back">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>
</div>

<?= $this->endSection() ?>