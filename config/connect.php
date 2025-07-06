<?php
if (isset($_SERVER['SERVER_NAME']) && ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1')) {
    include_once __DIR__ . '/connect_local.php';
} else {
    include_once __DIR__ . '/connect_hosting.php';
}
?>