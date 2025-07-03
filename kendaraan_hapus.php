<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Hapus data kendaraan berdasarkan ID
    $sql = "DELETE FROM kendaraan WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data kendaraan berhasil dihapus.";
        $_SESSION['message_type'] = "success";
    } else {
        // Error ini biasanya terjadi karena ada foreign key constraint (data servis terkait)
        $_SESSION['message'] = "Gagal menghapus. Kendaraan ini memiliki riwayat servis.";
        $_SESSION['message_type'] = "error";
    }
} else {
    $_SESSION['message'] = "ID kendaraan tidak valid.";
    $_SESSION['message_type'] = "warning";
}

header("Location: kendaraan_data.php");
exit();
