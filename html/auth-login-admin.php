<?php
session_start(); // Start the session for login

include 'config.php'; // Include database configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nik = $_POST['nik'];
    $password = $_POST['password'];

    // Query to check if NIK exists in the admin table
    $sql = "SELECT * FROM admin WHERE nik = ?";
    $stmt = $koneksi->prepare($sql);
    
    if (!$stmt) {
        die("Query failed: " . $koneksi->error);
    }

    $stmt->bind_param("s", $nik); // Use prepared statement to prevent SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if NIK is found
    if ($result->num_rows > 0) {
        // Fetch admin data
        $row = $result->fetch_assoc();

        // Verify password (adjust if password is hashed)
        if ($password === $row['password']) {
            // Correct password, create session for admin
            $_SESSION['admin_username'] = $row['username']; // Set session for admin
            echo "<script>
                    alert('Login successful. Welcome, " . $row['username'] . "!');
                    window.location.href = 'index.php'; // Redirect to admin dashboard
                  </script>";
            exit;
        } else {
            echo "<script>
                    alert('Wrong password');
                    window.location.href = 'auth-login-admin.php'; // Redirect back to login if password is wrong
                  </script>";
            exit;
        }
    } else {
        echo "<script>
                alert('NIK not found');
                window.location.href = 'auth-login-admin.php'; // Redirect back to login if NIK not found
              </script>";
        exit;
    }

    $stmt->close(); // Close statement
}

$koneksi->close(); // Close database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <title>Admin Login - Iregularitas</title>

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon/pos-favicon.png" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600&display=swap" rel="stylesheet" />

    <!-- Core CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/core.css" />
    <link rel="stylesheet" href="../assets/vendor/css/theme-default.css" />

    <!-- Page CSS -->
    <link rel="stylesheet" href="../assets/vendor/css/pages/page-auth.css" />
</head>
<body>
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner">
                <div class="card">
                    <div class="card-body">
                        <div class="app-brand justify-content-center">
                          <a href="auth-login-admin.php" class="app-brand-link">
                            <span class="app-brand-logo demo">
                            <img src="../assets/img/favicon/pos-logo.png" alt="Logo" width="40" height="45">
                            </span>
                            <span class="app-brand-text demo menu-text fw-bolder ms-2 irregularitas-text">Iregularitas</span>
                          </a>
                        </div>
                        <h4 class="mb-2">Welcome back Admin! 👋</h4>
                        <p class="mb-4">Please sign in to your account</p>

                        <form id="formAuthentication" class="mb-3" action="auth-login-admin.php" method="POST">
                            <div class="mb-3">
                                <label for="nik" class="form-label">NIPPos</label>
                                <input type="text" class="form-control" id="nik" name="nik" placeholder="Enter your NIPPOS" required />
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password" class="form-control" name="password" placeholder="********" required />
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <div class="mb-3">
                                <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                            </div>
                        </form>

                        <!-- <p class="text-center">
                            <a href="auth-forgot-password-admin.php">
                                <small>Forgot Password?</small>
                            </a>
                        </p> -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Core JS -->
    <script src="../assets/vendor/libs/jquery/jquery.js"></script>
    <script src="../assets/vendor/js/bootstrap.js"></script>
</body>
</html>
