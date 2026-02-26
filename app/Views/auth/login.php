<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Login - project System</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<style>

*{box-sizing:border-box;}

body{
    margin:0;
    font-family:'Poppins', sans-serif;
    background: linear-gradient(135deg,#4e73df,#224abe);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

.login-container{
    background:white;
    padding:40px;
    width:400px;
    border-radius:15px;
    box-shadow:0 20px 45px rgba(0,0,0,0.2);
}

.title{
    text-align:center;
    margin-bottom:30px;
}

.title i{
    font-size:50px;
    color:#4e73df;
}

.title h2{
    margin:10px 0 0;
    color:#4e73df;
}

.subtitle{
    font-size:13px;
    color:#777;
}

.error{
    background:#ffd2d2;
    color:#b30000;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}

.success{
    background:#d4edda;
    color:#155724;
    padding:10px;
    border-radius:8px;
    margin-bottom:15px;
    text-align:center;
}

.input-group{
    position:relative;
    margin-bottom:20px;
}

.input-group i{
    position:absolute;
    top:50%;
    left:12px;
    transform:translateY(-50%);
    color:#4e73df;
}

.input-group input{
    width:100%;
    padding:12px 12px 12px 40px;
    border-radius:8px;
    border:1px solid #ddd;
}

.input-group input:focus{
    outline:none;
    border-color:#4e73df;
}

button{
    width:100%;
    padding:12px;
    border:none;
    border-radius:8px;
    background:#4e73df;
    color:white;
    font-weight:bold;
    cursor:pointer;
}

button:hover{
    background:#2e59d9;
}

.footer{
    text-align:center;
    margin-top:20px;
    font-size:14px;
}

.footer a{
    color:#4e73df;
    text-decoration:none;
    font-weight:600;
}

.footer a:hover{
    text-decoration:underline;
}

</style>
</head>
<body>
    <div class="login-container">
        <div class="title">
            <i class="fa fa-ticket"></i>
            <h2>Project System</h2>
            <div class="subtitle">
                Silakan login
            </div>
        </div>
        <?php if(session()->getFlashdata('success')): ?>
            <div class="success">
                <?= session()->getFlashdata('success') ?>
            </div>
        <?php endif;?>
        <?php if(session()->getFlashdata('error')): ?>
            <div class="error">
                <?= session()->getFlashdata('error') ?>
            </div>
        <?php endif;?>
        <form action="<?= base_url('login/process') ?>" method="post">
            <div class="input-group">
                <i class="fa fa-envelope"></i>
                <input type="email"name="email"placeholder="Masukkan Email"required>
            </div>
            <div class="input-group">
                <i class="fa fa-lock"></i>
                <input type="password"name="password"placeholder="Masukkan Password"required>
            </div>
            <button type="submit">
                <i class="fa fa-sign-in-alt"></i> Login
            </button>
        </form>
        <div class="footer">Belum punya akun?<a href="<?= base_url('register') ?>">Register</a></div>
    </div>
</body>
</html>