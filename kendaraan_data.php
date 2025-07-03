<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';
$page_title = 'Data Kendaraan';

// Ambil semua data kendaraan dengan join ke tabel pelanggan
$sql = "SELECT kendaraan.*, pelanggan.nama AS nama_pelanggan 
        FROM kendaraan 
        JOIN pelanggan ON kendaraan.pelanggan_id = pelanggan.id
        ORDER BY pelanggan.nama, kendaraan.merk ASC";
$result = mysqli_query($koneksi, $sql);

include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Manajemen Data Kendaraan</h2>
                <a href="kendaraan_tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Kendaraan</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Plat Nomor</th>
                                    <th>Pemilik</th>
                                    <th>Merk</th>
                                    <th>Jenis</th>
                                    <th>Tahun</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php $no = 1; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><span class="badge bg-dark"><?php echo htmlspecialchars($row['plat_nomor']); ?></span></td>
                                            <td><?php echo htmlspecialchars($row['nama_pelanggan']); ?></td>
                                            <td><?php echo htmlspecialchars($row['merk']); ?></td>
                                            <td><?php echo htmlspecialchars($row['jenis']); ?></td>
                                            <td><?php echo htmlspecialchars($row['tahun']); ?></td>
                                            <td class="text-center">
                                                <a href="kendaraan_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                                <a href="kendaraan_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash-fill"></i></a>
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
