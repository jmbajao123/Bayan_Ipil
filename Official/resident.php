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
  <title>Residence List &mdash; Barangay Information System</title>
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

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
      <div class="navbar-bg"></div>
      <?php include 'Include/header.php'; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include 'Include/side_bar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Residence List</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Residence List</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Residence List</h2>
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
									<!-- <div class="card-header">
										
									  <div class="col-lg-12 d-flex justify-content-end">
									    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
									      Add Residence List
									    </button>
									  </div>
									</div> -->
									<?php

// Ensure the user is logged in
if (!isset($_SESSION['b_list_id'])) {
    die("Access denied. Please log in.");
}

$logged_in_b_list_id = $_SESSION['b_list_id']; // Get currently logged-in user's b_list_id

// Define how many results per page
$limit = 10;

// Get the current page number from the URL, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Calculate the starting row for the query
$start = ($page - 1) * $limit;

include 'conn.php';

// Secure `b_list_id` for query
$safe_b_list_id = mysqli_real_escape_string($conn, $logged_in_b_list_id);

// Count total rows in `residence` to calculate total pages (only matching b_list_id)
$total_query = "SELECT COUNT(*) AS total FROM residence WHERE b_list_id = '$safe_b_list_id'";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch data filtered by b_list_id with LEFT JOIN to include ps_name
$query = "SELECT residence.residence_id, 
                 residence.r_id, 
                 residence.first_name, 
                 residence.middle_name, 
                 residence.last_name, 
                 residence.suffix_name, 
                 residence.status, 
                 residence.profile, 
                 ps_list.ps_name
          FROM residence
          LEFT JOIN ps_list ON residence.ps_list_id = ps_list.ps_list_id
          WHERE residence.b_list_id = '$safe_b_list_id'
          LIMIT $start, $limit";

$result = mysqli_query($conn, $query);
?>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Purok/Street Name</th>
                    <th>Resident Name</th>
                    <th>Profile Picture</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): 
                    while ($row = mysqli_fetch_assoc($result)): 
                        // Format full name
                        $full_name = trim(
                            $row['first_name'] . " " . 
                            (!empty($row['middle_name']) ? $row['middle_name'] . " " : "") . 
                            $row['last_name'] . 
                            (($row['suffix_name'] !== "None" && !empty($row['suffix_name'])) ? " " . $row['suffix_name'] : "")
                        );

                        // Define profile picture path
                        $profile = !empty($row['profile']) && file_exists("../Barangay/uploads/" . $row['profile']) 
                            ? "../Barangay/uploads/" . $row['profile'] 
                            : "../Barangay/uploads/default.png"; // Use default image if none exists
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['r_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['ps_name']); ?></td>
                            <td><?php echo htmlspecialchars($full_name); ?></td>
                            <td>
                                <img src="<?php echo htmlspecialchars($profile); ?>" 
                                     alt="Profile Picture" 
                                     class="rounded-circle" 
                                     width="80" height="80">
                            </td>
                            <td>
                                <div class="badge <?php echo ($row['status'] === 'Active Residence') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                            <td>
                                <a href="residence_info.php?r_id=<?php echo urlencode($row['r_id']); ?>" 
                                   class="btn btn-outline-secondary">Detail</a>
                            </td>
                        </tr>
                    <?php endwhile; 
                else: ?>
                    <tr>
                        <td colspan="6" class="text-center">
                            <h4>No Residents Found</h4>
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




                </div>
              </div>
            </div>
          </div>
        </section>
        <?php include 'add_r.php'; ?>
<?php
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and collect form data
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $last_name = $_POST['last_name'];
    $suffix_name = $_POST['suffix_name'];
    $date_birth = $_POST['date_birth'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $civil_status = $_POST['civil_status'];
    $contact = $_POST['contact'];
    $residence_id = $_POST['residence_id'];
    $ps_list_id = (int)$_POST['ps_list_id']; // Convert to integer
    $nationality = $_POST['nationality'];
    $birthplace = $_POST['birthplace'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password
    $con_pass = $_POST['con_pass']; // Store confirm password as plain text
    $status = 'Active Residence'; // Default status
    $user_type = 'Residence Account'; // User type

    // Get session values
    $u_id = isset($_SESSION['u_id']) ? (int)$_SESSION['u_id'] : 0;
    $b_list_id = isset($_SESSION['b_list_id']) ? (int)$_SESSION['b_list_id'] : 0;

    // Handle file upload
    if (!empty($_FILES['profile']['name'])) {
        $profile = $_FILES['profile']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($profile);

        if (!move_uploaded_file($_FILES['profile']['tmp_name'], $target_file)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Error uploading file.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
            exit();
        }
    } else {
        $profile = null; // If no file is uploaded, store NULL
    }

    // Insert into residence table
    $query = "INSERT INTO residence (first_name, middle_name, last_name, suffix_name, date_birth, age, gender, civil_status, contact, profile, residence_id, ps_list_id, nationality, birthplace, email, password, con_pass, status, user_type, u_id, b_list_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssssssssiisssssssii", 
        $first_name, $middle_name, $last_name, $suffix_name, $date_birth, $age, $gender, 
        $civil_status, $contact, $profile, $residence_id, $ps_list_id, $nationality, 
        $birthplace, $email, $password, $con_pass, $status, $user_type, $u_id, $b_list_id
    );

    if (mysqli_stmt_execute($stmt)) {
        $r_id = mysqli_insert_id($conn); // Get last inserted ID

        // Insert into user_type table with "Active" status
        $query_user_type = "INSERT INTO user_type (email, password, b_list_id, user_type, r_id, status) 
                            VALUES (?, ?, ?, ?, ?, 'Active')";
        
        $stmt_user_type = mysqli_prepare($conn, $query_user_type);
        mysqli_stmt_bind_param($stmt_user_type, "ssisi", $email, $password, $b_list_id, $user_type, $r_id);

        if (mysqli_stmt_execute($stmt_user_type)) {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        title: 'Success!',
                        text: 'Resident added successfully!',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = 'resident.php';
                    });
                  </script>";
        } else {
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
            echo "<script>
                    Swal.fire({
                        title: 'Error!',
                        text: 'Failed to insert into user_type table.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                  </script>";
        }

        mysqli_stmt_close($stmt_user_type);
    } else {
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Unable to add resident.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
              </script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>






<!-- Bootstrap 5 JS Bundle (includes Popper.js) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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
    header("Location: ../index.php");
    exit();
}
?>