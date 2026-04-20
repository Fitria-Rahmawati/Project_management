<?= $this->extend('layout/app') ?>
<?= $this->section('content') ?>

<style>
    .form-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        padding: 25px;
    }
    .form-group {
        margin-bottom: 20px;
    }
    .form-group label {
        font-weight: 500;
        margin-bottom: 8px;
        display: block;
        color: #333;
    }
    .form-group input, .form-group select {
        width: 100%;
        padding: 10px 15px;
        border: 2px solid #e0e0e0;
        border-radius: 8px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.3s;
    }
    .form-group input:focus, .form-group select:focus {
        outline: none;
        border-color: #667eea;
        box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
    }
    .btn-save {
        background: linear-gradient(135deg, #667eea, #764ba2);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-save:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
    }
    .btn-back {
        background: #6c757d;
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        margin-left: 10px;
    }
    .btn-back:hover {
        background: #5a6268;
    }
    hr {
        margin: 20px 0;
    }
</style>

<div class="form-card">
    <h2 class="mb-4">
        <i class="fas fa-building me-2 text-primary"></i>
        Tambah Perusahaan
    </h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('superadmin/companies/store') ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipe Perusahaan <span class="text-danger">*</span></label>
                    <select name="company_type" required>
                        <option value="">-- Pilih --</option>
                        <option value="internal">Internal</option>
                        <option value="client">Client</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text" name="contact_person">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="phone">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active">
                        <option value="1">Aktif</option>
                        <option value="0">Nonaktif</option>
                    </select>
                </div>
            </div>
        </div>

        <hr>

        <h5 class="mb-3"><i class="fas fa-file-contract me-2 text-primary"></i>Informasi Kontrak (Khusus Client)</h5>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Mulai Kontrak</label>
                    <input type="date" name="contract_start" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ada</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Berakhir Kontrak</label>
                    <input type="date" name="contract_end" class="form-control">
                    <small class="text-muted">Kosongkan jika tidak ada</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status Kontrak</label>
                    <select name="contract_status" class="form-control">
                        <option value="active">Aktif</option>
                        <option value="expiring_soon">Akan Berakhir</option>
                        <option value="expired">Berakhir</option>
                        <option value="renewed">Diperpanjang</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn-save">
                <i class="fas fa-save me-2"></i>Simpan
            </button>
            <a href="<?= base_url('superadmin/companies') ?>" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
        </div>

    </form>
</div>

<script>
    
    document.querySelector('[name="company_type"]').addEventListener('change', function() {
        const contractFields = document.querySelectorAll('.contract-field');
        if (this.value === 'client') {
            contractFields.forEach(field => field.style.display = 'block');
        } else {
            contractFields.forEach(field => field.style.display = 'none');
        }
    });
</script>

<?= $this->endSection() ?>