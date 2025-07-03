<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header("Location: servis_data.php"); exit(); }

// Ambil data servis yang akan diedit
$sql = "SELECT s.*, k.plat_nomor, p.nama AS nama_pelanggan
        FROM servis s 
        JOIN kendaraan k ON s.kendaraan_id = k.id
        JOIN pelanggan p ON k.pelanggan_id = p.id
        WHERE s.id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$servis = mysqli_fetch_assoc($result);
if (!$servis) {
    $_SESSION['message'] = "Data servis tidak ditemukan!";
    $_SESSION['message_type'] = "error";
    header("Location: servis_data.php"); exit();
}

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $biaya = str_replace('.', '', $_POST['biaya']); // Hapus titik dari format ribuan
    $tanggal_selesai = !empty($_POST['tanggal_selesai']) ? $_POST['tanggal_selesai'] : NULL;
    $keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan']);

    $sql_update = "UPDATE servis SET status = ?, biaya = ?, tanggal_selesai = ?, keluhan = ? WHERE id = ?";
    $stmt_update = mysqli_prepare($koneksi, $sql_update);
    mysqli_stmt_bind_param($stmt_update, "sdssi", $status, $biaya, $tanggal_selesai, $keluhan, $id);
    if (mysqli_stmt_execute($stmt_update)) {
        $_SESSION['message'] = "Data servis berhasil diperbarui!";
        $_SESSION['message_type'] = "success";
    } else {
        $_SESSION['message'] = "Gagal memperbarui data.";
        $_SESSION['message_type'] = "error";
    }
    header("Location: servis_data.php");
    exit();
}

$page_title = 'Edit Data Servis';
include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4">Edit Data Servis</h2>
            <div class="card">
                <div class="card-body">
                    <form action="servis_edit.php?id=<?php echo $id; ?>" method="POST">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label class="form-label">Pelanggan</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($servis['nama_pelanggan']); ?>" disabled>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Kendaraan (Plat Nomor)</label>
                                <input type="text" class="form-control" value="<?php echo htmlspecialchars($servis['plat_nomor']); ?>" disabled>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="keluhan" class="form-label">Keluhan</label>
                            <textarea class="form-control" id="keluhan" name="keluhan" rows="3" required><?php echo htmlspecialchars($servis['keluhan']); ?></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="status" class="form-label">Status Pengerjaan</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="Dikerjakan" <?php echo ($servis['status'] == 'Dikerjakan') ? 'selected' : ''; ?>>Dikerjakan</option>
                                    <option value="Menunggu Sparepart" <?php echo ($servis['status'] == 'Menunggu Sparepart') ? 'selected' : ''; ?>>Menunggu Sparepart</option>
                                    <option value="Selesai" <?php echo ($servis['status'] == 'Selesai') ? 'selected' : ''; ?>>Selesai</option>
                                    <option value="Dibatalkan" <?php echo ($servis['status'] == 'Dibatalkan') ? 'selected' : ''; ?>>Dibatalkan</option>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="biaya" class="form-label">Total Biaya (Rp)</label>
                                <input type="text" class="form-control" id="biaya" name="biaya" value="<?php echo number_format($servis['biaya'], 0, ',', '.'); ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'')">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tanggal_selesai" class="form-label">Tanggal Selesai</label>
                                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?php echo htmlspecialchars($servis['tanggal_selesai']); ?>">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Update</button>
                        <a href="servis_data.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
