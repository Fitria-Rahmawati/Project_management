<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title><?= $title ?? 'Dashboard' ?></title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f1f5f9;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: #1e293b;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            padding: 20px;
        }

        /* HEADER */
        .header {
            height: 60px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            padding: 0 30px;
            display: flex;
            align-items: center;
            margin-left: 250px;
        }

        /* CONTENT */
        .content {
            margin-left: 250px;
            padding: 30px;
            min-height: calc(100vh - 120px);
        }

        .container {
            max-width: 1100px;
            margin: auto;
        }

        /* FOOTER */
        .footer {
            margin-left: 250px;
            background: #ffffff;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            padding: 15px;
            font-size: 14px;
            color: #64748b;
        }

        /* CARD */
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0,0,0,.08);
        }

        .card h4 {
            margin-bottom: 8px;
            font-size: 15px;
            color: #475569;
        }

        .card p {
            font-size: 22px;
            font-weight: bold;
            margin: 0;
        }
    </style>
</head>
<body>

    <?= view('layout/sidebar') ?>
    <?= view('layout/header') ?>

    <main class="content">
        <div class="container">
            <?= $this->renderSection('content') ?>
        </div>
    </main>

    <?= view('layout/footer') ?>

</body>
</html>