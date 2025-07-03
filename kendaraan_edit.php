<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id <= 0) { header("Location: kendaraan_data.php"); exit(); }

// Ambil data kendaraan yang akan diedit
$sql_kendaraan_edit = "SELECT * FROM kendaraan WHERE id = ?";
$stmt_kendaraan = mysqli_prepare($koneksi, $sql_kendaraan_edit);
mysqli_stmt_bind_param($stmt_kendaraan, "i", $id);
mysqli_stmt_execute($stmt_kendaraan);
$result_kendaraan_edit = mysqli_stmt_get_result($stmt_kendaraan);
$kendaraan = mysqli_fetch_assoc($result_kendaraan_edit);
if (!$kendaraan) {
    $_SESSION['message'] = "Kendaraan tidak ditemukan!";
    $_SESSION['message_type'] = "error";
    header("Location: kendaraan_data.php"); exit();
}

// Ambil data semua pelanggan untuk dropdown
$sql_pelanggan = "SELECT id, nama FROM pelanggan ORDER BY nama ASC";
$result_pelanggan = mysqli_query($koneksi, $sql_pelanggan);

// Proses update data
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelanggan_id = (int)$_POST['pelanggan_id'];
    $plat_nomor = mysqli_real_escape_string($koneksi, $_POST['plat_nomor']);
    $merk = mysqli_real_escape_string($koneksi, $_POST['merk']);
    $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);

    if (!empty($pelanggan_id) && !empty($plat_nomor) && !empty($merk) && !empty($jenis) && !empty($tahun)) {
        $sql_update = "UPDATE kendaraan SET pelanggan_id = ?, plat_nomor = ?, merk = ?, jenis = ?, tahun = ? WHERE id = ?";
        $stmt_update = mysqli_prepare($koneksi, $sql_update);
        mysqli_stmt_bind_param($stmt_update, "issssi", $pelanggan_id, $plat_nomor, $merk, $jenis, $tahun, $id);
        if (mysqli_stmt_execute($stmt_update)) {
            $_SESSION['message'] = "Data kendaraan berhasil diperbarui!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal memperbarui data. Plat nomor mungkin sudah ada.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Semua kolom wajib diisi!";
        $_SESSION['message_type'] = "warning";
    }
    header("Location: kendaraan_data.php");
    exit();
}

$page_title = 'Edit Kendaraan';
include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4">Edit Data Kendaraan</h2>
            <div class="card">
                <div class="card-body">
                    <form action="kendaraan_edit.php?id=<?php echo $id; ?>" method="POST">
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pemilik Kendaraan</label>
                            <select class="form-select" id="pelanggan_id" name="pelanggan_id" required>
                                <option value="">-- Pilih Pelanggan --</option>
                                <?php mysqli_data_seek($result_pelanggan, 0); // Reset pointer result set ?>
                                <?php while ($pelanggan_option = mysqli_fetch_assoc($result_pelanggan)): ?>
                                    <option value="<?php echo $pelanggan_option['id']; ?>" <?php echo ($pelanggan_option['id'] == $kendaraan['pelanggan_id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($pelanggan_option['nama']); ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="plat_nomor" class="form-label">Plat Nomor</label>
                            <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" value="<?php echo htmlspecialchars($kendaraan['plat_nomor']); ?>" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="merk" class="form-label">Merk Kendaraan</label>
                                <input type="text" class="form-control" id="merk" name="merk" value="<?php echo htmlspecialchars($kendaraan['merk']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jenis" class="form-label">Jenis/Model Kendaraan</label>
                                <input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo htmlspecialchars($kendaraan['jenis']); ?>" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" min="1900" max="<?php echo date('Y') + 1; ?>" value="<?php echo htmlspecialchars($kendaraan['tahun']); ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Update</button>
                        <a href="kendaraan_data.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
