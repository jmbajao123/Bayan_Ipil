<?php
session_start();
include 'conn.php';

if (isset($_SESSION['email'], $_SESSION['u_id'], $_SESSION['r_id'], $_SESSION['b_list_id'], $_SESSION['user_type']) 
    && $_SESSION['user_type'] === "Barangay Account") {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Dashboard &mdash; Barangay Information System</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">

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
      <div class="navbar-bg"></div>
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
include 'conn.php'; // Include database connection

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if session variable b_list_id exists
if (!isset($_SESSION['b_list_id'])) {
    echo '<div class="alert alert-danger">Session expired. Please log in again.</div>';
    exit();
}

// Retrieve session variable
$b_list_id = $_SESSION['b_list_id'];

// Fetch count of pending requests
$query = "SELECT COUNT(*) AS pending_count FROM req_cert WHERE b_list_id = '$b_list_id' AND status = 'Pending'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pending_count = $row['pending_count'] ?? 0;
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-warning">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Pending Requests</h4>
            </div>
            <div class="card-body">
                <?php echo htmlspecialchars($pending_count); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Close database connection
mysqli_close($conn);
?>

			<?php
include 'conn.php'; // Include database connection

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if session variable b_list_id exists
if (!isset($_SESSION['b_list_id'])) {
    echo '<div class="alert alert-danger">Session expired. Please log in again.</div>';
    exit();
}

// Retrieve session variable
$b_list_id = $_SESSION['b_list_id'];

// Fetch count of pending requests
$query = "SELECT COUNT(*) AS pending_count FROM req_cert WHERE b_list_id = '$b_list_id' AND status = 'Approved'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pending_count = $row['pending_count'] ?? 0;
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Approved Requests</h4>
            </div>
            <div class="card-body">
                <?php echo htmlspecialchars($pending_count); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Close database connection
mysqli_close($conn);
?>

<?php
include 'conn.php'; // Include database connection

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if session variable b_list_id exists
if (!isset($_SESSION['b_list_id'])) {
    echo '<div class="alert alert-danger">Session expired. Please log in again.</div>';
    exit();
}

// Retrieve session variable
$b_list_id = $_SESSION['b_list_id'];

// Fetch count of pending requests
$query = "SELECT COUNT(*) AS pending_count FROM req_cert WHERE b_list_id = '$b_list_id' AND status = 'Denied'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$pending_count = $row['pending_count'] ?? 0;
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-danger">
            <i class="fas fa-envelope"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Denied Requests</h4>
            </div>
            <div class="card-body">
                <?php echo htmlspecialchars($pending_count); ?>
            </div>
        </div>
    </div>
</div>

<?php
// Close database connection
mysqli_close($conn);
?>

            <?php
// Include your database connection file
include 'conn.php';

// Assuming you have the session for the currently signed-in user
$b_list_id = $_SESSION['b_list_id']; // Get the barangay list ID

// Query to count barangay officials based on b_list_id and u_id
$query = "SELECT COUNT(*) AS total_officials FROM b_officials WHERE b_list_id = '$b_list_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_officials = $row['total_officials'];
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Barangay Officials </h4>
            </div>
            <div class="card-body">
                <?php echo $total_officials; ?>
            </div>
        </div>
    </div>
</div>

            <?php
// Include your database connection file
include 'conn.php';

// Start the session to access the signed-in user's data
$b_list_id = $_SESSION['b_list_id']; // Get the currently signed-in user's barangay list ID

// Query to count active Purok/Street (ps_list) entries based on b_list_id
$query = "SELECT COUNT(*) AS total_active_ps FROM ps_list WHERE b_list_id = '$b_list_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_active_ps = $row['total_active_ps'];
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-road"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Purok/Street List</h4>
            </div>
            <div class="card-body">
                <?php echo $total_active_ps; ?>
            </div>
        </div>
    </div>
</div>


            <?php
// Include your database connection file
include 'conn.php';

// Start session to access the signed-in user's data
$b_list_id = $_SESSION['b_list_id']; // Get the currently signed-in user's barangay list ID

// Query to count residence entries based on b_list_id
$query = "SELECT COUNT(*) AS total_residents FROM residence WHERE b_list_id = '$b_list_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_residents = $row['total_residents'];
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-users"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Residence List</h4>
            </div>
            <div class="card-body">
                <?php echo $total_residents; ?>
            </div>
        </div>
    </div>
</div>

            <?php
// Include your database connection file
include 'conn.php';

// Start session to access the signed-in user's data
$b_list_id = $_SESSION['b_list_id']; // Get the currently signed-in user's barangay list ID

// Query to count household entries based on b_list_id
$query = "SELECT COUNT(*) AS total_households FROM household WHERE b_list_id = '$b_list_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_households = $row['total_households'];
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-home"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Household List</h4>
            </div>
            <div class="card-body">
                <?php echo $total_households; ?>
            </div>
        </div>
    </div>
</div>
<?php
// Include your database connection file
include 'conn.php';

// Start session to access the signed-in user's data
$b_list_id = $_SESSION['b_list_id']; // Get the currently signed-in user's barangay list ID

// Query to count household entries based on b_list_id
$query = "SELECT COUNT(*) AS total_households FROM certificate WHERE b_list_id = '$b_list_id'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$total_households = $row['total_households'];
?>

<div class="col-lg-3 col-md-6 col-sm-6 col-12">
    <div class="card card-statistic-1">
        <div class="card-icon bg-success">
            <i class="fas fa-list"></i>
        </div>
        <div class="card-wrap">
            <div class="card-header">
                <h4>Certificate List</h4>
            </div>
            <div class="card-body">
                <?php echo $total_households; ?>
            </div>
        </div>
    </div>
</div>
                  
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
    header("Location: ../index.php");
    exit();
}
?>
