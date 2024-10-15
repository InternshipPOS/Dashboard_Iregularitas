<?php
session_start(); // Start the session for login

include 'config.php'; // Include database configuration

// Aktifkan tampilan error untuk debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

$successMessage = ''; // Menyimpan pesan sukses
$errorMessage = ''; // Menyimpan pesan error
$nikErrorMessage = ''; // Menyimpan pesan error khusus untuk NIK

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $password = $_POST['password'];

    // Query untuk memeriksa apakah NIK ada di tabel admin
    $sql = "SELECT * FROM admin WHERE nik = ?";
    $stmt = $koneksi->prepare($sql);
    
    if (!$stmt) {
        die("Query failed: " . $koneksi->error);
    }

    $stmt->bind_param("s", $nik); // Menggunakan prepared statement untuk mencegah SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    // Cek apakah NIK ditemukan
    if ($result->num_rows > 0) {
        // Ambil data admin
        $row = $result->fetch_assoc();

        // Verifikasi password (sesuaikan jika password di-hash)
        if ($password === $row['password']) {
            // Password benar, buat sesi untuk admin
            $_SESSION['admin_nama'] = $row['nama']; // Set sesi untuk admin
            $successMessage = $row['nama']; // Simpan nama admin untuk pesan sukses
        } else {
            $errorMessage = 'Wrong password. Please try again.';
        }
    } else {
        $nikErrorMessage = 'NIPPOS not found. Please check your NIPPOS and try again.';
    }

    $stmt->close(); // Tutup statement
}

$koneksi->close(); // Tutup koneksi database
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Admin Login - Iregularitas</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<body style="background-color: #f8f9fa;">
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card shadow-lg border-0 rounded-lg" style="max-width: 900px; margin: 0 auto;">
                    <div class="card-body p-4">
                        <div class="app-brand justify-content-center">
                            <a href="auth-login-admin.php" class="app-brand-link d-flex align-items-center">
                                <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45" class="me-2">
                                <span class="app-brand-text menu-text fw-bolder ms-2" style="font-size: 1.5rem;">ReguTrack</span>
                            </a>
                        </div>
                        <h4 class="mb-2">Welcome Admin! 👋</h4>
                        <p class="mb-4">Please sign in to your account</p>

                        <form id="formAuthentication" class="mb-3" action="auth-login-admin.php" method="POST">
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIPPos</label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Enter your NIPPOS" required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="********" required />
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <!-- <p class="text-center">
                            <a href="auth-forgot-password-admin.php">
                                <small>Forgot Password?</small>
                            </a>
                        </p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // Fungsi untuk menampilkan alert sukses
    function showSuccessAlert(nama) {
        Swal.fire({
            icon: 'success',
            title: 'Login successful!',
            text: 'Welcome, ' + nama + '!',
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'index.php'; // Redirect ke dashboard admin
            }
        });
    }

    // Fungsi untuk menampilkan alert error
    function showErrorAlert(title, text) {
        Swal.fire({
            icon: 'error',
            title: title,
            text: text,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = 'auth-login-admin.php'; // Redirect kembali ke login
            }
        });
    }

    // Cek apakah ada pesan sukses atau error untuk ditampilkan
    window.onload = function() {
        <?php if ($successMessage): ?>
            showSuccessAlert('<?php echo $successMessage; ?>');
        <?php elseif ($errorMessage): ?>
            showErrorAlert('Error', '<?php echo $errorMessage; ?>');
        <?php elseif ($nikErrorMessage): ?>
            showErrorAlert('Error', '<?php echo $nikErrorMessage; ?>');
        <?php endif; ?>
    };
    </script>
</body>
</html>
