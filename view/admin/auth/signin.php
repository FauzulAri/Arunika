<?php
ob_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Arunika</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(120deg, #f7f7fa 60%, #e9e6f7 100%);
            min-height: 100vh;
        }
        .login-card {
            border-radius: 18px;
            box-shadow: 0 4px 32px #0002;
            background: #fff;
        }
        .login-title {
            font-weight: 700;
            color: #7c5fe6;
            letter-spacing: 1px;
        }
        .form-label {
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height: 150vh;">
    <div class="login-card p-4 shadow w-100" style="max-width: 400px;">
        <h3 class="mb-4 text-center login-title">Login Admin</h3>
        <form action="/Arunika/controller/admin_login_process.php" method="post" autocomplete="off">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required autofocus>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>
        <div class="text-center mt-3">
            <a href="/Arunika/view/admin/home/index.php" class="small text-decoration-none text-secondary">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
echo ob_get_clean();
?> 