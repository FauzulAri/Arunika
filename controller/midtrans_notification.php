<?php
// midtrans_notification.php

// Ambil data notifikasi dari Midtrans
$json = file_get_contents('php://input');
$notif = json_decode($json, true);

// Koneksi ke database
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Ambil order_id dan status dari notifikasi
$order_id = $notif['order_id'] ?? null;
$transaction_status = $notif['transaction_status'] ?? null;
$fraud_status = $notif['fraud_status'] ?? null;

if ($order_id && $transaction_status) {
    // Ambil bagian sebelum tanda strip (jika ada)
    $order_id_db = explode('-', $order_id)[0];

    if (
        $transaction_status == 'settlement' ||
        ($transaction_status == 'capture' && $fraud_status == 'accept')
    ) {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'sedang diproses' WHERE nomor_order = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    }
}

http_response_code(200); // Beri response OK ke Midtrans
echo 'OK';