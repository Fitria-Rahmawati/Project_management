<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .filter-section {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }
    .filter-section input,
    .filter-section select {
        padding: 8px 12px;
        border: 1px solid #ddd;
        border-radius: 5px;
        min-width: 200px;
    }
    .filter-section button {
        margin-left: auto;
    }
    .badge {
        padding: 5px 10px;
        border-radius: 5px;
        font-size: 12px;
        margin-right: 5px;
    }
    .badge.bg-info {
        background-color: #17a2b8;
        color: white;
    }
    .badge.bg-warning {
        background-color: #ffc107;
        color: black;
    }
    .badge.bg-success {
        background-color: #28a745;
        color: white;
    }
    .badge.bg-secondary {
        background-color: #6c757d;
        color: white;
    }
</style>

<main class="content">
    <div class="card shadow">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">
                <i class="fas fa-building me-2 text-primary"></i>
                Data Perusahaan
            </h5>
            <a href="<?= base_url('superadmin/companies/create') ?>" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Tambah Perusahaan
            </a>
        </div>
        <div class="card-body">
            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>
            <div class="filter-section">
                <input type="text" id="searchCompany" placeholder="Cari nama perusahaan..." onkeyup="filterTable()">
                <select id="statusFilter" onchange="filterTable()">
                    <option value="all">Semua Status</option>
                    <option value="active">Aktif</option>
                    <option value="inactive">Nonaktif</option>
                </select>
                <select id="typeFilter" onchange="filterTable()">
                    <option value="all">Semua Tipe</option>
                    <option value="internal">Internal</option>
                    <option value="client">Client</option>
                </select>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="companiesTable">
                    <thead class="table-light">
                        <tr>
                            <th width="50">No</th>
                            <th>Nama Perusahaan</th>
                            <th>Tipe</th>
                            <th>Contact Person</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Status</th>
                            <th width="150">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(empty($companies)): ?>
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <i class="fas fa-building fa-3x text-muted mb-3"></i>
                                    <p class="text-muted">Belum ada data perusahaan</p>
                                    <a href="<?= base_url('superadmin/companies/create') ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-2"></i>Tambah Perusahaan
                                    </a>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php $no = 1; foreach($companies as $company): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td>
                                    <strong><?= $company['company_name'] ?></strong>
                                </td>
                                <td>
                                    <?php if ($company['company_type'] == 'internal'): ?>
                                        <span class="badge bg-info">Internal</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">Client</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $company['contact_person'] ?? '-' ?></td>
                                <td><?= $company['email'] ?? '-' ?></td>
                                <td><?= $company['phone'] ?? '-' ?></td>
                                <td>
                                    <?php if ($company['is_active']): ?>
                                        <span class="badge bg-success">Aktif</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="<?= base_url('superadmin/companies/edit/' . $company['id']) ?>"
                                           class="btn btn-sm btn-warning" title="Edit">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <a href="<?= base_url('superadmin/companies/delete/' . $company['id']) ?>"
                                           onclick="return confirm('Yakin ingin menghapus perusahaan ini?')"
                                           class="btn btn-sm btn-danger" title="Hapus">
                                            <i class="fas fa-trash"></i> Hapus
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script>
function filterTable() {
    const searchInput = document.getElementById('searchCompany').value.toLowerCase();
    const statusFilter = document.getElementById('statusFilter').value;
    const typeFilter = document.getElementById('typeFilter').value;
    const table = document.getElementById('companiesTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) { 
        const companyName = rows[i].getElementsByTagName('td')[1]?.textContent.toLowerCase() || '';
        const companyType = rows[i].getElementsByTagName('td')[2]?.textContent.toLowerCase() || '';
        const companyStatus = rows[i].getElementsByTagName('td')[6]?.textContent.toLowerCase() || '';
        const matchesSearch = companyName.includes(searchInput);
        let matchesType = true;
        if (typeFilter !== 'all') {
            matchesType = companyType.includes(typeFilter);
        }
        
        let matchesStatus = true;
        if (statusFilter !== 'all') {
            if (statusFilter === 'active') {
                matchesStatus = companyStatus.includes('aktif');
            } else if (statusFilter === 'inactive') {
                matchesStatus = companyStatus.includes('nonaktif');
            }
        }

        rows[i].style.display = (matchesSearch && matchesType && matchesStatus) ? '' : 'none';
    }
}

setTimeout(function() {
    let alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        let bsAlert = new bootstrap.Alert(alert);
        bsAlert.close();
    });
}, 5000);
</script>

<?= $this->endSection() ?>