<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';
$page_title = 'Data Pelanggan';

// Ambil semua data pelanggan
$sql = "SELECT * FROM pelanggan ORDER BY nama ASC";
$result = mysqli_query($koneksi, $sql);

include 'includes/header.php';
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold">Manajemen Data Pelanggan</h2>
                <a href="pelanggan_tambah.php" class="btn btn-primary"><i class="bi bi-plus-circle me-2"></i>Tambah Pelanggan</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="data-table" class="table table-striped table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>No. HP</th>
                                    <th>Alamat</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (mysqli_num_rows($result) > 0): ?>
                                    <?php $no = 1; ?>
                                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                        <tr>
                                            <td><?php echo $no++; ?></td>
                                            <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                            <td><?php echo htmlspecialchars($row['no_hp']); ?></td>
                                            <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                            <td class="text-center">
                                                <a href="pelanggan_edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm me-1"><i class="bi bi-pencil-square"></i></a>
                                                <a href="pelanggan_hapus.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm btn-delete"><i class="bi bi-trash-fill"></i></a>
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
