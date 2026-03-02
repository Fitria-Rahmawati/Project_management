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
                        <form method="post" action="<?= base_url('superadmin/companies/status/'.$company['id']) ?>">
                            <input type="hidden" name="_method" value="toggle">
                            <button type="submit" class="status-btn <?= $company['is_active'] ? 'active' : 'inactive' ?>">
                                <?= $company['is_active'] ? 'Active' : 'Inactive' ?>
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="<?= base_url('superadmin/companies/edit/'.$company['id']) ?>">Edit</a> |
                        <a href="<?= base_url('superadmin/companies/delete/'.$company['id']) ?>" onclick="return confirm('Yakin ingin menghapus?')">Hapus</a>
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
filterBorder = document.querySelectorAll('.status-btn');
filterBorder.forEach(btn => {
    btn.addEventListener('click', function() {
        filterBorder.forEach(b => b.classList.remove('active', 'inactive'));
        this.classList.add(this.textContent.trim() === 'Active' ? 'active' : 'inactive');
    });
    
});
</script>

<?= $this->endSection() ?>