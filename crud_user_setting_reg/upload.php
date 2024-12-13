<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
<meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Upload Evidence</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
</head>
<body>
    <div class="container mt-5">
        <form action="" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="uploaded_file" class="form-label">Pilih File</label>
                <input type="file" name="uploaded_file" id="uploaded_file" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah</button>
            <?php 
session_start();

// Cek login
if (!isset($_SESSION['nik'])) {
    echo "<script>
        Swal.fire({
            title: 'Akses Ditolak!',
            text: 'Silakan login terlebih dahulu.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = 'auth-login-basic.html'; // Redirect ke halaman login
        });
    </script>";
    exit();
}

// Konfigurasi database
$host = "localhost";
$user = "root";
$password = "";
$database = "iregularitas";
$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    echo "<script>
        Swal.fire({
            title: 'Koneksi Gagal!',
            text: 'Tidak dapat terhubung ke database.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    </script>";
    exit();
}

// Mendapatkan ID Sistem dari URL
$id_sistem = $_GET['id_sistem'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES['uploaded_file']) && $_FILES['uploaded_file']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/"; // Ubah ke folder 'user/uploads/'
        $fileName = basename($_FILES['uploaded_file']['name']);
        $targetFilePath = $targetDir . $fileName;

        $nik_user = $_SESSION['nik']; // Pastikan Anda memiliki sesi NIK pengguna
        $query = "SELECT regional FROM loginreg WHERE nik = '$nik_user'";
        $result = $koneksi->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $user_regional = $row['regional']; // Ambil nilai regional pengguna

            // Pindahkan file ke direktori target
            if (move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $targetFilePath)) {
                $sql = "UPDATE newreport SET file_path = '$targetFilePath' WHERE id_sistem = '$id_sistem'";

                if ($koneksi->query($sql) === TRUE) {
                    echo "<script>
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'File berhasil diunggah.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.location.href = '../user/user-setting-reg.php?regional=' + '$user_regional';
                        });
                    </script>";
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Gagal!',
                            text: 'Gagal menyimpan ke database.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    Swal.fire({
                        title: 'Gagal!',
                        text: 'Gagal mengunggah file.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Regional pengguna tidak ditemukan.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Pilih file untuk diunggah.',
                icon: 'warning',
                confirmButtonText: 'OK'
            });
        </script>";
    }
}
?>
        </form>
    </div>
</body>
</html>
