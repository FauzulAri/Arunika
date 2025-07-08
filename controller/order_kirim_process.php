<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

if (isset($_GET['id'])) {
    $order_id = intval($_GET['id']);
    $sql = "UPDATE orders SET status_order = 'Sedang Dikirim' WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $order_id);
    if ($stmt->execute()) {
        session_start();
        $_SESSION['message'] = "Status order berhasil diubah menjadi 'Sedang Dikirim'.";
        $_SESSION['message_type'] = "success";
    } else {
        session_start();
        $_SESSION['message'] = "Gagal mengubah status order.";
        $_SESSION['message_type'] = "danger";
    }
    $stmt->close();
}
header("Location: /Arunika/view/admin/data_order/index.php");
exit;
?>
