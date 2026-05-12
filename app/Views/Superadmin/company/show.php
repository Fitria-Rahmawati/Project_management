<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    /* ==================== VARIABLES ==================== */
    :root {
        --primary: #4e73df;
        --primary-light: #e8f0fe;
        --success: #1cc88a;
        --success-light: #e3f9e9;
        --warning: #f6c23e;
        --warning-light: #fff3e0;
        --danger: #e74a3b;
        --danger-light: #fee2e2;
        --info: #36b9cc;
        --info-light: #e1f5fe;
        --dark: #5a5c69;
        --gray: #858796;
        --border: #e3e6f0;
        --bg: #f8f9fc;
    }

    /* ==================== PAGE LAYOUT ==================== */
    .detail-page {
        padding: 20px;
        background: var(--bg);
        min-height: 100vh;
    }

    /* ==================== HEADER CARD ==================== */
    .header-card {
        background: white;
        border-radius: 16px;
        padding: 20px 25px;
        margin-bottom: 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 15px;
    }
    .header-title h2 {
        font-size: 20px;
        font-weight: 700;
        color: var(--dark);
        margin: 0 0 5px 0;
    }
    .header-title p {
        font-size: 13px;
        color: var(--gray);
        margin: 0;
    }
    .btn-back {
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 10px 20px;
        border-radius: 10px;
        color: var(--gray);
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back:hover {
        background: var(--border);
        color: var(--dark);
    }

    /* ==================== DETAIL CARD ==================== */
    .detail-card {
        background: white;
        border-radius: 20px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        overflow: hidden;
    }
    .detail-header {
        background: linear-gradient(135deg, #ffffff 0%, #f8f9fc 100%);
        padding: 20px 25px;
        border-bottom: 1px solid var(--border);
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .detail-header i {
        font-size: 28px;
        color: var(--primary);
    }
    .detail-header h4 {
        font-size: 18px;
        font-weight: 700;
        color: var(--dark);
        margin: 0;
    }
    .detail-header p {
        font-size: 12px;
        color: var(--gray);
        margin: 2px 0 0;
    }
    .detail-body {
        padding: 25px;
    }

    /* ==================== INFO GRID ==================== */
    .info-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .info-item {
        background: var(--bg);
        border-radius: 12px;
        padding: 15px;
        border: 1px solid var(--border);
        transition: all 0.3s;
    }
    .info-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }
    .info-label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .info-label i {
        font-size: 12px;
    }
    .info-value {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        word-break: break-word;
    }
    .info-value small {
        font-size: 12px;
        font-weight: normal;
        color: var(--gray);
    }

    /* ==================== BADGES ==================== */
    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 14px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }
    .badge-client { background: var(--warning-light); color: #e65100; }
    .badge-internal { background: var(--primary-light); color: var(--primary); }
    .badge-active { background: var(--success-light); color: var(--success); }
    .badge-inactive { background: var(--danger-light); color: var(--danger); }
    .badge-contract-active { background: var(--success-light); color: var(--success); }
    .badge-contract-expiring { background: var(--warning-light); color: #e65100; }
    .badge-contract-expired { background: var(--danger-light); color: var(--danger); }
    .badge-contract-renewed { background: var(--info-light); color: var(--info); }

    /* ==================== SECTION ==================== */
    .section {
        margin-top: 25px;
        border-top: 1px solid var(--border);
        padding-top: 25px;
    }
    .section-title {
        font-size: 16px;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .section-title i {
        font-size: 18px;
        color: var(--primary);
    }

    /* ==================== CONTRACT ALERT ==================== */
    .contract-alert {
        margin-top: 20px;
        padding: 15px 20px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .contract-alert.warning {
        background: var(--warning-light);
        border-left: 4px solid var(--warning);
    }
    .contract-alert.danger {
        background: var(--danger-light);
        border-left: 4px solid var(--danger);
    }
    .contract-alert i {
        font-size: 20px;
    }
    .contract-alert.warning i { color: var(--warning); }
    .contract-alert.danger i { color: var(--danger); }
    .contract-alert .alert-content {
        flex: 1;
    }
    .contract-alert .alert-title {
        font-weight: 700;
        margin-bottom: 4px;
    }
    .contract-alert .alert-text {
        font-size: 13px;
    }

    /* ==================== ACTION BUTTONS ==================== */
    .action-buttons {
        display: flex;
        gap: 15px;
        margin-top: 25px;
        padding-top: 20px;
        border-top: 1px solid var(--border);
    }
    .btn-edit {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        border: none;
        padding: 12px 25px;
        border-radius: 12px;
        color: white;
        font-weight: 700;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-edit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(253, 126, 20, 0.3);
    }
    .btn-back-detail {
        background: white;
        border: 2px solid var(--border);
        padding: 12px 25px;
        border-radius: 12px;
        color: var(--gray);
        font-weight: 600;
        font-size: 14px;
        transition: all 0.3s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-back-detail:hover {
        background: var(--bg);
        border-color: var(--primary);
        color: var(--primary);
    }

    /* ==================== LOADING ==================== */
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.5);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }
    .loading-card {
        background: white;
        padding: 30px;
        border-radius: 20px;
        text-align: center;
        box-shadow: 0 20px 40px rgba(0,0,0,0.2);
    }
    .loading-spinner {
        width: 40px;
        height: 40px;
        border: 3px solid var(--border);
        border-top-color: var(--primary);
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
        margin: 0 auto 15px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 768px) {
        .detail-page { padding: 15px; }
        .header-card { flex-direction: column; text-align: center; }
        .info-grid { grid-template-columns: 1fr; }
        .action-buttons { flex-direction: column; }
        .btn-edit, .btn-back-detail { justify-content: center; }
    }
</style>

<div class="detail-page">
    <!-- Header -->
    <div class="header-card">
        <div class="header-title">
            <h2><i class="fas fa-building me-2" style="color: var(--primary);"></i> Detail Perusahaan</h2>
            <p>Informasi lengkap data perusahaan</p>
        </div>
        <a href="<?= base_url('superadmin/companies') ?>" class="btn-back" id="btnBack">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Daftar
        </a>
    </div>

    <!-- Detail Card -->
    <div class="detail-card">
        <div class="detail-header">
            <i class="fas fa-building"></i>
            <div>
                <h4><?= esc($company['company_name']) ?></h4>
                <p>Informasi detail perusahaan</p>
            </div>
        </div>
        
        <div class="detail-body">
            <!-- Info Grid -->
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-tag"></i> TIPE PERUSAHAAN</div>
                    <div class="info-value">
                        <span class="badge-custom <?= $company['company_type'] == 'client' ? 'badge-client' : 'badge-internal' ?>">
                            <i class="fas <?= $company['company_type'] == 'client' ? 'fa-user-tie' : 'fa-building' ?>"></i>
                            <?= ucfirst($company['company_type']) ?>
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-toggle-on"></i> STATUS PERUSAHAAN</div>
                    <div class="info-value">
                        <span class="badge-custom <?= $company['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                            <i class="fas <?= $company['is_active'] ? 'fa-check-circle' : 'fa-ban' ?>"></i>
                            <?= $company['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                        </span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-user"></i> CONTACT PERSON</div>
                    <div class="info-value">
                        <?= esc($company['contact_person'] ?? '-') ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-phone"></i> TELEPON</div>
                    <div class="info-value">
                        <?= esc($company['phone'] ?? '-') ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-envelope"></i> EMAIL</div>
                    <div class="info-value">
                        <?= esc($company['email'] ?? '-') ?>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label"><i class="fas fa-calendar-alt"></i> TERDAFTAR</div>
                    <div class="info-value">
                        <?= date('d F Y', strtotime($company['created_at'] ?? 'now')) ?>
                        <small><?= date('H:i', strtotime($company['created_at'] ?? 'now')) ?></small>
                    </div>
                </div>
            </div>

            <!-- Contract Section -->
            <div class="section">
                <div class="section-title">
                    <i class="fas fa-file-contract"></i>
                    <span>Informasi Kontrak</span>
                </div>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar-alt"></i> TANGGAL MULAI</div>
                        <div class="info-value">
                            <?= !empty($company['contract_start']) ? date('d F Y', strtotime($company['contract_start'])) : '-' ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-calendar-check"></i> TANGGAL BERAKHIR</div>
                        <div class="info-value">
                            <?= !empty($company['contract_end']) ? date('d F Y', strtotime($company['contract_end'])) : '-' ?>
                        </div>
                    </div>
                    <div class="info-item">
                        <div class="info-label"><i class="fas fa-chart-line"></i> STATUS KONTRAK</div>
                        <div class="info-value">
                            <?php 
                            $statusClass = '';
                            $statusIcon = '';
                            $statusText = '';
                            switch($company['contract_status']) {
                                case 'active':
                                    $statusClass = 'badge-contract-active';
                                    $statusIcon = 'fa-check-circle';
                                    $statusText = 'Aktif';
                                    break;
                                case 'expiring_soon':
                                    $statusClass = 'badge-contract-expiring';
                                    $statusIcon = 'fa-hourglass-half';
                                    $statusText = 'Akan Berakhir';
                                    break;
                                case 'expired':
                                    $statusClass = 'badge-contract-expired';
                                    $statusIcon = 'fa-times-circle';
                                    $statusText = 'Berakhir';
                                    break;
                                case 'renewed':
                                    $statusClass = 'badge-contract-renewed';
                                    $statusIcon = 'fa-sync-alt';
                                    $statusText = 'Diperpanjang';
                                    break;
                                default:
                                    $statusClass = 'badge-inactive';
                                    $statusIcon = 'fa-question';
                                    $statusText = '-';
                            }
                            ?>
                            <span class="badge-custom <?= $statusClass ?>">
                                <i class="fas <?= $statusIcon ?>"></i> <?= $statusText ?>
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Contract Alert -->
                <?php 
                if(!empty($company['contract_end'])):
                    $today = time();
                    $end = strtotime($company['contract_end']);
                    $daysLeft = floor(($end - $today) / (60 * 60 * 24));
                    
                    if($daysLeft >= 0 && $daysLeft <= 30):
                ?>
                    <div class="contract-alert warning">
                        <i class="fas fa-clock"></i>
                        <div class="alert-content">
                            <div class="alert-title">⚠️ Kontrak Akan Berakhir</div>
                            <div class="alert-text">
                                Kontrak akan berakhir dalam <strong><?= $daysLeft ?></strong> hari.
                                <?php if($daysLeft <= 7): ?>
                                    <br><strong>Segera lakukan perpanjangan kontrak!</strong>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php 
                    elseif($daysLeft < 0):
                ?>
                    <div class="contract-alert danger">
                        <i class="fas fa-exclamation-triangle"></i>
                        <div class="alert-content">
                            <div class="alert-title">❌ Kontrak Telah Berakhir</div>
                            <div class="alert-text">
                                Kontrak sudah berakhir sejak <?= abs($daysLeft) ?> hari yang lalu.
                                <br><strong>Client tidak dapat login sampai kontrak diperpanjang.</strong>
                            </div>
                        </div>
                    </div>
                <?php 
                    endif;
                endif; 
                ?>
            </div>

            <!-- Action Buttons -->
            <div class="action-buttons">
                <a href="<?= base_url('superadmin/companies/edit/' . $company['id']) ?>" class="btn-edit" id="btnEdit">
                    <i class="fas fa-edit"></i> Edit Perusahaan
                </a>
                <a href="<?= base_url('superadmin/companies') ?>" class="btn-back-detail" id="btnCancel">
                    <i class="fas fa-arrow-left"></i> Kembali ke Daftar
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loadingOverlay">
    <div class="loading-card">
        <div class="loading-spinner"></div>
        <p id="loadingMessage">Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(msg = 'Memproses...') {
    loadingMessage.textContent = msg;
    loadingOverlay.style.display = 'flex';
}

function hideLoading() {
    loadingOverlay.style.display = 'none';
}

// Loading untuk navigasi
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});
document.getElementById('btnEdit')?.addEventListener('click', function(e) {
    showLoading('Membuka form edit...');
});
document.getElementById('btnCancel')?.addEventListener('click', function(e) {
    showLoading('Kembali ke daftar...');
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', hideLoading);
</script>

<?= $this->endSection() ?>