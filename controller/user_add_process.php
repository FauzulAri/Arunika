<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
if ($nama && $email && $password) {
    $hash = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $conn->prepare("INSERT INTO user (nama, email, password, alamat, no_hp) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $nama, $email, $hash, $alamat, $no_hp);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'user berhasil ditambahkan!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menambah user: ' . $conn->error;
        $_SESSION['message_type'] = 'danger';
    }
    $stmt->close();
} else {
    $_SESSION['message'] = 'Data tidak lengkap!';
    $_SESSION['message_type'] = 'danger';
}
header('Location: /Arunika/view/admin/data_user/index.php');
exit(); 