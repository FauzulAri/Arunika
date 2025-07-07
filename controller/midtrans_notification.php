<?php
// Native PHP handler untuk notifikasi Midtrans tanpa library
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$raw = file_get_contents('php://input');
file_put_contents(__DIR__.'/notif_log.txt', date('Y-m-d H:i:s')." RAW: $raw\n", FILE_APPEND);
$notif = json_decode($raw, true);
file_put_contents(__DIR__.'/notif_log.txt', "DECODED: ".json_encode($notif)."\n", FILE_APPEND);

$order_id_full = $notif['order_id'] ?? '';
// Ambil bagian awal sebelum strip terakhir (untuk mencocokkan dengan nomor_order di database)
$nomor_order = preg_replace('/-\d+$/', '', $order_id_full);
$server_key = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key Anda
$auth = base64_encode($server_key . ':');

if ($order_id_full) {
    // Ambil detail transaksi dari Midtrans
    $ch = curl_init("https://api.sandbox.midtrans.com/v2/$order_id_full/status");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json',
        'Authorization: Basic ' . $auth
    ]);
    $response = curl_exec($ch);
    curl_close($ch);

    $status = json_decode($response, true);
    file_put_contents(__DIR__.'/notif_log.txt', "STATUS: ".json_encode($status)."\n", FILE_APPEND);

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
    file_put_contents(__DIR__.'/notif_log.txt', "UPDATE: status_order=$status_order, metode_pembayaran=$metode_pembayaran, order_id=$order_id_full\n", FILE_APPEND);
    // Update hanya kolom yang diperlukan
    $stmt = $conn->prepare("UPDATE orders SET status_order = ?, metode_pembayaran = ? WHERE nomor_order = ?");
    $stmt->bind_param('sss', $status_order, $metode_pembayaran, $nomor_order);
    if (!$stmt->execute()) {
        file_put_contents(__DIR__.'/notif_log.txt', "ERROR: ".$stmt->error."\n", FILE_APPEND);
    }
    $stmt->close();
}
http_response_code(200);
echo "OK"; 