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

        .table td, .table th {
            padding: 1.5rem;
            vertical-align: top;
            word-wrap: break-word;
            white-space: normal;
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

        /* CSS untuk memberikan jarak antar tombol dan efek hover */
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

        /* Efek shadow */
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
                        oninput="filterTable()"
                    />
                </div>
            </div>
            <!-- /Search -->

            <ul class="navbar-nav flex-row align-items-center ms-auto">
              <!-- Place this tag where you want the button to render. -->
              <li class="nav-item lh-1 me-3">
                <a
                  class="github-button"
                  href="https://github.com/themeselection/sneat-html-admin-template-free"
                  data-icon="octicon-star"
                  data-size="large"
                  data-show-count="true"
                  aria-label="Star themeselection/sneat-html-admin-template-free on GitHub">Star</a>
              </li>

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
                    <a class="dropdown-item" href="#">
                      <i class="bx bx-cog me-2"></i>
                      <span class="align-middle">Settings</span>
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="#">
                      <span class="d-flex align-items-center align-middle">
                        <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                        <span class="flex-grow-1 align-middle">Billing</span>
                        <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                      </span>
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

            <!-- Pesan tidak ada hasil pencarian -->
            <div id="noResults" class="no-results">No matching results found</div>

            <!-- Data Table -->
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table" id="dataTable">
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
                                <th>Rincian Root Cause</th> <!-- New column -->
                                <th>Referensi Root Cause</th> <!-- New column -->
                                <th>Tindakan Pencegahan</th> <!-- New column -->
                                <th>Corrective Action</th> <!-- New column -->
                                <th>Locus</th> <!-- New column -->
                                <th>Nama NIK Pegawai</th> <!-- New column -->
                                <th>No Evidence</th> <!-- New column -->
                                <th>Validasi Regional</th> <!-- New column -->
                                <th>Validasi Pusat</th> <!-- New column -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $host = "localhost"; 
                            $user = "root"; 
                            $password = ""; 
                            $database = "iregularitas"; 

                            $koneksi = mysqli_connect($host, $user, $password, $database);

                            if ($koneksi->connect_error) {
                                die("Connection failed: " . $koneksi->connect_error);
                            }

                            // Pagination variables
                            $limit = 1000; 
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; 
                            $offset = ($page - 1) * $limit; 

                            // Get total records for pagination
                            $total_sql = "SELECT COUNT(*) AS total FROM report_agung";
                            $total_result = $koneksi->query($total_sql);
                            $total_row = $total_result->fetch_assoc();
                            $total_records = $total_row['total'];
                            $total_pages = ceil($total_records / $limit); 

                            // Get total records for newreport
                            $total_sql_newreport = "SELECT COUNT(*) AS total FROM newreport";
                            $total_result_newreport = $koneksi->query($total_sql_newreport);
                            $total_row_newreport = $total_result_newreport->fetch_assoc();
                            $total_records_newreport = $total_row_newreport['total'];

                            // Total records for pagination
                            $total_records = $total_records + $total_records_newreport; // Adjusted line
                            $total_pages = ceil($total_records / $limit); 

                            // Initialize query for report_agung
                            $sql = "SELECT ID_Sistem, ZonaAsal, Nama_Kantor_Asal, Kantor_Asal, Tanggal_Berita_Acara, ZonaTujuan, Nama_Kantor_Tujuan, Kantor_Tujuan, Deskripsi, DNLN, Nomor_Kiriman, Uraian_Berita_Acara, Deskripsi_Iregularitas, Tahun_BA, Bulan_BA, Week, month_name FROM report_agung LIMIT $limit OFFSET $offset";
                            $result = $koneksi->query($sql);

                            // Initialize query for newreport
                            $sql_newreport = "SELECT Rincian_Root_Cause, Referensi_Root_Cause, Tindakan_Pencegahan, Corrective_Action, Locus, Nama_NIK_Pegawai, No_Evidence, Validasi_Regional, Validasi_Pusat FROM newreport LIMIT $limit OFFSET $offset";
                            $result_newreport = $koneksi->query($sql_newreport);

                            // Check if both queries return data
                            if ($result->num_rows > 0 || $result_newreport->num_rows > 0) :
                                // Loop for report_agung data
                                while ($row = $result->fetch_assoc()) :
                                    // Fetch newreport data for the corresponding row
                                    $row_newreport = $result_newreport->fetch_assoc();
                            ?>
                                <tr>
                                <td class="aksi">
                                    <a href="../crud_regional/update.php?id_sistem=<?php echo $row['ID_Sistem']; ?>" class="btn btn-primary btn-sm d-flex align-items-center gap-1">
                                        <i class="bx bx-edit"></i> Edit
                                    </a>
                                    <a href="../crud_regional/delete.php" class="btn btn-danger btn-sm delete-btn d-flex align-items-center gap-1" data-id="<?php echo $row['ID_Sistem']; ?>">
                                        <i class="bx bx-trash"></i> Delete
                                    </a>
                                </td>


                                    <td><?php echo $row['ID_Sistem']; ?></td>
                                    <td><?php echo $row['ZonaAsal']; ?></td>
                                    <td><?php echo $row['Nama_Kantor_Asal']; ?></td>
                                    <td><?php echo $row['Kantor_Asal']; ?></td>
                                    <td><?php echo date('Y-m-d', strtotime($row['Tanggal_Berita_Acara'])); ?></td>
                                    <td><?php echo $row['ZonaTujuan']; ?></td>
                                    <td><?php echo $row['Nama_Kantor_Tujuan']; ?></td>
                                    <td><?php echo $row['Kantor_Tujuan']; ?></td>
                                    <td><?php echo $row['Deskripsi']; ?></td>
                                    <td><?php echo $row['DNLN']; ?></td>
                                    <td><?php echo $row['Nomor_Kiriman']; ?></td>
                                    <td><?php echo $row['Uraian_Berita_Acara']; ?></td>
                                    <td><?php echo $row['Deskripsi_Iregularitas']; ?></td>
                                    <td><?php echo $row['Tahun_BA']; ?></td>
                                    <td><?php echo $row['Bulan_BA']; ?></td>
                                    <td><?php echo $row['Week']; ?></td>
                                    <td><?php echo isset($row_newreport['Rincian_Root_Cause']) ? $row_newreport['Rincian_Root_Cause'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Referensi_Root_Cause']) ? $row_newreport['Referensi_Root_Cause'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Tindakan_Pencegahan']) ? $row_newreport['Tindakan_Pencegahan'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Corrective_Action']) ? $row_newreport['Corrective_Action'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Locus']) ? $row_newreport['Locus'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Nama_NIK_Pegawai']) ? $row_newreport['Nama_NIK_Pegawai'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['No_Evidence']) ? $row_newreport['No_Evidence'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Validasi_Regional']) ? $row_newreport['Validasi_Regional'] : ''; ?></td>
                                    <td><?php echo isset($row_newreport['Validasi_Pusat']) ? $row_newreport['Validasi_Pusat'] : ''; ?></td>
                                </tr>
                            <?php
                                endwhile;
                            else :
                            ?>
                                <tr>
                                    <td colspan="16" class="text-center">No data available</td>
                                </tr>
                            <?php
                            endif;
                            ?>
                            
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="pagination-wrapper">
                    <small class="text-muted">Menampilkan <?php echo $offset + 1; ?> sampai <?php echo min($offset + $limit, $total_records); ?> dari total <?php echo $total_records; ?> hasil</small>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-end">
                            <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>" aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                                <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>" aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

     <!-- Scripts -->
     <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
                            url: '../crud_regional6/delete.php',
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

        <!-- JavaScript untuk Filter -->
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

        <script>
            // Toggle full text display on click
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
                  window.location.href = '../html/auth-login-admin.php';
              }
          })
      }
    </script>
</body>

</html>
