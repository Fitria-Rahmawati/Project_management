<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - PM System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container {
            max-width: 450px;
            width: 100%;
            background: white;
            border-radius: 24px;
            padding: 40px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
            animation: slideUp 0.5s ease;
        }
        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .logo { text-align: center; margin-bottom: 30px; }
        .logo i { font-size: 48px; color: #667eea; }
        .logo h2 { margin-top: 10px; color: #333; }
        .alert {
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
        }
        .alert-danger { background: #fee2e2; color: #e74a3b; border-left: 3px solid #e74a3b; }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; margin-bottom: 8px; font-weight: 600; color: #555; }
        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 4px rgba(102,126,234,0.1);
        }
        .form-group input.is-invalid { border-color: #e74a3b; }
        .invalid-feedback { color: #e74a3b; font-size: 12px; margin-top: 5px; display: block; }
        .btn-submit {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 12px;
            color: white;
            font-weight: 600;
            font-size: 16px;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-submit:hover { transform: translateY(-2px); box-shadow: 0 5px 15px rgba(102,126,234,0.4); }
        .btn-submit:disabled { opacity: 0.7; cursor: wait; }
        .info-text { text-align: center; margin-top: 20px; font-size: 13px; color: #888; }
        .info-text a { color: #667eea; text-decoration: none; font-weight: 600; }
    </style>
</head>
<body>
    <div class="container">
        <div class="logo">
            <i class="fas fa-chart-line"></i>
            <h2>Reset Password</h2>
            <p style="color: #888; font-size: 13px; margin-top: 5px;">Buat password baru untuk akun Anda</p>
        </div>

        <?php if(session()->getFlashdata('error')): ?>
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle me-2"></i> <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif; ?>

        <form action="<?= base_url('reset-password/update') ?>" method="post" id="resetForm">
            <?= csrf_field() ?>
            <?php if(isset($token)): ?>
            <input type="hidden" name="token" value="<?= esc($token ?? '') ?>">
            <?php endif; ?>

            <div class="form-group">
                <label>Password Baru</label>
                <input type="password" name="password" id="password" placeholder="Minimal 6 karakter" required>
                <div class="invalid-feedback">Password minimal 6 karakter</div>
            </div>

            <div class="form-group">
                <label>Konfirmasi Password Baru</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <div class="invalid-feedback">Konfirmasi password tidak cocok</div>
            </div>

            <button type="submit" class="btn-submit" id="btnSubmit">
                <span class="btn-text">Reset Password</span>
                <span class="spinner-border spinner-border-sm d-none" role="status"></span>
            </button>
        </form>

        <div class="info-text">
            <a href="<?= base_url('login') ?>">
                <i class="fas fa-arrow-left me-1"></i> Kembali ke Login
            </a>
        </div>
    </div>

    <script>
        const form = document.getElementById('resetForm');
        const password = document.getElementById('password');
        const confirmPassword = document.getElementById('confirm_password');
        const btn = document.getElementById('btnSubmit');

        form.addEventListener('submit', function(e) {
            let isValid = true;
            
            password.classList.remove('is-invalid');
            confirmPassword.classList.remove('is-invalid');
            
            if (password.value.length < 6) {
                password.classList.add('is-invalid');
                isValid = false;
            }
            
            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
                return false;
            }
            
            btn.disabled = true;
            btn.querySelector('.btn-text').textContent = 'Memproses...';
            btn.querySelector('.spinner-border').classList.remove('d-none');
        });
    </script>
</body>
</html>