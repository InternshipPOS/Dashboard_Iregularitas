<?php
$host = "localhost"; // atau nama host lain
$user = "root"; // username MySQL
$password = ""; // password MySQL
$database = "iregularitas"; // ganti sesuai nama database yang kamu buat

$koneksi = new mysqli($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

// Memastikan id_sistem dikirimkan sebagai parameter POST atau GET
if (isset($_POST['id_sistem']) || isset($_GET['id_sistem'])) {
    $id_sistem = isset($_POST['id_sistem']) ? $_POST['id_sistem'] : $_GET['id_sistem'];

    // Hapus dari tabel ireg_p6_entri
    $sql1 = "DELETE FROM ireg_p6_entri WHERE id_sistem = ?";
    $stmt1 = $koneksi->prepare($sql1);
    $stmt1->bind_param("s", $id_sistem);

    // Eksekusi query pertama
    if ($stmt1->execute()) {
        // Hapus dari tabel newreport hanya jika query pertama sukses
        $sql2 = "DELETE FROM newreport WHERE id_sistem = ?";
        $stmt2 = $koneksi->prepare($sql2);
        $stmt2->bind_param("s", $id_sistem);

        if ($stmt2->execute()) {
            echo 'success';
        } else {
            echo 'error on deleting from newreport';
        }
        $stmt2->close();
    } else {
        echo 'error on deleting from ireg_p6_entri';
    }
    
    $stmt1->close();
} else {
    echo 'ID Sistem tidak ditemukan';
}

$koneksi->close();
?>
