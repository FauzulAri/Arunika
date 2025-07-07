<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$user_id = $_SESSION['user_id'];
// Ambil data keranjang, user, dll sesuai kebutuhan Anda
// Contoh:
$keranjang_ids = isset($_POST['keranjang_ids']) ? array_filter(explode(',', $_POST['keranjang_ids'])) : [];
if (empty($keranjang_ids)) {
    die('Tidak ada barang yang dipilih.');
}

// Ambil data user
$stmt = $conn->prepare("SELECT nama, email, alamat, no_hp FROM user WHERE user_id = ?");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($nama, $email_user, $alamat, $no_hp);
$stmt->fetch();
$stmt->close();

// Ambil data keranjang
$placeholders = implode(',', array_fill(0, count($keranjang_ids), '?'));
$types = str_repeat('i', count($keranjang_ids));
$params = $keranjang_ids;
$sql = "SELECT k.*, f.nama_furniture, f.harga FROM keranjang k JOIN furniture f ON k.furniture_id = f.furniture_id WHERE k.keranjang_id IN ($placeholders) AND k.user_id = ?";
$params[] = $user_id;
$types .= 'i';
$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$res = $stmt->get_result();
$items = [];
$total = 0;
while ($row = $res->fetch_assoc()) {
    $items[] = $row;
    $total += $row['subtotal'];
}
$stmt->close();

if (empty($items)) {
    die('Barang tidak ditemukan di keranjang.');
}

// Buat order di database
$metode_pembayaran = null; // atau ''
$alamat_pengiriman = $_POST['alamat_pengiriman'] ?? $alamat;
$nama_penerima = $_POST['nama_penerima'] ?? $nama;
$no_hp_penerima = $_POST['no_hp_penerima'] ?? $no_hp;
$catatan = $_POST['catatan'] ?? '';

// Generate nomor_order sesuai format Midtrans
$nomor_order = 'ORD' . date('YmdHis') . rand(1000,9999);

// Insert ke database dengan nomor_order tersebut
$status_order = 'pending';
$stmt = $conn->prepare("INSERT INTO orders (user_id, nomor_order, total_harga, status_order, metode_pembayaran, alamat_pengiriman, nama_penerima, no_hp_penerima, catatan) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('isdssssss', $user_id, $nomor_order, $total, $status_order, $metode_pembayaran, $alamat_pengiriman, $nama_penerima, $no_hp_penerima, $catatan);
$stmt->execute();
$new_order_id = $stmt->insert_id;
$stmt->close();

// Pindahkan item keranjang ke detail_order
foreach ($items as $item) {
    $stmt = $conn->prepare("INSERT INTO detail_order (order_id, furniture_id, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('iiidd', $new_order_id, $item['furniture_id'], $item['jumlah'], $item['harga'], $item['subtotal']);
    $stmt->execute();
    $stmt->close();
}

// Hapus keranjang user
$stmt = $conn->prepare("DELETE FROM keranjang WHERE user_id = ? AND keranjang_id IN ($placeholders)");
$stmt->bind_param('i' . str_repeat('i', count($keranjang_ids)), $user_id, ...$keranjang_ids);
$stmt->execute();
$stmt->close();

// Buat item_details untuk Midtrans
$item_details = array_map(function($item) {
    return [
        "id" => $item['furniture_id'],
        "price" => (int)$item['harga'],
        "quantity" => (int)$item['jumlah'],
        "name" => $item['nama_furniture']
    ];
}, $items);

// Data untuk Payment Link API
$data = [
    "transaction_details" => [
        "order_id" => $nomor_order,
        "gross_amount" => (int)$total,
        "payment_type" => $metode_pembayaran,
        "status" => "pending"
    ],
    "customer_details" => [
        "first_name" => $nama_penerima,
        "email" => $email_user,
        "phone" => $no_hp_penerima,
        "address" => $alamat_pengiriman
    ],
    "item_details" => $item_details,
    "usage_limit" => 1,
    "expiry" => [
        "duration" => 1,
        "unit" => "days"
    ],
    "shipping_address" => [
        "first_name" => $nama_penerima,
        "email" => $email_user,
        "phone" => $no_hp_penerima,
        "address" => $alamat_pengiriman
    ],
    "callbacks" => [
        "finish" => "http://arunika.42web.io/Arunika/view/user/order/index.php?nomor_order=" . $nomor_order
    ]
];

// GUNAKAN SERVER KEY SANDBOX MIDTRANS YANG BENAR!
$server_key = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key sandbox Anda dari dashboard Midtrans
$auth = base64_encode($server_key . ':');

// Endpoint sandbox
$midtrans_url = 'https://api.sandbox.midtrans.com/v1/payment-links';

$ch = curl_init($midtrans_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Basic ' . $auth
]);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
$response = curl_exec($ch);
if (curl_errno($ch)) {
    die('Curl error: ' . curl_error($ch));
}
curl_close($ch);

$result = json_decode($response, true);
if (isset($result['payment_url'])) {
    $payment_link = $result['payment_url'];
    // Simpan payment_link ke database
    $stmt = $conn->prepare("UPDATE orders SET payment_link = ? WHERE order_id = ?");
    $stmt->bind_param('si', $payment_link, $new_order_id);
    $stmt->execute();
    $stmt->close();
    // Redirect langsung ke payment link
    header('Location: ' . $payment_link);
    exit();
} else {
    // Tampilkan error detail jika unauthorized
    if (isset($result['error_messages'])) {
        die('Gagal membuat payment link: ' . json_encode($result));
    } else {
        die('Gagal membuat payment link: ' . htmlspecialchars($response));
    }
} 