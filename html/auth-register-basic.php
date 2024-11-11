<?php
include 'config.php'; // Include your database configuration

// Fetch regional and kantor data from the database
$regionalQuery = "SELECT DISTINCT regional FROM ref_kcu_kc";
$kantorQuery = "SELECT DISTINCT Nama_Kantor FROM ref_kcu_kc";
$jenisKantorQuery = "SELECT DISTINCT Jenis_Kantor FROM ref_kcu_kc";

// Execute queries
$regionalResult = $koneksi->query($regionalQuery);
$Nama_KantorResult = $koneksi->query($kantorQuery);
$jenisKantorResult = $koneksi->query($jenisKantorQuery);

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $jenis = $_POST['jenis'];
    $regional = $_POST['regional'];
    $Nama_Kantor = $_POST['Nama_Kantor'];
    $password = $_POST['password'];

    // Validate form data (basic validation example)
    if (empty($username) || empty($nama) || empty($nik) || empty($jenis) || empty($regional) || empty($Nama_Kantor) || empty($password)) {
        echo "All fields are required!";
        exit;
    }

    // Check if NIK already exists
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // NIK already exists
        echo "<script>alert('NIK sudah terdaftar! Silakan gunakan NIK lain.'); window.location.href='auth-register-basic.php';</script>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $stmt = $koneksi->prepare("INSERT INTO user (username, nama, nik, jenis, regional, kantor_asal, password) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param("sssssss", $username, $nama, $nik, $jenis, $regional, $Nama_Kantor, $hashed_password);

        // Password validation
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $password)) {
            echo "<script>
                  alert('Password minimal harus 6 karakter, mengandung minimal satu huruf dan satu angka.');
                  window.location.href = 'auth-register-basic.php'; 
                </script>";
            exit;
        }

        // Execute the query
        if ($stmt->execute()) {
            // Successful registration alert and redirect
            echo "<script>
                  alert('Registration successful!');
                  window.location.href = 'auth-login-basic.php'; 
                </script>";
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register - Pages | Iregularitas</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
</head>

<body style="background-color: #f8f9fa;">
    <div class="container-xxl">
        <div class="authentication-basic container-p-y">
            <div class="card shadow-lg border-0 rounded-lg" style="max-width: 900px; margin: 0 auto;">
                <div class="card-body p-4">
                    <div class="app-brand justify-content-center mb-3">
                        <a href="auth-register-basic.php" class="app-brand-link d-flex align-items-center">
                            <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45" class="me-2">
                            <span class="app-brand-text menu-text fw-bolder ms-2" style="font-size: 1.5rem;">ReguTrack</span>
                        </a>
                    </div>
                    <h4 class="text-center mb-3">Empowering You to Uncover Hidden Irregularities</h4>

                    <form id="formAuthentication" class="mb-3" action="" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control shadow-sm" id="username" name="username" required />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control shadow-sm" id="nama" name="nama" required />
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nik" class="form-label">NIPPos</label>
                                <input type="text" class="form-control shadow-sm" id="nik" name="nik" required />
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="jenis" class="form-label">Jenis Kantor</label>
                                <select class="form-control shadow-sm" id="jenis" name="jenis" required>
                                    <option value="" disabled selected>Pilih Jenis Kantor</option>
                                    <?php while ($jenisRow = $jenisKantorResult->fetch_assoc()): ?>
                                        <option value="<?= $jenisRow['Jenis_Kantor']; ?>"><?= $jenisRow['Jenis_Kantor']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="regional" class="form-label">Regional</label>
                                <select class="form-control shadow-sm" id="regional" name="regional" required>
                                    <option value="">--Pilih Regional--</option>
                                    <?php while ($regionalRow = $regionalResult->fetch_assoc()): ?>
                                        <option value="<?= $regionalRow['regional']; ?>"><?= $regionalRow['regional']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="Nama_Kantor" class="form-label">Kantor Asal</label>
                                <select class="form-control shadow-sm" id="Nama_Kantor" name="Nama_Kantor" required>
                                    <option value="">--Pilih Nama Kantor--</option>
                                    <?php while ($Nama_KantorRow = $Nama_KantorResult->fetch_assoc()): ?>
                                        <option value="<?= $Nama_KantorRow['Nama_Kantor']; ?>"><?= $Nama_KantorRow['Nama_Kantor']; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control shadow-sm" id="password" name="password" required />
                            </div>
                        </div>

                        <button class="register btn btn-primary d-grid w-100 shadow-sm">Sign Up</button>
                    </form>

                    <p class="text-center mt-3">
                        <span>Already have an account?</span>
                        <a href="auth-login-basic.php"><span>Sign in instead</span></a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
