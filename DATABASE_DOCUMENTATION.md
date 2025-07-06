# Dokumentasi Database Arunika Furniture

## Deskripsi Project
Arunika Furniture adalah platform marketplace furniture yang memungkinkan user untuk melihat katalog furniture, menambahkan ke keranjang, melakukan pemesanan, dan memberikan review. Sistem ini terdiri dari user interface untuk customer dan admin panel untuk mengelola data.

## Struktur Database

### 1. Tabel User
Tabel untuk menyimpan data pengguna (customer)

```sql
CREATE TABLE user (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    foto VARCHAR(255),
    alamat TEXT,
    no_hp VARCHAR(15),
    tanggal_daftar TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    status ENUM('online', 'offline') DEFAULT 'offline',
    last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

**Keterangan Kolom:**
- `user_id`: Primary key, ID unik user
- `nama`: Nama lengkap user
- `email`: Email user (unique)
- `password`: Password terenkripsi
- `foto`: Nama file foto profil user
- `alamat`: Alamat lengkap user
- `no_hp`: Nomor handphone user
- `tanggal_daftar`: Tanggal user mendaftar
- `status`: Status online/offline user
- `last_activity`: Timestamp aktivitas terakhir user

### 2. Tabel Admin
Tabel untuk menyimpan data administrator

```sql
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('super_admin', 'admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);
```

**Keterangan Kolom:**
- `admin_id`: Primary key, ID unik admin
- `username`: Username untuk login admin
- `password`: Password terenkripsi
- `nama_lengkap`: Nama lengkap admin
- `email`: Email admin
- `role`: Role admin (super_admin/admin)
- `created_at`: Tanggal admin dibuat
- `last_login`: Timestamp login terakhir

### 3. Tabel Kategori
Tabel untuk mengelompokkan furniture berdasarkan kategori

```sql
CREATE TABLE kategori (
    kategori_id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    icon VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Keterangan Kolom:**
- `kategori_id`: Primary key, ID unik kategori
- `nama_kategori`: Nama kategori (Sofa, Meja, Kursi, dll)
- `deskripsi`: Deskripsi kategori
- `icon`: Icon untuk kategori (FontAwesome class)
- `is_active`: Status aktif kategori
- `created_at`: Tanggal kategori dibuat

### 4. Tabel Furniture
Tabel untuk menyimpan data furniture

```sql
CREATE TABLE furniture (
    furniture_id INT AUTO_INCREMENT PRIMARY KEY,
    kategori_id INT NOT NULL,
    nama_furniture VARCHAR(255) NOT NULL,
    harga DECIMAL(10,2) NOT NULL,
    stok INT DEFAULT 0,
    gambar_furniture VARCHAR(255),
    deskripsi TEXT,
    berat DECIMAL(5,2),
    dimensi VARCHAR(100),
    material VARCHAR(100),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (kategori_id) REFERENCES kategori(kategori_id) ON DELETE RESTRICT
);
```

**Keterangan Kolom:**
- `furniture_id`: Primary key, ID unik furniture
- `kategori_id`: Foreign key ke tabel kategori
- `nama_furniture`: Nama furniture
- `harga`: Harga furniture
- `stok`: Jumlah stok tersedia
- `gambar_furniture`: Nama file gambar furniture
- `deskripsi`: Deskripsi detail furniture
- `berat`: Berat furniture dalam kg
- `dimensi`: Dimensi furniture (PxLxT)
- `material`: Material furniture
- `is_active`: Status aktif furniture
- `created_at`: Tanggal furniture ditambahkan
- `updated_at`: Tanggal terakhir update

### 5. Tabel Keranjang
Tabel untuk menyimpan item keranjang belanja user

```sql
CREATE TABLE keranjang (
    keranjang_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    furniture_id INT NOT NULL,
    jumlah INT NOT NULL DEFAULT 1,
    harga_satuan DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (furniture_id) REFERENCES furniture(furniture_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_furniture (user_id, furniture_id)
);
```

**Keterangan Kolom:**
- `keranjang_id`: Primary key, ID unik keranjang
- `user_id`: Foreign key ke tabel user
- `furniture_id`: Foreign key ke tabel furniture
- `jumlah`: Jumlah item yang dipilih
- `harga_satuan`: Harga per unit saat ditambahkan ke keranjang
- `subtotal`: Total harga (jumlah × harga_satuan)
- `created_at`: Tanggal item ditambahkan ke keranjang
- `updated_at`: Tanggal terakhir update keranjang

### 6. Tabel Order
Tabel untuk menyimpan data pesanan

```sql
CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    nomor_order VARCHAR(20) UNIQUE NOT NULL,
    total_harga DECIMAL(10,2) NOT NULL,
    status_order ENUM('pending', 'confirmed', 'processing', 'shipped', 'delivered', 'cancelled') DEFAULT 'pending',
    metode_pembayaran ENUM('transfer_bank', 'cod', 'e_wallet') NOT NULL,
    alamat_pengiriman TEXT NOT NULL,
    nama_penerima VARCHAR(100) NOT NULL,
    no_hp_penerima VARCHAR(15) NOT NULL,
    catatan TEXT,
    tanggal_order TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tanggal_konfirmasi TIMESTAMP NULL,
    tanggal_pengiriman TIMESTAMP NULL,
    tanggal_diterima TIMESTAMP NULL,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE RESTRICT
);
```

**Keterangan Kolom:**
- `order_id`: Primary key, ID unik order
- `user_id`: Foreign key ke tabel user
- `nomor_order`: Nomor order unik (format: ORD-YYYYMMDD-XXXX)
- `total_harga`: Total harga order
- `status_order`: Status pesanan
- `metode_pembayaran`: Metode pembayaran yang dipilih
- `alamat_pengiriman`: Alamat pengiriman
- `nama_penerima`: Nama penerima
- `no_hp_penerima`: Nomor HP penerima
- `catatan`: Catatan tambahan untuk order
- `tanggal_order`: Tanggal order dibuat
- `tanggal_konfirmasi`: Tanggal order dikonfirmasi admin
- `tanggal_pengiriman`: Tanggal order dikirim
- `tanggal_diterima`: Tanggal order diterima customer

### 7. Tabel Detail Order
Tabel untuk menyimpan detail item dalam order

```sql
CREATE TABLE detail_order (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    furniture_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (furniture_id) REFERENCES furniture(furniture_id) ON DELETE RESTRICT
);
```

**Keterangan Kolom:**
- `detail_id`: Primary key, ID unik detail order
- `order_id`: Foreign key ke tabel orders
- `furniture_id`: Foreign key ke tabel furniture
- `jumlah`: Jumlah furniture yang dipesan
- `harga_satuan`: Harga per unit saat order
- `subtotal`: Total harga item (jumlah × harga_satuan)

### 8. Tabel Review
Tabel untuk menyimpan review/rating furniture dari user

```sql
CREATE TABLE review (
    review_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    furniture_id INT NOT NULL,
    order_id INT NOT NULL,
    rating INT NOT NULL CHECK (rating >= 1 AND rating <= 5),
    komentar TEXT,
    gambar_review VARCHAR(255),
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES user(user_id) ON DELETE CASCADE,
    FOREIGN KEY (furniture_id) REFERENCES furniture(furniture_id) ON DELETE CASCADE,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    UNIQUE KEY unique_user_furniture_order (user_id, furniture_id, order_id)
);
```

**Keterangan Kolom:**
- `review_id`: Primary key, ID unik review
- `user_id`: Foreign key ke tabel user
- `furniture_id`: Foreign key ke tabel furniture
- `order_id`: Foreign key ke tabel orders (memastikan user sudah membeli)
- `rating`: Rating 1-5 bintang
- `komentar`: Komentar review
- `gambar_review`: Gambar review (opsional)
- `is_verified`: Status verifikasi review oleh admin
- `created_at`: Tanggal review dibuat

## TABEL DISKON

Tabel `diskon` digunakan untuk menyimpan data diskon/promo yang berlaku pada produk furniture tertentu. Tabel ini terhubung ke tabel `furniture` melalui kolom `furniture_id`.

### Struktur Tabel
| Kolom           | Tipe Data                | Keterangan                                    |
|-----------------|-------------------------|------------------------------------------------|
| diskon_id       | INT AUTO_INCREMENT      | Primary key                                    |
| furniture_id    | INT                     | Relasi ke furniture (produk yang didiskon)      |
| tipe            | ENUM('persen','nominal')| Jenis diskon: persen (%) atau nominal (rupiah)  |
| nilai           | DECIMAL(10,2)           | Nilai diskon (misal: 20 untuk 20% atau 500000) |
| tanggal_mulai   | TIMESTAMP NULL          | Waktu mulai diskon                             |
| tanggal_selesai | TIMESTAMP NULL          | Waktu selesai diskon                           |
| is_active       | BOOLEAN                 | Status aktif/tidak                             |
| keterangan      | TEXT                    | Keterangan promo                               |
| created_at      | TIMESTAMP               | Waktu dibuat                                   |
| updated_at      | TIMESTAMP               | Waktu update                                   |

### Relasi
- `furniture_id` FOREIGN KEY ke `furniture(furniture_id)`
- Jika produk dihapus, diskon terkait juga ikut terhapus (ON DELETE CASCADE)

### Contoh Data
| diskon_id | furniture_id | tipe    | nilai   | tanggal_mulai         | tanggal_selesai        | is_active | keterangan        |
|-----------|--------------|---------|---------|-----------------------|------------------------|-----------|-------------------|
| 1         | 1            | persen  | 20      | 2024-06-01 10:00:00   | 2024-06-08 10:00:00    | 1         | Promo Minggu Ini  |
| 2         | 2            | nominal | 500000  | 2024-06-01 10:00:00   | 2024-06-04 10:00:00    | 1         | Flash Sale        |

### Cara Penggunaan
- Untuk menampilkan harga diskon, lakukan LEFT JOIN ke tabel diskon dan cek diskon yang aktif dan dalam periode berlaku.
- Hitung harga akhir:
    - Jika tipe `persen`: `harga_akhir = harga - (harga * nilai / 100)`
    - Jika tipe `nominal`: `harga_akhir = harga - nilai`
- Jika tidak ada diskon aktif, gunakan harga asli.

## Relasi Antar Tabel

### Diagram Relasi:
```
User (1) -----> (N) Keranjang
User (1) -----> (N) Orders
User (1) -----> (N) Review

Kategori (1) -----> (N) Furniture

Furniture (1) -----> (N) Keranjang
Furniture (1) -----> (N) Detail_Order
Furniture (1) -----> (N) Review

Orders (1) -----> (N) Detail_Order
Orders (1) -----> (N) Review
```

## Data Sample

### Kategori Sample:
```sql
INSERT INTO kategori (nama_kategori, deskripsi, icon) VALUES
('Sofa', 'Koleksi sofa untuk ruang tamu', 'fa-couch'),
('Meja', 'Berbagai jenis meja', 'fa-table'),
('Kursi', 'Kursi untuk berbagai keperluan', 'fa-chair'),
('Lemari', 'Lemari penyimpanan', 'fa-door-closed'),
('Tempat Tidur', 'Tempat tidur dan ranjang', 'fa-bed'),
('Dekorasi', 'Item dekorasi ruangan', 'fa-palette'),
('Lainnya', 'Furniture lainnya', 'fa-plus');
```

### Furniture Sample:
```sql
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, deskripsi, berat, dimensi, material) VALUES
(1, 'Sofa Minimalis Modern', 3500000, 10, 'Sofa minimalis dengan desain modern', 45.5, '200x85x75', 'Kain premium'),
(2, 'Meja Makan Kayu Solid', 2800000, 5, 'Meja makan berbahan kayu solid', 35.0, '150x90x75', 'Kayu jati'),
(3, 'Kursi Kerja Ergonomic', 1200000, 15, 'Kursi kerja ergonomis', 12.5, '65x65x120', 'Mesh fabric');
```

## Index dan Optimasi

### Index yang Disarankan:
```sql
-- Index untuk pencarian furniture
CREATE INDEX idx_furniture_kategori ON furniture(kategori_id);
CREATE INDEX idx_furniture_active ON furniture(is_active);

-- Index untuk order
CREATE INDEX idx_order_user ON orders(user_id);
CREATE INDEX idx_order_status ON orders(status_order);
CREATE INDEX idx_order_date ON orders(tanggal_order);

-- Index untuk keranjang
CREATE INDEX idx_keranjang_user ON keranjang(user_id);

-- Index untuk review
CREATE INDEX idx_review_furniture ON review(furniture_id);
CREATE INDEX idx_review_rating ON review(rating);
```

## Trigger dan Constraint

### Trigger untuk Update Stok:
```sql
DELIMITER //
CREATE TRIGGER update_stok_after_order
AFTER INSERT ON detail_order
FOR EACH ROW
BEGIN
    UPDATE furniture 
    SET stok = stok - NEW.jumlah 
    WHERE furniture_id = NEW.furniture_id;
END//
DELIMITER ;
```

### Trigger untuk Generate Nomor Order:
```sql
DELIMITER //
CREATE TRIGGER generate_nomor_order
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
    SET NEW.nomor_order = CONCAT('ORD-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD((SELECT COUNT(*) + 1 FROM orders WHERE DATE(tanggal_order) = CURDATE()), 4, '0'));
END//
DELIMITER ;
```

## Backup dan Maintenance

### Backup Strategy:
1. **Full Backup**: Setiap hari jam 2 pagi
2. **Incremental Backup**: Setiap 6 jam
3. **Log Backup**: Setiap jam

### Maintenance Tasks:
1. **Cleanup Session**: Hapus session yang expired setiap hari
2. **Update User Status**: Update status user menjadi offline jika tidak aktif > 30 menit
3. **Archive Old Orders**: Pindahkan order > 2 tahun ke tabel archive
4. **Optimize Tables**: Optimize tabel setiap minggu

## Security Considerations

### Password Security:
- Password di-hash menggunakan bcrypt
- Minimum 8 karakter
- Kombinasi huruf besar, kecil, angka, dan simbol

### Data Protection:
- Semua input di-sanitize
- Menggunakan prepared statements
- Validasi file upload
- Rate limiting untuk API

### Access Control:
- Role-based access control untuk admin
- Session timeout setelah 30 menit tidak aktif
- Log semua aktivitas admin

## Monitoring dan Logging

### Log Tables:
```sql
CREATE TABLE activity_log (
    log_id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    action VARCHAR(100) NOT NULL,
    table_name VARCHAR(50),
    record_id INT,
    old_data JSON,
    new_data JSON,
    ip_address VARCHAR(45),
    user_agent TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### Performance Monitoring:
- Query execution time
- Database connection count
- Table size monitoring
- Index usage statistics

## Migration Scripts

### Script untuk Update Existing Database:
```sql
-- Update existing furniture table
ALTER TABLE furniture 
ADD COLUMN stok INT DEFAULT 0 AFTER harga,
ADD COLUMN berat DECIMAL(5,2) AFTER deskripsi,
ADD COLUMN dimensi VARCHAR(100) AFTER berat,
ADD COLUMN material VARCHAR(100) AFTER dimensi,
ADD COLUMN is_active BOOLEAN DEFAULT TRUE AFTER material;

-- Update existing user table
ALTER TABLE user 
ADD COLUMN last_activity TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP AFTER status;
```

Dokumentasi ini memberikan gambaran lengkap tentang struktur database yang diperlukan untuk project Arunika Furniture dengan semua fitur marketplace yang modern. 