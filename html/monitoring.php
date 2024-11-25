<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Monitoring Regional</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
</head>
<?php
session_start();
include('config.php');

// Cek apakah pengguna sudah login
if (!isset($_SESSION['nik'])) {
    header("Location: auth-login-basic.html");
    exit;
}

// Ambil NIK pengguna yang sudah login
$nik_user = $_SESSION['nik'];

// Query untuk mendapatkan regional pengguna
$query = "SELECT regional FROM loginreg WHERE nik = '$nik_user'";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $logged_in_regional = $row['regional'];
} else {
    echo "Regional tidak ditemukan.";
    exit;
}

// Inisialisasi variabel filter
$selected_year = $koneksi->real_escape_string($_GET['year'] ?? '');
$selected_week = $koneksi->real_escape_string($_GET['week'] ?? '');
$selected_regional = $koneksi->real_escape_string($_GET['regional'] ?? $logged_in_regional);

$conditions = [];

// Filter Regional
if (!empty($selected_regional)) {
    $conditions[] = "r.ZonaTujuan = '$selected_regional'";
}

// Filter Tahun (Tahun_BA)
if (!empty($selected_year)) {
    $conditions[] = "r.Tahun_BA = '$selected_year'";
}

// Filter Week
if (!empty($selected_week)) {
    $conditions[] = "r.Week = '$selected_week'";
}

// Bangun klausa WHERE secara dinamis
$where_clause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

// Query untuk mendapatkan data
$sql = "SELECT  
    r.Nama_Kantor_Tujuan, 
    SUM(CASE WHEN r.validasi_pusat = 'ok' THEN 1 ELSE 0 END) AS total_ok,
    SUM(CASE WHEN r.validasi_pusat = 'belum entri evaluasi' THEN 1 ELSE 0 END) AS total_belum_antri,
    SUM(CASE WHEN r.validasi_pusat = 'evidence belum upload' THEN 1 ELSE 0 END) AS total_evidence_belum_upload
FROM `iregularitas`.`report_agung` r
$where_clause
GROUP BY r.Nama_Kantor_Tujuan";

$result_data = $koneksi->query($sql);
?>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Monitoring Regional</span></h4>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="../html/index.php" class="btn btn-primary btn-back">Back</a>
            </div>

            <!-- Form Filter -->
            <form method="GET" action="" class="mb-4 p-3 bg-light rounded shadow-sm">
                <div class="row">
                    <!-- Filter Regional -->
                    <div class="col-md-4 mb-3">
                        <label for="regional" class="form-label fw-bold">Pilih Regional:</label>
                        <select name="regional" id="regional" class="form-select">
                            <option value="">--Pilih Regional (Opsional)--</option>
                            <?php
                            $regional_query = "SELECT DISTINCT ZonaTujuan FROM report_agung";
                            $regional_result = $koneksi->query($regional_query);
                            while ($regional_row = $regional_result->fetch_assoc()) {
                                $regional = $regional_row['ZonaTujuan'];
                                $selected = ($regional == $selected_regional) ? 'selected' : '';
                                echo "<option value='$regional' $selected>$regional</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Filter Year -->
                    <div class="col-md-4 mb-3">
                        <label for="year" class="form-label fw-bold">Pilih Tahun:</label>
                        <select name="year" id="year" class="form-select">
                            <option value="">--Pilih Tahun (Opsional)--</option>
                            <?php
                            $currentYear = date("Y");
                            for ($i = $currentYear; $i >= $currentYear - 6; $i--) {
                                $selected = ($i == $selected_year) ? 'selected' : '';
                                echo "<option value='$i' $selected>$i</option>";
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Filter Week -->
                    <div class="col-md-4 mb-3">
                        <label for="week" class="form-label fw-bold">Week:</label>
                        <select name="week" id="week" class="form-select">
                            <option value="">--Pilih Week (Opsional)--</option>
                            <?php
                            for ($i = 1; $i <= 52; $i++) {
                                $selected = ($i == $selected_week) ? 'selected' : '';
                                echo "<option value='$i' $selected>Minggu $i</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary w-100">Tampilkan Data</button>
            </form>

            <!-- Data Monitoring Table -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kantor Tujuan</th>
                                <th>Total OK</th>
                                <th>Total Belum Antri</th>
                                <th>Total Evidence Belum Upload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_data && $result_data->num_rows > 0) {
                                $grand_total_ok = $grand_total_belum_antri = $grand_total_evidence_belum_upload = 0;

                                while ($row = $result_data->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['Nama_Kantor_Tujuan']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['total_ok']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['total_belum_antri']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['total_evidence_belum_upload']) . "</td>";
                                    echo "</tr>";

                                    $grand_total_ok += $row['total_ok'];
                                    $grand_total_belum_antri += $row['total_belum_antri'];
                                    $grand_total_evidence_belum_upload += $row['total_evidence_belum_upload'];
                                }

                                // Grand Total Row
                                echo "<tr class='grand-total'>";
                                echo "<td><strong>Grand Total</strong></td>";
                                echo "<td><strong>$grand_total_ok</strong></td>";
                                echo "<td><strong>$grand_total_belum_antri</strong></td>";
                                echo "<td><strong>$grand_total_evidence_belum_upload</strong></td>";
                                echo "</tr>";
                            } else {
                                echo "<tr><td colspan='4' class='text-center'>Tidak ada data untuk filter yang dipilih.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- JS Scripts -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
