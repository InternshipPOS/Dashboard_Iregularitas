<?php
session_start();
include('config.php');  // Pastikan koneksi ke database sudah dilakukan

// Ambil NIK pengguna yang sudah login
$nik_user = $_SESSION['nik'];

// Query untuk mendapatkan regional pengguna
$query = "SELECT regional FROM loginreg WHERE nik = '$nik_user'";
$result = $koneksi->query($query);

if ($result->num_rows > 0) {
  $row = $result->fetch_assoc();
  $user_regional = $row['regional'];
} else {
  echo "Regional tidak ditemukan.";
}


// Get user's regional information from session
$regional = $_SESSION['regional'];

// Asumsi: koneksi database sudah ada melalui $koneksi
$user_id = $_SESSION['id']; // ID user yang sudah login

// Query untuk mengambil data kantor_asal dari database
$query = "SELECT kantor_asal FROM user WHERE id = ?";
$stmt = $koneksi->prepare($query);  // Menggunakan $koneksi sesuai yang ada di config.php
$stmt->bind_param('i', $user_id);
$stmt->execute();
$stmt->bind_result($kantor_asal);
$stmt->fetch();

// Menyimpan kantor_asal ke dalam session
$_SESSION['kantor_asal'] = $kantor_asal; 

$stmt->close();

// Menutup koneksi database
$koneksi->close();
?>


<!DOCTYPE html>
<html
  lang="en"
  class="light-style layout-menu-fixed"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="../assets/"
  data-template="vertical-menu-template-free">

<head>
  <meta charset="utf-8" />
  <meta
    name="viewport"
    content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

  <title>Dashboard Iregularitas</title>

  <meta name="description" content="" />

  <!-- Favicon -->
  <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />

  <!-- Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
    rel="stylesheet" />

  <!-- Icons. Uncomment required icon fonts -->
  <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

  <!-- Core CSS -->
  <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
  <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
  <link rel="stylesheet" href="../assets/css/demo.css" />

  <!-- Vendors CSS -->
  <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

  <link rel="stylesheet" href="../assets/vendor/libs/apex-charts/apex-charts.css" />

  <!-- Page CSS -->

  <!-- Helpers -->
  <script src="../assets/vendor/js/helpers.js"></script>

  <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
  <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
  <script src="../assets/js/config.js"></script>
  <!-- SweetAlert2 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
</head>
<?php

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
  <!-- Layout wrapper -->
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      <!-- Menu -->

      <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
        <div class="app-brand demo">
          <a href="dashboard.php" class="app-brand-link d-flex align-items-center">
            <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45" class="me-2">
            <span class="app-brand-text menu-text fw-bolder ms-2" style="font-size: 1.5rem;">ReguTrack</span>
          </a>

          <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
            <i class="bx bx-chevron-left bx-sm align-middle"></i>
          </a>
        </div>

        <div class="menu-inner-shadow"></div>

        <ul class="menu-inner py-1">
          <!-- Dashboard -->
          <li class="menu-item active">
            <a href="dashboard.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-home-circle"></i>
              <div data-i18n="Analytics">Dashboard</div>
            </a>
          </li>

          <li class="menu-header small text-uppercase">
            <span class="menu-header-text">Pages</span>
          </li>
          <li class="menu-item">
            <a href="../user/user-setting-reg.php?regional=<?php echo $user_regional; ?>" class="menu-link">
              <i class="menu-icon tf-icons bx bx-dock-top"></i>
              <div data-i18n="Account Settings">Manage Regional</div>
            </a>
          </li>
          <li class="menu-item">
            <a href="../user/monitoring_regional.php" class="menu-link">
              <i class="menu-icon tf-icons bx bx-line-chart"></i>
              <div data-i18n="Account Settings">Monitoring</div>
            </a>
          </li>
        </ul>
        <ul>
          <!-- Logout - Item ditempatkan di luar ul utama -->
          <li class="menu-item">
            <a class="menu-link" href="#" onclick="confirmLogout()">
              <i class="menu-icon tf-icons bx bx-exit"></i>
              <div data-i18n="Log Out">Log Out</div>
            </a>
          </li>
        </ul>
      </aside>
      <!-- / Menu -->

      <!-- Layout container -->
      <div class="layout-page">
        <!-- Navbar -->

        <nav
          class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme"
          id="layout-navbar">
          <div class="layout-menu-toggle navbar-nav align-items-xl-center me-3 me-xl-0 d-xl-none">
            <a class="nav-item nav-link px-0 me-xl-4" href="javascript:void(0)">
              <i class="bx bx-menu bx-sm"></i>
            </a>
          </div>

          <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
            <!-- Search -->
            <div class="navbar-nav align-items-center">
              <div class="nav-item d-flex align-items-center">
                <i class="bx bx-search fs-4 lh-0"></i>
                <input
                  type="text"
                  class="form-control border-0 shadow-none"
                  placeholder="Search..."
                  aria-label="Search..." />
              </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- User -->
              <li class="nav-item navbar-dropdown dropdown-user dropdown">
                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                  <div class="avatar avatar-online">
                    <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                  </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                  <li>
                    <a class="dropdown-item" href="#">
                      <div class="d-flex">
                        <div class="flex-shrink-0 me-3">
                          <div class="avatar avatar-online">
                            <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                          </div>
                        </div>
                        <div class="flex-grow-1">
                          <span class="fw-semibold d-block">
                            <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>
                          </span>
                          <small class="text-muted">
                            <?php echo isset($_SESSION['jenis']) ? $_SESSION['jenis'] : 'Jenis tidak ditemukan'; ?>
                          </small>
                        </div>
                      </div>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="../user/profile.php">
                      <i class="bx bx-user me-2"></i>
                      <span class="align-middle">My Profile</span>
                    </a>
                  </li>
                  <li>
                    <div class="dropdown-divider"></div>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#" onclick="confirmLogout()">
                      <i class="bx bx-power-off me-2"></i>
                      <span class="align-middle">Log Out</span>
                    </a>
                  </li>
                </ul>
              </li>
              <!--/ User -->
            </ul>
          </div>
        </nav>

        <!-- / Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <!-- Content -->

          <div class="container-xxl flex-grow-1 container-p-y">
            <div class="row">
              <div class="col-lg-8 mb-4 order-0">
                <div class="card">
                  <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                      <div class="card-body">
                        <h5 class="card-title text-primary">
                          Hello <?php echo isset($_SESSION['nama']) ? $_SESSION['nama'] : 'User'; ?>!
                          <p><strong><?php echo isset($_SESSION['kantorasal']) ? $_SESSION['kantorasal'] : 'Tidak Ditemukan'; ?></strong></p>
                        </h5>
                        <p class="mb-4">
                          Selamat datang di <span class="fw-bold">dashboard iregularitas</span>, kelola data dengan efisien dan pantau kinerja secara real-time dengan lebih cepat dan tepat.
                        </p>

                        <a href="javascript:;" class="btn btn-sm btn-outline-primary">View Badges</a>
                      </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                      <div class="card-body pb-0 px-0 px-md-4">
                        <img
                          src="../assets/img/illustrations/man-with-laptop-light.png"
                          height="140"
                          alt="View Badge User"
                          data-app-dark-img="illustrations/man-with-laptop-dark.png"
                          data-app-light-img="illustrations/man-with-laptop-light.png" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-lg-4 col-md-4 order-1">
                <div class="row">
                  <div class="col-lg-6 col-md-12 col-6 mb-4">
                   
                </div>
              </div>


          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
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
            <?php
            include('config.php');

            if (!isset($_SESSION['nik'])) {
                header("Location: auth-login-basic.html");
                exit;
            }

            $nik_user = $_SESSION['nik'];

            $query = "SELECT regional FROM loginreg WHERE nik = '$nik_user'";
            $result = $koneksi->query($query);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $logged_in_regional = $row['regional'];
            } else {
                echo "Regional tidak ditemukan.";
                exit;
            }

            $selected_year = $koneksi->real_escape_string($_GET['year'] ?? '');
            $selected_week = $koneksi->real_escape_string($_GET['week'] ?? '');
            $selected_regional = $koneksi->real_escape_string($_GET['regional'] ?? $logged_in_regional);

            $conditions = [];
            if (!empty($selected_regional)) {
                $conditions[] = "r.ZonaTujuan = '$selected_regional'";
            }
            if (!empty($selected_year)) {
                $conditions[] = "r.Tahun_BA = '$selected_year'";
            }
            if (!empty($selected_week)) {
                $conditions[] = "r.Week = '$selected_week'";
            }
            $where_clause = !empty($conditions) ? "WHERE " . implode(' AND ', $conditions) : '';

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

            if ($result_data->num_rows === 0) {
                echo "Tidak ada data ditemukan.";
                exit;
            }

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
                $labels[] = $row['Nama_Kantor_Tujuan'];
                foreach ($datasets as $key => &$data) {
                    $data[] = $row[$key];
                }
            }
            ?>
            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Grafik Irregularitas per Kantor Tujuan</h5>
                    <canvas id="lineChart"></canvas>
                    <script>
                        var ctx = document.getElementById('lineChart').getContext('2d');
                        new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: <?php echo json_encode($labels); ?>,
                                datasets: Object.keys(<?php echo json_encode($datasets); ?>).map((key, index) => ({
                                    label: key.replace(/_/g, ' '),
                                    data: <?php echo json_encode($datasets); ?>[key],
                                    borderColor: `rgba(${(index * 50) % 255}, ${(index * 70) % 255}, ${(index * 90) % 255}, 1)`,
                                    fill: false
                                }))
                            },
                            options: {
                                responsive: true,
                                scales: {
                                    x: {
                                        title: { display: true, text: 'Nama Kantor Tujuan' }
                                    },
                                    y: {
                                        title: { display: true, text: 'Jumlah Irregularitas' }
                                    }
                                }
                            }
                        });
                    </script>
                </div>
            </div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

  <!-- <div class="buy-now">
    <a
      href="https://themeselection.com/products/sneat-bootstrap-html-admin-template/"
      target="_blank"
      class="btn btn-danger btn-buy-now">Upgrade to Pro</a>
  </div> -->

  <!-- Core JS -->
  <!-- build:js assets/vendor/js/core.js -->
  <script src="../assets/vendor/libs/jquery/jquery.js"></script>
  <script src="../assets/vendor/libs/popper/popper.js"></script>
  <script src="../assets/vendor/js/bootstrap.js"></script>
  <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>

  <script src="../assets/vendor/js/menu.js"></script>
  <!-- endbuild -->

  <!-- Vendors JS -->
  <script src="../assets/vendor/libs/apex-charts/apexcharts.js"></script>

  <!-- Main JS -->
  <script src="../assets/js/main.js"></script>

  <!-- Page JS -->
  <script src="../assets/js/dashboards-analytics.js"></script>

  <!-- Place this tag in your head or just before your close body tag. -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  <!-- SweetAlert2 JS -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    function confirmLogout() {
      Swal.fire({
        title: 'Apakah Anda yakin ingin keluar?',
        text: "Anda akan keluar dari sesi saat ini!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, Keluar!',
        cancelButtonText: 'Batal'
      }).then((result) => {
        if (result.isConfirmed) {
          // Redirect ke halaman logout jika pengguna menekan "Ya, Keluar!"
          window.location.href = '../html/auth-login-basic.php';
        }
      })
    }
  </script>
</body>

</html>