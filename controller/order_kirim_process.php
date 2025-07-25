<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id_order = intval($_GET['id']);
$sql = "UPDATE orders SET status_order = 'Sedang Dikirim' WHERE id_order = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->close();
header('Location: ../view/admin/data_order/index.php');
exit();
?>
