<?php 
session_start();
include 'config.php';

if (!isset($_SESSION['id'])) {
    header("Location: ../html/auth-login-basic.php");
    exit();
}

$user_id = $_SESSION['id'];

$query = "SELECT * FROM user WHERE id = ?";
$stmt = $koneksi->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $nama = $_POST['nama'];
    $nik = $_POST['nik'];
    $jenis = $_POST['jenis'];
    $regional = $_POST['regional'];
    $kantor_asal = $_POST['kantor_asal'];
    $password = $_POST['password'];

    if (!empty($password)) {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $update_query = "UPDATE user SET username = ?, nama = ?, nik = ?, jenis = ?, regional = ?, kantor_asal = ?, password = ? WHERE id = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("sssssssi", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $hashed_password, $user_id);
    } else {
        $update_query = "UPDATE user SET username = ?, nama = ?, nik = ?, jenis = ?, regional = ?, kantor_asal = ? WHERE id = ?";
        $stmt = $koneksi->prepare($update_query);
        $stmt->bind_param("ssssssi", $username, $nama, $nik, $jenis, $regional, $kantor_asal, $user_id);
    }

    if ($stmt->execute()) {
        // After the data is updated, set a flag for success.
        $updateSuccess = true;
    } else {
        $updateSuccess = false;
        $errorMessage = $stmt->error;
    }

    $stmt->close();
}

$koneksi->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title>Edit My Profile | Iregularitas</title>
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
        // Store user's current kantor_asal data
        const existingKantorAsal = "<?php echo isset($user['kantor_asal']) ? htmlspecialchars($user['kantor_asal']) : ''; ?>";
        
        // Populate kantor_asal dropdown based on selected regional
        $('#regional').change(function() {
            const regionalId = $(this).val();
            const postOfficeSelect = $('#kantor_asal');
            postOfficeSelect.empty(); // Clear previous options

            // Populate options if the selected regional exists in postOffices
            if (postOffices[regionalId]) {
                postOffices[regionalId].forEach(office => {
                    const officeValue = `${office.kcu}|${office.nama}`;
                    const selected = existingKantorAsal === officeValue ? 'selected' : '';
                    postOfficeSelect.append(`<option value="${officeValue}" ${selected}>${office.nama}</option>`);
                });
            }
        });

        // Trigger the change event to load initial kantor_asal options
        $('#regional').trigger('change');
    });
    </script>
</head>
<body>
    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="py-3 breadcrumb-wrapper mb-4"><span class="text-muted fw-light">Edit Profile</span></h4>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="profile.php">
                        <input type="hidden" name="id" value="<?= htmlspecialchars($user['id']) ?>">

                        <div class="col-xxl">
                            <div class="card mb-4">
                                <div class="card-header d-flex align-items-center justify-content-between">
                                    <h5 class="mb-0">Edit Your Profile Information</h5>
                                </div>
                                <div class="card-body">

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="username">Username</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-user"></i></span>
                                                <input type="text" class="form-control" id="username" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="nama">Nama</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-user-circle"></i></span>
                                                <input type="text" class="form-control" id="nama" name="nama" value="<?= htmlspecialchars($user['nama']) ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="nik">NIPPOS</label>
                                        <div class="col-sm-10">
                                            <div class="input-group input-group-merge">
                                                <span class="input-group-text"><i class="bx bx-id-card"></i></span>
                                                <input type="text" class="form-control" id="nik" name="nik" value="<?= htmlspecialchars($user['nik']) ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="jenis">Jenis Kantor</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="jenis" name="jenis" required>
                                                <option value="KC" <?= $user['jenis'] == 'KC' ? 'selected' : '' ?>>KC</option>
                                                <option value="KCU" <?= $user['jenis'] == 'KCU' ? 'selected' : '' ?>>KCU</option>
                                                <option value="SPP" <?= $user['jenis'] == 'SPP' ? 'selected' : '' ?>>SPP</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="regional">Regional</label>
                                        <div class="col-sm-10">
                                            <select class="form-select" id="regional" name="regional" required>
                                                <option value="Regional 1 - Sumatra" <?= $user['regional'] == 'Regional 1 - Sumatra' ? 'selected' : '' ?>>Regional 1 - Sumatra</option>
                                                <option value="Regional 2 - Jakarta & Banten" <?= $user['regional'] == 'Regional 2 - Jakarta & Banten' ? 'selected' : '' ?>>Regional 2 - Jakarta & Banten</option>
                                                <option value="Regional 3 - Jawa Barat" <?= $user['regional'] == 'Regional 3 - Jawa Barat' ? 'selected' : '' ?>>Regional 3 - Jawa Barat</option>
                                                <option value="Regional 4 - Jawa Tengah & DIY" <?= $user['regional'] == 'Regional 4 - Jawa Tengah & DIY' ? 'selected' : '' ?>>Regional 4 - Jawa Tengah & DIY</option>
                                                <option value="Regional 5 - Jawa Timur, Bali & Nusa Tenggara" <?= $user['regional'] == 'Regional 5 - Jawa Timur, Bali & Nusa Tenggara' ? 'selected' : '' ?>>Regional 5 - Jawa Timur, Bali & Nusa Tenggara</option>
                                                <option value="Regional 6 - Kalimantan, Sulawesi & Papua" <?= $user['regional'] == 'Regional 6 - Kalimantan, Sulawesi & Papua' ? 'selected' : '' ?>>Regional 6 - Kalimantan, Sulawesi & Papua</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label" for="kantor_asal">Kantor Asal</label>
                                            <div class="col-sm-10">
                                                <select class="form-select" id="kantor_asal" name="kantor_asal" required>
                                                <option value="">Pilih Kantor Asal</option>
                                                <!-- Add options for Kantor Asal here -->
                                                </select>
                                            </div>
                                    </div>

                                    <div class="mb-3 row">
                                        <label class="col-sm-2 col-form-label" for="password">Password (Change if needed)</label>
                                        <div class="col-sm-10">
                                            <input type="password" class="form-control" id="password" name="password">
                                        </div>
                                    </div>

                                    <div class="row justify-content-end">
                                        <div class="col-sm-10">
                                            <button type="submit" class="btn btn-primary">Update Profile</button>
                                            <a href="../user/dashboard.php" class="btn btn-secondary">Cancel</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <?php if (isset($updateSuccess)): ?>
                        <script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Data berhasil diperbarui!',
                                showConfirmButton: true
                            }).then(function() {
                                window.location.href = 'profile.php'; // Redirect after success
                            });
                        </script>
                    <?php elseif (isset($updateSuccess) && !$updateSuccess): ?>
                        <script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal memperbarui data!',
                                text: 'Terjadi kesalahan: <?= $errorMessage ?>',
                            });
                        </script>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
