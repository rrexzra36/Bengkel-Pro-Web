<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require 'includes/koneksi.php';

// Jika user sudah login, redirect ke halaman dashboard
if (isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $konfirmasi_password = $_POST['konfirmasi_password'];
    $role = 'staff'; // Role default untuk pendaftaran mandiri

    // Validasi
    if (empty($nama_lengkap) || empty($username) || empty($password) || empty($konfirmasi_password)) {
        $error = "Semua kolom wajib diisi!";
    } elseif (strlen($password) < 6) {
        $error = "Password minimal harus 6 karakter.";
    } elseif ($password !== $konfirmasi_password) {
        $error = "Konfirmasi password tidak cocok!";
    } else {
        // Cek apakah username sudah ada
        $sql_check = "SELECT id FROM users WHERE username = ?";
        $stmt_check = mysqli_prepare($koneksi, $sql_check);
        mysqli_stmt_bind_param($stmt_check, "s", $username);
        mysqli_stmt_execute($stmt_check);
        $result_check = mysqli_stmt_get_result($stmt_check);

        if (mysqli_num_rows($result_check) > 0) {
            $error = "Username sudah digunakan, silakan pilih yang lain.";
        } else {
            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data user baru
            $sql_insert = "INSERT INTO users (nama_lengkap, username, password, role) VALUES (?, ?, ?, ?)";
            $stmt_insert = mysqli_prepare($koneksi, $sql_insert);
            mysqli_stmt_bind_param($stmt_insert, "ssss", $nama_lengkap, $username, $hashed_password, $role);

            if (mysqli_stmt_execute($stmt_insert)) {
                // Atur session untuk menampilkan SweetAlert
                $_SESSION['registration_success'] = true;
                header("Location: register.php");
                exit();
            } else {
                $error = "Terjadi kesalahan pada server. Gagal mendaftar.";
            }
        }
    }
}

$page_title = "Registrasi";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($page_title); ?> - Bengkel Pro</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page-body">

    <div class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Buat Akun Baru</h2>
                            <p class="text-muted">Daftar untuk mengakses sistem</p>
                        </div>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?php echo $error; ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="register.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" placeholder="Nama Lengkap" required value="<?php echo isset($_POST['nama_lengkap']) ? htmlspecialchars($_POST['nama_lengkap']) : ''; ?>">
                                <label for="nama_lengkap"><i class="bi bi-person-badge me-2"></i>Nama Lengkap</label>
                            </div>
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                                <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                                <span class="toggle-password-icon"><i class="bi bi-eye-slash"></i></span>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" id="konfirmasi_password" name="konfirmasi_password" placeholder="Konfirmasi Password" required>
                                <label for="konfirmasi_password"><i class="bi bi-shield-lock me-2"></i>Konfirmasi Password</label>
                                <span class="toggle-password-icon"><i class="bi bi-eye-slash"></i></span>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold">Daftar</button>
                            </div>
                        </form>
                        <div class="text-center mt-4">
                            <small class="text-muted">Sudah punya akun? <a href="login.php">Login di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <script>
        $(document).ready(function() {
            // Script untuk toggle password visibility
            $(".toggle-password-icon").click(function() {
                $(this).find("i").toggleClass("bi-eye bi-eye-slash");
                var input = $(this).closest('.position-relative').find("input");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });

            <?php
            // Cek session dan tampilkan SweetAlert jika ada
            if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']) {
                echo "
                Swal.fire({
                    title: 'Registrasi Berhasil!',
                    text: 'Akun Anda berhasil dibuat.',
                    icon: 'success',
                    confirmButtonText: 'Login',
                    confirmButtonColor: '#0d6efd'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = 'login.php';
                    }
                });
                ";
                // Hapus session setelah alert ditampilkan
                unset($_SESSION['registration_success']);
            }
            ?>
        });
    </script>
</body>
</html>