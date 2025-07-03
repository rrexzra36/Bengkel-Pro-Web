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

// Proses form login ketika disubmit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $error = "Username dan password tidak boleh kosong!";
    } else {
        $sql = "SELECT id, username, password, role, nama_lengkap FROM users WHERE username = ?";
        $stmt = mysqli_prepare($koneksi, $sql);
        mysqli_stmt_bind_param($stmt, "s", $username);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($user = mysqli_fetch_assoc($result)) {
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['nama_lengkap'] = $user['nama_lengkap'];
                $_SESSION['role'] = $user['role'];
                header("Location: index.php");
                exit();
            } else {
                $error = "Kombinasi username dan password salah!";
            }
        } else {
            $error = "Kombinasi username dan password salah!";
        }
    }
}

$page_title = "Login";
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body class="login-page-body">

    <div class="container">
        <div class="row min-vh-100 justify-content-center align-items-center">
            <div class="col-md-5">
                <div class="card shadow-lg border-0">
                    <div class="card-body p-4 p-md-5">
                        <div class="text-center mb-4">
                            <h2 class="fw-bold">Bengkel Pro</h2>
                            <p class="text-muted">Silakan login untuk melanjutkan</p>
                        </div>
                        
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <div><?php echo $error; ?></div>
                            </div>
                        <?php endif; ?>

                        <form action="login.php" method="POST">
                            <div class="form-floating mb-3">
                                <input type="text" class="form-control" id="username" name="username" placeholder="Username" required>
                                <label for="username"><i class="bi bi-person me-2"></i>Username</label>
                            </div>
                            <div class="form-floating mb-3 position-relative">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                                <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                                <span class="toggle-password-icon"><i class="bi bi-eye-slash"></i></span>
                            </div>
                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg fw-semibold">Login</button>
                            </div>
                        </form>
                        <div class="text-center mt-4">
                            <small class="text-muted">Belum punya akun? <a href="register.php">Daftar di sini</a></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".toggle-password-icon").click(function() {
                $(this).find("i").toggleClass("bi-eye bi-eye-slash");
                // Cari input di parent .position-relative
                var input = $(this).closest('.position-relative').find("input");
                if (input.attr("type") === "password") {
                    input.attr("type", "text");
                } else {
                    input.attr("type", "password");
                }
            });
        });
    </script>

</body>
</html>
