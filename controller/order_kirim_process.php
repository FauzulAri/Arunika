<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id_order = intval($_GET['id']);
$sql = "UPDATE orders SET status_order = 'Sedang Dikirim' WHERE id_order = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->close();

// Kurangi stok produk sesuai jumlah di detail_order
$stmt = $conn->prepare("SELECT furniture_id, jumlah FROM detail_order WHERE id_order = ?");
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->bind_result($furniture_id, $jumlah);
while ($stmt->fetch()) {
    $update = $conn->prepare("UPDATE furniture SET stok = stok - ? WHERE furniture_id = ?");
    $update->bind_param('ii', $jumlah, $furniture_id);
    $update->execute();
    $update->close();
}
$stmt->close();

header('Location: ../view/admin/data_order/index.php');
exit();
?>
