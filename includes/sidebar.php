<?php
// Pastikan variabel $page_title sudah didefinisikan sebelum include file ini
$current_page = isset($page_title) ? $page_title : '';
?>
<nav id="sidebar" class="sidebar">
    <div class="sidebar-header text-center">
        <h3><i class="bi bi-tools"></i> Bengkel Pro</h3>
    </div>

    <ul class="list-unstyled components">
        <li class="<?php echo ($current_page == 'Dashboard') ? 'active' : ''; ?>">
            <a href="index.php"><i class="bi bi-grid-fill"></i>Dashboard</a>
        </li>
        <li class="<?php echo ($current_page == 'Data Pelanggan') ? 'active' : ''; ?>">
            <a href="pelanggan_data.php"><i class="bi bi-people-fill"></i>Data Pelanggan</a>
        </li>
        <li class="<?php echo ($current_page == 'Data Kendaraan') ? 'active' : ''; ?>">
            <a href="kendaraan_data.php"><i class="bi bi-car-front-fill"></i>Data Kendaraan</a>
        </li>
        <li class="<?php echo ($current_page == 'Data Servis') ? 'active' : ''; ?>">
            <a href="servis_data.php"><i class="bi bi-wrench-adjustable-circle-fill"></i>Data Servis</a>
        </li>
        <li class="<?php echo ($current_page == 'Profil Pengguna') ? 'active' : ''; ?>">
            <a href="profil.php"><i class="bi bi-person-fill"></i>Profil Pengguna</a>
        </li>
    </ul>
</nav>
