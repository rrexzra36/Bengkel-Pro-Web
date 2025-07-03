<?php
// Proteksi halaman
require 'includes/auth_check.php';
// Koneksi database
require 'includes/koneksi.php';

// Set judul halaman
$page_title = 'Dashboard';

// Query untuk mengambil data ringkasan
$total_pelanggan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM pelanggan"))['total'];
$total_kendaraan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM kendaraan"))['total'];
$total_servis_dikerjakan = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM servis WHERE status = 'Dikerjakan'"))['total'];
$total_servis_selesai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(id) as total FROM servis WHERE status = 'Selesai'"))['total'];

// Include kerangka utama
include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>

    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>

        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4">Dashboard</h2>

            <div class="row g-4">
                <!-- Card Pelanggan -->
                <div class="col-md-6 col-lg-3">
                    <div class="card dashboard-card bg-primary">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">PELANGGAN</h5>
                                <p class="card-text"><?php echo $total_pelanggan; ?></p>
                            </div>
                            <i class="bi bi-people-fill card-icon"></i>
                        </div>
                        <div class="card-footer">
                            <a href="pelanggan_data.php">Lihat Detail <i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Card Kendaraan -->
                <div class="col-md-6 col-lg-3">
                    <div class="card dashboard-card bg-info">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">KENDARAAN</h5>
                                <p class="card-text"><?php echo $total_kendaraan; ?></p>
                            </div>
                            <i class="bi bi-car-front-fill card-icon"></i>
                        </div>
                        <div class="card-footer">
                            <a href="kendaraan_data.php">Lihat Detail <i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Card Servis Dikerjakan -->
                <div class="col-md-6 col-lg-3">
                    <div class="card dashboard-card bg-warning text-dark">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">DIKERJAKAN</h5>
                                <p class="card-text"><?php echo $total_servis_dikerjakan; ?></p>
                            </div>
                            <i class="bi bi-hourglass-split card-icon"></i>
                        </div>
                        <div class="card-footer">
                            <a href="servis_data.php?status=Dikerjakan">Lihat Detail <i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>
                </div>

                <!-- Card Servis Selesai -->
                <div class="col-md-6 col-lg-3">
                    <div class="card dashboard-card bg-success">
                        <div class="card-body">
                            <div>
                                <h5 class="card-title">SELESAI</h5>
                                <p class="card-text"><?php echo $total_servis_selesai; ?></p>
                            </div>
                            <i class="bi bi-check-circle-fill card-icon"></i>
                        </div>
                        <div class="card-footer">
                            <a href="servis_data.php?status=Selesai">Lihat Detail <i class="bi bi-arrow-right-circle"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body">
                    <h5 class="card-title">Selamat Datang!</h5>
                    <p class="card-text">Anda telah login sebagai <strong><?php echo htmlspecialchars($_SESSION['role']); ?></strong>. Gunakan menu di samping untuk mengelola data bengkel.</p>
                </div>
            </div>

        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
