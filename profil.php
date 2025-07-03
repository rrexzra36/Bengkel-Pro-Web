<?php
require 'includes/auth_check.php';
require 'includes/koneksi.php';

$page_title = 'Profil Pengguna'; // DEFINISIKAN PAGE TITLE DI ATAS
$user_id = $_SESSION['user_id'];

// Proses update profil
if (isset($_POST['update_profil'])) {
    $nama_lengkap = mysqli_real_escape_string($koneksi, $_POST['nama_lengkap']);
    if (!empty($nama_lengkap)) {
        $sql_update_profil = "UPDATE users SET nama_lengkap = ? WHERE id = ?";
        $stmt = mysqli_prepare($koneksi, $sql_update_profil);
        mysqli_stmt_bind_param($stmt, "si", $nama_lengkap, $user_id);
        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['nama_lengkap'] = $nama_lengkap;
            $_SESSION['message'] = "Nama lengkap berhasil diperbarui.";
            $_SESSION['message_type'] = "success";
        } else {
            $_SESSION['message'] = "Gagal memperbarui profil.";
            $_SESSION['message_type'] = "error";
        }
    } else {
        $_SESSION['message'] = "Nama lengkap tidak boleh kosong.";
        $_SESSION['message_type'] = "warning";
    }
    header("Location: profil.php");
    exit();
}

// Proses ganti password
if (isset($_POST['ganti_password'])) {
    $password_lama = $_POST['password_lama'];
    $password_baru = $_POST['password_baru'];
    $konfirmasi_password = $_POST['konfirmasi_password'];

    $sql_user = "SELECT password FROM users WHERE id = ?";
    $stmt_user = mysqli_prepare($koneksi, $sql_user);
    mysqli_stmt_bind_param($stmt_user, "i", $user_id);
    mysqli_stmt_execute($stmt_user);
    $result_user = mysqli_stmt_get_result($stmt_user);
    $user = mysqli_fetch_assoc($result_user);

    if (password_verify($password_lama, $user['password'])) {
        if ($password_baru === $konfirmasi_password) {
            if(strlen($password_baru) >= 6) {
                $hashed_password = password_hash($password_baru, PASSWORD_DEFAULT);
                $sql_update_pass = "UPDATE users SET password = ? WHERE id = ?";
                $stmt_pass = mysqli_prepare($koneksi, $sql_update_pass);
                mysqli_stmt_bind_param($stmt_pass, "si", $hashed_password, $user_id);
                if (mysqli_stmt_execute($stmt_pass)) {
                    $_SESSION['message'] = "Password berhasil diubah.";
                    $_SESSION['message_type'] = "success";
                } else {
                    $_SESSION['message'] = "Gagal mengubah password.";
                    $_SESSION['message_type'] = "error";
                }
            } else {
                $_SESSION['message'] = "Password baru minimal harus 6 karakter.";
                $_SESSION['message_type'] = "warning";
            }
        } else {
            $_SESSION['message'] = "Konfirmasi password baru tidak cocok.";
            $_SESSION['message_type'] = "warning";
        }
    } else {
        $_SESSION['message'] = "Password lama salah.";
        $_SESSION['message_type'] = "error";
    }
    header("Location: profil.php");
    exit();
}


include 'includes/header.php';

// Ambil data user terbaru untuk ditampilkan
$sql_get_user = "SELECT nama_lengkap, username, role FROM users WHERE id = ?";
$stmt_get = mysqli_prepare($koneksi, $sql_get_user);
mysqli_stmt_bind_param($stmt_get, "i", $user_id);
mysqli_stmt_execute($stmt_get);
$current_user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_get));
?>

<div class="wrapper d-flex align-items-stretch">
    <?php include 'includes/sidebar.php'; ?>
    <div id="content" class="content-wrapper">
        <?php include 'includes/navbar.php'; ?>
        <div class="container-fluid p-4">
            <h2 class="fw-bold mb-4"><?php echo $page_title; ?></h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Informasi Akun</h5>
                        </div>
                        <div class="card-body">
                            <form action="profil.php" method="POST">
                                <div class="mb-3">
                                    <label class="form-label">Username</label>
                                    <input type="text" class="form-control" value="<?php echo htmlspecialchars($current_user['username']); ?>" disabled readonly>
                                </div>
                                <div class="mb-3">
                                    <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="<?php echo htmlspecialchars($current_user['nama_lengkap']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control" value="<?php echo ucfirst(htmlspecialchars($current_user['role'])); ?>" disabled readonly>
                                </div>
                                <button type="submit" name="update_profil" class="btn btn-primary"><i class="bi bi-save me-2"></i>Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-header"><h5 class="mb-0">Ganti Password</h5></div>
                        <div class="card-body">
                            <form action="profil.php" method="POST">
                                <div class="mb-3">
                                    <label for="password_lama" class="form-label">Password Lama</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password_lama" name="password_lama" required>
                                        <span class="toggle-password-icon"><i class="bi bi-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="password_baru" class="form-label">Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="password_baru" name="password_baru" required>
                                        <span class="toggle-password-icon"><i class="bi bi-eye-slash"></i></span>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="konfirmasi_password" class="form-label">Konfirmasi Password Baru</label>
                                    <div class="position-relative">
                                        <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" required>
                                        <span class="toggle-password-icon"><i class="bi bi-eye-slash"></i></span>
                                    </div>
                                </div>
                                <button type="submit" name="ganti_password" class="btn btn-danger"><i class="bi bi-shield-lock me-2"></i>Ubah Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'includes/footer.php'; ?>
