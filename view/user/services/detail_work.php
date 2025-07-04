<?php
ob_start();
?>
<div class="hero-detailwork-section">
    <div class="text-center w-100 d-flex flex-column align-items-center justify-content-center">
        <div class="hero-detailwork-title">Proses Desain Arunika Interior</div>
        <div class="hero-detailwork-subtitle">cara mudah untuk mendesain ruanganmu</div>
        <a href="/Arunika/view/user/get_start/getting_start.php" class="hero-detailwork-btn">Mulai sekarang</a>
    </div>
</div>
<div class="step-section">
    <div class="step-row">
        <div class="step-img-col">
            <div class="designer-grid-section">
                <div class="designer-grid">
                    <div class="designer-card active">
                        <img src="/Arunika/assets/img/interior1.jpg" class="designer-img" alt="Ghianella">
                        <div class="designer-info">
                            <img src="/Arunika/assets/img/person1.jpg" class="designer-avatar" alt="Ghianella">
                            <div>
                                <div class="designer-name">Ghianella</div>
                                <div class="designer-status">Taking on projects this week</div>
                            </div>
                        </div>
                    </div>
                    <div class="designer-card inactive">
                        <img src="/Arunika/assets/img/interior2.jpg" class="designer-img" alt="Freddi">
                        <div class="designer-info">
                            <img src="/Arunika/assets/img/person2.jpg" class="designer-avatar" alt="Freddi">
                            <div>
                                <div class="designer-name">Freddi</div>
                                <div class="designer-status">Taking on projects this week</div>
                            </div>
                        </div>
                    </div>
                    <div class="designer-card inactive">
                        <img src="/Arunika/assets/img/interior3.jpeg" class="designer-img" alt="Jordan">
                        <div class="designer-info">
                            <img src="/Arunika/assets/img/person3.jpg" class="designer-avatar" alt="Jordan">
                            <div>
                                <div class="designer-name">Jordan</div>
                                <div class="designer-status">Taking on projects this week</div>
                            </div>
                        </div>
                    </div>
                    <div class="designer-card inactive">
                        <img src="/Arunika/assets/img/interior4.jpeg" class="designer-img" alt="Emmanuel">
                        <div class="designer-info">
                            <img src="/Arunika/assets/img/person4.jpg" class="designer-avatar" alt="Emmanuel">
                            <div>
                                <div class="designer-name">Emmanuel</div>
                                <div class="designer-status">Taking on projects this week</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="step-text-col">
            <div class="step-label">STEP 1</div>
            <div class="step-title">Pilih Desainer</div>
            <div class="step-desc">Pilih salah satu desainer berbakat kami yang akan menjadi partner Anda selama proses desain. Mereka akan membimbing Anda secara personal dari awal hingga akhir.</div>
        </div>
    </div>
</div>
<div class="step-section">
    <div class="step-row">
        <div class="step-text-col">
            <div class="step-label">STEP 2</div>
            <div class="step-title">Ceritakan Kebutuhanmu</div>
            <div class="step-desc">Sampaikan detail kebutuhan dan inspirasi ruang impian Anda kepada desainer kami. Kami akan membantu mewujudkan visi Anda dengan solusi terbaik.</div>
        </div>
        <div class="step2-img-col">
            <img src="/Arunika/assets/img/interior5.jpg" class="step2-img-slider active" alt="Preview 1">
            <img src="/Arunika/assets/img/interior6.jpg" class="step2-img-slider" alt="Preview 2">
            <img src="/Arunika/assets/img/flower1.jpg" class="step2-img-slider" alt="Preview 3">
        </div>
    </div>
</div>
<div class="step-section">
    <div class="step-row">
        <div class="step3-img-col">
            <img src="/Arunika/assets/img/interior2.jpg" class="step3-img-slider active" alt="Step 3 Preview 1">
            <img src="/Arunika/assets/img/interior3.jpeg" class="step3-img-slider inactive" alt="Step 3 Preview 2">
            <img src="/Arunika/assets/img/interior4.jpeg" class="step3-img-slider inactive" alt="Step 3 Preview 3">
        </div>
        <div class="step-text-col">
            <div class="step-label">STEP 3</div>
            <div class="step-title">Kolaborasi & Inspirasi</div>
            <div class="step-desc">Kolaborasi dengan desainer kami untuk mendapatkan inspirasi dan solusi terbaik bagi ruang Anda. Setiap ide dan masukan akan membantu mewujudkan ruang impian Anda.</div>
        </div>
    </div>
</div>
<div class="step-section">
    <div class="step-row">
        <div class="step-text-col">
            <div class="step-label">STEP 4</div>
            <div class="step-title">Sentuhan Akhir</div>
            <div class="step-desc">Pilih ide desain favorit Anda dan kami akan menambahkan sentuhan akhir yang indah pada ruangan Anda.</div>
        </div>
        <div class="step4-img-col">
            <div class="step4-beforeafter-wrapper">
                <img src="/Arunika/assets/img/interior before.png" class="step4-img-before" alt="Before">
                <img src="/Arunika/assets/img/interior after.png" class="step4-img-after" alt="After">
                <div class="step4-vertical-bar"></div>
            </div>
        </div>
    </div>
</div>
<script>
// Animasi looping designer grid
const designers = document.querySelectorAll('.designer-card');
let activeIdx = 0;
function setActiveDesigner(idx) {
    designers.forEach((card, i) => {
        if (i === idx) {
            card.classList.add('active');
            card.classList.remove('inactive');
        } else {
            card.classList.remove('active');
            card.classList.add('inactive');
        }
    });
}
setActiveDesigner(activeIdx);
setInterval(() => {
    activeIdx = (activeIdx + 1) % designers.length;
    setActiveDesigner(activeIdx);
}, 2000);

// Slider animasi step 2 otomatis, slide always to left
const sliderImgs = document.querySelectorAll('.step2-img-col .step2-img-slider');
let sliderIdx = 0;
let prevIdx = 0;
function showSliderImg(idx, prev) {
    sliderImgs.forEach((img, i) => {
        img.classList.remove('active','prev','next');
        if(i === idx) img.classList.add('active');
        else if(i === prev) img.classList.add('prev');
        else img.classList.add('next');
    });
}
showSliderImg(sliderIdx, prevIdx);
setInterval(() => {
    prevIdx = sliderIdx;
    sliderIdx = (sliderIdx + 1) % sliderImgs.length;
    showSliderImg(sliderIdx, prevIdx);
}, 5000);

// Slider animasi step 3 otomatis, fade in/out
const step3Imgs = document.querySelectorAll('.step3-img-col .step3-img-slider');
let step3Idx = 0;
function showStep3Img(idx) {
    step3Imgs.forEach((img, i) => {
        img.classList.remove('active','inactive');
        if(i === idx) img.classList.add('active');
        else img.classList.add('inactive');
    });
}
showStep3Img(step3Idx);
setInterval(() => {
    step3Idx = (step3Idx + 1) % step3Imgs.length;
    showStep3Img(step3Idx);
}, 5000);

const afterImg = document.querySelector('.step4-img-after');
const bar = document.querySelector('.step4-vertical-bar');
const wrapper = document.querySelector('.step4-beforeafter-wrapper');

let progress = 110;
let direction = -1;

function animateBeforeAfter() {
    progress += direction * 1;

    // Hitung posisi bar (dari 0% sampai 100% area gambar)
    let barOffset = wrapper.offsetWidth * (progress / 100);

    // Bar di luar kanan
    if (progress > 100) {
        afterImg.style.clipPath = `inset(0 0 0 0)`;
        bar.style.left = (wrapper.offsetWidth) + 'px';
    }
    // Bar di luar kiri
    else if (progress < 0) {
        afterImg.style.clipPath = `inset(0 ${wrapper.offsetWidth}px 0 0)`;
        bar.style.left = (-bar.offsetWidth) + 'px';
        setTimeout(() => {
            progress = 110;
            setTimeout(animateBeforeAfter, 1200);
        }, 4000);
        return;
    }
    // Bar di dalam area gambar
    else {
        afterImg.style.clipPath = `inset(0 ${wrapper.offsetWidth - barOffset}px 0 0)`;
        bar.style.left = (barOffset - bar.offsetWidth / 2) + 'px';
    }

    setTimeout(animateBeforeAfter, 20);
}
animateBeforeAfter();
</script>
<?php
$content = ob_get_clean();
include $_SERVER['DOCUMENT_ROOT'] . '/Arunika/view/user/master.php';
?>
