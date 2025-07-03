<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $sql = "DELETE FROM servis WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['message'] = "Data servis berhasil dihapus.";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal menghapus data servis.";
        $_SESSION['message_type'] = "error";
    }
} else {
    $_SESSION['message'] = "ID servis tidak valid.";
    $_SESSION['message_type'] = "warning";
}

header("Location: servis_data.php");
exit();
