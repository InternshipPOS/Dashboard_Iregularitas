<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Monitoring Regional 4</title>
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

<body>
    <!-- <div class="layout-wrapper layout-content-navbar layout-without-menu">
        <div class="layout-container">
            <div class="layout-page">
                <nav class="layout-navbar container-xxl navbar navbar-expand-xl navbar-detached align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/1.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">My Profile</a></li>
                                    <li><div class="dropdown-divider"></div></li>
                                    <li><a class="dropdown-item" href="auth-login-basic.html">Log Out</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav> -->

                <div class="content-wrapper">
                    <div class="container-xxl flex-grow-1 container-p-y">
                        <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Monitoring Regional 4</span></h4>

                        <!-- Back Button -->
                        <div class="mb-3">
                            <a href="../user/user-setting-reg4.php" class="btn btn-primary">Back</a>
                        </div>

                        <!-- Data Monitoring Table -->
                        <div class="card">
                            <div class="card-body">
                                <?php
                                // Koneksi ke database
                                $host = "localhost";
                                $user = "root"; // ganti dengan username MySQL Anda
                                $password = ""; // ganti dengan password MySQL Anda
                                $database = "iregularitas"; // ganti sesuai nama database Anda

                                // Membuat koneksi
                                $koneksi = mysqli_connect($host, $user, $password, $database);

                                // Cek koneksi
                                if (!$koneksi) {
                                    die("Connection failed: " . mysqli_connect_error());
                                }

                                // Mengambil jumlah data untuk masing-masing validasi berdasarkan kantor tujuan P6
                                $sql_data = "
                                    SELECT kantor_tujuan_p6, 
                                        SUM(CASE WHEN validasi_pusat = 'ok' THEN 1 ELSE 0 END) AS total_ok,
                                        SUM(CASE WHEN validasi_pusat = 'belum entri evaluasi' THEN 1 ELSE 0 END) AS total_belum_antri,
                                        SUM(CASE WHEN validasi_pusat = 'evidence belum upload' THEN 1 ELSE 0 END) AS total_evidence_belum_upload
                                    FROM regional4
                                    GROUP BY kantor_tujuan_p6
                                ";

                                $result_data = mysqli_query($koneksi, $sql_data);

                                // Hitung grand total
                                $grand_total_ok = 0;
                                $grand_total_belum_antri = 0;
                                $grand_total_evidence_belum_upload = 0;

                                // Tutup koneksi
                                mysqli_close($koneksi);
                                ?>

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Kantor Tujuan P6</th>
                                            <th>OK</th>
                                            <th>Belum Antri Evaluasi</th>
                                            <th>Evidence Belum Di-upload</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        // Tampilkan data dari query
                                        if (mysqli_num_rows($result_data) > 0) {
                                            while ($row = mysqli_fetch_assoc($result_data)) {
                                                echo "<tr>";
                                                echo "<td>" . $row['kantor_tujuan_p6'] . "</td>";
                                                echo "<td>" . $row['total_ok'] . "</td>";
                                                echo "<td>" . $row['total_belum_antri'] . "</td>";
                                                echo "<td>" . $row['total_evidence_belum_upload'] . "</td>";
                                                echo "</tr>";

                                                // Tambah nilai ke grand total
                                                $grand_total_ok += $row['total_ok'];
                                                $grand_total_belum_antri += $row['total_belum_antri'];
                                                $grand_total_evidence_belum_upload += $row['total_evidence_belum_upload'];
                                            }
                                        } else {
                                            echo "<tr><td colspan='4'>Tidak ada data</td></tr>";
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td><strong>Grand Total</strong></td>
                                            <td><strong><?php echo $grand_total_ok; ?></strong></td>
                                            <td><strong><?php echo $grand_total_belum_antri; ?></strong></td>
                                            <td><strong><?php echo $grand_total_evidence_belum_upload; ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>

                            </div>
                        </div>
                    </div>

                    <footer class="content-footer footer bg-footer-theme">
                        <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                            <div class="mb-2 mb-md-0">
                                © <script>document.write(new Date().getFullYear());</script>, made with ❤️ by <a href="https://themeselection.com" target="_blank" class="footer-link fw-bolder">ThemeSelection</a>
                            </div>
                            <div>
                                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                                <a href="https://themeselection.com/" class="footer-link me-4">More Themes</a>
                                <a href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/" target="_blank" class="footer-link me-4">Documentation</a>
                                <a href="https://themeselection.com/github/sneat-html-admin-template-free/issues" target="_blank" class="footer-link me-4">Support</a>
                            </div>
                        </div>
                    </footer>
                    <div class="content-backdrop fade"></div>
                </div>
            </div>
        </div>

        <script src="../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../assets/vendor/libs/popper/popper.js"></script>
        <script src="../assets/vendor/js/bootstrap.js"></script>
        <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../assets/vendor/js/menu.js"></script>
        <script src="../assets/js/main.js"></script>
    </body>
</html>
