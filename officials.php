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
  <title>Barangay Officials List &mdash; Barangay Information System</title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="assets/modules/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/modules/fontawesome/css/all.min.css">
  <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
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
            <h1>Barangay Officials List</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Barangay Officials List</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Barangay Officials List</h2>
            <div class="row">
              <div class="col-12  col-lg-12">
                <div class="card">
                  <?php
                    include 'conn.php';
                    // Check if user is logged in and get their b_list_id
                    if (!isset($_SESSION['b_list_id'])) {
                        echo "<h4><center>User not signed in</center></h4>";
                        exit;
                    }

                    $b_list_id = $_SESSION['b_list_id']; // Get logged-in user's b_list_id

                    // Define pagination variables
                    $limit = 10; // Number of records per page
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Get current page number
                    $offset = ($page - 1) * $limit; // Calculate offset

                    // Fetch total number of records for pagination (filtered by b_list_id)
                    $total_query = "SELECT COUNT(*) AS total FROM b_officials WHERE b_list_id = '$b_list_id'";
                    $total_result = mysqli_query($conn, $total_query);
                    $total_row = mysqli_fetch_assoc($total_result);
                    $total_records = $total_row['total'];
                    $total_pages = ceil($total_records / $limit); // Calculate total pages

                    // Fetch paginated results (filtered by b_list_id)
                    $query = "SELECT b_officials.b_officials_id, 
                                     CONCAT(b_officials.first_name, ' ', 
                                            IFNULL(CONCAT(b_officials.middle_name, ' '), ''), 
                                            b_officials.last_name, 
                                            IF(b_officials.suffix_name = 'None' OR b_officials.suffix_name IS NULL, '', CONCAT(' ', b_officials.suffix_name))) AS full_name, 
                                     b_officials.profile, 
                                     b_officials.status, 
                                     b_positions.position_name 
                              FROM b_officials 
                              JOIN b_positions ON b_officials.b_positions_id = b_positions.b_positions_id
                              WHERE b_officials.b_list_id = '$b_list_id' 
                              LIMIT $limit OFFSET $offset";

                    $result = mysqli_query($conn, $query);
                    ?>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered table-md">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Barangay Position</th>
                                        <th>Barangay Official Name</th>
                                        <th>Barangay Official Picture</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (mysqli_num_rows($result) > 0): ?>
                                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($row['b_officials_id']); ?></td>
                                                <td><?php echo htmlspecialchars($row['position_name']); ?></td> <!-- Display Position Name -->
                                                <td><?php echo htmlspecialchars($row['full_name']); ?></td> <!-- Display Full Name -->
                                                <td>
                                                    <center>
                                                        <img src="Admin_Ipil/officials/<?php echo htmlspecialchars($row['profile']); ?>" 
                                                             alt="Profile Picture" width="50" height="50" style="border-radius: 50%;">
                                                    </center>
                                                </td> <!-- Display Profile Image -->
                                                <td>
                                                    <div class="badge <?php echo ($row['status'] === 'Active Officials') ? 'badge-success' : 'badge-danger'; ?>">
                                                        <?php echo htmlspecialchars($row['status']); ?>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="off_detail.php?b_officials_id=<?php echo urlencode($row['b_officials_id']); ?>" class="btn btn-secondary">Detail</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6">
                                                <center>
                                                    <h4>No Officials Found</h4>
                                                </center>
                                            </td>
                                        </tr>
                                    <?php endif; ?>

                                    <?php
                                    // Close connection
                                    mysqli_close($conn);
                                    ?>
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