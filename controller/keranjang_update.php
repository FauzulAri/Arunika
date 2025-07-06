<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$keranjang_id = (int)($_POST['keranjang_id'] ?? 0);
$action = $_POST['action'] ?? '';
if (!$keranjang_id || !in_array($action, ['plus','minus'])) {
    $_SESSION['message'] = 'Permintaan tidak valid!';
    $_SESSION['message_type'] = 'danger';
    header('Location: /Arunika/view/user/cart/index.php');
    exit();
}
// Ambil data keranjang dan stok furniture
$q = $conn->query("SELECT k.jumlah, f.stok FROM keranjang k JOIN furniture f ON k.furniture_id = f.furniture_id WHERE k.keranjang_id = $keranjang_id AND k.user_id = " . $_SESSION['user_id']);
if ($q->num_rows < 1) {
    $_SESSION['message'] = 'Data keranjang tidak ditemukan!';
    $_SESSION['message_type'] = 'danger';
    header('Location: /Arunika/view/user/cart/index.php');
    exit();
}
$row = $q->fetch_assoc();
$jumlah = (int)$row['jumlah'];
$stok = (int)$row['stok'];
if ($action == 'plus' && $jumlah < $stok) $jumlah++;
if ($action == 'minus' && $jumlah > 1) $jumlah--;
$conn->query("UPDATE keranjang SET jumlah = $jumlah, subtotal = jumlah * harga_satuan, updated_at = NOW() WHERE keranjang_id = $keranjang_id");
$_SESSION['message'] = 'Jumlah barang berhasil diupdate!';
$_SESSION['message_type'] = 'success';
header('Location: /Arunika/view/user/cart/index.php');
exit(); 