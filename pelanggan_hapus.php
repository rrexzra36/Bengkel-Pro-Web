<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Hapus data pelanggan berdasarkan ID
    $sql = "DELETE FROM pelanggan WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data pelanggan berhasil dihapus.";
    } else {
        $_SESSION['message'] = "Gagal menghapus data. Pelanggan mungkin terkait dengan data lain (kendaraan/servis).";
    }
} else {
    $_SESSION['message'] = "ID pelanggan tidak valid.";
}

header("Location: pelanggan_data.php");
exit();
