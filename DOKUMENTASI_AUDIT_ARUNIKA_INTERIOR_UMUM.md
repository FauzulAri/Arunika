# DOKUMENTASI AUDIT SISTEM INFORMASI ARUNIKA INTERIOR

**Periode Audit:** Desember 2024  
**Tim Auditor:** Tim Audit IT  
**Versi Dokumen:** 1.0 (Umum)  

---

## 1. PENDAHULUAN

### 1.1 Latar Belakang

Di tengah meningkatnya kebutuhan masyarakat terhadap produk furnitur dan desain interior yang praktis dan berkualitas, proses pencarian dan pembelian produk secara online masih menyisakan banyak kendala. Kurangnya informasi produk yang detail, keterbatasan fitur perbandingan harga, dan sistem transaksi yang belum sepenuhnya transparan membuat calon pembeli enggan melakukan pembelian secara digital. 

Untuk menjawab tantangan ini, Arunika Interior mengembangkan platform marketplace furnitur berbasis web dengan fitur katalog produk, keranjang belanja, sistem pembayaran terintegrasi, dan manajemen order yang komprehensif. Sistem ini telah beroperasi dengan database yang terstruktur, mendukung berbagai kategori furnitur, dan memiliki panel admin untuk pengelolaan produk dan transaksi.

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
   - Review struktur database dan arsitektur aplikasi
   - Evaluasi integrasi payment gateway
   - Analisis keamanan sistem

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
- Aplikasi web e-commerce dengan struktur MVC
- Database dengan 9 tabel utama untuk manajemen data
- Integrasi payment gateway dengan multiple payment methods
- Panel admin untuk manajemen produk, user, dan order
- Sistem keranjang belanja dengan teknologi AJAX
- Sistem review dan rating produk
- Manajemen diskon dan promo terintegrasi

---

## 2. GAMBARAN UMUM

### 2.1 Proses Bisnis

Arunika Interior menjalankan bisnis sebagai marketplace furnitur digital yang mempertemukan vendor furnitur dengan konsumen melalui platform web yang terintegrasi. Sistem ini dirancang untuk memberikan pengalaman berbelanja yang seamless dari awal hingga akhir transaksi.

**Proses Manajemen Produk** menjadi fondasi utama sistem, dimana admin memiliki kendali penuh atas katalog produk melalui panel administrasi yang terpusat. Admin dapat menambahkan, mengedit, dan menghapus data produk dengan mudah. Sistem kategorisasi furnitur dirancang dengan fleksibilitas tinggi, mencakup berbagai jenis seperti Sofa, Meja, Kursi, Lemari, Tempat Tidur, Dekorasi, dan kategori lainnya yang dapat disesuaikan dengan kebutuhan bisnis. Pengelolaan stok dan harga dilakukan secara real-time dengan sistem validasi otomatis yang memastikan data selalu akurat. Untuk meningkatkan daya tarik produk, sistem dilengkapi dengan manajemen diskon dan promo yang terintegrasi, mendukung berbagai jenis diskon baik persentase maupun nominal. Setiap produk dapat dilengkapi dengan gambar berkualitas tinggi melalui sistem upload yang dilengkapi validasi file dan optimasi gambar otomatis.

**Proses Transaksi Customer** dirancang dengan mempertimbangkan user experience yang optimal. Customer dapat menjelajahi katalog produk dengan berbagai filter kategori dan fitur pencarian yang responsif. Sistem keranjang belanja menggunakan teknologi AJAX yang memungkinkan customer menambahkan produk ke keranjang tanpa perlu reload halaman, memberikan pengalaman yang smooth dan cepat. Customer juga dapat mengupdate keranjang dengan mudah, mengubah jumlah item atau menghapus produk yang tidak diinginkan. Proses checkout dirancang dengan validasi stok otomatis dan kalkulasi total yang akurat, memastikan customer tidak dapat memesan produk yang tidak tersedia. Sistem pembayaran mendukung berbagai metode yang umum digunakan di Indonesia, termasuk transfer bank, COD (Cash on Delivery), dan e-wallet. Setelah pembayaran, customer dapat melacak status order mereka secara real-time, dari status pending hingga delivered. Untuk meningkatkan kepercayaan antar customer, sistem dilengkapi dengan fitur review dan rating produk yang memungkinkan customer memberikan feedback setelah pembelian.

**Proses Manajemen Order** memberikan admin kontrol penuh atas seluruh transaksi. Admin dapat mengkonfirmasi order melalui panel administrasi yang terpusat, memastikan setiap transaksi valid sebelum diproses. Sistem update status pengiriman dilengkapi dengan notifikasi otomatis ke customer, sehingga customer selalu mendapat informasi terkini tentang pesanan mereka. Feedback pelanggan dikelola melalui sistem review dan rating yang terintegrasi, memberikan insights berharga untuk perbaikan produk dan layanan. Admin juga memiliki kemampuan untuk mengelola data user, termasuk menambah, mengedit, dan menghapus data customer sesuai kebutuhan. Untuk mendukung keputusan bisnis, sistem dilengkapi dengan laporan penjualan dan analisis data transaksi yang komprehensif.

### 2.2 Arsitektur Teknologi Informasi

Arsitektur teknologi informasi Arunika Interior dirancang dengan pendekatan modern yang mengutamakan performa, keamanan, dan skalabilitas. Sistem ini mengadopsi arsitektur client-server yang modular, memungkinkan pengembangan yang fleksibel dan maintenance yang mudah. Stack teknologi yang dipilih mempertimbangkan kebutuhan bisnis e-commerce yang memerlukan kecepatan, keamanan transaksi, dan user experience yang optimal. Integrasi berbagai komponen teknologi dilakukan dengan memastikan kompatibilitas dan efisiensi dalam pengelolaan data dan proses bisnis.

#### 2.2.1 Stack Teknologi

**Frontend Development**
- **HTML5 dan CSS3:** Digunakan sebagai fondasi untuk struktur dan styling website, memastikan kompatibilitas dengan berbagai browser dan perangkat
- **Bootstrap Framework:** Diimplementasikan untuk desain responsif yang memastikan tampilan optimal di desktop, tablet, dan mobile device
- **JavaScript:** Digunakan untuk interaktivitas dan dynamic content, termasuk AJAX untuk operasi keranjang belanja tanpa reload halaman
- **Swiper.js Library:** Diintegrasikan untuk carousel dan slider yang menampilkan produk dengan animasi yang menarik

**Backend Development**
- **PHP Native:** Dipilih sebagai bahasa pemrograman server-side yang powerful dan fleksibel untuk pengembangan aplikasi web
- **MVC Architecture:** Diimplementasikan untuk memisahkan logika bisnis (Model), presentasi (View), dan kontrol (Controller)
- **Session Management:** Dikelola untuk autentikasi user dan admin dengan keamanan yang memadai

**Database Management**
- **MySQL 8.0:** Dipilih sebagai sistem manajemen database relasional yang robust dan scalable
- **9 Tabel Utama:** Dirancang dengan normalisasi yang optimal untuk menghindari redundancy dan memastikan integritas data
- **Index Optimization:** Diimplementasikan untuk mempercepat query dan meningkatkan performa database

**Payment Integration**
- **Midtrans Payment Gateway:** Diintegrasikan untuk memproses berbagai metode pembayaran seperti transfer bank, COD, dan e-wallet
- **Webhook System:** Diimplementasikan untuk handling notifikasi pembayaran secara real-time
- **Security Protocol:** Diterapkan untuk memastikan keamanan transaksi finansial sesuai standar PCI DSS

**Development Tools**
- **Composer:** Digunakan untuk dependency management yang memudahkan pengelolaan library dan framework
- **Version Control:** Diimplementasikan untuk tracking perubahan source code dan collaboration tim
- **Local Development Environment:** Dikonfigurasi untuk development yang konsisten antar developer

**Server Infrastructure**
- **Apache/Nginx Web Server:** Dikonfigurasi untuk menangani HTTP request dan response dengan efisien
- **PHP 8.x:** Dioptimalkan untuk performa dan keamanan dalam menjalankan aplikasi
- **File Storage System:** Diimplementasikan untuk menyimpan gambar produk dan dokumen dengan struktur yang terorganisir

#### 2.2.2 Struktur Database

Sistem database Arunika Interior dirancang dengan pendekatan yang komprehensif untuk mendukung seluruh operasi bisnis e-commerce. Arsitektur database mengadopsi relational database model dengan 9 tabel utama yang saling terhubung melalui foreign key relationships, memastikan data consistency dan referential integrity.

**Tabel User**
- **Fungsi:** Menyimpan data customer dengan informasi lengkap termasuk profil dan preferensi
- **Fitur Khusus:** Foto profil, status online/offline, dan tracking aktivitas terakhir
- **Keamanan:** Password di-hash dan data sensitif dilindungi

**Tabel Admin**
- **Fungsi:** Mengelola data administrator dengan role-based access control
- **Fitur Khusus:** Role hierarchy (super admin, admin), tracking login terakhir
- **Keamanan:** Session management dan audit trail untuk aktivitas admin

**Tabel Kategori**
- **Fungsi:** Mengelompokkan produk berdasarkan jenis furnitur
- **Fitur Khusus:** Icon untuk visual representation, deskripsi kategori
- **Fleksibilitas:** Status aktif/nonaktif untuk manajemen kategori

**Tabel Furniture**
- **Fungsi:** Menyimpan katalog produk dengan detail spesifikasi lengkap
- **Fitur Khusus:** Dimensi, material, berat, stok real-time, gambar produk
- **Optimasi:** Index untuk pencarian dan filtering yang cepat

**Tabel Keranjang**
- **Fungsi:** Mengelola shopping cart dengan teknologi AJAX
- **Fitur Khusus:** Snapshot harga, kalkulasi subtotal otomatis
- **Integrasi:** Real-time update tanpa reload halaman

**Tabel Orders**
- **Fungsi:** Menyimpan data pesanan dengan tracking status real-time
- **Fitur Khusus:** Nomor order unik, status tracking (pending hingga delivered)
- **Notifikasi:** Sistem alert untuk update status ke customer

**Tabel Detail Order**
- **Fungsi:** Menyimpan item order dengan snapshot harga untuk konsistensi historis
- **Fitur Khusus:** Kalkulasi subtotal per item, tracking perubahan harga
- **Integritas:** Memastikan data order tidak berubah meski harga produk berubah

**Tabel Review**
- **Fungsi:** Mengelola feedback customer dengan sistem rating dan komentar
- **Fitur Khusus:** Rating 1-5 bintang, upload gambar review, verifikasi pembelian
- **Social Proof:** Meningkatkan kepercayaan customer melalui review autentik

**Tabel Diskon**
- **Fungsi:** Mengelola promo dan diskon dengan fleksibilitas tinggi
- **Fitur Khusus:** Tipe diskon persen atau nominal, periode berlaku
- **Integrasi:** Kalkulasi otomatis harga setelah diskon

#### 2.2.3 Arsitektur Sistem

Arsitektur sistem Arunika Interior mengadopsi pendekatan layered architecture yang memisahkan berbagai komponen dengan jelas untuk memudahkan development, testing, dan maintenance. Sistem dirancang dengan scalability dan maintainability sebagai prioritas utama.

**Customer Interface Layer**
- **Responsive Design:** Diimplementasikan untuk memastikan pengalaman optimal di berbagai device
- **User Experience:** Fokus pada kemudahan navigasi dan proses checkout yang smooth
- **Performance:** Optimasi loading time dan caching untuk meningkatkan kecepatan akses

**Admin Panel Layer**
- **Dashboard Management:** Menyediakan overview komprehensif atas seluruh operasi sistem
- **Role-based Access:** Mengontrol akses berdasarkan level administrator
- **Real-time Monitoring:** Menampilkan status order, stok, dan transaksi secara real-time

**Payment API Layer**
- **Gateway Integration:** Terintegrasi dengan Midtrans untuk berbagai metode pembayaran
- **Security Protocol:** Implementasi SSL/TLS dan tokenization untuk keamanan transaksi
- **Webhook Handling:** Sistem notifikasi otomatis untuk update status pembayaran

**Web Server Layer**
- **Request Handling:** Mengelola HTTP request dan response dengan efisien
- **Load Balancing:** Dikonfigurasi untuk distribusi beban yang optimal
- **Security Headers:** Implementasi security headers untuk proteksi dari serangan

**Database Server Layer**
- **Data Management:** Mengelola penyimpanan dan pengambilan data dengan 9 tabel terstruktur
- **Backup System:** Implementasi backup otomatis untuk data protection
- **Performance Tuning:** Optimasi query dan indexing untuk performa optimal

**File Storage Layer**
- **Image Management:** Menyimpan dan mengoptimasi gambar produk dengan struktur yang terorganisir
- **Security:** Validasi file upload dan proteksi dari malicious files
- **CDN Ready:** Struktur yang siap untuk integrasi Content Delivery Network

### 2.3 Struktur Organisasi

#### 2.3.1 Tim Pengembangan

Tim pengembangan Arunika Interior terdiri dari empat anggota yang masing-masing memiliki peran dan tanggung jawab yang jelas. Product Owner memegang peran strategis dalam menentukan arah pengembangan produk, bertanggung jawab atas definisi requirement yang detail, penentuan prioritas fitur berdasarkan kebutuhan bisnis, dan pengelolaan stakeholder untuk memastikan alignment dengan tujuan organisasi. Scrum Master yang juga berperan sebagai Full Stack Developer mengelola proses agile dengan metodologi yang terstruktur, melakukan sprint planning yang efektif, dan mengkoordinasikan tim untuk mencapai target pengembangan yang telah ditentukan. Frontend Developer fokus pada pengembangan antarmuka pengguna yang intuitif, menciptakan desain responsif yang memastikan pengalaman optimal di berbagai perangkat, dan mengoptimalkan user experience melalui penelitian dan testing yang berkelanjutan. Backend Developer bertanggung jawab atas arsitektur database yang robust, pengembangan API yang scalable, dan integrasi payment gateway yang aman dan reliable.

#### 2.3.2 Tanggung Jawab Tim

Setiap anggota tim memiliki tanggung jawab yang saling melengkapi untuk memastikan kesuksesan proyek. Product Owner mengelola definisi requirement yang komprehensif, memastikan setiap fitur memiliki justifikasi bisnis yang jelas, dan mengelola stakeholder untuk mendapatkan feedback dan approval yang diperlukan. Scrum Master mengelola proses agile dengan metodologi yang konsisten, melakukan sprint planning yang realistis, dan mengkoordinasikan komunikasi antar tim untuk menghindari misalignment. Frontend Developer mengimplementasikan UI/UX yang menarik dan fungsional, memastikan desain responsif yang optimal di berbagai device, dan mengoptimalkan user experience melalui testing dan iterasi yang berkelanjutan. Backend Developer merancang database yang efisien dan scalable, mengembangkan API yang robust dan aman, serta mengintegrasikan payment gateway dengan standar keamanan yang tinggi.

---

## 3. PELAKSANAAN AUDIT

### 3.1 Design Factors

Audit terhadap sistem Arunika Interior mempertimbangkan berbagai faktor desain yang mempengaruhi pengelolaan teknologi informasi. Ukuran organisasi yang kecil dengan hanya empat developer menciptakan lingkungan kerja yang informal dengan dokumentasi yang minimal, namun memungkinkan komunikasi yang cepat dan pengambilan keputusan yang fleksibel. Strategi teknologi informasi difokuskan pada mendukung digitalisasi penjualan furnitur, sehingga audit perlu memastikan bahwa sistem e-commerce dan payment gateway berfungsi optimal dan aman. Risiko yang diidentifikasi mencakup kemungkinan transaksi gagal, kurangnya validasi akun pengguna, dan potensi data breach, sehingga audit memberikan prioritas tinggi pada aspek keamanan dan validasi sistem. Regulasi yang berlaku termasuk UU ITE, kebijakan privasi, dan PCI DSS menciptakan compliance requirements yang ketat yang harus dipenuhi oleh sistem. Sumber daya yang tersedia adalah in-house developer dengan skill teknis yang memadai, memungkinkan pengembangan solusi internal yang disesuaikan dengan kebutuhan spesifik. Budaya organisasi yang agile dan kolaboratif mendukung pendekatan pengembangan iteratif yang memungkinkan perbaikan berkelanjutan.

### 3.2 Goals Cascade

**Enterprise Goals (EG) → Alignment Goals (AG) → COBIT BAI Objectives:**

Goals cascade dalam audit ini menunjukkan hubungan hierarkis dari tujuan enterprise hingga implementasi teknis. Enterprise Goal EG08 yang berfokus pada produk unggul diterjemahkan melalui Alignment Goal AG14 untuk solusi yang sesuai kebutuhan, yang kemudian diimplementasikan melalui BAI02 untuk mengelola definisi requirement yang tepat. Enterprise Goal EG06 tentang layanan berkelanjutan diwujudkan melalui Alignment Goal AG07 yang menekankan delivery dan reliability, yang diterjemahkan dalam BAI09 untuk environment testing yang robust. Enterprise Goal EG07 mengenai kepatuhan dan kontrol risiko diimplementasikan melalui Alignment Goal AG09 yang fokus pada keamanan, yang kemudian diwujudkan dalam BAI03 untuk membangun solusi yang aman. Enterprise Goal EG03 tentang pelayanan pelanggan diterjemahkan melalui Alignment Goal AG15 yang menekankan dokumentasi pengguna, yang diimplementasikan dalam BAI05 untuk perubahan organisasional yang mendukung user experience. Enterprise Goal EG12 tentang pengelolaan risiko diwujudkan melalui Alignment Goal AG03 yang fokus pada optimasi risiko, yang kemudian diterjemahkan dalam BAI01 untuk mengelola program dan proyek dengan pendekatan berbasis risiko.

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
- **Level 0:** Incomplete (tidak lengkap)
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

Untuk meningkatkan keamanan sistem, perlu implementasi:

1. **Validasi Email:** Sistem validasi email yang ketat untuk registrasi dan login
2. **CAPTCHA:** Implementasi CAPTCHA untuk mencegah bot dan spam
3. **Sanitasi Input:** Pembersihan input user untuk mencegah serangan XSS
4. **Validasi File Upload:** Pembatasan tipe dan ukuran file untuk upload gambar

#### 3.6.2 Rekomendasi Monitoring (BAI04)

Untuk monitoring sistem yang efektif:

1. **System Health Check:** Monitoring koneksi database, payment gateway, dan disk space
2. **Uptime Monitoring:** Logging status sistem dan response time
3. **Alerting System:** Notifikasi otomatis untuk critical issues
4. **Performance Monitoring:** Monitoring performa database dan aplikasi

#### 3.6.3 Rekomendasi Dokumentasi (BAI02, BAI05)

Untuk dokumentasi yang komprehensif:

1. **Software Requirements Specification (SRS):** Dokumen formal dengan use case dan user story
2. **Functional Requirements:** Detail requirement untuk user management, product management, dan order management
3. **User Documentation:** FAQ, user guide, dan tutorial untuk customer dan admin
4. **Technical Documentation:** Dokumentasi arsitektur dan konfigurasi sistem

---

## 4. KESIMPULAN HASIL AUDIT

### 4.1 Tingkat Kesesuaian Audit

Berdasarkan hasil audit yang komprehensif terhadap 11 proses dalam domain BAI, ditemukan bahwa sebagian besar proses telah berjalan pada level yang cukup baik namun belum mencapai tingkat optimal yang diharapkan. Distribusi capability level menunjukkan bahwa 27% proses berada pada Level 3 (Established), 55% pada Level 2 (Managed), dan 18% pada Level 1 (Performed). Skor rata-rata yang dicapai adalah 2.27 dari 5.0 atau setara dengan 45.4%, yang mengindikasikan bahwa sistem masih memerlukan perbaikan signifikan untuk mencapai standar yang diharapkan.

Analisis capability level mengungkapkan bahwa proses yang berada pada Level 3 (Established) telah terdokumentasi dengan baik dan distandarkan, menunjukkan maturity yang cukup dalam pengelolaan. Proses pada Level 2 (Managed) menunjukkan bahwa proses telah dilakukan namun masih memiliki keterbatasan dalam dokumentasi dan kontrol formal. Sementara itu, proses pada Level 1 (Performed) mengindikasikan bahwa proses dilakukan namun belum memiliki dokumentasi yang memadai atau kebijakan formal yang mengatur pelaksanaannya.

### 4.2 Daftar Hasil Audit

#### 4.2.1 Level 3 (Established) - Sudah Baik

Proses yang berada pada Level 3 menunjukkan maturity yang cukup dalam pengelolaan sistem. BAI01 (Manage Programs and Projects) telah mengimplementasikan metodologi Agile dengan sprint planning yang terstruktur, memungkinkan pengembangan yang iteratif dan responsif terhadap perubahan kebutuhan. BAI03 (Manage Solutions Build) telah menerapkan validasi input dasar dengan prepared statements yang memastikan keamanan dari serangan SQL injection. BAI09 (Test Environment) telah melaksanakan black-box testing untuk fitur utama, memastikan bahwa fungsionalitas sistem berjalan sesuai dengan yang diharapkan.

#### 4.2.2 Level 2 (Managed) - Perlu Perbaikan

Proses pada Level 2 menunjukkan bahwa implementasi telah dilakukan namun masih memerlukan perbaikan dalam dokumentasi dan kontrol formal. BAI02 (Manage Requirements Definition) belum memiliki Software Requirements Specification (SRS) formal dengan use case yang komprehensif, yang dapat menyebabkan misalignment antara kebutuhan bisnis dan implementasi teknis. BAI04 (Manage Availability) belum mengimplementasikan sistem monitoring uptime dan alerting yang memadai, yang dapat menyebabkan downtime tidak terdeteksi secara dini. BAI06 (Manage Changes) belum memiliki dokumentasi versi dan change log yang sistematis, menyulitkan tracking perubahan dan troubleshooting. BAI07 (Change Acceptance) belum mendokumentasikan User Acceptance Testing (UAT) dengan acceptance criteria yang jelas, yang dapat menyebabkan bug tidak terdeteksi sebelum deployment. BAI08 (Manage Knowledge) masih bergantung pada dokumen offline tanpa knowledge base yang terintegrasi, menyulitkan sharing pengetahuan antar tim. BAI10 (Configuration Management) belum mendokumentasikan struktur database dan environment dengan detail yang memadai.

#### 4.2.3 Level 1 (Performed) - Kritis

Proses pada Level 1 mengindikasikan masalah kritis yang memerlukan perhatian segera. BAI05 (Organizational Change) belum menyediakan dokumentasi user guide dan FAQ yang komprehensif, menyebabkan user mengalami kesulitan dalam menggunakan sistem. BAI11 (Requirement Maintenance) belum mengimplementasikan sistem histori update requirement dan changelog, menyulitkan tracking perubahan kebutuhan dan dapat menyebabkan misalignment antara requirement dan implementasi.

### 4.3 Saran Perbaikan Menyeluruh

#### 4.3.1 Peningkatan Dokumentasi (Prioritas Tinggi)

Peningkatan dokumentasi menjadi prioritas utama untuk memastikan keberlanjutan dan pengembangan sistem yang efektif. Penyusunan dokumen kebutuhan sistem (SRS) yang komprehensif dengan use case dan user story yang detail untuk fitur e-commerce akan memastikan alignment yang tepat antara kebutuhan bisnis dan implementasi teknis. Sistem pencatatan histori perubahan backlog dan kebutuhan sistem melalui changelog yang terstruktur dengan versioning akan memudahkan tracking perubahan dan memastikan traceability yang baik. Pembuatan dokumentasi pengguna yang komprehensif dengan FAQ dan user guide untuk customer dan admin akan meningkatkan user experience dan mengurangi beban support.

#### 4.3.2 Penguatan Pengujian & Validasi Sistem (Prioritas Tinggi)

Penguatan sistem pengujian dan validasi menjadi kritis untuk memastikan keandalan sistem e-commerce. Penerapan pengujian otomatis untuk payment gateway dan checkout akan mengurangi risiko kesalahan fungsi yang dapat berdampak pada transaksi finansial. Implementasi validasi form input yang ketat dan keamanan akun pengguna menggunakan metode seperti CAPTCHA dan verifikasi email akan melindungi sistem dari serangan dan abuse. Unit testing untuk critical functions seperti keranjang, checkout, dan payment processing akan memastikan bahwa komponen kritis berfungsi dengan baik sebelum deployment.

#### 4.3.3 Monitoring dan Evaluasi Kinerja Sistem (Prioritas Sedang)

Implementasi sistem monitoring yang komprehensif akan memastikan ketersediaan dan performa sistem e-commerce yang optimal. Tools monitoring untuk uptime dan response time akan memungkinkan deteksi dini masalah yang dapat mempengaruhi user experience. Setup alerting system untuk critical issues seperti payment gateway down atau database error akan memastikan tim dapat merespons masalah dengan cepat. Performance monitoring untuk database dan aplikasi dengan fokus pada checkout process akan memastikan bahwa proses transaksi berjalan dengan lancar dan cepat.

#### 4.3.4 Knowledge Management dan Capacity Building (Prioritas Sedang)

Pengembangan sistem knowledge management yang efektif akan mendukung pertumbuhan tim dan keberlanjutan proyek. Penyediaan sistem basis pengetahuan internal bagi tim pengembang dengan dokumentasi teknis yang komprehensif akan memudahkan onboarding dan knowledge sharing. Pelatihan dan onboarding dokumentatif untuk pengguna admin dan customer akan meningkatkan efektivitas penggunaan sistem. Implementasi version control yang proper untuk source code dan database schema akan memastikan tracking perubahan yang sistematis dan memudahkan rollback jika diperlukan.

#### 4.3.5 Perencanaan Ke Depan (Prioritas Rendah)

Perencanaan jangka panjang akan memastikan keberlanjutan dan pertumbuhan sistem yang berkelanjutan. Penyusunan roadmap audit lanjutan untuk mengevaluasi kembali perbaikan yang telah dilakukan pada sistem e-commerce akan memastikan bahwa investasi perbaikan memberikan hasil yang optimal. Asesmen ulang setiap 6–12 bulan sesuai siklus pengembangan produk dan update teknologi akan memastikan sistem tetap relevan dan mengikuti best practices terbaru. Implementasi continuous improvement process dengan fokus pada user experience dan keamanan akan memastikan sistem terus berkembang sesuai dengan kebutuhan pengguna dan standar industri.

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
**Versi:** 1.0 (Umum) 