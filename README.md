# 🛒 POS & Inventory Management System (Laravel 10)

![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5.3-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-Database-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

Sistem Informasi **Point of Sale (POS / Kasir)** dan **Manajemen Inventaris Barang** berbasis web yang dirancang untuk mengelola stok barang, transaksi pembelian dari pemasok (*Stock In*), transaksi penjualan kasir (*Stock Out*), serta analisis keuangan harian/bulanan secara *real-time*.

Aplikasi ini dikembangkan sebagai tugas **Ujian Tengah Semester (UTS)** untuk mendemonstrasikan implementasi arsitektur MVC, relasi database, dan antarmuka pengguna yang responsif.

---

## 📸 Tampilan Utama Sistem

* **Dashboard Analitik:** Menyajikan ringkasan statistik, grafik tren penjualan 7 hari terakhir, dan indikator stok kritis.
* **Kasir Penjualan:** Antarmuka responsif dengan keranjang belanja multi-item dan pemotongan stok otomatis.
* **Sidebar Navigasi Modern:** Navigasi tersentralisasi dengan pembedaan tampilan peran pengguna (*Admin* vs *Staff Kasir*).

---

## 🌟 Fitur-Fitur Utama

### 1. 📊 Dashboard & Analisis Data
* **Widget Statistik Real-time:** Menampilkan total produk, akumulasi penjualan hari ini, penjualan bulan ini, dan total nota transaksi.
* **Grafik Penjualan Interaktif:** Visualisasi tren pendapatan 7 hari terakhir menggunakan modul Chart.js.
* **Alert Stok Kritis (Low Stock Alert):** Deteksi otomatis dan peringatan visual untuk produk dengan jumlah stok $\le 10$ item.

### 2. 📦 Manajemen Inventaris & Pemasok
* **Katalog Produk & Kategori:** Pengelolaan data barang lengkap dengan kode unik, nama, kategori, harga jual, dan stok sisa.
* **Manajemen Pemasok (Supplier):** Modul CRUD lengkap (Tambah, Lihat, Edit, Hapus) untuk mengelola entitas supplier.
* **Pembelian Barang (Stock In):** 
  * Pencatatan stok masuk dari supplier.
  * Otomatis menambah jumlah kuantitas (*stock*) produk terkait.
  * Riwayat transaksi pembelian yang dilengkapi rincian item nota.

### 3. 💳 Kasir & Penjualan (Stock Out)
* **Multi-Item Shopping Cart:** Penambahan beberapa jenis produk sekaligus dalam satu sesi transaksi.
* **Row-Level Cancellation (Partial Void):** Fitur untuk menghapus item individual dari keranjang sebelum dilakukan konfirmasi bayar.
* **Validasi Audit Integrity:** Pemotongan stok otomatis saat transaksi berhasil dikonfirmasi (`COMPLETED`).

---

## 🗄️ Struktur Basis Data (Database Architecture)

Aplikasi ini menggunakan basis data relasional MySQL dengan entitas utama berikut:

| Nama Tabel | Fungsi Utama | Relasi Kunci |
| :--- | :--- | :--- |
| `users` | Mengelola data pengguna & hak akses (*role*) | - |
| `categories` | Pengelompokan kategori barang | One-to-Many ke `products` |
| `suppliers` | Data pemasok/distributor barang | One-to-Many ke `purchases` |
| `products` | Katalog barang dan jumlah stok tersisa | BelongsTo