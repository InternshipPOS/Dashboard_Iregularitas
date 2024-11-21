<?php 
session_start();
include '../html/config.php';

// Redirect jika belum login
if (!isset($_SESSION['id'])) {
    header("Location: ../html/auth-login-basic.php");
    exit();
}

// Ambil ID user dari URL atau session
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
} else {
    die("Error: ID pengguna tidak ditemukan.");
}

// Fetch data user berdasarkan ID
$query = "SELECT * FROM user WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("Data pengguna tidak ditemukan.");
}

// Fetch data regional, kantor, dan jenis kantor
$regionalResult = $koneksi->query("SELECT DISTINCT regional FROM ref_kcu_kc");
$kantorResult = $koneksi->query("SELECT DISTINCT Nama_Kantor FROM ref_kcu_kc");
$jenisKantorResult = $koneksi->query("SELECT DISTINCT Jenis_Kantor FROM ref_kcu_kc");

// Proses update data
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $nama = htmlspecialchars($_POST['nama']);
    $nik = htmlspecialchars($_POST['nik']);
    $jenis = htmlspecialchars($_POST['jenis']);
    $regional = htmlspecialchars($_POST['regional']);
    $kantor_asal = htmlspecialchars($_POST['kantor_asal']);
    $password = htmlspecialchars($_POST['password']);

    // Jika password tidak kosong, hash dan update
    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE user SET username = ?, nama = ?, nik = ?, jenis = ?, regional = ?, kantor_asal = ?, password = ? WHERE id = ?";
        $stmt = $koneksi->prepare($updateQuery);
        $stmt->bind_param("sssssssi", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $hashed_password, $user_id);
    } else {
        $updateQuery = "UPDATE user SET username = ?, nama = ?, nik = ?, jenis = ?, regional = ?, kantor_asal = ? WHERE id = ?";
        $stmt = $koneksi->prepare($updateQuery);
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
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Manage Users | Iregularitas</title>
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
        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Edit Users</span></h4>
        <div class="card">
            <div class="card-body">
                <form action="" method="POST">
                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="username">Username</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="nik">NIPPOS</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($user['nik']) ?>" required>
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
                                    <option value="<?= $regionalRow['regional']; ?>" <?= ($regionalRow['regional'] == $user['regional']) ? 'selected' : ''; ?>>
                                        <?= $regionalRow['regional']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="kantor_asal">Kantor Asal</label>
                        <div class="col-sm-10">
                            <select class="form-select" id="kantor_asal" name="kantor_asal" required>
                                <?php while ($kantorRow = $kantorResult->fetch_assoc()): ?>
                                    <option value="<?= $kantorRow['Nama_Kantor']; ?>" <?= ($kantorRow['Nama_Kantor'] == $user['kantor_asal']) ? 'selected' : ''; ?>>
                                        <?= $kantorRow['Nama_Kantor']; ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-2 col-form-label" for="password">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah">
                        </div>
                    </div>

                    <div class="row justify-content-end">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="../html/manage-user.php" class="btn btn-secondary">Cancel</a>
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
                                window.location.href = '../html/manage-user.php'; // Redirect after success
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


    <!-- Scripts -->
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>