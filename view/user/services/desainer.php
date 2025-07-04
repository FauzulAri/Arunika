<?php
ob_start();
?>
<div class="hero-detailwork-section">
    <div class="text-center w-100 d-flex flex-column align-items-center justify-content-center">
        <div class="hero-detailwork-title">Temukan Desain & Desainer Favoritmu</div>
        <div class="hero-detailwork-subtitle">Jelajahi inspirasi desain dan desainer terbaik dari Arunika Interior untuk mewujudkan ruang impian Anda.</div>
        <a href="/Arunika/view/user/get_start/getting_start.php" class="hero-detailwork-btn">Mulai sekarang</a>
    </div>
</div>

<!-- Hero Section 2: Pilihan Desain & Desainer -->
<div class="hero2-section-v2">
    <div class="hero2-title-v2">Pilihan Desain Interior</div>
    <div class="designer-grid-section">
        <div class="designer-grid" style="grid-template-columns: repeat(4, 1fr);">
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior1.jpg" class="designer-img" alt="Desain 1">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Living Room Cozy</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior2.jpg" class="designer-img" alt="Desain 2">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Modern Minimalis</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior3.jpeg" class="designer-img" alt="Desain 3">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Scandinavian Style</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior4.jpeg" class="designer-img" alt="Desain 4">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Classic Elegance</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior5.jpg" class="designer-img" alt="Desain 5">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Tropical Vibes</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/interior6.jpg" class="designer-img" alt="Desain 6">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Industrial Urban</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/flower1.jpg" class="designer-img" alt="Desain 7">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Floral Accent</div>
            </div>
            <div class="designer-card">
                <img src="/Arunika/assets/img/flower2.avif" class="designer-img" alt="Desain 8">
                <div class="designer-name" style="text-align:center; margin: 0.7rem 0 0.3rem 0;">Natural Light</div>
            </div>
        </div>
    </div>
    <div class="hero2-title-v2" style="margin-top:3.5rem; font-size:2rem;">Pilih Desainer Favoritmu</div>
    <div class="designer-grid-section">
        <div class="designer-grid" style="grid-template-columns: repeat(3, 1fr);">
            <div class="designer-card">
                <div class="designer-info">
                    <img src="/Arunika/assets/img/profile/user_5_1751457587.jpg" class="designer-avatar" alt="Desainer 1">
                    <div>
                        <div class="designer-name">Ayu Pratiwi</div>
                        <div class="designer-status">Spesialis Scandinavian</div>
                    </div>
                </div>
            </div>
            <div class="designer-card">
                <div class="designer-info">
                    <img src="/Arunika/assets/img/profile/user_5_1751458219.jpg" class="designer-avatar" alt="Desainer 2">
                    <div>
                        <div class="designer-name">Budi Santoso</div>
                        <div class="designer-status">Modern Minimalis</div>
                    </div>
                </div>
            </div>
            <div class="designer-card">
                <div class="designer-info">
                    <img src="/Arunika/assets/img/person3.jpg" class="designer-avatar" alt="Desainer 3">
                    <div>
                        <div class="designer-name">Citra Lestari</div>
                        <div class="designer-status">Klasik Elegan</div>
                    </div>
                </div>
            </div>
            <div class="designer-card">
                <div class="designer-info">
                    <img src="/Arunika/assets/img/person1.jpg" class="designer-avatar" alt="Desainer 4">
                    <div>
                        <div class="designer-name">Dewi Anggraini</div>
                        <div class="designer-status">Industrial & Urban</div>
                    </div>
                </div>
            </div>
            <div class="designer-card">
                <div class="designer-info">
                    <img src="/Arunika/assets/img/person2.jpg" class="designer-avatar" alt="Desainer 5">
                    <div>
                        <div class="designer-name">Eko Prabowo</div>
                        <div class="designer-status">Tropical Modern</div>
                    </div>
                </div>
            </div>
            <div class="designer-card">
                <div class="designer-info">
                    <img src="/Arunika/assets/img/person4.jpg" class="designer-avatar" alt="Desainer 6">
                    <div>
                        <div class="designer-name">Fira Rahma</div>
                        <div class="designer-status">Vintage & Retro</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?> 