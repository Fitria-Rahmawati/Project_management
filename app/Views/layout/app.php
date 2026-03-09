<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Project Management System' ?></title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8f9fa;
        }
        .wrapper {
            display: flex;
            width: 100%;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            min-height: 100vh;
            transition: all 0.3s;
            background: white;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }
        #content {
            flex: 1;
            min-width: 0;
        }
        .nav-link.active {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white !important;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #764ba2, #667eea);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.3);
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <div id="sidebar">
            <?= $this->include('layout/sidebar') ?>
        </div>
        <div id="content">
            <?= $this->include('layout/navbar') ?>
            <main class="p-4">
                <?= $this->renderSection('content') ?>
            </main>
            <footer class="bg-white text-center py-3 mt-4 border-top">
                <small class="text-muted">
                    &copy; <?= date('Y') ?> Project Management System. All rights reserved.
                </small>
            </footer>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- jQuery (optional) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        setTimeout(function() {
            let alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                let bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
    
    <?= $this->renderSection('scripts') ?>
</body>
</html>