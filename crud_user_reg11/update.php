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
                        $ZonaAsal = $_POST['ZonaAsal'] ?? '';
                        $Nama_Kantor_Asal = $_POST['Nama_Kantor_Asal'] ?? '';
                        $Kantor_Asal = $_POST['Kantor_Asal'] ?? '';
                        $Tanggal_Berita_Acara = $_POST['Tanggal_Berita_Acara'] ?? '';
                        $Kantor_Tujuan = $_POST['Kantor_Tujuan'] ?? '';
                        $Nomor_Kiriman = $_POST['Nomor_Kiriman'] ?? '';
                        $Uraian_Berita_Acara = $_POST['Uraian_Berita_Acara'] ?? '';
                        $Deskripsi_Iregularitas = $_POST['Deskripsi_Iregularitas'] ?? '';
                        $rincian_root_cause = $_POST['rincian_root_cause'] ?? '';
                        $referensi_root_cause = $_POST['referensi_root_cause'] ?? '';
                        $tindakan_pencegahan = $_POST['tindakan_pencegahan'] ?? '';
                        $corrective_action = $_POST['corrective_action'] ?? '';
                        $locus = $_POST['locus'] ?? '';
                        $nama_nik_pegawai = $_POST['nama_nik_pegawai'] ?? '';
                        $no_evidence = $_POST['no_evidence'] ?? '';
                        $validasi_regional = $_POST['validasi_regional'] ?? '';
                        $validasi_pusat = $_POST['validasi_pusat'] ?? '';

                        // Query untuk mengupdate data report_agung
                        $sql1 = "UPDATE ireg_p6_entri SET 
                                    Kantor_Asal = '$Kantor_Asal',
                                    Tanggal_Berita_Acara = '$Tanggal_Berita_Acara',
                                    Kantor_Tujuan = '$Kantor_Tujuan',
                                    Nomor_Kiriman = '$Nomor_Kiriman',
                                    Uraian_Berita_Acara = '$Uraian_Berita_Acara'
                                    WHERE id_sistem='$id_sistem'";

                        $sql2 = "UPDATE newtab SET
                                    Rincian_Root_Cause = '$rincian_root_cause',
                                    Referensi_Root_Cause = '$referensi_root_cause',
                                    Tindakan_Pencegahan = '$tindakan_pencegahan',
                                    Corrective_Action = '$corrective_action',
                                    Locus = '$locus',
                                    Nama_NIK_Pegawai = '$nama_nik_pegawai',
                                    No_Evidence = '$no_evidence',
                                    Validasi_Regional = '$validasi_regional',
                                    Validasi_Pusat = '$validasi_pusat'
                                    WHERE id_sistem='$id_sistem'";
                                              
                        // Eksekusi query
                        $koneksi->query($sql1);
                        $koneksi->query($sql2);
                    }

                    // Query untuk mendapatkan data yang ingin diedit
                    $sql1 = "SELECT * FROM report_agung WHERE id_sistem='$id_sistem'";
                    $result1 = $koneksi->query($sql1);

                    if ($result1 && $result1->num_rows > 0) {
                        $row1 = $result1->fetch_assoc();
                    ?>

                        <form action="" method="POST">
                            <input type="hidden" name="ID_Sistem" value="<?php echo $row1['ID_Sistem']; ?>">

                            <!-- Zona Asal -->
                            <div class="mb-3">
                                <label for="ZonaAsal" class="form-label">Zona Asal</label>
                                <input type="text" class="form-control" id="ZonaAsal" name="ZonaAsal" value="<?php echo $row1['ZonaAsal']; ?>">
                            </div>

                            <!-- Nama Kantor Asal -->
                            <div class="mb-3">
                                <label for="Nama_Kantor_Asal" class="form-label">Nama Kantor Asal</label>
                                <input type="text" class="form-control" id="Nama_Kantor_Asal" name="Nama_Kantor_Asal" value="<?php echo $row1['Nama_Kantor_Asal']; ?>">
                            </div>

                            <!-- Kantor Asal -->
                            <div class="mb-3">
                                <label for="Kantor_Asal" class="form-label">Kantor Asal</label>
                                <input type="text" class="form-control" id="Kantor_Asal" name="Kantor_Asal" value="<?php echo $row1['Kantor_Asal']; ?>">
                            </div>

                            <!-- Tanggal Berita Acara -->
                            <div class="mb-3">
                                <label for="Tanggal_Berita_Acara" class="form-label">Tanggal Berita Acara</label>
                                <input type="date" class="form-control" id="Tanggal_Berita_Acara" name="Tanggal_Berita_Acara" value="<?php echo $row1['Tanggal_Berita_Acara']; ?>">
                            </div>

                            <!-- Kantor Tujuan -->
                            <div class="mb-3">
                                <label for="Kantor_Tujuan" class="form-label">Kantor Tujuan</label>
                                <input type="text" class="form-control" id="Kantor_Tujuan" name="Kantor_Tujuan" value="<?php echo $row1['Kantor_Tujuan']; ?>">
                            </div>

                            <!-- Nomor Kiriman -->
                            <div class="mb-3">
                                <label for="Nomor_Kiriman" class="form-label">Nomor Kiriman</label>
                                <input type="text" class="form-control" id="Nomor_Kiriman" name="Nomor_Kiriman" value="<?php echo $row1['Nomor_Kiriman']; ?>">
                            </div>

                            <!-- Uraian Berita Acara -->
                            <div class="mb-3">
                                <label for="Uraian_Berita_Acara" class="form-label">Uraian Berita Acara</label>
                                <textarea class="form-control" id="Uraian_Berita_Acara" name="Uraian_Berita_Acara"><?php echo $row1['Uraian_Berita_Acara']; ?></textarea>
                            </div>

                            <!-- Deskripsi Iregularitas -->
                            <div class="mb-3">
                                <label for="Deskripsi_Iregularitas" class="form-label">Deskripsi Iregularitas</label>
                                <textarea class="form-control" id="Deskripsi_Iregularitas" name="Deskripsi_Iregularitas"><?php echo $row1['Deskripsi_Iregularitas']; ?></textarea>
                            </div>

                        <?php
                    }

                    // Query untuk rincian_root_cause dan referensi_root_cause
                    $sql2 = "SELECT Rincian_Root_Cause, Referensi_Root_Cause FROM newtab WHERE id_sistem='$id_sistem'";
                    $result2 = $koneksi->query($sql2);

                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        ?>
                            <!-- Rincian Root Cause -->
                            <div class="mb-3">
                                <label for="rincian_root_cause" class="form-label">Rincian Root Cause</label>
                                <input type="text" class="form-control" id="rincian_root_cause" name="rincian_root_cause" value="<?php echo $row2['Rincian_Root_Cause']; ?>">
                            </div>

                            <!-- Referensi Root Cause -->
                            <div class="mb-3">
                                <label for="referensi_root_cause" class="form-label">Referensi Root Cause</label>
                                <input type="text" class="form-control" id="referensi_root_cause" name="referensi_root_cause" value="<?php echo $row2['Referensi_Root_Cause']; ?>">
                            </div>

                            <!-- Tindakan Pencegahan -->
                            <div class="mb-3">
                                <label for="tindakan_pencegahan" class="form-label">Tindakan Pencegahan</label>
                                <input type="text" class="form-control" id="tindakan_pencegahan" name="tindakan_pencegahan">
                            </div>

                            <!-- Corrective Action -->
                            <div class="mb-3">
                                <label for="corrective_action" class="form-label">Corrective Action</label>
                                <input type="text" class="form-control" id="corrective_action" name="corrective_action">
                            </div>

                            <!-- Locus -->
                            <div class="mb-3">
                                <label for="locus" class="form-label">Locus</label>
                                <input type="text" class="form-control" id="locus" name="locus">
                            </div>

                            <!-- Nama NIK Pegawai -->
                            <div class="mb-3">
                                <label for="nama_nik_pegawai" class="form-label">Nama NIK Pegawai</label>
                                <input type="text" class="form-control" id="nama_nik_pegawai" name="nama_nik_pegawai">
                            </div>

                            <!-- No Evidence -->
                            <div class="mb-3">
                                <label for="no_evidence" class="form-label">No Evidence</label>
                                <input type="text" class="form-control" id="no_evidence" name="no_evidence">
                            </div>

                            <!-- Validasi Regional -->
                            <div class="mb-3">
                                <label for="validasi_regional" class="form-label">Validasi Regional</label>
                                <input type="text" class="form-control" id="validasi_regional" name="validasi_regional">
                            </div>

                            <!-- Validasi Pusat -->
                            <div class="mb-3">
                                <label for="validasi_pusat" class="form-label">Validasi Pusat</label>
                                <input type="text" class="form-control" id="validasi_pusat" name="validasi_pusat">
                            </div>

                            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                        </form>
                    <?php
                    } else {
                        echo "Data tidak ditemukan.";
                    }

                    // Menutup koneksi
                    $koneksi->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/js/sidenav.js"></script>
    <script src="../assets/vendor/js/main.js"></script>
</body>

</html>