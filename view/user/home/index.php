<?php

ob_start();

// Ambil data furniture dan kategori dari database
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

// Ambil kategori
$kategori = [];
$kq = $conn->query("SELECT * FROM kategori WHERE is_active = 1 ORDER BY kategori_id ASC");
while ($row = $kq->fetch_assoc()) {
    $kategori[] = $row;
}

// Ambil furniture
$furnitures = [];
$fq = $conn->query("SELECT f.*, k.nama_kategori FROM furniture f JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.is_active = 1 ORDER BY f.furniture_id DESC");
while ($row = $fq->fetch_assoc()) {
    $furnitures[] = $row;
}

// Ambil data promo dari furniture yang memiliki diskon aktif
$promo = [];
$pq = $conn->query("SELECT f.*, k.nama_kategori, d.tipe, d.nilai, d.keterangan,
    CASE 
        WHEN d.tipe = 'persen' THEN f.harga / (1 - d.nilai/100)
        ELSE f.harga + d.nilai
    END AS harga_lama,
    CASE 
        WHEN d.tipe = 'persen' THEN d.nilai
        ELSE (d.nilai / f.harga) * 100
    END AS diskon_persen
    FROM furniture f 
    JOIN kategori k ON f.kategori_id = k.kategori_id 
    JOIN diskon d ON f.furniture_id = d.furniture_id
    WHERE f.is_active = 1 
    AND d.is_active = 1
    AND NOW() BETWEEN d.tanggal_mulai AND d.tanggal_selesai
    ORDER BY d.tanggal_selesai ASC 
    LIMIT 8");
while ($row = $pq->fetch_assoc()) {
    $promo[] = $row;
}

// Produk terlaris (random 10 furniture)
$terlaris = [];
$tq = $conn->query("SELECT f.*, k.nama_kategori FROM furniture f JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.is_active = 1 ORDER BY RAND() LIMIT 10");
while ($row = $tq->fetch_assoc()) {
    $terlaris[] = $row;
}
?>

<!-- HERO SECTION -->
<section class="hero-arunika">
  <div class="hero-arunika-bg">
    <img src="/Arunika/assets/img/interior1.jpg" alt="Hero Arunika"/>
    </div>
  <div class="hero-arunika-content">
    <h1 class="hero-arunika-title">Marketplace Furniture & Interior Terlengkap</h1>
    <p class="hero-arunika-subtitle">Temukan ribuan produk furniture berkualitas, promo menarik, dan inspirasi ruang impian Anda di Arunika Interior.</p>
    <a href="/Arunika/view/user/product/furniture.php" class="hero-arunika-btn no-underline">Jelajahi Katalog</a>
    <a href="#promo" class="hero-arunika-btn btn-outline no-underline">Lihat Promo</a>
</div>
</section>

<!-- KATEGORI UTAMA -->
<section class="kategori-arunika">
  <h2 class="section-title">Kategori Populer</h2>
  <div class="kategori-grid">
    <?php foreach ($kategori as $k): ?>
      <a href="#furniture-section" class="kategori-card kategori-link" data-kategori="<?= htmlspecialchars($k['nama_kategori']) ?>">
        <div class="kategori-icon"><i class="fa <?= htmlspecialchars($k['icon']) ?>"></i></div>
        <div class="kategori-nama"><?= htmlspecialchars($k['nama_kategori']) ?></div>
      </a>
    <?php endforeach; ?>
                </div>
</section>

<!-- PROMO/FLASH SALE -->
<section class="promo-arunika" id="promo">
  <h2 class="section-title">Promo & Flash Sale</h2>
  <div class="promo-carousel swiper">
    <div class="swiper-wrapper">
      <?php if (empty($promo)): ?>
        <div class="swiper-slide w-100">
          <div class="alert alert-info text-center"><i class="fas fa-info-circle"></i> Belum ada promo aktif saat ini.</div>
        </div>
      <?php else: ?>
        <?php foreach ($promo as $p): ?>
          <div class="swiper-slide">
            <a href="/Arunika/view/user/product/detail.php?id=<?= $p['furniture_id'] ?>&promo=1" class="promo-card" style="text-decoration:none;">
              <img src="/Arunika/assets/img/<?= htmlspecialchars($p['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($p['nama_furniture']) ?>">
              <div class="promo-info">
                <div class="promo-title"><i class="fa fa-bolt text-warning"></i> <?= htmlspecialchars($p['nama_furniture']) ?></div>
                <div class="promo-price-old">Rp<?= number_format($p['harga_lama'],0,',','.') ?></div>
                <div class="promo-badge">
                  <?php if ($p['tipe'] == 'persen'): ?>
                    Diskon <?= number_format($p['diskon_persen'],0) ?>%
                  <?php else: ?>
                    Hemat Rp<?= number_format($p['nilai'],0,',','.') ?>
                  <?php endif; ?>
                </div>
                <div class="promo-price">Rp<?= number_format($p['harga'],0,',','.') ?></div>
                <div class="promo-keterangan"><?= htmlspecialchars($p['keterangan']) ?></div>
              </div>
            </a>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>

<!-- REKOMENDASI UNTUK ANDA -->
<section class="unggulan-arunika" id="furniture-section">
  <h2 class="section-title">Rekomendasi untuk Anda</h2>
  <div class="unggulan-grid">
    <?php foreach (array_slice($terlaris,0,15) as $t): ?>
      <a href="/Arunika/view/user/product/detail.php?id=<?= $t['furniture_id'] ?>" class="unggulan-card" style="text-decoration:none; color:inherit;">
        <img src="/Arunika/assets/img/<?= htmlspecialchars($t['gambar_furniture'] ?? 'noimage.jpg') ?>" alt="<?= htmlspecialchars($t['nama_furniture']) ?>">
        <div class="unggulan-title"><?= htmlspecialchars($t['nama_furniture']) ?></div>
        <div class="unggulan-price">Rp<?= number_format($t['harga'],0,',','.') ?></div>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- KEUNGGULAN/BENEFIT -->
<section class="benefit-arunika">
  <h2 class="section-title">Kenapa Pilih Arunika?</h2>
  <div class="benefit-grid">
    <div class="benefit-card"><i class="fa fa-truck"></i><div>Gratis Ongkir</div></div>
    <div class="benefit-card"><i class="fa fa-shield-alt"></i><div>Garansi Produk</div></div>
    <div class="benefit-card"><i class="fa fa-th-large"></i><div>Pilihan Lengkap</div></div>
    <div class="benefit-card"><i class="fa fa-headset"></i><div>CS Ramah</div></div>
        </div>
</section>

<!-- TESTIMONI/ULASAN -->
<section class="testimoni-arunika">
  <h2 class="section-title">Apa Kata Pelanggan?</h2>
  <div class="testimoni-grid">
    <div class="testimoni-card">
      <img src="/Arunika/assets/img/person1.jpg" class="testimoni-img" alt="User 1">
      <div class="testimoni-nama">Fajar Andika</div>
      <div class="testimoni-rating">★★★★★</div>
      <div class="testimoni-isi">Produk berkualitas, pengiriman cepat, dan CS sangat membantu!</div>
    </div>
    <div class="testimoni-card">
      <img src="/Arunika/assets/img/person2.jpg" class="testimoni-img" alt="User 2">
      <div class="testimoni-nama">Rina Lestari</div>
      <div class="testimoni-rating">★★★★★</div>
      <div class="testimoni-isi">Banyak pilihan furniture, harga bersaing, dan promo menarik.</div>
    </div>
    <div class="testimoni-card">
      <img src="/Arunika/assets/img/person3.jpg" class="testimoni-img" alt="User 3">
      <div class="testimoni-nama">Maria Lestari</div>
      <div class="testimoni-rating">★★★★★</div>
      <div class="testimoni-isi">Sangat puas belanja di Arunika, pasti akan order lagi!</div>
    </div>
</div>
</section>

<!-- INSPIRASI RUANG (OPSIONAL) -->
<section class="inspirasi-arunika">
  <h2 class="section-title">Inspirasi Ruang</h2>
  <div class="inspirasi-grid">
    <div class="inspirasi-card"><img src="/Arunika/assets/img/interior2.jpg" alt="Inspirasi 1"><div>Ruang Tamu Modern</div></div>
    <div class="inspirasi-card"><img src="/Arunika/assets/img/interior3.jpeg" alt="Inspirasi 2"><div>Ruang Keluarga Nyaman</div></div>
    <div class="inspirasi-card"><img src="/Arunika/assets/img/interior4.jpeg" alt="Inspirasi 3"><div>Kamar Tidur Minimalis</div></div>
    <div class="inspirasi-card"><img src="/Arunika/assets/img/interior5.jpg" alt="Inspirasi 4"><div>Sudut Kerja Fungsional</div></div>
  </div>
</section>

<style>
.hero-arunika {
  position: relative;
  width: 100vw;
  min-height: 60vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f7f7fa;
  overflow: hidden;
}
.hero-arunika-bg img {
  width: 100vw;
  min-height: 60vh;
  object-fit: cover;
  filter: brightness(0.7);
  position: absolute;
  left: 0; top: 0; right: 0; bottom: 0;
  z-index: 1;
}
.hero-arunika-content {
  position: relative;
  z-index: 2;
  text-align: center;
  color: #fff;
  max-width: 700px;
  margin: 0 auto;
  padding: 4rem 1rem 3rem 1rem;
}
.hero-arunika-title {
  font-size: 2.5rem;
  font-weight: bold;
  margin-bottom: 1.2rem;
  text-shadow: 0 2px 16px rgba(0,0,0,0.3);
}
.hero-arunika-subtitle {
  font-size: 1.2rem;
  margin-bottom: 2rem;
  text-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.hero-arunika-btn, .hero-arunika-btn.btn-outline, .no-underline {
  text-decoration: none !important;
}
.hero-arunika-btn {
  background: #FEA5AD;
  color: #fff;
  border: none;
  border-radius: 40px;
  padding: 0.75rem 2.5rem;
  font-size: 1.1rem;
  font-weight: 500;
  margin: 0 0.5rem 0.5rem 0.5rem;
  transition: background 0.2s;
  display: inline-block;
}
.hero-arunika-btn.btn-outline {
  background: #fff;
  color: #FEA5AD;
  border: 2px solid #FEA5AD;
}
.hero-arunika-btn:hover {
  background: #e07b87;
  color: #fff;
}

.section-title {
  font-size: 2rem;
  font-weight: 600;
  text-align: center;
  margin: 2.5rem 0 1.5rem 0;
  color: #222;
  font-family: 'Sansita Swashed', cursive;
}

.kategori-arunika {
  background: #fff;
  padding: 2rem 0 2rem 0;
}
.kategori-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
  gap: 1.5rem;
  max-width: 900px;
  margin: 0 auto;
}
.kategori-card {
  background: #f7f7fa;
  border-radius: 16px;
  padding: 1.2rem 0.5rem;
  text-align: center;
  color: #222;
  text-decoration: none;
  box-shadow: 0 2px 12px #0001;
  transition: box-shadow 0.2s, transform 0.2s;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.kategori-card:hover {
  box-shadow: 0 6px 24px #0002;
  transform: translateY(-4px) scale(1.04);
}
.kategori-icon {
  font-size: 2.2rem;
  margin-bottom: 0.7rem;
  color: #FEA5AD;
}
.kategori-nama {
  font-size: 1.1rem;
  font-weight: 500;
}

.promo-arunika {
  background: #faece6;
  padding: 2rem 0 2rem 0;
}
.promo-carousel { position:relative; }
.promo-carousel .swiper-wrapper { display:flex; align-items:stretch; }
.promo-carousel .swiper-slide { width:220px; max-width:90vw; margin-right: 0; }
.promo-card {
  background: #fff;
  border-radius: 14px;
  box-shadow: 0 2px 12px #0001;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 400px;
  max-width: 240px;
  margin: 0 auto;
  padding-bottom: 1rem;
  text-align: center;
}
.promo-card img {
  width: 100%;
  height: 260px;
  object-fit: cover;
}
.promo-info { padding: 0.8rem 0.7rem 0.5rem 0.7rem; width: 100%; }
.promo-title {
  font-weight: 600;
  font-size: 1.1rem;
  margin-bottom: 0.3rem;
}
.promo-price-old {
  text-decoration: line-through;
  color: #b0b0b0;
  font-size: 0.95rem;
  margin-bottom: 0.1rem;
}
.promo-badge {
  background: #ff3d3d;
  color: #fff;
  font-size: 0.85rem;
  border-radius: 8px;
  padding: 0.1rem 0.6rem;
  margin-bottom: 0.2rem;
  display: inline-block;
}
.promo-price {
  font-weight: bold;
  font-size: 1.1rem;
  color: #222;
  margin-bottom: 0.2rem;
}
.promo-keterangan {
  font-size: 0.85rem;
  color: #666;
  font-style: italic;
  margin-top: 0.3rem;
}

.unggulan-arunika {
  background: #fff;
  padding: 2rem 0 2rem 0;
}
.unggulan-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  grid-auto-rows: 1fr;
  gap: 2rem;
  max-width: 1300px;
  margin: 0 auto;
}
.unggulan-card {
  background: #f7f7fa;
  border-radius: 20px;
  box-shadow: 0 2px 12px #0001;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 1.5rem;
  min-height: 320px;
  max-width: 260px;
  margin: 0 auto;
  transition: box-shadow 0.2s, transform 0.2s;
}
.unggulan-card img {
  width: 100%;
  height: 180px;
  object-fit: cover;
  border-radius: 20px 20px 0 0;
}
.unggulan-title {
  font-weight: 600;
  font-size: 1.1rem;
  margin: 1.2rem 0 0.5rem 0;
  text-align: center;
}
.unggulan-price {
  font-weight: bold;
  font-size: 1.3rem;
  color: #222;
  margin-bottom: 0.2rem;
  text-align: center;
}
@media (max-width: 1200px) {
  .unggulan-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (max-width: 900px) {
  .unggulan-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (max-width: 600px) {
  .unggulan-grid { grid-template-columns: 1fr; }
  .unggulan-card { max-width: 100%; }
}

.benefit-arunika {
  background: #faece6;
  padding: 2rem 0 2rem 0;
}
.benefit-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center;
  align-items: center;
  max-width: 1100px;
  margin: 0 auto;
}
.benefit-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 12px #0001;
  padding: 2rem 1.5rem;
  text-align: center;
  font-size: 1.1rem;
  color: #FEA5AD;
  font-weight: 600;
  display: flex;
  flex-direction: column;
  align-items: center;
  min-width: 160px;
}
.benefit-card i {
  font-size: 2.2rem;
  margin-bottom: 0.7rem;
}
.benefit-card div {
  color: #222;
  font-size: 1.1rem;
  font-weight: 500;
}

.testimoni-arunika {
  background: #fff;
  padding: 2rem 0 2rem 0;
}
.testimoni-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: center;
  align-items: stretch;
  max-width: 1100px;
  margin: 0 auto;
}
.testimoni-card {
  background: #faece6;
  border-radius: 16px;
  box-shadow: 0 2px 12px #0001;
  padding: 2rem 1.5rem;
  text-align: center;
  color: #222;
  font-size: 1rem;
  flex: 1 1 220px;
  max-width: 320px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.testimoni-img {
  width: 56px;
  height: 56px;
  border-radius: 50%;
  object-fit: cover;
  margin-bottom: 1rem;
  border: 3px solid #fff;
  box-shadow: 0 2px 8px #0001;
}
.testimoni-nama {
  font-size: 1.1rem;
  font-weight: 600;
  color: #333;
  margin-bottom: 0.7rem;
}
.testimoni-rating {
  color: #FFD600;
  font-size: 1.3rem;
  margin-bottom: 1.1rem;
}
.testimoni-isi {
  font-size: 1rem;
  color: #444;
  margin-bottom: 0.2rem;
}

.inspirasi-arunika {
  background: #faece6;
  padding: 2rem 0 2rem 0;
}
.inspirasi-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 1.5rem;
  max-width: 1100px;
  margin: 0 auto;
}
.inspirasi-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 12px #0001;
  overflow: hidden;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding-bottom: 1rem;
}
.inspirasi-card img {
  width: 100%;
  height: 120px;
  object-fit: cover;
}
.inspirasi-card div {
  font-weight: 600;
  font-size: 1rem;
  margin: 0.7rem 0 0.3rem 0;
  text-align: center;
}
</style>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<script>
// Kategori Populer: filter dan scroll ke section furniture
function filterFurnitureByKategori(kat) {
  window.location.href = '/Arunika/view/user/product/furniture.php?cat=' + encodeURIComponent(kat);
}
document.querySelectorAll('.kategori-link').forEach(btn => {
  btn.addEventListener('click', function(e){
    e.preventDefault();
    const kategori = this.getAttribute('data-kategori');
    filterFurnitureByKategori(kategori);
  });
});
// Swiper promo carousel
var swiper = new Swiper('.promo-carousel', {
  slidesPerView: 1,
  spaceBetween: 8,
  navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
  breakpoints: { 600: { slidesPerView: 2 }, 900: { slidesPerView: 3 }, 1200: { slidesPerView: 4 }, 1500: { slidesPerView: 5 } }
});
</script>

<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?>