<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Dashboard Sistem Informasi' ?></title>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">

    <style>
        /* Tambahkan sedikit reset agar layout lebih modern */
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            background-color: #f8f9fc;
        }
        .wrapper {
            display: flex;
            min-height: 100vh;
        }
        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }
        .content {
            padding: 20px;
            flex: 1;
        }
    </style>
</head>
<body>

<div class="wrapper">

    <?= $this->include('layout/sidebar') ?>

    <div class="main-content">
        <?= $this->include('layout/header') ?>

        <main class="content">
            <?= $this->renderSection('content') ?>
        </main>

        <?= $this->include('layout/footer') ?>
    </div>

</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>