<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id = (int)($_POST['user_id'] ?? 0);
$nama = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';
$alamat = trim($_POST['alamat'] ?? '');
$no_hp = trim($_POST['no_hp'] ?? '');
if ($id && $nama && $email) {
    if ($password) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE user SET nama=?, email=?, password=?, alamat=?, no_hp=? WHERE user_id=?");
        $stmt->bind_param('sssssi', $nama, $email, $hash, $alamat, $no_hp, $id);
    } else {
        $stmt = $conn->prepare("UPDATE user SET nama=?, email=?, alamat=?, no_hp=? WHERE user_id=?");
        $stmt->bind_param('ssssi', $nama, $email, $alamat, $no_hp, $id);
    }
    if ($stmt->execute()) {
        $_SESSION['message'] = 'User berhasil diupdate!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal update user: ' . $conn->error;
        $_SESSION['message_type'] = 'danger';
    }
    $stmt->close();
} else {
    $_SESSION['message'] = 'Data tidak lengkap!';
    $_SESSION['message_type'] = 'danger';
}
header('Location: /Arunika/view/admin/data_user/index.php');
exit(); 