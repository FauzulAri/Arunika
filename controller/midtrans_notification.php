<?php
// Midtrans Webhook Notification Handler
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$json = file_get_contents('php://input');
$notif = json_decode($json, true);

$order_id = $notif['order_id'] ?? null;
$status = $notif['transaction_status'] ?? null;

// Logging sederhana untuk debug
file_put_contents(__DIR__ . '/webhook_debug.log', date('c') . " | order_id: $order_id | status: $status\n", FILE_APPEND);

if ($order_id && $status) {
    $stmt = $conn->prepare("UPDATE orders SET status_order = ? WHERE order_id = ?");
    $stmt->bind_param('ss', $status, $order_id);
    $stmt->execute();
    // Log hasil update
    file_put_contents(__DIR__ . '/webhook_debug.log', date('c') . " | Updated $order_id to $status, affected: {$stmt->affected_rows}\n", FILE_APPEND);
    $stmt->close();
}

http_response_code(200);
echo 'OK';