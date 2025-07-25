<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id_order = intval($_GET['id']);
$sql = "UPDATE orders SET status_order = 'Sedang Dikirim' WHERE id_order = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->close();
echo "Update status OK<br>";

// Kurangi stok produk sesuai jumlah di detail_order
$stmt = $conn->prepare("SELECT furniture_id, jumlah FROM detail_order WHERE id_order = ?");
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->bind_result($furniture_id, $jumlah);
$found = false;
while ($stmt->fetch()) {
    $found = true;
    $update = $conn->prepare("UPDATE furniture SET stok = stok - ? WHERE furniture_id = ?");
    $update->bind_param('ii', $jumlah, $furniture_id);
    $update->execute();
    $update->close();
    echo "Kurangi stok furniture_id=$furniture_id, jumlah=$jumlah<br>";
}
$stmt->close();

if (!$found) {
    echo "Tidak ada detail order ditemukan untuk id_order $id_order<br>";
}

header('Location: ../view/admin/data_order/index.php');
exit();
?>
