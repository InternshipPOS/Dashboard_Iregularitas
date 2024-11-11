<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Monitoring Regional </title>
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
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Monitoring Regional</span></h4>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="pages-regional.php" class="btn btn-primary btn-back">Back</a>
            </div>

            <!-- Data Monitoring Table -->
            <div class="card">
                <div class="card-body">
                    <?php
                    // Koneksi ke database
                    $host = "localhost";
                    $user = "root";
                    $password = "";
                    $database = "iregularitas";

                    $koneksi = new mysqli($host, $user, $password, $database);

                    // Cek koneksi
                    if ($koneksi->connect_error) {
                        die("Connection failed: " . $koneksi->connect_error);
                    }

                    // Query untuk mengambil data dari dua tabel dalam satu database
                    $sql_data = "
                        SELECT 
                            r.Nama_Kantor_Tujuan, 
                            SUM(CASE WHEN r.validasi_pusat = 'ok' THEN 1 ELSE 0 END) AS total_ok,
                            SUM(CASE WHEN r.validasi_pusat = 'belum entri evaluasi' THEN 1 ELSE 0 END) AS total_belum_antri,
                            SUM(CASE WHEN r.validasi_pusat = 'evidence belum upload' THEN 1 ELSE 0 END) AS total_evidence_belum_upload
                        FROM `iregularitas`.`report_agung` r  -- Menggunakan view report_agung di database iregularitas
                        GROUP BY r.Nama_Kantor_Tujuan
                    ";

                    // Menjalankan query
                    $result_data = $koneksi->query($sql_data);

                    // Cek apakah query berhasil dijalankan
                    if (!$result_data) {
                        die("Error: " . $koneksi->error);
                    }

                    // Menampilkan hasil
                    echo '<table class="table table-bordered table-striped">';
                    echo '<thead><tr><th>Kantor Tujuan</th><th>Total OK</th><th>Total Belum Antri</th><th>Total Evidence Belum Upload</th></tr></thead>';
                    echo '<tbody>';

                    while ($row = $result_data->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['Nama_Kantor_Tujuan']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_ok']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_belum_antri']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['total_evidence_belum_upload']) . "</td>";
                        echo "</tr>";
                    }

                    // Menampilkan grand total
                    $grand_total_ok = 0;
                    $grand_total_belum_antri = 0;
                    $grand_total_evidence_belum_upload = 0;

                    // Reset result pointer for grand total calculation
                    $result_data->data_seek(0);
                    while ($row = $result_data->fetch_assoc()) {
                        $grand_total_ok += $row['total_ok'];
                        $grand_total_belum_antri += $row['total_belum_antri'];
                        $grand_total_evidence_belum_upload += $row['total_evidence_belum_upload'];
                    }

                    echo "<tr class='grand-total'><td><strong>Grand Total</strong></td><td><strong>$grand_total_ok</strong></td><td><strong>$grand_total_belum_antri</strong></td><td><strong>$grand_total_evidence_belum_upload</strong></td></tr>";
                    echo '</tbody>';
                    echo '</table>';

                    $koneksi->close();
                    ?>

                </div>
            </div>
        </div>
        
         <!-- Footer -->
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