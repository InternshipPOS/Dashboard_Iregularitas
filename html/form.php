<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Input Nama dan Email</title>
</head>
<body>
    <h2>Form Input Nama dan Email</h2>
    
    <!-- Form untuk input nama dan email -->
    <form method="POST" action="">
        <label for="nama">Nama:</label><br>
        <input type="text" id="nama" name="nama" required><br><br>
        
        <label for="email">Email:</label><br>
        <input type="email" id="email" name="email" required><br><br>
        
        <input type="submit" value="Submit">
    </form>

    <?php
    // Mengecek apakah form telah di-submit
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Menangkap input nama dan email
        $nama = htmlspecialchars($_POST['nama']);
        $email = htmlspecialchars($_POST['email']);

        // Menampilkan hasil input
        echo "<h3>Data yang Anda Masukkan:</h3>";
        echo "Nama: " . $nama . "<br>";
        echo "Email: " . $email . "<br>";
    }
    ?>
</body>
</html>
