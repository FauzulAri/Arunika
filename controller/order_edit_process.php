<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id = (int)($_POST['order_id'] ?? 0);
$status = $_POST['status_order'] ?? '';
$alamat = trim($_POST['alamat_pengiriman'] ?? '');
$nama = trim($_POST['nama_penerima'] ?? '');
$no_hp = trim($_POST['no_hp_penerima'] ?? '');
$catatan = trim($_POST['catatan'] ?? '');
if ($id && $status && $alamat && $nama && $no_hp) {
    $stmt = $conn->prepare("UPDATE orders SET status_order=?, alamat_pengiriman=?, nama_penerima=?, no_hp_penerima=?, catatan=? WHERE order_id=?");
    $stmt->bind_param('sssssi', $status, $alamat, $nama, $no_hp, $catatan, $id);
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Order berhasil diupdate!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal update order: ' . $conn->error;
        $_SESSION['message_type'] = 'danger';
    }
    $stmt->close();
} else {
    $_SESSION['message'] = 'Data tidak lengkap!';
    $_SESSION['message_type'] = 'danger';
}
header('Location: /Arunika/view/admin/data_order/index.php');
exit(); 