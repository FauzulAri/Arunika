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

    // Mapping status Midtrans ke status order Arunika
    $transaction_status = $status['transaction_status'] ?? '';
    $payment_type = $status['payment_type'] ?? null;
    $metode_pembayaran = null;

    if ($payment_type == 'bank_transfer' && isset($status['va_numbers'][0]['bank'])) {
        $metode_pembayaran = strtoupper($status['va_numbers'][0]['bank']); // Contoh: BCA, MANDIRI
    } else if ($payment_type) {
        $metode_pembayaran = strtoupper($payment_type); // Contoh: GOPAY, SHOPEEPAY, QRIS, DLL
    }

    $status_order = 'pending';
    if ($transaction_status == 'settlement' || $transaction_status == 'capture') {
        $status_order = 'sedang diproses';
    } else if ($transaction_status == 'pending') {
        $status_order = 'pending';
    } else if ($transaction_status == 'deny' || $transaction_status == 'expire' || $transaction_status == 'cancel') {
        $status_order = 'dibatalkan';
    }

    // Update hanya kolom yang diperlukan
    $stmt = $conn->prepare("UPDATE orders SET status_order = ?, metode_pembayaran = ? WHERE nomor_order = ?");
    $stmt->bind_param('sss', $status_order, $metode_pembayaran, $order_id);
    $stmt->execute();
    $stmt->close();
}
http_response_code(200);
echo "OK"; 