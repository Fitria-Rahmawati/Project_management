<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2>Edit Perusahaan</h2>

<div class="card">
    <form action="<?= base_url('/superadmin/companies/update/' . $company['id']) ?>" method="post">

        <label>Nama Perusahaan</label>
        <input type="text" name="company_name"
               value="<?= esc($company['company_name']) ?>" required>

        <label>Tipe Perusahaan</label>
        <select name="company_type" required>
            <option value="internal" <?= $company['company_type'] === 'internal' ? 'selected' : '' ?>>
                Internal
            </option>
            <option value="client" <?= $company['company_type'] === 'client' ? 'selected' : '' ?>>
                Client
            </option>
        </select>

        <label>Contact Person</label>
        <input type="text" name="contact_person"
               value="<?= esc($company['contact_person']) ?>">

        <label>Email</label>
        <input type="email" name="email"
               value="<?= esc($company['email']) ?>">

        <label>Telepon</label>
        <input type="text" name="phone"
               value="<?= esc($company['phone']) ?>">

        <label>Status</label>
        <select name="is_active">
            <option value="1" <?= $company['is_active'] ? 'selected' : '' ?>>
                Aktif
            </option>
            <option value="0" <?= !$company['is_active'] ? 'selected' : '' ?>>
                Nonaktif
            </option>
        </select>

        <br><br>
        <button type="submit" class="btn">Update</button>
        <a href="<?= base_url('superadmin/companies') ?>">Batal</a>

    </form>
</div>

<?= $this->endSection() ?>