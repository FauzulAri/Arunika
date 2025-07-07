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
    // Karena tidak ada pemisah, langsung pakai $order_id
    // Jika Midtrans menambah kode unik di belakang, kamu harus tahu berapa panjang $nomor_order yang kamu generate
    $panjang_nomor_order = 20; // contoh: ORD + 14 digit tanggal + 4 digit random = 3+14+4=21, cek sesuai generatormu

    $order_id_db = substr($order_id, 0, $panjang_nomor_order);

    if (
        $transaction_status == 'settlement' ||
        ($transaction_status == 'capture' && $fraud_status == 'accept')
    ) {
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