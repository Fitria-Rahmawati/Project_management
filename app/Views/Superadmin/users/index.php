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
    .users-page {
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
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .filter-row {
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
    .badge-custom {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
    }
    .badge-superadmin { background: var(--danger-light); color: var(--danger); }
    .badge-admin { background: var(--warning-light); color: #e65100; }
    .badge-staff { background: var(--info-light); color: var(--info); }
    .badge-client { background: var(--success-light); color: var(--success); }
    .badge-active { background: var(--success-light); color: var(--success); }
    .badge-inactive { background: var(--danger-light); color: var(--danger); }
    .badge-internal { background: var(--primary-light); color: var(--primary); }

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

    /* ==================== USER INFO ==================== */
    .user-name {
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 2px;
    }
    .user-email {
        font-size: 11px;
        color: var(--gray);
    }
    .user-email i {
        width: 12px;
        margin-right: 4px;
    }

    /* ==================== RESPONSIVE ==================== */
    @media (max-width: 992px) {
        .stats-row { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
        .users-page { padding: 15px; }
        .header-card { flex-direction: column; text-align: center; }
        .filter-row { flex-direction: column; }
        .filter-group { width: 100%; }
        .stats-row { grid-template-columns: 1fr; }
    }
</style>

<div class="users-page">
    <!-- Header -->
    <div class="header-card">
        <div class="header-title">
            <h2><i class="fas fa-users-cog me-2" style="color: var(--primary);"></i> Manajemen User</h2>
            <p>Kelola user dan hak akses sistem</p>
        </div>
        <a href="<?= base_url('superadmin/users/create') ?>" class="btn btn-primary-custom" id="btnCreate">
            <i class="fas fa-plus me-2"></i> Tambah User
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
                <h3><?= count($users) ?></h3>
                <p>Total User</p>
            </div>
            <div class="stat-icon blue"><i class="fas fa-users"></i></div>
        </div>
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count(array_filter($users, fn($u) => $u['is_active'] == 1)) ?></h3>
                <p>User Aktif</p>
            </div>
            <div class="stat-icon green"><i class="fas fa-check-circle"></i></div>
        </div>
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count(array_filter($users, fn($u) => $u['role_name'] == 'client')) ?></h3>
                <p>Client</p>
            </div>
            <div class="stat-icon orange"><i class="fas fa-user-tie"></i></div>
        </div>
        <div class="stat-item">
            <div class="stat-info">
                <h3><?= count(array_filter($users, fn($u) => $u['role_name'] == 'staff')) ?></h3>
                <p>Staff</p>
            </div>
            <div class="stat-icon purple"><i class="fas fa-user-cog"></i></div>
        </div>
    </div>

    <!-- Filter Bar -->
    <div class="filter-bar">
        <form method="get" action="<?= base_url('superadmin/users') ?>" id="filterForm">
            <div class="filter-row">
                <div class="filter-group">
                    <label><i class="fas fa-search me-1"></i> CARI USER</label>
                    <input type="text" name="keyword" class="form-control" placeholder="Username atau email..." value="<?= esc($keyword) ?>" id="searchKeyword">
                </div>
                <div class="filter-group">
                    <label><i class="fas fa-building me-1"></i> TIPE PERUSAHAAN</label>
                    <select name="company_type" class="form-select" id="filterCompanyType">
                        <option value="">Semua</option>
                        <option value="internal" <?= $companyType == 'internal' ? 'selected' : '' ?>>🏢 Internal</option>
                        <option value="client" <?= $companyType == 'client' ? 'selected' : '' ?>>🤝 Client</option>
                    </select>
                </div>
                <div class="filter-group">
                    <button type="submit" class="btn btn-primary w-100" id="btnFilter" style="background: var(--primary); border: none;">
                        <i class="fas fa-filter me-2"></i> Filter
                    </button>
                </div>
                <?php if($keyword || $companyType): ?>
                    <div class="filter-group">
                        <a href="<?= base_url('superadmin/users') ?>" class="btn-reset w-100 d-block text-center" id="btnReset">
                            <i class="fas fa-sync-alt me-2"></i> Reset
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Table -->
    <div class="table-wrapper">
        <table class="data-table" id="usersTable">
            <thead>
                <tr>
                    <th width="40">#</th>
                    <th>User</th>
                    <th>Role</th>
                    <th>Perusahaan</th>
                    <th>Tipe</th>
                    <th width="80">Status</th>
                    <th width="90">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if(empty($users)): ?>
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-icon"><i class="fas fa-users"></i></div>
                                <h4>Belum Ada Data User</h4>
                                <p>Silakan tambahkan user baru</p>
                                <a href="<?= base_url('superadmin/users/create') ?>" class="btn btn-primary-custom btn-sm">
                                    <i class="fas fa-plus me-2"></i> Tambah User
                                </a>
                            </div>
                         </div>
                         </td>
                    </tr>
                <?php else: ?>
                    <?php foreach($users as $index => $user): ?>
                        <tr>
                            <td class="text-center fw-bold"><?= $index + 1 ?></td>
                            <td>
                                <div class="user-name"><?= esc($user['username']) ?></div>
                                <div class="user-email"><i class="fas fa-envelope"></i> <?= esc($user['email']) ?></div>
                             </div>
                             </td>
                            <td>
                                <?php 
                                $roleBadge = '';
                                $roleIcon = '';
                                switch($user['role_name']) {
                                    case 'superadmin':
                                        $roleBadge = 'badge-superadmin';
                                        $roleIcon = 'fa-crown';
                                        break;
                                    case 'admin':
                                        $roleBadge = 'badge-admin';
                                        $roleIcon = 'fa-user-shield';
                                        break;
                                    case 'staff':
                                        $roleBadge = 'badge-staff';
                                        $roleIcon = 'fa-user-cog';
                                        break;
                                    case 'client':
                                        $roleBadge = 'badge-client';
                                        $roleIcon = 'fa-user-tie';
                                        break;
                                    default:
                                        $roleBadge = 'badge-inactive';
                                        $roleIcon = 'fa-user';
                                }
                                ?>
                                <span class="badge-custom <?= $roleBadge ?>">
                                    <i class="fas <?= $roleIcon ?>"></i> <?= ucfirst($user['role_name'] ?? 'Unknown') ?>
                                </span>
                             </div>
                             </td>
                            <td>
                                <?= esc($user['company_name'] ?? '-') ?>
                             </div>
                             </td>
                            <td>
                                <?php if($user['company_type']): ?>
                                    <span class="badge-custom badge-internal">
                                        <i class="fas <?= $user['company_type'] == 'internal' ? 'fa-building' : 'fa-user-tie' ?>"></i>
                                        <?= ucfirst($user['company_type']) ?>
                                    </span>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                             </div>
                             </td>
                            <td>
                                <span class="badge-custom <?= $user['is_active'] ? 'badge-active' : 'badge-inactive' ?>">
                                    <i class="fas <?= $user['is_active'] ? 'fa-check-circle' : 'fa-ban' ?>"></i>
                                    <?= $user['is_active'] ? 'Aktif' : 'Nonaktif' ?>
                                </span>
                             </div>
                             </td>
                            <td>
                                <div class="action-group">
                                    <a href="<?= base_url('superadmin/users/edit/' . $user['id']) ?>" 
                                       class="action-icon edit" 
                                       title="Edit User"
                                       data-edit-link
                                       data-id="<?= $user['id'] ?>"
                                       data-name="<?= esc($user['username']) ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="javascript:void(0)" 
                                       class="action-icon delete" 
                                       onclick="confirmDelete(<?= $user['id'] ?>, '<?= addslashes($user['username']) ?>')"
                                       title="Hapus User">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </div>
                             </div>
                             </td>
                        </td>
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

// Konfirmasi Delete
function confirmDelete(id, username) {
    if (confirm(`⚠️ PERINGATAN!\n\nYakin ingin menghapus user "${username}"?\n\nData user akan dihapus permanen!\n\nTindakan ini TIDAK DAPAT DIBATALKAN.\n\nKlik OK untuk menghapus.`)) {
        showLoading('Menghapus user...');
        setTimeout(() => window.location.href = '/superadmin/users/delete/' + id, 200);
    }
}

// Loading untuk tombol create
document.getElementById('btnCreate')?.addEventListener('click', () => showLoading('Membuka form tambah user...'));

// Loading untuk tombol filter
document.getElementById('btnFilter')?.addEventListener('click', () => showLoading('Menerapkan filter...'));

// Loading untuk tombol reset
document.getElementById('btnReset')?.addEventListener('click', () => showLoading('Merreset filter...'));

// Loading untuk tombol edit
document.querySelectorAll('[data-edit-link]').forEach(link => {
    link.addEventListener('click', function(e) {
        const username = this.getAttribute('data-name') || 'User';
        showLoading(`Membuka form edit ${username}...`);
    });
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', hideLoading);

// Auto-hide flash messages
setTimeout(() => {
    document.querySelectorAll('.alert').forEach(alert => {
        new bootstrap.Alert(alert).close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>