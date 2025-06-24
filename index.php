<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Sign In &mdash; Barangay Information System</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/bootstrap-social/bootstrap-social.css">

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
<!-- Start GA -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-94034622-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-94034622-3');
</script>
<!-- /END GA --></head>

<body style="background-image: url('assets/img/bg_ipil.jpg'); background-size: cover; background-position: center;">
  <div id="app" >
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="login-brand">
              <img src="assets/img/Ipil_sibugay_seal.png" alt="logo" width="100" class="shadow-light rounded-circle">
            </div>

            <div class="card card-primary">
              <div class="card-header">
                <center>
                
                <br><h4>Welcome to Barangay Information System</h4>
              </center>
              </div>

              <div class="card-body">
                <form method="POST" action="index.php" class="#" novalidate="">
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="text" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label">Password</label>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>

                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      Sign In
                    </button>
                  </div>
                </form>
                <?php
session_start(); // Start session
include 'conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; // Include SweetAlert

    // Retrieve and sanitize user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Missing Fields',
                text: 'Please enter both email and password!',
                confirmButtonColor: '#ffc107'
            }).then(() => window.history.back());
        </script>";
        exit();
    }

    // Query to fetch user details
    $query = "SELECT u_id, email, password, user_type, b_list_id, b_officials_id, r_id FROM user_type WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['u_id'] = $row['u_id'];
            $_SESSION['b_list_id'] = $row['b_list_id'];
            $_SESSION['b_officials_id'] = $row['b_officials_id'];
            $_SESSION['r_id'] = $row['r_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];

            // Fetch b_officials_id and full_name if user is an official
            if ($row['user_type'] == "Official Account") {
                $official_query = "SELECT b_officials_id, first_name, middle_name, last_name, suffix_name FROM b_officials WHERE b_officials_id = ?";
                $official_stmt = mysqli_prepare($conn, $official_query);
                mysqli_stmt_bind_param($official_stmt, "i", $row['b_officials_id']);
                mysqli_stmt_execute($official_stmt);
                $official_result = mysqli_stmt_get_result($official_stmt);
                
                if ($official_row = mysqli_fetch_assoc($official_result)) {
                    $_SESSION['b_officials_id'] = $official_row['b_officials_id'];
                    
                    $full_name = $official_row['first_name'];
                    if (!empty($official_row['middle_name'])) {
                        $full_name .= " " . $official_row['middle_name'];
                    }
                    $full_name .= " " . $official_row['last_name'];
                    
                    if ($official_row['suffix_name'] != "None" && !empty($official_row['suffix_name'])) {
                        $full_name .= " " . $official_row['suffix_name'];
                    }
                    $_SESSION['official_name'] = $full_name;
                }
            }

            if ($row['user_type'] == "Barangay Account") {
                $b_list_id = $row['b_list_id'];
                $barangay_query = "SELECT barangay_name FROM b_list WHERE b_list_id = ?";
                $barangay_stmt = mysqli_prepare($conn, $barangay_query);
                mysqli_stmt_bind_param($barangay_stmt, "i", $b_list_id);
                mysqli_stmt_execute($barangay_stmt);
                $barangay_result = mysqli_stmt_get_result($barangay_stmt);

                $barangay_name = ($barangay_row = mysqli_fetch_assoc($barangay_result)) ? $barangay_row['barangay_name'] : "Unknown Barangay";
                $_SESSION['barangay_name'] = $barangay_name;

                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sign in Successful!',
                        text: 'Welcome, Barangay of {$barangay_name}!',
                        confirmButtonColor: '#28a745'
                    }).then(() => window.location.href='Barangay/dashboard.php');
                </script>";
                exit();
            } elseif ($row['user_type'] == "Residence Account") {
                $r_id = $row['r_id'];
                $resident_query = "SELECT first_name, middle_name, last_name, suffix_name FROM residence WHERE r_id = ?";
                $resident_stmt = mysqli_prepare($conn, $resident_query);
                mysqli_stmt_bind_param($resident_stmt, "i", $r_id);
                mysqli_stmt_execute($resident_stmt);
                $resident_result = mysqli_stmt_get_result($resident_stmt);
                
                if ($resident_row = mysqli_fetch_assoc($resident_result)) {
                    $full_name = $resident_row['first_name'];
                    if (!empty($resident_row['middle_name'])) {
                        $full_name .= " " . $resident_row['middle_name'];
                    }
                    $full_name .= " " . $resident_row['last_name'];
                    
                    if ($resident_row['suffix_name'] != "None" && !empty($resident_row['suffix_name'])) {
                        $full_name .= " " . $resident_row['suffix_name'];
                    }
                } else {
                    $full_name = "Resident";
                }

                $_SESSION['resident_name'] = $full_name;
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sign In Successful!',
                        text: 'Welcome, {$full_name}!',
                        confirmButtonColor: '#28a745'
                    }).then(() => window.location.href='dashboard.php');
                </script>";
                exit();
            } elseif ($row['user_type'] == "Official Account") {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Sign in Successful!',
                        text: 'Welcome, Barangay Officials {$_SESSION['official_name']}!',
                        confirmButtonColor: '#28a745'
                    }).then(() => window.location.href='Official/dashboard.php');
                </script>";
                exit();
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Access Denied!',
                        text: 'Invalid user type detected!',
                        confirmButtonColor: '#dc3545'
                    }).then(() => window.history.back());
                </script>";
                exit();
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Incorrect Password!',
                    text: 'Please try again.',
                    confirmButtonColor: '#dc3545'
                }).then(() => window.history.back());
            </script>";
            exit();
        }
    }
}?>


                <div class="text-center mt-4 mb-3">
                    <div class="text-job text-muted">
                    Copyright &copy; 2025, All Reserved <br> Barangay Information System. <br> Develop by : Baymax
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>

  <!-- General JS Scripts -->
  <script src="assets/modules/jquery.min.js"></script>
  <script src="assets/modules/popper.js"></script>
  <script src="assets/modules/tooltip.js"></script>
  <script src="assets/modules/bootstrap/js/bootstrap.min.js"></script>
  <script src="assets/modules/nicescroll/jquery.nicescroll.min.js"></script>
  <script src="assets/modules/moment.min.js"></script>
  <script src="assets/js/stisla.js"></script>
  
  <!-- JS Libraies -->

  <!-- Page Specific JS File -->
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>