<?php
session_start();
include 'conn.php';

if (isset($_SESSION['email'], $_SESSION['u_id'], $_SESSION['r_id'], $_SESSION['b_list_id'], $_SESSION['user_type']) 
    && $_SESSION['user_type'] === "Residence Account") {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; Barangay Information System</title>

  <!-- General CSS Files -->
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="assets/modules/jqvmap/dist/jqvmap.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons.min.css">
  <link rel="stylesheet" href="assets/modules/weather-icon/css/weather-icons-wind.min.css">
  <link rel="stylesheet" href="assets/modules/summernote/summernote-bs4.css">

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

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg bg-info"></div>
      <?php include 'Include/header.php'; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include 'Include/side_bar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Dashboard</h1>
          </div>
          <div class="row">
              <?php
                include 'conn.php'; // Database connection

                // Get the currently signed-in user's details
                $u_id = isset($_SESSION['u_id']) ? (int)$_SESSION['u_id'] : 0;
                $r_id = isset($_SESSION['r_id']) ? (int)$_SESSION['r_id'] : 0;
                $b_list_id = isset($_SESSION['b_list_id']) ? (int)$_SESSION['b_list_id'] : 0;

                // Query to count pending requests based on the logged-in user
                $query = "SELECT COUNT(*) AS total FROM req_cert WHERE status = 'Pending' AND u_id = ? AND r_id = ? AND b_list_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "iii", $u_id, $r_id, $b_list_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $totalPending = $row['total'];

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
              ?>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-warning">
                          <i class="far fa-file-alt"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4 style="color: black;">Pending Requests</h4>
                          </div>
                          <div class="card-body">
                              <?php echo $totalPending; ?>
                          </div>
                      </div>
                  </div>
              </div>

              <?php
                include 'conn.php'; // Database connection

                // Get the currently signed-in user's details
                $u_id = isset($_SESSION['u_id']) ? (int)$_SESSION['u_id'] : 0;
                $r_id = isset($_SESSION['r_id']) ? (int)$_SESSION['r_id'] : 0;
                $b_list_id = isset($_SESSION['b_list_id']) ? (int)$_SESSION['b_list_id'] : 0;

                // Query to count pending requests based on the logged-in user
                $query = "SELECT COUNT(*) AS total FROM req_cert WHERE status = 'Approved' AND u_id = ? AND r_id = ? AND b_list_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "iii", $u_id, $r_id, $b_list_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $totalPending = $row['total'];

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
              ?>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-success">
                          <i class="far fa-file-alt"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4 style="color: black;">Approved Requests</h4>
                          </div>
                          <div class="card-body">
                              <?php echo $totalPending; ?>
                          </div>
                      </div>
                  </div>
              </div>

              <?php
                include 'conn.php'; // Database connection

                // Get the currently signed-in user's details
                $u_id = isset($_SESSION['u_id']) ? (int)$_SESSION['u_id'] : 0;
                $r_id = isset($_SESSION['r_id']) ? (int)$_SESSION['r_id'] : 0;
                $b_list_id = isset($_SESSION['b_list_id']) ? (int)$_SESSION['b_list_id'] : 0;

                // Query to count pending requests based on the logged-in user
                $query = "SELECT COUNT(*) AS total FROM req_cert WHERE status = 'Denied' AND u_id = ? AND r_id = ? AND b_list_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "iii", $u_id, $r_id, $b_list_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $totalPending = $row['total'];

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
              ?>
              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-danger">
                          <i class="far fa-file-alt"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4 style="color: black;">Denied Requests</h4>
                          </div>
                          <div class="card-body">
                              <?php echo $totalPending; ?>
                          </div>
                      </div>
                  </div>
              </div>
              <?php
                include 'conn.php'; // Database connection

                // Get the currently signed-in user's b_list_id
                $b_list_id = isset($_SESSION['b_list_id']) ? (int)$_SESSION['b_list_id'] : 0;

                // Query to count officials based on b_list_id
                $query = "SELECT COUNT(*) AS total FROM b_officials WHERE b_list_id = ?";
                $stmt = mysqli_prepare($conn, $query);
                mysqli_stmt_bind_param($stmt, "i", $b_list_id);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $row = mysqli_fetch_assoc($result);
                $totalOfficials = $row['total'];

                mysqli_stmt_close($stmt);
                mysqli_close($conn);
              ?>

              <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                  <div class="card card-statistic-1">
                      <div class="card-icon bg-secondary">
                          <i class="fas fa-users"></i>
                      </div>
                      <div class="card-wrap">
                          <div class="card-header">
                              <h4>Barangay Officials</h4>
                          </div>
                          <div class="card-body">
                              <?php echo $totalOfficials; ?>
                          </div>
                      </div>
                  </div>
              </div>

            <!-- <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                  <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Reports</h4>
                  </div>
                  <div class="card-body">
                    1,201
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6 col-12">
              <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                  <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                  <div class="card-header">
                    <h4>Online Users</h4>
                  </div>
                  <div class="card-body">
                    47
                  </div>
                </div>
              </div>
            </div> -->                  
          </div>
        </section>
      </div>
      <?php include 'Include/footer.php'; ?>
    </div>
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
  <script src="assets/modules/simple-weather/jquery.simpleWeather.min.js"></script>
  <script src="assets/modules/chart.min.js"></script>
  <script src="assets/modules/jqvmap/dist/jquery.vmap.min.js"></script>
  <script src="assets/modules/jqvmap/dist/maps/jquery.vmap.world.js"></script>
  <script src="assets/modules/summernote/summernote-bs4.js"></script>
  <script src="assets/modules/chocolat/dist/js/jquery.chocolat.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/index-0.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
<?php 
} else {
    header("Location: index.php");
    exit();
}
?>