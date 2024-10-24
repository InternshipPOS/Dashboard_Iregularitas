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
                        //$koneksi->query($sql1);
                        //$koneksi->query($sql2);
                     
                        if ($koneksi->query($sql1) === TRUE && $koneksi->query($sql2) === TRUE) {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Sukses!',
                                        text: 'Data berhasil diperbarui.',
                                        icon: 'success',
                                        confirmButtonText: 'OK'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            window.location.href = '../html/pages-regional settings-reg11.php'; 
                                        }
                                    });
                                  </script>";
                        } else {
                            echo "<script>
                                    Swal.fire({
                                        title: 'Error!',
                                        text: 'Gagal memperbarui data.',
                                        icon: 'error',
                                        confirmButtonText: 'OK'
                                    });
                                  </script>";
                        }
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
                                <label for="ZonaAsal" class="form-label">Reg Asal P6</label>
                                <input type="text" class="form-control" id="ZonaAsal" name="ZonaAsal" value="<?php echo $row1['ZonaAsal']; ?>">
                            </div>

                            <!-- Nama Kantor Asal -->
                            <div class="mb-3">
                                <label for="Nama_Kantor_Asal" class="form-label">Kantor Asal P6</label>
                                <input type="text" class="form-control" id="Nama_Kantor_Asal" name="Nama_Kantor_Asal" value="<?php echo $row1['Nama_Kantor_Asal']; ?>">
                            </div>

                            <!-- Kantor Asal -->
                            <div class="mb-3">
                                <label for="Kantor_Asal" class="form-label">Nopend Asal P6</label>
                                <input type="text" class="form-control" id="Kantor_Asal" name="Kantor_Asal" value="<?php echo $row1['Kantor_Asal']; ?>">
                            </div>

                            <!-- Tanggal Berita Acara -->
                            <div class="mb-3">
                                <label for="Tanggal_Berita_Acara" class="form-label">Tanggal Berita Acara</label>
                                <input type="date" class="form-control" id="Tanggal_Berita_Acara" name="Tanggal_Berita_Acara" value="<?php echo $row1['Tanggal_Berita_Acara']; ?>">
                            </div>

                            <!-- Kantor Tujuan -->
                            <div class="mb-3">
                                <label for="Kantor_Tujuan" class="form-label">Nopend Tujuan P6</label>
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
                                <input type="text" class="form-control" id="Deskripsi_Iregularitas" name="Deskripsi_Iregularitas" value="<?php echo htmlspecialchars($row1['Deskripsi_Iregularitas']); ?>">
                            </div>


                        <?php
                    }

                    // Query untuk rincian_root_cause dan referensi_root_cause
                    $sql2 = "SELECT Rincian_Root_Cause, Referensi_Root_Cause, Tindakan_Pencegahan, Corrective_Action, Locus, Nama_NIK_Pegawai, No_Evidence, Validasi_Regional, Validasi_Pusat FROM newtab WHERE id_sistem='$id_sistem'";
                    $result2 = $koneksi->query($sql2);

                    if ($result2 && $result2->num_rows > 0) {
                        $row2 = $result2->fetch_assoc();
                        ?>
                            <!-- Rincian Root Cause -->
                            <div class="mb-3">
                                <label for="rincian_root_cause" class="form-label">Rincian Root Cause</label>
                                <textarea class="form-control" id="rincian_root_cause" name="rincian_root_cause" ><?php echo $row2['Rincian_Root_Cause']; ?></textarea>
                            </div>

                            <!-- Referensi Root Cause -->
                            <div class="mb-3">
                                <label for="referensi_root_cause" class="form-label">Referensi Root Cause</label>
                                <select class="form-select" id="referensi_root_cause" name="referensi_root_cause">
                                    <option value="" disabled <?php echo empty($row2['Referensi_Root_Cause']) ? 'selected' : ''; ?>>Pilih referensi root cause</option>
                                    <option value="gagal x-ray kiriman import" <?php echo ($row2['Referensi_Root_Cause'] == 'gagal x-ray kiriman import') ? 'selected' : ''; ?>>Gagal x-ray kiriman import</option>
                                    <option value="incoming ln" <?php echo ($row2['Referensi_Root_Cause'] == 'incoming ln') ? 'selected' : ''; ?>>Incoming LN</option>
                                    <option value="pengirim tidak menginfokan isi kiriman yang benar" <?php echo ($row2['Referensi_Root_Cause'] == 'pengirim tidak menginfokan isi kiriman yang benar') ? 'selected' : ''; ?>>Pengirim tidak menginfokan isi kiriman yang benar</option>
                                    <option value="petugas melakukan froud/kecurangan" <?php echo ($row2['Referensi_Root_Cause'] == 'petugas melakukan froud/kecurangan') ? 'selected' : ''; ?>>Petugas melakukan froud/kecurangan</option>
                                    <option value="petugas tidak melaksanakan sop" <?php echo ($row2['Referensi_Root_Cause'] == 'petugas tidak melaksanakan sop') ? 'selected' : ''; ?>>Petugas tidak melaksanakan SOP</option>
                                    <option value="petugas tidak memeriksa isi kiriman (khusus pos internasional)" <?php echo ($row2['Referensi_Root_Cause'] == 'petugas tidak memeriksa isi kiriman (khusus pos internasional)') ? 'selected' : ''; ?>>Petugas tidak memeriksa isi kiriman (khusus pos internasional)</option>
                                    <option value="petugas tidak memeriksa packing" <?php echo ($row2['Referensi_Root_Cause'] == 'petugas tidak memeriksa packing') ? 'selected' : ''; ?>>Petugas tidak memeriksa packing</option>
                                    <option value="petugas tidak menanyakan isi kiriman" <?php echo ($row2['Referensi_Root_Cause'] == 'petugas tidak menanyakan isi kiriman') ? 'selected' : ''; ?>>Petugas tidak menanyakan isi kiriman</option>
                                    <option value="petugas tidak teliti" <?php echo ($row2['Referensi_Root_Cause'] == 'petugas tidak teliti') ? 'selected' : ''; ?>>Petugas tidak teliti</option>
                                    <option value="salah salur p6" <?php echo ($row2['Referensi_Root_Cause'] == 'salah salur p6') ? 'selected' : ''; ?>>Salah salur P6</option>
                                    <option value="potensi kerusakan pada saat perjalanan" <?php echo ($row2['Referensi_Root_Cause'] == 'potensi kerusakan pada saat perjalanan') ? 'selected' : ''; ?>>Potensi kerusakan pada saat perjalanan</option>
                                    <option value="pengirim tidak melakukan packing dengan baik" <?php echo ($row2['Referensi_Root_Cause'] == 'pengirim tidak melakukan packing dengan baik') ? 'selected' : ''; ?>>Pengirim tidak melakukan packing dengan baik</option>
                                    <option value="pengirim salah memberikan data penerima" <?php echo ($row2['Referensi_Root_Cause'] == 'pengirim salah memberikan data penerima') ? 'selected' : ''; ?>>Pengirim salah memberikan data penerima</option>
                                    <option value="lain-lain" <?php echo ($row2['Referensi_Root_Cause'] == 'lain-lain') ? 'selected' : ''; ?>>Lain-lain</option>
                                </select>
                            </div>

                            <!-- Tindakan Pencegahan -->
                            <div class="mb-3">
                                <label for="tindakan_pencegahan" class="form-label">Tindakan Pencegahan</label>
                                <input type="text" class="form-control" id="tindakan_pencegahan" name="tindakan_pencegahan" value="<?php echo $row2['Tindakan_Pencegahan']; ?>">
                            </div>


                            <!-- Corrective Action -->
                            <div class="mb-3">
                                <label for="corrective_action" class="form-label">Corrective Action</label>
                                <select class="form-select" id="corrective_action" name="corrective_action">
                                    <option value="" disabled <?php echo empty($row2['Corrective_Action']) ? 'selected' : ''; ?>>Pilih corrective action</option>
                                    <option value="surat pemanggilan pegawai organik" <?php echo ($row2['Corrective_Action'] == 'surat pemanggilan pegawai organik') ? 'selected' : ''; ?>>Surat pemanggilan pegawai organik</option>
                                    <option value="sp2 + denda (kemitraan/agenpos)" <?php echo ($row2['Corrective_Action'] == 'sp2 + denda (kemitraan/agenpos)') ? 'selected' : ''; ?>>SP2 + denda (kemitraan/agenpos)</option>
                                    <option value="sp3 + denda tingkat berat/phk/penghentian kerjasama" <?php echo ($row2['Corrective_Action'] == 'sp3 + denda tingkat berat/phk/penghentian kerjasama') ? 'selected' : ''; ?>>SP3 + denda tingkat berat/PHK/penghentian kerjasama</option>
                                    <option value="surat pemberitahuan kepada pengirim" <?php echo ($row2['Corrective_Action'] == 'surat pemberitahuan kepada pengirim') ? 'selected' : ''; ?>>Surat pemberitahuan kepada pengirim</option>
                                    <option value="tidak ada" <?php echo ($row2['Corrective_Action'] == 'tidak ada') ? 'selected' : ''; ?>>Tidak ada</option>
                                </select>
                            </div>


                            <!-- Locus -->
                            <div class="mb-3">
                                <label for="locus" class="form-label">Locus</label>
                                <input type="text" class="form-control" id="locus" name="locus" value="<?php echo $row2['Locus']; ?>">
                            </div>

                            <!-- Nama NIK Pegawai -->
                            <div class="mb-3">
                                <label for="nama_nik_pegawai" class="form-label">Nama NIK Pegawai</label>
                                <input type="text" class="form-control" id="nama_nik_pegawai" name="nama_nik_pegawai" value="<?php echo $row2['Nama_NIK_Pegawai']; ?>">
                            </div>

                            <!-- No Evidence -->
                            <div class="mb-3">
                                <label for="no_evidence" class="form-label">No Evidence</label>
                                <input type="text" class="form-control" id="no_evidence" name="no_evidence" value="<?php echo $row2['No_Evidence']; ?>">
                            </div>

                            <!-- Validasi Regional -->
                            <div class="mb-3">
                                <label for="validasi_regional" class="form-label">Validasi Regional</label>
                                <input type="text" class="form-control" id="validasi_regional" name="validasi_regional" value="<?php echo $row2['Validasi_Regional']; ?>">
                            </div>

                            <!-- Validasi Pusat -->
                            <div class="mb-3">
                                <label for="validasi_pusat" class="form-label">Validasi Pusat</label>
                                <select class="form-select" id="validasi_pusat" name="validasi_pusat">
                                    <option value="" disabled <?php echo empty($row2['Validasi_Pusat']) ? 'selected' : ''; ?>>Pilih status validasi</option>
                                    <option value="ok" <?php echo ($row2['Validasi_Pusat'] == 'ok') ? 'selected' : ''; ?>>OK</option>
                                    <option value="belum entri evaluasi" <?php echo ($row2['Validasi_Pusat'] == 'belum entri evaluasi') ? 'selected' : ''; ?>>Belum Entri Evaluasi</option>
                                    <option value="evidence belum upload" <?php echo ($row2['Validasi_Pusat'] == 'evidence belum upload') ? 'selected' : ''; ?>>Evidence Belum Upload</option>
                                </select>
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