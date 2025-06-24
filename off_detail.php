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
  <title>Barangay Officials Information &mdash; Barangay Information System</title>

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
      <div class="navbar-bg bg-info"></div>
      <?php include 'Include/header.php'; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include 'Include/side_bar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Barangay Officials Information</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Barangay Officials Information</div>
            </div>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-lg-6">
                        <h2>Barangay Officials Information</h2>
                    </div>
                  </div>
                  <div class="card-body">
                    <?php
include 'conn.php'; // Database connection

// Initialize variables
$first_name = $middle_name = $last_name = $suffix_name = "";
$contact = $email = $official_id = $status = "";
$barangay_name = $position_name = $start_term = $end_term = "";
$profile = "officials/default.png"; // Default profile image

if (isset($_GET['b_officials_id'])) {
    $b_officials_id = intval($_GET['b_officials_id']); // Sanitize input

    // Fetch official details, barangay name, and position
    $query = "
        SELECT o.first_name, o.middle_name, o.last_name, o.suffix_name, o.contact, 
               o.email, o.official_id, o.status, o.profile, 
               b.barangay_name, p.position_name, o.start_term, o.end_term
        FROM b_officials o
        LEFT JOIN b_list b ON o.b_list_id = b.b_list_id
        LEFT JOIN b_positions p ON o.b_positions_id = p.b_positions_id
        WHERE o.b_officials_id = $b_officials_id";

    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $first_name = htmlspecialchars($row['first_name']);
        $middle_name = htmlspecialchars($row['middle_name']);
        $last_name = htmlspecialchars($row['last_name']);
        $suffix_name = htmlspecialchars($row['suffix_name']);
        $contact = htmlspecialchars($row['contact']);
        $email = htmlspecialchars($row['email']);
        $official_id = htmlspecialchars($row['official_id']);
        $status = htmlspecialchars($row['status']);
        $barangay_name = htmlspecialchars($row['barangay_name']);
        $position_name = htmlspecialchars($row['position_name']);
        $start_term = htmlspecialchars($row['start_term']);
        $end_term = htmlspecialchars($row['end_term']);
        $profile = !empty($row['profile']) ? "Admin_Ipil/officials/" . htmlspecialchars($row['profile']) : "officials/default.png";
    }
}
?>

<form method="post" action="">
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-12">
                <center>
                    <label><h4>Profile</h4></label><br>
                    <img src="<?php echo $profile; ?>" alt="Profile Image" class="rounded-circle" width="200" height="200">
                </center>
            </div>

            <div class="col-lg-12"><br></div>
            <div class="col-lg-3">
                <label><h4>Barangay Position</h4></label>
                <input type="text" name="position_name" class="form-control" value="<?php echo $position_name; ?>" readonly>
            </div>
            <div class="col-lg-3">
                <label><h4>Start Term</h4></label>
                <input type="text" name="start_term" class="form-control" value="<?php echo $start_term; ?>" readonly>
            </div>
            <div class="col-lg-3">
                <label><h4>End Term</h4></label>
                <input type="text" name="end_term" class="form-control" value="<?php echo $end_term; ?>" readonly>
            </div>
            <div class="col-lg-3">
                <label><h4>Official ID</h4></label>
                <input type="text" name="official_id" class="form-control" value="<?php echo $official_id; ?>" readonly>
            </div>
            <div class="col-lg-12"><br></div>

            <div class="col-lg-3">
                <label><h4>First Name</h4></label>
                <input type="text" name="first_name" class="form-control" value="<?php echo $first_name; ?>" readonly>
            </div>
            <div class="col-lg-3">
                <label><h4>Middle Name</h4></label>
                <input type="text" name="middle_name" class="form-control" value="<?php echo $middle_name; ?>" readonly>
            </div>
            <div class="col-lg-3">
                <label><h4>Last Name</h4></label>
                <input type="text" name="last_name" class="form-control" value="<?php echo $last_name; ?>" readonly>
            </div>
            <div class="col-lg-3">
                <label><h4>Suffix Name</h4></label>
                <select class="form-control" name="suffix_name" disabled>
                    <option selected disabled>Choose a Suffix Name</option>
                    <option value="Sr." <?php echo ($suffix_name === "Sr.") ? "selected" : ""; ?>>Sr.</option>
                    <option value="Jr." <?php echo ($suffix_name === "Jr.") ? "selected" : ""; ?>>Jr.</option>
                    <option value="II" <?php echo ($suffix_name === "II") ? "selected" : ""; ?>>II</option>
                    <option value="III" <?php echo ($suffix_name === "III") ? "selected" : ""; ?>>III</option>
                    <option value="IV" <?php echo ($suffix_name === "IV") ? "selected" : ""; ?>>IV</option>
                    <option value="V" <?php echo ($suffix_name === "V") ? "selected" : ""; ?>>V</option>
                    <option value="None" <?php echo ($suffix_name === "None") ? "selected" : ""; ?>>None</option>
                </select>
            </div>

            <div class="col-lg-12"><br></div>

            <div class="col-lg-4">
                <label><h4>Contact Number</h4></label>
                <input type="text" name="contact" class="form-control" value="<?php echo $contact; ?>" readonly>
            </div>
            <div class="col-lg-4">
                <label><h4>Status</h4></label>
                <select name="status" class="form-control" disabled>
                    <option value="Active Officials" <?php echo ($status === 'Active Officials') ? 'selected' : ''; ?>>Active Officials</option>
                    <option value="Inactive Officials" <?php echo ($status === 'Inactive Officials') ? 'selected' : ''; ?>>Inactive Officials</option>
                </select>
            </div>

            <div class="col-lg-12"><br></div>

            <div class="col-lg-12">
                <a href="officials.php" class="btn btn-outline-secondary">Back</a>
            </div>
        </div>
    </div>
</form>
<?php
include 'conn.php'; // Database connection

// Initialize variables
$first_name = $middle_name = $last_name = $suffix_name = "";
$contact = $email = $residence_id = $status = $date_birth = $age = $gender = $civil_status = $ps_list_id = "";
$profile = "officials/default.png"; // Default profile image
$ps_name = "";

if (isset($_GET['r_id'])) {
    $r_id = intval($_GET['r_id']); // Sanitize input

    // Fetch resident details
    $query = "SELECT r.*, p.ps_name FROM residence r LEFT JOIN ps_list p ON r.ps_list_id = p.ps_list_id WHERE r.r_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $query)) {
        mysqli_stmt_bind_param($stmt, "i", $r_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($row = mysqli_fetch_assoc($result)) {
            $first_name = htmlspecialchars($row['first_name']);
            $middle_name = htmlspecialchars($row['middle_name']);
            $last_name = htmlspecialchars($row['last_name']);
            $suffix_name = htmlspecialchars($row['suffix_name']);
            $contact = htmlspecialchars($row['contact']);
            $email = htmlspecialchars($row['email']);
            $date_birth = htmlspecialchars($row['date_birth']);
            $age = htmlspecialchars($row['age']);
            $gender = htmlspecialchars($row['gender']);
            $civil_status = htmlspecialchars($row['civil_status']);
            $residence_id = htmlspecialchars($row['residence_id']);
            $status = htmlspecialchars($row['status']);
            $ps_list_id = htmlspecialchars($row['ps_list_id']);
            $ps_name = htmlspecialchars($row['ps_name']);
            
            // Profile image check
            $profile_path = "uploads/" . htmlspecialchars($row['profile']);
            $profile = (!empty($row['profile']) && file_exists($profile_path)) ? $profile_path : "uploads/default.png";
        }
        mysqli_stmt_close($stmt);
    }
}

// Handle form submission for updating residence details
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $suffix_name = mysqli_real_escape_string($conn, $_POST['suffix_name']);
    $date_birth = mysqli_real_escape_string($conn, $_POST['date_birth']);
    $age = mysqli_real_escape_string($conn, $_POST['age']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    $ps_list_id = mysqli_real_escape_string($conn, $_POST['ps_list_id']);
    
    $update_query = "UPDATE residence SET first_name = ?, middle_name = ?, last_name = ?, suffix_name = ?, date_birth = ?, age = ?, gender = ?, civil_status = ?, ps_list_id = ?, status = ? WHERE r_id = ?";
    
    if ($stmt = mysqli_prepare($conn, $update_query)) {
        mysqli_stmt_bind_param($stmt, "sssssisissi", $first_name, $middle_name, $last_name, $suffix_name, $date_birth, $age, $gender, $civil_status, $ps_list_id, $status, $r_id);
        $update_success = mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>";
        if ($update_success) {
            echo "Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Residence details updated successfully!',
                confirmButtonColor: '#28a745'
            }).then(() => { window.location.href='b_o.php'; });";
        } else {
            echo "Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Error updating residence details.',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });";
        }
        echo "</script>";
    }
}
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
} else {
    header("Location: index.php");
    exit();
}
?>