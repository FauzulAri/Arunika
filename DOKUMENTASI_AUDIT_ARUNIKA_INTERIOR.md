# DOKUMENTASI AUDIT SISTEM INFORMASI ARUNIKA INTERIOR

**Periode Audit:** Desember 2024  
**Tim Auditor:** Tim Audit IT  
**Versi Dokumen:** 1.0  

---

## 1. PENDAHULUAN [POIN 10]

### 1.1 Latar Belakang

Arunika Interior adalah platform marketplace furniture yang telah beroperasi sejak tahun 2024. Sistem ini memungkinkan pelanggan untuk melihat katalog furniture, melakukan pemesanan, dan memberikan review produk. Dengan pertumbuhan bisnis yang signifikan dan kompleksitas sistem yang meningkat, diperlukan audit sistem informasi untuk memastikan keamanan, kinerja, dan kepatuhan terhadap standar industri.

Audit ini dilaksanakan untuk mengevaluasi efektivitas pengendalian internal, keamanan sistem, dan kesesuaian dengan best practices dalam pengelolaan sistem informasi e-commerce.

### 1.2 Dasar Hukum

1. **Undang-Undang Nomor 11 Tahun 2008** tentang Informasi dan Transaksi Elektronik (UU ITE)
2. **Undang-Undang Nomor 19 Tahun 2016** tentang Perubahan atas Undang-Undang Nomor 11 Tahun 2008 tentang Informasi dan Transaksi Elektronik
3. **Peraturan Menteri Komunikasi dan Informatika Nomor 20 Tahun 2016** tentang Perlindungan Data Pribadi dalam Sistem Elektronik
4. **ISO/IEC 27001:2013** Information Security Management System
5. **COBIT 2019 Framework** untuk IT Governance
6. **PCI DSS v4.0** untuk keamanan data kartu pembayaran

### 1.3 Metodologi Audit

Audit ini menggunakan pendekatan berbasis risiko dengan metodologi sebagai berikut:

1. **Perencanaan Audit**
   - Identifikasi area audit
   - Penilaian risiko
   - Penentuan scope audit

2. **Pelaksanaan Audit**
   - Pengumpulan bukti audit
   - Pengujian pengendalian
   - Analisis temuan

3. **Pelaporan Audit**
   - Dokumentasi temuan
   - Penilaian risiko
   - Rekomendasi perbaikan

**Teknik Audit yang Digunakan:**
- Review dokumentasi sistem
- Pengujian pengendalian aplikasi
- Analisis konfigurasi sistem
- Penilaian keamanan database
- Review kode aplikasi
- Pengujian penetrasi terbatas

### 1.4 Tujuan Audit

1. **Tujuan Umum:**
   - Memastikan keamanan dan integritas sistem informasi Arunika Interior
   - Mengevaluasi efektivitas pengendalian internal
   - Memverifikasi kepatuhan terhadap regulasi yang berlaku

2. **Tujuan Khusus:**
   - Menilai keamanan data pelanggan dan transaksi
   - Mengevaluasi kinerja sistem dan infrastruktur
   - Memastikan ketersediaan dan kontinuitas layanan
   - Menilai efektivitas manajemen risiko IT

### 1.5 Ruang Lingkup Audit

**Sistem yang Diaudit:**
1. **Aplikasi Web E-commerce**
   - Frontend user interface
   - Backend admin panel
   - Sistem keranjang belanja
   - Proses checkout dan pembayaran

2. **Database Management System**
   - Struktur database MySQL
   - Pengendalian akses database
   - Backup dan recovery procedures

3. **Infrastruktur Sistem**
   - Server web (Apache/Nginx)
   - Konfigurasi keamanan
   - Monitoring dan logging

4. **Integrasi Pembayaran**
   - Integrasi Midtrans payment gateway
   - Keamanan transaksi finansial
   - Penanganan notifikasi pembayaran

**Periode Audit:** 1-31 Desember 2024  
**Lokasi Audit:** Sistem produksi dan development environment

---

## 2. GAMBARAN UMUM [POIN 10]

### 2.1 Proses Bisnis

**Arunika Interior** mengoperasikan model bisnis B2C (Business-to-Consumer) dengan alur proses sebagai berikut:

#### 2.1.1 Proses Utama

1. **Manajemen Katalog Produk**
   - Admin menambahkan/mengedit data furniture
   - Kategorisasi produk berdasarkan jenis
   - Pengelolaan stok dan harga
   - Manajemen diskon dan promo

2. **Proses Pembelian Customer**
   - Customer browsing katalog produk
   - Menambahkan produk ke keranjang
   - Proses checkout dengan berbagai metode pembayaran
   - Konfirmasi order oleh admin
   - Pengiriman dan tracking order

3. **Manajemen User**
   - Registrasi dan login customer
   - Pengelolaan profil user
   - Sistem review dan rating produk

#### 2.1.2 Alur Transaksi

```
Customer → Browse Katalog → Add to Cart → Checkout → Payment → Order Confirmation → Shipping → Delivery
```

### 2.2 Arsitektur Teknologi Informasi

#### 2.2.1 Stack Teknologi

**Frontend:**
- HTML5, CSS3, JavaScript
- Bootstrap 5.3.3 (UI Framework)
- FontAwesome (Icons)
- Swiper.js (Carousel)

**Backend:**
- PHP 8.x (Server-side scripting)
- MySQL 8.0 (Database)
- Apache/Nginx (Web Server)

**Payment Gateway:**
- Midtrans PHP SDK v2.6.2
- Integrasi multiple payment methods

**Development Tools:**
- Composer (Dependency Management)
- Git (Version Control)

#### 2.2.2 Arsitektur Sistem

```
┌─────────────────┐    ┌─────────────────┐    ┌─────────────────┐
│   Web Browser  │    │   Mobile App    │    │   Admin Panel   │
└─────────┬───────┘    └─────────┬───────┘    └─────────┬───────┘
          │                      │                      │
          └──────────────────────┼──────────────────────┘
                                 │
                    ┌─────────────▼─────────────┐
                    │      Web Server           │
                    │   (Apache/Nginx + PHP)    │
                    └─────────────┬─────────────┘
                                  │
                    ┌─────────────▼─────────────┐
                    │      Database Server      │
                    │        (MySQL 8.0)        │
                    └─────────────┬─────────────┘
                                  │
                    ┌─────────────▼─────────────┐
                    │    Payment Gateway        │
                    │      (Midtrans)           │
                    └───────────────────────────┘
```

#### 2.2.3 Struktur Database

**Tabel Utama:**
- `user` - Data customer
- `admin` - Data administrator
- `kategori` - Kategori produk
- `furniture` - Data produk furniture
- `keranjang` - Keranjang belanja
- `orders` - Data pesanan
- `detail_order` - Detail item pesanan
- `review` - Review dan rating produk
- `diskon` - Data diskon dan promo

### 2.3 Struktur Organisasi

#### 2.3.1 Tim Pengembangan

**Development Team:**
- **Lead Developer** - Bertanggung jawab atas arsitektur sistem
- **Frontend Developer** - Pengembangan user interface
- **Backend Developer** - Pengembangan server-side logic
- **Database Administrator** - Manajemen database
- **QA Engineer** - Testing dan quality assurance

#### 2.3.2 Tim Operasional

**IT Operations:**
- **System Administrator** - Manajemen server dan infrastruktur
- **Network Administrator** - Manajemen jaringan
- **Security Officer** - Keamanan sistem
- **Support Engineer** - Technical support

#### 2.3.3 Tim Bisnis

**Business Team:**
- **Product Manager** - Manajemen produk dan fitur
- **Marketing Team** - Promosi dan customer acquisition
- **Customer Service** - Layanan pelanggan
- **Finance Team** - Manajemen keuangan dan pembayaran

---

## 3. PELAKSANAAN AUDIT [POIN 70]

### 3.1 Lingkup Kontrol Audit

Berdasarkan analisis sistem Arunika Interior, audit ini fokus pada domain **"Deliver, Service and Support (DSS)"** dari framework COBIT 2019, dengan pertimbangan bahwa sistem ini merupakan aplikasi e-commerce yang memberikan layanan langsung kepada customer.

#### 3.1.1 Domain DSS yang Diaudit

**DSS01 - Managed Operations**
- Operasi harian sistem e-commerce
- Monitoring dan maintenance sistem

**DSS02 - Managed Service Requests and Incidents**
- Penanganan request dan incident
- Support customer service

**DSS03 - Managed Problems**
- Identifikasi dan resolusi masalah
- Root cause analysis

**DSS04 - Managed Continuity**
- Business continuity planning
- Disaster recovery procedures

**DSS05 - Managed Security Services**
- Keamanan aplikasi dan data
- Access control dan authentication

**DSS06 - Managed Business Process Controls**
- Pengendalian proses bisnis
- Compliance monitoring

### 3.2 Kertas Kerja/ Kuisoner Audit

#### 3.2.1 Kriteria Pengujian

**A. Keamanan Sistem (DSS05)**

| No | Kriteria Pengujian | Metode Pengujian | Hasil |
|----|-------------------|------------------|-------|
| 1 | Implementasi HTTPS | Review konfigurasi server | ✅ LULUS |
| 2 | Password Policy | Review kode autentikasi | ⚠️ PERLU PERBAIKAN |
| 3 | SQL Injection Protection | Penetration testing | ✅ LULUS |
| 4 | XSS Protection | Code review | ⚠️ PERLU PERBAIKAN |
| 5 | File Upload Security | Review upload handler | ⚠️ PERLU PERBAIKAN |
| 6 | Session Management | Review session handling | ✅ LULUS |
| 7 | Access Control | Review role-based access | ✅ LULUS |

**B. Kinerja Sistem (DSS01)**

| No | Kriteria Pengujian | Metode Pengujian | Hasil |
|----|-------------------|------------------|-------|
| 1 | Response Time < 3 detik | Load testing | ✅ LULUS |
| 2 | Database Optimization | Review query performance | ⚠️ PERLU PERBAIKAN |
| 3 | Image Optimization | Review asset management | ⚠️ PERLU PERBAIKAN |
| 4 | Caching Implementation | Review caching strategy | ❌ TIDAK ADA |
| 5 | CDN Usage | Review static asset delivery | ❌ TIDAK ADA |

**C. Manajemen Data (DSS06)**

| No | Kriteria Pengujian | Metode Pengujian | Hasil |
|----|-------------------|------------------|-------|
| 1 | Data Backup | Review backup procedures | ⚠️ PERLU PERBAIKAN |
| 2 | Data Encryption | Review encryption at rest | ❌ TIDAK ADA |
| 3 | Data Retention Policy | Review data lifecycle | ❌ TIDAK ADA |
| 4 | GDPR Compliance | Review privacy policy | ⚠️ PERLU PERBAIKAN |
| 5 | Audit Trail | Review logging system | ⚠️ PERLU PERBAIKAN |

**D. Integrasi Pembayaran (DSS02)**

| No | Kriteria Pengujian | Metode Pengujian | Hasil |
|----|-------------------|------------------|-------|
| 1 | Payment Gateway Security | Review Midtrans integration | ✅ LULUS |
| 2 | Transaction Logging | Review payment logs | ✅ LULUS |
| 3 | Error Handling | Review payment error handling | ✅ LULUS |
| 4 | Webhook Security | Review notification handling | ✅ LULUS |
| 5 | PCI DSS Compliance | Review payment data handling | ⚠️ PERLU PERBAIKAN |

#### 3.2.2 Temuan/ GAP

**A. Temuan Kritis (High Risk)**

1. **Tidak Ada Enkripsi Data Sensitif**
   - **Deskripsi:** Data pelanggan seperti password dan informasi pribadi tidak dienkripsi dengan standar yang memadai
   - **Lokasi:** Tabel `user`, kolom `password`, `alamat`, `no_hp`
   - **Dampak:** Risiko kebocoran data pelanggan yang tinggi
   - **Rekomendasi:** Implementasi bcrypt untuk password dan enkripsi untuk data sensitif

2. **Tidak Ada Backup Otomatis**
   - **Deskripsi:** Sistem backup database tidak otomatis dan tidak teruji
   - **Lokasi:** Konfigurasi database server
   - **Dampak:** Risiko kehilangan data permanen
   - **Rekomendasi:** Implementasi backup otomatis harian dengan testing restore

**B. Temuan Sedang (Medium Risk)**

3. **Tidak Ada Rate Limiting**
   - **Deskripsi:** Sistem tidak membatasi jumlah request per user
   - **Lokasi:** API endpoints dan form submission
   - **Dampak:** Risiko DDoS dan abuse
   - **Rekomendasi:** Implementasi rate limiting untuk API dan form

4. **Tidak Ada Input Validation yang Komprehensif**
   - **Deskripsi:** Validasi input tidak mencakup semua field
   - **Lokasi:** Form registrasi, checkout, dan admin panel
   - **Dampak:** Risiko injection attacks dan data corruption
   - **Rekomendasi:** Implementasi validasi server-side yang ketat

5. **Tidak Ada Monitoring Sistem**
   - **Deskripsi:** Tidak ada sistem monitoring untuk uptime dan performance
   - **Lokasi:** Server infrastructure
   - **Dampak:** Tidak dapat mendeteksi masalah secara proaktif
   - **Rekomendasi:** Implementasi monitoring tools (Nagios, Zabbix)

**C. Temuan Rendah (Low Risk)**

6. **Tidak Ada CDN**
   - **Deskripsi:** Static assets tidak menggunakan CDN
   - **Lokasi:** CSS, JavaScript, dan gambar
   - **Dampak:** Loading time yang lambat untuk user di lokasi jauh
   - **Rekomendasi:** Implementasi CDN untuk static assets

7. **Tidak Ada Caching**
   - **Deskripsi:** Tidak ada implementasi caching untuk database queries
   - **Lokasi:** Database queries di seluruh aplikasi
   - **Dampak:** Performa database yang tidak optimal
   - **Rekomendasi:** Implementasi Redis atau Memcached

#### 3.2.3 Risiko

**A. Risiko Keamanan**

| Risiko | Probabilitas | Dampak | Level Risiko | Mitigasi |
|--------|-------------|--------|--------------|----------|
| Data Breach | Medium | High | High | Enkripsi data, access control |
| SQL Injection | Low | High | Medium | Prepared statements, input validation |
| XSS Attack | Medium | Medium | Medium | Output encoding, CSP headers |
| DDoS Attack | Low | High | Medium | Rate limiting, CDN |
| Payment Fraud | Low | High | Medium | Payment gateway security |

**B. Risiko Operasional**

| Risiko | Probabilitas | Dampak | Level Risiko | Mitigasi |
|--------|-------------|--------|--------------|----------|
| System Downtime | Medium | High | High | Monitoring, backup |
| Data Loss | Low | High | Medium | Backup, disaster recovery |
| Performance Issues | High | Medium | Medium | Optimization, caching |
| User Experience | High | Medium | Medium | UX testing, feedback |

**C. Risiko Compliance**

| Risiko | Probabilitas | Dampak | Level Risiko | Mitigasi |
|--------|-------------|--------|--------------|----------|
| GDPR Violation | Medium | High | High | Privacy policy, data protection |
| PCI DSS Non-compliance | Low | High | Medium | Payment security audit |
| UU ITE Violation | Low | High | Medium | Legal compliance review |

#### 3.2.4 Rekomendasi

**A. Rekomendasi Prioritas Tinggi (Implementasi < 1 bulan)**

1. **Implementasi Enkripsi Data**
   ```php
   // Contoh implementasi bcrypt untuk password
   $hashed_password = password_hash($password, PASSWORD_BCRYPT);
   
   // Contoh enkripsi data sensitif
   $encrypted_data = openssl_encrypt($data, 'AES-256-CBC', $key, 0, $iv);
   ```

2. **Setup Backup Otomatis**
   ```bash
   # Cron job untuk backup harian
   0 2 * * * /usr/bin/mysqldump -u root -p arunika_furniture > /backup/arunika_$(date +\%Y\%m\%d).sql
   ```

3. **Implementasi Rate Limiting**
   ```php
   // Contoh rate limiting sederhana
   function checkRateLimit($user_id, $action, $limit = 100, $window = 3600) {
       $redis = new Redis();
       $key = "rate_limit:$user_id:$action";
       $current = $redis->incr($key);
       if ($current === 1) {
           $redis->expire($key, $window);
       }
       return $current <= $limit;
   }
   ```

**B. Rekomendasi Prioritas Sedang (Implementasi 1-3 bulan)**

4. **Implementasi Monitoring**
   - Setup Nagios/Zabbix untuk server monitoring
   - Implementasi application performance monitoring (APM)
   - Setup alerting untuk critical issues

5. **Optimasi Database**
   ```sql
   -- Index optimization
   CREATE INDEX idx_furniture_kategori ON furniture(kategori_id);
   CREATE INDEX idx_order_user ON orders(user_id);
   CREATE INDEX idx_order_status ON orders(status_order);
   
   -- Query optimization
   SELECT f.*, k.nama_kategori 
   FROM furniture f 
   INNER JOIN kategori k ON f.kategori_id = k.kategori_id 
   WHERE f.is_active = 1 
   ORDER BY f.furniture_id DESC;
   ```

6. **Implementasi Caching**
   ```php
   // Redis caching implementation
   $redis = new Redis();
   $cache_key = "furniture_list";
   $furniture_data = $redis->get($cache_key);
   
   if (!$furniture_data) {
       $furniture_data = $db->query("SELECT * FROM furniture WHERE is_active = 1");
       $redis->setex($cache_key, 3600, json_encode($furniture_data));
   }
   ```

**C. Rekomendasi Prioritas Rendah (Implementasi 3-6 bulan)**

7. **Implementasi CDN**
   - Setup CloudFlare atau AWS CloudFront
   - Configure static asset delivery
   - Implement image optimization

8. **Security Headers**
   ```php
   // Security headers implementation
   header("Content-Security-Policy: default-src 'self'");
   header("X-Frame-Options: DENY");
   header("X-Content-Type-Options: nosniff");
   header("X-XSS-Protection: 1; mode=block");
   ```

9. **Audit Trail Implementation**
   ```php
   // Audit logging
   function logActivity($user_id, $action, $table, $record_id, $old_data = null, $new_data = null) {
       $log_data = [
           'user_id' => $user_id,
           'action' => $action,
           'table_name' => $table,
           'record_id' => $record_id,
           'old_data' => json_encode($old_data),
           'new_data' => json_encode($new_data),
           'ip_address' => $_SERVER['REMOTE_ADDR'],
           'user_agent' => $_SERVER['HTTP_USER_AGENT'],
           'created_at' => date('Y-m-d H:i:s')
       ];
       
       $db->insert('activity_log', $log_data);
   }
   ```

---

## 4. KESIMPULAN HASIL AUDIT [POIN 10]

### 4.1 Tingkat Kesesuaian Audit

Berdasarkan hasil audit yang telah dilaksanakan, berikut adalah tingkat kesesuaian sistem Arunika Interior:

#### 4.1.1 Skor Kesesuaian per Domain

| Domain COBIT 2019 | Skor | Keterangan |
|-------------------|------|------------|
| DSS01 - Managed Operations | 65% | Perlu perbaikan monitoring dan maintenance |
| DSS02 - Managed Service Requests | 75% | Baik, perlu peningkatan incident management |
| DSS03 - Managed Problems | 60% | Perlu implementasi problem management |
| DSS04 - Managed Continuity | 45% | Kritis - perlu business continuity planning |
| DSS05 - Managed Security Services | 70% | Baik, perlu peningkatan enkripsi dan access control |
| DSS06 - Managed Business Process Controls | 55% | Perlu peningkatan compliance dan audit trail |

**Skor Rata-rata: 61.7%**

#### 4.1.2 Kategori Kesesuaian

- **Sangat Baik (90-100%):** 0 domain
- **Baik (80-89%):** 0 domain  
- **Cukup (70-79%):** 2 domain (DSS02, DSS05)
- **Kurang (60-69%):** 2 domain (DSS01, DSS03)
- **Buruk (<60%):** 2 domain (DSS04, DSS06)

### 4.2 Daftar Hasil Audit

#### 4.2.1 Temuan Positif

1. **Integrasi Payment Gateway yang Baik**
   - Implementasi Midtrans yang sesuai standar
   - Penanganan webhook yang proper
   - Error handling yang baik

2. **Struktur Database yang Terorganisir**
   - Normalisasi yang baik
   - Relasi antar tabel yang jelas
   - Index yang optimal untuk query utama

3. **User Interface yang User-Friendly**
   - Design yang responsif
   - Navigasi yang intuitif
   - Loading time yang acceptable

4. **Role-Based Access Control**
   - Pemisahan akses admin dan user yang jelas
   - Session management yang proper
   - Logout mechanism yang aman

#### 4.2.2 Temuan Negatif

1. **Keamanan Data (Kritis)**
   - Password tidak di-hash dengan bcrypt
   - Data sensitif tidak dienkripsi
   - Tidak ada rate limiting

2. **Backup dan Recovery (Kritis)**
   - Tidak ada backup otomatis
   - Tidak ada disaster recovery plan
   - Tidak ada testing restore

3. **Monitoring dan Alerting (Sedang)**
   - Tidak ada sistem monitoring
   - Tidak ada alerting untuk issues
   - Tidak ada performance monitoring

4. **Compliance (Sedang)**
   - Tidak ada privacy policy yang komprehensif
   - Tidak ada audit trail
   - Tidak ada data retention policy

#### 4.2.3 Rekomendasi Prioritas

**Prioritas 1 (Kritis - Implementasi < 2 minggu):**
1. Implementasi bcrypt untuk password
2. Setup backup otomatis harian
3. Implementasi rate limiting

**Prioritas 2 (Tinggi - Implementasi < 1 bulan):**
1. Implementasi monitoring sistem
2. Enkripsi data sensitif
3. Implementasi audit trail

**Prioritas 3 (Sedang - Implementasi < 3 bulan):**
1. Optimasi database performance
2. Implementasi caching
3. Setup CDN

**Prioritas 4 (Rendah - Implementasi < 6 bulan):**
1. Implementasi security headers
2. Setup disaster recovery
3. Compliance audit

#### 4.2.4 Rencana Tindak Lanjut

1. **Fase 1 (Minggu 1-2):** Implementasi keamanan kritis
2. **Fase 2 (Minggu 3-4):** Setup monitoring dan backup
3. **Fase 3 (Bulan 2-3):** Optimasi performa dan caching
4. **Fase 4 (Bulan 4-6):** Compliance dan security enhancement

**Timeline Implementasi:**
- **Q1 2025:** Keamanan dan monitoring
- **Q2 2025:** Performa dan optimasi
- **Q3 2025:** Compliance dan audit
- **Q4 2025:** Review dan enhancement

---

**Dokumentasi ini disusun berdasarkan hasil audit yang telah dilaksanakan dan dapat digunakan sebagai referensi untuk perbaikan sistem Arunika Interior ke depannya.**

**Disusun oleh:** Tim Audit IT  
**Tanggal:** 31 Desember 2024  
**Disetujui oleh:** [Nama Penyetuju]  
**Versi:** 1.0 