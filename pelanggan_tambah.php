<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($koneksi, $_POST['nama']);
    $no_hp = mysqli_real_escape_string($koneksi, $_POST['no_hp']);
    $alamat = mysqli_real_escape_string($koneksi, $_POST['alamat']);

    if (!empty($nama) && !empty($no_hp) && !empty($alamat)) {
        $sql = "INSERT INTO pelanggan (nama, no_hp, alamat) VALUES (?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $nama, $no_hp, $alamat);

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['message'] = "Pelanggan baru berhasil ditambahkan!";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal menambahkan data.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Semua kolom wajib diisi!";
        $_SESSION['message_type'] = "warning";
    }
    header("Location: pelanggan_data.php");
    exit();
}

$page_title = 'Tambah Pelanggan';
include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4">Tambah Pelanggan Baru</h2>
            <div class="card">
                <div class="card-body">
                    <form action="pelanggan_tambah.php" method="POST">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="no_hp" class="form-label">Nomor HP</label>
                            <input type="tel" class="form-control" id="no_hp" name="no_hp" required>
                        </div>
                        <div class="mb-3">
                            <label for="alamat" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat" name="alamat" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Simpan</button>
                        <a href="pelanggan_data.php" class="btn btn-secondary">Batal</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
