<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Regional 1 | Iregularitas</title>
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />
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
    </style>
</head>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Regional 1</span></h4>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="index.php" class="btn btn-primary">Back</a>
            </div>

            <!-- Data Table -->
            <div class="card">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID Sistem</th>
                                <th>Zona Asal</th>
                                <th>Nama Kantor Asal</th>
                                <th>Kantor Asal</th>
                                <th>Tanggal Berita Acara</th>
                                <th>Zona Tujuan</th>
                                <th>Nama Kantor Tujuan</th>
                                <th>Kantor Tujuan</th>
                                <th>Deskripsi</th>
                                <th>DN/LN</th>
                                <th>Nomor Kiriman</th>
                                <th>Uraian Berita Acara</th>
                                <th>Deskripsi Iregularitas</th>
                                <th>Bulan Berita Acara</th>
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
                                <th class="aksi">Aksi</th>
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

                            // Get total records for view_newtab
                            $total_sql_view_newtab = "SELECT COUNT(*) AS total FROM view_newtab";
                            $total_result_view_newtab = $koneksi->query($total_sql_view_newtab);
                            $total_row_view_newtab = $total_result_view_newtab->fetch_assoc();
                            $total_records_view_newtab = $total_row_view_newtab['total'];

                            // Total records for pagination
                            $total_records = $total_records + $total_records_view_newtab; // Adjusted line
                            $total_pages = ceil($total_records / $limit); 

                            // Initialize query for report_agung
                            $sql = "SELECT ID_Sistem, ZonaAsal, Nama_Kantor_Asal, Kantor_Asal, Tanggal_Berita_Acara, ZonaTujuan, Nama_Kantor_Tujuan, Kantor_Tujuan, Deskripsi, DNLN, Nomor_Kiriman, Uraian_Berita_Acara, Deskripsi_Iregularitas, Bulan_BA, Week, month_name FROM report_agung LIMIT $limit OFFSET $offset";
                            $result = $koneksi->query($sql);

                            // Initialize query for view_newtab
                            $sql_view_newtab = "SELECT Rincian_Root_Cause, Referensi_Root_Cause, Tindakan_Pencegahan, Corrective_Action, Locus, Nama_NIK_Pegawai, No_Evidence, Validasi_Regional, Validasi_Pusat FROM view_newtab LIMIT $limit OFFSET $offset";
                            $result_view_newtab = $koneksi->query($sql_view_newtab);

                            // Check if both queries return data
                            if ($result->num_rows > 0 || $result_view_newtab->num_rows > 0) :
                                // Loop for report_agung data
                                while ($row = $result->fetch_assoc()) :
                                    // Fetch view_newtab data for the corresponding row
                                    $row_view_newtab = $result_view_newtab->fetch_assoc();
                            ?>
                                <tr>
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
                                    <td><?php echo $row['Bulan_BA']; ?></td>
                                    <td><?php echo $row['Week']; ?></td>
                                    <td><?php echo isset($row_view_newtab['Rincian_Root_Cause']) ? $row_view_newtab['Rincian_Root_Cause'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Referensi_Root_Cause']) ? $row_view_newtab['Referensi_Root_Cause'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Tindakan_Pencegahan']) ? $row_view_newtab['Tindakan_Pencegahan'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Corrective_Action']) ? $row_view_newtab['Corrective_Action'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Locus']) ? $row_view_newtab['Locus'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Nama_NIK_Pegawai']) ? $row_view_newtab['Nama_NIK_Pegawai'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['No_Evidence']) ? $row_view_newtab['No_Evidence'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Validasi_Regional']) ? $row_view_newtab['Validasi_Regional'] : ''; ?></td>
                                    <td><?php echo isset($row_view_newtab['Validasi_Pusat']) ? $row_view_newtab['Validasi_Pusat'] : ''; ?></td>
                                    <td class="aksi">
                                        <a href="../crud_user_reg11/update.php?id_sistem=<?php echo $row['ID_Sistem']; ?>" class="btn btn-primary">Edit</a>
                                        <a href="../crud_regional/delete.php" class="btn btn-danger delete-btn" data-id="<?php echo $row['ID_Sistem']; ?>">Delete</a>
                                    </td>
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
