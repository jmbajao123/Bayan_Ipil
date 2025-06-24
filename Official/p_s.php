<?php
session_start();
include 'conn.php';

if (isset($_SESSION['email'], $_SESSION['u_id'], $_SESSION['r_id'], $_SESSION['b_list_id'], $_SESSION['user_type']) 
    && $_SESSION['user_type'] === "Official Account") {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Purok/Street List &mdash; Barangay Information System</title>

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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <h1>Purok/Street List</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Purok/Street List</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Purok/Street List</h2>
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
                  <?php
include 'conn.php';
// Check if user is logged in and get their b_list_id
if (!isset($_SESSION['b_list_id'])) {
    echo "<h4><center>User not signed in</center></h4>";
    exit;
}

$b_list_id = $_SESSION['b_list_id']; // Get logged-in user's b_list_id

// Pagination setup
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = ($page < 1) ? 1 : $page; // Prevent negative pages
$start = ($page - 1) * $limit;

// Get selected status filter
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

// Fetch total records count based on status filter and b_list_id
$total_query = "SELECT COUNT(*) AS total FROM ps_list WHERE b_list_id = '$b_list_id'";
if ($status_filter) {
    $total_query .= " AND status = '$status_filter'";
}
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated records based on status filter and b_list_id
$query = "SELECT * FROM ps_list WHERE b_list_id = '$b_list_id'";
if ($status_filter) {
    $query .= " AND status = '$status_filter'";
}
$query .= " LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<div class="card-header">
    <div class="col-lg-4">
        <label>
            <h4>Status</h4>
        </label>
        <select id="statusFilter" class="form-control" onchange="filterStatus()">
            <option value="">All</option>
            <option value="Active" <?php echo ($status_filter == 'Active') ? 'selected' : ''; ?>>Active</option>
            <option value="Inactive" <?php echo ($status_filter == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select>
    </div>
    <!-- <div class="col-lg-8 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Purok/Street List
        </button>
    </div> -->
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Purok/Street Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['ps_list_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['ps_name']); ?></td>
                            <td>
                                <div class="badge <?php echo ($row['status'] === 'Active') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                            <td>
                                <a href="ps_list_info.php?ps_list_id=<?php echo urlencode($row['ps_list_id']); ?>" 
                                   class="btn btn-outline-secondary">Detail</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7">
                            <center>
                                <h4>No Purok/ Street Records Found</h4>
                            </center>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card-footer text-right">
    <nav class="d-inline-block">
        <ul class="pagination mb-0">
            <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>&status=<?php echo $status_filter; ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>&status=<?php echo $status_filter; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
            
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>&status=<?php echo $status_filter; ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>

<script>
function filterStatus() {
    var status = document.getElementById("statusFilter").value;
    window.location.href = "?status=" + status;
}
</script>

<?php
// Close connection
mysqli_close($conn);
?>




                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Add Purok/Street </h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
              </div>
              <div class="modal-body">
               <form method="post" action="p_s.php" enctype="multipart/form-data">
               	    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>
                                    <h6>Purok/Street Name</h6>
                                </label>
                                <input type="text" name="ps_name" id="ps_name" class="form-control" placeholder="Input the Purok/Street Name" required>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Status</h6>
                                </label>
                                <select class="form-control" name="status" id="status" required>
                                    <option selected disabled>Choose a Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-outline-primary">Add now</button>
              </div>
              </form>
            </div>
          </div>
        </div>
<?php
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_SESSION['u_id']) || !isset($_SESSION['b_list_id'])) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied!',
                text: 'You must be logged in to add a Purok/Street!',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.location.href='login.php'; });
        </script>";
        exit;
    }

    $u_id = $_SESSION['u_id']; // Get currently logged-in user ID
    $b_list_id = $_SESSION['b_list_id']; // Get b_list_id from session
    $ps_name = mysqli_real_escape_string($conn, $_POST['ps_name']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $date = date('Y-m-d'); // Current date

    // Check for duplicate purok/street name
    $check_ps_query = "SELECT * FROM ps_list WHERE ps_name = '$ps_name' AND b_list_id = '$b_list_id'";
    $check_ps_result = mysqli_query($conn, $check_ps_query);

    if (mysqli_num_rows($check_ps_result) > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Entry!',
                text: 'Purok/Street name already exists!',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });
        </script>";
        exit;
    }

    // Insert into ps_list
    $query = "INSERT INTO ps_list (ps_name, status, u_id, b_list_id, date) 
              VALUES ('$ps_name', '$status', '$u_id', '$b_list_id', '$date')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Purok/Street added successfully!',
                confirmButtonColor: '#28a745'
            }).then(() => { window.location.href='p_s.php'; });
        </script>";
    } else {
        echo "<script>alert('Error inserting into ps_list table');</script>";
    }
}

// Close connection
mysqli_close($conn);
?>







<!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    header("Location: ../index.php");
    exit();
}
?>