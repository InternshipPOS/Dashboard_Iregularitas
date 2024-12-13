<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Dashboard Regional</title>
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
    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

// Query untuk mendapatkan data dengan kategori baru
$sql = "SELECT  
    r.Nama_Kantor_Tujuan, 
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Selisih Kurang Berat Kiriman' THEN 1 ELSE 0 END) AS selisih_kurang_berat_kiriman,
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Salah Tempel Resi' THEN 1 ELSE 0 END) AS salah_tempel_resi,
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Salah Salur Kiriman' THEN 1 ELSE 0 END) AS salah_salur_kiriman,
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Gagal X-Ray' THEN 1 ELSE 0 END) AS gagal_xray,
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Kiriman Rusak' THEN 1 ELSE 0 END) AS kiriman_rusak,
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Isi Kiriman Tidak Sesuai' THEN 1 ELSE 0 END) AS isi_kiriman_tidak_sesuai,
    SUM(CASE WHEN r.Deskripsi_Iregularitas = 'Selisih Kurang Item Kiriman' THEN 1 ELSE 0 END) AS selisih_kurang_item_kiriman
FROM `iregularitas`.`report_agung` r
$where_clause
GROUP BY r.Nama_Kantor_Tujuan";

$result_data = $koneksi->query($sql);

// Menyusun data untuk Chart.js
$labels = [];
$datasets = [
    'selisih_kurang_berat_kiriman' => [],
    'salah_tempel_resi' => [],
    'salah_salur_kiriman' => [],
    'gagal_xray' => [],
    'kiriman_rusak' => [],
    'isi_kiriman_tidak_sesuai' => [],
    'selisih_kurang_item_kiriman' => []
];

while ($row = $result_data->fetch_assoc()) {
    $labels[] = $row['Nama_Kantor_Tujuan']; // Menambahkan Nama Kantor Tujuan ke label

    // Menambahkan data untuk setiap irregularitas
    foreach ($datasets as $key => &$data) {
        $data[] = $row[$key];
    }
}
?>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Dashboard Regional</span></h4>



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

            <!-- Data Dashboard Table -->
            <div class="card">
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Kantor Tujuan</th>
                                <th>Selisih Kurang Berat Kiriman</th>
                                <th>Salah Tempel Resi</th>
                                <th>Salah Salur Kiriman</th>
                                <th>Gagal X-Ray</th>
                                <th>Kiriman Rusak</th>
                                <th>Isi Kiriman Tidak Sesuai</th>
                                <th>Selisih Kurang Item Kiriman</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($labels as $index => $label) {
                                echo "<tr><td>$label</td>";
                                foreach ($datasets as $key => $data) {
                                    echo "<td>" . $data[$index] . "</td>";
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <br>
            <br>

            <!-- Grafik Garis -->
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Grafik Irregularitas per Kantor Tujuan</h5>
                    <canvas id="lineChart"></canvas>
                    <script>
                        var ctx = document.getElementById('lineChart').getContext('2d');
                        var lineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: <?php echo json_encode($labels); ?>,  // Data untuk sumbu X
                                datasets: [
                                    {
                                        label: 'Selisih Kurang Berat Kiriman',
                                        data: <?php echo json_encode($datasets['selisih_kurang_berat_kiriman']); ?>,
                                        borderColor: 'rgba(255, 99, 132, 1)',
                                        fill: false
                                    },
                                    {
                                        label: 'Salah Tempel Resi',
                                        data: <?php echo json_encode($datasets['salah_tempel_resi']); ?>,
                                        borderColor: 'rgba(54, 162, 235, 1)',
                                        fill: false
                                    },
                                    {
                                        label: 'Salah Salur Kiriman',
                                        data: <?php echo json_encode($datasets['salah_salur_kiriman']); ?>,
                                        borderColor: 'rgba(255, 206, 86, 1)',
                                        fill: false
                                    },
                                    {
                                        label: 'Gagal X-Ray',
                                        data: <?php echo json_encode($datasets['gagal_xray']); ?>,
                                        borderColor: 'rgba(75, 192, 192, 1)',
                                        fill: false
                                    },
                                    {
                                        label: 'Kiriman Rusak',
                                        data: <?php echo json_encode($datasets['kiriman_rusak']); ?>,
                                        borderColor: 'rgba(153, 102, 255, 1)',
                                        fill: false
                                    },
                                    {
                                        label: 'Isi Kiriman Tidak Sesuai',
                                        data: <?php echo json_encode($datasets['isi_kiriman_tidak_sesuai']); ?>,
                                        borderColor: 'rgba(255, 159, 64, 1)',
                                        fill: false
                                    },
                                    {
                                        label: 'Selisih Kurang Item Kiriman',
                                        data: <?php echo json_encode($datasets['selisih_kurang_item_kiriman']); ?>,
                                        borderColor: 'rgba(255, 99, 132, 0.5)',
                                        fill: false
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                    tooltip: {
                                        mode: 'index',
                                        intersect: false,
                                    }
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Nama Kantor Tujuan'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Jumlah Irregularitas'
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>

        </div>
    </div>
</body>
</html>
