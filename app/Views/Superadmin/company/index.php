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

    /* ==================== MAIN CONTENT ==================== */
    .companies-page {
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
    .btn-primary-custom {
        background: var(--primary);
        border: none;
        padding: 10px 20px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 13px;
        transition: all 0.3s;
    }
    .btn-primary-custom:hover {
        background: #2e59d9;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(78, 115, 223, 0.3);
    }

    /* ==================== STATS ROW ==================== */
    .stats-row {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 25px;
    }
    .stat-item {
        background: white;
        border-radius: 16px;
        padding: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: transform 0.3s;
    }
    .stat-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    .stat-info h3 {
        font-size: 28px;
        font-weight: 700;
        margin: 0;
        color: var(--dark);
    }
    .stat-info p {
        font-size: 12px;
        color: var(--gray);
        margin: 5px 0 0;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .stat-icon.blue { background: var(--primary-light); color: var(--primary); }
    .stat-icon.green { background: var(--success-light); color: var(--success); }
    .stat-icon.orange { background: var(--warning-light); color: var(--warning); }
    .stat-icon.purple { background: #f3e5f5; color: #9c27b0; }

    /* ==================== FILTER BAR ==================== */
    .filter-bar {
        background: white;
        border-radius: 16px;
        padding: 15px 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        align-items: flex-end;
    }
    .filter-group {
        flex: 1;
        min-width: 180px;
    }
    .filter-group label {
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        color: var(--gray);
        margin-bottom: 6px;
        display: block;
    }
    .filter-group input,
    .filter-group select {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid var(--border);
        border-radius: 10px;
        font-size: 13px;
        background: white;
        transition: all 0.3s;
    }
    .filter-group input:focus,
    .filter-group select:focus {
        border-color: var(--primary);
        outline: none;
        box-shadow: 0 0 0 3px rgba(78, 115, 223, 0.1);
    }
    .btn-reset {
        background: var(--bg);
        border: 1px solid var(--border);
        padding: 10px 20px;
        border-radius: 10px;
        color: var(--gray);
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-reset:hover {
        background: var(--border);
        color: var(--dark);
    }

    /* ==================== TABLE ==================== */
    .table-wrapper {
        background: white;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .data-table {
        width: 100%;
        border-collapse: collapse;
    }
    .data-table thead tr {
        background: var(--bg);
    }
    .data-table th {
        padding: 15px;
        font-size: 12px;
        font-weight: 700;
        color: var(--dark);
        text-transform: uppercase;
        letter-spacing: 0.5px;
        text-align: left;
        border-bottom: 1px solid var(--border);
    }
    .data-table td {
        padding: 16px 15px;
        font-size: 13px;
        color: var(--dark);
        border-bottom: 1px solid var(--border);
        vertical-align: middle;
    }
    .data-table tbody tr:hover {
        background: var(--bg);
    }

    /* ==================== BADGES ==================== */
    .badge-sm {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-internal { background: var(--primary-light); color: var(--primary); }
    .badge-client { background: var(--warning-light); color: #e65100; }
    .badge-active { background: var(--success-light); color: var(--success); }
    .badge-inactive { background: var(--danger-light); color: var(--danger); }
    .badge-contract-active { background: var(--success-light); color: var(--success); }
    .badge-contract-expiring { background: var(--warning-light); color: #e65100; }
    .badge-contract-expired { background: var(--danger-light); color: var(--danger); }

    /* ==================== COMPANY INFO ==================== */
    .company-name {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 4px;
    }
    .company-email {
        font-size: 11px;
        color: var(--gray);
    }
    .company-email i {
        width: 14px;
        margin-right: 4px;
    }
    .contact-name {
        font-weight: 600;
        margin-bottom: 2px;
    }
    .contact-phone {
        font-size: 11px;
        color: var(--gray);
    }
    .contract-date {
        font-size: 12px;
        font-weight: 500;
        margin-bottom: 4px;
    }
    .contract-warning {
        font-size: 10px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .contract-warning.warning { color: #e65100; }
    .contract-warning.danger { color: var(--danger); }

    /* ==================== ACTION BUTTONS ==================== */
    .action-group {
        display: flex;
        gap: 8px;
    }
    .action-icon {
        width: 30px;
        height: 30px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
    }
    .action-icon.view { background: var(--primary-light); color: var(--primary); }
    .action-icon.edit { background: var(--warning-light); color: #e65100; }
    .action-icon.delete { background: var(--danger-light); color: var(--danger); }
    .action-icon:hover {
        transform: translateY(-2px);
        filter: brightness(0.95);
    }

    /* ==================== EMPTY STATE ==================== */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-state .empty-icon {
        font-size: 64px;
        color: var(--border);
        margin-bottom: 20px;
    }
    .empty-state h4 {
        font-size: 18px;
        color: var(--dark);
        margin-bottom: 8px;
    }
    .empty-state p {
        color: var(--gray);
        margin-bottom: 20px;
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
    @media (max-width: 992px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .stats-row { grid-template-columns: 1fr; }
        .filter-bar { flex-direction: column; }
        .filter-group { width: 100%; }
    }
</style>

<div class="companies-page">
    <!-- Header -->
    <div class="header-card">
        <div class="header-title">
            <h2><i class="fas fa-building me-2" style="color: var(--primary);"></i> Manajemen Perusahaan</h2>
            <p>Kelola data perusahaan client dan internal</p>
        </div>
        <a href="<?= base_url('superadmin/companies/create') ?>" class="btn btn-primary-custom" id="btnCreate">
            <i class="fas fa-plus me-2"></i> Tambah Perusahaan
        </a>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show mb-3">
            <i class="fas fa-check-circle me-2"></i> <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-3">
            <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Stats Row -->
    <div class="stats-row">
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count($companies) ?></h3>
                <p>Total Perusahaan</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-building"></i></div>
        </div>
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count(array_filter($companies, fn($c) => $c['company_type'] == 'client')) ?></h3>
                <p>Client</p>
            </div>
            <div class="stat-icon orange"><i class="fas fa-user-tie"></i></div>
        </div>
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count(array_filter($companies, fn($c) => $c['company_type'] == 'internal')) ?></h3>
                <p>Internal</p>
            </div>
            <div class="stat-icon green"><i class="fas fa-building"></i></div>
        </div>
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count(array_filter($companies, fn($c) => $c['is_active'] == 1)) ?></h3>
                <p>Perusahaan Aktif</p>
            </div>
            <div class="stat-icon purple"><i class="fas fa-check-circle"></i></div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <div class="filter-group">
            <label><i class="fas fa-search me-1"></i> CARI</label>
            <input type="text" id="searchCompany" placeholder="Nama perusahaan..." onkeyup="filterTable()">
        </div>
        <div class="filter-group">
            <label><i class="fas fa-tag me-1"></i> TIPE</label>
            <select id="typeFilter" onchange="filterTable()">
                <option value="all">Semua</option>
                <option value="internal">🏢 Internal</option>
                <option value="client">🤝 Client</option>
            </select>
        </div>
        <div class="filter-group">
            <label><i class="fas fa-chart-line me-1"></i> STATUS</label>
            <select id="statusFilter" onchange="filterTable()">
                <option value="all">Semua</option>
                <option value="active">✅ Aktif</option>
                <option value="inactive">❌ Nonaktif</option>
            </select>
        </div>
        <div class="filter-group" style="flex: 0.3;">
            <button class="btn-reset" onclick="resetFilters()" style="width: 100%;">
                <i class="fas fa-sync-alt me-2"></i> Reset
            </button>
        </div>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="data-table" id="companiesTable">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>Perusahaan</th>
                    <th width="100">Tipe</th>
                    <th>Contact Person</th>
                    <th width="150">Masa Kontrak</th>
                    <th width="110">Status Kontrak</th>
                    <th width="80">Status</th>
                    <th width="100">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($companies)): ?>
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-building"></i></div>
                                <h4>Belum Ada Data Perusahaan</h4>
                                <p>Silakan tambahkan perusahaan baru</p>
                                <a href="<?= base_url('superadmin/companies/create') ?>" class="btn btn-primary-custom btn-sm">
                                    <i class="fas fa-plus me-2"></i> Tambah Perusahaan
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php $no = 1; foreach($companies as $company): ?>
                    <tr>
                        <td class="text-center fw-bold"><?= $no++ ?></td>
                        <td>
                            <div class="company-name"><?= esc($company['company_name']) ?></div>
                            <div class="company-email"><i class="fas fa-envelope"></i> <?= esc($company['email'] ?? '-') ?></div>
                        </td>
                        <td>
                            <?php if ($company['company_type'] == 'internal'): ?>
                                <span class="badge-sm badge-internal"><i class="fas fa-building"></i> Internal</span>
                            <?php else: ?>
                                <span class="badge-sm badge-client"><i class="fas fa-user-tie"></i> Client</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="contact-name"><?= esc($company['contact_person'] ?? '-') ?></div>
                            <div class="contact-phone"><i class="fas fa-phone"></i> <?= esc($company['phone'] ?? '-') ?></div>
                        </td>
                        <td>
                            <?php if(!empty($company['contract_start']) && !empty($company['contract_end'])): ?>
                                <div class="contract-date">
                                    <i class="far fa-calendar-alt"></i> <?= date('d/m/Y', strtotime($company['contract_start'])) ?> - <?= date('d/m/Y', strtotime($company['contract_end'])) ?>
                                </div>
                                <?php 
                                $daysLeft = floor((strtotime($company['contract_end']) - time()) / (60 * 60 * 24));
                                if($daysLeft >= 0 && $daysLeft <= 30):
                                ?>
                                    <div class="contract-warning warning"><i class="fas fa-hourglass-half"></i> Sisa <?= $daysLeft ?> hari</div>
                                <?php elseif($daysLeft < 0): ?>
                                    <div class="contract-warning danger"><i class="fas fa-exclamation-triangle"></i> Terlambat <?= abs($daysLeft) ?> hari</div>
                                <?php endif; ?>
                            <?php else: ?>
                                <span class="text-muted">-</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php 
                            $contractBadge = '';
                            $contractIcon = '';
                            switch($company['contract_status']) {
                                case 'active': $contractBadge = 'badge-contract-active'; $contractIcon = 'fa-check-circle'; $contractText = 'Aktif'; break;
                                case 'expiring_soon': $contractBadge = 'badge-contract-expiring'; $contractIcon = 'fa-hourglass-half'; $contractText = 'Akan Berakhir'; break;
                                case 'expired': $contractBadge = 'badge-contract-expired'; $contractIcon = 'fa-times-circle'; $contractText = 'Berakhir'; break;
                                default: $contractBadge = 'badge-inactive'; $contractIcon = 'fa-question'; $contractText = '-';
                            }
                            ?>
                            <span class="badge-sm <?= $contractBadge ?>"><i class="fas <?= $contractIcon ?>"></i> <?= $contractText ?></span>
                        </td>
                        <td>
                            <?php if ($company['is_active']): ?>
                                <span class="badge-sm badge-active"><i class="fas fa-check-circle"></i> Aktif</span>
                            <?php else: ?>
                                <span class="badge-sm badge-inactive"><i class="fas fa-ban"></i> Nonaktif</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="action-group">
                                <a href="<?= base_url('superadmin/companies/' . $company['id']) ?>" class="action-icon view" title="Detail" data-detail-link data-name="<?= esc($company['company_name']) ?>"><i class="fas fa-eye"></i></a>
                                <a href="<?= base_url('superadmin/companies/edit/' . $company['id']) ?>" class="action-icon edit" title="Edit" data-edit-link data-name="<?= esc($company['company_name']) ?>"><i class="fas fa-edit"></i></a>
                                <a href="javascript:void(0)" onclick="confirmDelete(<?= $company['id'] ?>, '<?= addslashes($company['company_name']) ?>')" class="action-icon delete" title="Hapus"><i class="fas fa-trash"></i></a>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
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
const loadingOverlay = document.getElementById('loadingOverlay');
const loadingMessage = document.getElementById('loadingMessage');

function showLoading(msg = 'Memproses...') {
    loadingMessage.textContent = msg;
    loadingOverlay.style.display = 'flex';
}

function hideLoading() {
    loadingOverlay.style.display = 'none';
}

function confirmDelete(id, name) {
    if (confirm(`⚠️ PERINGATAN!\n\nYakin ingin menghapus "${name}"?\n\nData terkait akan terhapus semua.\n\nTindakan ini TIDAK DAPAT DIBATALKAN.`)) {
        showLoading('Menghapus perusahaan...');
        setTimeout(() => window.location.href = '<?= base_url('superadmin/companies/delete/') ?>' + id, 200);
    }
}

function filterTable() {
    const keyword = document.getElementById('searchCompany').value.toLowerCase();
    const type = document.getElementById('typeFilter').value;
    const status = document.getElementById('statusFilter').value;
    const rows = document.querySelectorAll('#companiesTable tbody tr');
    
    rows.forEach(row => {
        if (row.querySelector('.empty-state')) return;
        const name = row.cells[1]?.textContent.toLowerCase() || '';
        const typeText = row.cells[2]?.textContent.toLowerCase() || '';
        const statusText = row.cells[6]?.textContent.toLowerCase() || '';
        
        const matchSearch = !keyword || name.includes(keyword);
        const matchType = type === 'all' || typeText.includes(type);
        const matchStatus = status === 'all' || (status === 'active' ? statusText.includes('aktif') : status === 'inactive' ? statusText.includes('nonaktif') : true);
        
        row.style.display = (matchSearch && matchType && matchStatus) ? '' : 'none';
    });
}

function resetFilters() {
    document.getElementById('searchCompany').value = '';
    document.getElementById('typeFilter').value = 'all';
    document.getElementById('statusFilter').value = 'all';
    filterTable();
}

document.getElementById('btnCreate')?.addEventListener('click', () => showLoading('Membuka form...'));
document.querySelectorAll('[data-detail-link]').forEach(el => el.addEventListener('click', () => showLoading('Memuat detail...')));
document.querySelectorAll('[data-edit-link]').forEach(el => el.addEventListener('click', () => showLoading('Membuka form edit...')));
window.addEventListener('load', hideLoading);
setTimeout(() => document.querySelectorAll('.alert').forEach(a => new bootstrap.Alert(a).close()), 5000);
</script>

<?= $this->endSection() ?>