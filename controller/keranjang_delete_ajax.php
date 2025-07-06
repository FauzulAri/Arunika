<?php
session_start();
header('Content-Type: application/json');
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success'=>false, 'message'=>'Silakan login terlebih dahulu!']);
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$keranjang_id = (int)($_POST['keranjang_id'] ?? 0);
if (!$keranjang_id) {
    echo json_encode(['success'=>false, 'message'=>'Permintaan tidak valid!']);
    exit();
}
$conn->query("DELETE FROM keranjang WHERE keranjang_id = $keranjang_id AND user_id = " . $_SESSION['user_id']);
echo json_encode(['success'=>true, 'message'=>'Barang berhasil dihapus dari keranjang!']); 