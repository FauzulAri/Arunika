<?php
session_start();
// Hapus semua session
$_SESSION = array();
// Hancurkan session
session_destroy();
// Redirect ke halaman login
header('Location: /Arunika/view/user/home/index.php');
exit(); 