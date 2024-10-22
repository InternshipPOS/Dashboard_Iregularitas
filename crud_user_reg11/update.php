<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Regional 11 | Iregularitas</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- SweetAlert2 -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
</head>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Edit Regional</span></h4>

            <div class="card">
                <div class="card-body">
                    <?php
                    // Koneksi ke database
                    $host = "localhost";
                    $user = "root"; // ganti dengan username MySQL Anda
                    $password = ""; // ganti dengan password MySQL Anda
                    $database = "iregularitas"; // ganti sesuai nama database Anda

                    // Membuat koneksi
                    $koneksi = new mysqli($host, $user, $password, $database);

                    if ($koneksi->connect_error) {
                        die("Connection failed: " . $koneksi->connect_error);
                    }

                    // Mendapatkan ID Sistem dari URL
                    $id_sistem = $_GET['id_sistem'];

                    // Cek jika form telah disubmit
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Mendapatkan data dari form
                        $ZonaAsal = isset($_POST['ZonaAsal']) ? $_POST['ZonaAsal'] : '';
                        $Nama_Kantor_Asal = isset($_POST['Nama_Kantor_Asal']) ? $_POST['Nama_Kantor_Asal'] : '';
                        $Kantor_Asal = isset($_POST['Kantor_Asal']) ? $_POST['Kantor_Asal'] : '';
                        $Tanggal_Berita_Acara = isset($_POST['Tanggal_Berita_Acara']) ? $_POST['Tanggal_Berita_Acara'] : '';
                        $ZonaTujuan = isset($_POST['ZonaTujuan']) ? $_POST['ZonaTujuan'] : '';
                        $Nama_Kantor_Tujuan = isset($_POST['Nama_Kantor_Tujuan']) ? $_POST['Nama_Kantor_Tujuan'] : '';
                        $Kantor_Tujuan = isset($_POST['Kantor_Tujuan']) ? $_POST['Kantor_Tujuan'] : '';
                        $Deskripsi = isset($_POST['Deskripsi']) ? $_POST['Deskripsi'] : '';
                        $DNLN = isset($_POST['DNLN']) ? $_POST['DNLN'] : '';
                        $Nomor_Kiriman = isset($_POST['Nomor_Kiriman']) ? $_POST['Nomor_Kiriman'] : '';
                        $Uraian_Berita_Acara = isset($_POST['Uraian_Berita_Acara']) ? $_POST['Uraian_Berita_Acara'] : '';
                        $Deskripsi_Iregularitas = isset($_POST['Deskripsi_Iregularitas']) ? $_POST['Deskripsi_Iregularitas'] : '';
                        $Bulan_BA = isset($_POST['Bulan_BA']) ? $_POST['Bulan_BA'] : '';
                        $Week = isset($_POST['Week']) ? $_POST['Week'] : '';
                        $month_name = isset($_POST['month_name']) ? $_POST['month_name'] : '';
                        $rincian_root_cause = isset($_POST['rincian_root_cause']) ? $_POST['rincian_root_cause'] : '';
                        $referensi_root_cause = isset($_POST['referensi_root_cause']) ? $_POST['referensi_root_cause'] : '';
                        $tindakan_pencegahan = isset($_POST['tindakan_pencegahan']) ? $_POST['tindakan_pencegahan'] : '';
                        $corrective_action = isset($_POST['corrective_action']) ? $_POST['corrective_action'] : '';
                        $locus = isset($_POST['locus']) ? $_POST['locus'] : '';
                        $nama_nik_pegawai = isset($_POST['nama_nik_pegawai']) ? $_POST['nama_nik_pegawai'] : '';
                        $no_evidence = isset($_POST['no_evidence']) ? $_POST['no_evidence'] : '';
                        $validasi_regional = isset($_POST['validasi_regional']) ? $_POST['validasi_regional'] : '';
                        $validasi_pusat = isset($_POST['validasi_pusat']) ? $_POST['validasi_pusat'] : '';


                        // Query untuk mengupdate data report_agung
                        $sql1 = "UPDATE report_agung SET 
                                    ZonaAsal = '$ZonaAsal',
                                    Nama_Kantor_Asal = '$Nama_Kantor_Asal', 
                                    Kantor_Asal = '$Kantor_Asal',
                                    Tanggal_Berita_Acara = '$Tanggal_Berita_Acara',
                                    ZonaTujuan = '$ZonaTujuan',
                                    Nama_Kantor_Tujuan = '$Nama_Kantor_Tujuan',
                                    Kantor_Tujuan = '$Kantor_Tujuan',
                                    Deskripsi = '$Deskripsi',
                                    DNLN = '$DNLN',
                                    Nomor_Kiriman = '$Nomor_Kiriman',
                                    Uraian_Berita_Acara = '$Uraian_Berita_Acara',
                                    Deskripsi_Iregularitas = '$Deskripsi_Iregularitas',
                                    Bulan_BA = '$Bulan_BA',
                                    Week = '$Week',
                                    month_name = '$month_name'
                                    WHERE id_sistem='$id_sistem'";


                        // Query untuk mengupdate data newtab
                        $sql2 = "UPDATE newtab SET 
                                    rincian_root_cause='$rincian_root_cause',
                                    referensi_root_cause='$referensi_root_cause',
                                    tindakan_pencegahan='$tindakan_pencegahan',
                                    corrective_action='$corrective_action',
                                    locus='$locus',
                                    nama_nik_pegawai='$nama_nik_pegawai',
                                    no_evidence='$no_evidence',
                                    validasi_regional='$validasi_regional',
                                    validasi_pusat='$validasi_pusat' 
                                WHERE id_sistem='$id_sistem'";

                        // Menjalankan query dan mengecek hasilnya
                        if ($koneksi->query($sql1) === TRUE && $koneksi->query($sql2) === TRUE) {
                            // Jika update berhasil, munculkan SweetAlert dan redirect setelah OK
                            echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil diperbarui!',
                                    showConfirmButton: true
                                }).then(function() {
                                    window.location.href = '../user/user-setting-reg11.php';
                                });
                            </script>";
                        } else {
                            echo "<script>
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal memperbarui data!',
                                    text: 'Terjadi kesalahan: " . $koneksi->error . "',
                                });
                            </script>";
                        }
                    }

                    // Query untuk mendapatkan data yang ingin diedit
                    $sql1 = "SELECT * FROM report_agung WHERE id_sistem='$id_sistem'";
                    $result1 = $koneksi->query($sql1); // Menggunakan $result1 untuk query pertama

                    $sql2 = "SELECT * FROM view_newtab WHERE id_sistem='$id_sistem'";
                    $result2 = $koneksi->query($sql2); // Menggunakan $result2 untuk query kedua

                    if ($result1 && $result1->num_rows > 0) {
                        $row = $result1->fetch_assoc();
                    ?>
                        <form action="" method="POST">
                            <input type="hidden" name="ID_Sistem" value="<?php echo $row['ID_Sistem']; ?>">

                            <!-- Zona Asal -->
                            <div class="mb-3">
                                <label for="ZonaAsal" class="form-label">Zona Asal</label>
                                <input type="text" class="form-control" id="ZonaAsal" name="ZonaAsal" value="<?php echo $row['ZonaAsal']; ?>">
                            </div>

                            <!-- Nama Kantor Asal -->
                            <div class="mb-3">
                                <label for="Nama_Kantor_Asal" class="form-label">Nama Kantor Asal</label>
                                <input type="text" class="form-control" id="Nama_Kantor_Asal" name="Nama_Kantor_Asal" value="<?php echo $row['Nama_Kantor_Asal']; ?>">
                            </div>

                            <!-- Kantor Asal -->
                            <div class="mb-3">
                                <label for="Kantor_Asal" class="form-label">Kantor Asal</label>
                                <input type="text" class="form-control" id="Kantor_Asal" name="Kantor_Asal" value="<?php echo $row['Kantor_Asal']; ?>">
                            </div>

                            <!-- Tanggal Berita Acara -->
                            <div class="mb-3">
                                <label for="Tanggal_Berita_Acara" class="form-label">Tanggal Berita Acara</label>
                                <input type="date" class="form-control" id="Tanggal_Berita_Acara" name="Tanggal_Berita_Acara" value="<?php echo date('Y-m-d', strtotime($row['Tanggal_Berita_Acara'])); ?>">
                            </div>

                            <!-- Zona Tujuan -->
                            <div class="mb-3">
                                <label for="ZonaTujuan" class="form-label">Zona Tujuan</label>
                                <input type="text" class="form-control" id="ZonaTujuan" name="ZonaTujuan" value="<?php echo $row['ZonaTujuan']; ?>">
                            </div>

                            <!-- Nama Kantor Tujuan -->
                            <div class="mb-3">
                                <label for="Nama_Kantor_Tujuan" class="form-label">Nama Kantor Tujuan</label>
                                <input type="text" class="form-control" id="Nama_Kantor_Tujuan" name="Nama_Kantor_Tujuan" value="<?php echo $row['Nama_Kantor_Tujuan']; ?>">
                            </div>

                            <!-- Kantor Tujuan -->
                            <div class="mb-3">
                                <label for="Kantor_Tujuan" class="form-label">Kantor Tujuan</label>
                                <input type="text" class="form-control" id="Kantor_Tujuan" name="Kantor_Tujuan" value="<?php echo $row['Kantor_Tujuan']; ?>">
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label for="Deskripsi" class="form-label">Deskripsi</label>
                                <input type="text" class="form-control" id="Deskripsi" name="Deskripsi" value="<?php echo $row['Deskripsi']; ?>">
                            </div>

                            <!-- DNLN -->
                            <div class="mb-3">
                                <label for="DNLN" class="form-label">DN/LN</label>
                                <input type="text" class="form-control" id="DNLN" name="DNLN" value="<?php echo $row['DNLN']; ?>">
                            </div>

                            <!-- Nomor Kiriman -->
                            <div class="mb-3">
                                <label for="Nomor_Kiriman" class="form-label">Nomor Kiriman</label>
                                <input type="text" class="form-control" id="Nomor_Kiriman" name="Nomor_Kiriman" value="<?php echo $row['Nomor_Kiriman']; ?>">
                            </div>

                            <!-- Uraian Berita Acara -->
                            <div class="mb-3">
                                <label for="Uraian_Berita_Acara" class="form-label">Uraian Berita Acara</label>
                                <input type="text" class="form-control" id="Uraian_Berita_Acara" name="Uraian_Berita_Acara" value="<?php echo $row['Uraian_Berita_Acara']; ?>">
                            </div>

                            <!-- Deskripsi Iregulartitas -->
                            <div class="mb-3">
                                <label for="Deskripsi_Iregularitas" class="form-label">Deskripsi Iregularitas</label>
                                <input type="text" class="form-control" id="Deskripsi_Iregularitas" name="Deskripsi_Iregularitas" value="<?php echo $row['Deskripsi_Iregularitas']; ?>">
                            </div>

                            <!-- Bulan BA -->
                            <div class="mb-3">
                                <label for="Bulan_BA" class="form-label">Bulan</label>
                                <input type="text" class="form-control" id="Bulan_BA" name="Bulan_BA" value="<?php echo $row['Bulan_BA']; ?>">
                            </div>

                            <!-- Week -->
                            <div class="mb-3">
                                <label for="Week" class="form-label">Week</label>
                                <input type="text" class="form-control" id="Week" name="Week" value="<?php echo $row['Week']; ?>">
                            </div>

                            <!-- Month Name -->
                            <div class="mb-3">
                                <label for="month_name" class="form-label">Deskripsi Iregularitas</label>
                                <textarea class="form-control" id="month_name" name="month_name" rows="3" ><?php echo $row['Deskripsi_Iregularitas']; ?></textarea>
                            </div>

                            <!-- Data Newtab -->
                            <?php
                            if ($result2 && $result2->num_rows > 0) {
                                $row_newtab = $result2->fetch_assoc();
                                // Menampilkan input dari newtab
                            ?>
                                <div class="mb-3">
                                    <label for="rincian_root_cause" class="form-label">Rincian Root Cause</label>
                                    <textarea class="form-control" id="rincian_root_cause" name="rincian_root_cause" rows="3" ><?php echo $row_newtab['rincian_root_cause']; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="referensi_root_cause" class="form-label">Referensi Root Cause</label>
                                    <input type="text" class="form-control" id="referensi_root_cause" name="referensi_root_cause" value="<?php echo $row_newtab['referensi_root_cause']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="tindakan_pencegahan" class="form-label">Tindakan Pencegahan</label>
                                    <textarea class="form-control" id="tindakan_pencegahan" name="tindakan_pencegahan" rows="3" ><?php echo $row_newtab['tindakan_pencegahan']; ?></textarea>
                                </div>

                                <div class="mb-3">
                                    <label for="corrective_action" class="form-label">Corrective Action</label>
                                    <input type="text" class="form-control" id="corrective_action" name="corrective_action" value="<?php echo $row_newtab['corrective_action']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="locus" class="form-label">Locus</label>
                                    <input type="text" class="form-control" id="locus" name="locus" value="<?php echo $row_newtab['locus']; ?>" >
                                </div>

                                <div class="mb-3">
                                    <label for="nama_nik_pegawai" class="form-label">Nama NIK Pegawai</label>
                                    <input type="text" class="form-control" id="nama_nik_pegawai" name="nama_nik_pegawai" value="<?php echo $row_newtab['nama_nik_pegawai']; ?>" >
                                </div>

                                <div class="mb-3">
                                    <label for="no_evidence" class="form-label">Nomor Evidence</label>
                                    <input type="text" class="form-control" id="no_evidence" name="no_evidence" value="<?php echo $row_newtab['no_evidence']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="validasi_regional" class="form-label">Validasi Regional</label>
                                    <input type="text" class="form-control" id="validasi_regional" name="validasi_regional" value="<?php echo $row_newtab['validasi_regional']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label for="validasi_pusat" class="form-label">Validasi Pusat</label>
                                    <input type="text" class="form-control" id="validasi_pusat" name="validasi_pusat" value="<?php echo $row_newtab['validasi_pusat']; ?>">
                                </div>
                            <?php
                            } else {
                                echo "Data newtab tidak ditemukan.";
                            }
                            ?>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    <?php
                    } else {
                        echo "Data tidak ditemukan.";
                    }

                    $koneksi->close(); // Menutup koneksi
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/js/sidenav.js"></script>
    <script src="../assets/vendor/js/scrolltop.js"></script>
    <script src="../assets/vendor/js/theme.js"></script>
</body>
</html>
