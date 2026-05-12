<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Project Management System</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
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

        /* ==================== LOGIN CONTAINER ==================== */
        .login-container {
            background: white;
            max-width: 460px;
            width: 100%;
            padding: 45px 40px;
            border-radius: 28px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.15);
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
        .login-header {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-wrapper {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary-light), #f0e6ff);
            border-radius: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.15);
        }

        .logo-wrapper i {
            font-size: 38px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .login-header h2 {
            font-size: 28px;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 8px;
        }

        .login-header p {
            color: var(--gray);
            font-size: 14px;
            font-weight: 400;
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

        /* ==================== FORM ==================== */
        .form-group {
            margin-bottom: 24px;
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

        .input-group {
            position: relative;
        }

        .input-group i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--primary);
            font-size: 18px;
            transition: all 0.3s;
            opacity: 0.6;
        }

        .input-group input {
            width: 100%;
            padding: 14px 16px 14px 48px;
            border: 2px solid var(--border);
            border-radius: 14px;
            font-family: 'Inter', sans-serif;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
            background: var(--bg-light);
        }

        .input-group input:focus {
            outline: none;
            border-color: var(--primary);
            background: white;
            box-shadow: 0 0 0 4px rgba(78, 115, 223, 0.1);
        }

        .input-group input:focus + i {
            opacity: 1;
        }

        .input-group input:hover {
            border-color: #cbd5e1;
            background: white;
        }

        .input-group input::placeholder {
            color: #cbd5e1;
            font-weight: 400;
        }

        /* ==================== FORM OPTIONS ==================== */
        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 28px;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .remember-me input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            accent-color: var(--primary);
            border-radius: 4px;
        }

        .remember-me label {
            color: var(--gray);
            font-size: 13px;
            cursor: pointer;
            font-weight: 500;
        }

        .forgot-password {
            color: var(--primary);
            font-size: 13px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .forgot-password:hover {
            color: var(--secondary);
            text-decoration: underline;
        }

        /* ==================== BUTTON ==================== */
        .btn-login {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, var(--primary), var(--secondary));
            border: none;
            border-radius: 14px;
            color: white;
            font-family: 'Inter', sans-serif;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s;
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-login:active {
            transform: translateY(0);
        }

        /* ==================== LOADING STATE ==================== */
        .btn-login.loading {
            opacity: 0.8;
            cursor: wait;
        }

        .btn-login.loading .btn-text {
            display: none;
        }

        .btn-login.loading .loading-spinner {
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

        /* ==================== CAPTCHA ==================== */
        .captcha-wrapper {
            margin-bottom: 20px;
            display: flex;
            justify-content: center;
            transform: scale(0.95);
        }

        /* ==================== FOOTER ==================== */
        .login-footer {
            text-align: center;
            margin-top: 28px;
            padding-top: 24px;
            border-top: 1px solid var(--border);
        }

        .login-footer p {
            color: var(--gray);
            font-size: 13px;
        }

        /* ==================== RESPONSIVE ==================== */
        @media (max-width: 480px) {
            .login-container {
                padding: 35px 25px;
                border-radius: 24px;
            }

            .login-header h2 {
                font-size: 24px;
            }

            .logo-wrapper {
                width: 60px;
                height: 60px;
            }

            .logo-wrapper i {
                font-size: 30px;
            }

            .form-options {
                flex-direction: column;
                gap: 15px;
                align-items: flex-start;
            }

            .captcha-wrapper {
                transform: scale(0.85);
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <!-- Header -->
        <div class="login-header">
            <div class="logo-wrapper">
                <i class="fas fa-chart-line"></i>
            </div>
            <h2>Project System</h2>
            <p>Login untuk mengakses dashboard</p>
        </div>

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

        <?php if(session()->getFlashdata('captcha_error')): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <span><?= session()->getFlashdata('captcha_error') ?></span>
            </div>
        <?php endif; ?>

        <?php if(session()->getFlashdata('contract_warning')): ?>
            <div class="alert alert-error" style="background: #fff3e0; border-left-color: #f6c23e; color: #e65100;">
                <i class="fas fa-exclamation-triangle"></i>
                <span><?= session()->getFlashdata('contract_warning') ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form action="<?= base_url('login/process') ?>" method="post" id="loginForm">
            <?= csrf_field() ?>

            <div class="form-group">
                <label for="email">
                    <i class="fas fa-envelope"></i> EMAIL / USERNAME
                </label>
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input 
                        type="text" 
                        id="email"
                        name="email" 
                        placeholder="Masukkan email atau username" 
                        value="<?= old('email') ?>" 
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="form-group">
                <label for="password">
                    <i class="fas fa-lock"></i> PASSWORD
                </label>
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input 
                        type="password" 
                        id="password"
                        name="password" 
                        placeholder="Masukkan password" 
                        required
                    >
                </div>
            </div>

            <div class="captcha-wrapper">
                <div class="g-recaptcha" data-sitekey="<?= getenv('GOOGLE_RECAPTCHA_SITE_KEY') ?>"></div>
            </div>

            <div class="form-options">
                <div class="remember-me">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Ingat saya</label>
                </div>
                <a href="<?= base_url('forgot-password') ?>" class="forgot-password">
                    Lupa password?
                </a>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">
                <span class="btn-text">Login</span>
                <span class="loading-spinner"></span>
                <i class="fas fa-arrow-right"></i>
            </button>
        </form>

        <!-- Footer (tanpa link registrasi) -->
        <div class="login-footer">
            <p>
                &copy; <?= date('Y') ?> Project Management System - PT Vitech Asia
            </p>
            <p style="font-size: 11px; margin-top: 8px;">
                <i class="fas fa-shield-alt"></i> Sistem ini hanya untuk pengguna yang terdaftar
            </p>
        </div>
    </div>

    <script>
        // Loading state on form submit
        const loginForm = document.getElementById('loginForm');
        const btnLogin = document.getElementById('btnLogin');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                // Basic validation
                const email = document.getElementById('email').value;
                const password = document.getElementById('password').value;
                
                if (!email.trim()) {
                    e.preventDefault();
                    showAlert('Email/Username wajib diisi!', 'error');
                    return false;
                }
                
                if (!password.trim()) {
                    e.preventDefault();
                    showAlert('Password wajib diisi!', 'error');
                    return false;
                }
                
                // Show loading state
                btnLogin.classList.add('loading');
                btnLogin.disabled = true;
            });
        }

        // Custom alert function
        function showAlert(message, type) {
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type}`;
            alertDiv.innerHTML = `<i class="fas fa-${type === 'error' ? 'exclamation-circle' : 'check-circle'}"></i><span>${message}</span>`;
            
            const container = document.querySelector('.login-container');
            const header = document.querySelector('.login-header');
            container.insertBefore(alertDiv, header.nextSibling);
            
            setTimeout(() => {
                alertDiv.style.opacity = '0';
                setTimeout(() => alertDiv.remove(), 500);
            }, 4000);
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