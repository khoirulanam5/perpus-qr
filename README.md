# 📚 Sistem Perpustakaan Berbasis QR Code

Sistem informasi perpustakaan modern dengan pemanfaatan **QR Code** untuk proses peminjaman dan pengembalian buku, serta dilengkapi dengan fitur **EDD (Earliest Due Date)** untuk pengelolaan antrian peminjaman secara lebih efektif. Sistem dibangun menggunakan **CodeIgniter 4**, **MySQL**, dan **Frontend HTML, CSS, JS, Bootstrap**.

---

## 🚀 Teknologi yang Digunakan

* **Framework Backend:** CodeIgniter 4
* **Database:** MySQL
* **Frontend:** HTML, CSS, JavaScript, Bootstrap
* **QR Code Generator & Scanner**
* **Metode Penjadwalan:** Earliest Due Date (EDD)

---

## 👥 Role Pengguna

### 1. **Admin**

* Mengelola data buku
* Mengelola anggota
* Mengelola transaksi peminjaman & pengembalian
* Mencetak QR Code buku
* Pengaturan sistem dan laporan

### 2. **Kepala Perpustakaan**

* Melihat laporan lengkap perpustakaan
* Monitoring peminjaman, keterlambatan, dan statistik
* Analisis penggunaan EDD

### 3. **Anggota**

* Scan QR untuk peminjaman/pengembalian
* Melihat riwayat pinjam
* Melihat status buku
* Notifikasi jatuh tempo

---

## 🧩 Fitur Utama

### 📌 **QR Code System**

* QR pada setiap buku
* Scan buku untuk memulai peminjaman
* Scan ulang saat pengembalian

### 🔢 **Metode Earliest Due Date (EDD)**

* Pengelolaan prioritas dalam peminjaman
* Menentukan antrian peminjaman berdasarkan tanggal jatuh tempo
* Mengurangi risiko keterlambatan dan konflik antrian

### 📚 **Manajemen Buku**

* CRUD data buku
* Kategori buku
* Cetak QR otomatis

### 👤 **Manajemen Anggota**

* Pendaftaran anggota
* Kartu anggota dengan QR (opsional)

### 🔄 **Transaksi Peminjaman & Pengembalian**

* Proses cepat menggunakan scan QR
* Validasi otomatis
* Notifikasi jatuh tempo dan denda (opsional)

### 📊 **Laporan Lengkap**

* Laporan peminjaman
* Buku paling sering dipinjam
* Buku sedang dipinjam
* Keterlambatan

### 🎨 **Landing Page**

* Informasi perpustakaan
* Katalog buku
* Form login anggota & admin

---

## 🛠️ Instalasi & Setup

1. Clone Repository

```
git clone https://github.com/username/perpustakaan-qr.git
```

2. Install dependency CodeIgniter 4 (jika menggunakan Composer)

```
composer install
```

3. Buat database MySQL, lalu import `database.sql`
4. Konfigurasi `.env` atau `app/Config/Database.php`

```
hostname = localhost
username = root
password = ''
database = perpustakaan_qr
```

5. Jalankan Project

```
php spark serve
```

Akses melalui:

```
http://localhost:8080
```

---

## 📂 Struktur Direktori Utama

```
app/
├── Controllers/
├── Models/
├── Views/
public/
├── assets/
│   ├── css/
│   ├── js/
│   └── img/
database.sql
README.md
```

---

## 📄 Lisensi

Private / Open Source — sesuaikan kebutuhan.

---

## 📞 Kontak

Untuk pengembangan lebih lanjut, silakan hubungi developer.

---
