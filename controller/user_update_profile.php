<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$user_id = $_SESSION['user_id'];
$nama = trim($_POST['nama']);
$email = trim($_POST['email']);
$alamat = trim($_POST['alamat']);
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validasi email unik (tidak boleh sama dengan user lain)
$stmt = $conn->prepare('SELECT user_id FROM user WHERE email = ? AND user_id != ?');
$stmt->bind_param('si', $email, $user_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows > 0) {
    $stmt->close();
    echo "<script>alert('Email sudah digunakan oleh user lain!'); window.history.back();</script>";
    exit();
}
$stmt->close();

// Handle upload foto profil
$foto_nama = null;
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $file_tmp = $_FILES['foto']['tmp_name'];
    $file_name = basename($_FILES['foto']['name']);
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png'];
    if (in_array($file_ext, $allowed_ext)) {
        $foto_nama = 'user_' . $user_id . '_' . time() . '.' . $file_ext;
        $target_dir = $_SERVER['DOCUMENT_ROOT'] . '/Arunika/assets/img/profile/';
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        move_uploaded_file($file_tmp, $target_dir . $foto_nama);
    }
}

// Siapkan query update
$update_query = 'UPDATE user SET nama=?, email=?, alamat=?';
$params = [$nama, $email, $alamat];
$types = 'sss';

if (!empty($password)) {
    $update_query .= ', password=?';
    $params[] = password_hash($password, PASSWORD_DEFAULT);
    $types .= 's';
}
if ($foto_nama) {
    $update_query .= ', foto=?';
    $params[] = $foto_nama;
    $types .= 's';
}
$update_query .= ' WHERE user_id=?';
$params[] = $user_id;
$types .= 'i';

$stmt = $conn->prepare($update_query);
$stmt->bind_param($types, ...$params);
if ($stmt->execute()) {
    // Update session nama/email jika berubah
    $_SESSION['nama'] = $nama;
    $_SESSION['email'] = $email;
    header('Location: /Arunika/view/user/profile.php');
    exit();
} else {
    echo "<script>alert('Gagal update profil!'); window.history.back();</script>";
}
$stmt->close();
$conn->close(); 