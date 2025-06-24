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
  <title>Household List &mdash; Barangay Information System</title>

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
            <h1>Household List</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Household List</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Household List</h2>
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
$total_query = "SELECT COUNT(*) AS total FROM household WHERE b_list_id = '$b_list_id'" . ($status_filter ? " AND status = '$status_filter'" : "");
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated records based on status filter and b_list_id
$query = "SELECT h.*, 
                 CONCAT(r.first_name, ' ', r.middle_name, ' ', r.last_name, 
                        IF(r.suffix_name = 'None' OR r.suffix_name IS NULL, '', CONCAT(' ', r.suffix_name))) AS full_name 
          FROM household h 
          JOIN residence r ON h.r_id = r.r_id 
          WHERE h.b_list_id = '$b_list_id'" .
          ($status_filter ? " AND h.status = '$status_filter'" : "") .
          " LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<div class="card-header">
    <div class="col-lg-4">
        <label><h4>Status</h4></label>
        <select id="statusFilter" class="form-control" onchange="filterStatus()">
            <option value="">All</option>
            <option value="Active Household" <?php echo ($status_filter == 'Active Household') ? 'selected' : ''; ?>>Active Household</option>
            <option value="Inactive Household" <?php echo ($status_filter == 'Inactive Household') ? 'selected' : ''; ?>>Inactive Household</option>
        </select>
    </div>
    <!-- <div class="col-lg-8 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Household List
        </button>
    </div> -->
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Household Number</th>
                    <th>Head of Family</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['h_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['h_num']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td>
                                <div class="badge <?php echo ($row['status'] === 'Active Household') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                            <td>
                                <a href="h_info.php?h_id=<?php echo urlencode($row['h_id']); ?>" 
                                   class="btn btn-outline-secondary">Detail</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">
                            <center>
                                <h4>No Household Records Found</h4>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Household </h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
              </div>
              <div class="modal-body">
               <form method="post" action="household.php" enctype="multipart/form-data">
               	    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
							    <label><h6>Purok/Street Name</h6></label>
							    <select class="form-control" name="ps_list_id" id="ps_list_id" required>
							        <option value="">Select an Option</option>
							        <?php
							        include 'conn.php';
							        $sql = "SELECT ps_list_id, ps_name FROM ps_list WHERE status = 'Active'";
							        $result = mysqli_query($conn, $sql);
							        while ($row = mysqli_fetch_assoc($result)) {
							            echo '<option value="' . htmlspecialchars($row['ps_list_id']) . '">' . htmlspecialchars($row['ps_name']) . '</option>';
							        }
							        mysqli_close($conn);
							        ?>
							    </select>
							</div>
							<div class="col-lg-6">
							    <label><h6>Head of Family</h6></label>
							    <select name="r_id" id="r_id" class="form-control" required>
							        <option selected disabled>Choose a Residence</option>
							    </select>
							</div>
							<!-- Hidden storage for residence data -->
							<select id="residence_data" style="display: none;">
							    <?php
							    include 'conn.php';
							    $query = "SELECT r_id, first_name, middle_name, last_name, suffix_name, ps_list_id FROM residence";
							    $result = mysqli_query($conn, $query);
							    
							    while ($row = mysqli_fetch_assoc($result)) {
							        $full_name = $row['first_name'];
							        if (!empty($row['middle_name'])) {
							            $full_name .= " " . $row['middle_name'];
							        }
							        $full_name .= " " . $row['last_name'];

							        if (!empty($row['suffix_name']) && $row['suffix_name'] !== "None") {
							            $full_name .= " " . $row['suffix_name'];
							        }

							        echo "<option value='{$row['r_id']}' data-ps_list_id='{$row['ps_list_id']}'>$full_name</option>";
							    }
							    mysqli_close($conn);
							    ?>
							</select>
							<div class="col-lg-12">
							    <br>
							</div>
							<div class="col-lg-6">
							    <label><h6>Household No.</h6></label>
							    <input type="number" name="h_num" id="h_num" class="form-control" placeholder="Household Number" readonly>
							</div>
							<?php include 'gene.php'; ?>
							<div class="col-lg-6">
								<label>
									<h6>Total Member of Household</h6>
								</label>
								<input type="number" name="t_member" id="t_member" class="form-control" placeholder="Input the Total Member of Household" required>
							</div>
							<div class="col-lg-12">
								<br>
							</div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Status</h6>
                                </label>
                                <select class="form-control" name="status" id="status" required>
                                    <option selected disabled>Choose a Status</option>
                                    <option value="Active Household">Active Household</option>
                                    <option value="Inactive Household">Inactive Household</option>
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $ps_list_id = mysqli_real_escape_string($conn, $_POST['ps_list_id']);
    $r_id = mysqli_real_escape_string($conn, $_POST['r_id']);
    $h_num = mysqli_real_escape_string($conn, $_POST['h_num']);
    $t_member = mysqli_real_escape_string($conn, $_POST['t_member']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    // Get currently signed-in user details
    $b_list_id = isset($_SESSION['b_list_id']) ? $_SESSION['b_list_id'] : null;
    $u_id = isset($_SESSION['u_id']) ? $_SESSION['u_id'] : null;

    // Validate if b_list_id and u_id are available
    if ($b_list_id === null || $u_id === null) {
        echo "<script>
                alert('Error: User session data missing!');
                window.history.back();
              </script>";
        exit();
    }

    // Check if the combination of ps_list_id and r_id already exists
    $check_query = "SELECT * FROM household WHERE ps_list_id = '$ps_list_id' AND r_id = '$r_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    icon: 'warning',
                    title: 'Duplicate Entry',
                    text: 'A record with the same Purok/Street Name and Residence Full Name already exists.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.history.back();
                    }
                });
              </script>";
    } else {
        // Insert data into the household table
        $sql = "INSERT INTO household (ps_list_id, r_id, h_num, t_member, status, b_list_id, u_id) 
                VALUES ('$ps_list_id', '$r_id', '$h_num', '$t_member', '$status', '$b_list_id', '$u_id')";

        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

        if (mysqli_query($conn, $sql)) {
            echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Household added successfully!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = 'household.php';
                        }
                    });
                  </script>";
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: '" . mysqli_error($conn) . "',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.history.back();
                        }
                    });
                  </script>";
        }
    }

    mysqli_close($conn);
}
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