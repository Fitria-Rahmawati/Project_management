<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<h2>Tambah Perusahaan</h2>

<div class="card">
    <form action="<?= base_url('/superadmin/companies/store') ?>" method="post">

        <label>Nama Perusahaan</label>
        <input type="text" name="company_name" required>

        <label>Tipe Perusahaan</label>
        <select name="company_type" required>
            <option value="">-- Pilih --</option>
            <option value="internal">Internal</option>
            <option value="client">Client</option>
        </select>

        <label>Contact Person</label>
        <input type="text" name="contact_person">

        <label>Email</label>
        <input type="email" name="email">

        <label>Telepon</label>
        <input type="text" name="phone">

        <label>Status</label>
        <select name="is_active">
            <option value="1">Aktif</option>
            <option value="0">Nonaktif</option>
        </select>

        <br><br>
        <button type="submit" class="btn">Simpan</button>
        <a href="<?= base_url('superadmin/companies') ?>">Kembali</a>

    </form>
</div>

<?= $this->endSection() ?>