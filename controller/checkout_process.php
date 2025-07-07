<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/vendor/autoload.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Konfigurasi MIDTRANS
\Midtrans\Config::$serverKey = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key Midtrans Anda
\Midtrans\Config::$isProduction = false;
\Midtrans\Config::$isSanitized = true;
\Midtrans\Config::$is3ds = true;

$user_id = $_SESSION['user_id'];
$keranjang_ids = isset($_POST['keranjang_ids']) ? array_filter(explode(',', $_POST['keranjang_ids'])) : [];
$alamat_pengiriman = trim($_POST['alamat_pengiriman'] ?? '');
$nama_penerima = trim($_POST['nama_penerima'] ?? '');
$no_hp_penerima = trim($_POST['no_hp_penerima'] ?? '');
$catatan = trim($_POST['catatan'] ?? '');

if (empty($keranjang_ids) || !$alamat_pengiriman || !$nama_penerima || !$no_hp_penerima) {
    echo '<div class="container py-5 text-center"><h3>Data checkout tidak lengkap.</h3><a href="/Arunika/view/user/cart/index.php" class="btn btn-primary mt-3">Kembali ke Keranjang</a></div>';
    exit();
}

// Ambil data keranjang terpilih
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
    echo '<div class="container py-5 text-center"><h3>Barang tidak ditemukan di keranjang.</h3><a href="/Arunika/view/user/cart/index.php" class="btn btn-primary mt-3">Kembali ke Keranjang</a></div>';
    exit();
}

// Buat order_id unik
$order_id = 'ORD-' . date('YmdHis') . '-' . rand(1000,9999);

// Simpan order ke database (status pending, belum dibayar)
$stmt = $conn->prepare("INSERT INTO orders (user_id, nomor_order, total_harga, status_order, metode_pembayaran, alamat_pengiriman, nama_penerima, no_hp_penerima, catatan) VALUES (?, ?, ?, 'pending', 'payment_link', ?, ?, ?, ?)");
$stmt->bind_param('isdssss', $user_id, $order_id, $total, $alamat_pengiriman, $nama_penerima, $no_hp_penerima, $catatan);
$stmt->execute();
$new_order_id = $conn->insert_id;
$stmt->close();

// Simpan detail order
foreach ($items as $item) {
    $stmt = $conn->prepare("INSERT INTO detail_order (order_id, furniture_id, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('iiidd', $new_order_id, $item['furniture_id'], $item['jumlah'], $item['harga'], $item['subtotal']);
    $stmt->execute();
    $stmt->close();
}
// Hapus item dari keranjang user
$del_placeholders = implode(',', array_fill(0, count($keranjang_ids), '?'));
$del_types = str_repeat('i', count($keranjang_ids));
$del_params = $keranjang_ids;
$del_params[] = $user_id;
$del_types .= 'i';
$stmt = $conn->prepare("DELETE FROM keranjang WHERE keranjang_id IN ($del_placeholders) AND user_id = ?");
$stmt->bind_param($del_types, ...$del_params);
$stmt->execute();
$stmt->close();

// Ambil email user
$stmt = $conn->prepare('SELECT email FROM user WHERE user_id = ?');
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($email_user);
$stmt->fetch();
$stmt->close();

// Buat item_details untuk Payment Link
$item_details = array_map(function($item) {
    return [
        "id" => $item['furniture_id'],
        "price" => $item['harga'],
        "quantity" => $item['jumlah'],
        "name" => $item['nama_furniture']
    ];
}, $items);

// Data untuk Payment Link API
$data = [
    "transaction_details" => [
        "order_id" => $order_id,
        "gross_amount" => $total
    ],
    "customer_details" => [
        "first_name" => $nama_penerima,
        "email" => $email_user,
        "phone" => $no_hp_penerima
    ],
    "item_details" => $item_details,
    "usage_limit" => 1,
    "expiry" => [
        "duration" => 1,
        "unit" => "days"
    ]
];

$server_key = 'Mid-server-vxsYmfYmV9JC_bpbCM3cV_C7'; // Ganti dengan server key Anda
$auth = base64_encode($server_key . ':');

$ch = curl_init('https://api.sandbox.midtrans.com/v1/payment-links');
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
    echo '<div class="container py-5 text-center"><h3>Curl error: ' . curl_error($ch) . '</h3></div>';
    exit();
}
curl_close($ch);

$result = json_decode($response, true);
if (isset($result['payment_url'])) {
    $payment_link = $result['payment_url'];
    // Simpan $payment_link ke database
    $stmt = $conn->prepare("UPDATE orders SET payment_link = ? WHERE order_id = ?");
    $stmt->bind_param('si', $payment_link, $new_order_id);
    $stmt->execute();
    $stmt->close();
} else {
    echo '<div class="container py-5 text-center"><h3>Gagal membuat payment link: ' . htmlspecialchars($response) . '</h3></div>';
    exit();
}
// Redirect ke halaman Pesanan Saya
header('Location: /Arunika/view/user/order/index.php');
exit(); 