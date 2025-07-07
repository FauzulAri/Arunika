<?php
// Native PHP handler untuk notifikasi Midtrans tanpa library
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$raw = file_get_contents('php://input');
$notif = json_decode($raw, true);

$order_id = $notif['order_id'] ?? '';
$server_key = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key Anda
$auth = base64_encode($server_key . ':');

if ($order_id) {
    // Ambil detail transaksi dari Midtrans
    $ch = curl_init("https://api.sandbox.midtrans.com/v2/$order_id/status");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Basic ' . $auth
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $status = json_decode($response, true);

    // Ambil data detail pembayaran
    $transaction_status = $status['transaction_status'] ?? '';
    $payment_type = $status['payment_type'] ?? null;
    $va_number = null;
    $bank = null;
    $channel = null;
    $metode_pembayaran = null;

    // Mapping status Midtrans ke status order Arunika
    $status_order = 'pending';
    if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
        $status_order = 'sedang diproses';
    } else if ($transaction_status == 'pending') {
        $status_order = 'pending';
    } else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
        $status_order = 'dibatalkan';
    }

    // Contoh untuk bank_transfer/VA
    if ($payment_type == 'bank_transfer' && isset($status['va_numbers'][0])) {
        $va_number = $status['va_numbers'][0]['va_number'] ?? null;
        $bank = strtoupper($status['va_numbers'][0]['bank'] ?? '');
        $channel = $status['permata_va_number'] ? 'Permata' : $bank;
        $metode_pembayaran = $bank; // Simpan nama bank (BCA, MANDIRI, dst)
    } else if ($payment_type) {
        // Untuk e-wallet, QRIS, dll, simpan payment_type saja
        $metode_pembayaran = strtoupper($payment_type);
    }

    // Update ke database
    $stmt = $conn->prepare("UPDATE orders SET status_order = ?, metode_pembayaran = ?, va_number = ?, bank = ?, channel = ? WHERE nomor_order = ?");
    $stmt->bind_param('ssssss', $status_order, $metode_pembayaran, $va_number, $bank, $channel, $order_id);
    $stmt->execute();
    $stmt->close();
}
http_response_code(200);
echo "OK"; 