<?php
ob_start();
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$id_order = intval($_GET['id']);
$stmt = $conn->prepare("SELECT * FROM orders WHERE id_order = ?");
$stmt->bind_param('i', $id_order);
$stmt->execute();
$result = $stmt->get_result();
$order = $result->fetch_assoc();
$stmt->close();
?>
<h2>Edit Order</h2>
<form action="/Arunika/controller/order_edit_process.php" method="post" class="mb-4" autocomplete="off">
  <input type="hidden" name="id_order" value="<?= $order['id_order'] ?>">
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