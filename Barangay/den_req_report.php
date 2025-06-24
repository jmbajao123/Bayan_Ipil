<?php
session_start();
include 'conn.php';

if (isset($_SESSION['email'], $_SESSION['u_id'], $_SESSION['r_id'], $_SESSION['b_list_id'], $_SESSION['user_type']) 
    && $_SESSION['user_type'] === "Barangay Account") {
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Denied Request List Report &mdash; Barangay Information System</title>

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
      <div class="navbar-bg"></div>
      <?php include 'Include/header.php'; ?>
      <div class="main-sidebar sidebar-style-2">
        <?php include 'Include/side_bar.php'; ?>
      </div>

      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
          <div class="section-header">
            <h1>Denied Request List Report</h1>
            <div class="section-header-breadcrumb">
              <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
              <div class="breadcrumb-item">Denied Request List Report</div>
            </div>
          </div>

          <div class="section-body">
            <h2 class="section-title">Denied Request List Report</h2>
            <div class="row">
              <div class="col-12  col-lg-12">
                <div class="card">
                  <div class="card-header">
						    <div class="col-lg-12 d-flex justify-content-end">
						    	<a href="d_req_print.php" class="btn btn-outline-primary" target="_blank">Generate</a>
						    </div>
						</div>
                    <div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>Residence Name</th>
                    <th>Certificate Request</th>
                    <th>Purpose</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'conn.php';
                $b_list_id = $_SESSION['b_list_id'];

                // Set the number of rows per page
                $rows_per_page = 10;

                // Get the current page or set the default to 1
                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $offset = ($page - 1) * $rows_per_page;

                // Fetch data with LIMIT for pagination
                $query = "SELECT rc.r_id, rc.rc_id, rc.cert_id, rc.purpose, rc.status, 
                                 r.first_name, r.middle_name, r.last_name, r.suffix_name,
                                 c.c_name
                          FROM req_cert rc
                          JOIN residence r ON rc.r_id = r.r_id
                          JOIN certificate c ON rc.cert_id = c.cert_id
                          WHERE rc.b_list_id = '$b_list_id' AND rc.status = 'Denied'
                          LIMIT $offset, $rows_per_page";

                $result = mysqli_query($conn, $query);

                // Fetch total rows for pagination calculation
                $total_query = "SELECT COUNT(*) AS total FROM req_cert rc 
                                JOIN residence r ON rc.r_id = r.r_id 
                                JOIN certificate c ON rc.cert_id = c.cert_id 
                                WHERE rc.b_list_id = '$b_list_id' AND rc.status = 'Denied'";
                $total_result = mysqli_query($conn, $total_query);
                $total_rows = mysqli_fetch_assoc($total_result)['total'];
                $total_pages = ceil($total_rows / $rows_per_page);
                ?>
                
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <?php
                        // Construct full name
                        $full_name = $row['first_name'];
                        if (!empty($row['middle_name'])) {
                            $full_name .= " " . $row['middle_name'];
                        }
                        $full_name .= " " . $row['last_name'];
                        if ($row['suffix_name'] !== 'None' && !empty($row['suffix_name'])) {
                            $full_name .= " " . $row['suffix_name'];
                        }
                        ?>
                        <tr>
                            <td><?= $full_name; ?></td>
                            <td><?= $row['c_name']; ?></td>
                            <td><?= $row['purpose']; ?></td>
                            <td><?= $row['status']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">
                        	<center>
                        		No Denied requests found
                        	</center>
                        </td>
                    </tr>
                <?php endif; ?>
                <?php mysqli_close($conn); ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Pagination Section -->
<div class="card-footer text-right">
    <nav class="d-inline-block">
        <ul class="pagination mb-0">
            <!-- Previous Button -->
            <li class="page-item <?= ($page <= 1) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= max(1, $page - 1); ?>">
                    <i class="fas fa-chevron-left"></i>
                </a>
            </li>

            <!-- Page Numbers -->
            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                <li class="page-item <?= ($i == $page) ? 'active' : ''; ?>">
                    <a class="page-link" href="?page=<?= $i; ?>"><?= $i; ?></a>
                </li>
            <?php endfor; ?>

            <!-- Next Button -->
            <li class="page-item <?= ($page >= $total_pages) ? 'disabled' : ''; ?>">
                <a class="page-link" href="?page=<?= min($total_pages, $page + 1); ?>">
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
<?php
include 'conn.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $rc_id = $_POST['rc_id'];
    $new_status = $_POST['status']; // Either "Approved" or "Denied"

    // Update query
    $query = "UPDATE req_cert SET status = '$new_status' WHERE rc_id = '$rc_id'";

    if (mysqli_query($conn, $query)) {
        // Determine the redirection page
        $redirect_page = ($new_status == "Approved") ? "app_req.php" : "den_req.php";
    } else {
        $error_message = "Error updating record: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>

<!-- SweetAlert Script -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
<?php if (isset($redirect_page)): ?>
    Swal.fire({
        title: "Success!",
        text: "Request has been <?= $new_status; ?>.",
        icon: "success"
    }).then(() => {
        window.location.href = "<?= $redirect_page; ?>";
    });
<?php elseif (isset($error_message)): ?>
    Swal.fire({
        title: "Error!",
        text: "<?= $error_message; ?>",
        icon: "error"
    }).then(() => {
        window.history.back();
    });
<?php endif; ?>
</script>


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