<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Manage Users | Iregularitas</title>
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
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Manage Users</span></h4>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="index.php" class="btn btn-primary">Back</a>
            </div>

            <!-- Button to Monitoring Page -->
            <a href="auth-register-basic.php" class="btn btn-success mb-3">Insert User</a>

            <!-- Data Table -->
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Username</th>
                                <th>Nama</th>
                                <th>NIPPOS</th>
                                <th>Jenis Kantor</th>
                                <th>Regional</th>
                                <th>Kantor Asal</th>
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
                            $total_sql = "SELECT COUNT(*) AS total FROM user";
                            $total_result = $koneksi->query($total_sql);
                            $total_row = $total_result->fetch_assoc();
                            $total_records = $total_row['total'];
                            $total_pages = ceil($total_records / $limit); // calculate total pages

                            // Fetch data with limit and offset
                            $sql = "SELECT * FROM user LIMIT $limit OFFSET $offset";
                            $result = $koneksi->query($sql);

                            if ($result->num_rows > 0) :
                                while ($row = $result->fetch_assoc()) : ?>
                                    <tr>
                                        <td><?php echo $row['username']; ?></td>
                                        <td><?php echo $row['nama']; ?></td>
                                        <td><?php echo $row['nik']; ?></td>
                                        <td><?php echo $row['jenis']; ?></td>
                                        <td><?php echo $row['regional']; ?></td>
                                        <td><?php echo $row['kantor_asal']; ?></td>
                                        <td class="aksi">
                                            <a href="../crud_user/update.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit</a>
                                            <a href="../crud_user/delete.php" class="btn btn-danger delete-btn" data-id="<?php echo $row['id']; ?>">Delete</a>
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
</body>

</html>
