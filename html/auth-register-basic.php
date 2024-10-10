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
    $kode_pos = $_POST['kode_pos'];
    $password = $_POST['password'];
    
    // Validate form data (basic validation example)
    if (empty($username) || empty($nama) || empty($nik) || empty($jenis) || empty($regional) || empty($kantor_asal) || empty($kode_pos) || empty($password)) {
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
        $stmt = $koneksi->prepare("INSERT INTO user (username, nama, nik, jenis, regional, kantor_asal, kode_pos, password) 
                                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

        // Bind parameters
        $stmt->bind_param("ssssssss", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $kode_pos, $hashed_password);

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
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/favicon.ico" />
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

        $(document).ready(function () {
            $('#regional').change(function () {
                const regionalId = $(this).val();
                const postOfficeSelect = $('#kantor_asal');
                const kodePosSelect = $('#kode_pos');

                // Clear previous options
                postOfficeSelect.empty().append('<option value="">Pilih Kantor Asal</option>');
                kodePosSelect.empty().append('<option value="">Pilih Kode Pos</option>');

                // Populate KC Asal based on selected regional
                if (postOffices[regionalId]) {
                    postOffices[regionalId].forEach(office => {
                        postOfficeSelect.append(`<option value="${office.kode}">${office.nama}</option>`);
                    });
                }
            });

            $('#kantor_asal').change(function () {
                const selectedKode = $(this).val();
                const kodePosSelect = $('#kode_pos');

                // Clear previous options
                kodePosSelect.empty().append('<option value="">Pilih Kode Pos</option>');

                // Populate Kode Pos based on selected KC Asal
                for (const regional in postOffices) {
                    const offices = postOffices[regional];
                    offices.forEach(office => {
                        if (office.kode === selectedKode) {
                            kodePosSelect.append(`<option value="${office.kode}">${office.kode}</option>`);
                        }
                    });
                }
            });
        });
    </script>
</head>

<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                        <a href="auth-register-basic.php" class="app-brand-link">
                            <span class="app-brand-logo demo">
                                <svg
                                width="25"
                                viewBox="0 0 25 42"
                                version="1.1"
                                xmlns="http://www.w3.org/2000/svg"
                                xmlns:xlink="http://www.w3.org/1999/xlink"
                                >
                                <defs>
                                    <path
                                    d="M13.7918663,0.358365126 L3.39788168,7.44174259 C0.566865006,9.69408886 -0.379795268,12.4788597 0.557900856,15.7960551 C0.68998853,16.2305145 1.09562888,17.7872135 3.12357076,19.2293357 C3.8146334,19.7207684 5.32369333,20.3834223 7.65075054,21.2172976 L7.59773219,21.2525164 L2.63468769,24.5493413 C0.445452254,26.3002124 0.0884951797,28.5083815 1.56381646,31.1738486 C2.83770406,32.8170431 5.20850219,33.2640127 7.09180128,32.5391577 C8.347334,32.0559211 11.4559176,30.0011079 16.4175519,26.3747182 C18.0338572,24.4997857 18.6973423,22.4544883 18.4080071,20.2388261 C17.963753,17.5346866 16.1776345,15.5799961 13.0496516,14.3747546 L10.9194936,13.4715819 L18.6192054,7.984237 L13.7918663,0.358365126 Z"
                                    id="path-1"
                                    ></path>
                                    <path
                                    d="M5.47320593,6.00457225 C4.05321814,8.216144 4.36334763,10.0722806 6.40359441,11.5729822 C8.61520715,12.571656 10.0999176,13.2171421 10.8577257,13.5094407 L15.5088241,14.433041 L18.6192054,7.984237 C15.5364148,3.11535317 13.9273018,0.573395879 13.7918663,0.358365126 C13.5790555,0.511491653 10.8061687,2.3935607 5.47320593,6.00457225 Z"
                                    id="path-3"
                                    ></path>
                                    <path
                                    d="M7.50063644,21.2294429 L12.3234468,23.3159332 C14.1688022,24.7579751 14.397098,26.4880487 13.008334,28.506154 C11.6195701,30.5242593 10.3099883,31.790241 9.07958868,32.3040991 C5.78142938,33.4346997 4.13234973,34 4.13234973,34 C4.13234973,34 2.75489982,33.0538207 2.37032616e-14,31.1614621 C-0.55822714,27.8186216 -0.55822714,26.0572515 -4.05231404e-15,25.8773518 C0.83734071,25.6075023 2.77988457,22.8248993 3.3049379,22.52991 C3.65497346,22.3332504 5.05353963,21.8997614 7.50063644,21.2294429 Z"
                                    id="path-4"
                                    ></path>
                                    <path
                                    d="M20.6,7.13333333 L25.6,13.8 C26.2627417,14.6836556 26.0836556,15.9372583 25.2,16.6 C24.8538077,16.8596443 24.4327404,17 24,17 L14,17 C12.8954305,17 12,16.1045695 12,15 C12,14.5672596 12.1403557,14.1461923 12.4,13.8 L17.4,7.13333333 C18.0627417,6.24967773 19.3163444,6.07059163 20.2,6.73333333 C20.3516113,6.84704183 20.4862915,6.981722 20.6,7.13333333 Z"
                                    id="path-5"
                                    ></path>
                                </defs>
                                <g id="g-app-brand" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <g id="Brand-Logo" transform="translate(-27.000000, -15.000000)">
                                    <g id="Icon" transform="translate(27.000000, 15.000000)">
                                        <g id="Mask" transform="translate(0.000000, 8.000000)">
                                        <mask id="mask-2" fill="white">
                                            <use xlink:href="#path-1"></use>
                                        </mask>
                                        <use fill="#696cff" xlink:href="#path-1"></use>
                                        <g id="Path-3" mask="url(#mask-2)">
                                            <use fill="#696cff" xlink:href="#path-3"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-3"></use>
                                        </g>
                                        <g id="Path-4" mask="url(#mask-2)">
                                            <use fill="#696cff" xlink:href="#path-4"></use>
                                            <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-4"></use>
                                        </g>
                                        </g>
                                        <g
                                        id="Triangle"
                                        transform="translate(19.000000, 11.000000) rotate(-300.000000) translate(-19.000000, -11.000000) "
                                        >
                                        <use fill="#696cff" xlink:href="#path-5"></use>
                                        <use fill-opacity="0.2" fill="#FFFFFF" xlink:href="#path-5"></use>
                                        </g>
                                        </g>
                                      </g>
                                     </g>
                                    </svg>
                                </span>
                            <span class="app-brand-text demo menu-text fw-bolder ms-2">Sneat</span>
                        </a>
                        </div>
                        <h4 class="mb-2">Adventure starts here 🚀</h4>
                        <p class="mb-4">Make your app management easy and fun!</p>

                        <form id="formAuthentication" class="mb-3" action="" method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username" autofocus required />
                            </div>
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Enter your name" required />
                            </div>
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK Pos</label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Enter your nik" required />
                            </div>
                            <div class="mb-3">
                                <label for="jenis" class="form-label">Jenis Kantor</label>
                                <select class="form-control" id="jenis" name="jenis" required>
                                    <option value="">Jenis Kantor</option>
                                    <option value="KC">KC</option>
                                    <option value="KCU">KCU</option>
                                    <option value="SPP">SPP</option>
                                </select>
                            </div>
                            <div class="mb-3">
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
                            <div class="mb-3">
                                <label for="kantor_asal" class="form-label">Kantor Asal</label>
                                <select class="form-control" id="kantor_asal" name="kantor_asal" required>
                                    <option value="">Pilih Kantor Asal</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="kode_pos" class="form-label">Kode Pos</label>
                                <select class="form-control" id="kode_pos" name="kode_pos" required>
                                    <option value="">Pilih Kode Pos</option>
                                </select>
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms" required />
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>
                            <button id="saveButton" class="register btn btn-primary d-grid w-100">Save Data</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="auth-login-basic.php"><span>Sign in instead</span></a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="buy-now">
        <a href="https://1.envato.market/4dR0y" target="_blank" class="btn btn-danger btn-buy-now">Buy Now</a>
    </div>
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/libs/popper/popper.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/vendor/js/menu.js"></script>
    <script src="../assets/js/main.js"></script>
</body>
</html>
