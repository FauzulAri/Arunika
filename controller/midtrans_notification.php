<?php
// Native PHP handler untuk notifikasi Midtrans tanpa library
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$raw = file_get_contents('php://input');
$notif = json_decode($raw, true);

$order_id = $notif['order_id'] ?? '';
$transaction = $notif['transaction_status'] ?? '';
$fraud = $notif['fraud_status'] ?? '';

// Mapping status Midtrans ke status order Arunika
$status_order = 'pending';
if ($transaction == 'settlement' || $transaction == 'capture') {
    $status_order = 'sedang diproses';
} else if ($transaction == 'pending') {
    $status_order = 'pending';
} else if ($transaction == 'deny' || $transaction == 'expire' || $transaction == 'cancel') {
    $status_order = 'dibatalkan';
}

// Update status di database
if ($order_id) {
    $stmt = $conn->prepare("UPDATE orders SET status_order = ? WHERE nomor_order = ?");
    $stmt->bind_param('ss', $status_order, $order_id);
    $stmt->execute();
    $stmt->close();
}

http_response_code(200);
echo "OK"; 