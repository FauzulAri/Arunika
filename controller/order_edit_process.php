<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id_order = (int)($_POST['id_order'] ?? 0);
$status_order = $_POST['status_order'] ?? '';
$alamat_pengiriman = $_POST['alamat_pengiriman'] ?? '';
$nama_penerima = $_POST['nama_penerima'] ?? '';
$no_hp_penerima = $_POST['no_hp_penerima'] ?? '';
$catatan = $_POST['catatan'] ?? '';
if ($id_order && $status_order && $alamat_pengiriman && $nama_penerima && $no_hp_penerima) {
    $stmt = $conn->prepare("UPDATE orders SET status_order=?, alamat_pengiriman=?, nama_penerima=?, no_hp_penerima=?, catatan=? WHERE id_order=?");
    $stmt->bind_param('sssssi', $status_order, $alamat_pengiriman, $nama_penerima, $no_hp_penerima, $catatan, $id_order);
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
header('Location: ../view/admin/data_order/index.php');
exit(); 