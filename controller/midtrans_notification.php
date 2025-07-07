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
$fraud_status = $notif['fraud_status'] ?? null;

if ($order_id && $transaction_status) {
    $order_id_parts = explode('-', $order_id);
    $order_id_db = implode('-', array_slice($order_id_parts, 0, 3));

    if ($transaction_status == 'settlement' || ($transaction_status == 'capture' && $fraud_status == 'accept')) {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'sedang diproses' WHERE nomor_order = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();

        // Logging hasil update
        if ($stmt->affected_rows > 0) {
            file_put_contents('notif_log.txt', "Update sukses untuk $order_id_db\n", FILE_APPEND);
        } else {
            file_put_contents('notif_log.txt', "Update GAGAL untuk $order_id_db\n", FILE_APPEND);
        }

        $stmt->close();
    }
}

http_response_code(200); // Beri response OK ke Midtrans
echo 'OK';