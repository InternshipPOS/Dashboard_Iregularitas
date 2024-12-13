<?php
session_start();
if (!isset($_SESSION['admin_nama'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href = 'auth-login-admin.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Manage Regional|Iregularitas</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />
    <style>
        .table {
            height: 600px;
            overflow-y: auto;
            table-layout: auto;
        }

        .table td,
        .table th {
            padding: 1.5rem;
            vertical-align: top;
            word-wrap: break-word;
            white-space: normal;
        }

        #dataTable thead th:nth-child(8) {
            background-color: #8eaadb;
        }

        .table tbody td:nth-child(8) {
            background-color: #8eaadb;
        }

        /* Mengubah warna latar belakang header kolom "Rincian Root Cause" */
        #dataTable thead th:nth-child(18) {
            background-color: #e6b8af;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(19) {
            background-color: #fbe5d5;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(20) {
            background-color: #c5e0b3;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(21) {
            background-color: #fdd97c;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(22) {
            background-color: #c5e0b3;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(23) {
            background-color: #f2f2f2;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(24) {
            background-color: #fdd97c;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        #dataTable thead th:nth-child(25) {
            background-color: #8eaadb;
            /* Warna khusus untuk header "Rincian Root Cause" */
        }

        .aksi {
            min-width: 100px;
        }

        .read-more {
            color: blue;
            cursor: pointer;
        }

        .pagination-wrapper {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .no-results {
            display: none;
            color: red;
            text-align: center;
            margin-top: 10px;
        }

        .aksi .btn {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.3s ease;
            border-radius: 4px;
            padding: 0.375rem 0.75rem;
        }

        .aksi .btn-primary:hover {
            background-color: #004085;
            border-color: #003765;
        }

        .aksi .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .aksi .btn:hover {
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.15);
        }
    </style>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
                <div class="app-brand demo">
                    <a href="index.php" class="app-brand-link d-flex align-items-center">
                        <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45" class="me-2">
                        <span class="app-brand-text menu-text fw-bolder ms-2" style="font-size: 1.5rem;">ReguTrack</span>
                    </a>

                    <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
                        <i class="bx bx-chevron-left bx-sm align-middle"></i>
                    </a>
                </div>

                <div class="menu-inner-shadow"></div>

                <ul class="menu-inner py-1">
                    <!-- Index -->
                    <li class="menu-item active">
                        <a href="index.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                            <div data-i18n="Analytics">Dashboard</div>
                        </a>
                    </li>

                    <li class="menu-header small text-uppercase">
                        <span class="menu-header-text">Pages</span>
                    </li>
                    <li class="menu-item">
                        <a href="../html/pages-regional.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-dock-top"></i>
                            <div data-i18n="Account Settings">Manage Regional</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../html/monitoring.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-line-chart"></i>
                            <div data-i18n="Account Settings">Monitoring Regional</div>
                        </a>
                    </li>
                    <li class="menu-item">
                        <a href="../html/manage-user.php" class="menu-link">
                            <i class="menu-icon tf-icons bx bx-user"></i>
                            <div data-i18n="Account Settings">Manage User</div>
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
                                    id="searchInput"
                                    class="form-control border-0 shadow-none"
                                    placeholder=""
                                    aria-label="Search..."
                                    oninput="filterTable()" />
                            </div>
                        </div>
                        <!-- /Search -->

                        <ul class="navbar-nav flex-row align-items-center ms-auto">
                            
                            <!-- User -->
                            <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                    <div class="avatar avatar-online">
                                        <img src="../assets/img/avatars/6.png" alt class="w-px-40 h-auto rounded-circle" />
                                    </div>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end">
                                    <li>
                                        <a class="dropdown-item" href="#">
                                            <div class="d-flex">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="avatar avatar-online">
                                                        <img src="../assets/img/avatars/6.png" alt class="w-px-40 h-auto rounded-circle" />
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <span class="fw-semibold d-block">Admin Pusat</span>
                                                    <small class="text-muted">Admin</small>
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
                <div class="content-wrapper">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <?php
                    // Database connection setup
                    $host = "localhost";
                    $user = "root";
                    $password = "";
                    $database = "iregularitas";
                    $koneksi = mysqli_connect($host, $user, $password, $database);

                    if ($koneksi->connect_error) {
                        die("Connection failed: " . $koneksi->connect_error);
                    }

                    // Ambil data Regional dari ref_kcu_kc
                    $regional_query = "SELECT DISTINCT Regional FROM ref_kcu_kc";
                    $regional_result = $koneksi->query($regional_query);
                    ?>

                    <!-- Form untuk memilih Regional -->
                    <form method="GET" action="" class="mb-4 p-3 bg-light rounded shadow-sm">
                        <div class="row">
                            <!-- Filter Regional -->
                            <div class="col-md-4 mb-3">
                                <label for="regional" class="form-label fw-bold">Pilih Regional:</label>
                                <select name="regional" id="regional" class="form-select">
                                    <option value="">--Pilih Regional--</option>
                                    <?php
                                    while ($regional = $regional_result->fetch_assoc()) {
                                        $selected = ($regional['Regional'] == $selected_regional) ? 'selected' : '';
                                        echo "<option value='{$regional['Regional']}' $selected>{$regional['Regional']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Filter Year -->
                            <div class="col-md-4 mb-3">
                                <label for="year" class="form-label fw-bold">Pilih Tahun:</label>
                                <select name="year" id="year" class="form-select">
                                    <option value="">--Pilih Tahun--</option>
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
                                <label for="week" class="form-label fw-bold">Pilih Minggu (Week):</label>
                                <select name="week" id="week" class="form-select">
                                    <option value="">--Pilih Minggu--</option>
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

                    <?php
                    // Definisikan variabel default untuk year dan week
                    $selected_regional = $selected_year = $selected_week = '';

                    // Menangani inputan filter yang dipilih
                    $conditions = [];
                    if (isset($_GET['regional']) && $_GET['regional'] != '') {
                        $selected_regional = $_GET['regional'];
                        $conditions[] = "report_agung.ZonaTujuan = '$selected_regional'";
                    }
                    if (isset($_GET['year']) && $_GET['year'] != '') {
                        $selected_year = $_GET['year'];
                        $conditions[] = "report_agung.Tahun_BA = '$selected_year'";
                    }
                    if (isset($_GET['week']) && $_GET['week'] != '') {
                        $selected_week = $_GET['week'];
                        $conditions[] = "report_agung.Week = '$selected_week'";
                    }

                    // Mengecek apakah ada filter yang dipilih
                    if (empty($conditions)) {
                        echo '<p class="text-center">Silakan pilih filter untuk menampilkan data.</p>';
                    } else {
                        // Menyusun query dinamis berdasarkan kondisi yang ada
                        $sql = "SELECT 
                            report_agung.ID_Sistem, report_agung.ZonaAsal, report_agung.Nama_Kantor_Asal, report_agung.Kantor_Asal,
                            report_agung.Tanggal_Berita_Acara, report_agung.ZonaTujuan, report_agung.Nama_Kantor_Tujuan, report_agung.Kantor_Tujuan, 
                            report_agung.Deskripsi, report_agung.DNLN, report_agung.Nomor_Kiriman, report_agung.Uraian_Berita_Acara, 
                            report_agung.Deskripsi_Iregularitas, report_agung.Tahun_BA, report_agung.Bulan_BA, report_agung.Week, report_agung.month_name,
                            newreport.Rincian_Root_Cause, newreport.Referensi_Root_Cause, newreport.Tindakan_Pencegahan, newreport.Corrective_Action, 
                            newreport.Locus, newreport.Nama_NIK_Pegawai, newreport.No_Evidence, newreport.Validasi_Regional, newreport.Validasi_Pusat, newreport.File_Path
                        FROM 
                            report_agung
                        LEFT JOIN 
                            newreport ON report_agung.ID_Sistem = newreport.ID_Sistem";

                        if (!empty($conditions)) {
                            $sql .= " WHERE " . implode(" AND ", $conditions);
                        }

                        // Hitung total data yang sesuai filter
                        $result = $koneksi->query($sql);
                        $totalData = $result->num_rows;

                        // Konfigurasi paginasi
                        $dataPerPage = 100;
                        $totalPages = ceil($totalData / $dataPerPage);
                        $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $startIndex = ($currentPage - 1) * $dataPerPage;

                        // Query dengan paginasi
                        $sql .= " LIMIT $startIndex, $dataPerPage";
                        $paginatedResult = $koneksi->query($sql);

                        if ($totalData > 0) {
                            echo '<div class="card"><div class="table-responsive text-nowrap"><table class="table" id="dataTable">';
                            echo '
                            <thead>
                                <tr>
                                    <th class="aksi">Aksi</th>
                                    <th>ID Sistem</th>
                                    <th>Reg Asal P6</th>
                                    <th>Kantor Asal P6</th>
                                    <th>Nopend Asal P6</th>
                                    <th>Tanggal Berita Acara</th>
                                    <th>Reg Tujuan P6</th>
                                    <th>Kantor Tujuan P6</th>
                                    <th>Nopend Tujuan P6</th>
                                    <th>Deskripsi</th>
                                    <th>DN/LN</th>
                                    <th>Nomor Kiriman</th>
                                    <th>Uraian Berita Acara</th>
                                    <th>Deskripsi Iregularitas</th>
                                    <th>Tahun</th>
                                    <th>Bulan</th>
                                    <th>Week</th>
                                    <th>Rincian Root Cause</th>
                                    <th>Referensi Root Cause</th>
                                    <th>Tindakan Pencegahan</th>
                                    <th>Corrective Action</th>
                                    <th>Locus</th>
                                    <th>Nama NIK Pegawai</th>
                                    <th>No Evidence</th>
                                    <th>Validasi Regional</th>
                                    <th>Validasi Pusat</th>
                                    <th>File Evidence</th>
                                </tr>
                            </thead>';
                            echo '<tbody>';
                            while ($row = $paginatedResult->fetch_assoc()) {
                                echo '<tr>';
                                echo '<td class="aksi">
                                    <a href="../crud_regional/update.php?id_sistem=' . $row['ID_Sistem'] . '" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                                            <i class="bx bx-edit"></i> Edit
                                    </a>
                                    <a href="../crud_regional/delete.php" class="btn btn-danger delete-btn" data-id="' . $row['ID_Sistem'] . '">Delete</a>
                                </td>';
                                echo '<td>' . $row['ID_Sistem'] . '</td>';
                                echo '<td>' . $row['ZonaAsal'] . '</td>';
                                echo '<td>' . $row['Nama_Kantor_Asal'] . '</td>';
                                echo '<td>' . $row['Kantor_Asal'] . '</td>';
                                echo '<td>' . date('Y-m-d', strtotime($row['Tanggal_Berita_Acara'])) . '</td>';
                                echo '<td>' . $row['ZonaTujuan'] . '</td>';
                                echo '<td>' . $row['Nama_Kantor_Tujuan'] . '</td>';
                                echo '<td>' . $row['Kantor_Tujuan'] . '</td>';
                                echo '<td>' . $row['Deskripsi'] . '</td>';
                                echo '<td>' . $row['DNLN'] . '</td>';
                                echo '<td>';
                                $nomorKiriman = $row['Nomor_Kiriman'];
                                    if (strlen($nomorKiriman) > 28) {
                                        $short_text_nomor = substr($nomorKiriman, 0, 24);
                                        $full_text_nomor = substr($nomorKiriman, 24);
                                        echo '<span class="short-text">' . $short_text_nomor . '</span>';
                                        echo '<span class="full-text" style="display: none;">' . $full_text_nomor . '</span>';
                                        echo '<span class="read-more-btn" style="color: blue; cursor: pointer;">Baca Selengkapnya</span>';
                                    } else {
                                        echo $nomorKiriman;
                                    }
                                    echo '</td>';
                                echo '<td>';
                                $uraian = $row['Uraian_Berita_Acara'];
                                    if (strlen($uraian) > 100) {
                                        $short_text_uraian = substr($uraian, 0, 100);
                                        $full_text_uraian = substr($uraian, 100);
                                        echo '<span class="short-text">' . $short_text_uraian . '</span>';
                                        echo '<span class="full-text" style="display: none;">' . $full_text_uraian . '</span>';
                                        echo '<span class="read-more-btn" style="color: blue; cursor: pointer;">Baca Selengkapnya</span>';
                                    } else {
                                        echo $uraian;
                                    }
                                echo '<td>' . $row['Deskripsi_Iregularitas'] . '</td>';
                                echo '<td>' . $row['Tahun_BA'] . '</td>';
                                echo '<td>' . $row['month_name'] . '</td>';
                                echo '<td>' . $row['Week'] . '</td>';
                                echo '<td>' . $row['Rincian_Root_Cause'] . '</td>';
                                echo '<td>' . $row['Referensi_Root_Cause'] . '</td>';
                                echo '<td>' . $row['Tindakan_Pencegahan'] . '</td>';
                                echo '<td>' . $row['Corrective_Action'] . '</td>';
                                echo '<td>' . $row['Locus'] . '</td>';
                                echo '<td>' . $row['Nama_NIK_Pegawai'] . '</td>';
                                echo '<td>' . $row['No_Evidence'] . '</td>';
                                echo '<td>' . $row['Validasi_Regional'] . '</td>';
                                echo '<td>' . $row['Validasi_Pusat'] . '</td>';
                                // Kolom untuk menampilkan link file jika ada    
                                echo '<td>';
                                if (!empty($row['File_Path'])) {
                                    // Tampilkan link file jika ada
                                    echo '<a href="../crud_user_setting_reg/uploads/' . basename($row['File_Path']) . '" target="_blank">Download File</a>';
                                } else {
                                    echo 'Belum Ada File';
                                }
                                echo '</td>';
                                echo '</tr>';
                            }
                            echo '</tbody>';
                            echo '</table></div></div>';
                            
                            // Pagination message
                            $startResult = $startIndex + 1;
                            $endResult = min($startIndex + $dataPerPage, $totalData);
                            echo "<div class='pagination-wrapper'>
                                    <small class='text-muted'>Menampilkan $startResult-$endResult dari total $totalData hasil</small>
                                    <nav aria-label='Page navigation'>
                                        <ul class='pagination justify-content-end'>";

                            // Prev button
                            echo '<li class="page-item ' . ($currentPage <= 1 ? 'disabled' : '') . '">
                                    <a class="page-link" href="?page=' . max(1, $currentPage - 1) . '&regional=' . $selected_regional . '&year=' . $selected_year . '&week=' . $selected_week . '" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>';

                            // Page numbers
                            for ($i = 1; $i <= $totalPages; $i++) {
                                echo '<li class="page-item ' . ($i == $currentPage ? 'active' : '') . '">
                                        <a class="page-link" href="?page=' . $i . '&regional=' . $selected_regional . '&year=' . $selected_year . '&week=' . $selected_week . '">' . $i . '</a>
                                    </li>';
                            }

                            // Next button
                            echo '<li class="page-item ' . ($currentPage >= $totalPages ? 'disabled' : '') . '">
                                    <a class="page-link" href="?page=' . min($totalPages, $currentPage + 1) . '&regional=' . $selected_regional . '&year=' . $selected_year . '&week=' . $selected_week . '" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>';

                            // Close pagination list and navigation
                            echo '</ul></nav></div>';

                            } else {
                                echo '<p class="text-center">Tidak ada data yang sesuai dengan filter yang dipilih.</p>';
                            }
                        }
                    ?>
                </div>
            </div>
        </div>
    </div>
        <!-- External Scripts -->
        <script src="../assets/vendor/libs/jquery/jquery.js"></script>
        <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
        <script src="../assets/vendor/js/bootstrap.js"></script>
        <script src="../assets/vendor/js/menu.js"></script>
        <script src="../assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- Delete Confirmation Script -->
        <script>
            $(document).ready(function() {
                $('.delete-btn').click(function(e) {
                    e.preventDefault();
                    var id = $(this).data('id'); // ambil id dari atribut data-id

                    Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Data ini akan dihapus!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Hapus'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url: '../crud_regional/delete.php',
                                type: 'POST',
                                data: {
                                    id_sistem: id
                                },
                                success: function(response) {
                                    if (response == 'success') {
                                        Swal.fire(
                                            'Dihapus!',
                                            'Data telah berhasil dihapus.',
                                            'success'
                                        );
                                        // Menghapus baris dari tabel
                                        $('a.delete-btn[data-id="' + id + '"]').closest('tr').fadeOut();
                                    } else {
                                        Swal.fire(
                                            'Gagal!',
                                            'Data gagal dihapus.',
                                            'error'
                                        );
                                    }
                                }
                            });
                        }
                    });
                });
            });
        </script>

        <!-- Table Filter Script -->
        <script>
            function filterTable() {
                let input = document.getElementById('searchInput').value.toLowerCase();
                let table = document.getElementById("dataTable");
                let tr = table.getElementsByTagName("tr");
                let noResults = document.getElementById("noResults");
                let found = false;

                // Menyembunyikan seluruh baris tabel kecuali header
                for (let i = 1; i < tr.length; i++) {
                    tr[i].style.display = "none"; // Sembunyikan semua baris
                }

                // Menampilkan baris yang sesuai dengan hasil pencarian
                for (let i = 1; i < tr.length; i++) {
                    let idSistem = tr[i].getElementsByTagName("td")[1]?.textContent.toLowerCase();
                    let tahunBA = tr[i].getElementsByTagName("td")[14]?.textContent.toLowerCase(); // Kolom Tahun_BA
                    let week = tr[i].getElementsByTagName("td")[15]?.textContent.toLowerCase(); // Kolom Week
                    let zonaTujuan = tr[i].getElementsByTagName("td")[6]?.textContent.toLowerCase(); // Kolom ZonaTujuan

                    // Cek apakah input ada di salah satu kolom
                    if (idSistem.includes(input) || tahunBA.includes(input) || week.includes(input) || zonaTujuan.includes(input)) {
                        tr[i].style.display = ""; // Tampilkan baris yang sesuai
                        found = true;
                    }
                }

                // Tampilkan atau sembunyikan pesan jika tidak ada hasil
                noResults.style.display = found ? "none" : "block";
            }
        </script>

        <!-- Toggle Full Text Display -->
        <script>
            $(document).on('click', '.read-more-btn', function() {
                var $shortText = $(this).siblings('.short-text');
                var $fullText = $(this).siblings('.full-text');
                if ($fullText.is(':visible')) {
                    $shortText.show();
                    $fullText.hide();
                    $(this).text('Baca Selengkapnya');
                } else {
                    $shortText.hide();
                    $fullText.show();
                    $(this).text('Tutup');
                }
            });
        </script>

        <!-- Logout Confirmation -->
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
                        window.location.href = '../html/auth-login-admin.php';
                    }
                })
            }
        </script>

    </body>

</html>