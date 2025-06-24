<?php
session_start(); 
include 'conn.php';
if (isset($_SESSION['username']) && isset($_SESSION['a_id']) && ($_SESSION['password']) ) {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Barangay Positions &mdash; Barangay Information System</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
  <!-- CSS Libraries -->
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"> -->
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
      <div class="navbar-bg bg-success"></div>
      <?php include 'Include/header.php'; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include 'Include/side_bar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Barangay Positions</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Barangay Positions</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                  	<div class="col-lg-6">
                  		<h2>Barangay Position</h2>
                  	</div>
                  </div>
                  <div class="card-body">
                  	<?php
include 'conn.php'; // Database connection

// Check if b_positions_id is provided
$position_name = "";
$status = "";

if (isset($_GET['b_positions_id'])) {
    $b_positions_id = intval($_GET['b_positions_id']); // Sanitize input

    // Fetch position details based on ID
    $query = "SELECT position_name, status FROM b_positions WHERE b_positions_id = $b_positions_id";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $position_name = htmlspecialchars($row['position_name']); // Prevent XSS
        $status = htmlspecialchars($row['status']); // Store status
    }
}
?>

<form method="post" action="">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-6">
                <label>
                    <h4>Position Name</h4>
                </label>
                <input type="text" name="position_name" class="form-control" value="<?php echo $position_name; ?>" required>
            </div>

            <div class="col-lg-6">
                <label>
                    <h4>Status</h4>
                </label>
                <select name="status" class="form-control" id="status" required>
                    <option value="Available" <?php echo ($status === 'Available') ? 'selected' : ''; ?>>Available</option>
                    <option value="Unavailable" <?php echo ($status === 'Unavailable') ? 'selected' : ''; ?>>Unavailable</option>
                </select>
            </div>
            <div class="col-lg-12">
                <br>
            </div>
            <div class="col-lg-12">
                <a href="b_p.php" class="btn btn-outline-secondary">Back</a>
                <button type="submit" class="btn btn-outline-success" style="float: right;">Update</button>
            </div>
        </div>
    </div>
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_GET['b_positions_id']) && isset($_POST['position_name']) && isset($_POST['status'])) {
        $b_positions_id = intval($_GET['b_positions_id']); // Sanitize input
        $position_name = mysqli_real_escape_string($conn, $_POST['position_name']);
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // Update query
        $query = "UPDATE b_positions SET position_name = '$position_name', status = '$status' WHERE b_positions_id = $b_positions_id";
        $result = mysqli_query($conn, $query);

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>";
        if ($result) {
            echo "Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Position updated successfully!',
                confirmButtonColor: '#28a745'
            }).then(() => { window.location.href='b_p.php'; });";
        } else {
            echo "Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error updating position.',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });";
        }
        echo "</script>";
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Invalid Request',
                text: 'Invalid request.',
                confirmButtonColor: '#ffc107'
            }).then(() => { window.history.back(); });
        </script>";
    }
}

// Close connection
mysqli_close($conn);
?>



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
  <script src="assets/modules/jquery-ui/jquery-ui.min.js"></script>

  <!-- Page Specific JS File -->
  <script src="assets/js/page/components-table.js"></script>
  
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script src="assets/js/custom.js"></script>
</body>
</html>
<?php 
}else{
    header("Location: index.php");
    exit();
}

?>