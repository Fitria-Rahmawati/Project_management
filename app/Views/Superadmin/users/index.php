<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<main class="content">
    <h2>Data User</h2>

    <!-- FILTER -->
    <div class="filter-section">
        <input type="text"
               id="searchUser"
               placeholder="Search"
               onkeyup="filterUserTable()">

        <select id="companyTypeFilter" onchange="filterUserTable()">
            <option value="all">Semua Company</option>
            <option value="internal">Internal</option>
            <option value="external">Eksternal</option>
        </select>

        <select id="statusFilter" onchange="filterUserTable()">
            <option value="all">Semua Status</option>
            <option value="aktif">Aktif</option>
            <option value="nonaktif">Nonaktif</option>
        </select>

        <button class="btn btn-primary"
                onclick="window.location='<?= base_url('superadmin/users/create') ?>'">
            + Tambah User
        </button>
    </div>

   
<div class="card">
    <div class="card-body p-0">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-dark">
                <tr class="text-center">
                    <th>No</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Company</th>
                    <th>Kategori</th>
                    <th>Status</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="8" class="text-center py-4 text-muted">
                            Data user tidak ditemukan
                        </td>
                    </tr>
                <?php endif; ?>

                <?php foreach ($users as $i => $u): ?>
                <tr>
                    <td class="text-center"><?= $i + 1 ?></td>
                    <td><?= esc($u['username']) ?></td>
                    <td><?= esc($u['email']) ?></td>

                    <td class="text-center">
                        <span class="badge bg-info text-dark">
                            <?= esc($u['role_name']) ?>
                        </span>
                    </td>

                    <td><?= esc($u['company_name'] ?? '-') ?></td>

                    <td class="text-center">
                        <?php if (($u['company_type'] ?? '') == 'internal'): ?>
                            <span class="badge bg-success">Internal</span>
                        <?php else: ?>
                            <span class="badge bg-warning text-dark">Eksternal</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-center">
                        <?php if ($u['is_active']): ?>
                            <span class="badge bg-success">Aktif</span>
                        <?php else: ?>
                            <span class="badge bg-secondary">Nonaktif</span>
                        <?php endif; ?>
                    </td>

                    <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <a href="/superadmin/users/edit/<?= $u['id'] ?>"
           class="btn btn-sm btn-warning" title="Edit">
            ✏️
        </a>

        <a href="/superadmin/users/toggle/<?= $u['id'] ?>"
           class="btn btn-sm btn-info" title="Aktif / Nonaktif">
            🔁
        </a>

        <a href="/superadmin/users/delete/<?= $u['id'] ?>"
           onclick="return confirm('Yakin hapus user?')"
           class="btn btn-sm btn-danger" title="Hapus">
            🗑️
        </a>
    </div>
</td>
                
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

</main>

<!-- JS FILTER -->
<script>
function filterUserTable() {
    const search = document.getElementById('searchUser').value.toLowerCase();
    const companyType = document.getElementById('companyTypeFilter').value;
    const status = document.getElementById('statusFilter').value;

    const table = document.getElementById('usersTable');
    const rows = table.getElementsByTagName('tr');

    for (let i = 1; i < rows.length; i++) {
        const username = rows[i].getElementsByTagName('td')[1].textContent.toLowerCase();
        const email = rows[i].getElementsByTagName('td')[2].textContent.toLowerCase();
        const kategori = rows[i].getElementsByTagName('td')[5].textContent.toLowerCase();
        const statusText = rows[i].getElementsByTagName('td')[6].textContent.toLowerCase();

        const matchSearch = username.includes(search) || email.includes(search);
        const matchCompany = companyType === 'all' || kategori === companyType;
        const matchStatus = status === 'all' || statusText === status;

        rows[i].style.display = (matchSearch && matchCompany && matchStatus)
            ? ''
            : 'none';
    }
}
</script>

<?= $this->endSection() ?>