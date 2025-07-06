<?php
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: /Arunika/view/user/product/furniture.php');
    exit();
}
$id = (int)$_GET['id'];
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Query detail furniture + kategori
$stmt = $conn->prepare("SELECT f.*, k.nama_kategori FROM furniture f LEFT JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.furniture_id = ? AND f.is_active = 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows < 1) {
    echo '<div class="container py-5 text-center"><h3>Produk tidak ditemukan.</h3></div>';
    exit();
}
$f = $res->fetch_assoc();

// Query diskon jika ada
$diskon = null;
$dq = $conn->prepare("SELECT * FROM diskon WHERE furniture_id = ? AND is_active = 1 AND NOW() BETWEEN tanggal_mulai AND tanggal_selesai LIMIT 1");
$dq->bind_param("i", $id);
$dq->execute();
$dr = $dq->get_result();
if ($dr->num_rows > 0) $diskon = $dr->fetch_assoc();

// Hitung harga lama jika diskon
$harga_lama = null;
$badge_diskon = '';
if ($diskon) {
    if ($diskon['tipe'] == 'persen') {
        $harga_lama = $f['harga'] / (1 - $diskon['nilai']/100);
        $badge_diskon = 'Diskon ' . number_format($diskon['nilai'],0) . '%';
    } else {
        $harga_lama = $f['harga'] + $diskon['nilai'];
        $badge_diskon = 'Hemat Rp' . number_format($diskon['nilai'],0,',','.');
    }
}
ob_start();
?>
<div class="container py-5" style="margin-top:40px;">
  <div class="row justify-content-center">
    <div class="col-lg-11">
      <div class="row g-4 align-items-start">
        <!-- Kiri: Gambar & Info -->
        <div class="col-md-7">
          <div class="card shadow-lg border-0 rounded-4 p-4 product-detail-container mb-4">
            <div class="row g-3">
              <div class="col-12">
                <nav aria-label="breadcrumb" class="mb-3">
                  <ol class="breadcrumb" style="background:transparent; padding:0; margin-bottom:1.2rem;">
                    <li class="breadcrumb-item">
                      <a href="/Arunika/view/user/product/furniture.php">Furniture</a>
                    </li>
                    <li class="breadcrumb-item">
                      <a href="/Arunika/view/user/product/furniture.php?cat=<?= urlencode($f['nama_kategori']) ?>">
                        <?= htmlspecialchars($f['nama_kategori']) ?>
                      </a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                      <?= htmlspecialchars($f['nama_furniture']) ?>
                    </li>
                  </ol>
                </nav>
                <div class="detail-img-wrap mb-3">
                  <img src="/Arunika/assets/img/<?= htmlspecialchars($f['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($f['nama_furniture']) ?>" class="img-fluid rounded shadow-sm w-100" style="max-height:350px;object-fit:cover;">
                </div>
              </div>
              <div class="col-12">
                <h2 class="mb-2" style="font-weight:700;"><?= htmlspecialchars($f['nama_furniture']) ?></h2>
                <div class="mb-2 text-muted">Kategori: <b><?= htmlspecialchars($f['nama_kategori']) ?></b></div>
                <?php if ($badge_diskon): ?>
                  <span class="badge bg-danger mb-2" style="font-size:1rem;"> <?= $badge_diskon ?> </span>
                <?php endif; ?>
                <div class="mb-3">
                  <?php if ($harga_lama): ?>
                    <span class="text-muted text-decoration-line-through" style="font-size:1.2rem;">Rp<?= number_format($harga_lama,0,',','.') ?></span>
                  <?php endif; ?>
                  <span class="ms-2" style="font-size:2rem;font-weight:700;color:#e07b87;">Rp<?= number_format($f['harga'],0,',','.') ?></span>
                </div>
                <div class="mb-2">Stok: <b><?= (int)$f['stok'] ?></b></div>
                <div class="mb-2">Material: <b><?= htmlspecialchars($f['material']) ?></b></div>
                <div class="mb-2">Dimensi: <b><?= htmlspecialchars($f['dimensi']) ?></b></div>
                <div class="mb-3">Berat: <b><?= number_format($f['berat'],2) ?> kg</b></div>
                <!-- Deskripsi Produk Langsung -->
                <div class="mt-4">
                  <b>Deskripsi Produk:</b>
                  <?php
                  $deskripsi = trim($f['deskripsi']);
                  $max_char = 200;
                  if (mb_strlen($deskripsi) > $max_char) {
                    $short_desc = mb_substr($deskripsi, 0, $max_char);
                    // pastikan tidak memotong di tengah kata
                    $last_space = mb_strrpos($short_desc, ' ');
                    if ($last_space !== false) $short_desc = mb_substr($short_desc, 0, $last_space);
                  ?>
                    <div id="desc-short" style="white-space:pre-line;"> <?= nl2br(htmlspecialchars($short_desc)) ?>...</div>
                    <div id="desc-full" style="display:none; white-space:pre-line;"> <?= nl2br(htmlspecialchars($deskripsi)) ?> </div>
                    <button type="button" class="btn btn-link p-0 mt-1" id="toggle-desc" style="font-size:1rem;">Tampilkan Lebih Banyak</button>
                  <?php } else { ?>
                    <div style="white-space:pre-line;"> <?= nl2br(htmlspecialchars($deskripsi)) ?> </div>
                  <?php } ?>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Kanan: Atur Jumlah & Aksi -->
        <div class="col-md-5">
          <div class="card shadow border-0 rounded-4 p-4 detail-kanan-sticky">
            <h5 class="mb-3">Atur jumlah dan catatan</h5>
            <?php if (isset($_SESSION['message'])): ?>
              <div class="alert alert-<?= $_SESSION['message_type'] ?? 'info' ?> alert-dismissible fade show" role="alert">
                <?= $_SESSION['message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>
              <?php unset($_SESSION['message'], $_SESSION['message_type']); ?>
            <?php endif; ?>
            <form method="post" action="/Arunika/controller/keranjang_add_ajax.php" id="form-keranjang" class="mb-2">
              <input type="hidden" name="furniture_id" value="<?= $f['furniture_id'] ?>">
              <div class="d-flex align-items-center mb-2 gap-2">
                <button type="button" class="btn btn-outline-secondary btn-sm" id="qty-minus">-</button>
                <input type="number" id="jumlah" name="jumlah" value="1" min="1" max="<?= (int)$f['stok'] ?>" class="form-control text-center" style="width:70px;" required>
                <button type="button" class="btn btn-outline-secondary btn-sm" id="qty-plus">+</button>
                <span class="ms-2 small">Stok Total: <b><?= (int)$f['stok'] ?></b></span>
              </div>
              <div class="mb-2">
                <label for="catatan" class="form-label">Catatan (opsional)</label>
                <input type="text" name="catatan" id="catatan" class="form-control" maxlength="100" placeholder="Contoh: warna coklat, kirim siang, dsb">
              </div>
              <div class="mb-3 d-flex justify-content-between align-items-center">
                <span>Subtotal</span>
                <span id="subtotal" class="fw-bold" style="font-size:1.3rem; color:#e07b87;">Rp<?= number_format($f['harga'],0,',','.') ?></span>
              </div>
              <div class="d-grid gap-2">
                <button type="submit" class="btn btn-success btn-lg"><i class="fas fa-shopping-cart"></i> + Keranjang</button>
              </div>
            </form>
            <form method="post" action="/Arunika/controller/keranjang_add.php" id="form-beli">
              <input type="hidden" name="furniture_id" value="<?= $f['furniture_id'] ?>">
              <input type="hidden" name="jumlah" id="jumlah-beli" value="1">
              <input type="hidden" name="catatan" id="catatan-beli">
              <button type="submit" name="beli_sekarang" class="btn btn-primary btn-lg w-100"><i class="fas fa-bolt"></i> Beli Sekarang</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<style>
.product-detail-container {
  background: #fff;
  border-radius: 24px;
  box-shadow: 0 4px 32px #0001;
}
.detail-img-wrap {
  background:#fff;border-radius:12px;box-shadow:0 2px 12px #0001;padding:1rem;
}
/* Tambahan padding pada tab deskripsi agar teks tidak menempel ke border */
.tab-content {
  padding: 1rem !important;
  background: #fff;
  border-radius: 0 0 16px 16px;
  min-height: 100px;
}
.tab-pane {
  padding: 0 !important;
}
/* Sticky kanan agar selalu di atas header saat scroll */
.detail-kanan-sticky {
  position: sticky;
  top: 72px; /* sesuaikan dengan tinggi header/navbar */
  z-index: 20;
}
@media (max-width: 991px) {
  .detail-kanan-sticky {
    position: static;
  }
}
@media (max-width: 900px) {
  .product-detail-container, .detail-kanan-sticky {margin-bottom: 2rem;}
}
.breadcrumb a { color: #a48ad4; text-decoration: none; }
.breadcrumb-item.active { color: #222; font-weight: 600; }
</style>
<script>
// Qty plus/minus
const qtyInput = document.getElementById('jumlah');
document.getElementById('qty-minus').onclick = function(e){ e.preventDefault(); if(qtyInput.value>1) qtyInput.value--; updateSubtotal(); syncBeli(); };
document.getElementById('qty-plus').onclick = function(e){ e.preventDefault(); if(qtyInput.value<<?= (int)$f['stok'] ?>) qtyInput.value++; updateSubtotal(); syncBeli(); };
qtyInput.addEventListener('input', function(){ updateSubtotal(); syncBeli(); });
function updateSubtotal(){
  let harga = <?= (int)$f['harga'] ?>;
  let qty = parseInt(qtyInput.value)||1;
  document.getElementById('subtotal').innerText = 'Rp'+(harga*qty).toLocaleString('id-ID');
}
function syncBeli(){
  document.getElementById('jumlah-beli').value = qtyInput.value;
  document.getElementById('catatan-beli').value = document.getElementById('catatan').value;
}
document.getElementById('catatan').addEventListener('input', syncBeli);
updateSubtotal();
syncBeli();
// Toggle deskripsi lebih banyak/sedikit
const btnToggleDesc = document.getElementById('toggle-desc');
if(btnToggleDesc){
  btnToggleDesc.addEventListener('click', function(){
    const shortDiv = document.getElementById('desc-short');
    const fullDiv = document.getElementById('desc-full');
    if(shortDiv.style.display !== 'none'){
      shortDiv.style.display = 'none';
      fullDiv.style.display = 'block';
      btnToggleDesc.innerText = 'Tampilkan Lebih Sedikit';
    }else{
      shortDiv.style.display = 'block';
      fullDiv.style.display = 'none';
      btnToggleDesc.innerText = 'Tampilkan Lebih Banyak';
    }
  });
}
// Tambah ke keranjang via AJAX
const formKeranjang = document.getElementById('form-keranjang');
if(formKeranjang){
  formKeranjang.addEventListener('submit', async function(e){
    e.preventDefault();
    const form = this;
    const data = new FormData(form);
    const btn = form.querySelector('button[type=submit]');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Menambah...';
    try {
      const res = await fetch('/Arunika/controller/keranjang_add_ajax.php', {
        method: 'POST',
        body: data
      });
      const json = await res.json();
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-shopping-cart"></i> + Keranjang';
      if(json.success){
        alert(json.message); // Ganti dengan toast jika ada
        form.jumlah.value = 1;
        updateSubtotal();
      }else{
        alert(json.message); // Ganti dengan toast jika ada
      }
    } catch(err){
      btn.disabled = false;
      btn.innerHTML = '<i class="fas fa-shopping-cart"></i> + Keranjang';
      alert('Terjadi kesalahan. Coba lagi.');
    }
  });
}
</script>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php'; 