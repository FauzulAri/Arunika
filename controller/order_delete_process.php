<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id = (int)($_GET['id'] ?? 0);
if ($id) {
    $stmt = $conn->prepare("DELETE FROM orders WHERE order_id = ?");
    $stmt->bind_param('i', $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Order berhasil dihapus!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal hapus order: ' . $conn->error;
        $_SESSION['message_type'] = 'danger';
    }
    $stmt->close();
} else {
    $_SESSION['message'] = 'ID order tidak valid!';
    $_SESSION['message_type'] = 'danger';
}
header('Location: /Arunika/view/admin/data_order/index.php');
exit(); 