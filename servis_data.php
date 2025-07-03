<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';
$page_title = 'Data Servis';

// Ambil semua data servis dengan join ke tabel kendaraan dan pelanggan
$sql = "SELECT 
            servis.id, 
            servis.tanggal_masuk, 
            servis.keluhan, 
            servis.status, 
            servis.biaya,
            kendaraan.plat_nomor, 
            kendaraan.merk, 
            pelanggan.nama AS nama_pelanggan
        FROM servis
        JOIN kendaraan ON servis.kendaraan_id = kendaraan.id
        JOIN pelanggan ON kendaraan.pelanggan_id = pelanggan.id
        ORDER BY servis.tanggal_masuk DESC, servis.id DESC";
$result = mysqli_query($koneksi, $sql);

include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Manajemen Data Servis</h2>
                <a href="servis_tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Data Servis</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Tgl Masuk</th>
                                    <th>Pelanggan</th>
                                    <th>Kendaraan</th>
                                    <th>Keluhan</th>
                                    <th class="text-center">Status</th>
                                    <th>Biaya</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo date('d M Y', strtotime($row['tanggal_masuk'])); ?></td>
                                            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['plat_nomor']) . ' (' . htmlspecialchars($row['merk']) . ')'; ?></td>
                                            <td><?php echo htmlspecialchars($row['keluhan']); ?></td>
                                            <td class="text-center">
                                                <?php
                                                $status = $row['status'];
                                                $badge_class = 'bg-secondary';
                                                if ($status == 'Dikerjakan') $badge_class = 'bg-primary';
                                                if ($status == 'Menunggu Sparepart') $badge_class = 'bg-warning text-dark';
                                                if ($status == 'Selesai') $badge_class = 'bg-success';
                                                if ($status == 'Dibatalkan') $badge_class = 'bg-danger';
                                                ?>
                                                <span class="badge <?php echo $badge_class; ?>"><?php echo htmlspecialchars($status); ?></span>
                                            </td>
                                            <td>Rp <?php echo number_format($row['biaya'], 0, ',', '.'); ?></td>
                                            <td class="text-center">
                                                <a href="servis_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                                <a href="servis_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash-fill"></i></a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
