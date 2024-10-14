<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Regional 4 | Iregularitas</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
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
                    $koneksi = mysqli_connect($host, $user, $password, $database);

                    if ($koneksi->connect_error) {
                        die("Connection failed: " . $koneksi->connect_error);
                    }

                    // Mendapatkan ID Sistem dari URL
                    $id_sistem = $_GET['id_sistem'];

                    // Cek jika form telah disubmit
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        // Mendapatkan data dari form
                        $reg_asal_p6 = $_POST['reg_asal_p6'];
                        $kantor_asal_p6 = $_POST['kantor_asal_p6'];
                        $nopend_asal_p6 = $_POST['nopend_asal_p6'];
                        $tanggal_berita_acara = $_POST['tanggal_berita_acara'];
                        $deskripsi = $_POST['deskripsi'];
                        $uraian_berita_acara = $_POST['uraian_berita_acara'];
                        $deskripsi_iregularitas = $_POST['deskripsi_iregularitas'];
                        $rincian_root_cause = $_POST['rincian_root_cause'];
                        $referensi_root_cause = $_POST['referensi_root_cause'];
                        $tindakan_pencegahan = $_POST['tindakan_pencegahan'];
                        $corrective_action = $_POST['corrective_action'];
                        $locus = $_POST['locus'];
                        $nama_nik_pegawai = $_POST['nama_nik_pegawai'];
                        $nomor_evidence = $_POST['nomor_evidence'];
                        $validasi_regional = $_POST['validasi_regional'];
                        $validasi_pusat = $_POST['validasi_pusat'];

                        // Query untuk mengupdate data
                        $sql = "UPDATE regional5 SET 
                                    reg_asal_p6='$reg_asal_p6', 
                                    kantor_asal_p6='$kantor_asal_p6', 
                                    nopend_asal_p6='$nopend_asal_p6', 
                                    tanggal_berita_acara='$tanggal_berita_acara', 
                                    deskripsi='$deskripsi',
                                    uraian_berita_acara='$uraian_berita_acara',
                                    deskripsi_iregularitas='$deskripsi_iregularitas',
                                    rincian_root_cause='$rincian_root_cause',
                                    referensi_root_cause='$referensi_root_cause',
                                    tindakan_pencegahan='$tindakan_pencegahan',
                                    corrective_action='$corrective_action',
                                    locus='$locus',
                                    nama_nik_pegawai='$nama_nik_pegawai',
                                    nomor_evidence='$nomor_evidence',
                                    validasi_regional='$validasi_regional',
                                    validasi_pusat='$validasi_pusat' 
                                WHERE id_sistem='$id_sistem'";

                        if ($koneksi->query($sql) === TRUE) {
                            // Jika update berhasil, munculkan SweetAlert dan redirect setelah OK
                            echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Data berhasil diperbarui!',
                                    showConfirmButton: true
                                }).then(function() {
                                    window.location.href = '../html/pages-regional settings-reg4.php';
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
                    $sql = "SELECT * FROM regional5 WHERE id_sistem='$id_sistem'";
                    $result = $koneksi->query($sql);

                    if ($result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                    ?>

                    <form action="" method="POST">
                        <input type="hidden" name="id_sistem" value="<?php echo $row['id_sistem']; ?>">

                        <div class="mb-3">
                            <label for="reg_asal_p6" class="form-label">Reg Asal P6</label>
                            <input type="text" class="form-control" id="reg_asal_p6" name="reg_asal_p6" value="<?php echo $row['reg_asal_p6']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="kantor_asal_p6" class="form-label">Kantor Asal P6</label>
                            <input type="text" class="form-control" id="kantor_asal_p6" name="kantor_asal_p6" value="<?php echo $row['kantor_asal_p6']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nopend_asal_p6" class="form-label">No Pend Asal P6</label>
                            <input type="text" class="form-control" id="nopend_asal_p6" name="nopend_asal_p6" value="<?php echo $row['nopend_asal_p6']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal_berita_acara" class="form-label">Tanggal Berita Acara</label>
                            <input type="date" class="form-control" id="tanggal_berita_acara" name="tanggal_berita_acara" value="<?php echo date('Y-m-d', strtotime($row['tanggal_berita_acara'])); ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi</label>
                            <input type="text" class="form-control" id="deskripsi" name="deskripsi" value="<?php echo $row['deskripsi']; ?>" required>
                        </div>

                        <!-- Tambahan kolom baru -->
                        <div class="mb-3">
                            <label for="uraian_berita_acara" class="form-label">Uraian Berita Acara</label>
                            <textarea class="form-control" id="uraian_berita_acara" name="uraian_berita_acara" required><?php echo $row['uraian_berita_acara']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="deskripsi_iregularitas" class="form-label">Deskripsi Iregularitas</label>
                            <input type="text" class="form-control" id="deskripsi_iregularitas" name="deskripsi_iregularitas" value="<?php echo $row['deskripsi_iregularitas']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="rincian_root_cause" class="form-label">Rincian Root Cause</label>
                            <textarea class="form-control" id="rincian_root_cause" name="rincian_root_cause" required><?php echo $row['rincian_root_cause']; ?></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="referensi_root_cause" class="form-label">Referensi Root Cause</label>
                            <select class="form-select" id="referensi_root_cause" name="referensi_root_cause" required>
                                <option value="" disabled selected>Pilih referensi root cause</option>
                                <option value="gagal x-ray kiriman import" <?php echo ($row['referensi_root_cause'] == 'gagal x-ray kiriman import') ? 'selected' : ''; ?>>Gagal X-Ray Kiriman Import</option>
                                <option value="incoming ln" <?php echo ($row['referensi_root_cause'] == 'incoming ln') ? 'selected' : ''; ?>>Incoming LN</option>
                                <option value="pengirim tidak menginfokan isi kiriman yanng benar" <?php echo ($row['referensi_root_cause'] == 'pengirim tidak menginfokan isi kiriman yanng benar') ? 'selected' : ''; ?>>Pengirim Tidak Menginfokan Isi Kiriman Yanng Benar</option>
                                <option value="petugas melakukan froud/kecurangan" <?php echo ($row['referensi_root_cause'] == 'petugas melakukan froud/kecurangan') ? 'selected' : ''; ?>>Petugas Melakukan Froud/Kecurangan</option>
                                <option value="petugas tidak melaksanakan sop" <?php echo ($row['referensi_root_cause'] == 'petugas tidak melaksanakan sop') ? 'selected' : ''; ?>>Petugas Tidak Melaksanakan SOP</option>
                                <option value="petugas tidak memeriksa isi kiriman (khusus pos internasional)" <?php echo ($row['referensi_root_cause'] == 'petugas tidak memeriksa isi kiriman (khusus pos internasional)') ? 'selected' : ''; ?>>Petugas Tidak Memeriksa Isi Kiriman (Khusus Pos International)</option>
                                <option value="petugas tidak memeriksa packing" <?php echo ($row['referensi_root_cause'] == 'petugas tidak memeriksa packing') ? 'selected' : ''; ?>>Petugas Tidak Memeriksa Packing</option>
                                <option value="petugas tidak menanyakan isi kiriman" <?php echo ($row['referensi_root_cause'] == 'petugas tidak menanyakan isi kiriman') ? 'selected' : ''; ?>>Petugas Tidak Menanyakan Isi Kiriman</option>
                                <option value="petugas tidak teliti" <?php echo ($row['referensi_root_cause'] == 'petugas tidak teliti') ? 'selected' : ''; ?>>Petugas Tidak Teliti</option>
                                <option value="salah salur p6" <?php echo ($row['referensi_root_cause'] == 'salah salur p6') ? 'selected' : ''; ?>>Salah Salur P6</option>
                                <option value="potensi kerusakan pada saat perjalanan" <?php echo ($row['referensi_root_cause'] == 'potensi kerusakan pada saat perjalanan') ? 'selected' : ''; ?>>Potensi Kerusakan pada saat Perjalanan</option>
                                <option value="pengirim tidak melakukan packing dengan baik" <?php echo ($row['referensi_root_cause'] == 'pengirim tidak melakukan packing dengan baik') ? 'selected' : ''; ?>>Pengirim Tidak Melakukan Packing dengan Baik</option>
                                <option value="pengirim salah memberikan data penerima" <?php echo ($row['referensi_root_cause'] == 'pengirim salah memberikan data penerima') ? 'selected' : ''; ?>>Pengirim Salah Memberikan Data Penerima</option>
                                <option value="lain-lain" <?php echo ($row['referensi_root_cause'] == 'lain-lain') ? 'selected' : ''; ?>>Lain-Lain</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="tindakan_pencegahan" class="form-label">Tindakan Pencegahan</label>
                            <input type="text" class="form-control" id="tindakan_pencegahan" name="tindakan_pencegahan" value="<?php echo $row['tindakan_pencegahan']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="corrective_action" class="form-label">corrective Action</label>
                            <select class="form-select" id="corrective_action" name="corrective_action" required>
                                <option value="" disabled selected>Pilih corrective action</option>
                                <option value="surat pemanggilan pegawai organik" <?php echo ($row['corrective_action'] == 'surat pemanggilan pegawai organik') ? 'selected' : ''; ?>>Surat Pemanggilan Pegawai Organik</option>
                                <option value="sp2 + denda (kemitraan/agenpos)" <?php echo ($row['corrective_action'] == 'sp2 + Denda (kemitraan/agenpos)') ? 'selected' : ''; ?>>SP2 + Denda (Kemitraan/Agenpos)</option>
                                <option value="sp3 + denda tingkat berat/phk/penghentian kerjasama" <?php echo ($row['corrective_action'] == 'sp3 + dendatingkat berat/phk/penghentian kerjasama') ? 'selected' : ''; ?>>SP3 + DendaTingkat Berat/PHK/Penghentian Kerjasama</option>
                                <option value="surat pemberitahuan kepada pengirim" <?php echo ($row['corrective_action'] == 'surat pemberitahuan kepada pengirim') ? 'selected' : ''; ?>>Surat Pemberitahuan Kepada Pengirim</option>
                                <option value="tidak ada" <?php echo ($row['corrective_action'] == 'tidak ada') ? 'selected' : ''; ?>>Tidak Ada</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="locus" class="form-label">Locus</label>
                            <input type="text" class="form-control" id="locus" name="locus" value="<?php echo $row['locus']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nama_nik_pegawai" class="form-label">Nama/NIK Pegawai</label>
                            <input type="text" class="form-control" id="nama_nik_pegawai" name="nama_nik_pegawai" value="<?php echo $row['nama_nik_pegawai']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="nomor_evidence" class="form-label">No Evidence</label>
                            <input type="text" class="form-control" id="nomor_evidence" name="nomor_evidence" value="<?php echo $row['nomor_evidence']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="validasi_regional" class="form-label">Validasi Regional</label>
                            <input type="text" class="form-control" id="validasi_regional" name="validasi_regional" value="<?php echo $row['validasi_regional']; ?>" required>
                        </div>

                        <div class="mb-3">
                            <label for="validasi_pusat" class="form-label">Validasi Pusat</label>
                            <select class="form-select" id="validasi_pusat" name="validasi_pusat" required>
                                <option value="" disabled selected>Pilih status validasi</option>
                                <option value="ok" <?php echo ($row['validasi_pusat'] == 'ok') ? 'selected' : ''; ?>>OK</option>
                                <option value="belum entri evaluasi" <?php echo ($row['validasi_pusat'] == 'belum entri evaluasi') ? 'selected' : ''; ?>>Belum Entri Evaluasi</option>
                                <option value="evidence belum upload" <?php echo ($row['validasi_pusat'] == 'evidence belum upload') ? 'selected' : ''; ?>>Evidence Belum Upload</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="../html/pages-regional settings-reg1.php" class="btn btn-secondary">Cancel</a>
                    </form>

                    <?php
                    } else {
                        echo "Data tidak ditemukan.";
                    }

                    $koneksi->close();
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
