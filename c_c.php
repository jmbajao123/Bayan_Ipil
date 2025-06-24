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
  <title>Certificate Request List &mdash; Barangay Information System</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
  <!-- CSS Libraries -->

  <!-- Template CSS -->
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
 <!-- Bootstrap CSS -->

<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- CSS Libraries -->

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
            <h1>Certificate Request List</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Certificate Request List</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Certificate Request List</h2>
            <div class="row">
              <div class="col-12  col-lg-12">
              	<div class="card-header">
              		<div class="col-lg-12 d-flex justify-content-end">
						<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
							Request Certificate
						</button>
					</div>
              	</div>
                <div class="card">
                    <?php
include 'conn.php'; // Database connection

// Check if session variables exist
if (!isset($_SESSION['u_id']) || !isset($_SESSION['r_id']) || !isset($_SESSION['b_list_id'])) {
?>
    <tr><td colspan="5">Session expired. Please log in again.</td></tr>
<?php
    exit();
}

// Retrieve session variables
$u_id = $_SESSION['u_id'];
$r_id = $_SESSION['r_id'];
$b_list_id = $_SESSION['b_list_id'];

// Set pagination variables
$rows_per_page = 10; // Maximum of 10 rows per page
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $rows_per_page;

// Get total row count for pagination
$count_query = "SELECT COUNT(*) AS total FROM req_cert 
                WHERE u_id = '$u_id' AND r_id = '$r_id' AND b_list_id = '$b_list_id'";
$count_result = mysqli_query($conn, $count_query);
$total_rows = mysqli_fetch_assoc($count_result)['total'];
$total_pages = ceil($total_rows / $rows_per_page);

// Fetch paginated request data with certificate name using JOIN
$query = "SELECT rc.rc_id, rc.purpose, rc.status, c.c_name 
          FROM req_cert rc
          JOIN certificate c ON rc.cert_id = c.cert_id
          WHERE rc.u_id = '$u_id' AND rc.r_id = '$r_id' AND rc.b_list_id = '$b_list_id'
          ORDER BY rc.rc_id DESC
          LIMIT $rows_per_page OFFSET $offset";

$result = mysqli_query($conn, $query);
?>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Purpose</th>
                    <th>Certificate Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['rc_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['purpose']); ?></td>
                            <td><?php echo htmlspecialchars($row['c_name']); ?></td>
                            <td>
							    <?php
							    $status = htmlspecialchars($row['status']); // Get status

							    // Determine badge class based on status
							    $status_class = "";
							    if ($status === "Approved") {
							        $status_class = "bg-success text-white";
							    } elseif ($status === "Pending") {
							        $status_class = "bg-warning text-dark";
							    } elseif ($status === "Denied") {
							        $status_class = "bg-danger text-white";
							    }
							    ?>
							    
							    <span class="badge <?php echo $status_class; ?>"><?php echo $status; ?></span>
							</td>
                            <td>
                                <a href="req_info.php?rc_id=<?php echo $row['rc_id']; ?>" class="btn btn-outline-secondary">Details</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">
                        	<center>
                        		No certificate requests found.
                        	</center>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination Section -->
<div class="card-footer text-right">
    <nav class="d-inline-block">
        <ul class="pagination mb-0">
            <!-- Previous Button -->
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next Button -->
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>

<?php
// Close database connection
mysqli_close($conn);
?>

                </div>
              </div>
            </div>
          </div>
        </section>
        <?php include 'req_clearance.php'; ?>
        <?php
include 'conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; // Include SweetAlert

    // Check if required session variables exist
    if (!isset($_SESSION['u_id']) || !isset($_SESSION['r_id']) || !isset($_SESSION['b_list_id'])) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Session Expired!',
                text: 'Please log in again.',
                confirmButtonColor: '#dc3545'
            }).then(() => window.location.href='index.php');
        </script>";
        exit();
    }

    // Retrieve and sanitize form data
    $purpose = trim($_POST['purpose']);
    $cert_id = trim($_POST['cert_id']);

    $purpose = mysqli_real_escape_string($conn, $purpose);
    $cert_id = mysqli_real_escape_string($conn, $cert_id);

    // Retrieve session variables
    $u_id = $_SESSION['u_id'];
    $r_id = $_SESSION['r_id'];
    $b_list_id = $_SESSION['b_list_id'];

    // Check if a pending request already exists for this user
    $check_query = "SELECT * FROM req_cert WHERE u_id = '$u_id' AND r_id = '$r_id' AND b_list_id = '$b_list_id' AND status = 'Pending' LIMIT 1";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // A pending request exists, show error message
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Your last request is a pending!',
                text: 'Please wait for it to be processed before submitting another request.',
                confirmButtonColor: '#ffc107'
            }).then(() => window.history.back());
        </script>";
        exit();
    }

    // Insert query into `req_cert` table
    $query = "INSERT INTO req_cert (u_id, r_id, b_list_id, cert_id, purpose, status) VALUES ('$u_id', '$r_id', '$b_list_id', '$cert_id', '$purpose', 'Pending')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Request Submitted!',
                text: 'Your certificate request has been sent successfully.',
                confirmButtonColor: '#28a745'
            }).then(() => window.location.href='c_c.php');
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Submission Failed!',
                text: 'An error occurred while submitting your request.',
                confirmButtonColor: '#dc3545'
            }).then(() => window.history.back());
        </script>";
    }
}

// Close database connection
mysqli_close($conn);
?>



      </div>
      <?php include 'Include/footer.php'; ?>
    </div>
  </div>

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