<?php
// Dummy data, nanti bisa diisi dari database berdasarkan order_id
$order = [
  'nomor_order' => isset($_GET['order_id']) ? $_GET['order_id'] : 'ORD-20240708-0001',
  'tanggal_order' => date('Y-m-d H:i:s'),
  'total_harga' => 2500000,
  'status_order' => 'settlement',
];
?>
<div class="container py-5 text-center">
  <div class="alert alert-success mb-4">
    <h2>Pembayaran Berhasil!</h2>
    <p>Terima kasih, pesanan Anda telah diterima dan sedang diproses.</p>
  </div>
  <div class="card mx-auto" style="max-width:500px;">
    <div class="card-body">
      <h5 class="card-title">Ringkasan Pesanan</h5>
      <ul class="list-group mb-3 text-start">
        <li class="list-group-item"><b>No. Order:</b> <?= htmlspecialchars($order['nomor_order']) ?></li>
        <li class="list-group-item"><b>Tanggal:</b> <?= date('d M Y H:i', strtotime($order['tanggal_order'])) ?></li>
        <li class="list-group-item"><b>Total:</b> Rp<?= number_format($order['total_harga'],0,',','.') ?></li>
        <li class="list-group-item"><b>Status:</b> <span class="badge bg-success">Berhasil</span></li>
      </ul>
      <a href="/Arunika/view/user/order/index.php" class="btn btn-primary w-100 mb-2">Lihat Pesanan Saya</a>
      <a href="/Arunika/view/user/home/index.php" class="btn btn-outline-secondary w-100">Kembali ke Beranda</a>
    </div>
  </div>
</div> 