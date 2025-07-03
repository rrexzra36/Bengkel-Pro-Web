<?php
/**
 * File koneksi.php
 * Berfungsi untuk menghubungkan proyek PHP dengan database MySQL.
 */

// Konfigurasi Database
$db_host = 'localhost';     // Biasanya 'localhost'
$db_user = 'root';          // User default XAMPP
$db_pass = '';              // Password default XAMPP (kosong)
$db_name = 'bengkel_db';    // Nama database yang sudah dibuat

// Membuat koneksi
$koneksi = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

// Cek koneksi
// Jika gagal, hentikan program dan tampilkan pesan error
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}

// Mengatur zona waktu default
date_default_timezone_set('Asia/Jakarta');

// Jika koneksi berhasil, file ini bisa di-include di file lain
// tanpa menampilkan output apa pun.
?>
