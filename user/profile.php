<?php
session_start();
include '../html/config.php'; // Include database configuration

// Check if the user is logged in
if (!isset($_SESSION['nama'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href = 'auth-login-basic.php';
          </script>";
    exit;
}

// Fetch user data from the database
$nik = $_SESSION['nik']; // Assuming you have stored NIK in the session
$sql = "SELECT * FROM user WHERE nik = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $nik);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
} else {
    echo "<script>
            alert('Data pengguna tidak ditemukan.');
            window.location.href = 'dashboard.php';
          </script>";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = $_POST['nama'];
    $jenis = $_POST['jenis'];

    // Update user data in the database
    $update_sql = "UPDATE user SET nama = ?, jenis = ? WHERE nik = ?";
    $update_stmt = $koneksi->prepare($update_sql);
    $update_stmt->bind_param("ssi", $nama, $jenis, $nik);

    if ($update_stmt->execute()) {
        // Update session data
        $_SESSION['nama'] = $nama;
        $_SESSION['jenis'] = $jenis;

        echo "<script>
                alert('Profil berhasil diperbarui!');
                window.location.href = 'dashboard.php';
              </script>";
    } else {
        echo "<script>
                alert('Terjadi kesalahan saat memperbarui profil.');
                window.location.href = 'profile.php';
              </script>";
    }

    $update_stmt->close();
}

$stmt->close();
$koneksi->close();
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css">
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css">
    <link rel="stylesheet" href="../assets/css/demo.css">
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card shadow-lg border-0 rounded-lg">
                    <div class="card-body p-4">
                        <h4 class="mb-4">Edit Profil</h4>
                        <form action="profile.php" method="POST">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo htmlspecialchars($user['nama']); ?>" required />
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis</label>
                                <input type="text" class="form-control" id="jenis" name="jenis" value="<?php echo htmlspecialchars($user['jenis']); ?>" required />
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Perbarui Profil</button>
                            </div>
                        </form>
                        <p class="text-center">
                            <a href="dashboard.php">Kembali ke Dashboard</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/js/main.js"></script>
</body>
</html>
