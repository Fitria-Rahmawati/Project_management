<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Project Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ==================== VARIABLES ==================== */
        :root {
            --primary: #4e73df;
            --primary-dark: #2e59d9;
            --primary-light: #e8f0fe;
            --secondary: #764ba2;
            --success: #1cc88a;
            --danger: #e74a3b;
            --dark: #5a5c69;
            --gray: #858796;
            --border: #e3e6f0;
            --bg-light: #f8f9fc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* Background decoration */
        body::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ==================== CONTAINER ==================== */
        .register-container {
            max-width: 950px;
            width: 100%;
            background: white;
            border-radius: 28px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideUp 0.6s cubic-bezier(0.2, 0.9, 0.4, 1.1);
            position: relative;
            z-index: 1;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ==================== HEADER ==================== */
        .register-header {
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            padding: 35px;
            text-align: center;
            color: white;
        }

        .logo-wrapper {
            width: 70px;
            height: 70px;
            background: rgba(255,255,255,0.15);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
        }

        .logo-wrapper i {
            font-size: 38px;
            color: white;
        }

        .register-header h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .register-header p {
            opacity: 0.85;
            font-size: 14px;
            font-weight: 400;
        }

        /* ==================== BODY ==================== */
        .register-body {
            padding: 40px;
        }

        /* ==================== ALERT ==================== */
        .alert {
            padding: 14px 18px;
            border-radius: 14px;
            margin-bottom: 25px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert i {
            font-size: 18px;
        }

        .alert-error {
            background: #fff5f5;
            color: var(--danger);
            border-left: 4px solid var(--danger);
        }

        .alert-success {
            background: #f0fff4;
            color: var(--success);
            border-left: 4px solid var(--success);
        }

        /* ==================== ROLE SELECTOR ==================== */
        .role-selector {
            display: flex;
            gap: 20px;
            margin-bottom: 35px;
        }

        .role-card {
            flex: 1;
            border: 2px solid var(--border);
            border-radius: 20px;
            padding: 25px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
            background: white;
        }

        .role-card:hover {
            border-color: var(--primary);
            background: var(--bg-light);
            transform: translateY(-3px);
        }

        .role-card.active {
            border-color: var(--primary);
            background: linear-gradient(135deg, var(--primary-light), #f0e6ff);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        }

        .role-card i {
            font-size: 48px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 15px;
        }

        .role-card h3 {
            font-size: 18px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--dark);
        }

        .role-card p {
            font-size: 12px;
            color: var(--gray);
        }

        /* ==================== FORM SECTION ==================== */
        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid var(--border);
        }

        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 25px;
        }

        .section-title i {
            font-size: 20px;
            color: var(--primary);
            background: var(--primary-light);
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .section-title h4 {
            font-size: 16px;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .section-title p {
            font-size: 12px;
            color: var(--gray);
            margin-top: 2px;
        }

        /* ==================== FORM GRID ==================== */
        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: var(--dark);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.3px;
        }

        .form-group label i {
            margin-right: 6px;
            color: var(--primary);
            font-size: 12px;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 2px solid var(--border);
            border-radius: 12px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            background: var(--bg-light);
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        }

        .input-group input:hover,
        .input-group select:hover,
        .input-group textarea:hover {
            border-color: #cbd5e1;
            background: white;
        }

        .input-group input::placeholder,
        .input-group textarea::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }

        textarea {
            resize: vertical;
            min-height: 80px;
        }

        /* ==================== BUTTON ==================== */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 14px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            transition: all 0.3s;
            margin-top: 30px;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-register:active {
            transform: translateY(0);
        }

        .btn-register.loading {
            opacity: 0.8;
            cursor: wait;
        }

        .btn-register.loading .btn-text {
            display: none;
        }

        .btn-register.loading .loading-spinner {
            display: inline-block;
        }

        .loading-spinner {
            display: none;
            width: 20px;
            height: 20px;
            border: 2px solid rgba(255,255,255,0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.6s linear infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        /* ==================== FOOTER ==================== */
        .login-link {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
            color: var(--gray);
            font-size: 13px;
        }

        .login-link a {
            color: var(--primary);
            text-decoration: none;
            font-weight: 700;
            margin-left: 5px;
            transition: all 0.3s;
        }

        .login-link a:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        /* ==================== UTILITY ==================== */
        .hidden {
            display: none;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 768px) {
            .register-container {
                max-width: 100%;
            }
            
            .register-body {
                padding: 30px 25px;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .role-selector {
                flex-direction: column;
                gap: 15px;
            }
            
            .role-card {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .register-body {
                padding: 25px 20px;
            }
            
            .register-header {
                padding: 25px;
            }
            
            .register-header h2 {
                font-size: 22px;
            }
            
            .section-title i {
                width: 32px;
                height: 32px;
                font-size: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="register-container">
        <!-- Header -->
        <div class="register-header">
            <div class="logo-wrapper">
                <i class="fas fa-chart-line"></i>
            </div>
            <h2>Buat Akun Baru</h2>
            <p>Bergabunglah dengan Project Management System</p>
        </div>

        <div class="register-body">
            <!-- Flash Messages -->
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <span><?= session()->getFlashdata('error') ?></span>
                </div>
            <?php endif; ?>

            <?php if(session()->getFlashdata('success')): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span><?= session()->getFlashdata('success') ?></span>
                </div>
            <?php endif; ?>

            <!-- Register Form -->
            <form action="<?= base_url('register/process') ?>" method="post" id="registerForm">
                <?= csrf_field() ?>
                
                <!-- Role Selector -->
                <div class="role-selector">
                    <div class="role-card <?= old('role') == 'staff' ? 'active' : '' ?>" onclick="selectRole('staff')" id="role-staff">
                        <i class="fas fa-user-tie"></i>
                        <h3>Staff</h3>
                        <p>Karyawan / Anggota Tim</p>
                    </div>
                    <div class="role-card <?= old('role') == 'client' ? 'active' : '' ?>" onclick="selectRole('client')" id="role-client">
                        <i class="fas fa-building"></i>
                        <h3>Client</h3>
                        <p>Perusahaan / Klien</p>
                    </div>
                </div>
                <input type="hidden" name="role" id="selectedRole" value="<?= old('role') ?>">

                <!-- Data Akun -->
                <div class="form-section">
                    <div class="section-title">
                        <i class="fas fa-user-circle"></i>
                        <div>
                            <h4>Data Akun</h4>
                            <p>Informasi dasar untuk login</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Username <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="username" value="<?= old('username') ?>" placeholder="Masukkan username" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="email" name="email" value="<?= old('email') ?>" placeholder="email@domain.com" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="password" placeholder="Minimal 6 karakter" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Konfirmasi Password <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" placeholder="Ulangi password" required>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Staff Fields -->
                <div id="staffFields" class="form-section <?= old('role') != 'staff' ? 'hidden' : '' ?>">
                    <div class="section-title">
                        <i class="fas fa-id-card"></i>
                        <div>
                            <h4>Data Karyawan</h4>
                            <p>Informasi lengkap staff</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Depan</label>
                            <div class="input-group">
                                <input type="text" name="first_name" value="<?= old('first_name') ?>" placeholder="Nama depan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Belakang</label>
                            <div class="input-group">
                                <input type="text" name="last_name" value="<?= old('last_name') ?>" placeholder="Nama belakang">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> No. Telepon</label>
                            <div class="input-group">
                                <input type="text" name="phone" value="<?= old('phone') ?>" placeholder="Contoh: 08123456789">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar"></i> Tanggal Bergabung</label>
                            <div class="input-group">
                                <input type="date" name="hire_date" value="<?= old('hire_date') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Departemen</label>
                            <div class="input-group">
                                <select name="department_id">
                                    <option value="">Pilih Departemen</option>
                                    <?php foreach ($departments as $dept): ?>
                                        <option value="<?= $dept['id'] ?>" <?= old('department_id') == $dept['id'] ? 'selected' : '' ?>>
                                            <?= $dept['department_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-tag"></i> Posisi</label>
                            <div class="input-group">
                                <select name="position_id">
                                    <option value="">Pilih Posisi</option>
                                    <?php foreach ($positions as $pos): ?>
                                        <option value="<?= $pos['id'] ?>" <?= old('position_id') == $pos['id'] ? 'selected' : '' ?>>
                                            <?= $pos['position_name'] ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Client Fields -->
                <div id="clientFields" class="form-section <?= old('role') != 'client' ? 'hidden' : '' ?>">
                    <div class="section-title">
                        <i class="fas fa-building"></i>
                        <div>
                            <h4>Data Perusahaan</h4>
                            <p>Informasi lengkap client</p>
                        </div>
                    </div>
                    <div class="form-grid">
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Nama Perusahaan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="company_name" value="<?= old('company_name') ?>" placeholder="Nama perusahaan">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user-tie"></i> Contact Person <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="text" name="contact_person" value="<?= old('contact_person') ?>" placeholder="Nama kontak person">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Perusahaan</label>
                            <div class="input-group">
                                <input type="email" name="company_email" value="<?= old('company_email') ?>" placeholder="email@perusahaan.com">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Telepon Perusahaan</label>
                            <div class="input-group">
                                <input type="text" name="company_phone" value="<?= old('company_phone') ?>" placeholder="Nomor telepon">
                            </div>
                        </div>
                        <div class="form-group full-width">
                            <label><i class="fas fa-map-marker-alt"></i> Alamat</label>
                            <div class="input-group">
                                <textarea name="company_address" rows="3" placeholder="Alamat lengkap perusahaan"><?= old('company_address') ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn-register" id="btnRegister">
                    <span class="btn-text">Daftar Sekarang</span>
                    <span class="loading-spinner"></span>
                    <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Login Link -->
            <div class="login-link">
                Sudah punya akun? <a href="<?= base_url('login') ?>">Login disini</a>
            </div>
        </div>
    </div>

    <script>
        function selectRole(role) {
            document.getElementById('selectedRole').value = role;
            document.getElementById('role-staff').classList.remove('active');
            document.getElementById('role-client').classList.remove('active');
            document.getElementById('role-' + role).classList.add('active');
            
            const staffFields = document.getElementById('staffFields');
            const clientFields = document.getElementById('clientFields');
            
            if (role === 'staff') {
                staffFields.classList.remove('hidden');
                clientFields.classList.add('hidden');
            } else {
                clientFields.classList.remove('hidden');
                staffFields.classList.add('hidden');
            }
        }

        <?php if(old('role')): ?>
            selectRole('<?= old('role') ?>');
        <?php endif; ?>

        // Form validation and loading
        const registerForm = document.getElementById('registerForm');
        const btnRegister = document.getElementById('btnRegister');

        if (registerForm) {
            registerForm.addEventListener('submit', function(e) {
                const password = document.querySelector('input[name="password"]');
                const confirmPassword = document.querySelector('input[name="confirm_password"]');
                
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Konfirmasi password tidak cocok!');
                    confirmPassword.focus();
                    return false;
                }
                
                if (password.value.length < 6) {
                    e.preventDefault();
                    alert('Password minimal 6 karakter!');
                    password.focus();
                    return false;
                }
                
                // Show loading state
                btnRegister.classList.add('loading');
                btnRegister.disabled = true;
            });
        }

        // Auto-hide flash messages
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
</body>
</html>