# DOKUMENTASI AUDIT SISTEM INFORMASI ARUNIKA INTERIOR

**Periode Audit:** Desember 2024  
**Tim Auditor:** Tim Audit IT  
**Versi Dokumen:** 2.0 (Revisi Final)  

---

## 1. PENDAHULUAN

### 1.1 Latar Belakang

Di tengah meningkatnya kebutuhan masyarakat terhadap produk furnitur dan desain interior yang praktis dan berkualitas, proses pencarian dan pembelian produk secara online masih menyisakan banyak kendala. Kurangnya informasi produk yang detail, keterbatasan fitur perbandingan harga, dan sistem transaksi yang belum sepenuhnya transparan membuat calon pembeli enggan melakukan pembelian secara digital. 

Untuk menjawab tantangan ini, Arunika Interior mengembangkan platform marketplace furnitur berbasis web dengan fitur katalog produk, keranjang belanja, sistem pembayaran terintegrasi Midtrans, dan manajemen order yang komprehensif. Sistem ini telah beroperasi dengan database MySQL yang terstruktur, mendukung berbagai kategori furnitur, dan memiliki panel admin untuk pengelolaan produk dan transaksi.

Audit ini dilakukan untuk mengevaluasi sejauh mana pengelolaan dan implementasi TI pada proyek Arunika Interior sudah sesuai dengan praktik terbaik dalam pengembangan sistem e-commerce, dengan fokus pada domain Build, Acquire, and Implement (BAI) dari framework COBIT 2019.

### 1.2 Dasar Hukum

Audit ini dilakukan dengan mengacu pada:

1. **Kerangka kerja COBIT 2019** dari ISACA sebagai pedoman utama tata kelola dan manajemen teknologi informasi
2. **UU Republik Indonesia No. 11 Tahun 2008** tentang Informasi dan Transaksi Elektronik (UU ITE)
3. **UU Republik Indonesia No. 19 Tahun 2016** tentang Perubahan atas UU No. 11 Tahun 2008
4. **Peraturan Menteri Komunikasi dan Informatika No. 20 Tahun 2016** tentang Perlindungan Data Pribadi dalam Sistem Elektronik
5. **PCI DSS v4.0** untuk keamanan data kartu pembayaran
6. **ISO/IEC 27001:2013** Information Security Management System

### 1.3 Metodologi Audit

Metode yang digunakan meliputi:

1. **Observasi dan dokumentasi sistem**
   - Review struktur database MySQL
   - Analisis arsitektur aplikasi PHP
   - Evaluasi integrasi payment gateway Midtrans

2. **Wawancara internal** (Product Owner, Scrum Master, Frontend & Backend Developer)
   - Evaluasi proses pengembangan
   - Review dokumentasi teknis
   - Analisis manajemen risiko

3. **Analisis menggunakan domain BAI (Build, Acquire, and Implement)**
   - Penilaian 11 proses BAI01-BAI11
   - Evaluasi capability level setiap proses

4. **Penilaian tingkat kapabilitas (Capability Level Assessment)**
   - Pengukuran level 0-5 untuk setiap proses
   - Identifikasi gap dengan target level

5. **Gap analysis dan perumusan rekomendasi**
   - Analisis kesenjangan implementasi
   - Formulasi rekomendasi perbaikan

### 1.4 Tujuan Audit

1. **Menilai kesesuaian proses pengembangan dan implementasi sistem Arunika Interior** dengan kerangka kerja COBIT 2019 domain BAI
2. **Mengidentifikasi kelemahan dan risiko** dalam pengelolaan sistem e-commerce
3. **Memberikan rekomendasi untuk perbaikan** proses pengelolaan TI dan keamanan sistem
4. **Memastikan kepatuhan** terhadap regulasi yang berlaku
5. **Mengoptimalkan kinerja sistem** untuk meningkatkan user experience dan keamanan transaksi

### 1.5 Ruang Lingkup Audit

Audit ini mencakup proses pada domain COBIT 2019: **Build, Acquire and Implement (BAI)** dari BAI01 sampai BAI11, dengan fokus pada:

- **BAI01:** Manage Programs and Projects
- **BAI02:** Manage Requirements Definition  
- **BAI03:** Manage Solutions Build
- **BAI04:** Manage Availability
- **BAI05:** Organizational Change
- **BAI06:** Manage Changes
- **BAI07:** Change Acceptance
- **BAI08:** Manage Knowledge
- **BAI09:** Test Environment
- **BAI10:** Configuration Management
- **BAI11:** Requirement Maintenance

**Sistem yang diaudit:**
- Aplikasi web e-commerce (PHP Native) dengan struktur MVC
- Database MySQL dengan 8 tabel utama (user, admin, kategori, furniture, keranjang, orders, detail_order, review, diskon)
- Integrasi payment gateway Midtrans dengan multiple payment methods
- Panel admin untuk manajemen produk, user, dan order
- Sistem keranjang belanja dengan AJAX dan checkout process
- Sistem review dan rating produk
- Manajemen diskon dan promo terintegrasi

---

## 2. GAMBARAN UMUM

### 2.1 Proses Bisnis

Arunika Interior menjalankan bisnis sebagai marketplace furnitur digital, mempertemukan vendor furnitur dengan konsumen melalui platform web. Proses utama meliputi:

#### 2.1.1 Proses Manajemen Produk
- **Input data produk oleh admin** melalui panel admin (`/view/admin/data_furniture/`)
- **Kategorisasi furnitur** (Sofa, Meja, Kursi, Lemari, Tempat Tidur, Dekorasi, dll.)
- **Pengelolaan stok dan harga** real-time dengan validasi
- **Manajemen diskon dan promo** dengan sistem diskon terintegrasi (persen/nominal)
- **Upload gambar produk** dengan validasi file dan optimasi

#### 2.1.2 Proses Transaksi Customer
- **Browse katalog produk** dengan filter kategori dan pencarian
- **Tambah ke keranjang** dengan sistem AJAX (`/controller/keranjang_add_ajax.php`)
- **Update keranjang** dengan AJAX (`/controller/keranjang_update_ajax.php`)
- **Proses checkout** dengan validasi stok dan kalkulasi total
- **Pembayaran via Midtrans** (transfer bank BCA/BRI/Mandiri, COD, e-wallet)
- **Tracking order** dengan status real-time (pending → confirmed → processing → shipped → delivered)
- **Review produk** setelah pembelian dengan rating dan komentar

#### 2.1.3 Proses Manajemen Order
- **Konfirmasi order** oleh admin melalui panel admin (`/view/admin/data_order/`)
- **Update status pengiriman** dengan notifikasi ke customer
- **Pencatatan feedback pelanggan** dengan sistem review dan rating
- **Manajemen user** (tambah, edit, hapus customer) melalui panel admin
- **Laporan penjualan** dan analisis data transaksi

### 2.2 Arsitektur Teknologi Informasi

#### 2.2.1 Stack Teknologi
- **Frontend:** HTML5, CSS3, Bootstrap 5.3.3, JavaScript, FontAwesome, Swiper.js
- **Backend:** PHP Native dengan struktur MVC sederhana
- **Database:** MySQL 8.0 dengan 9 tabel utama
- **Payment Gateway:** Midtrans PHP SDK v2.6.2
- **Development Tools:** Composer untuk dependency management
- **Server:** Apache/Nginx dengan PHP 8.x
- **File Storage:** Local file system untuk gambar produk dan profil

#### 2.2.2 Struktur Database
```sql
-- Tabel Utama (9 tabel)
user (customer data dengan foto profil)
admin (administrator data dengan role-based access)
kategori (product categories dengan icon)
furniture (product catalog dengan detail spesifikasi)
keranjang (shopping cart dengan AJAX)
orders (order management dengan status tracking)
detail_order (order items dengan harga snapshot)
review (product reviews dengan rating dan gambar)
diskon (promo management dengan tipe persen/nominal)
```

#### 2.2.3 Arsitektur Sistem
```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Customer UI   │    │   Admin Panel   │    │   Payment API   │
│   (Bootstrap)   │    │   (PHP Native)  │    │   (Midtrans)    │
│   + Swiper.js   │    │   + AJAX        │    │   + Webhook     │
└─────────┬───────┘    └─────────┬───────┘    └─────────┬───────┘
          │                      │                      │
          └──────────────────────┼──────────────────────┘
                                 │
                    ┌─────────────▼─────────────┐
                    │      Web Server           │
                    │   (Apache + PHP 8.x)      │
                    │   + File Storage          │
                    └─────────────┬─────────────┘
                                  │
                    ┌─────────────▼─────────────┐
                    │      Database Server      │
                    │        (MySQL 8.0)        │
                    │   + 9 Tabel Utama        │
                    └───────────────────────────┘
```

### 2.3 Struktur Organisasi

#### 2.3.1 Tim Pengembangan
- **Product Owner:** Mufqi Ammar Fauzan
- **Scrum Master & Full Stack Developer:** Fauzul Akbar Arianto
- **Frontend Developer:** Rasendria Danbelva Fadhil
- **Backend Developer:** Dicki Ahmad Mutamaqin

#### 2.3.2 Tanggung Jawab Tim
- **Product Owner:** Definisi requirement, prioritas fitur, stakeholder management
- **Scrum Master:** Agile process, sprint planning, team coordination
- **Frontend Developer:** UI/UX implementation, responsive design, user experience
- **Backend Developer:** Database design, API development, payment integration

---

## 3. PELAKSANAAN AUDIT

### 3.1 Design Factors

Faktor-faktor desain yang mempengaruhi pengelolaan TI Arunika Interior:

| Faktor | Deskripsi | Dampak pada Audit |
|--------|-----------|-------------------|
| **Ukuran organisasi** | Kecil (4 developer) | Proses informal, dokumentasi minimal |
| **Strategi TI** | Mendukung digitalisasi penjualan furnitur | Fokus pada e-commerce dan payment |
| **Risiko** | Transaksi gagal, tidak validasi akun, data breach | Prioritas keamanan dan validasi |
| **Regulasi** | UU ITE, kebijakan privasi, PCI DSS | Compliance requirements |
| **Sumber daya** | In-house developer dengan skill PHP/MySQL | Self-developed solution |
| **Budaya** | Agile dan kolaboratif | Iterative development approach |

### 3.2 Goals Cascade

**Enterprise Goals (EG) → Alignment Goals (AG) → COBIT BAI Objectives:**

| Enterprise Goals (EG) | Alignment Goals (AG) | COBIT BAI Objectives |
|----------------------|---------------------|---------------------|
| EG08 - Produk unggul | AG14 - Solusi sesuai kebutuhan | BAI02 - Manage Requirements Definition |
| EG06 - Layanan berkelanjutan | AG07 - Delivery & reliability | BAI09 - Test Environment |
| EG07 - Kepatuhan & kontrol risiko | AG09 - Keamanan | BAI03 - Manage Solutions Build |
| EG03 - Pelayanan pelanggan | AG15 - Dokumentasi pengguna | BAI05 - Organizational Change |
| EG12 - Pengelolaan risiko | AG03 - Optimasi risiko | BAI01 - Manage Programs and Projects |

### 3.3 Capability Level BAI01 – BAI11

| Kode | Nama Proses | Temuan | Level Saat Ini (0–5) | Target Level |
|------|-------------|--------|----------------------|--------------|
| **BAI01** | Manage Programs and Projects | Agile diterapkan, belum terdokumentasi | 3 | 4 |
| **BAI02** | Manage Requirements Definition | Tidak ada SRS formal | 2 | 3 |
| **BAI03** | Manage Solutions Build | Validasi input dasar, belum komprehensif | 3 | 4 |
| **BAI04** | Manage Availability | Tidak ada monitoring uptime | 2 | 3 |
| **BAI05** | Organizational Change | Tidak ada dokumentasi user | 1 | 3 |
| **BAI06** | Manage Changes | Tidak terdokumentasi versi | 2 | 3 |
| **BAI07** | Change Acceptance | UAT tidak terdokumentasi | 2 | 3 |
| **BAI08** | Manage Knowledge | Dokumen proyek hanya offline | 2 | 3 |
| **BAI09** | Test Environment | Black-box test dilakukan | 3 | 4 |
| **BAI10** | Configuration Management | Struktur belum terdokumentasi | 2 | 3 |
| **BAI11** | Requirement Maintenance | Tidak ada histori update kebutuhan | 1 | 3 |

**Keterangan Level:**
- **Level 0:** Incomplete
- **Level 1:** Performed (dilakukan tapi tidak terdokumentasi)
- **Level 2:** Managed (dilakukan dengan dokumentasi terbatas)
- **Level 3:** Established (terdokumentasi dan distandarkan)
- **Level 4:** Predictable (terukur dan dapat diprediksi)
- **Level 5:** Optimizing (terus diperbaiki)

### 3.4 Gap Analysis

| Kode | Target Level | Level Saat Ini | GAP | Prioritas |
|------|-------------|----------------|-----|-----------|
| BAI01 | 4 | 3 | 1 | Sedang |
| BAI02 | 3 | 2 | 1 | Tinggi |
| BAI03 | 4 | 3 | 1 | Tinggi |
| BAI04 | 3 | 2 | 1 | Sedang |
| BAI05 | 3 | 1 | 2 | Tinggi |
| BAI06 | 3 | 2 | 1 | Sedang |
| BAI07 | 3 | 2 | 1 | Sedang |
| BAI08 | 3 | 2 | 1 | Rendah |
| BAI09 | 4 | 3 | 1 | Sedang |
| BAI10 | 3 | 2 | 1 | Sedang |
| BAI11 | 3 | 1 | 2 | Tinggi |

### 3.5 Temuan & Rekomendasi

#### 3.5.1 Temuan Kritis (High Priority)

| Proses | Risiko | Rekomendasi | Timeline |
|--------|--------|-------------|----------|
| **BAI02** | Sistem tidak sesuai ekspektasi user | Buat dokumen SRS formal dengan use case dan user story | 2 minggu |
| **BAI03** | Sistem tidak aman, validasi lemah | Implementasi validasi email, CAPTCHA, dan sanitasi input | 1 bulan |
| **BAI05** | User kesulitan menggunakan sistem | Tambah FAQ, user guide, dan dokumentasi lengkap | 1 bulan |
| **BAI11** | Tidak diketahui perubahan kebutuhan | Simpan changelog dan histori requirement dengan versioning | 2 minggu |

#### 3.5.2 Temuan Sedang (Medium Priority)

| Proses | Risiko | Rekomendasi | Timeline |
|--------|--------|-------------|----------|
| **BAI01** | Proyek tidak terstruktur | Dokumentasi agile process dan project management | 1 bulan |
| **BAI04** | Downtime tidak terdeteksi | Implementasi monitoring uptime dan alerting | 2 minggu |
| **BAI06** | Perubahan tidak terkontrol | Implementasi version control dan change log | 1 bulan |
| **BAI07** | Bug tidak terdeteksi | Dokumentasi UAT dan acceptance criteria | 2 minggu |
| **BAI09** | Testing tidak komprehensif | Tambah automated test dan unit testing | 2 bulan |
| **BAI10** | Konfigurasi tidak terdokumentasi | Dokumentasi environment dan deployment process | 1 bulan |

#### 3.5.3 Temuan Rendah (Low Priority)

| Proses | Risiko | Rekomendasi | Timeline |
|--------|--------|-------------|----------|
| **BAI08** | Knowledge tidak tersimpan | Implementasi knowledge base dan dokumentasi online | 3 bulan |

### 3.6 Rekomendasi Implementasi

#### 3.6.1 Rekomendasi Keamanan (BAI03)

```php
// Implementasi validasi email
function validateEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) && 
           preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email);
}

// Implementasi CAPTCHA
function verifyCaptcha($response) {
    $secret = "YOUR_CAPTCHA_SECRET";
    $url = "https://www.google.com/recaptcha/api/siteverify";
    $data = ['secret' => $secret, 'response' => $response];
    $result = file_get_contents($url . '?' . http_build_query($data));
    return json_decode($result)->success;
}

// Sanitasi input untuk mencegah XSS
function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
}

// Validasi file upload untuk gambar produk
function validateFileUpload($file, $allowedTypes = ['jpg', 'jpeg', 'png', 'webp']) {
    $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    return in_array($fileExtension, $allowedTypes) && $file['size'] <= 5000000; // 5MB max
}
```

#### 3.6.2 Rekomendasi Monitoring (BAI04)

```php
// Monitoring script untuk sistem Arunika Interior
function checkSystemHealth() {
    $checks = [
        'database' => checkDatabaseConnection(),
        'payment_gateway' => checkMidtransAPI(),
        'disk_space' => checkDiskSpace(),
        'memory_usage' => checkMemoryUsage(),
        'file_uploads' => checkFileUploadDirectory(),
        'session_storage' => checkSessionStorage()
    ];
    
    foreach ($checks as $service => $status) {
        if (!$status) {
            sendAlert("Service $service is down");
        }
    }
}

// Uptime monitoring
function logUptime() {
    $log = [
        'timestamp' => date('Y-m-d H:i:s'),
        'status' => 'UP',
        'response_time' => measureResponseTime()
    ];
    file_put_contents('/logs/uptime.log', json_encode($log) . "\n", FILE_APPEND);
}
```

#### 3.6.3 Rekomendasi Dokumentasi (BAI02, BAI05)

```markdown
# Software Requirements Specification (SRS)
## 1. Introduction
### 1.1 Purpose
Dokumen ini mendefinisikan requirement untuk sistem Arunika Interior

### 1.2 Scope
Sistem e-commerce untuk marketplace furnitur

## 2. Functional Requirements
### 2.1 User Management
- FR1: User dapat registrasi dengan email valid
- FR2: User dapat login dengan email dan password
- FR3: User dapat update profil

### 2.2 Product Management
- FR4: Admin dapat tambah/edit/hapus produk dengan validasi
- FR5: Admin dapat kelola kategori produk dengan icon
- FR6: Admin dapat kelola diskon dan promo (persen/nominal)
- FR7: Admin dapat upload gambar produk dengan validasi

### 2.3 Order Management
- FR8: User dapat tambah produk ke keranjang dengan AJAX
- FR9: User dapat update keranjang dengan AJAX
- FR10: User dapat checkout dengan validasi stok
- FR11: User dapat pembayaran via Midtrans (BCA/BRI/Mandiri)
- FR12: Admin dapat kelola status order dengan notifikasi
- FR13: User dapat review produk setelah pembelian
```

---

## 4. KESIMPULAN HASIL AUDIT

### 4.1 Tingkat Kesesuaian Audit

Berdasarkan hasil audit terhadap 11 proses dalam domain BAI, ditemukan bahwa sebagian besar proses telah berjalan pada level yang cukup baik namun belum optimal. 

**Distribusi Level Capability:**
- **Level 3 (Established):** 3 proses (BAI01, BAI03, BAI09) - 27%
- **Level 2 (Managed):** 6 proses (BAI02, BAI04, BAI06, BAI07, BAI08, BAI10) - 55%
- **Level 1 (Performed):** 2 proses (BAI05, BAI11) - 18%

**Skor Rata-rata:** 2.27 dari 5.0 (45.4%)

**Analisis Capability Level:**
- **Level 3 (Established):** Proses sudah terdokumentasi dan distandarkan
- **Level 2 (Managed):** Proses dilakukan dengan dokumentasi terbatas
- **Level 1 (Performed):** Proses dilakukan namun belum terdokumentasi

### 4.2 Daftar Hasil Audit

#### 4.2.1 Level 3 (Established) - Sudah Baik
- **BAI01:** Manage Programs and Projects - Agile methodology diterapkan dengan sprint planning
- **BAI03:** Manage Solutions Build - Validasi input dasar sudah ada dengan prepared statements
- **BAI09:** Test Environment - Black-box testing dilakukan untuk fitur utama

#### 4.2.2 Level 2 (Managed) - Perlu Perbaikan
- **BAI02:** Manage Requirements Definition - Tidak ada SRS formal dengan use case
- **BAI04:** Manage Availability - Tidak ada monitoring uptime dan alerting
- **BAI06:** Manage Changes - Tidak terdokumentasi versi dan change log
- **BAI07:** Change Acceptance - UAT tidak terdokumentasi dengan acceptance criteria
- **BAI08:** Manage Knowledge - Dokumen hanya offline tanpa knowledge base
- **BAI10:** Configuration Management - Struktur database dan environment belum terdokumentasi

#### 4.2.3 Level 1 (Performed) - Kritis
- **BAI05:** Organizational Change - Tidak ada dokumentasi user guide dan FAQ
- **BAI11:** Requirement Maintenance - Tidak ada histori update requirement dan changelog

### 4.3 Saran Perbaikan Menyeluruh

#### 4.3.1 Peningkatan Dokumentasi (Prioritas Tinggi)
1. **Menyusun dokumen kebutuhan sistem (SRS)** dengan use case dan user story yang lengkap untuk fitur e-commerce
2. **Mencatat histori perubahan** backlog dan kebutuhan sistem melalui changelog terstruktur dengan versioning
3. **Membuat dokumentasi pengguna** yang komprehensif dengan FAQ dan user guide untuk customer dan admin

#### 4.3.2 Penguatan Pengujian & Validasi Sistem (Prioritas Tinggi)
1. **Menerapkan pengujian otomatis** untuk mengurangi risiko kesalahan fungsi pada payment gateway dan checkout
2. **Memastikan validasi form input** dan keamanan akun pengguna menggunakan metode seperti CAPTCHA dan verifikasi email
3. **Implementasi unit testing** untuk critical functions seperti keranjang, checkout, dan payment processing

#### 4.3.3 Monitoring dan Evaluasi Kinerja Sistem (Prioritas Sedang)
1. **Mengimplementasikan tools monitoring** uptime dan response time untuk memastikan ketersediaan sistem e-commerce
2. **Setup alerting system** untuk critical issues seperti payment gateway down atau database error
3. **Performance monitoring** untuk database dan aplikasi dengan focus pada checkout process

#### 4.3.4 Knowledge Management dan Capacity Building (Prioritas Sedang)
1. **Menyediakan sistem basis pengetahuan** internal bagi tim pengembang dengan dokumentasi teknis
2. **Memberikan pelatihan** dan onboarding dokumentatif untuk pengguna admin dan customer
3. **Implementasi version control** yang proper untuk source code dan database schema

#### 4.3.5 Perencanaan Ke Depan (Prioritas Rendah)
1. **Menyusun roadmap audit lanjutan** untuk mengevaluasi kembali perbaikan yang telah dilakukan pada sistem e-commerce
2. **Melakukan asesmen ulang** setiap 6–12 bulan sesuai siklus pengembangan produk dan update teknologi
3. **Implementasi continuous improvement** process dengan focus pada user experience dan keamanan

### 4.4 Timeline Implementasi

| Fase | Periode | Fokus | Target Capability Level |
|------|---------|-------|------------------------|
| **Fase 1** | Bulan 1-2 | Keamanan & Dokumentasi | BAI02, BAI03, BAI05, BAI11 → Level 3 |
| **Fase 2** | Bulan 3-4 | Monitoring & Testing | BAI04, BAI09 → Level 4 |
| **Fase 3** | Bulan 5-6 | Process Improvement | BAI01, BAI06, BAI07, BAI10 → Level 3 |
| **Fase 4** | Bulan 7-8 | Knowledge Management | BAI08 → Level 3 |

**Target Akhir:** Rata-rata capability level 3.5 (70%) dalam 8 bulan dengan fokus pada keamanan e-commerce dan user experience

Dengan penerapan saran tersebut, diharapkan seluruh proses pada domain BAI dapat ditingkatkan hingga minimal Level 3 (Established) dan menjamin bahwa sistem Arunika Interior berjalan secara optimal, aman, serta mendukung kebutuhan pengguna secara berkelanjutan dengan fokus pada keamanan transaksi e-commerce dan user experience yang optimal.

---

**Dokumentasi ini disusun berdasarkan hasil audit yang telah dilaksanakan dan dapat digunakan sebagai referensi untuk perbaikan sistem Arunika Interior ke depannya.**

**Disusun oleh:** Tim Audit IT  
**Tanggal:** 31 Desember 2024  
**Disetujui oleh:** [Nama Penyetuju]  
**Versi:** 2.0 (Revisi) 