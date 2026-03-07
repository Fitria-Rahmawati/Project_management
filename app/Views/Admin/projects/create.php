<?= $this->extend('layout/app') ?>

<?= $this->section('content') ?>

<div class="container mt-4">

    <h4 class="mb-4">Tambah Project</h4>

    <?php if(session()->getFlashdata('errors')) : ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach(session()->getFlashdata('errors') as $error) : ?>
                    <li><?= $error ?></li>
                <?php endforeach ?>
            </ul>
        </div>
    <?php endif ?>

    <form action="<?= base_url('admin/projects/store') ?>" method="post">

        <div class="mb-3">
            <label class="form-label">Nama Project</label>
            <input type="text" name="project_name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Perusahaan</label>
            <select name="company_id" id="company_id" class="form-control">
    <option value="">-- Pilih Perusahaan --</option>
    <?php foreach($companies as $c): ?>
        <option value="<?= $c['id'] ?>"><?= $c['company_name'] ?></option>
    <?php endforeach ?>
</select>
        </div>

        <div class="mb-3">
            <label class="form-label">Project Manager</label>
            <select name="project_manager_id" id="project_manager_id" class="form-control">
    <option value="">-- Pilih Project Manager --</option>
</select>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Start Date</label>
                <input type="date" name="start_date" class="form-control" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">End Date</label>
                <input type="date" name="end_date" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="not_started">Not Started</option>
                <option value="progress">Progress</option>
                <option value="completed">Completed</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Deskripsi</label>
            <textarea name="description" class="form-control" rows="4"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Project
        </button>

        <a href="<?= base_url('admin/projects') ?>" class="btn btn-secondary">
            Kembali
        </a>

    </form>

</div>

<?= $this->endSection() ?>

<script>

document.getElementById('company_id').addEventListener('change', function(){

    let company_id = this.value;

    fetch("/admin/projects/get-pm/" + company_id)
    .then(response => response.json())
    .then(data => {

        let pmSelect = document.getElementById('project_manager_id');

        pmSelect.innerHTML = '<option value="">-- Pilih Project Manager --</option>';

        data.forEach(pm => {
            pmSelect.innerHTML += `<option value="${pm.id}">${pm.name}</option>`;
        });

    });

});

</script>