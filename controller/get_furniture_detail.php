<?php
header('Content-Type: application/json');

// Include koneksi database
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Cek apakah ada parameter ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'ID furniture tidak valid'
    ]);
    exit();
}

$id = (int)$_GET['id'];

// Query untuk mengambil detail furniture dengan join kategori
$stmt = $conn->prepare("SELECT f.*, k.nama_kategori 
                       FROM furniture f 
                       LEFT JOIN kategori k ON f.kategori_id = k.kategori_id 
                       WHERE f.furniture_id = ? AND f.is_active = TRUE");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $furniture = $result->fetch_assoc();
    
    echo json_encode([
        'success' => true,
        'furniture' => $furniture
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Furniture tidak ditemukan'
    ]);
}

$stmt->close();
$conn->close();
?> 