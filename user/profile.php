<?php 
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../html/auth-login-basic.php");
    exit();
}

// Fetch regional and kantor data from the database
$regionalQuery = "SELECT DISTINCT regional FROM ref_kcu_kc";
$kantorQuery = "SELECT DISTINCT Nama_Kantor FROM ref_kcu_kc";
$jenisKantorQuery = "SELECT DISTINCT Jenis_Kantor FROM ref_kcu_kc";

// Execute queries
$regionalResult = $koneksi->query($regionalQuery);
$Nama_KantorResult = $koneksi->query($kantorQuery);
$jenisKantorResult = $koneksi->query($jenisKantorQuery);

$user_id = $_SESSION['id'];

$query = "SELECT * FROM user WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $jenis = $_POST['jenis'];
    $regional = $_POST['regional'];
    $kantor_asal = $_POST['kantor_asal'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE user SET username = ?, nama = ?, nik = ?, jenis = ?, regional = ?, kantor_asal = ?, password = ? WHERE id = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("sssssssi", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $hashed_password, $user_id);
    } else {
        $update_query = "UPDATE user SET username = ?, nama = ?, nik = ?, jenis = ?, regional = ?, kantor_asal = ? WHERE id = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("ssssssi", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $user_id);
    }

    if ($stmt->execute()) {
        // After the data is updated, set a flag for success.
        $updateSuccess = true;
    } else {
        $updateSuccess = false;
        $errorMessage = $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit My Profile | Iregularitas</title>
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
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Edit Profile</span></h4>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="profile.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Edit Your Profile Information</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="username">Username</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-user-circle"></i></span>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="nik">NIPPOS</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                                <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($user['nik']) ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="jenis">Jenis Kantor</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="jenis" name="jenis" required>
                                                <?php while ($jenisRow = $jenisKantorResult->fetch_assoc()): ?>
                                                    <option value="<?= $jenisRow['Jenis_Kantor']; ?>" <?= ($jenisRow['Jenis_Kantor'] == $user['jenis']) ? 'selected' : ''; ?>>
                                                        <?= $jenisRow['Jenis_Kantor']; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="regional">Regional</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="regional" name="regional" required>
                                                <?php while ($regionalRow = $regionalResult->fetch_assoc()): ?>
                                                    <option value="<?= $regionalRow['regional']; ?>" <?= ($user['regional'] == $regionalRow['regional']) ? 'selected' : ''; ?>>
                                                        <?= $regionalRow['regional']; ?>
                                                    </option>
                                                <?php endwhile; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="kantor_asal">Kantor Asal</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-buildings"></i></span>
                                                <select class="form-select" id="kantor_asal" name="kantor_asal" required>
                                                    <?php while ($Nama_KantorRow = $Nama_KantorResult->fetch_assoc()): ?>
                                                        <option value="<?= $Nama_KantorRow['Nama_Kantor']; ?>" <?= ($user['kantor_asal'] == $Nama_KantorRow['Nama_Kantor']) ? 'selected' : '' ?>>
                                                            <?= $Nama_KantorRow['Nama_Kantor']; ?>
                                                        </option>
                                                    <?php endwhile; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="password">Password (Change if needed)</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-lock"></i></span>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password if you want to change it">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                            <a href="../user/dashboard.php" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php if (isset($updateSuccess)): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil diperbarui!',
                                showConfirmButton: true
                            }).then(function() {
                                window.location.href = 'profile.php'; // Redirect after success
                            });
                        </script>
                    <?php elseif (isset($updateSuccess) && !$updateSuccess): ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal memperbarui data!',
                                text: 'Terjadi kesalahan: <?= $errorMessage ?>',
                            });
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
