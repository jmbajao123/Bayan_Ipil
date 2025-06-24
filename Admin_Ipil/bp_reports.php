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
  <title>Barangay Position Report &mdash; Barangay Information System</title>

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
            <h1>Barangay Position Report</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="dashboard.php">Dashboard</a></div>
              <div class="breadcrumb-item">Barangay Position Report</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Barangay Position Report</h2>
            <div class="row">
              <div class="col-12 col-lg-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <div class="col-lg-12 d-flex justify-content-end">
                    	<a href="bp_print.php" target="_blank" class="btn btn-outline-primary">Generate</a>
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
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4">No records found</td>
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