<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /Arunika/view/admin/auth/signin.php');
    exit();
}

include '../../../config/connect.php';

if (!isset($_GET['id'])) {
    $_SESSION['message'] = 'ID furniture tidak ditemukan!';
    $_SESSION['message_type'] = 'danger';
    header('Location: index.php');
    exit();
}

$id = $_GET['id'];

// Ambil data furniture untuk menghapus gambar
$stmt = $conn->prepare("SELECT gambar FROM furniture WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $furniture = $result->fetch_assoc();
    
    // Hapus file gambar jika ada
    if ($furniture['gambar'] && file_exists($_SERVER['DOCUMENT_ROOT'] . '/Arunika/assets/img/furniture/' . $furniture['gambar'])) {
        unlink($_SERVER['DOCUMENT_ROOT'] . '/Arunika/assets/img/furniture/' . $furniture['gambar']);
    }
    
    // Hapus data dari database
    $stmt = $conn->prepare("DELETE FROM furniture WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Furniture berhasil dihapus!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Gagal menghapus furniture!';
        $_SESSION['message_type'] = 'danger';
    }
} else {
    $_SESSION['message'] = 'Furniture tidak ditemukan!';
    $_SESSION['message_type'] = 'danger';
}

header('Location: index.php');
exit();
?>
