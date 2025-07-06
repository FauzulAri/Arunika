<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];
$furniture_id = (int)($_POST['furniture_id'] ?? 0);
$jumlah = max(1, (int)($_POST['jumlah'] ?? 1));
// Cek stok furniture
$stmt = $conn->prepare("SELECT harga, stok FROM furniture WHERE furniture_id = ? AND is_active = 1");
$stmt->bind_param('i', $furniture_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows < 1) {
    $_SESSION['message'] = 'Produk tidak ditemukan atau tidak aktif!';
    $_SESSION['message_type'] = 'danger';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/Arunika/index.php'));
    exit();
}
$row = $res->fetch_assoc();
$harga = $row['harga'];
$stok = $row['stok'];
if ($jumlah > $stok) {
    $_SESSION['message'] = 'Jumlah melebihi stok tersedia!';
    $_SESSION['message_type'] = 'danger';
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/Arunika/index.php'));
    exit();
}
// Cek apakah sudah ada di keranjang
$stmt2 = $conn->prepare("SELECT jumlah FROM keranjang WHERE user_id = ? AND furniture_id = ?");
$stmt2->bind_param('ii', $user_id, $furniture_id);
$stmt2->execute();
$res2 = $stmt2->get_result();
if ($res2->num_rows > 0) {
    // Update jumlah
    $old = $res2->fetch_assoc();
    $new_jumlah = $old['jumlah'] + $jumlah;
    if ($new_jumlah > $stok) $new_jumlah = $stok;
    $subtotal = $new_jumlah * $harga;
    $stmt3 = $conn->prepare("UPDATE keranjang SET jumlah = ?, harga_satuan = ?, subtotal = ?, updated_at = NOW() WHERE user_id = ? AND furniture_id = ?");
    $stmt3->bind_param('iddii', $new_jumlah, $harga, $subtotal, $user_id, $furniture_id);
    $stmt3->execute();
} else {
    // Insert baru
    $subtotal = $jumlah * $harga;
    $stmt3 = $conn->prepare("INSERT INTO keranjang (user_id, furniture_id, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt3->bind_param('iiidd', $user_id, $furniture_id, $jumlah, $harga, $subtotal);
    $stmt3->execute();
}
$_SESSION['message'] = 'Berhasil menambah ke keranjang!';
$_SESSION['message_type'] = 'success';
if (isset($_POST['beli_sekarang'])) {
    header('Location: /Arunika/view/user/cart/index.php');
} else {
    header('Location: ' . ($_SERVER['HTTP_REFERER'] ?? '/Arunika/index.php'));
}
exit(); 