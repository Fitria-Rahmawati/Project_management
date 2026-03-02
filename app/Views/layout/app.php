<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard Sistem Informasi' ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
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

</body>
</html>