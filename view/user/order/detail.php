<?php
ob_start();
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /Arunika/view/auth/login.php');
    exit();
}
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';
$user_id = $_SESSION['user_id'];
$order_id = isset($_GET['order_id']) ? $_GET['order_id'] : '';

// Ambil data order
$stmt = $conn->prepare("SELECT order_id, tanggal_order, status_order, total_harga, metode_pembayaran, payment_link FROM orders WHERE order_id = ? AND user_id = ?");
$stmt->bind_param('si', $order_id, $user_id);
$stmt->execute();
$stmt->bind_result($order_id, $tanggal_order, $status_order, $total_harga, $metode_pembayaran, $payment_link);
if (!$stmt->fetch()) {
    $stmt->close();
    echo '<div class="container py-5 text-center"><div class="alert alert-danger">Pesanan tidak ditemukan.</div></div>';
    exit();
}
$stmt->close();

// Ambil detail barang
$items = [];
$stmt = $conn->prepare("SELECT f.nama_furniture, f.gambar_furniture, d.jumlah, d.harga_satuan, d.subtotal FROM detail_order d JOIN furniture f ON d.furniture_id = f.furniture_id WHERE d.order_id = ?");
$stmt->bind_param('s', $order_id);
$stmt->execute();
$stmt->bind_result($nama_furniture, $gambar_furniture, $jumlah, $harga_satuan, $subtotal);
while ($stmt->fetch()) {
    $items[] = [
        'nama_furniture' => $nama_furniture,
        'gambar_furniture' => $gambar_furniture,
        'jumlah' => $jumlah,
        'harga_satuan' => $harga_satuan,
        'subtotal' => $subtotal,
    ];
}
$stmt->close();

// Dummy nomor VA (bisa diambil dari tabel pembayaran jika sudah diintegrasi)
$va_number = '1234567890123456';
?>
<div class="container py-4">
  <h2 class="mb-4">Detail Pesanan</h2>
  <div class="card mb-4">
    <div class="card-body">
      <div class="d-flex flex-wrap align-items-center mb-2">
        <span class="fw-bold me-3">No. Order:</span> <span class="me-4"> <?= htmlspecialchars($order_id) ?> </span>
        <span class="fw-bold me-3">Tanggal:</span> <span class="me-4"> <?= date('d M Y H:i', strtotime($tanggal_order)) ?> </span>
        <span class="badge bg-<?= $status_order=='settlement'?'success':($status_order=='pending'?'warning':'secondary') ?> ms-auto">
          <?= ucfirst($status_order=='settlement'?'Selesai':$status_order) ?>
        </span>
      </div>
      <div class="mb-2"><b>Metode Pembayaran:</b> <?= htmlspecialchars($metode_pembayaran) ?></div>
      <?php if ($status_order == 'pending'): ?>
        <?php if (!empty($payment_link)): ?>
          <div class="alert alert-info mb-2">
            <b>Pembayaran Belum Selesai</b><br>
            Silakan klik tombol di bawah untuk melanjutkan pembayaran:<br>
            <a href="<?= htmlspecialchars($payment_link) ?>" target="_blank" class="btn btn-success mt-2">Bayar Sekarang via Midtrans</a>
          </div>
        <?php else: ?>
          <div class="alert alert-warning mb-2">
            <b>Nomor Virtual Account:</b> <span class="text-monospace"> <?= $va_number ?> </span><br>
            Silakan lakukan pembayaran ke nomor VA di atas sebelum pesanan expired.
          </div>
        <?php endif; ?>
      <?php endif; ?>
      <div class="mb-2"><b>Total:</b> Rp<?= number_format($total_harga,0,',','.') ?></div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><b>Daftar Barang</b></div>
    <div class="card-body p-0">
      <table class="table mb-0">
        <thead>
          <tr>
            <th>Produk</th>
            <th>Jumlah</th>
            <th>Harga Satuan</th>
            <th>Subtotal</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($items as $item): ?>
          <tr>
            <td class="d-flex align-items-center gap-2">
              <img src="/Arunika/assets/img/<?= htmlspecialchars($item['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($item['nama_furniture']) ?>" style="width:48px; height:48px; object-fit:cover; border-radius:8px;">
              <?= htmlspecialchars($item['nama_furniture']) ?>
            </td>
            <td><?= $item['jumlah'] ?></td>
            <td>Rp<?= number_format($item['harga_satuan'],0,',','.') ?></td>
            <td>Rp<?= number_format($item['subtotal'],0,',','.') ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
  <div class="mt-4 text-end">
    <a href="index.php" class="btn btn-outline-secondary">Kembali ke Pesanan Saya</a>
  </div>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 