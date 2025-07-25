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

// 1. Ambil semua detail order ke array
$stmt = $conn->prepare("SELECT furniture_id, jumlah FROM detail_order WHERE id_order = ?");
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->bind_result($furniture_id, $jumlah);
$details = [];
while ($stmt->fetch()) {
    $details[] = ['furniture_id' => $furniture_id, 'jumlah' => $jumlah];
}
$stmt->close();

if (empty($details)) {
    echo "Tidak ada detail order ditemukan untuk id_order $id_order<br>";
} else {
    // 2. Update stok di luar loop fetch
    foreach ($details as $item) {
        $update = $conn->prepare("UPDATE furniture SET stok = stok - ? WHERE furniture_id = ?");
        $update->bind_param('ii', $item['jumlah'], $item['furniture_id']);
        $update->execute();
        $update->close();
        echo "Kurangi stok furniture_id={$item['furniture_id']}, jumlah={$item['jumlah']}<br>";
    }
}

header('Location: ../view/admin/data_order/index.php');
exit();
?>
