<?php
// midtrans_notification.php

// Ambil data notifikasi dari Midtrans
$json = file_get_contents('php://input');
$notif = json_decode($json, true);

// Koneksi ke database
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Ambil order_id dari notifikasi
$order_id = $notif['order_id'] ?? null;
$transaction_status = $notif['transaction_status'] ?? null;

if ($order_id && $transaction_status) {
    // Ambil hanya 3 bagian pertama dari order_id
    $order_id_parts = explode('-', $order_id);
    $order_id_db = implode('-', array_slice($order_id_parts, 0, 23));

    if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'diproses' WHERE nomor_order = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    }
}

http_response_code(200); // Beri response OK ke Midtrans
echo 'OK';