<?php
$host = "localhost"; // atau nama host lain
$user = "root"; // username MySQL
$password = ""; // password MySQL
$database = "iregularitas"; // ganti sesuai nama database yang kamu buat

$koneksi = mysqli_connect($host, $user, $password, $database);

if ($koneksi->connect_error) {
    die("Connection failed: " . $koneksi->connect_error);
}

if (isset($_POST['id_sistem'])) {
    $id_sistem = $_POST['id_sistem'];
    
    $sql = "DELETE FROM regional1 WHERE id_sistem = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $id_sistem);

    if ($stmt->execute()) {
        echo 'success';
    } else {
        echo 'error';
    }
    
    $stmt->close();
}
$koneksi->close();
?>
