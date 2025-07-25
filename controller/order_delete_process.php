<?php
session_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id_order = intval($_GET['id']);
$stmt = $conn->prepare("DELETE FROM orders WHERE id_order = ?");
$stmt->bind_param('i', $id_order);
$stmt->execute();
$stmt->close();
header('Location: ../view/admin/data_order/index.php');
exit(); 