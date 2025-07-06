<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $conn->prepare("DELETE FROM user WHERE user_id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'User berhasil dihapus!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal hapus user: ' . $conn->error;
        $_SESSION['message_type'] = 'danger';
    }
    $stmt->close();
} else {
    $_SESSION['message'] = 'ID user tidak valid!';
    $_SESSION['message_type'] = 'danger';
}
header('Location: /Arunika/view/admin/data_user/index.php');
exit(); 