<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

// Ambil data semua pelanggan untuk dropdown
$sql_pelanggan = "SELECT id, nama FROM pelanggan ORDER BY nama ASC";
$result_pelanggan = mysqli_query($koneksi, $sql_pelanggan);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pelanggan_id = (int)$_POST['pelanggan_id'];
    $plat_nomor = mysqli_real_escape_string($koneksi, $_POST['plat_nomor']);
    $merk = mysqli_real_escape_string($koneksi, $_POST['merk']);
    $jenis = mysqli_real_escape_string($koneksi, $_POST['jenis']);
    $tahun = mysqli_real_escape_string($koneksi, $_POST['tahun']);

    if (!empty($pelanggan_id) && !empty($plat_nomor) && !empty($merk) && !empty($jenis) && !empty($tahun)) {
        $sql = "INSERT INTO kendaraan (pelanggan_id, plat_nomor, merk, jenis, tahun) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "issss", $pelanggan_id, $plat_nomor, $merk, $jenis, $tahun);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Kendaraan baru berhasil ditambahkan!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal menambahkan data. Plat nomor mungkin sudah ada.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Semua kolom wajib diisi!";
        $_SESSION['message_type'] = "warning";
    }
    header("Location: kendaraan_data.php");
    exit();
}

$page_title = 'Tambah Kendaraan';
include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4">Tambah Kendaraan Baru</h2>
            <div class="card">
                <div class="card-body">
                    <form action="kendaraan_tambah.php" method="POST">
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pemilik Kendaraan</label>
                            <select class="form-select" id="pelanggan_id" name="pelanggan_id" required>
                                <option value="" selected disabled>-- Pilih Pelanggan --</option>
                                <?php while ($pelanggan = mysqli_fetch_assoc($result_pelanggan)): ?>
                                    <option value="<?php echo $pelanggan['id']; ?>"><?php echo htmlspecialchars($pelanggan['nama']); ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="plat_nomor" class="form-label">Plat Nomor</label>
                            <input type="text" class="form-control" id="plat_nomor" name="plat_nomor" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="merk" class="form-label">Merk Kendaraan</label>
                                <input type="text" class="form-control" id="merk" name="merk" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="jenis" class="form-label">Jenis/Model Kendaraan</label>
                                <input type="text" class="form-control" id="jenis" name="jenis" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="tahun" class="form-label">Tahun</label>
                                <input type="number" class="form-control" id="tahun" name="tahun" min="1900" max="<?php echo date('Y') + 1; ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Simpan</button>
                        <a href="kendaraan_data.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
