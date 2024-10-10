<?php
session_start(); // Start the session for login

include 'config.php'; // Include database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $password = $_POST['password'];

    // Query to check if NIK exists in the database
    $sql = "SELECT * FROM user WHERE nik = ?";
    $stmt = $koneksi->prepare($sql);
    $stmt->bind_param("s", $nik); // Use prepared statement to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch user data
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password'])) {
            // If password is correct, start session
            $_SESSION['username'] = $row['username']; // Set session with username
            echo "<script>
                    alert('Login berhasil. Selamat datang, " . $row['username'] . "!');
                    window.location.href = 'index.php';
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Password salah');
                    window.location.href = 'auth-login-basic.php';
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('NIK Pos tidak ditemukan');
                window.location.href = 'auth-login-basic.php';
              </script>";
        exit;
    }

    $stmt->close(); // Close statement
}

$koneksi->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en" class="light-style customizer-hide" dir="ltr" data-theme="theme-default" data-assets-path="../assets/" data-template="vertical-menu-template-free">
<head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"
    />

    <title>Login - Pages | Iregularitas</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons. Uncomment required icon fonts -->
    <link rel="stylesheet" href="../assets/vendor/fonts/boxicons.css" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" class="template-customizer-core-css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" class="template-customizer-theme-css" />
    <link rel="stylesheet" href="../assets/css/demo.css" />

    <!-- Vendors CSS -->
    <link rel="stylesheet" href="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />

    <!-- Page CSS -->
    <!-- Page -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
    <!-- Helpers -->
    <script src="../assets/vendor/js/helpers.js"></script>

    <!--! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the <head> section -->
    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="../assets/js/config.js"></script>
  </head>
  <body>
    <div class="container-xxl">
      <div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
          <div class="card">
            <div class="card-body">
              <div class="app-brand justify-content-center">
              <a href="auth-login-basic.php" class="app-brand-link">
                <span class="app-brand-logo demo">
                  <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45">
                </span>
                <span class="app-brand-text demo menu-text fw-bolder ms-2 irregularitas-text">Iregularitas</span>
              </a>
              </div>
              <h4 class="mb-2">Welcome back! 👋</h4>
              <p class="mb-4">Please sign-in to your account</p>

              <!-- Error message if login failed -->
              <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
              <?php endif; ?>

              <form id="formAuthentication" class="mb-3" action="auth-login-basic.php" method="POST">
                <div class="mb-3">
                  <label for="nik" class="form-label">NIK Pos</label>
                  <input type="text" class="form-control" id="nik" name="nik" placeholder="Enter your NIK" required />
                </div>
                <div class="mb-3 form-password-toggle">
                  <div class="d-flex justify-content-between">
                    <label class="form-label" for="password">Password</label>
                    <a href="auth-forgot-password-basic.php">
                      <small>Forgot Password?</small>
                    </a>
                  </div>
                  <div class="input-group input-group-merge">
                    <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" required />
                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                  </div>
                </div>
                <div class="mb-3">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>
              </form>

              <p class="text-center">
                <span>New on our platform?</span>
                <a href="auth-register-basic.php">
                  <span>Create an account</span>
                </a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
    <script src="../assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="../assets/js/main.js"></script>
  </body>
</html>
