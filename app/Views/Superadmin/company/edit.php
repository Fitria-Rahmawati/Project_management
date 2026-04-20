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
    .btn-update {
        background: linear-gradient(135deg, #ffc107, #fd7e14);
        color: white;
        border: none;
        padding: 12px 25px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s;
    }
    .btn-update:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(255, 193, 7, 0.3);
    }
    .btn-cancel {
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
    .btn-cancel:hover {
        background: #5a6268;
    }
    hr {
        margin: 20px 0;
    }
    .alert {
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
    }
    .alert-danger {
        background: #fee;
        color: #c33;
        border-left: 4px solid #c33;
    }
</style>

<div class="form-card">
    <h2 class="mb-4">
        <i class="fas fa-edit me-2 text-warning"></i>
        Edit Perusahaan
    </h2>

    <?php if(session()->getFlashdata('error')): ?>
        <div class="alert alert-danger"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <form action="<?= base_url('superadmin/companies/update/' . $company['id']) ?>" method="post">
        <?= csrf_field() ?>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama Perusahaan <span class="text-danger">*</span></label>
                    <input type="text" name="company_name" 
                           value="<?= esc($company['company_name']) ?>" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tipe Perusahaan <span class="text-danger">*</span></label>
                    <select name="company_type" required>
                        <option value="internal" <?= $company['company_type'] === 'internal' ? 'selected' : '' ?>>Internal</option>
                        <option value="client" <?= $company['company_type'] === 'client' ? 'selected' : '' ?>>Client</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Contact Person</label>
                    <input type="text" name="contact_person" 
                           value="<?= esc($company['contact_person']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" 
                           value="<?= esc($company['email']) ?>">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Telepon</label>
                    <input type="text" name="phone" 
                           value="<?= esc($company['phone']) ?>">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status</label>
                    <select name="is_active">
                        <option value="1" <?= $company['is_active'] ? 'selected' : '' ?>>Aktif</option>
                        <option value="0" <?= !$company['is_active'] ? 'selected' : '' ?>>Nonaktif</option>
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
                    <input type="date" name="contract_start" class="form-control" 
                           value="<?= old('contract_start', $company['contract_start'] ?? '') ?>">
                    <small class="text-muted">Kosongkan jika tidak ada</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Tanggal Berakhir Kontrak</label>
                    <input type="date" name="contract_end" class="form-control" 
                           value="<?= old('contract_end', $company['contract_end'] ?? '') ?>">
                    <small class="text-muted">Kosongkan jika tidak ada</small>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Status Kontrak</label>
                    <select name="contract_status" class="form-control">
                        <option value="active" <?= (old('contract_status', $company['contract_status'] ?? '') == 'active') ? 'selected' : '' ?>>Aktif</option>
                        <option value="expiring_soon" <?= (old('contract_status', $company['contract_status'] ?? '') == 'expiring_soon') ? 'selected' : '' ?>>Akan Berakhir</option>
                        <option value="expired" <?= (old('contract_status', $company['contract_status'] ?? '') == 'expired') ? 'selected' : '' ?>>Berakhir</option>
                        <option value="renewed" <?= (old('contract_status', $company['contract_status'] ?? '') == 'renewed') ? 'selected' : '' ?>>Diperpanjang</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn-update">
                <i class="fas fa-save me-2"></i>Update
            </button>
            <a href="<?= base_url('superadmin/companies') ?>" class="btn-cancel">
                <i class="fas fa-times me-2"></i>Batal
            </a>
        </div>

    </form>
</div>

<script>
    const typeSelect = document.querySelector('[name="company_type"]');
    const contractFields = document.querySelectorAll('.contract-field');
    
    function toggleContractFields() {
        if (typeSelect.value === 'client') {
            document.querySelectorAll('.contract-field').forEach(field => {
                field.style.display = 'block';
            });
        } else {
            document.querySelectorAll('.contract-field').forEach(field => {
                field.style.display = 'none';
            });
        }
    }
    
    
    toggleContractFields();
    
    
    typeSelect.addEventListener('change', toggleContractFields);
</script>

<?= $this->endSection() ?>