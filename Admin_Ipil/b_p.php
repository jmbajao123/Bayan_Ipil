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
            <h2 class="section-title">Barangay Position List</h2>
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-lg-12 d-flex justify-content-end">
			            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
			                Add Barangay Position
			            </button>
			        </div>
                  </div>
               <?php
include 'conn.php';

// Pagination setup
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = ($page < 1) ? 1 : $page; // Prevent negative pages
$start = ($page - 1) * $limit;

// Fetch total records count
$total_query = "SELECT COUNT(*) AS total FROM b_positions";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated records
$query = "SELECT * FROM b_positions LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Position Name</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['b_positions_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['position_name']); ?></td>
                            <td>
                                <div class="badge 
                                    <?php echo ($row['status'] === 'Available') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                            <td>
                                <a href="b_info.php?b_positions_id=<?php echo urlencode($row['b_positions_id']); ?>" 
                                   class="btn btn-outline-secondary">Detail</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">
                            <center>No Barangay Position Records Found</center>
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
                <a class="page-link" href="?page=<?php echo max(1, $page - 1); ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>
            
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?php echo $i; ?>">
                        <?php echo $i; ?>
                    </a>
                </li>
            <?php endfor; ?>
            
            <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?php echo min($total_pages, $page + 1); ?>">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</div>

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
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Barangay Positions</h5>
        <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
      </div>
      <div class="modal-body">
       <form method="post" action="b_p.php">
       	<div class="col-lg-12">
       		<label>
       			<h6>Barangay Position</h6>
       		</label>
       		<input type="text" name="position_name" id="position_name" class="form-control" placeholder="Input the Barangay Positions" required>
       	</div>
       	<div class="col-lg-12">
       		<br>
       	</div>
       	<div class="col-lg-12">
       		<label>
       			<h6>Status</h6>
       		</label>
       		<select class="form-control" name="status" id="status" required>
       			<option selected disabled>Choose a Status</option>
       			<option value="Available">Available</option>
       			<option value="Unavailable">Unavailable</option>
       		</select>
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
include 'conn.php'; // Ensure you have a database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $position_name = isset($_POST['position_name']) ? trim($_POST['position_name']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $a_id = isset($_SESSION['a_id']) ? $_SESSION['a_id'] : null; // Retrieve currently signed-in admin ID
    
    echo '<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>';
    
    // Validate required fields
    if (!empty($position_name) && !empty($status) && !empty($a_id)) {
        // Check for duplicate entry
        $check_sql = "SELECT * FROM b_positions WHERE position_name = ? AND a_id = ?";
        if ($check_stmt = $conn->prepare($check_sql)) {
            $check_stmt->bind_param("si", $position_name, $a_id);
            $check_stmt->execute();
            $result = $check_stmt->get_result();
            
            if ($result->num_rows > 0) {
                echo "<script>
                    Swal.fire({
                        title: 'Duplicate Entry!',
                        text: 'This barangay position already exists.',
                        icon: 'warning',
                        confirmButtonText: 'OK'
                    }).then(() => { window.history.back(); });
                </script>";
            } else {
                // Prepare SQL query to insert data into the b_positions table
                $sql = "INSERT INTO b_positions (position_name, status, a_id) VALUES (?, ?, ?)";
                
                if ($stmt = $conn->prepare($sql)) {
                    $stmt->bind_param("ssi", $position_name, $status, $a_id);
                    
                    if ($stmt->execute()) {
                        echo "<script>
                            Swal.fire({
                                title: 'Success!',
                                text: 'Barangay position added successfully!',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => { window.location.href='b_p.php'; });
                        </script>";
                    } else {
                        echo "<script>
                            Swal.fire({
                                title: 'Error!',
                                text: 'Error adding barangay position.',
                                icon: 'error',
                                confirmButtonText: 'Try Again'
                            }).then(() => { window.history.back(); });
                        </script>";
                    }
                    
                    $stmt->close();
                } else {
                    echo "<script>
                        Swal.fire({
                            title: 'Database Error!',
                            text: 'Please try again later.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        }).then(() => { window.history.back(); });
                    </script>";
                }
            }
            $check_stmt->close();
        }
    } else {
        echo "<script>
            Swal.fire({
                title: 'Warning!',
                text: 'All fields are required.',
                icon: 'warning',
                confirmButtonText: 'OK'
            }).then(() => { window.history.back(); });
        </script>";
    }
    
    $conn->close();
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
}else{
    header("Location: index.php");
    exit();
}

?>