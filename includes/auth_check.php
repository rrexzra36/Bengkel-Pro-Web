<?php // File: includes/auth_check.php
// Cek dan mulai sesi hanya jika belum ada (praktik terbaik)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah user sudah login atau belum
// File ini sekarang aman dan tidak akan menyebabkan error
if (!isset($_SESSION['user_id'])) {
    // Jika belum, redirect ke halaman login
    header("Location: login.php");
    exit();
}

// Anda juga bisa menambahkan pengecekan role di sini jika diperlukan
// Contoh:
// if ($_SESSION['role'] !== 'admin') {
//     die("Akses ditolak. Anda bukan admin.");
// }

?>