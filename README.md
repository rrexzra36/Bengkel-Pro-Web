# Sistem Informasi Manajemen Bengkel (Bengkel Pro)

<!-- ![Bengkel Pro Dashboard](https://i.imgur.com/your-dashboard-image.png)
*<p align="center">Tampilan Halaman Dashboard</p>* -->

## 📝 Deskripsi Proyek
**Bengkel Pro** adalah aplikasi web sederhana yang dirancang untuk membantu pemilik bengkel dalam mengelola data operasional sehari-hari. Aplikasi ini mencakup manajemen data pelanggan, kendaraan, riwayat servis, serta sistem otentikasi untuk admin dan staf. Proyek ini dibangun menggunakan PHP native dan MySQL dengan antarmuka yang modern dan responsif berkat Bootstrap 5.

---

## ✨ Fitur Utama
- **Login & Otentikasi**:
  - Sistem login yang aman untuk pengguna (admin/staff).
  - Halaman registrasi untuk pengguna baru (default sebagai staff).
  - Halaman profil untuk mengubah nama dan kata sandi.
  - Proteksi halaman (hanya bisa diakses setelah login).

- **Dashboard Informatif**:
  - Menampilkan ringkasan data penting dalam bentuk kartu (card) yang menarik.
  - Ringkasan mencakup total pelanggan, total kendaraan, jumlah servis yang sedang dikerjakan, dan jumlah servis yang telah selesai.

- **Manajemen Data (CRUD)**:
  - **Data Pelanggan**: Tambah, lihat, edit, dan hapus data pelanggan (Nama, No. HP, Alamat).
  - **Data Kendaraan**: Tambah, lihat, edit, dan hapus data kendaraan (Plat Nomor, Merk, Jenis, Tahun) dengan relasi ke data pelanggan.
  - **Data Servis**: Tambah, lihat, edit, dan hapus data servis (Tanggal Masuk, Keluhan, Status, Biaya) dengan relasi ke data kendaraan.

- **Antarmuka Pengguna Modern**:
  - Tampilan yang bersih, modern, dan sepenuhnya responsif.
  - Tabel data canggih dengan fitur **pencarian, pengurutan, dan paginasi** menggunakan library **DataTables**.
  - Notifikasi dan dialog konfirmasi yang elegan menggunakan **SweetAlert2**, menggantikan `alert()` bawaan browser.
  - Navigasi yang mudah dengan sidebar dan navbar yang intuitif.
  - Ikon yang informatif dari **Bootstrap Icons**.
  - Fitur *toggle* untuk melihat/menyembunyikan kata sandi.

---

## 🛠️ Teknologi yang Digunakan
- **Backend**: PHP 7.4+
- **Database**: MySQL (dikelola melalui phpMyAdmin)
- **Frontend**:
  - HTML5
  - CSS3
  - JavaScript
- **Framework & Library**:
  - **Bootstrap 5.3**: Untuk layout responsif dan komponen UI.
  - **jQuery**: Sebagai dependensi untuk DataTables.
  - **DataTables**: Untuk membuat tabel data yang interaktif.
  - **SweetAlert2**: Untuk notifikasi dan dialog konfirmasi yang modern.
  - **Bootstrap Icons**: Untuk ikonografi yang konsisten.

---

## 🚀 Cara Instalasi dan Menjalankan Proyek

Untuk menjalankan proyek ini di lingkungan lokal, ikuti langkah-langkah berikut:

1.  **Prasyarat**:
    - Pastikan sudah menginstal web server seperti **XAMPP** atau **WAMP**.
    - Nyalakan service **Apache** dan **MySQL** dari panel kontrol XAMPP.

2.  **Clone atau Unduh Proyek**:
    - Clone repository ini ke dalam folder `htdocs` di direktori instalasi XAMPP.
      ```bash
      git clone [URL_REPOSITORY] C:\xampp\htdocs\bengkel-pro
      ```
    - Atau, unduh file ZIP dan ekstrak ke `C:\xampp\htdocs\bengkel-pro`.

3.  **Setup Database**:
    - Buka **phpMyAdmin** (`http://localhost/phpmyadmin`).
    - Buat database baru dengan nama `bengkel_db`.
    - Pilih database `bengkel_db`, lalu klik tab **Import**.
    - Pilih file `bengkel_db.sql` yang ada di dalam folder proyek.
    - Klik "Go" atau "Kirim" untuk mengimpor struktur tabel dan data awal.

4.  **Konfigurasi Koneksi**:
    - Buka file `includes/koneksi.php`.
    - Sesuaikan konfigurasi database jika diperlukan (secara default sudah diatur untuk XAMPP standar).
      ```php
      $db_host = 'localhost';
      $db_user = 'root';
      $db_pass = ''; // Kosongkan jika tidak ada password
      $db_name = 'bengkel_db';
      ```

5.  **Jalankan Proyek**:
    - Buka browser dan akses URL:
      ```
      http://localhost/bengkel-pro/
      ```
    - Anda akan diarahkan ke halaman login.

---

## 🔐 Akun Default
Anda bisa langsung login menggunakan akun admin yang sudah tersedia:
- **Username**: `ezra`
- **Password**: `123`

---

## 📁 Struktur Folder Proyek
Struktur folder diatur agar rapi dan mudah dikelola.

bengkel-pro/
├── css/
│   └── style.css                
├── includes/
│   ├── auth_check.php           
│   ├── footer.php               
│   ├── header.php               
│   ├── koneksi.php              
│   ├── navbar.php               
│   └── sidebar.php              
├── js/
│   └── script.js                
├── login.php                    
├── register.php                 
├── logout.php                   
├── profil.php                   
├── index.php                    
├── pelanggan_data.php           
├── pelanggan_tambah.php         
├── pelanggan_edit.php           
├── pelanggan_hapus.php          
├── kendaraan_data.php           
├── ...                          
└── bengkel_db.sql               
