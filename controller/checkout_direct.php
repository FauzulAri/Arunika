<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
if (!isset($_POST['furniture_id']) || !isset($_POST['jumlah'])) {
    header('Location: /Arunika/view/user/product/furniture.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];
$furniture_id = (int)$_POST['furniture_id'];
$jumlah = max(1, (int)$_POST['jumlah']);
$catatan = isset($_POST['catatan']) ? trim($_POST['catatan']) : '';
// Cek stok furniture
$stmt = $conn->prepare('SELECT stok FROM furniture WHERE furniture_id = ? AND is_active = 1');
$stmt->bind_param('i', $furniture_id);
$stmt->execute();
$stmt->bind_result($stok);
$stmt->fetch();
$stmt->close();
if ($jumlah > $stok) {
    echo "<script>alert('Jumlah melebihi stok tersedia!'); window.history.back();</script>";
    exit();
}
// Tambahkan ke keranjang (sementara, jika belum ada)
$stmt = $conn->prepare('SELECT keranjang_id FROM keranjang WHERE user_id = ? AND furniture_id = ?');
$stmt->bind_param('ii', $user_id, $furniture_id);
$stmt->execute();
$stmt->bind_result($keranjang_id);
if ($stmt->fetch()) {
    // Update jumlah
    $stmt->close();
    $stmt2 = $conn->prepare('UPDATE keranjang SET jumlah = ?, subtotal = jumlah * harga_satuan, updated_at = NOW() WHERE keranjang_id = ?');
    $stmt2->bind_param('ii', $jumlah, $keranjang_id);
    $stmt2->execute();
    $stmt2->close();
} else {
    $stmt->close();
    // Ambil harga
    $stmt3 = $conn->prepare('SELECT harga FROM furniture WHERE furniture_id = ?');
    $stmt3->bind_param('i', $furniture_id);
    $stmt3->execute();
    $stmt3->bind_result($harga);
    $stmt3->fetch();
    $stmt3->close();
    $subtotal = $jumlah * $harga;
    $stmt4 = $conn->prepare('INSERT INTO keranjang (user_id, furniture_id, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)');
    $stmt4->bind_param('iiidd', $user_id, $furniture_id, $jumlah, $harga, $subtotal);
    $stmt4->execute();
    $keranjang_id = $conn->insert_id;
    $stmt4->close();
}
// Redirect ke checkout.php hanya dengan produk ini
header('Location: /Arunika/view/user/cart/checkout.php?direct=1&keranjang_ids=' . $keranjang_id . '&catatan=' . urlencode($catatan));
exit(); 