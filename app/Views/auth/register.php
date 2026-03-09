<?php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Project Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 40px 20px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .register-container {
            max-width: 800px;
            width: 100%;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .register-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            padding: 30px;
            text-align: center;
            color: white;
        }

        .register-header i {
            font-size: 50px;
            margin-bottom: 15px;
        }

        .register-header h2 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .register-header p {
            opacity: 0.9;
            font-size: 14px;
        }

        .register-body {
            padding: 40px;
        }

        .alert {
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: #fee;
            color: #c33;
            border-left: 4px solid #c33;
        }

        .alert-success {
            background: #e8f5e9;
            color: #2e7d32;
            border-left: 4px solid #2e7d32;
        }

        .role-selector {
            display: flex;
            gap: 20px;
            margin-bottom: 30px;
            justify-content: center;
        }

        .role-card {
            flex: 1;
            border: 2px solid #e0e0e0;
            border-radius: 12px;
            padding: 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s;
        }

        .role-card:hover {
            border-color: #667eea;
            background: #f8f9ff;
        }

        .role-card.active {
            border-color: #667eea;
            background: #f0f3ff;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.2);
        }

        .role-card i {
            font-size: 40px;
            color: #667eea;
            margin-bottom: 10px;
        }

        .role-card h3 {
            font-size: 18px;
            margin-bottom: 5px;
            color: #333;
        }

        .role-card p {
            font-size: 12px;
            color: #888;
        }

        .form-section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }

        .form-section h4 {
            color: #667eea;
            margin-bottom: 20px;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .form-section h4 i {
            font-size: 18px;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #555;
            font-size: 14px;
            font-weight: 500;
        }

        .form-group label i {
            color: #667eea;
            margin-right: 8px;
            width: 16px;
        }

        .input-group {
            position: relative;
        }

        .input-group input,
        .input-group select,
        .input-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-size: 14px;
            transition: all 0.3s;
            background: #fafafa;
        }

        .input-group input:focus,
        .input-group select:focus,
        .input-group textarea:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 4px rgba(102, 126, 234, 0.1);
        }

        .btn-register {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            border-radius: 10px;
            color: white;
            font-family: 'Poppins', sans-serif;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .btn-register:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .login-link {
            text-align: center;
            margin-top: 20px;
            color: #888;
            font-size: 14px;
        }

        .login-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        .hidden {
            display: none;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <i class="fas fa-user-plus"></i>
            <h2>Daftar Akun Baru</h2>
            <p>Isi data dengan lengkap untuk mendaftar</p>
        </div>

        <div class="register-body">
            <?php if(session()->getFlashdata('error')): ?>
                <div class="alert alert-error">
                    <i class="fas fa-exclamation-circle"></i>
                    <?= session()->getFlashdata('error') ?>
                </div>
            <?php endif; ?>

            <form action="<?= base_url('register/process') ?>" method="post" id="registerForm">
                <?= csrf_field() ?>
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
                <div class="form-section">
                    <h4><i class="fas fa-user-circle"></i> Data Akun</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Username</label>
                            <div class="input-group">
                                <input type="text" name="username" value="<?= old('username') ?>" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email</label>
                            <div class="input-group">
                                <input type="email" name="email" value="<?= old('email') ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Password</label>
                            <div class="input-group">
                                <input type="password" name="password" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-lock"></i> Konfirmasi Password</label>
                            <div class="input-group">
                                <input type="password" name="confirm_password" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="staffFields" class="form-section <?= old('role') != 'staff' ? 'hidden' : '' ?>">
                    <h4><i class="fas fa-id-card"></i> Data Karyawan (Staff)</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Depan</label>
                            <div class="input-group">
                                <input type="text" name="first_name" value="<?= old('first_name') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user"></i> Nama Belakang</label>
                            <div class="input-group">
                                <input type="text" name="last_name" value="<?= old('last_name') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-briefcase"></i> Departemen</label>
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
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> No. Telepon</label>
                            <div class="input-group">
                                <input type="text" name="phone" value="<?= old('phone') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-calendar"></i> Tanggal Bergabung</label>
                            <div class="input-group">
                                <input type="date" name="hire_date" value="<?= old('hire_date') ?>">
                            </div>
                        </div>
                    </div>
                </div>
                <div id="clientFields" class="form-section <?= old('role') != 'client' ? 'hidden' : '' ?>">
                    <h4><i class="fas fa-building"></i> Data Perusahaan (Client)</h4>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-building"></i> Nama Perusahaan</label>
                            <div class="input-group">
                                <input type="text" name="company_name" value="<?= old('company_name') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-user-tie"></i> Contact Person</label>
                            <div class="input-group">
                                <input type="text" name="contact_person" value="<?= old('contact_person') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label><i class="fas fa-envelope"></i> Email Perusahaan</label>
                            <div class="input-group">
                                <input type="email" name="company_email" value="<?= old('company_email') ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label><i class="fas fa-phone"></i> Telepon Perusahaan</label>
                            <div class="input-group">
                                <input type="text" name="company_phone" value="<?= old('company_phone') ?>">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label><i class="fas fa-map-marker-alt"></i> Alamat</label>
                        <div class="input-group">
                            <textarea name="company_address" rows="3"><?= old('company_address') ?></textarea>
                        </div>
                    </div>
                </div>

                <button type="submit" class="btn-register">
                    <i class="fas fa-user-plus"></i> Daftar Sekarang
                </button>
            </form>

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
            if (role === 'staff') {
                document.getElementById('staffFields').classList.remove('hidden');
                document.getElementById('clientFields').classList.add('hidden');
                document.querySelectorAll('#clientFields input, #clientFields select, #clientFields textarea').forEach(field => {
                    field.required = false;
                });
                document.querySelectorAll('#staffFields input[type="text"], #staffFields select').forEach(field => {
                    field.required = true;
                });
            } else {
                document.getElementById('clientFields').classList.remove('hidden');
                document.getElementById('staffFields').classList.add('hidden');
                document.querySelectorAll('#staffFields input, #staffFields select').forEach(field => {
                    field.required = false;
                });
                document.querySelectorAll('#clientFields input[type="text"], #clientFields input[type="email"], #clientFields textarea').forEach(field => {
                    field.required = true;
                });
            }
        }
        <?php if(old('role')): ?>
            selectRole('<?= old('role') ?>');
        <?php endif; ?>
    </script>
</body>
</html>