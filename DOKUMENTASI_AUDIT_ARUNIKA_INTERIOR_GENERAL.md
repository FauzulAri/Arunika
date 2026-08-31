# DOKUMENTASI AUDIT SISTEM INFORMASI ARUNIKA INTERIOR

**Periode Audit:** Desember 2024  
**Tim Auditor:** Tim Audit IT  
**Versi Dokumen:** 1.0 (General)  

---

## 1. PENDAHULUAN

### 1.1 Latar Belakang

Di tengah meningkatnya kebutuhan masyarakat terhadap produk furnitur dan desain interior yang praktis dan berkualitas, proses pencarian dan pembelian produk secara online masih menyisakan banyak kendala. Kurangnya informasi produk yang detail, keterbatasan fitur perbandingan harga, dan sistem transaksi yang belum sepenuhnya transparan membuat calon pembeli enggan melakukan pembelian secara digital. 

Untuk menjawab tantangan ini, Arunika Interior mengembangkan platform marketplace furnitur berbasis web yang memungkinkan pelanggan untuk melihat katalog produk, melakukan pemesanan, dan memberikan review. Sistem ini telah beroperasi dengan database yang terstruktur dan memiliki panel administrasi untuk pengelolaan produk dan transaksi.

Audit ini dilakukan untuk mengevaluasi sejauh mana pengelolaan dan implementasi teknologi informasi pada proyek Arunika Interior sudah sesuai dengan praktik terbaik dalam pengembangan sistem e-commerce, dengan fokus pada domain Build, Acquire, and Implement (BAI) dari framework COBIT 2019.

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

1. **Menilai kesesuaian proses pengembangan dan implementasi sistem** dengan kerangka kerja COBIT 2019 domain BAI
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
- Aplikasi web e-commerce dengan arsitektur client-server
- Database management system dengan multiple tabel
- Integrasi payment gateway dengan berbagai metode pembayaran
- Panel administrasi untuk manajemen produk, user, dan order
- Sistem keranjang belanja dengan teknologi modern
- Sistem review dan rating produk
- Manajemen diskon dan promo terintegrasi

---

## 2. GAMBARAN UMUM

### 2.1 Proses Bisnis

Arunika Interior menjalankan bisnis sebagai marketplace furnitur digital yang mempertemukan vendor furnitur dengan konsumen melalui platform web yang terintegrasi. Sistem ini dirancang untuk memberikan pengalaman berbelanja yang seamless dari awal hingga akhir transaksi.

**Proses Manajemen Produk** menjadi fondasi utama sistem, dimana administrator memiliki kendali penuh atas katalog produk melalui panel administrasi yang terpusat. Administrator dapat menambahkan, mengedit, dan menghapus data produk dengan mudah. Sistem kategorisasi produk dirancang dengan fleksibilitas tinggi, mencakup berbagai jenis furnitur yang dapat disesuaikan dengan kebutuhan bisnis. Pengelolaan stok dan harga dilakukan secara real-time dengan sistem validasi otomatis yang memastikan data selalu akurat. Untuk meningkatkan daya tarik produk, sistem dilengkapi dengan manajemen diskon dan promo yang terintegrasi, mendukung berbagai jenis diskon. Setiap produk dapat dilengkapi dengan gambar berkualitas tinggi melalui sistem upload yang dilengkapi validasi file dan optimasi gambar otomatis.

**Proses Transaksi Customer** dirancang dengan mempertimbangkan user experience yang optimal. Customer dapat menjelajahi katalog produk dengan berbagai filter kategori dan fitur pencarian yang responsif. Sistem keranjang belanja menggunakan teknologi modern yang memungkinkan customer menambahkan produk ke keranjang tanpa perlu reload halaman, memberikan pengalaman yang smooth dan cepat. Customer juga dapat mengupdate keranjang dengan mudah, mengubah jumlah item atau menghapus produk yang tidak diinginkan. Proses checkout dirancang dengan validasi stok otomatis dan kalkulasi total yang akurat, memastikan customer tidak dapat memesan produk yang tidak tersedia. Sistem pembayaran mendukung berbagai metode yang umum digunakan, termasuk transfer bank, COD (Cash on Delivery), dan e-wallet. Setelah pembayaran, customer dapat melacak status order mereka secara real-time, dari status pending hingga delivered. Untuk meningkatkan kepercayaan antar customer, sistem dilengkapi dengan fitur review dan rating produk yang memungkinkan customer memberikan feedback setelah pembelian.

**Proses Manajemen Order** memberikan administrator kontrol penuh atas seluruh transaksi. Administrator dapat mengkonfirmasi order melalui panel administrasi yang terpusat, memastikan setiap transaksi valid sebelum diproses. Sistem update status pengiriman dilengkapi dengan notifikasi otomatis ke customer, sehingga customer selalu mendapat informasi terkini tentang pesanan mereka. Feedback pelanggan dikelola melalui sistem review dan rating yang terintegrasi, memberikan insights berharga untuk perbaikan produk dan layanan. Administrator juga memiliki kemampuan untuk mengelola data user, termasuk menambah, mengedit, dan menghapus data customer sesuai kebutuhan. Untuk mendukung keputusan bisnis, sistem dilengkapi dengan laporan penjualan dan analisis data transaksi yang komprehensif.

### 2.2 Arsitektur Teknologi Informasi

Arsitektur teknologi informasi Arunika Interior dirancang dengan pendekatan modern yang mengutamakan performa, keamanan, dan skalabilitas. Sistem ini mengadopsi arsitektur client-server yang modular, memungkinkan pengembangan yang fleksibel dan maintenance yang mudah. Stack teknologi yang dipilih mempertimbangkan kebutuhan bisnis e-commerce yang memerlukan kecepatan, keamanan transaksi, dan user experience yang optimal. Integrasi berbagai komponen teknologi dilakukan dengan memastikan kompatibilitas dan efisiensi dalam pengelolaan data dan proses bisnis.

#### 2.2.1 Stack Teknologi

**Frontend Development**
- **Web Technologies:** Digunakan sebagai fondasi untuk struktur dan styling website, memastikan kompatibilitas dengan berbagai browser dan perangkat
- **Responsive Framework:** Diimplementasikan untuk desain responsif yang memastikan tampilan optimal di desktop, tablet, dan mobile device
- **Client-side Scripting:** Digunakan untuk interaktivitas dan dynamic content, termasuk operasi keranjang belanja tanpa reload halaman
- **UI/UX Libraries:** Diintegrasikan untuk carousel dan slider yang menampilkan produk dengan animasi yang menarik

**Backend Development**
- **Server-side Programming:** Dipilih sebagai bahasa pemrograman server-side yang powerful dan fleksibel untuk pengembangan aplikasi web
- **Architecture Pattern:** Diimplementasikan untuk memisahkan logika bisnis, presentasi, dan kontrol
- **Session Management:** Dikelola untuk autentikasi user dan admin dengan keamanan yang memadai

**Database Management**
- **Relational Database System:** Dipilih sebagai sistem manajemen database yang robust dan scalable
- **Data Structure:** Dirancang dengan normalisasi yang optimal untuk menghindari redundancy dan memastikan integritas data
- **Performance Optimization:** Diimplementasikan untuk mempercepat query dan meningkatkan performa database

**Payment Integration**
- **Payment Gateway:** Diintegrasikan untuk memproses berbagai metode pembayaran seperti transfer bank, COD, dan e-wallet
- **Notification System:** Diimplementasikan untuk handling notifikasi pembayaran secara real-time
- **Security Protocol:** Diterapkan untuk memastikan keamanan transaksi finansial sesuai standar industri

**Development Tools**
- **Dependency Management:** Digunakan untuk dependency management yang memudahkan pengelolaan library dan framework
- **Version Control:** Diimplementasikan untuk tracking perubahan source code dan collaboration tim
- **Development Environment:** Dikonfigurasi untuk development yang konsisten antar developer

**Server Infrastructure**
- **Web Server:** Dikonfigurasi untuk menangani HTTP request dan response dengan efisien
- **Application Server:** Dioptimalkan untuk performa dan keamanan dalam menjalankan aplikasi
- **File Storage System:** Diimplementasikan untuk menyimpan gambar produk dan dokumen dengan struktur yang terorganisir

#### 2.2.2 Struktur Database

Sistem database Arunika Interior dirancang dengan pendekatan yang komprehensif untuk mendukung seluruh operasi bisnis e-commerce. Arsitektur database mengadopsi relational database model dengan multiple tabel utama yang saling terhubung melalui foreign key relationships, memastikan data consistency dan referential integrity.

**User Management Tables**
- **Fungsi:** Menyimpan data customer dengan informasi lengkap termasuk profil dan preferensi
- **Fitur Khusus:** Foto profil, status online/offline, dan tracking aktivitas terakhir
- **Keamanan:** Password di-hash dan data sensitif dilindungi

**Administration Tables**
- **Fungsi:** Mengelola data administrator dengan role-based access control
- **Fitur Khusus:** Role hierarchy, tracking login terakhir
- **Keamanan:** Session management dan audit trail untuk aktivitas admin

**Product Management Tables**
- **Fungsi:** Mengelompokkan produk berdasarkan jenis dan kategori
- **Fitur Khusus:** Icon untuk visual representation, deskripsi kategori
- **Fleksibilitas:** Status aktif/nonaktif untuk manajemen kategori

**Inventory Tables**
- **Fungsi:** Menyimpan katalog produk dengan detail spesifikasi lengkap
- **Fitur Khusus:** Dimensi, material, berat, stok real-time, gambar produk
- **Optimasi:** Index untuk pencarian dan filtering yang cepat

**Shopping Cart Tables**
- **Fungsi:** Mengelola shopping cart dengan teknologi modern
- **Fitur Khusus:** Snapshot harga, kalkulasi subtotal otomatis
- **Integrasi:** Real-time update tanpa reload halaman

**Order Management Tables**
- **Fungsi:** Menyimpan data pesanan dengan tracking status real-time
- **Fitur Khusus:** Nomor order unik, status tracking (pending hingga delivered)
- **Notifikasi:** Sistem alert untuk update status ke customer

**Order Detail Tables**
- **Fungsi:** Menyimpan item order dengan snapshot harga untuk konsistensi historis
- **Fitur Khusus:** Kalkulasi subtotal per item, tracking perubahan harga
- **Integritas:** Memastikan data order tidak berubah meski harga produk berubah

**Review Tables**
- **Fungsi:** Mengelola feedback customer dengan sistem rating dan komentar
- **Fitur Khusus:** Rating sistem, upload gambar review, verifikasi pembelian
- **Social Proof:** Meningkatkan kepercayaan customer melalui review autentik

**Promotion Tables**
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
- **Gateway Integration:** Terintegrasi dengan payment gateway untuk berbagai metode pembayaran
- **Security Protocol:** Implementasi SSL/TLS dan tokenization untuk keamanan transaksi
- **Webhook Handling:** Sistem notifikasi otomatis untuk update status pembayaran

**Web Server Layer**
- **Request Handling:** Mengelola HTTP request dan response dengan efisien
- **Load Balancing:** Dikonfigurasi untuk distribusi beban yang optimal
- **Security Headers:** Implementasi security headers untuk proteksi dari serangan

**Database Server Layer**
- **Data Management:** Mengelola penyimpanan dan pengambilan data dengan struktur terorganisir
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

### 2.4 Penilaian Kematangan Proses

Berdasarkan evaluasi terhadap domain BAI (Build, Acquire, and Implement) menggunakan framework COBIT 2019, berikut adalah ringkasan tingkat kematangan proses:

| Domain BAI | Proses | Level Saat Ini | Target Level | Gap | Status |
|------------|--------|----------------|--------------|-----|--------|
| **BAI01** | Manage Programs and Projects | 3 (Established) | 4 (Predictable) | 1 | Perlu Peningkatan |
| **BAI02** | Manage Requirements Definition | 2 (Managed) | 3 (Established) | 1 | Kritis |
| **BAI03** | Manage Solutions Build | 3 (Established) | 4 (Predictable) | 1 | Perlu Peningkatan |
| **BAI04** | Manage Availability | 2 (Managed) | 3 (Established) | 1 | Sedang |
| **BAI05** | Organizational Change | 1 (Performed) | 3 (Established) | 2 | Kritis |
| **BAI06** | Manage Changes | 2 (Managed) | 3 (Established) | 1 | Sedang |
| **BAI07** | Change Acceptance | 2 (Managed) | 3 (Established) | 1 | Sedang |
| **BAI08** | Manage Knowledge | 2 (Managed) | 3 (Established) | 1 | Rendah |
| **BAI09** | Test Environment | 3 (Established) | 4 (Predictable) | 1 | Perlu Peningkatan |
| **BAI10** | Configuration Management | 2 (Managed) | 3 (Established) | 1 | Sedang |
| **BAI11** | Requirement Maintenance | 1 (Performed) | 3 (Established) | 2 | Kritis |

**Rata-rata Capability Level:** 2.27/5.0 (45.4%)

**Distribusi Level:**
- Level 3 (Established): 27% (3 proses)
- Level 2 (Managed): 55% (6 proses)  
- Level 1 (Performed): 18% (2 proses)
- Level 0 (Incomplete): 0% (0 proses)

---

## 3. PELAKSANAAN AUDIT

### 3.0 Kerangka Audit dan Pendekatan COBIT 2019

Audit ini mengikuti metodologi COBIT 2019 dengan pendekatan sistematis yang terdiri dari lima tahapan utama:

#### 3.0.1 Penentuan Domain
Domain BAI (Build, Acquire, and Implement) dipilih karena relevansi dengan pengembangan sistem e-commerce Arunika Interior yang memerlukan pengelolaan program, requirement, dan implementasi solusi yang terstruktur.

#### 3.0.2 Pemilihan Enterprise Goals (EG) dan Alignment Goals (AG)
- **EG03:** Customer-oriented service culture
- **EG06:** Business service continuity and availability  
- **EG07:** Compliance with external laws and regulations
- **EG08:** Competitive products and services
- **EG12:** Managed business risk

#### 3.0.3 Evaluasi Kapabilitas
Penilaian capability level menggunakan Process Capability Model COBIT 2019 dengan 7 atribut performa:
1. **Performance Management:** Sejauh mana proses mencapai tujuan yang ditetapkan
2. **Resource Management:** Efektivitas penggunaan sumber daya
3. **Process Management:** Konsistensi dan repeatability proses
4. **Change Management:** Kemampuan beradaptasi dengan perubahan
5. **Quality Management:** Kualitas output dan kepuasan stakeholder
6. **Risk Management:** Identifikasi dan mitigasi risiko
7. **Compliance Management:** Kepatuhan terhadap regulasi dan standar

#### 3.0.4 Penentuan Gap
Analisis kesenjangan antara capability level saat ini dengan target level yang diharapkan untuk setiap proses BAI01-BAI11.

#### 3.0.5 Penyusunan Rekomendasi
Formulasi rekomendasi perbaikan berdasarkan gap analysis dengan prioritas berdasarkan tingkat risiko dan dampak bisnis.

### 3.1 Design Factors

Audit terhadap sistem Arunika Interior mempertimbangkan berbagai faktor desain yang mempengaruhi pengelolaan teknologi informasi sesuai dengan COBIT 2019 Design Guide:

#### 3.1.1 Ukuran Organisasi
- **Kondisi:** Tim kecil dengan 4 developer
- **Dampak:** Lingkungan kerja informal, komunikasi cepat, dokumentasi minimal
- **Implikasi Audit:** Fokus pada proses yang dapat dioptimalkan dengan sumber daya terbatas

#### 3.1.2 Strategi Teknologi Informasi
- **Fokus:** Digitalisasi penjualan furnitur melalui e-commerce
- **Prioritas:** Sistem e-commerce dan payment gateway yang optimal dan aman
- **Implikasi Audit:** Evaluasi keamanan transaksi dan user experience

#### 3.1.3 Budaya Organisasi
- **Karakteristik:** Agile dan kolaboratif
- **Pendekatan:** Pengembangan iteratif dengan perbaikan berkelanjutan
- **Implikasi Audit:** Penilaian maturity proses agile dan dokumentasi

#### 3.1.4 Toleransi Risiko
- **Identifikasi Risiko:** Transaksi gagal, validasi akun lemah, data breach
- **Prioritas:** Keamanan sistem dan validasi input
- **Implikasi Audit:** Fokus pada aspek keamanan dan compliance

#### 3.1.5 Sumber Daya
- **Ketersediaan:** In-house developer dengan skill teknis memadai
- **Kemampuan:** Pengembangan solusi internal yang disesuaikan
- **Implikasi Audit:** Evaluasi efektivitas penggunaan sumber daya

#### 3.1.6 Regulasi dan Compliance
- **Framework:** UU ITE, PCI DSS, ISO/IEC 27001
- **Requirements:** Compliance requirements yang ketat
- **Implikasi Audit:** Penilaian kepatuhan terhadap regulasi yang berlaku

### 3.2 Goals Cascade

**Enterprise Goals (EG) → Alignment Goals (AG) → COBIT BAI Objectives:**

| Enterprise Goal | Alignment Goal | BAI Process | Justifikasi |
|----------------|----------------|-------------|-------------|
| **EG03:** Customer-oriented service culture | **AG15:** User documentation and training | **BAI05:** Organizational Change | Perubahan organisasional untuk mendukung user experience yang optimal |
| **EG06:** Business service continuity and availability | **AG07:** Delivery and support | **BAI04:** Manage Availability | Memastikan ketersediaan sistem e-commerce secara berkelanjutan |
| **EG07:** Compliance with external laws and regulations | **AG09:** Security and privacy | **BAI03:** Manage Solutions Build | Membangun solusi yang aman dan compliant |
| **EG08:** Competitive products and services | **AG14:** Solution delivery | **BAI02:** Manage Requirements Definition | Definisi requirement yang tepat untuk produk unggul |
| **EG12:** Managed business risk | **AG03:** Risk optimization | **BAI01:** Manage Programs and Projects | Pengelolaan program dengan pendekatan berbasis risiko |

**Penjelasan Hubungan:**
- **EG03 → AG15 → BAI05:** Pelayanan pelanggan memerlukan dokumentasi pengguna yang baik, diimplementasikan melalui perubahan organisasional
- **EG06 → AG07 → BAI04:** Layanan berkelanjutan memerlukan delivery yang reliable, diimplementasikan melalui manajemen ketersediaan
- **EG07 → AG09 → BAI03:** Kepatuhan regulasi memerlukan keamanan dan privasi, diimplementasikan melalui pembangunan solusi yang aman
- **EG08 → AG14 → BAI02:** Produk unggul memerlukan solusi yang tepat, diimplementasikan melalui definisi requirement yang akurat
- **EG12 → AG03 → BAI01:** Pengelolaan risiko memerlukan optimasi risiko, diimplementasikan melalui manajemen program yang terstruktur

### 3.3 Capability Level BAI01 – BAI11

| Kode | Nama Proses | Level Saat Ini | Target Level | Justifikasi Berdasarkan 7 Atribut Performa |
|------|-------------|----------------|--------------|---------------------------------------------|
| **BAI01** | Manage Programs and Projects | 3 | 4 | **Performance:** Agile diterapkan dengan sprint planning<br>**Resource:** Tim 4 developer terkelola baik<br>**Process:** Metodologi terstruktur namun belum terdokumentasi<br>**Change:** Adaptif terhadap perubahan requirement<br>**Quality:** Output sesuai ekspektasi stakeholder<br>**Risk:** Identifikasi risiko dasar<br>**Compliance:** Mengikuti standar agile |
| **BAI02** | Manage Requirements Definition | 2 | 3 | **Performance:** Requirement dikumpulkan secara informal<br>**Resource:** Product Owner mengelola requirement<br>**Process:** Proses ada namun tidak terdokumentasi formal<br>**Change:** Responsif terhadap perubahan kebutuhan<br>**Quality:** Tidak ada SRS formal<br>**Risk:** Risiko misalignment requirement<br>**Compliance:** Belum ada standar requirement management |
| **BAI03** | Manage Solutions Build | 3 | 4 | **Performance:** Solusi berfungsi sesuai kebutuhan<br>**Resource:** Developer skill memadai<br>**Process:** Validasi input dasar diterapkan<br>**Change:** Adaptif terhadap perubahan teknologi<br>**Quality:** Kualitas kode cukup baik<br>**Risk:** Security measures dasar<br>**Compliance:** Mengikuti best practices development |
| **BAI04** | Manage Availability | 2 | 3 | **Performance:** Sistem berjalan dengan uptime cukup<br>**Resource:** Server infrastructure tersedia<br>**Process:** Tidak ada monitoring formal<br>**Change:** Responsif terhadap downtime<br>**Quality:** Ketersediaan sistem memadai<br>**Risk:** Tidak ada alerting system<br>**Compliance:** Belum ada SLA formal |
| **BAI05** | Organizational Change | 1 | 3 | **Performance:** Perubahan dilakukan secara ad-hoc<br>**Resource:** Tim kecil memudahkan perubahan<br>**Process:** Tidak ada dokumentasi user guide<br>**Change:** Perubahan tidak terstruktur<br>**Quality:** User experience belum optimal<br>**Risk:** Risiko user confusion tinggi<br>**Compliance:** Tidak ada training formal |
| **BAI06** | Manage Changes | 2 | 3 | **Performance:** Perubahan diterapkan dengan cepat<br>**Resource:** Version control digunakan<br>**Process:** Tidak ada change log formal<br>**Change:** Perubahan tidak terdokumentasi<br>**Quality:** Kualitas perubahan memadai<br>**Risk:** Risiko rollback tidak terkelola<br>**Compliance:** Tidak ada change management process |
| **BAI07** | Change Acceptance | 2 | 3 | **Performance:** Testing dilakukan secara manual<br>**Resource:** Testing dilakukan oleh developer<br>**Process:** UAT tidak terdokumentasi<br>**Change:** Responsif terhadap bug report<br>**Quality:** Bug detection manual<br>**Risk:** Risiko bug tidak terdeteksi<br>**Compliance:** Tidak ada acceptance criteria formal |
| **BAI08** | Manage Knowledge | 2 | 3 | **Performance:** Knowledge sharing informal<br>**Resource:** Dokumen tersimpan offline<br>**Process:** Tidak ada knowledge base<br>**Change:** Knowledge tidak terstruktur<br>**Quality:** Dokumentasi terbatas<br>**Risk:** Knowledge loss risk tinggi<br>**Compliance:** Tidak ada knowledge management system |
| **BAI09** | Test Environment | 3 | 4 | **Performance:** Black-box testing dilakukan<br>**Resource:** Testing environment tersedia<br>**Process:** Testing process terstruktur<br>**Change:** Adaptif terhadap perubahan fitur<br>**Quality:** Testing coverage memadai<br>**Risk:** Tidak ada automated testing<br>**Compliance:** Mengikuti testing best practices |
| **BAI10** | Configuration Management | 2 | 3 | **Performance:** Konfigurasi berjalan dengan baik<br>**Resource:** Environment tersedia<br>**Process:** Struktur tidak terdokumentasi<br>**Change:** Konfigurasi dapat diubah<br>**Quality:** Konfigurasi memadai<br>**Risk:** Tidak ada backup konfigurasi<br>**Compliance:** Tidak ada configuration management process |
| **BAI11** | Requirement Maintenance | 1 | 3 | **Performance:** Requirement diupdate secara informal<br>**Resource:** Product Owner mengelola perubahan<br>**Process:** Tidak ada histori update<br>**Change:** Perubahan tidak terdokumentasi<br>**Quality:** Traceability requirement lemah<br>**Risk:** Risiko requirement drift tinggi<br>**Compliance:** Tidak ada requirement maintenance process |

**Keterangan Level berdasarkan COBIT 2019:**
- **Level 0 (Incomplete):** Proses tidak ada atau tidak lengkap
- **Level 1 (Performed):** Proses dilakukan namun tidak terdokumentasi
- **Level 2 (Managed):** Proses dilakukan dengan dokumentasi terbatas
- **Level 3 (Established):** Proses terdokumentasi dan distandarkan
- **Level 4 (Predictable):** Proses terukur dan dapat diprediksi
- **Level 5 (Optimizing):** Proses terus diperbaiki dan dioptimalkan

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

### 3.5 Matriks Risiko

| Risiko | Dampak | Probabilitas | Tingkat Risiko | Tindakan Mitigasi |
|--------|--------|--------------|----------------|-------------------|
| **Sistem tidak sesuai ekspektasi user** | Tinggi | Sedang | Tinggi | Implementasi SRS formal dengan user story |
| **Sistem tidak aman, validasi lemah** | Sangat Tinggi | Tinggi | Sangat Tinggi | Implementasi OWASP guidelines dan security testing |
| **User kesulitan menggunakan sistem** | Sedang | Tinggi | Tinggi | Pengembangan user documentation dan training |
| **Downtime tidak terdeteksi** | Tinggi | Sedang | Tinggi | Implementasi monitoring dan alerting system |
| **Perubahan tidak terkontrol** | Sedang | Tinggi | Tinggi | Implementasi version control dan change management |
| **Bug tidak terdeteksi** | Sedang | Sedang | Sedang | Dokumentasi UAT process dan acceptance criteria |
| **Knowledge tidak tersimpan** | Rendah | Tinggi | Sedang | Implementasi knowledge management system |
| **Konfigurasi tidak terdokumentasi** | Sedang | Tinggi | Tinggi | Dokumentasi environment configuration |
| **Testing tidak komprehensif** | Sedang | Sedang | Sedang | Implementasi automated testing framework |
| **Tidak diketahui perubahan kebutuhan** | Tinggi | Tinggi | Sangat Tinggi | Implementasi requirement maintenance process |

**Keterangan Tingkat Risiko:**
- **Sangat Tinggi:** Dampak tinggi + probabilitas tinggi
- **Tinggi:** Dampak tinggi + probabilitas sedang, atau dampak sedang + probabilitas tinggi
- **Sedang:** Dampak sedang + probabilitas sedang, atau kombinasi lainnya
- **Rendah:** Dampak rendah + probabilitas rendah

### 3.5 Temuan & Rekomendasi

#### 3.5.1 Temuan Kritis (High Priority)

| Proses | Risiko | Rekomendasi | Timeline |
|--------|--------|-------------|----------|
| **BAI02** | Sistem tidak sesuai ekspektasi user | Implementasi formal requirements management process dengan dokumentasi SRS yang komprehensif | 2 minggu |
| **BAI03** | Sistem tidak aman, validasi lemah | Implementasi input validation sesuai OWASP guidelines dan security best practices | 1 bulan |
| **BAI05** | User kesulitan menggunakan sistem | Pengembangan user documentation dan training materials yang komprehensif | 1 bulan |
| **BAI11** | Tidak diketahui perubahan kebutuhan | Implementasi change management process dengan versioning dan changelog | 2 minggu |

#### 3.5.2 Temuan Sedang (Medium Priority)

| Proses | Risiko | Rekomendasi | Timeline |
|--------|--------|-------------|----------|
| **BAI01** | Proyek tidak terstruktur | Dokumentasi project management process dan agile methodology | 1 bulan |
| **BAI04** | Downtime tidak terdeteksi | Implementasi monitoring dan alerting system untuk availability management | 2 minggu |
| **BAI06** | Perubahan tidak terkontrol | Implementasi version control dan change management process | 1 bulan |
| **BAI07** | Bug tidak terdeteksi | Dokumentasi UAT process dan acceptance criteria | 2 minggu |
| **BAI09** | Testing tidak komprehensif | Implementasi automated testing dan unit testing framework | 2 bulan |
| **BAI10** | Konfigurasi tidak terdokumentasi | Dokumentasi environment configuration dan deployment process | 1 bulan |

#### 3.5.3 Temuan Rendah (Low Priority)

| Proses | Risiko | Rekomendasi | Timeline |
|--------|--------|-------------|----------|
| **BAI08** | Knowledge tidak tersimpan | Implementasi knowledge management system dan online documentation | 3 bulan |

### 3.6 Rekomendasi Implementasi

#### 3.6.1 Rekomendasi Keamanan (BAI03)

Untuk meningkatkan keamanan sistem, perlu implementasi:

1. **Input Validation:** Implementasi validasi input yang komprehensif sesuai OWASP guidelines
2. **Authentication & Authorization:** Penguatan sistem autentikasi dan otorisasi
3. **Data Protection:** Implementasi enkripsi untuk data sensitif
4. **Security Testing:** Regular security testing dan vulnerability assessment

#### 3.6.2 Rekomendasi Monitoring (BAI04)

Untuk monitoring sistem yang efektif:

1. **System Health Monitoring:** Implementasi monitoring untuk availability dan performance
2. **Alerting System:** Setup alerting untuk critical issues dan downtime
3. **Performance Monitoring:** Monitoring response time dan resource utilization
4. **Log Management:** Centralized logging dan log analysis

#### 3.6.3 Rekomendasi Dokumentasi (BAI02, BAI05)

Untuk dokumentasi yang komprehensif:

1. **Software Requirements Specification (SRS):** Dokumen formal dengan use case dan user story
2. **User Documentation:** User guide, FAQ, dan training materials
3. **Technical Documentation:** Dokumentasi arsitektur dan konfigurasi sistem
4. **Process Documentation:** Standard Operating Procedures (SOP) untuk semua proses

### 3.7 Ringkasan Rekomendasi per Domain

| Domain | Rekomendasi | Tindakan Prioritas | Bukti Implementasi |
|--------|-------------|-------------------|-------------------|
| **BAI01** | Dokumentasi project management process | Sedang | Project charter, sprint planning docs |
| **BAI02** | Buat dokumen SRS formal | Tinggi | SRS, use case, validasi user |
| **BAI03** | Validasi input & enkripsi data | Tinggi | Log validasi, sertifikat SSL |
| **BAI04** | Implementasi monitoring uptime | Sedang | Monitoring dashboard, alert system |
| **BAI05** | Pengembangan user documentation | Tinggi | User guide, FAQ, training materials |
| **BAI06** | Implementasi version control | Sedang | Git repository, change log |
| **BAI07** | Dokumentasi UAT process | Sedang | UAT checklist, acceptance criteria |
| **BAI08** | Implementasi knowledge management | Rendah | Knowledge base, online docs |
| **BAI09** | Implementasi automated testing | Sedang | Unit tests, integration tests |
| **BAI10** | Dokumentasi konfigurasi | Sedang | Configuration docs, deployment guide |
| **BAI11** | Implementasi requirement tracking | Tinggi | Requirement traceability matrix |

### 3.8 Tools & Framework yang Digunakan

#### 3.8.1 Security Testing
- **OWASP ZAP:** Untuk vulnerability assessment dan security testing
- **Burp Suite:** Untuk penetration testing dan security analysis
- **Nessus:** Untuk vulnerability scanning

#### 3.8.2 Performance Testing
- **Google PageSpeed Insights:** Untuk analisis performa website
- **GTmetrix:** Untuk performance monitoring
- **Apache JMeter:** Untuk load testing

#### 3.8.3 Version Control
- **Git:** Untuk source code version control
- **GitHub/GitLab:** Untuk repository management dan collaboration

#### 3.8.4 Monitoring
- **Uptime Robot:** Untuk uptime monitoring
- **New Relic:** Untuk application performance monitoring
- **Sentry:** Untuk error tracking dan monitoring

#### 3.8.5 Documentation
- **Confluence:** Untuk knowledge management
- **Notion:** Untuk documentation collaboration
- **Swagger:** Untuk API documentation

### 3.9 Evaluasi Dampak

Jika rekomendasi tidak diimplementasikan, diperkirakan dampak sebagai berikut:

#### 3.9.1 Dampak Jangka Pendek (1-3 bulan)
- **Kehilangan pelanggan:** 15-25% akibat user experience yang buruk
- **Peningkatan support ticket:** 40-60% akibat kurangnya dokumentasi
- **Downtime tidak terdeteksi:** Potensi kerugian Rp 5-10 juta per incident

#### 3.9.2 Dampak Jangka Menengah (3-6 bulan)
- **Security breach:** Risiko tinggi dengan potensi kerugian Rp 50-100 juta
- **Non-compliance:** Denda regulasi sebesar Rp 25-50 juta
- **Technical debt:** Peningkatan 30-50% dalam maintenance cost

#### 3.9.3 Dampak Jangka Panjang (6-12 bulan)
- **Market share loss:** Penurunan 20-30% akibat kompetitor yang lebih baik
- **Talent retention:** Kesulitan mempertahankan developer berkualitas
- **Scalability issues:** Ketidakmampuan menangani pertumbuhan bisnis

---

## 4. KESIMPULAN HASIL AUDIT

### 4.1 Tingkat Kesesuaian Audit

Berdasarkan hasil audit yang komprehensif terhadap 11 proses dalam domain BAI, ditemukan bahwa sebagian besar proses telah berjalan pada level yang cukup baik namun belum mencapai tingkat optimal yang diharapkan. Distribusi capability level menunjukkan bahwa 27% proses berada pada Level 3 (Established), 55% pada Level 2 (Managed), dan 18% pada Level 1 (Performed). Skor rata-rata yang dicapai adalah 2.27 dari 5.0 atau setara dengan 45.4%, yang mengindikasikan bahwa sistem masih memerlukan perbaikan signifikan untuk mencapai standar yang diharapkan.

Analisis capability level mengungkapkan bahwa proses yang berada pada Level 3 (Established) telah terdokumentasi dengan baik dan distandarkan, menunjukkan maturity yang cukup dalam pengelolaan. Proses pada Level 2 (Managed) menunjukkan bahwa proses telah dilakukan namun masih memiliki keterbatasan dalam dokumentasi dan kontrol formal. Sementara itu, proses pada Level 1 (Performed) mengindikasikan bahwa proses dilakukan namun belum memiliki dokumentasi yang memadai atau kebijakan formal yang mengatur pelaksanaannya.

### 4.2 Daftar Hasil Audit

#### 4.2.1 Level 3 (Established) - Sudah Baik

Proses yang berada pada Level 3 menunjukkan maturity yang cukup dalam pengelolaan sistem. BAI01 (Manage Programs and Projects) telah mengimplementasikan metodologi Agile dengan sprint planning yang terstruktur, memungkinkan pengembangan yang iteratif dan responsif terhadap perubahan kebutuhan. BAI03 (Manage Solutions Build) telah menerapkan validasi input dasar dengan security measures yang memastikan keamanan dari serangan umum. BAI09 (Test Environment) telah melaksanakan black-box testing untuk fitur utama, memastikan bahwa fungsionalitas sistem berjalan sesuai dengan yang diharapkan.

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

| Fase | Periode | Fokus | Target Capability Level | Deadline |
|------|---------|-------|------------------------|----------|
| **Fase 1** | Bulan 1-2 | Keamanan & Dokumentasi | BAI02, BAI03, BAI05, BAI11 → Level 3 | 28 Februari 2025 |
| **Fase 2** | Bulan 3-4 | Monitoring & Testing | BAI04, BAI09 → Level 4 | 30 April 2025 |
| **Fase 3** | Bulan 5-6 | Process Improvement | BAI01, BAI06, BAI07, BAI10 → Level 3 | 30 Juni 2025 |
| **Fase 4** | Bulan 7-8 | Knowledge Management | BAI08 → Level 3 | 31 Agustus 2025 |

**Target Akhir:** Rata-rata capability level 3.5 (70%) dalam 8 bulan dengan fokus pada keamanan e-commerce dan user experience

#### 4.4.1 Detail Implementasi per Fase

**Fase 1: Keamanan & Dokumentasi (Bulan 1-2)**
- **BAI02:** Penyusunan SRS formal dengan use case dan user story
- **BAI03:** Implementasi OWASP guidelines dan security testing
- **BAI05:** Pengembangan user documentation dan training materials
- **BAI11:** Implementasi requirement tracking dan changelog

**Fase 2: Monitoring & Testing (Bulan 3-4)**
- **BAI04:** Implementasi monitoring system dan alerting
- **BAI09:** Implementasi automated testing framework

**Fase 3: Process Improvement (Bulan 5-6)**
- **BAI01:** Dokumentasi project management process
- **BAI06:** Implementasi version control dan change management
- **BAI07:** Dokumentasi UAT process dan acceptance criteria
- **BAI10:** Dokumentasi environment configuration

**Fase 4: Knowledge Management (Bulan 7-8)**
- **BAI08:** Implementasi knowledge management system

Dengan penerapan saran tersebut, diharapkan seluruh proses pada domain BAI dapat ditingkatkan hingga minimal Level 3 (Established) dan menjamin bahwa sistem Arunika Interior berjalan secara optimal, aman, serta mendukung kebutuhan pengguna secara berkelanjutan dengan fokus pada keamanan transaksi e-commerce dan user experience yang optimal.

---

## 5. LAMPIRAN

### 5.1 Checklist Audit

#### 5.1.1 BAI01 - Manage Programs and Projects
- [ ] Project charter tersedia dan terdokumentasi
- [ ] Sprint planning dilakukan secara teratur
- [ ] Agile methodology diterapkan dengan konsisten
- [ ] Project timeline dan milestone terdefinisi
- [ ] Risk management plan tersedia

#### 5.1.2 BAI02 - Manage Requirements Definition
- [ ] Software Requirements Specification (SRS) tersedia
- [ ] Use case dan user story terdokumentasi
- [ ] Requirement validation process ada
- [ ] Stakeholder approval untuk requirement
- [ ] Requirement traceability matrix tersedia

#### 5.1.3 BAI03 - Manage Solutions Build
- [ ] Input validation sesuai OWASP guidelines
- [ ] Security testing dilakukan secara regular
- [ ] Code review process diterapkan
- [ ] SSL/TLS certificate terpasang
- [ ] Data encryption untuk informasi sensitif

#### 5.1.4 BAI04 - Manage Availability
- [ ] Uptime monitoring system terpasang
- [ ] Alerting system untuk downtime
- [ ] Backup dan recovery plan tersedia
- [ ] SLA (Service Level Agreement) terdefinisi
- [ ] Performance monitoring tools terpasang

#### 5.1.5 BAI05 - Organizational Change
- [ ] User documentation tersedia
- [ ] Training materials untuk user
- [ ] FAQ dan help desk tersedia
- [ ] Change communication plan ada
- [ ] User acceptance testing dilakukan

### 5.2 Form Capability Scoring

#### 5.2.1 Performance Management
| Kriteria | Score (1-5) | Bukti |
|----------|-------------|-------|
| Proses mencapai tujuan yang ditetapkan | | |
| KPI dan metrics terukur | | |
| Performance monitoring dilakukan | | |

#### 5.2.2 Resource Management
| Kriteria | Score (1-5) | Bukti |
|----------|-------------|-------|
| Efektivitas penggunaan sumber daya | | |
| Resource allocation optimal | | |
| Budget dan timeline terkelola | | |

#### 5.2.3 Process Management
| Kriteria | Score (1-5) | Bukti |
|----------|-------------|-------|
| Konsistensi dan repeatability proses | | |
| Standard Operating Procedures ada | | |
| Process documentation lengkap | | |

### 5.3 Contoh SRS (Software Requirements Specification)

#### 5.3.1 Functional Requirements
**FR-001: User Registration**
- **Description:** User dapat mendaftar akun baru
- **Input:** Email, password, nama lengkap, nomor telepon
- **Process:** Validasi input, hash password, simpan ke database
- **Output:** Akun user terdaftar dan dapat login

**FR-002: Product Search**
- **Description:** User dapat mencari produk berdasarkan kategori dan keyword
- **Input:** Keyword pencarian, filter kategori
- **Process:** Query database, filter hasil
- **Output:** Daftar produk yang sesuai kriteria

#### 5.3.2 Non-Functional Requirements
**NFR-001: Performance**
- Response time < 3 detik untuk 95% request
- System dapat menangani 100 concurrent users

**NFR-002: Security**
- Password di-hash menggunakan bcrypt
- Session timeout setelah 30 menit inaktif
- Input validation untuk mencegah SQL injection

### 5.4 Contoh UAT (User Acceptance Testing)

#### 5.4.1 Test Case: User Registration
| Test ID | TC-001 |
|---------|--------|
| **Test Case:** | User Registration |
| **Precondition:** | User belum terdaftar |
| **Test Steps:** | 1. Buka halaman register<br>2. Isi form dengan data valid<br>3. Klik tombol "Register" |
| **Expected Result:** | User berhasil terdaftar dan dapat login |
| **Actual Result:** | |
| **Status:** | Pass/Fail |

#### 5.4.2 Test Case: Product Purchase
| Test ID | TC-002 |
|---------|--------|
| **Test Case:** | Product Purchase |
| **Precondition:** | User sudah login, produk tersedia |
| **Test Steps:** | 1. Pilih produk<br>2. Tambah ke keranjang<br>3. Checkout<br>4. Pilih metode pembayaran |
| **Expected Result:** | Order berhasil dibuat dan status "Pending" |
| **Actual Result:** | |
| **Status:** | Pass/Fail |

### 5.5 Screenshot Monitoring System

*[Tempat untuk screenshot monitoring dashboard, alert system, dan performance metrics]*

---

**Dokumentasi ini disusun berdasarkan hasil audit yang telah dilaksanakan dan dapat digunakan sebagai referensi untuk perbaikan sistem Arunika Interior ke depannya.**

**Disusun oleh:** Tim Audit IT  
**Tanggal:** 31 Desember 2024  
**Disetujui oleh:** [Nama Penyetuju]  
**Versi:** 1.0 (General) 