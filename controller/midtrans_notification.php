<?php
// Midtrans Webhook Notification Handler
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Konfigurasi server key Midtrans (sandbox/production)
$server_key = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key kamu

$json = file_get_contents('php://input');
$notif = json_decode($json, true);

$order_id = $notif['order_id'] ?? null;
$status = $notif['transaction_status'] ?? null;
$type = $notif['payment_type'] ?? null;
$fraud = $notif['fraud_status'] ?? null;
$status_code = $notif['status_code'] ?? null;
$gross_amount = $notif['gross_amount'] ?? null;
$signature_key = $notif['signature_key'] ?? null;

// Simpan log ke tabel webhook_log
$log_text = 'order_id: ' . $order_id . ' | status: ' . $status . ' | type: ' . $type . ' | fraud: ' . $fraud . ' | status_code: ' . $status_code . ' | gross_amount: ' . $gross_amount . ' | signature_key: ' . $signature_key . ' | raw: ' . $json;
$stmt = $conn->prepare("INSERT INTO webhook_log (log_text) VALUES (?)");
$stmt->bind_param('s', $log_text);
$stmt->execute();
$stmt->close();

// Validasi signature_key
$expected_signature = hash('sha512', $order_id . $status_code . $gross_amount . $server_key);
if ($signature_key !== $expected_signature) {
    // Signature tidak valid, jangan proses update status
    http_response_code(403);
    echo 'Invalid signature';
    exit();
}

if ($order_id && $status) {
    // Ambil bagian sebelum tanda strip (jika ada)
    $order_id_db = explode('-', $order_id)[0];

    if ($status == 'capture') {
        if ($type == 'credit_card' && $fraud == 'challenge') {
            $stmt = $conn->prepare("UPDATE orders SET status_order = 'challenge' WHERE order_id = ?");
            $stmt->bind_param('s', $order_id_db);
            $stmt->execute();
            $stmt->close();
        } else {
            $stmt = $conn->prepare("UPDATE orders SET status_order = 'settlement' WHERE order_id = ?");
            $stmt->bind_param('s', $order_id_db);
            $stmt->execute();
            $stmt->close();
        }
    } else if ($status == 'settlement') {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'settlement' WHERE order_id = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    } else if ($status == 'pending') {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'pending' WHERE order_id = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    } else if ($status == 'deny') {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'deny' WHERE order_id = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    } else if ($status == 'expire') {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'expire' WHERE order_id = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    } else if ($status == 'cancel') {
        $stmt = $conn->prepare("UPDATE orders SET status_order = 'cancel' WHERE order_id = ?");
        $stmt->bind_param('s', $order_id_db);
        $stmt->execute();
        $stmt->close();
    }
}

http_response_code(200);
echo 'OK';