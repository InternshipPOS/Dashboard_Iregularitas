<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Regional 1 | Iregularitas</title>
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
            height: 600px; /* Ubah sesuai kebutuhan */
            overflow-y: auto; /* Untuk scroll jika data lebih dari tinggi yang ditetapkan */
            table-layout: auto; /* Memungkinkan lebar kolom menyesuaikan konten */
        }

        .table td, .table th {
            padding: 1.5rem; /* Ubah padding untuk memperbesar ukuran sel */
            vertical-align: top; /* Mengatur teks di atas secara vertikal */
            word-wrap: break-word; /* Memungkinkan teks panjang terputus */
            white-space: normal; /* Mengatur teks untuk tampil normal */
        }

        .aksi {
            min-width: 100px; /* Ubah lebar minimum kolom aksi jika diperlukan */
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
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Regional 1</span></h4>

            <!-- Back Button -->
            <div class="mb-3">
                <a href="index.html" class="btn btn-primary">Back</a>
            </div>

            <!-- Button to Add Data -->
            <!-- <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addDataModal">Insert Data</button> -->

            <!-- Button to Monitoring Page -->
            <a href="monitoring_regional1.php" class="btn btn-success mb-3">Go to Monitoring</a>

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

                            $sql = "SELECT * FROM regional1";
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
                                            <a href="../crud_regional/update.php?id_sistem=<?php echo $row['id_sistem']; ?>" class="btn btn-primary">Edit</a>
                                            <a href="#" class="btn btn-danger delete-btn" data-id="<?php echo $row['id_sistem']; ?>">Delete</a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else : ?>
                                <tr>
                                    <td colspan="25" class="text-center">Tidak ada data tersedia</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
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
        $(document).ready(function () {
            $('.delete-btn').click(function (e) {
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
                            data: { id_sistem: id },
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

            // Menampilkan teks lengkap saat mengklik "Baca Selengkapnya"
            $(document).on('click', '.read-more-btn', function () {
                $(this).prev('.full-text').toggle();
                $(this).prev('.short-text').toggle();
                $(this).text($(this).text() === 'Baca Selengkapnya' ? 'Sembunyikan' : 'Baca Selengkapnya');
            });
        });
    </script>
</body>
</html>
