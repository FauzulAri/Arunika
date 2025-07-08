<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$order_id = intval($_GET['id']);
$sql = "SELECT * FROM orders WHERE order_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $order_id);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();

if (!$order) {
    echo "<div class='alert alert-danger'>Order tidak ditemukan.</div>";
    exit;
}
?>

<h2>Detail Order</h2>
<table class="table table-bordered">
    <?php foreach ($order as $key => $value): ?>
        <tr>
            <th><?= htmlspecialchars($key) ?></th>
            <td><?= htmlspecialchars($value) ?></td>
        </tr>
    <?php endforeach; ?>
</table>
<a href="index.php" class="btn btn-secondary">Kembali ke Data Order</a>

<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php';
?>
