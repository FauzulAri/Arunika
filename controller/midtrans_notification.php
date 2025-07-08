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

// --- DEBUG: Simpan log ke database ---
$log_text = "order_id dari notif: $order_id\ntransaction_status: $transaction_status\nfraud_status: $fraud_status\n";
$stmt = $conn->prepare("INSERT INTO webhook_log (log_text) VALUES (?)");
$stmt->bind_param('s', $log_text);
$stmt->execute();
$stmt->close();
// --- END DEBUG ---

if ($order_id && $transaction_status) {
    // Ambil bagian sebelum tanda strip (jika ada)
    $order_id_db = explode('-', $order_id)[0];

    // --- DEBUG: Simpan log order_id_db ke database ---
    $log_text = "order_id_db: $order_id_db\n";
    $stmt = $conn->prepare("INSERT INTO webhook_log (log_text) VALUES (?)");
    $stmt->bind_param('s', $log_text);
    $stmt->execute();
    $stmt->close();
    // --- END DEBUG ---

    if (
        $transaction_status == 'settlement' ||
        ($transaction_status == 'capture' && $fraud_status == 'accept')
    ) {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'sedang diproses' WHERE nomor_order = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();

        // --- DEBUG: Simpan hasil update ke database ---
        if ($stmt->affected_rows > 0) {
            $log_text = "Update sukses untuk $order_id_db\n";
        } else {
            $log_text = "Update GAGAL untuk $order_id_db\n";
        }
        $stmt->close();

        $stmt = $conn->prepare("INSERT INTO webhook_log (log_text) VALUES (?)");
        $stmt->bind_param('s', $log_text);
        $stmt->execute();
        $stmt->close();
        // --- END DEBUG ---
    }
}

http_response_code(200); // Beri response OK ke Midtrans
echo 'OK';