<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$user_id = $_POST['user_id'];
$nama = $_POST['nama'];
$email = $_POST['email'];
// Tambahkan field lain sesuai kebutuhan

$stmt = $conn->prepare("UPDATE user SET nama = ?, email = ? WHERE user_id = ?");
$stmt->bind_param('ssi', $nama, $email, $user_id);
if ($stmt->execute()) {
    // Redirect ke halaman list user atau detail user
    header('Location: /Arunika/view/admin/data_user/index.php?update=success');
} else {
    // Tampilkan pesan error
    echo "Gagal update user: " . $stmt->error;
}
$stmt->close();
?> 