<?php
// Native PHP handler untuk notifikasi Midtrans tanpa library
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$raw = file_get_contents('php://input');
$notif = json_decode($raw, true);

$order_id = $notif['order_id'] ?? '';
$transaction = $notif['transaction_status'] ?? '';
$fraud = $notif['fraud_status'] ?? '';
$payment_type = $notif['payment_type'] ?? null;

// Mapping status Midtrans ke status order Arunika
$status_order = 'pending';
if ($transaction == 'settlement' || $transaction == 'capture') {
    $status_order = 'sedang diproses';
} else if ($transaction == 'pending') {
    $status_order = 'pending';
} else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
    $status_order = 'dibatalkan';
}

// Update status dan metode pembayaran di database
if ($order_id) {
    $stmt = $conn->prepare("UPDATE orders SET status_order = ?, metode_pembayaran = ? WHERE nomor_order = ?");
    $stmt->bind_param('sss', $status_order, $payment_type, $order_id);
    $stmt->execute();
    $stmt->close();
}

http_response_code(200);
echo "OK"; 