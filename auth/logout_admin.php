<?php
session_start();
// Hapus session admin
unset($_SESSION['admin_id']);
unset($_SESSION['admin_username']);
// Redirect ke halaman login admin
header('Location: /Arunika/view/admin/signin.php');
exit();