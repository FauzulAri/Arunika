<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
// Include koneksi database
include_once $_SERVER['DOCUMENT_ROOT'] . '/Arunika/config/connect.php';

$keyword = isset($_GET['q']) ? trim($_GET['q']) : '';
if ($keyword !== '') {
    // Query pencarian produk
    $stmt = $conn->prepare("SELECT f.*, k.nama_kategori FROM furniture f LEFT JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.is_active = TRUE AND (f.nama_furniture LIKE ? OR f.deskripsi LIKE ?) ORDER BY f.furniture_id DESC");
    $like = '%' . $keyword . '%';
    $stmt->bind_param('ss', $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
    $furnitures = [];
    while ($row = $result->fetch_assoc()) {
        $furnitures[] = $row;
    }
    $stmt->close();
    $judul = 'Menampilkan pencarian produk "' . htmlspecialchars($keyword) . '"';
    $show_kategori = false;
} else {
    // Query untuk mengambil semua data furniture dengan join kategori
    $query = "SELECT f.*, k.nama_kategori FROM furniture f LEFT JOIN kategori k ON f.kategori_id = k.kategori_id WHERE f.is_active = TRUE ORDER BY f.furniture_id DESC";
    $result = $conn->query($query);
    $furnitures = [];
    while ($row = $result->fetch_assoc()) {
        $furnitures[] = $row;
    }
    $judul = 'Pilihan Furniture';
    $show_kategori = true;
}

ob_start();
?>
<div class="hero-detailwork-section">
    <div class="hero-detailwork-bg">
      <img src="/Arunika/assets/img/interior1.jpg" alt="Hero Furniture" class="hero-detailwork-img">
    </div>
    <div class="hero-detailwork-overlay d-flex flex-column align-items-center justify-content-center text-center">
        <div class="hero-detailwork-title">Koleksi Furniture Arunika</div>
        <div class="hero-detailwork-subtitle">Temukan inspirasi furniture terbaik untuk melengkapi ruangan impian Anda.</div>
    </div>
</div>

<!-- Grid Gambar Furniture -->
<div class="hero2-section-v2">
    <div class="hero2-title-v2"><?= $judul ?></div>
    <!-- Filter Kategori -->
    <?php if ($show_kategori): ?>
    <div class="text-center mb-4">
        <div class="btn-group" role="group" aria-label="Filter Kategori">
            <button type="button" class="btn btn-outline-primary active" data-filter="all">Semua</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Sofa">Sofa</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Meja">Meja</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Kursi">Kursi</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Lemari">Lemari</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Tempat Tidur">Tempat Tidur</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Dekorasi">Dekorasi</button>
            <button type="button" class="btn btn-outline-primary" data-filter="Lainnya">Lainnya</button>
        </div>
    </div>
    <?php endif; ?>
    <div class="designer-grid-section">
        <div id="furniture-list" class="designer-grid furniture-grid-5"></div>
            </div>
    <div id="pagination" class="pagination-furniture mt-4 d-flex justify-content-center"></div>
            </div>

<style>
.designer-grid-section {
    width: 100%;
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    flex-direction: column;
    align-items: center;
}
.furniture-grid-5 {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    grid-auto-rows: auto;
    gap: 1rem;
    justify-items: center;
}
@media (max-width: 1200px) {
    .furniture-grid-5 {
        grid-template-columns: repeat(3, 1fr);
    }
}
@media (max-width: 900px) {
    .furniture-grid-5 {
        grid-template-columns: repeat(2, 1fr);
    }
}
@media (max-width: 600px) {
    .furniture-grid-5 {
        grid-template-columns: 1fr;
    }
}
.designer-card {
    width: 100%;
    max-width: 260px;
    min-width: 200px;
    margin: 0 auto;
    height: 100%;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    overflow: hidden;
}
.designer-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.furniture-image-container {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
}
.furniture-overlay {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.3) 100%);
    color: white;
    padding: 1rem;
    opacity: 0;
    transition: opacity 0.3s ease;
}
.furniture-item:hover .furniture-overlay {
    opacity: 1;
}
.furniture-price {
    font-size: 1.2rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}
.furniture-category {
    font-size: 0.9rem;
    opacity: 0.9;
}
.furniture-info {
    padding: 1rem;
}
.btn-group .btn {
    border-radius: 20px;
    margin: 0 0.25rem;
}
.btn-group .btn.active {
    background-color: #007bff;
    border-color: #007bff;
    color: white;
}
.pagination-furniture .page-link {
    border-radius: 8px;
    margin: 0 0.2rem;
    color: #007bff;
    border: 1px solid #e9ecef;
    background: #fff;
    min-width: 36px;
    text-align: center;
}
.pagination-furniture .page-link.active {
    background: #007bff;
    color: #fff;
    border-color: #007bff;
}
.hero-detailwork-section {
  position: relative;
  width: 100vw;
  min-height: 320px;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
  margin-bottom: 2rem;
}
.hero-detailwork-bg {
  position: absolute;
  left: 0; top: 0; right: 0; bottom: 0;
  width: 100vw;
  height: 100%;
  z-index: 1;
}
.hero-detailwork-img {
  width: 100vw;
  height: 100%;
  object-fit: cover;
  filter: brightness(0.7);
}
.hero-detailwork-overlay {
  position: relative;
  z-index: 2;
  width: 100vw;
  min-height: 320px;
  padding: 3rem 1rem 2rem 1rem;
  color: #fff;
  background: rgba(0,0,0,0.0);
}
.hero-detailwork-title {
  font-size: 2.2rem;
  font-weight: bold;
  margin-bottom: 1.2rem;
  text-shadow: 0 2px 16px rgba(0,0,0,0.3);
}
.hero-detailwork-subtitle {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  text-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
@media (max-width: 900px) {
  .hero-detailwork-title { font-size: 1.5rem; }
  .hero-detailwork-section, .hero-detailwork-overlay { min-height: 180px; }
}
</style>
<script>
const furnitures = <?= json_encode($furnitures) ?>;
let filtered = furnitures;
let currentPage = 1;
const perPage = 40; // 5x8 grid

function renderFurnitureGrid() {
    const start = (currentPage - 1) * perPage;
    const end = start + perPage;
    const items = filtered.slice(start, end);
    const grid = document.getElementById('furniture-list');
    if (items.length === 0) {
        grid.innerHTML = '<div class="col-12 text-center"><div class="alert alert-info"><i class="fas fa-info-circle"></i> Belum ada furniture yang tersedia saat ini.</div></div>';
        document.getElementById('pagination').innerHTML = '';
        return;
    }
    grid.innerHTML = items.map(row => `
        <a href="/Arunika/view/user/product/detail.php?id=${row.furniture_id}" class="designer-card furniture-item" data-kategori="${row.nama_kategori}" style="text-decoration:none; color:inherit;">
            <div class="furniture-image-container">
                ${row.gambar_furniture ?
                    `<img src="/Arunika/assets/img/${row.gambar_furniture}" class="designer-img" alt="${row.nama_furniture}" style="width: 100%; height: 200px; object-fit: cover;">` :
                    `<div class="designer-img" style="width: 100%; height: 200px; background: #f8f9fa; display: flex; align-items: center; justify-content: center;"><i class='fas fa-image text-muted' style='font-size: 3rem;'></i></div>`
                }
                <div class="furniture-overlay">
                    <div class="furniture-price">Rp ${parseInt(row.harga).toLocaleString('id-ID')}</div>
                    <div class="furniture-category">${row.nama_kategori}</div>
            </div>
            </div>
            <div class="furniture-info">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0; font-weight: 600;">
                    ${row.nama_furniture.length > 32 ? row.nama_furniture.substring(0,32)+'...' : row.nama_furniture}
            </div>
                ${row.deskripsi ? `<div class="furniture-description" style="text-align:center; color: #666; font-size: 0.9rem; margin-bottom: 1rem;">${row.deskripsi.length > 100 ? row.deskripsi.substring(0,100)+'...' : row.deskripsi}</div>` : ''}
            </div>
        </a>
    `).join('');
    renderPagination();
}

function renderPagination() {
    const total = Math.ceil(filtered.length / perPage);
    let html = '';
    if (total <= 1) { document.getElementById('pagination').innerHTML = ''; return; }
    for (let i = 1; i <= total; i++) {
        html += `<button class="page-link${i === currentPage ? ' active' : ''}" onclick="gotoPage(${i})">${i}</button>`;
    }
    document.getElementById('pagination').innerHTML = html;
}
function gotoPage(page) {
    currentPage = page;
    renderFurnitureGrid();
    window.scrollTo({top: document.querySelector('.hero2-section-v2').offsetTop-80, behavior:'smooth'});
}

document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('[data-filter]');
    // Ambil parameter cat dari URL
    const urlParams = new URLSearchParams(window.location.search);
    const catParam = urlParams.get('cat');
    let initialFilter = 'all';
    
    if (catParam && <?= $show_kategori ? 'true' : 'false' ?>) {
        // Cari tombol filter yang sesuai kategori
        filterButtons.forEach(btn => {
            if (btn.getAttribute('data-filter') === catParam) {
                btn.classList.add('active');
                initialFilter = catParam;
            } else {
                btn.classList.remove('active');
            }
        });
        filtered = furnitures.filter(f => f.nama_kategori === catParam);
    } else {
        filterButtons[0]?.classList.add('active');
        filtered = furnitures;
    }
    currentPage = 1;
    renderFurnitureGrid();

    // Event click filter
    filterButtons.forEach(button => {
        button.addEventListener('click', function() {
            const filter = this.getAttribute('data-filter');
            filterButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            filtered = filter === 'all' ? furnitures : furnitures.filter(f => f.nama_kategori === filter);
            currentPage = 1;
            renderFurnitureGrid();
        });
    });
});
</script>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?> 