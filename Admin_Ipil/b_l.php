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
  <title>Barangay List &mdash; Barangay Information System</title>

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
      <div class="navbar-bg bg-success"></div>
      <?php include 'Include/header.php'; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include 'Include/side_bar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Barangay List</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Barangay List</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Barangay List</h2>
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
                  <?php
include 'conn.php';

// Pagination setup
$limit = 10;
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * $limit;

// Get selected status filter
$status_filter = isset($_GET['status']) ? mysqli_real_escape_string($conn, $_GET['status']) : '';

// Fetch total records count based on status filter
$total_query = "SELECT COUNT(*) AS total FROM b_list" . ($status_filter ? " WHERE status = '$status_filter'" : "");
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch paginated records based on status filter
$query = "SELECT * FROM b_list" . ($status_filter ? " WHERE status = '$status_filter'" : "") . " LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<div class="card-header">
    <div class="col-lg-4">
        <label><h4>Status</h4></label>
        <select id="statusFilter" class="form-control" onchange="filterStatus()">
            <option value="">All</option>
            <option value="Active" <?php echo ($status_filter == 'Active') ? 'selected' : ''; ?>>Active</option>
            <option value="Inactive" <?php echo ($status_filter == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
        </select>
    </div>
    <div class="col-lg-8 d-flex justify-content-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Add Barangay 
        </button>
    </div>
</div>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Barangay Name</th>
                    <th>Barangay ID</th>
                    <th>Barangay Email</th>
                    <th>Barangay Seal</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['b_list_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['barangay_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['b_code']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <?php
                                $b_logo = !empty($row['b_logo']) ? "uploads/" . htmlspecialchars($row['b_logo']) : "uploads/default.png";
                                ?>
                                <img src="<?php echo $b_logo; ?>" alt="Barangay Seal" width="80" height="80" style="border-radius: 50%;">
                            </td>
                            <td>
                                <?php if (!empty($row['b_location'])): ?>
                                    <a href="<?php echo htmlspecialchars($row['b_location']); ?>" target="_blank" class="btn btn-outline-primary">View Location</a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="badge <?php echo ($row['status'] === 'Active') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                            <td>
                                <a href="b_list_info.php?b_list_id=<?php echo urlencode($row['b_list_id']); ?>" 
                                   class="btn btn-outline-secondary">Detail</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">
                            <center><h4>No Barangay records found</h4></center>
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
                <h5 class="modal-title" id="exampleModalLabel">Add Barangay Positions</h5>
                <!-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> -->
              </div>
              <div class="modal-body">
               <form method="post" action="b_l.php" enctype="multipart/form-data">
               	    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-6">
                                <label>
                                    <h6>Barangay Name</h6>
                                </label>
                                <input type="text" name="barangay_name" id="barangay_name" class="form-control" placeholder="Input the Barangay Name" required>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Barangay ID</h6>
                                </label>
                                <input type="text" name="b_code" id="b_code" class="form-control" placeholder="Generated Barangay ID" readonly>
                            </div>
                            <?php include 'b_code.php'; ?>
                            <div class="col-lg-12">
                                <br>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Barangay Seal</h6>
                                </label>
                                <input type="file" name="b_logo" id="b_logo" class="form-control" placeholder="Barangay Email" required>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Barangay Email</h6>
                                </label>
                                <input type="text" name="email" id="email" class="form-control" placeholder="Barangay Email" readonly>
                            </div>
                            <?php include 'b_email.php'; ?>
                            <div class="col-lg-12">
                                <br>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Barangay Password</h6>
                                </label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Input the Barangay Password" required>
                            </div>
                            <div class="col-lg-6">
                                <label>
                                    <h6>Barangay Confirm Password</h6>
                                </label>
                                <input type="password" name="con_pass" id="con_pass" class="form-control" placeholder="Input the Barangay Confirm Password" required>
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

    if (!isset($_SESSION['a_id'])) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Access Denied!',
                text: 'You must be logged in to add a Barangay!',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.location.href='login.php'; });
        </script>";
        exit;
    }

    $a_id = $_SESSION['a_id'];
    $barangay_name = mysqli_real_escape_string($conn, $_POST['barangay_name']);
    $barangay_name = str_replace(['‑', '–', '—', '−'], '-', $barangay_name); // normalize hyphens
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $con_pass = mysqli_real_escape_string($conn, $_POST['con_pass']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $user_type = "Barangay Account";
    $date = date('Y-m-d');

    // Determine location based on barangay name
    $b_location = "";
    switch ($barangay_name) {
        case "Bacalan":
            $b_location = "https://maps.app.goo.gl/MxmA7kiyfqFY7ZB68";
            break;
        case "Bangkerohan":
            $b_location = "https://maps.app.goo.gl/W9VEWXw8cdkJykXq8";
            break;
        case "Bulu-an":
            $b_location = "https://maps.app.goo.gl/LaZBhmMMp2fW834x6";
            break;
        case "Caparan":
            $b_location = "https://maps.app.goo.gl/awfnK7DbjUGuiH6E8";
            break;
        case "Domandan":
            $b_location = "https://maps.app.goo.gl/4b98Q5XYA7Vzornz5";
            break;
        case "Don Andres":
            $b_location = "https://maps.app.goo.gl/6aLGxQGa8Cg5ChnR8";
            break;
        case "Ipil Heights":
            $b_location = "https://maps.app.goo.gl/uiMiHpEtE9GxGcA68"; // New location link
            break;
        case "Lumbia": // Added Lumbia Barangay
            $b_location = "https://maps.app.goo.gl/u8LhqTQvxWuCBnmv6"; // New location link
            break;
        case "Lower Taway": // Added Lower Taway Barangay
            $b_location = "https://maps.app.goo.gl/4eKcvvgtkhganUrc9"; // New location link for Lower Taway
            break;
        case "Veterans Village": // Added Veteran's Village Barangay
            $b_location = "https://maps.app.goo.gl/NGNfKv9jqepskAF5A"; // New location link for Veteran's Village
            break;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Invalid Email!',
                text: 'Please enter a valid email address.',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });
        </script>";
        exit;
    }

    if ($password !== $con_pass) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Password Mismatch!',
                text: 'Passwords do not match.',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });
        </script>";
        exit;
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    function generateUniqueCode($conn) {
        do {
            $b_code = rand(100000, 999999);
            $check_code_result = mysqli_query($conn, "SELECT * FROM b_list WHERE b_code = '$b_code'");
        } while (mysqli_num_rows($check_code_result) > 0);
        return $b_code;
    }

    $b_code = generateUniqueCode($conn);

    // Check for duplicates
    $check_barangay_result = mysqli_query($conn, "SELECT * FROM b_list WHERE barangay_name = '$barangay_name'");
    if (mysqli_num_rows($check_barangay_result) > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Entry!',
                text: 'Barangay name already exists!',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });
        </script>";
        exit;
    }

    $check_email_result = mysqli_query($conn, "SELECT * FROM b_list WHERE email = '$email'");
    if (mysqli_num_rows($check_email_result) > 0) {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Duplicate Email!',
                text: 'This email is already registered!',
                confirmButtonColor: '#dc3545'
            }).then(() => { window.history.back(); });
        </script>";
        exit;
    }

    // Handle logo upload
    $upload_dir = "uploads/";
    $b_logo = null;

    if (isset($_FILES['b_logo']) && $_FILES['b_logo']['error'] === UPLOAD_ERR_OK) {
        $file_name = $_FILES['b_logo']['name'];
        $file_tmp = $_FILES['b_logo']['tmp_name'];
        $file_size = $_FILES['b_logo']['size'];
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
        $allowed_exts = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file_ext, $allowed_exts)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid File Type!',
                    text: 'Only JPG, JPEG, PNG, and GIF files are allowed.',
                    confirmButtonColor: '#dc3545'
                }).then(() => { window.history.back(); });
            </script>";
            exit;
        }

        if ($file_size > 2 * 1024 * 1024) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'File Too Large!',
                    text: 'File size should not exceed 2MB.',
                    confirmButtonColor: '#dc3545'
                }).then(() => { window.history.back(); });
            </script>";
            exit;
        }

        $new_file_name = time() . "_" . uniqid() . "." . $file_ext;
        $file_destination = $upload_dir . $new_file_name;

        if (move_uploaded_file($file_tmp, $file_destination)) {
            $b_logo = $new_file_name;
        }
    }

    $query = "INSERT INTO b_list (barangay_name, b_code, email, password, con_pass, status, a_id, b_logo, user_type, b_location) 
              VALUES ('$barangay_name', '$b_code', '$email', '$hashed_password', '$con_pass', '$status', '$a_id', '$b_logo', '$user_type', '$b_location')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        $b_list_id = mysqli_insert_id($conn);
        $user_query = "INSERT INTO user_type (email, password, b_list_id, user_type, status, date) 
                       VALUES ('$email', '$hashed_password', '$b_list_id', '$user_type', '$status', '$date')";
        $user_result = mysqli_query($conn, $user_query);

        if ($user_result) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Barangay added successfully!',
                    confirmButtonColor: '#28a745'
                }).then(() => { window.location.href='b_l.php'; });
            </script>";
        } else {
            echo "<script>alert('Error inserting into user_type table');</script>";
        }
    } else {
        echo "<script>alert('Error inserting into b_list table');</script>";
    }
}

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
}else{
    header("Location: index.php");
    exit();
}

?>