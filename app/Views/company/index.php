<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<main class="content">
    <h2>Data Perusahaan</h2>

    <div class="filter-section">
        <input type="text" id="searchCompany" placeholder="Search company..." onkeyup="filterTable()">
        <select id="statusFilter" onchange="filterTable()">
            <option value="all">All</option>
            <option value="active">Active</option>
            <option value="inactive">Inactive</option>
        </select>
        <button class="btn btn-primary" onclick="window.location='<?= base_url('superadmin/companies/create') ?>'">+ Tambah Perusahaan</button>
    </div>

    <div class="table-responsive">
        <table id="companiesTable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Perusahaan</th>
                    <th>Tipe</th>
                    <th>Contact Person</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; foreach($companies as $company): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $company['company_name'] ?></td>
                    <td><?= $company['company_type'] ?></td>
                    <td><?= $company['contact_person'] ?></td>
                    <td><?= $company['email'] ?></td>
                    <td><?= $company['phone'] ?? '-' ?></td>
                    <td>
                        <?php if ($company['company_type'] === 'internal'): ?>
                            <span class="badge bg-info">Internal</span>
                        <?php endif; ?>
                        <?php if ($company['company_type'] === 'external'): ?>
                            <span class="badge bg-warning">External</span>
                        <?php endif; ?>
                        <?php if ($company['is_active']): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>
                    <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="/superadmin/companies/edit/<?= $company['id'] ?>"
           class="btn btn-sm btn-warning" title="Edit">
            ✏️ Edit
        </a>

        <a href="/superadmin/companies/delete/<?= $company['id'] ?>"
           onclick="return confirm('Yakin hapus perusahaan?')"
           class="btn btn-sm btn-danger" title="Hapus">
            🗑️ Hapus
        </a>
    </div>
</td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</main>

<script>
function filterTable() {
    const input = document.getElementById('searchCompany').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;
    const table = document.getElementById('companiesTable');
    const tr = table.getElementsByTagName('tr');

    for (let i = 1; i < tr.length; i++) {
        let tdName = tr[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        let tdStatus = tr[i].getElementsByTagName('td')[6].textContent.toLowerCase();

        let show = tdName.includes(input) && (status === 'all' || tdStatus === status);
        tr[i].style.display = show ? '' : 'none';
    }
}

    
function filterCompanyTable() {
    const search = document.getElementById('searchCompany').value.toLowerCase();
    const status = document.getElementById('statusFilter').value;

    const table = document.getElementById('companiesTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const companyName = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        const companyStatus = rows[i].getElementsByTagName('td')[6].textContent.toLowerCase();

        const matchesSearch = companyName.includes(search);
        const matchesStatus = status === 'all' || companyStatus === status;

        rows[i].style.display = (matchesSearch && matchesStatus) ? '' : 'none';
    }
}
</script>

<?= $this->endSection() ?>