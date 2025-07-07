<?php
// File: midtrans_notif_handler.php

include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Ambil data mentah dari Midtrans
$raw = file_get_contents('php://input');
$timestamp = date('Y-m-d H:i:s');
file_put_contents(__DIR__ . '/notif_log.txt', "$timestamp RAW: $raw\n", FILE_APPEND);

// Decode JSON
$notif = json_decode($raw, true);
file_put_contents(__DIR__ . '/notif_log.txt', "DECODED: " . json_encode($notif) . "\n", FILE_APPEND);

$order_id = $notif['order_id'] ?? '';
$server_key = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key Anda
$auth = base64_encode($server_key . ':');

if ($order_id) {
    // Ambil status transaksi dari Midtrans
    $ch = curl_init("https://api.sandbox.midtrans.com/v2/$order_id/status");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Basic ' . $auth
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $status = json_decode($response, true);
    file_put_contents(__DIR__ . '/notif_log.txt', "STATUS: " . json_encode($status) . "\n", FILE_APPEND);

    // Ambil informasi penting
    $transaction_status = $status['transaction_status'] ?? '';
    $payment_type = $status['payment_type'] ?? '';
    $metode_pembayaran = 'TIDAK TERDETEKSI';

    // Deteksi metode pembayaran
    if ($payment_type === 'bank_transfer') {
        if (!empty($status['va_numbers'][0]['bank'])) {
            $metode_pembayaran = strtoupper($status['va_numbers'][0]['bank']);
        } elseif (!empty($status['permata_va_number'])) {
            $metode_pembayaran = 'PERMATA';
        }
    } elseif ($payment_type === 'echannel') {
        $metode_pembayaran = 'MANDIRI';
    } elseif (!empty($payment_type)) {
        $metode_pembayaran = strtoupper($payment_type); // GOPAY, QRIS, dll.
    }

    // Konversi status Midtrans ke status order
    switch ($transaction_status) {
        case 'settlement':
        case 'capture':
        case 'success': // just in case
            $status_order = 'sedang diproses';
            break;
        case 'pending':
            $status_order = 'pending';
            break;
        case 'deny':
        case 'expire':
        case 'cancel':
            $status_order = 'dibatalkan';
            break;
        default:
            $status_order = 'pending'; // fallback
            break;
    }

    file_put_contents(__DIR__ . '/notif_log.txt', "UPDATE: nomor_order=$order_id, status_order=$status_order, metode_pembayaran=$metode_pembayaran\n", FILE_APPEND);

    // Update database
    $stmt = $conn->prepare("UPDATE orders SET status_order = ?, metode_pembayaran = ? WHERE nomor_order = ?");
    $stmt->bind_param('sss', $status_order, $metode_pembayaran, $order_id);
    
    if ($stmt->execute()) {
        file_put_contents(__DIR__ . '/notif_log.txt', "SUCCESS: Rows affected = " . $stmt->affected_rows . "\n", FILE_APPEND);
    } else {
        file_put_contents(__DIR__ . '/notif_log.txt', "ERROR: " . $stmt->error . "\n", FILE_APPEND);
    }

    $stmt->close();
} else {
    file_put_contents(__DIR__ . '/notif_log.txt', "ERROR: order_id kosong\n", FILE_APPEND);
}

// Kirim respons OK ke Midtrans
http_response_code(200);
echo "OK";
