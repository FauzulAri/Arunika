<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
session_start();

// Mengambil data dari form pendaftaran pengguna
$nama = $_POST['nama'];
$email = $_POST['email'];
$password = $_POST['password'];
$konfirmasi_password = $_POST['konfirmasi_password'];
$tanggal_daftar = date('Y-m-d H:i:s');

// Validasi konfirmasi password
if ($password !== $konfirmasi_password) {
    echo "<script>alert('Konfirmasi password tidak sesuai!'); window.history.back();</script>";
    exit;
}

// Hash password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Cek email sudah terdaftar
$stmt_cek = $conn->prepare("SELECT user_id FROM user WHERE email = ?");
$stmt_cek->bind_param("s", $email);
$stmt_cek->execute();
$stmt_cek->store_result();
if ($stmt_cek->num_rows > 0) {
    echo "<script>alert('Email sudah terdaftar!'); window.history.back();</script>";
    $stmt_cek->close();
    exit;
}
$stmt_cek->close();

// Insert user baru
$role = 'user'; // default role
$foto = null;   // default foto

$stmt = $conn->prepare("INSERT INTO user (nama, email, password, role, foto, tanggal_daftar) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $nama, $email, $hashed_password, $role, $foto, $tanggal_daftar);

if ($stmt->execute()) {
    echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='/Arunika/view/auth/login.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
