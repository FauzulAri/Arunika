<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: /Arunika/view/admin/auth/signin.php');
    exit();
}

include '../config/connect.php';

// Fungsi untuk upload gambar
function uploadImage($file, $oldImage = null) {
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . '/Arunika/assets/img/';
    
    // Buat direktori jika belum ada
    if (!file_exists($targetDir)) {
        mkdir($targetDir, 0777, true);
    }
    
    // Jika ada file yang diupload
    if ($file['error'] === UPLOAD_ERR_OK) {
        $fileName = basename($file['name']);
        $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
        
        // Validasi tipe file
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
        if (!in_array($fileType, $allowedTypes)) {
            return ['success' => false, 'message' => 'Hanya file JPG, JPEG, PNG & GIF yang diperbolehkan!'];
        }
        
        // Validasi ukuran file (max 2MB)
        if ($file['size'] > 2 * 1024 * 1024) {
            return ['success' => false, 'message' => 'Ukuran file maksimal 2MB!'];
        }
        
        // Generate nama file unik
        $fileName = time() . '_' . $fileName;
        $targetFilePath = $targetDir . $fileName;
        
        // Upload file
        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // Hapus gambar lama jika ada
            if ($oldImage && file_exists($targetDir . $oldImage)) {
                unlink($targetDir . $oldImage);
            }
            return ['success' => true, 'filename' => $fileName];
        } else {
            return ['success' => false, 'message' => 'Gagal mengupload file!'];
        }
    }
    
    // Jika tidak ada file yang diupload, kembalikan gambar lama
    return ['success' => true, 'filename' => $oldImage];
}

// Proses Tambah Furniture
if (isset($_POST['tambah'])) {
    $nama = trim($_POST['nama_furniture']);
    $kategori = (int)$_POST['kategori_id'];
    $harga = (int)$_POST['harga'];
    $deskripsi = trim($_POST['deskripsi']);
    
    // Validasi input
    if (empty($nama) || empty($kategori) || $harga <= 0) {
        $_SESSION['message'] = 'Semua field wajib diisi dan harga harus lebih dari 0!';
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/add_furniture.php');
        exit();
    }
    
    // Upload gambar
    $imageResult = uploadImage($_FILES['gambar_furniture']);
    if (!$imageResult['success']) {
        $_SESSION['message'] = $imageResult['message'];
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/add_furniture.php');
        exit();
    }
    
    // Insert ke database
    $stmt = $conn->prepare("INSERT INTO furniture (nama_furniture, kategori_id, harga, deskripsi, gambar_furniture) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("siiss", $nama, $kategori, $harga, $deskripsi, $imageResult['filename']);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Furniture berhasil ditambahkan!';
        $_SESSION['message_type'] = 'success';
        header('Location: ../view/admin/data_furniture/index.php');
    } else {
        $_SESSION['message'] = 'Gagal menambahkan furniture!';
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/add_furniture.php');
    }
    exit();
}

// Proses Edit Furniture
if (isset($_POST['edit'])) {
    $id = (int)$_POST['furniture_id'];
    $nama = trim($_POST['nama_furniture']);
    $kategori = (int)$_POST['kategori_id'];
    $harga = (int)$_POST['harga'];
    $deskripsi = trim($_POST['deskripsi']);
    
    // Validasi input
    if (empty($nama) || empty($kategori) || $harga <= 0) {
        $_SESSION['message'] = 'Semua field wajib diisi dan harga harus lebih dari 0!';
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/edit_furniture.php?id=' . $id);
        exit();
    }
    
    // Ambil data furniture lama
    $stmt = $conn->prepare("SELECT gambar_furniture FROM furniture WHERE furniture_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        $_SESSION['message'] = 'Furniture tidak ditemukan!';
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/index.php');
        exit();
    }
    
    $oldData = $result->fetch_assoc();
    $oldImage = $oldData['gambar_furniture'];
    
    // Upload gambar baru (jika ada)
    $imageResult = uploadImage($_FILES['gambar_furniture'], $oldImage);
    if (!$imageResult['success']) {
        $_SESSION['message'] = $imageResult['message'];
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/edit_furniture.php?id=' . $id);
        exit();
    }
    
    // Update database
    $stmt = $conn->prepare("UPDATE furniture SET nama_furniture = ?, kategori_id = ?, harga = ?, deskripsi = ?, gambar_furniture = ? WHERE furniture_id = ?");
    $stmt->bind_param("siissi", $nama, $kategori, $harga, $deskripsi, $imageResult['filename'], $id);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Furniture berhasil diupdate!';
        $_SESSION['message_type'] = 'success';
        header('Location: ../view/admin/data_furniture/index.php');
    } else {
        $_SESSION['message'] = 'Gagal mengupdate furniture!';
        $_SESSION['message_type'] = 'danger';
        header('Location: ../view/admin/data_furniture/edit_furniture.php?id=' . $id);
    }
    exit();
}

// Jika tidak ada action yang valid
header('Location: ../view/admin/data_furniture/index.php');
exit();
?>
