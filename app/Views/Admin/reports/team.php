<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .report-header {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .report-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 5px;
    }
    .report-subtitle {
        color: #888;
        font-size: 14px;
    }
    .filter-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .summary-stats {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 25px;
    }
    .stat-box {
        background: white;
        border-radius: 12px;
        padding: 15px 20px;
        flex: 1;
        min-width: 150px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        border-left: 4px solid #667eea;
    }
    .stat-box .stat-number {
        font-size: 28px;
        font-weight: 700;
        color: #333;
    }
    .stat-box .stat-label {
        font-size: 13px;
        color: #888;
        margin-top: 5px;
    }
    .report-table {
        font-size: 14px;
    }
    .badge-completion-high {
        background: #28a745;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
    }
    .badge-completion-medium {
        background: #ffc107;
        color: #333;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
    }
    .badge-completion-low {
        background: #dc3545;
        color: white;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 12px;
        display: inline-block;
    }
    .export-buttons {
        display: flex;
        gap: 10px;
        justify-content: flex-end;
        margin-bottom: 20px;
    }
    
    /* Loading Overlay */
    .page-loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0,0,0,0.6);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 9999;
    }
    .loading-spinner {
        background: white;
        padding: 30px 40px;
        border-radius: 15px;
        text-align: center;
        box-shadow: 0 10px 30px rgba(0,0,0,0.2);
    }
    .loading-spinner p {
        margin-top: 15px;
        margin-bottom: 0;
        color: #28a745;
        font-weight: 500;
    }
    
    @media print {
        .no-print, .filter-card, .export-buttons, .btn, nav, .sidebar, footer {
            display: none !important;
        }
        body, .container, .container-fluid, .main-content, #content {
            margin: 0 !important;
            padding: 0 !important;
            background: white !important;
            width: 100% !important;
        }
        .report-header {
            box-shadow: none;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
            page-break-after: avoid;
        }
        .summary-stats {
            display: flex;
            gap: 15px;
            page-break-inside: avoid;
        }
        .stat-box {
            border: 1px solid #ddd;
            box-shadow: none;
            page-break-inside: avoid;
        }
        .report-table {
            width: 100%;
            border-collapse: collapse;
        }
        .report-table th, .report-table td {
            border: 1px solid #000 !important;
        }
        .badge-completion-high, .badge-completion-medium, .badge-completion-low {
            print-color-adjust: exact;
            -webkit-print-color-adjust: exact;
        }
        .rounded-circle {
            border: 1px solid #ddd;
            background-color: #f0f0f0 !important;
            color: #333 !important;
        }
        .card-footer {
            border-top: 1px solid #ddd;
            margin-top: 20px;
            padding: 10px;
        }
    }
</style>

<div class="container-fluid px-0">
    <div class="report-header">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <div class="report-title">
                    <i class="fas fa-chart-line me-2 text-primary"></i>
                    Laporan Kinerja Tim
                </div>
                <div class="report-subtitle">
                    Periode: <?= date('d F Y') ?> | Total <?= count($staff) ?> anggota tim aktif
                </div>
            </div>
            <div class="export-buttons no-print">
                <a href="<?= base_url('admin/reports/export/team') ?>" class="btn btn-sm btn-success" id="btnExportExcel">
                    <i class="fas fa-file-excel me-2"></i>Export Excel
                </a>
                <a href="<?= base_url('admin/reports/export-team') ?>" class="btn btn-sm btn-danger" target="_blank" id="btnExportPDF">
                    <i class="fas fa-file-pdf me-2"></i>PDF
                </a>
                <a href="<?= base_url('admin/teams') ?>" class="btn btn-sm btn-outline-secondary" id="btnBack">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
        </div>
    </div>

    <div class="filter-card no-print">
        <form method="get" action="<?= base_url('admin/reports/team') ?>" id="filterForm">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label class="form-label small text-muted">Periode</label>
                    <select name="period" class="form-select form-select-sm" id="filterPeriod">
                        <option value="all" <?= ($period ?? 'all') == 'all' ? 'selected' : '' ?>>Semua Waktu</option>
                        <option value="this_month" <?= ($period ?? '') == 'this_month' ? 'selected' : '' ?>>Bulan Ini</option>
                        <option value="last_month" <?= ($period ?? '') == 'last_month' ? 'selected' : '' ?>>Bulan Lalu</option>
                        <option value="this_year" <?= ($period ?? '') == 'this_year' ? 'selected' : '' ?>>Tahun Ini</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Departemen</label>
                    <select name="department" class="form-select form-select-sm" id="filterDepartment">
                        <option value="">Semua Departemen</option>
                        <?php foreach($departments ?? [] as $dept): ?>
                            <option value="<?= $dept['id'] ?>" <?= ($filter_dept ?? '') == $dept['id'] ? 'selected' : '' ?>>
                                <?= esc($dept['department_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label small text-muted">Posisi</label>
                    <select name="position" class="form-select form-select-sm" id="filterPosition">
                        <option value="">Semua Posisi</option>
                        <?php foreach($positions ?? [] as $pos): ?>
                            <option value="<?= $pos['id'] ?>" <?= ($filter_pos ?? '') == $pos['id'] ? 'selected' : '' ?>>
                                <?= esc($pos['position_name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm w-100" id="btnFilter">
                        <i class="fas fa-filter me-2"></i>Terapkan Filter
                    </button>
                </div>
            </div>
        </form>
    </div>

    <div class="summary-stats">
        <div class="stat-box">
            <div class="stat-number"><?= count($staff) ?></div>
            <div class="stat-label">Total Staff</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?= array_sum(array_column($staff, 'assigned_issues')) ?></div>
            <div class="stat-label">Total Tugas</div>
        </div>
        <div class="stat-box">
            <div class="stat-number text-success"><?= array_sum(array_column($staff, 'completed_issues')) + array_sum(array_column($staff, 'closed_issues')) ?></div>
            <div class="stat-label">Tugas Selesai</div>
        </div>
        <div class="stat-box">
            <div class="stat-number text-danger"><?= array_sum(array_column($staff, 'overdue_issues')) ?></div>
            <div class="stat-label">Tugas Terlambat</div>
        </div>
        <div class="stat-box">
            <div class="stat-number"><?= round(array_sum(array_column($staff, 'completion_rate')) / max(1, count($staff)), 1) ?>%</div>
            <div class="stat-label">Rata-rata Completion</div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-white no-print">
            <h6 class="mb-0"><i class="fas fa-table me-2"></i>Detail Kinerja Tim</h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover report-table mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>No</th>
                            <th>Nama Staff</th>
                            <th>Posisi</th>
                            <th>Departemen</th>
                            <th class="text-center">Tugas</th>
                            <th class="text-center">Selesai</th>
                            <th class="text-center">Terlambat</th>
                            <th class="text-center">Completion</th>
                            <th class="text-center">Jam Kerja</th>
                        </thead>
                    <tbody>
                        <?php if(empty($staff)): ?>
                            <tr>
                                <td colspan="9" class="text-center py-5 text-muted">
                                    <i class="fas fa-chart-line fa-3x mb-3 d-block"></i>
                                    Belum ada data kinerja tim
                                 </div>
                                 </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($staff as $i => $member): ?>
                                <tr>
                                    <td class="text-center"><?= $i+1 ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 32px; height: 32px; font-size: 14px;">
                                                <?= strtoupper(substr($member['first_name'] ?? $member['username'], 0, 1)) ?>
                                            </div>
                                            <div>
                                                <strong><?= esc($member['first_name'] ?? $member['username']) ?> <?= esc($member['last_name'] ?? '') ?></strong>
                                                <br>
                                                <small class="text-muted"><?= esc($member['email']) ?></small>
                                            </div>
                                        </div>
                                     </div>
                                     </td>
                                    <td><?= esc($member['position_name'] ?? '-') ?></div>
                                     </td>
                                    <td><?= esc($member['department_name'] ?? '-') ?></div>
                                     </td>
                                    <td class="text-center"><?= $member['assigned_issues'] ?? 0 ?></div>
                                     </td>
                                    <td class="text-center text-success"><?= ($member['completed_issues'] ?? 0) + ($member['closed_issues'] ?? 0) ?></div>
                                     </td>
                                    <td class="text-center text-danger"><?= $member['overdue_issues'] ?? 0 ?></div>
                                     </td>
                                    <td class="text-center">
                                        <?php $rate = $member['completion_rate'] ?? 0; ?>
                                        <span class="badge <?= $rate >= 70 ? 'badge-completion-high' : ($rate >= 50 ? 'badge-completion-medium' : 'badge-completion-low') ?>">
                                            <?= $rate ?>%
                                        </span>
                                     </div>
                                     </td>
                                    <td class="text-center"><?= $member['total_hours'] ?? 0 ?> jam</div>
                                     </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-footer bg-white text-muted small no-print">
            <i class="fas fa-info-circle me-1"></i> Laporan ini mencakup semua tugas yang telah diassign kepada staff.
            Completion Rate dihitung dari (tugas selesai / total tugas) × 100%.
        </div>
    </div>
</div>

<!-- Loading Overlay -->
<div class="page-loading-overlay" id="loadingOverlay">
    <div class="loading-spinner">
        <div class="spinner-border text-success" role="status" style="width: 3rem; height: 3rem;">
            <span class="visually-hidden">Loading...</span>
        </div>
        <p id="loadingMessage"><i class="fas fa-spinner fa-spin me-2"></i> Memproses...</p>
    </div>
</div>

<script>
// Loading Overlay
function showLoading(message = 'Memproses...') {
    const overlay = document.getElementById('loadingOverlay');
    const msgElement = document.getElementById('loadingMessage');
    if (overlay) {
        if (msgElement) msgElement.innerHTML = `<i class="fas fa-spinner fa-spin me-2"></i> ${message}`;
        overlay.style.display = 'flex';
    }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) {
        overlay.style.display = 'none';
    }
}

// Submit filter dengan loading
document.getElementById('filterForm')?.addEventListener('submit', function(e) {
    showLoading('Menerapkan filter...');
});

// Loading untuk tombol export Excel
document.getElementById('btnExportExcel')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file Excel...');
    setTimeout(() => {
        hideLoading();
    }, 2000);
});

// Loading untuk tombol export PDF
document.getElementById('btnExportPDF')?.addEventListener('click', function(e) {
    showLoading('Menyiapkan file PDF...');
    setTimeout(() => {
        hideLoading();
    }, 2000);
});

// Loading untuk tombol kembali
document.getElementById('btnBack')?.addEventListener('click', function(e) {
    showLoading('Kembali ke halaman reports...');
});

// Sembunyikan loading saat halaman selesai dimuat
window.addEventListener('load', function() {
    hideLoading();
});

// Auto-hide flash messages
setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>