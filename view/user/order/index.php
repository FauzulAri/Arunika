<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];

ob_start();
// Query pesanan user
$orders = [];
$stmt = $conn->prepare("SELECT id_order, order_id, tanggal_order, status_order, total_harga FROM orders WHERE user_id = ? ORDER BY tanggal_order DESC");
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($id_order, $order_id, $tanggal_order, $status_order, $total_harga);
while ($stmt->fetch()) {
    $orders[] = [
        'id_order' => $id_order, // tambahkan id_order
        'order_id' => $order_id,
        'tanggal_order' => $tanggal_order,
        'status_order' => $status_order,
        'total_harga' => $total_harga,
    ];
}
$stmt->close();
?>
<div class="container py-4">
  <h2 class="mb-4">Pesanan Saya</h2>
  <?php if (empty($orders)): ?>
    <div class="alert alert-info text-center">Belum ada pesanan.</div>
  <?php else: ?>
    <div class="d-flex flex-column gap-4">
      <?php foreach ($orders as $order): ?>
        <?php
        // Ambil 1 produk utama dari detail_order
        $q = $conn->prepare("SELECT d.jumlah, d.harga_satuan, f.nama_furniture, f.gambar_furniture, f.furniture_id FROM detail_order d JOIN furniture f ON d.furniture_id = f.furniture_id WHERE d.id_order = ? LIMIT 1");
        $q->bind_param('i', $order['id_order']);
        $q->execute();
        $q->bind_result($jumlah, $harga_satuan, $nama_furniture, $gambar_furniture, $furniture_id);
        $q->fetch();
        $q->close();
        ?>
        <div class="card shadow-sm border-0">
          <div class="card-body">
            <div class="d-flex align-items-center mb-2">
              <i class="fa fa-shopping-bag me-2 text-success"></i>
              <span class="fw-bold me-2">Belanja</span>
              <span class="text-muted me-2"><?= date('j M Y', strtotime($order['tanggal_order'])) ?></span>
              <span class="badge bg-<?= $order['status_order']=='settlement'?'success':($order['status_order']=='pending'?'warning':'secondary') ?> me-2">
                <?= ucfirst($order['status_order']=='settlement'?'Selesai':$order['status_order']) ?>
              </span>
              <span class="text-muted small"><?= htmlspecialchars($order['order_id']) ?></span>
            </div>
            <div class="d-flex align-items-center mb-2">
              <img src="/Arunika/assets/img/<?= htmlspecialchars($gambar_furniture ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($nama_furniture) ?>" style="width:64px; height:64px; object-fit:cover; border-radius:8px; margin-right:16px;">
              <div class="flex-grow-1">
                <div class="fw-bold"><?= htmlspecialchars($nama_furniture) ?></div>
                <div class="text-muted small"><?= $jumlah ?> barang x Rp<?= number_format($harga_satuan,0,',','.') ?></div>
              </div>
              <div class="text-end ms-3">
                <div class="text-muted small">Total Belanja</div>
                <div class="fw-bold fs-5 text-success">Rp<?= number_format($order['total_harga'],0,',','.') ?></div>
              </div>
            </div>
            <div class="d-flex justify-content-end gap-2 mt-2">
              <a href="detail.php?order_id=<?= $order['order_id'] ?>" class="btn btn-link text-success fw-bold">Lihat Detail Transaksi</a>
              <a href="/Arunika/view/user/product/detail.php?id=<?= $furniture_id ?>" class="btn btn-success">Beli Lagi</a>
              <!-- Menu aksi lain bisa ditambah di sini -->
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 