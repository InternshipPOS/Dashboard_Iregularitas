<!DOCTYPE html>
<html lang="en" class="light-style layout-menu-fixed" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit Manage Users | Iregularitas</title>
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
    <script>
        // Post office data
        const postOffices = {
            "Regional 1 - Sumatra": [
                { kode: "20000", nama: "20000 - MEDAN", kcu: "KCU MEDAN" },
                { kode: "20600", nama: "20600 - TEBINGTINGGIDELI", kcu: "KCU MEDAN" },
                { kode: "23000", nama: "23000 - BANDAACEH", kcu: "KCU BANDAACEH" },
                { kode: "23600", nama: "23600 - MEULABOH", kcu: "KCU BANDAACEH" },
                { kode: "25000", nama: "25000 - PADANG", kcu: "KCU PADANG" },
                { kode: "25500", nama: "25500 - PARIAMAN", kcu: "KCU PADANG" },
                { kode: "28000", nama: "28000 - PEKANBARU", kcu: "KCU PEKANBARU" },
                { kode: "28500", nama: "28500 - BANGKINANG", kcu: "KCU PEKANBARU" },
                { kode: "29100", nama: "29100 - TANJUNGPINANG", kcu: "KCU BATAM" },
                { kode: "29400", nama: "29400 - BATAM", kcu: "KCU BATAM" },
                { kode: "30000", nama: "30000 - PALEMBANG", kcu: "KCU PALEMBANG" },
                { kode: "31100", nama: "31100 - PRABUMULIH", kcu: "KCU PALEMBANG" },
                { kode: "34500", nama: "34500 - KOTABUMI", kcu: "KCU BANDARLAMPUNG" },
                { kode: "35000", nama: "35000 - BANDARLAMPUNG", kcu: "KCU BANDARLAMPUNG" },
                { kode: "36000", nama: "36000 - JAMBI", kcu: "KCU JAMBI" },
                { kode: "37100", nama: "37100 - SUNGAIPENUH", kcu: "KCU JAMBI" },
                { kode: "38000", nama: "38000 - BENGKULU", kcu: "KCU BENGKULU" },
                { kode: "39100", nama: "39100 - CURUP", kcu: "KCU BENGKULU" }
            ],
            "Regional 2 - Jakarta & Banten": [
                { kode: "10000", nama: "10000 - JAKARTA CENTRUM", kcu: "KCU JAKARTACENTRUM" },
                { kode: "11000", nama: "11000 - JAKARTA OCEANIA", kcu: "KCU JAKARTAOCEANIA" },
                { kode: "12000", nama: "12000 - JAKARTA FLORA", kcu: "KCU JAKARTAFLORA" },
                { kode: "13000", nama: "13000 - JAKARTA PREMIER", kcu: "KCU JAKARTAPREMIER" },
                { kode: "15000", nama: "15000 - TANGERANG", kcu: "KCU TANGERANG" },
                { kode: "16000", nama: "16000 - BOGOR", kcu: "KCU BOGOR" },
                { kode: "17000", nama: "17000 - DEPOK", kcu: "KCU DEPOK" },
                { kode: "18000", nama: "18000 - BEKASI", kcu: "KCU BEKASI" },
                { kode: "19000", nama: "19000 - BANTEN", kcu: "KCU BANTEN" },
                { kode: "19500", nama: "19500 - SERANG", kcu: "KCU SERANG" }
            ],
            "Regional 3 - Jawa Barat": [
                { kode: "40000", nama: "40000 - BANDUNG", kcu: "KCU BANDUNG" },
                { kode: "40100", nama: "40100 - UJUNGBERUNG", kcu: "KCU BANDUNG" },
                { kode: "41200", nama: "41200 - SUBANG", kcu: "KCU KARAWANG" },
                { kode: "41300", nama: "41300 - KARAWANG", kcu: "KCU KARAWANG" },
                { kode: "45100", nama: "45100 - CIREBON", kcu: "KCU CIREBON" },
                { kode: "45200", nama: "45200 - INDRAMAYU", kcu: "KCU CIREBON" }
            ],
            "Regional 4 - Jawa Tengah & DIY":[
                { kode: "50000", nama: "50000 - SEMARANG", kcu: "KCU SEMARANG" },
                { kode: "55400", nama: "55400 - SPP YOGYAKARTA", kcu: "KCU YOGYAKARTA" },
                { kode: "53100", nama: "53100 - PURWOKERTO", kcu: "KCU PURWOKERTO" },
                { kode: "53200", nama: "53200 - CILACAP", kcu: "KCU PURWOKERTO" },
                { kode: "55000", nama: "55000 - YOGYAKARTA", kcu: "KCU YOGYAKARTA" },
                { kode: "56300", nama: "56300 - WONOSOBO", kcu: "KCU PEKALONGAN" },
                { kode: "57100", nama: "57100 - SOLO", kcu: "KCU SOLO" },
                { kode: "57200", nama: "57200 - SRAGEN", kcu: "KCU SOLO" },
                { kode: "58100", nama: "58100 - PURWODADIGROBOGAN", kcu: "KCU SEMARANG" },
                { kode: "58200", nama: "58200 - BLORA", kcu: "KCU SEMARANG" }
            ],
            "Regional 5 - Jawa Timur, Bali & Nusa Tenggara": [
                { kode: "80900", nama: "80900 - SPP DENPASAR", kcu: "KCU DENPASAR" },
                { kode: "60000", nama: "60000 - SURABAYA", kcu: "KCU SURABAYA" },
                { kode: "60900", nama: "60900 - SPP SURABAYA", kcu: "KCU SURABAYA" },
                { kode: "62100", nama: "62100 - BOJONEGORO", kcu: "KCU MADIUN" },
                { kode: "62200", nama: "62200 - LAMONGAN", kcu: "KCU MADIUN" },
                { kode: "64100", nama: "64100 - KEDIRI", kcu: "KCU MALANG" },
                { kode: "64200", nama: "64200 - PARE", kcu: "KCU MALANG" },
                { kode: "65100", nama: "65100 - MALANG", kcu: "KCU MALANG" },
                { kode: "67100", nama: "67100 - PROBOLINGGO", kcu: "KCU JEMBER" }
            ],
            "Regional 6 - Kalimantan, Sulawesi & Papua": [
            { "kode": "70000", nama: "70000 - BANJARMASIN", "kcu": "KCU BANJARMASIN" },
            { "kode": "70400", nama: "70400 - SPP BANJARMASIN", "kcu": "KCU BANJARMASIN" },
            { "kode": "73000", nama: "73000 - PALANGKARAYA", "kcu": "KCU PALANGKARAYA" },
            { "kode": "73700", nama: "73700 - BUNTOK", "kcu": "KCU PALANGKARAYA" },
            { "kode": "75000", nama: "75000 - SAMARINDA", "kcu": "KCU BALIKPAPAN" },
            { "kode": "75300", nama: "75300 - BONTANG", "kcu": "KCU BALIKPAPAN" },
            { "kode": "78000", nama: "78000 - PONTIANAK", "kcu": "KCU PONTIANAK" },
            { "kode": "78500", nama: "78500 - SANGGAU", "kcu": "KCU PONTIANAK" },
            { "kode": "90000", nama: "90000 - MAKASSAR", "kcu": "KCU MAKASSAR" },
            { "kode": "91100", nama: "91100 - PAREPARE", "kcu": "KCU MAKASSAR" },
            { "kode": "93000", nama: "93000 - KENDARI", "kcu": "KCU KENDARI" },
            { "kode": "93700", nama: "93700 - BAUBAU", "kcu": "KCU KENDARI" },
            { "kode": "95000", nama: "95000 - MANADO", "kcu": "KCU MANADO" },
            { "kode": "95700", nama: "95700 - KOTAMOBAGU", "kcu": "KCU MANADO" },
            { "kode": "97000", nama: "97000 - AMBON", "kcu": "KCU AMBON" },
            { "kode": "97600", nama: "97600 - TUAL", "kcu": "KCU AMBON" },
            { "kode": "98100", nama: "98100 - BIAK", "kcu": "KCU JAYAPURA" },
            { "kode": "98300", nama: "98300 - MANOKWARI", "kcu": "KCU JAYAPURA" }
            ],
        };

        $(document).ready(function() {
        // Set the selected kantorn_asal based on existing data
        var existingKantorAsal = "<?php echo isset($row['kantor_asal']) ? $row['kantor_asal'] : ''; ?>";
        
        // Ketika regional berubah
        $('#regional').change(function() {
            var regionalId = $(this).val();
            var postOfficeSelect = $('#kantor_asal');
            postOfficeSelect.empty(); // Reset dropdown

            // Populasi kantor_asal berdasarkan regional yang dipilih
            if (postOffices[regionalId]) {
                postOffices[regionalId].forEach(office => {
                    postOfficeSelect.append(`<option value="${office.kcu}|${office.nama}" ${existingKantorAsal == office.kcu + '|' + office.nama ? 'selected' : ''}>${office.nama}</option>`);
                });
            }

        });

        // Trigger change event on page load to set the initial state
        $('#regional').trigger('change');
    });
    </script>
</head>

<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Edit Users</span></h4>

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

                            // Check if 'id' is set in the URL
                            if (isset($_GET['id'])) {
                                $id = $_GET['id'];
                            } else {
                                die("Error: ID not found.");
                            }

                            // Cek jika form telah disubmit
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                // Mendapatkan data dari form
                                $username = $_POST['username'];
                                $nama = $_POST['nama'];
                                $nik = $_POST['nik'];
                                $jenis = $_POST['jenis'];
                                $regional = $_POST['regional'];
                                $kantor_asal = $_POST['kantor_asal'];
                                
                                // Query untuk mengupdate data
                                $sql = "UPDATE user SET 
                                            username='$username', 
                                            nama='$nama', 
                                            nik='$nik', 
                                            jenis='$jenis', 
                                            regional='$regional',
                                            kantor_asal='$kantor_asal'
                                        WHERE id='$id'";

                                if ($koneksi->query($sql) === TRUE) {
                                    echo "<script>
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Data berhasil diperbarui!',
                                            showConfirmButton: true
                                        }).then(function() {
                                            window.location.href = '../html/manage-user.php';
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
                            $sql = "SELECT * FROM user WHERE id='$id'";
                            $result = $koneksi->query($sql);

                            if ($result->num_rows > 0) {
                                $row = $result->fetch_assoc();
                            ?>
                                <form action="" method="POST">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

                                    <div class="mb-3">
                                        <label for="username" class="form-label">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" value="<?php echo $row['username']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="nik" class="form-label">NIPPOS</label>
                                        <input type="text" class="form-control" id="nik" name="nik" value="<?php echo $row['nik']; ?>" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jenis" class="form-label">Jenis Kantor</label>
                                        <select class="form-select" id="jenis" name="jenis" required>
                                            <option value="">Jenis Kantor</option>
                                            <option value="KC" <?php echo ($row['jenis'] == "KC") ? 'selected' : ''; ?>>KC</option>
                                            <option value="KCU" <?php echo ($row['jenis'] == "KCU") ? 'selected' : ''; ?>>KCU</option>
                                            <option value="SPP" <?php echo ($row['jenis'] == "SPP") ? 'selected' : ''; ?>>SPP</option>
                                        </select>
                                    </div>


                                    <div class="mb-3">
                                        <label for="regional" class="form-label">Regional</label>
                                        <select class="form-select" id="regional" name="regional" required>
                                            <option value="Regional 1 - Sumatra" <?php echo ($row['regional'] == "Regional 1 - Sumatra") ? 'selected' : ''; ?>>Regional 1 - Sumatra</option>
                                            <option value="Regional 2 - Jakarta & Banten" <?php echo ($row['regional'] == "Regional 2 - Jakarta & Banten") ? 'selected' : ''; ?>>Regional 2 - Jakarta & Banten</option>
                                            <option value="Regional 3 - Jawa Barat" <?php echo ($row['regional'] == "Regional 3 - Jawa Barat") ? 'selected' : ''; ?>>Regional 3 - Jawa Barat</option>
                                            <option value="Regional 4 - Jawa Tengah & DIY" <?php echo ($row['regional'] == "Regional 4 - Jawa Tengah & DIY") ? 'selected' : ''; ?>>Regional 4 - Jawa Tengah & DIY</option>
                                            <option value="Regional 5 - Jawa Timur, Bali & Nusa Tenggara" <?php echo ($row['regional'] == "Regional 5 - Jawa Timur, Bali & Nusa Tenggara") ? 'selected' : ''; ?>>Regional 5 - Jawa Timur, Bali & Nusa Tenggara</option>
                                            <option value="Regional 6 - Kalimantan, Sulawesi & Papua" <?php echo ($row['regional'] == "Regional 6 - Kalimantan, Sulawesi & Papua") ? 'selected' : ''; ?>>Regional 6 - Kalimantan, Sulawesi & Papua</option>
                                        </select>
                                    </div>


                                    <!-- Tambahan kolom baru -->
                                    <div class="mb-3">
                                        <label for="kantor_asal" class="form-label">Kantor Asal</label>
                                        <select class="form-select" id="kantor_asal" name="kantor_asal" required>
                                            <!-- Kantor Asal will be populated by JavaScript -->
                                        </select>
                                    </div>

                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="../html/manage-user.php" class="btn btn-secondary">Cancel</a>
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
