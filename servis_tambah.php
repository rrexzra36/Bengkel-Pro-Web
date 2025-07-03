    <?php
    require 'includes/auth_check.php';
    require 'includes/koneksi.php';

    // Ambil data semua kendaraan untuk dropdown
    $sql_kendaraan = "SELECT k.id, k.plat_nomor, k.merk, p.nama AS nama_pelanggan 
                    FROM kendaraan k JOIN pelanggan p ON k.pelanggan_id = p.id 
                    ORDER BY p.nama, k.plat_nomor ASC";
    $result_kendaraan = mysqli_query($koneksi, $sql_kendaraan);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $kendaraan_id = (int)$_POST['kendaraan_id'];
        $tanggal_masuk = $_POST['tanggal_masuk'];
        $keluhan = mysqli_real_escape_string($koneksi, $_POST['keluhan']);
        
        if (!empty($kendaraan_id) && !empty($tanggal_masuk) && !empty($keluhan)) {
            $sql = "INSERT INTO servis (kendaraan_id, tanggal_masuk, keluhan, status) VALUES (?, ?, ?, 'Dikerjakan')";
            $stmt = mysqli_prepare($koneksi, $sql);
            mysqli_stmt_bind_param($stmt, "iss", $kendaraan_id, $tanggal_masuk, $keluhan);
            if (mysqli_stmt_execute($stmt)) {
                $_SESSION['message'] = "Data servis baru berhasil ditambahkan!";
                $_SESSION['message_type'] = "success";
            } else {
                $_SESSION['message'] = "Gagal menambahkan data servis.";
                $_SESSION['message_type'] = "error";
            }
        } else {
            $_SESSION['message'] = "Semua kolom wajib diisi!";
            $_SESSION['message_type'] = "warning";
        }
        header("Location: servis_data.php");
        exit();
    }

    $page_title = 'Tambah Data Servis';
    include 'includes/header.php';
    ?>

    <div class="wrapper d-flex align-items-stretch">
        <?php include 'includes/sidebar.php'; ?>
        <div id="content" class="content-wrapper">
            <?php include 'includes/navbar.php'; ?>
            <div class="container-fluid p-4">
                <h2 class="fw-bold mb-4">Tambah Data Servis Baru</h2>
                <div class="card">
                    <div class="card-body">
                        <form action="servis_tambah.php" method="POST">
                            <div class="mb-3">
                                <label for="kendaraan_id" class="form-label">Kendaraan</label>
                                <select class="form-select" id="kendaraan_id" name="kendaraan_id" required>
                                    <option value="" selected disabled>-- Pilih Kendaraan (Plat - Pemilik) --</option>
                                    <?php while ($kendaraan = mysqli_fetch_assoc($result_kendaraan)): ?>
                                        <option value="<?php echo $kendaraan['id']; ?>">
                                            <?php echo htmlspecialchars($kendaraan['plat_nomor'] . ' - ' . $kendaraan['merk'] . ' (' . $kendaraan['nama_pelanggan'] . ')'); ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tanggal_masuk" class="form-label">Tanggal Masuk</label>
                                <input type="date" class="form-control" id="tanggal_masuk" name="tanggal_masuk" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="keluhan" class="form-label">Keluhan</label>
                                <textarea class="form-control" id="keluhan" name="keluhan" rows="4" required placeholder="Contoh: Ganti oli, rem tidak pakem, AC tidak dingin"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success"><i class="bi bi-check-circle me-2"></i>Simpan</button>
                            <a href="servis_data.php" class="btn btn-secondary">Batal</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'includes/footer.php'; ?>
