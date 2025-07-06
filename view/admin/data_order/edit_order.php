<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM orders WHERE order_id = ?");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows < 1) {
    echo '<div class="alert alert-danger">Order tidak ditemukan.</div>';
    exit;
}
$order = $res->fetch_assoc();
?>
<h2>Edit Order</h2>
<form action="/Arunika/controller/order_edit_process.php" method="post" class="mb-4" autocomplete="off">
  <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
  <div class="mb-3">
    <label class="form-label">Status Order</label>
    <select class="form-select" name="status_order" required>
      <?php $statusList = ['pending','confirmed','processing','shipped','delivered','cancelled']; foreach($statusList as $s): ?>
        <option value="<?= $s ?>" <?= $order['status_order']==$s?'selected':'' ?>><?= ucfirst($s) ?></option>
      <?php endforeach; ?>
    </select>
  </div>
  <div class="mb-3">
    <label class="form-label">Metode Pembayaran</label>
    <input type="text" class="form-control" value="<?= htmlspecialchars($order['metode_pembayaran']) ?>" readonly>
  </div>
  <div class="mb-3">
    <label class="form-label">Alamat Pengiriman</label>
    <textarea class="form-control" name="alamat_pengiriman" required><?= htmlspecialchars($order['alamat_pengiriman']) ?></textarea>
  </div>
  <div class="mb-3">
    <label class="form-label">Nama Penerima</label>
    <input type="text" class="form-control" name="nama_penerima" value="<?= htmlspecialchars($order['nama_penerima']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">No HP Penerima</label>
    <input type="text" class="form-control" name="no_hp_penerima" value="<?= htmlspecialchars($order['no_hp_penerima']) ?>" required>
  </div>
  <div class="mb-3">
    <label class="form-label">Catatan</label>
    <textarea class="form-control" name="catatan"><?= htmlspecialchars($order['catatan']) ?></textarea>
  </div>
  <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
  <a href="index.php" class="btn btn-secondary">Batal</a>
</form>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/admin/master.php'; 