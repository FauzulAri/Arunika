-- =====================================================
-- DATABASE SETUP ARUNIKA FURNITURE
-- =====================================================

-- Buat database jika belum ada
CREATE DATABASE IF NOT EXISTS arunika_furniture;
USE arunika_furniture;

-- =====================================================
-- TABEL USER
-- =====================================================
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
) ENGINE=InnoDB;

-- =====================================================
-- TABEL ADMIN
-- =====================================================
CREATE TABLE admin (
    admin_id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    nama_lengkap VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    role ENUM('super_admin', 'admin') DEFAULT 'admin',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
) ENGINE=InnoDB;

-- =====================================================
-- TABEL KATEGORI
-- =====================================================
CREATE TABLE kategori (
    kategori_id INT AUTO_INCREMENT PRIMARY KEY,
    nama_kategori VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    icon VARCHAR(50),
    is_active BOOLEAN DEFAULT TRUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =====================================================
-- TABEL FURNITURE
-- =====================================================
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
) ENGINE=InnoDB;

-- =====================================================
-- TABEL KERANJANG
-- =====================================================
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
) ENGINE=InnoDB;

-- =====================================================
-- TABEL ORDERS
-- =====================================================
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
) ENGINE=InnoDB;

-- =====================================================
-- TABEL DETAIL ORDER
-- =====================================================
CREATE TABLE detail_order (
    detail_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    furniture_id INT NOT NULL,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(order_id) ON DELETE CASCADE,
    FOREIGN KEY (furniture_id) REFERENCES furniture(furniture_id) ON DELETE RESTRICT
) ENGINE=InnoDB;

-- =====================================================
-- TABEL REVIEW
-- =====================================================
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
) ENGINE=InnoDB;

-- =====================================================
-- TABEL DISKON
-- =====================================================
CREATE TABLE diskon (
    diskon_id INT AUTO_INCREMENT PRIMARY KEY,
    furniture_id INT NOT NULL,
    tipe ENUM('persen', 'nominal') NOT NULL,
    nilai DECIMAL(10,2) NOT NULL,
    tanggal_mulai TIMESTAMP NULL,
    tanggal_selesai TIMESTAMP NULL,
    is_active BOOLEAN DEFAULT TRUE,
    keterangan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (furniture_id) REFERENCES furniture(furniture_id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =====================================================
-- TABEL ACTIVITY LOG
-- =====================================================
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
) ENGINE=InnoDB;

-- =====================================================
-- INDEXES UNTUK OPTIMASI
-- =====================================================

-- Index untuk pencarian furniture
CREATE INDEX idx_furniture_kategori ON furniture(kategori_id);
CREATE INDEX idx_furniture_active ON furniture(is_active);
CREATE INDEX idx_furniture_nama ON furniture(nama_furniture);

-- Index untuk order
CREATE INDEX idx_order_user ON orders(user_id);
CREATE INDEX idx_order_status ON orders(status_order);
CREATE INDEX idx_order_date ON orders(tanggal_order);
CREATE INDEX idx_order_nomor ON orders(nomor_order);

-- Index untuk keranjang
CREATE INDEX idx_keranjang_user ON keranjang(user_id);

-- Index untuk review
CREATE INDEX idx_review_furniture ON review(furniture_id);
CREATE INDEX idx_review_rating ON review(rating);
CREATE INDEX idx_review_verified ON review(is_verified);

-- Index untuk user
CREATE INDEX idx_user_email ON user(email);
CREATE INDEX idx_user_status ON user(status);

-- Index untuk kategori
CREATE INDEX idx_kategori_active ON kategori(is_active);

-- =====================================================
-- TRIGGERS
-- =====================================================

-- Trigger untuk update stok setelah order
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

-- Trigger untuk generate nomor order
DELIMITER //
CREATE TRIGGER generate_nomor_order
BEFORE INSERT ON orders
FOR EACH ROW
BEGIN
    SET NEW.nomor_order = CONCAT('ORD-', DATE_FORMAT(NOW(), '%Y%m%d'), '-', LPAD((SELECT COUNT(*) + 1 FROM orders WHERE DATE(tanggal_order) = CURDATE()), 4, '0'));
END//
DELIMITER ;

-- Trigger untuk update subtotal keranjang
DELIMITER //
CREATE TRIGGER update_subtotal_keranjang
BEFORE INSERT ON keranjang
FOR EACH ROW
BEGIN
    SET NEW.subtotal = NEW.jumlah * NEW.harga_satuan;
END//
DELIMITER ;

-- Trigger untuk update subtotal detail order
DELIMITER //
CREATE TRIGGER update_subtotal_detail_order
BEFORE INSERT ON detail_order
FOR EACH ROW
BEGIN
    SET NEW.subtotal = NEW.jumlah * NEW.harga_satuan;
END//
DELIMITER ;

-- =====================================================
-- DATA SAMPLE
-- =====================================================

-- Insert admin default
INSERT INTO admin (username, password, nama_lengkap, email, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin@arunika.com', 'super_admin');

-- Insert kategori sample
INSERT INTO kategori (nama_kategori, deskripsi, icon) VALUES
('Sofa', 'Koleksi sofa untuk ruang tamu', 'fa-couch'),
('Meja', 'Berbagai jenis meja', 'fa-table'),
('Kursi', 'Kursi untuk berbagai keperluan', 'fa-chair'),
('Lemari', 'Lemari penyimpanan', 'fa-door-closed'),
('Tempat Tidur', 'Tempat tidur dan ranjang', 'fa-bed'),
('Dekorasi', 'Item dekorasi ruangan', 'fa-palette'),
('Lainnya', 'Furniture lainnya', 'fa-plus');

-- Insert furniture sample
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(1, 'Sofa Minimalis Modern', 3500000, 10, 'interior1.jpg', 'Sofa minimalis dengan desain modern, nyaman untuk ruang tamu. Terbuat dari bahan berkualitas tinggi dengan finishing yang elegan.', 45.5, '200x85x75', 'Kain premium'),
(2, 'Meja Makan Kayu Solid', 2800000, 5, 'interior2.jpg', 'Meja makan berbahan kayu solid, kuat dan tahan lama. Cocok untuk keluarga modern dengan kapasitas 6-8 orang.', 35.0, '150x90x75', 'Kayu jati'),
(3, 'Kursi Kerja Ergonomic', 1200000, 15, 'interior3.jpeg', 'Kursi kerja ergonomis dengan dukungan lumbar yang baik. Ideal untuk penggunaan lama di kantor atau rumah.', 12.5, '65x65x120', 'Mesh fabric'),
(4, 'Lemari Pakaian 3 Pintu', 4500000, 8, 'interior4.jpeg', 'Lemari pakaian 3 pintu dengan rak gantung dan laci. Desain modern dengan kapasitas penyimpanan yang besar.', 85.0, '180x60x200', 'MDF + HPL'),
(5, 'Tempat Tidur Minimalis', 3200000, 12, 'interior5.jpg', 'Tempat tidur minimalis dengan headboard yang elegan. Dilengkapi dengan laci penyimpanan di bawah.', 55.0, '200x160x25', 'Kayu pinus'),
(6, 'Rak Buku Kayu', 850000, 20, 'interior6.jpg', 'Rak buku kayu dengan desain sederhana namun elegan. Cocok untuk ruang kerja atau ruang keluarga.', 15.0, '100x30x180', 'Kayu mahoni'),
(7, 'Meja Belajar Anak', 950000, 25, 'interior7.jpg', 'Meja belajar khusus anak dengan ukuran yang sesuai. Dilengkapi dengan laci penyimpanan dan rak buku.', 18.0, '120x60x75', 'MDF + cat'),
(3, 'Kursi Santai Rotan', 750000, 30, 'glam1.jpg', 'Kursi santai berbahan rotan alami. Nyaman untuk bersantai di teras atau balkon.', 8.5, '70x70x85', 'Rotan alami'),
(6, 'Vas Bunga Dekoratif', 250000, 40, 'flower1.jpg', 'Vas bunga dekoratif untuk mempercantik ruangan. Material keramik dengan motif elegan.', 2.0, '20x20x35', 'Keramik'),
(6, 'Lukisan Dinding Modern', 600000, 10, 'flower2.avif', 'Lukisan dinding dengan tema modern, cocok untuk ruang tamu atau kamar tidur.', 1.5, '60x80', 'Canvas');

-- Tambahan data sample furniture untuk setiap kategori (20+ per kategori)
-- Kategori 1: Sofa
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(1, 'Sofa L Minimalis Abu', 4200000, 8, 'interior1.jpg', 'Sofa L dengan bahan kain premium, cocok untuk ruang keluarga modern.', 48, '220x90x80', 'Kain premium'),
(1, 'Sofa 2 Dudukan Elegan', 2800000, 12, 'interior1.jpg', 'Sofa 2 dudukan dengan desain elegan dan kaki kayu jati.', 32, '160x80x75', 'Kain & Kayu Jati'),
(1, 'Sofa Bed Multifungsi', 3900000, 10, 'interior1.jpg', 'Sofa bed yang dapat diubah menjadi tempat tidur, cocok untuk apartemen.', 50, '200x90x40', 'Kain & Busa'),
(1, 'Sofa Retro Kuning', 3100000, 7, 'interior1.jpg', 'Sofa retro warna kuning cerah, menambah keceriaan ruangan.', 36, '170x85x75', 'Kain'),
(1, 'Sofa Kulit Hitam', 5200000, 5, 'interior1.jpg', 'Sofa kulit asli warna hitam, tampilan mewah dan mudah dibersihkan.', 55, '200x90x80', 'Kulit Asli'),
(1, 'Sofa Minimalis Coklat', 3400000, 9, 'interior1.jpg', 'Sofa minimalis warna coklat, cocok untuk ruang tamu kecil.', 40, '180x80x75', 'Kain'),
(1, 'Sofa Modular 3 Seat', 4700000, 6, 'interior1.jpg', 'Sofa modular 3 seat, bisa diatur sesuai kebutuhan.', 60, '240x90x80', 'Kain'),
(1, 'Sofa Scandinavian', 3600000, 8, 'interior1.jpg', 'Sofa gaya Scandinavian, warna pastel lembut.', 38, '175x85x75', 'Kain'),
(1, 'Sofa Minimalis Biru', 3300000, 10, 'interior1.jpg', 'Sofa minimalis warna biru, rangka kayu kuat.', 42, '180x80x75', 'Kain'),
(1, 'Sofa 3 Dudukan Modern', 4100000, 7, 'interior1.jpg', 'Sofa 3 dudukan dengan sandaran empuk.', 50, '210x90x80', 'Kain'),
(1, 'Sofa Chesterfield', 5500000, 4, 'interior1.jpg', 'Sofa Chesterfield klasik, cocok untuk ruang tamu mewah.', 65, '220x95x80', 'Kulit'),
(1, 'Sofa Minimalis Hijau', 3200000, 11, 'interior1.jpg', 'Sofa minimalis warna hijau, desain simpel.', 39, '175x80x75', 'Kain'),
(1, 'Sofa Bed Lipat', 3700000, 8, 'interior1.jpg', 'Sofa bed lipat, praktis untuk ruang tamu kecil.', 45, '190x85x40', 'Kain'),
(1, 'Sofa 2 Dudukan Pink', 2950000, 10, 'interior1.jpg', 'Sofa 2 dudukan warna pink pastel, cocok untuk kamar remaja.', 33, '160x80x75', 'Kain'),
(1, 'Sofa Minimalis Putih', 3500000, 9, 'interior1.jpg', 'Sofa minimalis warna putih, mudah dipadukan dengan dekorasi apapun.', 41, '180x80x75', 'Kain'),
(1, 'Sofa L Modern', 4300000, 6, 'interior1.jpg', 'Sofa L modern, rangka kayu solid.', 49, '220x90x80', 'Kain'),
(1, 'Sofa Minimalis Krem', 3400000, 8, 'interior1.jpg', 'Sofa minimalis warna krem, nuansa hangat.', 40, '180x80x75', 'Kain'),
(1, 'Sofa 3 Dudukan Abu', 4100000, 7, 'interior1.jpg', 'Sofa 3 dudukan warna abu, desain modern.', 50, '210x90x80', 'Kain'),
(1, 'Sofa Minimalis Navy', 3300000, 10, 'interior1.jpg', 'Sofa minimalis warna navy, cocok untuk ruang keluarga.', 42, '180x80x75', 'Kain'),
(1, 'Sofa Bed Abu', 3700000, 8, 'interior1.jpg', 'Sofa bed warna abu, multifungsi.', 45, '190x85x40', 'Kain');

-- Kategori 2: Meja
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(2, 'Meja Makan Minimalis', 2500000, 10, 'interior2.jpg', 'Meja makan minimalis, cocok untuk keluarga kecil.', 30, '140x80x75', 'Kayu jati'),
(2, 'Meja Kerja Modern', 1800000, 12, 'interior2.jpg', 'Meja kerja modern dengan laci penyimpanan.', 22, '120x60x75', 'MDF'),
(2, 'Meja Tamu Bundar', 1200000, 15, 'interior2.jpg', 'Meja tamu bundar, desain elegan.', 15, '80x80x45', 'Kayu mahoni'),
(2, 'Meja Belajar Anak', 950000, 20, 'interior2.jpg', 'Meja belajar anak dengan rak buku.', 18, '100x60x75', 'MDF'),
(2, 'Meja Konsol', 1600000, 8, 'interior2.jpg', 'Meja konsol untuk ruang tamu atau lorong.', 20, '120x35x80', 'Kayu'),
(2, 'Meja Rias Minimalis', 1750000, 7, 'interior2.jpg', 'Meja rias dengan cermin dan laci.', 19, '100x45x140', 'MDF'),
(2, 'Meja Samping Tempat Tidur', 700000, 18, 'interior2.jpg', 'Meja samping tempat tidur, desain simpel.', 8, '45x45x50', 'Kayu'),
(2, 'Meja Makan Bulat', 2100000, 9, 'interior2.jpg', 'Meja makan bulat, kapasitas 4 orang.', 25, '110x110x75', 'Kayu'),
(2, 'Meja Kerja Industrial', 1950000, 11, 'interior2.jpg', 'Meja kerja gaya industrial, rangka besi.', 28, '130x65x75', 'Kayu & Besi'),
(2, 'Meja TV Minimalis', 1350000, 13, 'interior2.jpg', 'Meja TV minimalis, rak penyimpanan terbuka.', 17, '120x40x50', 'MDF'),
(2, 'Meja Makan Kaca', 2700000, 6, 'interior2.jpg', 'Meja makan dengan permukaan kaca tempered.', 32, '150x90x75', 'Kaca & Kayu'),
(2, 'Meja Kerja Lipat', 850000, 14, 'interior2.jpg', 'Meja kerja lipat, praktis untuk ruangan kecil.', 10, '90x50x75', 'MDF'),
(2, 'Meja Tamu Persegi', 1100000, 16, 'interior2.jpg', 'Meja tamu persegi, desain modern.', 13, '70x70x45', 'Kayu'),
(2, 'Meja Rias Putih', 1850000, 8, 'interior2.jpg', 'Meja rias warna putih, nuansa elegan.', 20, '100x45x140', 'MDF'),
(2, 'Meja Konsol Klasik', 1700000, 7, 'interior2.jpg', 'Meja konsol gaya klasik, ukiran cantik.', 21, '120x35x80', 'Kayu'),
(2, 'Meja Samping Sofa', 750000, 18, 'interior2.jpg', 'Meja samping sofa, desain minimalis.', 9, '45x45x50', 'Kayu'),
(2, 'Meja Makan Kayu Jati', 3200000, 9, 'interior2.jpg', 'Meja makan dari kayu jati solid.', 35, '160x90x75', 'Kayu jati'),
(2, 'Meja Kerja Anak', 980000, 11, 'interior2.jpg', 'Meja kerja anak, warna ceria.', 12, '100x60x75', 'MDF'),
(2, 'Meja TV Modern', 1450000, 13, 'interior2.jpg', 'Meja TV modern, rak tertutup.', 18, '120x40x50', 'MDF'),
(2, 'Meja Makan Persegi', 2300000, 6, 'interior2.jpg', 'Meja makan persegi, kapasitas 6 orang.', 28, '140x140x75', 'Kayu');

-- Kategori 3: Kursi
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(3, 'Kursi Santai Rotan', 750000, 30, 'glam1.jpg', 'Kursi santai berbahan rotan alami. Nyaman untuk bersantai di teras atau balkon.', 8.5, '70x70x85', 'Rotan alami'),
(3, 'Kursi Kerja Ergonomis', 1200000, 15, 'interior3.jpeg', 'Kursi kerja ergonomis dengan sandaran lumbar.', 12, '65x65x120', 'Mesh fabric'),
(3, 'Kursi Makan Kayu Jati', 950000, 20, 'interior3.jpeg', 'Kursi makan dari kayu jati solid, desain klasik.', 10, '45x45x90', 'Kayu jati'),
(3, 'Kursi Bar Minimalis', 850000, 12, 'interior3.jpeg', 'Kursi bar tinggi, cocok untuk kitchen set.', 9, '40x40x110', 'Kayu'),
(3, 'Kursi Tamu Modern', 1100000, 10, 'interior3.jpeg', 'Kursi tamu dengan busa tebal dan rangka kayu.', 11, '60x60x85', 'Kain & Kayu'),
(3, 'Kursi Lipat Praktis', 450000, 25, 'interior3.jpeg', 'Kursi lipat, mudah disimpan dan dibawa.', 6, '40x40x80', 'Besi & Kain'),
(3, 'Kursi Anak Warna-warni', 350000, 18, 'interior3.jpeg', 'Kursi anak dengan warna ceria.', 4, '35x35x60', 'Plastik'),
(3, 'Kursi Kantor Executive', 1750000, 8, 'interior3.jpeg', 'Kursi kantor executive, sandaran tinggi dan roda.', 15, '70x70x120', 'PU Leather'),
(3, 'Kursi Cafe Industrial', 700000, 14, 'interior3.jpeg', 'Kursi cafe gaya industrial, rangka besi.', 8, '45x45x85', 'Besi & Kayu'),
(3, 'Kursi Goyang Kayu', 1300000, 6, 'interior3.jpeg', 'Kursi goyang klasik dari kayu mahoni.', 13, '60x90x100', 'Kayu mahoni'),
(3, 'Kursi Teras Minimalis', 600000, 16, 'interior3.jpeg', 'Kursi teras minimalis, cocok untuk outdoor.', 7, '50x50x80', 'Kayu'),
(3, 'Kursi Bar Putar', 950000, 10, 'interior3.jpeg', 'Kursi bar dengan dudukan putar.', 9, '40x40x110', 'Besi & Kain'),
(3, 'Kursi Makan Modern', 980000, 13, 'interior3.jpeg', 'Kursi makan modern, busa empuk.', 10, '45x45x90', 'Kain & Kayu'),
(3, 'Kursi Lipat Kayu', 550000, 20, 'interior3.jpeg', 'Kursi lipat dari kayu, ringan dan kuat.', 5, '40x40x80', 'Kayu'),
(3, 'Kursi Gaming', 2100000, 5, 'interior3.jpeg', 'Kursi gaming ergonomis, sandaran tinggi.', 18, '70x70x130', 'PU Leather'),
(3, 'Kursi Direktur', 2500000, 4, 'interior3.jpeg', 'Kursi direktur mewah, bahan kulit sintetis.', 20, '75x75x130', 'PU Leather'),
(3, 'Kursi Cafe Kayu', 800000, 15, 'interior3.jpeg', 'Kursi cafe dari kayu solid.', 8, '45x45x85', 'Kayu'),
(3, 'Kursi Bar Merah', 900000, 9, 'interior3.jpeg', 'Kursi bar warna merah, desain modern.', 9, '40x40x110', 'Besi & Kain'),
(3, 'Kursi Tamu Klasik', 1200000, 7, 'interior3.jpeg', 'Kursi tamu klasik, ukiran cantik.', 12, '60x60x85', 'Kayu'),
(3, 'Kursi Santai Outdoor', 950000, 11, 'interior3.jpeg', 'Kursi santai untuk taman atau balkon.', 8, '70x70x85', 'Plastik');

-- Kategori 4: Lemari
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(4, 'Lemari Pakaian 3 Pintu', 4500000, 8, 'interior4.jpeg', 'Lemari pakaian 3 pintu dengan rak gantung dan laci.', 85, '180x60x200', 'MDF + HPL'),
(4, 'Lemari Serbaguna Minimalis', 2100000, 12, 'interior4.jpeg', 'Lemari serbaguna untuk ruang tamu atau kamar.', 40, '100x40x180', 'MDF'),
(4, 'Lemari Dapur Gantung', 1750000, 10, 'interior4.jpeg', 'Lemari dapur gantung, hemat ruang.', 25, '120x35x60', 'MDF'),
(4, 'Lemari Sepatu Modern', 950000, 15, 'interior4.jpeg', 'Lemari sepatu dengan rak bertingkat.', 18, '80x35x100', 'MDF'),
(4, 'Lemari Buku Kayu', 1600000, 14, 'interior4.jpeg', 'Lemari buku dari kayu mahoni.', 30, '90x35x180', 'Kayu mahoni'),
(4, 'Lemari TV Minimalis', 2200000, 9, 'interior4.jpeg', 'Lemari TV dengan rak penyimpanan.', 35, '150x40x180', 'MDF'),
(4, 'Lemari Pakaian Sliding', 3700000, 7, 'interior4.jpeg', 'Lemari pakaian pintu sliding, hemat tempat.', 60, '160x60x200', 'MDF'),
(4, 'Lemari Dapur Bawah', 1850000, 11, 'interior4.jpeg', 'Lemari dapur bawah, banyak laci.', 28, '120x50x80', 'MDF'),
(4, 'Lemari Pajangan Kaca', 2500000, 6, 'interior4.jpeg', 'Lemari pajangan dengan pintu kaca.', 32, '100x40x180', 'MDF & Kaca'),
(4, 'Lemari Arsip Kantor', 1950000, 13, 'interior4.jpeg', 'Lemari arsip untuk kantor, rak adjustable.', 27, '90x40x180', 'MDF'),
(4, 'Lemari Anak 2 Pintu', 1350000, 16, 'interior4.jpeg', 'Lemari anak 2 pintu, warna ceria.', 22, '80x40x150', 'MDF'),
(4, 'Lemari Serbaguna Putih', 2100000, 12, 'interior4.jpeg', 'Lemari serbaguna warna putih.', 40, '100x40x180', 'MDF'),
(4, 'Lemari Pakaian Minimalis', 3200000, 8, 'interior4.jpeg', 'Lemari pakaian minimalis, desain modern.', 55, '160x60x200', 'MDF'),
(4, 'Lemari Pajangan Kayu', 1800000, 10, 'interior4.jpeg', 'Lemari pajangan dari kayu solid.', 29, '90x35x180', 'Kayu'),
(4, 'Lemari TV Sliding', 2400000, 7, 'interior4.jpeg', 'Lemari TV dengan pintu sliding.', 36, '150x40x180', 'MDF'),
(4, 'Lemari Sepatu Minimalis', 1050000, 15, 'interior4.jpeg', 'Lemari sepatu minimalis, rak banyak.', 19, '80x35x100', 'MDF'),
(4, 'Lemari Arsip Besi', 2150000, 9, 'interior4.jpeg', 'Lemari arsip dari besi, kuat dan awet.', 38, '90x40x180', 'Besi'),
(4, 'Lemari Anak Sliding', 1450000, 11, 'interior4.jpeg', 'Lemari anak pintu sliding.', 23, '80x40x150', 'MDF'),
(4, 'Lemari Serbaguna Krem', 2100000, 12, 'interior4.jpeg', 'Lemari serbaguna warna krem.', 40, '100x40x180', 'MDF'),
(4, 'Lemari Pajangan Modern', 2600000, 8, 'interior4.jpeg', 'Lemari pajangan modern, kombinasi kayu dan kaca.', 33, '100x40x180', 'MDF & Kaca');

-- Kategori 5: Tempat Tidur
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(5, 'Tempat Tidur Minimalis', 3200000, 12, 'interior5.jpg', 'Tempat tidur minimalis dengan headboard elegan.', 55, '200x160x25', 'Kayu pinus'),
(5, 'Tempat Tidur Anak', 2100000, 10, 'interior5.jpg', 'Tempat tidur anak dengan pagar pengaman.', 35, '180x100x25', 'Kayu'),
(5, 'Tempat Tidur Tingkat', 4200000, 7, 'interior5.jpg', 'Tempat tidur tingkat, cocok untuk kamar anak.', 65, '200x100x160', 'Kayu'),
(5, 'Tempat Tidur Queen', 3700000, 8, 'interior5.jpg', 'Tempat tidur queen size, rangka kokoh.', 60, '200x160x30', 'Kayu'),
(5, 'Tempat Tidur King', 4800000, 6, 'interior5.jpg', 'Tempat tidur king size, desain mewah.', 75, '200x180x35', 'Kayu'),
(5, 'Tempat Tidur Lipat', 2500000, 14, 'interior5.jpg', 'Tempat tidur lipat, praktis untuk ruang sempit.', 28, '190x90x25', 'Kayu'),
(5, 'Tempat Tidur Sorong', 2950000, 11, 'interior5.jpg', 'Tempat tidur sorong, hemat ruang.', 38, '200x100x30', 'Kayu'),
(5, 'Tempat Tidur Bayi', 1800000, 9, 'interior5.jpg', 'Tempat tidur bayi dengan pagar aman.', 22, '120x70x90', 'Kayu'),
(5, 'Tempat Tidur Minimalis Putih', 3300000, 10, 'interior5.jpg', 'Tempat tidur minimalis warna putih.', 56, '200x160x25', 'Kayu'),
(5, 'Tempat Tidur Sofa', 3500000, 8, 'interior5.jpg', 'Tempat tidur sofa, multifungsi.', 48, '200x90x40', 'Kain & Kayu'),
(5, 'Tempat Tidur Laci', 3700000, 7, 'interior5.jpg', 'Tempat tidur dengan laci penyimpanan.', 60, '200x160x30', 'Kayu'),
(5, 'Tempat Tidur Minimalis Coklat', 3200000, 12, 'interior5.jpg', 'Tempat tidur minimalis warna coklat.', 55, '200x160x25', 'Kayu'),
(5, 'Tempat Tidur Anak Karakter', 2300000, 10, 'interior5.jpg', 'Tempat tidur anak dengan motif karakter.', 36, '180x100x25', 'Kayu'),
(5, 'Tempat Tidur Tingkat Putih', 4200000, 7, 'interior5.jpg', 'Tempat tidur tingkat warna putih.', 65, '200x100x160', 'Kayu'),
(5, 'Tempat Tidur Queen Abu', 3700000, 8, 'interior5.jpg', 'Tempat tidur queen size warna abu.', 60, '200x160x30', 'Kayu'),
(5, 'Tempat Tidur King Krem', 4800000, 6, 'interior5.jpg', 'Tempat tidur king size warna krem.', 75, '200x180x35', 'Kayu'),
(5, 'Tempat Tidur Lipat Kayu', 2500000, 14, 'interior5.jpg', 'Tempat tidur lipat dari kayu.', 28, '190x90x25', 'Kayu'),
(5, 'Tempat Tidur Sorong Modern', 2950000, 11, 'interior5.jpg', 'Tempat tidur sorong desain modern.', 38, '200x100x30', 'Kayu'),
(5, 'Tempat Tidur Bayi Putih', 1800000, 9, 'interior5.jpg', 'Tempat tidur bayi warna putih.', 22, '120x70x90', 'Kayu'),
(5, 'Tempat Tidur Minimalis Abu', 3300000, 10, 'interior5.jpg', 'Tempat tidur minimalis warna abu.', 56, '200x160x25', 'Kayu');

-- Kategori 6: Dekorasi
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(6, 'Vas Bunga Dekoratif', 250000, 40, 'flower1.jpg', 'Vas bunga dekoratif untuk mempercantik ruangan.', 2, '20x20x35', 'Keramik'),
(6, 'Lukisan Dinding Modern', 600000, 10, 'flower2.avif', 'Lukisan dinding dengan tema modern.', 1.5, '60x80', 'Canvas'),
(6, 'Jam Dinding Unik', 350000, 15, 'planning.jpg', 'Jam dinding desain unik dan minimalis.', 1, '35x35', 'Plastik'),
(6, 'Patung Kayu Artistik', 450000, 8, 'flower1.jpg', 'Patung kayu artistik untuk dekorasi ruang tamu.', 3, '15x15x40', 'Kayu'),
(6, 'Lampu Meja Minimalis', 320000, 12, 'flower2.avif', 'Lampu meja dengan desain minimalis.', 2, '20x20x40', 'Metal & Kaca'),
(6, 'Karpet Motif Geometris', 700000, 10, 'glam1.jpg', 'Karpet motif geometris, warna ceria.', 5, '200x150', 'Polyester'),
(6, 'Bingkai Foto Modern', 150000, 20, 'flower1.jpg', 'Bingkai foto modern, warna hitam.', 0.5, '25x35', 'Kayu'),
(6, 'Tanaman Hias Palsu', 180000, 18, 'flower2.avif', 'Tanaman hias palsu, tampak asli.', 1, '30x30x60', 'Plastik'),
(6, 'Vas Kaca Transparan', 220000, 14, 'flower1.jpg', 'Vas kaca transparan, desain simpel.', 1.2, '18x18x30', 'Kaca'),
(6, 'Lukisan Abstrak', 650000, 9, 'flower2.avif', 'Lukisan abstrak warna-warni.', 1.7, '70x90', 'Canvas'),
(6, 'Jam Dinding Kayu', 370000, 13, 'planning.jpg', 'Jam dinding dari kayu solid.', 1.3, '32x32', 'Kayu'),
(6, 'Patung Keramik', 480000, 7, 'flower1.jpg', 'Patung keramik motif klasik.', 2.5, '12x12x35', 'Keramik'),
(6, 'Lampu Gantung Modern', 950000, 6, 'flower2.avif', 'Lampu gantung gaya modern.', 4, '40x40x60', 'Metal & Kaca'),
(6, 'Karpet Bulu Lembut', 800000, 11, 'glam1.jpg', 'Karpet bulu lembut, nyaman untuk ruang keluarga.', 6, '200x150', 'Polyester'),
(6, 'Bingkai Foto Putih', 170000, 19, 'flower1.jpg', 'Bingkai foto warna putih.', 0.5, '25x35', 'Kayu'),
(6, 'Tanaman Hias Mini', 120000, 22, 'flower2.avif', 'Tanaman hias mini untuk meja kerja.', 0.3, '10x10x20', 'Plastik'),
(6, 'Vas Keramik Motif', 270000, 13, 'flower1.jpg', 'Vas keramik dengan motif etnik.', 1.8, '20x20x35', 'Keramik'),
(6, 'Lukisan Pemandangan', 700000, 8, 'flower2.avif', 'Lukisan pemandangan alam.', 2, '80x100', 'Canvas'),
(6, 'Jam Dinding Vintage', 390000, 10, 'planning.jpg', 'Jam dinding gaya vintage.', 1.1, '34x34', 'Metal'),
(6, 'Patung Modern', 520000, 7, 'flower1.jpg', 'Patung modern, bentuk abstrak.', 2.2, '15x15x40', 'Resin');

-- Kategori 7: Lainnya
INSERT INTO furniture (kategori_id, nama_furniture, harga, stok, gambar_furniture, deskripsi, berat, dimensi, material) VALUES
(7, 'Rak Sepatu Minimalis', 650000, 18, 'interior6.jpg', 'Rak sepatu minimalis, muat banyak pasang.', 8, '80x30x60', 'MDF'),
(7, 'Meja Setrika Lipat', 420000, 15, 'interior7.jpg', 'Meja setrika lipat, praktis dan hemat ruang.', 6, '100x35x80', 'MDF'),
(7, 'Keranjang Laundry', 250000, 20, 'glam1.jpg', 'Keranjang laundry anyaman plastik.', 2, '45x45x60', 'Plastik'),
(7, 'Rak Dinding Kayu', 320000, 14, 'interior6.jpg', 'Rak dinding dari kayu solid.', 3, '60x20x20', 'Kayu'),
(7, 'Meja Lipat Serbaguna', 550000, 12, 'interior7.jpg', 'Meja lipat serbaguna, mudah disimpan.', 7, '90x50x75', 'MDF'),
(7, 'Box Penyimpanan', 180000, 25, 'glam1.jpg', 'Box penyimpanan plastik, warna ceria.', 1, '40x30x25', 'Plastik'),
(7, 'Rak Gantung Serbaguna', 370000, 10, 'interior6.jpg', 'Rak gantung untuk dapur atau kamar mandi.', 2, '50x15x60', 'MDF'),
(7, 'Meja Samping Tempat Tidur', 290000, 16, 'interior7.jpg', 'Meja samping tempat tidur, desain simpel.', 5, '45x45x50', 'Kayu'),
(7, 'Keranjang Anyaman', 210000, 18, 'glam1.jpg', 'Keranjang anyaman dari rotan.', 1.5, '40x40x35', 'Rotan'),
(7, 'Rak Buku Mini', 330000, 13, 'interior6.jpg', 'Rak buku mini, cocok untuk anak-anak.', 3, '60x20x40', 'MDF'),
(7, 'Meja Laptop Portable', 370000, 15, 'interior7.jpg', 'Meja laptop portable, ringan dan praktis.', 4, '60x35x30', 'MDF'),
(7, 'Box Mainan Anak', 200000, 20, 'glam1.jpg', 'Box mainan anak, warna-warni.', 1.2, '50x35x30', 'Plastik'),
(7, 'Rak Dinding Besi', 420000, 11, 'interior6.jpg', 'Rak dinding dari besi, kuat dan awet.', 2.5, '60x20x20', 'Besi'),
(7, 'Meja Lipat Anak', 310000, 17, 'interior7.jpg', 'Meja lipat khusus anak-anak.', 3, '60x40x50', 'MDF'),
(7, 'Keranjang Serbaguna', 230000, 19, 'glam1.jpg', 'Keranjang serbaguna, bisa untuk baju atau mainan.', 1.3, '40x40x35', 'Plastik'),
(7, 'Rak Sepatu Besi', 480000, 12, 'interior6.jpg', 'Rak sepatu dari besi, kapasitas besar.', 9, '80x30x60', 'Besi'),
(7, 'Meja Samping Sofa', 270000, 14, 'interior7.jpg', 'Meja samping sofa, desain minimalis.', 4, '45x45x50', 'Kayu'),
(7, 'Box Penyimpanan Kain', 190000, 21, 'glam1.jpg', 'Box penyimpanan dari kain, mudah dilipat.', 0.8, '40x30x25', 'Kain'),
(7, 'Rak Gantung Besi', 350000, 10, 'interior6.jpg', 'Rak gantung dari besi, untuk dapur.', 2, '50x15x60', 'Besi');

-- =====================================================
-- VIEWS UNTUK REPORTING
-- =====================================================

-- View untuk laporan penjualan
CREATE VIEW v_penjualan AS
SELECT 
    o.order_id,
    o.nomor_order,
    u.nama as nama_customer,
    o.total_harga,
    o.status_order,
    o.tanggal_order,
    COUNT(do.detail_id) as jumlah_item
FROM orders o
JOIN user u ON o.user_id = u.user_id
LEFT JOIN detail_order do ON o.order_id = do.order_id
GROUP BY o.order_id;

-- View untuk laporan furniture terlaris
CREATE VIEW v_furniture_terlaris AS
SELECT 
    f.furniture_id,
    f.nama_furniture,
    k.nama_kategori,
    f.harga,
    f.stok,
    COUNT(do.detail_id) as total_terjual,
    SUM(do.jumlah) as jumlah_unit_terjual
FROM furniture f
JOIN kategori k ON f.kategori_id = k.kategori_id
LEFT JOIN detail_order do ON f.furniture_id = do.furniture_id
LEFT JOIN orders o ON do.order_id = o.order_id
WHERE o.status_order IN ('delivered', 'shipped')
GROUP BY f.furniture_id
ORDER BY total_terjual DESC;

-- View untuk laporan review
CREATE VIEW v_review_furniture AS
SELECT 
    r.review_id,
    f.nama_furniture,
    u.nama as nama_reviewer,
    r.rating,
    r.komentar,
    r.is_verified,
    r.created_at
FROM review r
JOIN furniture f ON r.furniture_id = f.furniture_id
JOIN user u ON r.user_id = u.user_id
ORDER BY r.created_at DESC;

-- =====================================================
-- STORED PROCEDURES
-- =====================================================

-- Procedure untuk menambah item ke keranjang
DELIMITER //
CREATE PROCEDURE AddToCart(
    IN p_user_id INT,
    IN p_furniture_id INT,
    IN p_jumlah INT
)
BEGIN
    DECLARE v_harga DECIMAL(10,2);
    DECLARE v_stok INT;
    DECLARE v_existing_jumlah INT DEFAULT 0;
    
    -- Ambil harga dan stok furniture
    SELECT harga, stok INTO v_harga, v_stok
    FROM furniture 
    WHERE furniture_id = p_furniture_id AND is_active = TRUE;
    
    -- Cek stok tersedia
    IF v_stok < p_jumlah THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Stok tidak mencukupi';
    END IF;
    
    -- Cek apakah sudah ada di keranjang
    SELECT jumlah INTO v_existing_jumlah
    FROM keranjang 
    WHERE user_id = p_user_id AND furniture_id = p_furniture_id;
    
    IF v_existing_jumlah > 0 THEN
        -- Update jumlah jika sudah ada
        UPDATE keranjang 
        SET jumlah = jumlah + p_jumlah,
            subtotal = (jumlah + p_jumlah) * harga_satuan,
            updated_at = NOW()
        WHERE user_id = p_user_id AND furniture_id = p_furniture_id;
    ELSE
        -- Insert baru jika belum ada
        INSERT INTO keranjang (user_id, furniture_id, jumlah, harga_satuan, subtotal)
        VALUES (p_user_id, p_furniture_id, p_jumlah, v_harga, p_jumlah * v_harga);
    END IF;
END//
DELIMITER ;

-- Procedure untuk checkout
DELIMITER //
CREATE PROCEDURE Checkout(
    IN p_user_id INT,
    IN p_metode_pembayaran ENUM('transfer_bank', 'cod', 'e_wallet'),
    IN p_alamat_pengiriman TEXT,
    IN p_nama_penerima VARCHAR(100),
    IN p_no_hp_penerima VARCHAR(15),
    IN p_catatan TEXT
)
BEGIN
    DECLARE v_order_id INT;
    DECLARE v_total_harga DECIMAL(10,2);
    
    -- Hitung total harga dari keranjang
    SELECT COALESCE(SUM(subtotal), 0) INTO v_total_harga
    FROM keranjang 
    WHERE user_id = p_user_id;
    
    IF v_total_harga = 0 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Keranjang kosong';
    END IF;
    
    -- Buat order baru
    INSERT INTO orders (user_id, total_harga, metode_pembayaran, alamat_pengiriman, nama_penerima, no_hp_penerima, catatan)
    VALUES (p_user_id, v_total_harga, p_metode_pembayaran, p_alamat_pengiriman, p_nama_penerima, p_no_hp_penerima, p_catatan);
    
    SET v_order_id = LAST_INSERT_ID();
    
    -- Pindahkan item dari keranjang ke detail order
    INSERT INTO detail_order (order_id, furniture_id, jumlah, harga_satuan, subtotal)
    SELECT v_order_id, furniture_id, jumlah, harga_satuan, subtotal
    FROM keranjang 
    WHERE user_id = p_user_id;
    
    -- Hapus keranjang user
    DELETE FROM keranjang WHERE user_id = p_user_id;
    
    SELECT v_order_id as order_id;
END//
DELIMITER ;

-- =====================================================
-- FUNCTIONS
-- =====================================================

-- Function untuk menghitung rating rata-rata furniture
DELIMITER //
CREATE FUNCTION GetAverageRating(p_furniture_id INT) 
RETURNS DECIMAL(3,2)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE v_avg_rating DECIMAL(3,2);
    
    SELECT COALESCE(AVG(rating), 0) INTO v_avg_rating
    FROM review 
    WHERE furniture_id = p_furniture_id AND is_verified = TRUE;
    
    RETURN v_avg_rating;
END//
DELIMITER ;

-- Function untuk menghitung total penjualan furniture
DELIMITER //
CREATE FUNCTION GetTotalSales(p_furniture_id INT) 
RETURNS DECIMAL(10,2)
READS SQL DATA
DETERMINISTIC
BEGIN
    DECLARE v_total_sales DECIMAL(10,2);
    
    SELECT COALESCE(SUM(do.subtotal), 0) INTO v_total_sales
    FROM detail_order do
    JOIN orders o ON do.order_id = o.order_id
    WHERE do.furniture_id = p_furniture_id 
    AND o.status_order IN ('delivered', 'shipped');
    
    RETURN v_total_sales;
END//
DELIMITER ;

-- =====================================================
-- EVENTS UNTUK MAINTENANCE
-- =====================================================

-- Event untuk update status user offline
DELIMITER //
CREATE EVENT update_user_status_offline
ON SCHEDULE EVERY 5 MINUTE
DO
BEGIN
    UPDATE user 
    SET status = 'offline' 
    WHERE last_activity < DATE_SUB(NOW(), INTERVAL 30 MINUTE);
END//
DELIMITER ;

-- Event untuk cleanup activity log lama
DELIMITER //
CREATE EVENT cleanup_activity_log
ON SCHEDULE EVERY 1 DAY
STARTS CURRENT_TIMESTAMP
DO
BEGIN
    DELETE FROM activity_log 
    WHERE created_at < DATE_SUB(NOW(), INTERVAL 1 YEAR);
END//
DELIMITER ;

-- =====================================================
-- GRANTS DAN PERMISSIONS
-- =====================================================

-- Buat user untuk aplikasi (ganti password sesuai kebutuhan)
-- CREATE USER 'arunika_app'@'localhost' IDENTIFIED BY 'password_secure_123';
-- GRANT SELECT, INSERT, UPDATE, DELETE ON arunika_furniture.* TO 'arunika_app'@'localhost';
-- FLUSH PRIVILEGES;

-- =====================================================
-- KOMENTAR AKHIR
-- =====================================================

/*
Database setup selesai!

Fitur yang tersedia:
1. User management dengan status online/offline
2. Admin management dengan role-based access
3. Kategori furniture dengan icon
4. Furniture management dengan stok
5. Keranjang belanja
6. Order management dengan status tracking
7. Review system dengan verifikasi
8. Activity logging
9. Optimized indexes
10. Triggers untuk automation
11. Stored procedures untuk business logic
12. Views untuk reporting
13. Functions untuk calculations
14. Events untuk maintenance

Untuk menggunakan database ini:
1. Import file ini ke MySQL/MariaDB
2. Update konfigurasi database di config/connect.php
3. Pastikan direktori assets/img/furniture/ sudah dibuat
4. Login admin default: username=admin, password=password
*/

-- DATA SAMPLE DISKON
-- Diskon persen dan nominal untuk beberapa produk furniture
INSERT INTO diskon (furniture_id, tipe, nilai, tanggal_mulai, tanggal_selesai, is_active, keterangan) VALUES
(1, 'persen', 20, NOW(), DATE_ADD(NOW(), INTERVAL 7 DAY), 1, 'Promo Minggu Ini'),
(2, 'nominal', 500000, NOW(), DATE_ADD(NOW(), INTERVAL 3 DAY), 1, 'Flash Sale'),
(5, 'persen', 15, NOW(), DATE_ADD(NOW(), INTERVAL 5 DAY), 1, 'Diskon Spesial'),
(10, 'nominal', 250000, NOW(), DATE_ADD(NOW(), INTERVAL 2 DAY), 1, 'Promo Kilat'),
(15, 'persen', 10, NOW(), DATE_ADD(NOW(), INTERVAL 10 DAY), 1, 'Diskon Lebaran'),
(22, 'persen', 25, NOW(), DATE_ADD(NOW(), INTERVAL 4 DAY), 1, 'Flash Sale Sofa'),
(30, 'nominal', 100000, NOW(), DATE_ADD(NOW(), INTERVAL 6 DAY), 1, 'Promo Akhir Pekan'); 

INSERT INTO orders 
(user_id, nomor_order, total_harga, status_order, metode_pembayaran, alamat_pengiriman, nama_penerima, no_hp_penerima, catatan, tanggal_order, tanggal_konfirmasi, tanggal_pengiriman, tanggal_diterima)
VALUES
(1, 'ORD-20240601-0001', 3500000, 'pending', 'transfer_bank', 'Jl. Melati No. 10, Jakarta', 'Fajar Andika', '081234567890', 'Tolong kirim siang hari', '2024-06-01 09:15:00', NULL, NULL, NULL),
(2, 'ORD-20240601-0002', 2800000, 'confirmed', 'e_wallet', 'Jl. Kenanga No. 5, Bandung', 'Rina Lestari', '082233445566', '', '2024-06-01 10:30:00', '2024-06-01 11:00:00', NULL, NULL),
(3, 'ORD-20240602-0003', 1200000, 'processing', 'cod', 'Jl. Mawar No. 7, Surabaya', 'Maria Lestari', '083344556677', 'Rumah warna biru', '2024-06-02 08:45:00', '2024-06-02 09:00:00', '2024-06-02 13:00:00', NULL),
(1, 'ORD-20240603-0004', 4500000, 'shipped', 'transfer_bank', 'Jl. Anggrek No. 12, Jakarta', 'Fajar Andika', '081234567890', '', '2024-06-03 14:20:00', '2024-06-03 15:00:00', '2024-06-04 09:00:00', NULL),
(2, 'ORD-20240604-0005', 3200000, 'delivered', 'e_wallet', 'Jl. Dahlia No. 3, Bandung', 'Rina Lestari', '082233445566', 'Kirim ke lantai 2', '2024-06-04 11:10:00', '2024-06-04 12:00:00', '2024-06-04 16:00:00', '2024-06-05 10:00:00'),
(3, 'ORD-20240605-0006', 850000, 'cancelled', 'cod', 'Jl. Flamboyan No. 8, Surabaya', 'Maria Lestari', '083344556677', 'Batal, salah alamat', '2024-06-05 09:00:00', NULL, NULL, NULL);