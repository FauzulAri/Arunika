<?php
ob_start();
?>
<div class="hero-detailwork-section">
    <div class="text-center w-100 d-flex flex-column align-items-center justify-content-center">
        <div class="hero-detailwork-title">Koleksi Furniture Arunika</div>
        <div class="hero-detailwork-subtitle">Temukan inspirasi furniture terbaik untuk melengkapi ruangan impian Anda.</div>
    </div>
</div>

<!-- Grid Gambar Furniture -->
<div class="hero2-section-v2">
    <div class="hero2-title-v2">Pilihan Furniture</div>
    <div class="designer-grid-section">
        <div class="designer-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior5.jpg" class="designer-img" alt="Sofa Minimalis">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Sofa Minimalis</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior6.jpg" class="designer-img" alt="Meja Kayu Modern">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Meja Kayu Modern</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/flower1.jpg" class="designer-img" alt="Rak Tanaman">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Rak Tanaman</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/flower2.avif" class="designer-img" alt="Kursi Rotan">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Kursi Rotan</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior1.jpg" class="designer-img" alt="Lemari Pajangan">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Lemari Pajangan</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior2.jpg" class="designer-img" alt="Meja Belajar">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Meja Belajar</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior3.jpeg" class="designer-img" alt="Buffet TV">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Buffet TV</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior4.jpeg" class="designer-img" alt="Meja Makan Keluarga">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Meja Makan Keluarga</div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?> 