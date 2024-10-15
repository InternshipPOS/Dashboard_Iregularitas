<?php
session_start(); 
if (!isset($_SESSION['nama'])) {
    echo "<script>
            alert('Anda harus login terlebih dahulu!');
            window.location.href = 'auth-login-basic.php';
          </script>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Regional 5 | Iregularitas</title>
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
            /* Ubah sesuai kebutuhan */
            overflow-y: auto;
            /* Untuk scroll jika data lebih dari tinggi yang ditetapkan */
            table-layout: auto;
            /* Memungkinkan lebar kolom menyesuaikan konten */
        }

        .table td,
        .table th {
            padding: 1.5rem;
            /* Ubah padding untuk memperbesar ukuran sel */
            vertical-align: top;
            /* Mengatur teks di atas secara vertikal */
            word-wrap: break-word;
            /* Memungkinkan teks panjang terputus */
            white-space: normal;
            /* Mengatur teks untuk tampil normal */
        }

        .aksi {
            min-width: 100px;
            /* Ubah lebar minimum kolom aksi jika diperlukan */
        }

        .short-text {
            display: inline;
        }

        .full-text {
            display: none;
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
                <a href="javascript:void(0);" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-dock-top"></i>
                    <div data-i18n="Account Settings">Manage Regional</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../user/user-setting-reg1.php" class="menu-link">
                    <div data-i18n="Regional 1">Regional 1</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../user/user-setting-reg2.php" class="menu-link">
                    <div data-i18n="Regional 2">Regional 2</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../user/user-setting-reg3.php" class="menu-link">
                    <div data-i18n="Regional 3">Regional 3</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../user/user-setting-reg4.php" class="menu-link">
                    <div data-i18n="Regional 4">Regional 4</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../user/user-setting-reg5.php" class="menu-link">
                    <div data-i18n="Regional 5">Regional 5</div>
                </a>
            </li>
            <li class="menu-item">
                <a href="../user/user-setting-reg6.php" class="menu-link">
                    <div data-i18n="Regional 6">Regional 6</div>
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
                  class="form-control border-0 shadow-none"
                  placeholder="Search..."
                  aria-label="Search..." />
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
                            <?php echo $_SESSION['jenis']; ?>
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
                <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Regional 5</span></h4>

                    <!-- Back Button
                    <div class="mb-3">
                        <a href="../html/dashboard.php" class="btn btn-primary">Back</a>
                    </div> -->

                    <!-- Button to Monitoring Page -->
                    <a href="monitoring_regional5.php" class="btn btn-success mb-3">Go to Monitoring</a>

                    <!-- Data Table -->
                    <div class="card">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID Sistem</th>
                                        <th>Reg Asal P6</th>
                                        <th>Kantor Asal P6</th>
                                        <th>No Pend Asal P6</th>
                                        <th>Tanggal Berita Acara</th>
                                        <th>Bulan</th>
                                        <th>Week</th>
                                        <th>Tahun</th>
                                        <th>Reg Tujuan P6</th>
                                        <th>Kantor Tujuan P6</th>
                                        <th>No Pend Tujuan P6</th>
                                        <th>Deskripsi</th>
                                        <th>DNLN</th>
                                        <th>Nomor Kiriman</th>
                                        <th>Uraian Berita Acara</th>
                                        <th>Deskripsi Iregularitas</th>
                                        <th>Rincian Root Cause</th>
                                        <th>Referensi Root Cause</th>
                                        <th>Tindakan Pencegahan</th>
                                        <th>Corrective Action</th>
                                        <th>Locus</th>
                                        <th>Nama NIK Pegawai</th>
                                        <th>No Evidence</th>
                                        <th>Validasi Regional</th>
                                        <th>Validasi Pusat</th>
                                        <th class="aksi">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // display_data.php
                                    $host = "localhost"; // atau nama host lain
                                    $user = "root"; // username MySQL
                                    $password = ""; // password MySQL
                                    $database = "iregularitas"; // ganti sesuai nama database yang kamu buat

                                    $koneksi = mysqli_connect($host, $user, $password, $database);

                                    if ($koneksi->connect_error) {
                                        die("Connection failed: " . $koneksi->connect_error);
                                    }

                                    // Pagination variables
                                    $limit = 10; // number of records per page
                                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // get the current page number
                                    $offset = ($page - 1) * $limit; // calculate the offset

                                    // Get total records for pagination
                                    $total_sql = "SELECT COUNT(*) AS total FROM regional5";
                                    $total_result = $koneksi->query($total_sql);
                                    $total_row = $total_result->fetch_assoc();
                                    $total_records = $total_row['total'];
                                    $total_pages = ceil($total_records / $limit); // calculate total pages

                                    // Fetch data with limit and offset
                                    $sql = "SELECT * FROM regional5 LIMIT $limit OFFSET $offset";
                                    $result = $koneksi->query($sql);

                                    if ($result->num_rows > 0) :
                                        while ($row = $result->fetch_assoc()) : ?>
                                            <tr>
                                                <td><?php echo $row['id_sistem']; ?></td>
                                                <td><?php echo $row['reg_asal_p6']; ?></td>
                                                <td><?php echo $row['kantor_asal_p6']; ?></td>
                                                <td><?php echo $row['nopend_asal_p6']; ?></td>
                                                <td><?php echo date('d-m-Y H:i', strtotime($row['tanggal_berita_acara'])); ?></td>
                                                <td><?php echo $row['bulan']; ?></td>
                                                <td><?php echo $row['week']; ?></td>
                                                <td><?php echo $row['tahun']; ?></td>
                                                <td><?php echo $row['reg_tujuan_p6']; ?></td>
                                                <td><?php echo $row['kantor_tujuan_p6']; ?></td>
                                                <td><?php echo $row['nopend_tujuan_p6']; ?></td>
                                                <td><?php echo $row['deskripsi']; ?></td>
                                                <td><?php echo $row['dnln']; ?></td>
                                                <td><?php echo $row['nomor_kiriman']; ?></td>
                                                <td>
                                                    <?php
                                                    $uraian = $row['uraian_berita_acara'];
                                                    if (strlen($uraian) > 100) {
                                                        $short_text = substr($uraian, 0, 100);
                                                        $full_text = substr($uraian, 100);
                                                    } else {
                                                        $short_text = $uraian;
                                                        $full_text = '';
                                                    }
                                                    ?>
                                                    <span class="short-text"><?php echo $short_text; ?></span>
                                                    <?php if ($full_text): ?>
                                                        <span class="full-text" style="display: none;"><?php echo $full_text; ?></span>
                                                        <span class="read-more-btn" style="color: blue; cursor: pointer;">Baca Selengkapnya</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td><?php echo $row['deskripsi_iregularitas']; ?></td>
                                                <td><?php echo $row['rincian_root_cause']; ?></td>
                                                <td><?php echo $row['referensi_root_cause']; ?></td>
                                                <td><?php echo $row['tindakan_pencegahan']; ?></td>
                                                <td><?php echo $row['corrective_action']; ?></td>
                                                <td><?php echo $row['locus']; ?></td>
                                                <td><?php echo $row['nama_nik_pegawai']; ?></td>
                                                <td><?php echo $row['nomor_evidence']; ?></td>
                                                <td><?php echo $row['validasi_regional']; ?></td>
                                                <td><?php echo $row['validasi_pusat']; ?></td>
                                                <td class="aksi">
                                                    <a href="../crud_user_reg1/update.php?id_sistem=<?php echo $row['id_sistem']; ?>" class="btn btn-primary">Edit</a>
                                                    <!-- <a href="../crud_user_reg1/update.php" class="btn btn-danger delete-btn" data-id="<?php echo $row['id_sistem']; ?>">Delete</a> -->
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else : ?>
                                        <tr>
                                            <td colspan="26" class="text-center">No data available</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="col-lg-8">
                            <small class="text-muted">Menampilkan <?php echo $offset + 1; ?>-<?php echo min($offset + $limit, $total_records); ?> dari total <?php echo $total_records; ?> hasil</small>
                        </div>
                        <div class="col-lg-4">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-end">
                                    <li class="page-item <?php if($page <= 1) echo 'disabled'; ?>">
                                        <a class="page-link" href="?page=<?php echo $page - 1; ?>" aria-label="Previous">
                                            <span aria-hidden="true">&laquo;</span>
                                        </a>
                                    </li>
                                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                        <li class="page-item <?php if($i == $page) echo 'active'; ?>">
                                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    <li class="page-item <?php if($page >= $total_pages) echo 'disabled'; ?>">
                                        <a class="page-link" href="?page=<?php echo $page + 1; ?>" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
            </div>
        </div>
          <!-- / Content -->

          <!-- Footer -->
          <footer class="content-footer footer bg-footer-theme">
            <div class="container-xxl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
              <div class="mb-2 mb-md-0">
                ©
                <script>
                  document.write(new Date().getFullYear());
                </script>
                , made with ❤️ by ARYKA JUWITA RIZKYRIA
              </div>
              <!-- <div>
                <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More Themes</a>

                <a
                  href="https://themeselection.com/demo/sneat-bootstrap-html-admin-template/documentation/"
                  target="_blank"
                  class="footer-link me-4">Documentation</a>

                <a
                  href="https://github.com/themeselection/sneat-html-admin-template-free/issues"
                  target="_blank"
                  class="footer-link me-4">Support</a>
              </div> -->
            </div>
          </footer>
          <!-- / Footer -->

          <div class="content-backdrop fade"></div>
        </div>
        <!-- Content wrapper -->
      </div>
      <!-- / Layout page -->
    </div>

    <!-- Overlay -->
    <div class="layout-overlay layout-menu-toggle"></div>
  </div>
  <!-- / Layout wrapper -->

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
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
            })
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
                  window.location.href = '../html/auth-login-basic.php';
              }
          })
      }
  </script>
</body>

</html>
