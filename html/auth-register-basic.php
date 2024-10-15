<?php
include 'config.php'; // Include your database configuration

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Capture form data
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $jenis = $_POST['jenis'];
    $regional = $_POST['regional'];
    $kantor_asal = $_POST['kantor_asal'];
    $password = $_POST['password'];
    
    // Validate form data (basic validation example)
    if (empty($username) || empty($nama) || empty($nik) || empty($jenis) || empty($regional) || empty($kantor_asal)  || empty($password)) {
        echo "All fields are required!";
        exit;
    }

    // Check if NIK already exists
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE nik = ?");
    $stmt->bind_param("s", $nik);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // NIK already exists
        echo "<script>alert('NIK sudah terdaftar! Silakan gunakan NIK lain.'); window.location.href='auth-register-basic.php';</script>";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement
        $stmt = $koneksi->prepare("INSERT INTO user (username, nama, nik, jenis, regional, kantor_asal,  password) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param("sssssss", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $hashed_password);

        // Password validation
        if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$/', $password)) {
            echo "<script>
                  alert('Password minimal harus 6 karakter, mengandung minimal satu huruf dan satu angka.');
                  window.location.href = 'auth-register-basic.php'; // Ganti dengan nama file registrasi Anda jika berbeda
                </script>";
            exit;
        }

        // Execute the query
        if ($stmt->execute()) {
            // Successful registration alert and redirect
            echo "<script>
                  alert('Registration successful!');
                  window.location.href = 'auth-login-basic.php'; // Ganti dengan nama file registrasi Anda jika berbeda
                </script>";
            exit(); // Make sure to call exit after the JavaScript
        } else {
            echo "Error: " . $stmt->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en" 
class="light-style customizer-hide" 
dir="ltr" data-theme="theme-default" 
data-assets-path="../assets/" 
data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Register - Pages | Iregularitas</title>
    <meta name="description" content="" />
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <script src="../assets/vendor/js/helpers.js"></script>
    <script src="../assets/js/config.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
        { kode: "16900", nama: "16900 - DEPOK", kcu: "KCU BOGOR" },
        { kode: "18000", nama: "18000 - BEKASI", kcu: "KCU BEKASI" },
        { kode: "19000", nama: "19000 - BANTEN", kcu: "KCU BANTEN" },
        { kode: "19500", nama: "19500 - SERANG", kcu: "KCU SERANG" },
    ],
    "Regional 3 - Jawa Barat": [
        { "kode": "40000", nama: "40000 - BANDUNG", "kcu": "KCU BANDUNG" },
        { "kode": "40100", nama: "40100 - UJUNGBERUNG", "kcu": "KCU BANDUNG" },
        { "kode": "41200", nama: "41200 - SUBANG", "kcu": "KCU KARAWANG" },
        { "kode": "41300", nama: "41300 - KARAWANG", "kcu": "KCU KARAWANG" },
        { "kode": "45100", nama: "45100 - CIREBON", "kcu": "KCU CIREBON" },
        { "kode": "45200", nama: "45200 - INDRAMAYU", "kcu": "KCU CIREBON" }
    ],
    "Regional 4 - Jawa Tengah & DIY":[
        { "kode": "50000", nama: "50000 - SEMARANG", "kcu": "KCU SEMARANG" },
        { "kode": "55400", nama: "55400 - SPP YOGYAKARTA", "kcu": "KCU YOGYAKARTA" },
        { "kode": "53100", nama: "53100 - PURWOKERTO", "kcu": "KCU PURWOKERTO" },
        { "kode": "53200", nama: "53200 - CILACAP", "kcu": "KCU PURWOKERTO" },
        { "kode": "55000", nama: "55000 - YOGYAKARTA", "kcu": "KCU YOGYAKARTA" },
        { "kode": "56300", nama: "56300 - WONOSOBO", "kcu": "KCU PEKALONGAN" },
        { "kode": "57100", nama: "57100 - SOLO", "kcu": "KCU SOLO" },
        { "kode": "57200", nama: "57200 - SRAGEN", "kcu": "KCU SOLO" },
        { "kode": "58100", nama: "58100 - PURWODADIGROBOGAN", "kcu": "KCU SEMARANG" },
        { "kode": "58200", nama: "58200 - BLORA", "kcu": "KCU SEMARANG" }
    ],
    "Regional 5 - Jawa Timur, Bali & Nusa Tenggara": [
      { "kode": "80900", nama: "80900 - SPP DENPASAR", "kcu": "KCU DENPASAR" },
      { "kode": "60000", nama: "60000 - SURABAYA", "kcu": "KCU SURABAYA" },
      { "kode": "60900", nama: "60900 - SPP SURABAYA", "kcu": "KCU SURABAYA" },
      { "kode": "62100", nama: "62100 - BOJONEGORO", "kcu": "KCU MADIUN" },
      { "kode": "62200", nama: "62200 - LAMONGAN", "kcu": "KCU MADIUN" },
      { "kode": "64100", nama: "64100 - KEDIRI", "kcu": "KCU MALANG" },
      { "kode": "64200", nama: "64200 - PARE", "kcu": "KCU MALANG" },
      { "kode": "67200", nama: "67200 - PROBOLINGGO", "kcu": "KCU JEMBER" },
      { "kode": "67300", nama: "67300 - LUMAJANG", "kcu": "KCU JEMBER" },
      { "kode": "85000", nama: "85000 - KUPANG", "kcu": "KCU KUPANG" },
      { "kode": "85500", nama: "85500 - SOE", "kcu": "KCU KUPANG" }
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

<body style="background-color: #f8f9fa;">
    <div class="container-xxl">
        <div class=" authentication-basic container-p-y">
            <div class="">
                <!-- Card -->
                <div class="card shadow-lg border-0 rounded-lg" style="max-width: 900px; margin: 0 auto;">
                    <div class="card-body p-4">
                        <!-- Logo and Title -->
                        <div class="app-brand justify-content-center mb-3">
                            <a href="auth-register-basic.php" class="app-brand-link d-flex align-items-center">
                                <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45" class="me-2">
                                <span class="app-brand-text menu-text fw-bolder ms-2" style="font-size: 1.5rem;">ReguTrack</span>
                            </a>
                        </div>
                        <h4 class="text-center mb-3" style="font-size: 1.25rem;">Empowering You to Uncover Hidden Irregularities</h4>
                        <p class="text-center mb-4" style="font-size: 0.9rem;">Simplify your oversight and ensure operational excellence!</p>

                        <!-- Registration Form -->
                        <form id="formAuthentication" class="mb-3" action="" method="POST">
                            <div class="row">
                                <!-- Username -->
                                <div class="col-md-6 mb-3">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control shadow-sm" id="username" name="username" placeholder="Enter your username" required />
                                </div>

                                <!-- Nama -->
                                <div class="col-md-6 mb-3">
                                    <label for="nama" class="form-label">Nama</label>
                                    <input type="text" class="form-control shadow-sm" id="nama" name="nama" placeholder="Enter your name" required />
                                </div>
                            </div>

                            <div class="row">
                                <!-- NIPPos -->
                                <div class="col-md-6 mb-3">
                                    <label for="nik" class="form-label">NIPPos</label>
                                    <input type="text" class="form-control shadow-sm" id="nik" name="nik" placeholder="Enter your NIPPOS" required />
                                </div>

                                <!-- Jenis Kantor -->
                                <div class="col-md-6 mb-3">
                                    <label for="jenis" class="form-label">Jenis Kantor</label>
                                    <select class="form-control shadow-sm" id="jenis" name="jenis" required>
                                        <option value="" disabled selected>Pilih Jenis Kantor</option>
                                        <option value="KC">KC</option>
                                        <option value="KCU">KCU</option>
                                        <option value="SPP">SPP</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">
                                <!-- Regional -->
                                <div class="col-md-6 mb-3">
                                    <label for="regional" class="form-label">Regional</label>
                                    <select class="form-control" id="regional" name="regional" required>
                                        <option value="Pilih Regional">Pilih Regional</option>
                                        <option value="Regional 1 - Sumatra">Regional 1 - Sumatra</option>
                                        <option value="Regional 2 - Jakarta & Banten">Regional 2 - Jakarta & Banten</option>
                                        <option value="Regional 3 - Jawa Barat">Regional 3 - Jawa Barat</option>
                                        <option value="Regional 4 - Jawa Tengah & DIY">Regional 4 - Jawa Tengah & DIY</option>
                                        <option value="Regional 5 - Jawa Timur, Bali & Nusa Tenggara">Regional 5 - Jawa Timur, Bali & Nusa Tenggara</option>
                                        <option value="Regional 6 - Kalimantan, Sulawesi & Papua">Regional 6 - Kalimantan, Sulawesi & Papua</option>
                                    </select>
                                </div>

                                <!-- Kantor Asal -->
                                <div class="col-md-6 mb-3">
                                    <label for="kantor_asal" class="form-label">Kantor Asal</label>
                                    <select class="form-control shadow-sm" id="kantor_asal" name="kantor_asal" required>
                                        <option value="" disabled selected>Pilih Kantor Asal</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row">

                                <!-- Password -->
                                <div class="col-md-6 mb-3 form-password-toggle">
                                    <label for="password" class="form-label">Password</label>
                                    <div class="input-group input-group-merge">
                                        <input type="password" id="password" class="form-control shadow-sm" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                    </div>
                                </div>
                            </div>

                            <!-- Terms & Conditions -->
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                                    <label class="form-check-label" for="terms-conditions" style="font-size: 0.85rem;">
                                        I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <button id="saveButton" class="register btn btn-primary d-grid w-100 shadow-sm">Sign Up</button>
                        </form>

                        <p class="text-center mt-3" style="font-size: 0.85rem;">
                            <span>Already have an account?</span>
                            <a href="auth-login-basic.php"><span>Sign in instead</span></a>
                        </p>
                    </div>
                </div>
                <!-- /Card -->
            </div>
        </div>
    </div>

    <!-- Script dependencies -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
</body>

</html>
