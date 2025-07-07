<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Mengecek apakah form login telah disubmit
if (isset($_POST['email']) && isset($_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Menggunakan prepared statements untuk mencegah SQL injection
    $stmt = $conn->prepare("SELECT user_id, nama, email, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Mengecek apakah ada pengguna yang ditemukan
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $hashed_password = $user['password'];
        $user_id = $user['user_id'];
        $nama = $user['nama'];

        // Memverifikasi password yang dimasukkan dengan password yang di-hash
        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['nama'] = $nama;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = 'user';
            // Debug session sebelum redirect
            echo '<pre>SESSION: '; print_r($_SESSION); echo '</pre>';
            // Cek apakah session benar-benar terset
            if (!headers_sent()) {
                header('Location: /Arunika/view/user/home/index.php');
                exit();
            } else {
                echo '<br>Header sudah terkirim, tidak bisa redirect.';
            }
        } else {
            echo "<script>alert('Email atau kata sandi salah!'); window.location='/Arunika/view/auth/login.php';</script>";
        }
    } else {
        echo "<script>alert('Email atau kata sandi salah!'); window.location='/Arunika/view/auth/login.php';</script>";
    }
    $stmt->close();
    $conn->close();
}
