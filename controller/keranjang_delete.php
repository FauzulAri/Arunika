<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$keranjang_id = (int)($_POST['keranjang_id'] ?? 0);
if (!$keranjang_id) {
    $_SESSION['message'] = 'Permintaan tidak valid!';
    $_SESSION['message_type'] = 'danger';
    header('Location: /Arunika/view/user/cart/index.php');
    exit();
}
$conn->query("DELETE FROM keranjang WHERE keranjang_id = $keranjang_id AND user_id = " . $_SESSION['user_id']);
$_SESSION['message'] = 'Barang berhasil dihapus dari keranjang!';
$_SESSION['message_type'] = 'success';
header('Location: /Arunika/view/user/cart/index.php');
exit(); 