<?php
include 'config.php'; // Include database configuration

// Set timezone
date_default_timezone_set('Asia/Jakarta'); // Set to your timezone

// Get the posted data
$data = json_decode(file_get_contents('php://input'), true);

// Check if we have data
if (!empty($data)) {
    // Prepare SQL statement
    $stmt = $koneksi->prepare("INSERT INTO iregular (id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, 
        tanggal_berita_acara, bulan, week, tahun, 
        reg_tujuan_p6, kantor_tujuan_p6, nopend_tujuan_p6, deskripsi, 
        dnln, nomor_kiriman, uraian_berita_acara, deskripsi_iregularitas, 
        rincian_root_cause, referensi_root_cause, tindakan_pencegahan, 
        corrective_action, locus, nama_nik_pegawai, nomor_evidence, 
        validasi_regional, validasi_pusat) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    foreach ($data as $row) {
        // Assuming that $row corresponds to: [id_sistem, reg_asal_p6, kantor_asal_p6, nopend_asal_p6, ...]
        $id_sistem = $row[0];
        $reg_asal_p6 = $row[1];
        $kantor_asal_p6 = $row[2];
        $nopend_asal_p6 = $row[3];

        // Format the date from input
        $tanggal_berita_acara = $row[4]; // Expecting 'YYYY-MM-DD HH:mm:ss'
        // Attempt to create a DateTime object
        $dateTime = DateTime::createFromFormat('Y-m-d H:i:s', $tanggal_berita_acara);

        // Check if date is valid
        if ($dateTime === false) {
            echo "Invalid date format: " . $tanggal_berita_acara;
            exit; // Exit if the date format is invalid
        }

        // Reformat date to MySQL DATETIME format if needed
        $tanggal_berita_acara = $dateTime->format('Y-m-d H:i:s');

        $bulan = $row[5];
        $week = $row[6];
        $tahun = $row[7];
        $reg_tujuan_p6 = $row[8];
        $kantor_tujuan_p6 = $row[9];
        $nopend_tujuan_p6 = $row[10];
        $deskripsi = $row[11];
        $dnln = $row[12];
        $nomor_kiriman = $row[13];
        $uraian_berita_acara = $row[14];
        $deskripsi_iregularitas = $row[15];
        $rincian_root_cause = $row[16];
        $referensi_root_cause = $row[17];
        $tindakan_pencegahan = $row[18];
        $corrective_action = $row[19];
        $locus = $row[20];
        $nama_nik_pegawai = $row[21];
        $nomor_evidence = $row[22];
        $validasi_regional = $row[23];
        $validasi_pusat = $row[24];

        // Bind parameters
        $stmt->bind_param(
            'sssssssssssssssssssssssss',
            $id_sistem, $reg_asal_p6, $kantor_asal_p6, $nopend_asal_p6,
            $tanggal_berita_acara, $bulan, $week, $tahun,
            $reg_tujuan_p6, $kantor_tujuan_p6, $nopend_tujuan_p6, $deskripsi,
            $dnln, $nomor_kiriman, $uraian_berita_acara, $deskripsi_iregularitas,
            $rincian_root_cause, $referensi_root_cause, $tindakan_pencegahan, $corrective_action,
            $locus, $nama_nik_pegawai, $nomor_evidence, $validasi_regional, $validasi_pusat
        );

        // Execute the statement
        if ($stmt->execute()) {
            echo "Data successfully saved!";
        } else {
            echo "Error executing query: " . $stmt->error;
        }
    }

    $stmt->close();
} else {
    echo "No data received!";
}

$koneksi->close();
?>