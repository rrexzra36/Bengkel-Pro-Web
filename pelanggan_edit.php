<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) {
    header("Location: pelanggan_data.php"); exit();
}

// Ambil data pelanggan yang akan diedit
$sql = "SELECT * FROM pelanggan WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$pelanggan = mysqli_fetch_assoc($result);
if (!$pelanggan) {
    $_SESSION['message'] = "Pelanggan tidak ditemukan!";
    $_SESSION['message_type'] = "error";
    header("Location: pelanggan_data.php"); exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    if (!empty($nama) && !empty($no_hp) && !empty($alamat)) {
        $sql_update = "UPDATE pelanggan SET nama = ?, no_hp = ?, alamat = ? WHERE id = ?";
        $stmt_update = mysqli_prepare($koneksi, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "sssi", $nama, $no_hp, $alamat, $id);
        if (mysqli_stmt_execute($stmt_update)) {
            $_SESSION['message'] = "Data pelanggan berhasil diperbarui!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal memperbarui data.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Semua kolom wajib diisi!";
        $_SESSION['message_type'] = "warning";
    }
    header("Location: pelanggan_data.php");
    exit();
}

$page_title = 'Edit Pelanggan';
include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4">Edit Data Pelanggan</h2>
            <div class="card">
                <div class="card-body">
                    <form action="pelanggan_edit.php?id=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($pelanggan['nama']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" value="<?php echo htmlspecialchars($pelanggan['no_hp']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required><?php echo htmlspecialchars($pelanggan['alamat']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Update</button>
                        <a href="pelanggan_data.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
