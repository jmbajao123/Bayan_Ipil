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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="assets/css/bootstrap.css">
    
    <link rel="stylesheet" href="assets/vendors/perfect-scrollbar/perfect-scrollbar.css">
    <link rel="stylesheet" href="assets/css/app.css">
    <link rel="shortcut icon" href="assets/img/logo.png" type="image/x-icon">
    <title>Household List Report - Sibugay Tech Government Portal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 1000px;
            margin: 0 auto;
        }

        .picture-box {
            width: 150px;
            height: 150px;
            border: 1px solid #ccc;
            text-align: center;
            line-height: 150px;
            display: inline-block;
            /* Add this line */
            margin-left: 25px;
        }

        .underline {
            text-decoration: underline;
        }

        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        @media print {
            #printSaveButtonContainer {
                display: none;
            }
            body {
                width: 100%;
            }

            table {
                width: 100%;
            }

            th, td {
                word-break: break-all;
            }
        }
    </style>
</head>

<body>
<br><br><br>
    <div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div id="reports-container" class="card-body">
                	<h6>
                		<?php
				            // Include your database connection file
				            include 'conn.php';
				            // Check if b_list_id is set in the session
				            if(isset($_SESSION['b_list_id'])) {
				                $b_list_id = $_SESSION['b_list_id']; // Get the currently signed-in user's barangay list ID

				                // Query to fetch the barangay logo (b_logo) based on b_list_id
				                $query = "SELECT b_logo FROM b_list WHERE b_list_id = ?";
				                $stmt = mysqli_prepare($conn, $query);
				                
				                if ($stmt) {
				                    mysqli_stmt_bind_param($stmt, "i", $b_list_id);
				                    mysqli_stmt_execute($stmt);
				                    $result = mysqli_stmt_get_result($stmt);
				                    $row = mysqli_fetch_assoc($result);
				                    
				                    // Set the image path; if no logo is found, use a default image
				                    $b_logo = !empty($row['b_logo']) ? "../Admin_Ipil/uploads/" . htmlspecialchars($row['b_logo']) : "assets/img/default_logo.png";
				                    
				                    mysqli_stmt_close($stmt);
				                } else {
				                    $b_logo = "assets/img/default_logo.png"; // Fallback if query fails
				                }
				            } else {
				                $b_logo = "assets/img/default_logo.png"; // Fallback if session is not set
				            }

				            // Close database connection
				            mysqli_close($conn);
				            ?>
            
                	</h6>
                    <center>
                    	<img src="<?php echo $b_logo; ?>"  class="rounded-circle mr-1" height="80" width="80"><br><br>	
                        <h6 class="m-0 font-weight-bold text-primary">Household List Report</h6>
                        <div class="card-body">
                            <div class="table-responsive">
                                <?php
include 'conn.php';

// Ensure result is initialized to avoid undefined variable error
$result = null;

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
                 ps.ps_name,
                 CONCAT(r.first_name, ' ', r.middle_name, ' ', r.last_name, 
                        IF(r.suffix_name = 'None' OR r.suffix_name IS NULL, '', CONCAT(' ', r.suffix_name))) AS full_name 
          FROM household h 
          JOIN residence r ON h.r_id = r.r_id 
          JOIN ps_list ps ON h.ps_list_id = ps.ps_list_id
          WHERE h.b_list_id = '$b_list_id'" . 
          ($status_filter ? " AND h.status = '$status_filter'" : "") . 
          " LIMIT $start, $limit";

$result = mysqli_query($conn, $query);
?>

<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Purok/Street Name</th>
                    <th>Household Number</th>
                    <th>Head of Family</th>
                    <th>Total Member of Household</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result && mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['h_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['ps_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['h_num']); ?></td>
                            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['t_member']); ?></td>
                            <td>
                                <div class="badge <?php echo ($row['status'] === 'Active Household') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">
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
                    </center>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center mt-4" id="printSaveButtonContainer">
        <button class="btn btn-primary" onclick="printAndSave()">Print & Save</button>
    </div>
</div>




    <script>
        function printAndSave() {
            // Create an HTML element to contain the printable content
            var printableElement = document.getElementById('reports-container');

            // Options for html2pdf
            var options = {
                margin: 10,
                filename: 'Purok_Street.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 2
                },
                jsPDF: {
                    unit: 'mm',
                    format: 'a4',
                    orientation: 'landscape'
                }
            };

            // Use html2pdf to generate the PDF and save it
            html2pdf(printableElement, options).then(function (pdf) {
                // Save the PDF using FileSaver.js
                
                window.print();
            });
        }
    </script>

</body>

</html>
<?php 
} else {
    header("Location: ../index.php");
    exit();
}
?>