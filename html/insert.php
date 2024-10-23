<?php
// Parameter yang ingin dimasukkan
$userName = '';
$email = '';

// Statement untuk memanggil stored procedure
$sql = "CALL InsertUsers(?, ?)";

// Mempersiapkan statement
if ($stmt = $conn->prepare($sql)) {
    // Mengikat parameter ke statement
    $stmt->bind_param("ss", $userName, $email);

    // Menjalankan statement
    if ($stmt->execute()) {
        echo "Data berhasil disisipkan!";
    } else {
        echo "Gagal menyisipkan data: " . $stmt->error;
    }

    // Menutup statement
    $stmt->close();
} else {
    echo "Error: " . $conn->error;
}

// Menutup koneksi
$conn->close();
?>
