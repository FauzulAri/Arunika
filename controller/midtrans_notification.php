<?php
// Midtrans Webhook Notification Handler
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$json = file_get_contents('php://input');
$notif = json_decode($json, true);

$order_id = $notif['order_id'] ?? null;
$status = $notif['transaction_status'] ?? null;

// Simpan log ke tabel webhook_log
$log_text = 'order_id: ' . $order_id . ' | status: ' . $status . ' | raw: ' . $json;
$stmt = $conn->prepare("INSERT INTO webhook_log (log_text) VALUES (?)");
$stmt->bind_param('s', $log_text);
$stmt->execute();
$stmt->close();

if ($order_id && $status) {
    // Ambil bagian sebelum tanda strip (jika ada)
    $order_id_db = explode('-', $order_id)[0];
    $stmt = $conn->prepare("UPDATE orders SET status_order = ? WHERE order_id = ?");
    $stmt->bind_param('ss', $status, $order_id_db);
    $stmt->execute();
    $stmt->close();
}

http_response_code(200);
echo 'OK';