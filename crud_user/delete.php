<?php
$host = "localhost"; // atau nama host lain
$user = "root"; // username MySQL
$password = ""; // password MySQL
$database = "iregularitas"; // nama database

// Koneksi ke database
$conn = mysqli_connect($host, $user, $password, $database);

// Periksa koneksi
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Ambil ID dari request POST
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // SQL untuk menghapus data
    $sql = "DELETE FROM user WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // Mengikat parameter, "i" berarti integer

    // Eksekusi statement
    if ($stmt->execute()) {
        echo 'success'; // Jika berhasil
    } else {
        echo 'error'; // Jika gagal
    }

    // Menutup statement dan koneksi
    $stmt->close();
}

// Menutup koneksi
$conn->close();
?>
