<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'Email' ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background-color: #f0f2f5;
            padding: 20px;
            line-height: 1.6;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        .email-header {
            background: linear-gradient(135deg, #4e73df 0%, #764ba2 100%);
            padding: 30px;
            text-align: center;
            color: white;
        }
        .email-header h1 { margin: 0; font-size: 24px; font-weight: 600; }
        .email-header p { margin: 10px 0 0; opacity: 0.9; font-size: 14px; }
        .email-body { padding: 30px; }
        .greeting { font-size: 16px; margin-bottom: 20px; color: #333; }
        .greeting strong { color: #4e73df; }
        .content-box {
            background: #f8f9fc;
            border-left: 4px solid #4e73df;
            padding: 15px 20px;
            margin: 20px 0;
            border-radius: 8px;
        }
        .content-box.warning { background: #fff3e0; border-left-color: #f6c23e; }
        .content-box.danger { background: #fee2e2; border-left-color: #e74a3b; }
        .content-box.success { background: #e3f9e9; border-left-color: #1cc88a; }
        .content-box.info { background: #e1f5fe; border-left-color: #36b9cc; }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #4e73df, #764ba2);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            margin: 20px 0;
            font-weight: 600;
            text-align: center;
        }
        .button:hover { opacity: 0.9; }
        .info-list { list-style: none; padding: 0; margin: 15px 0; }
        .info-list li { padding: 8px 0; border-bottom: 1px solid #e3e6f0; }
        .info-list li strong { color: #4e73df; width: 140px; display: inline-block; }
        .deadline-soon { color: #f6c23e; font-weight: bold; }
        .deadline-overdue { color: #e74a3b; font-weight: bold; }
        .email-footer {
            background: #f8f9fc;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #858796;
            border-top: 1px solid #e3e6f0;
        }
        .email-footer a { color: #4e73df; text-decoration: none; }
        @media (max-width: 600px) {
            .email-container { border-radius: 0; }
            .email-body { padding: 20px; }
            .info-list li strong { width: 100%; display: block; margin-bottom: 5px; }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>📊 <?= isset($title) ? $title : 'Email' ?></h1>
            <p><?= isset($companyName) ? $companyName : 'Company Name' ?></p>
        </div>
        
        <div class="email-body">
            <div class="greeting">
                Halo, <strong><?= isset($userName) && is_string($userName) ? esc($userName) : 'User' ?></strong>
            </div>
            
            <?= isset($content) ? $content : '' ?>
            
            <?php if (!empty($buttonText) && !empty($buttonLink)): ?>
            <div style="text-align: center;">
                <a href="<?= $buttonLink ?>" class="button"><?= $buttonText ?></a>
            </div>
            <?php endif; ?>
            
            <?php if (!empty($additionalInfo)): ?>
            <div class="content-box info">
                <p><strong>💡 Informasi Tambahan:</strong></p>
                <p><?= $additionalInfo ?></p>
            </div>
            <?php endif; ?>
        </div>
        
        <div class="email-footer">
            <p>&copy; <?= date('Y') ?> <?= isset($companyName) ? $companyName : 'Company Name' ?> - All Rights Reserved</p>
            <p><small>Email ini dikirim secara otomatis, mohon tidak membalas email ini.</small></p>
            <p><small>Jika ada pertanyaan, silakan hubungi <a href="mailto:support@vitechasia.com">support@vitechasia.com</a></small></p>
        </div>
    </div>
</body>
</html>