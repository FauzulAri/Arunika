<?php
session_start();
// Contoh login hardcode (bisa diganti cek ke database Admin)
$admin_username = 'admin';
$admin_password = 'admin123'; // Ganti dengan password yang aman

$username = $_POST['username'];
$password = $_POST['password'];

if ($username === $admin_username && $password === $admin_password) {
    $_SESSION['admin_id'] = 1;
    $_SESSION['admin_username'] = $admin_username;
    header('Location: /Arunika/view/admin/home/index.php');
    exit();
} else {
    echo "<script>alert('Username atau password salah!'); window.location.href='/Arunika/view/admin/auth/signin.php';</script>";
    exit();
}
