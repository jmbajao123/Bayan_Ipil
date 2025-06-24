<?php
session_start(); 
include 'conn.php';
if (isset($_SESSION['username']) && isset($_SESSION['a_id']) && ($_SESSION['password']) ) {
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
    <title>Barangay Officials - Sibugay Tech Government Portal</title>
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
                    <center> 
                        <h6 class="m-0 font-weight-bold text-primary">Barangay Officials Report</h6>
                        <div class="card-body">
                            <div class="table-responsive">
                               <?php
// Define how many results per page
$limit = 10;

// Get the current page number from the URL, default to 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1

// Calculate the starting row for the query
$start = ($page - 1) * $limit;

// Count total rows in `b_officials` to calculate total pages
$total_query = "SELECT COUNT(*) AS total FROM b_officials";
$total_result = mysqli_query($conn, $total_query);
$total_row = mysqli_fetch_assoc($total_result);
$total_records = $total_row['total'];
$total_pages = ceil($total_records / $limit);

// Fetch data with JOINs and pagination
$query = "SELECT b_officials.b_officials_id, 
                 b_list.barangay_name, 
                 b_positions.position_name, 
                 b_officials.first_name, 
                 b_officials.middle_name, 
                 b_officials.last_name, 
                 b_officials.suffix_name, 
                 b_officials.status,
                 b_officials.profile 
          FROM b_officials
          JOIN b_list ON b_officials.b_list_id = b_list.b_list_id
          JOIN b_positions ON b_officials.b_positions_id = b_positions.b_positions_id
          LIMIT $start, $limit";

$result = mysqli_query($conn, $query);
?>
<div class="card-body">
    <div class="table-responsive">
        <table class="table table-bordered table-md">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Barangay Name</th>
                    <th>Barangay Position</th>
                    <th>Official Name</th>
                    <th>Profile</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (mysqli_num_rows($result) > 0): 
                    while ($row = mysqli_fetch_assoc($result)): 
                        $full_name = trim(
                            $row['first_name'] . " " . 
                            (!empty($row['middle_name']) ? $row['middle_name'] . " " : "") . 
                            $row['last_name'] . 
                            (($row['suffix_name'] !== "None" && !empty($row['suffix_name'])) ? " " . $row['suffix_name'] : "")
                        );
                        $profile_img = !empty($row['profile']) ? "officials/" . htmlspecialchars($row['profile']) : "default_profile.png";
                ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['b_officials_id']); ?></td>
                            <td><?php echo htmlspecialchars($row['barangay_name']); ?></td>
                            <td><?php echo htmlspecialchars($row['position_name']); ?></td>
                            <td><?php echo htmlspecialchars($full_name); ?></td>
                            <td><img src="<?php echo $profile_img; ?>" alt="Profile" width="50" height="50" class="rounded-circle"></td>
                            <td>
                                <div class="badge <?php echo ($row['status'] === 'Active Officials') ? 'badge-success' : 'badge-danger'; ?>">
                                    <?php echo htmlspecialchars($row['status']); ?>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; 
                else: ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            <h4>No Barangay Officials Found</h4>
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-- Pagination Section -->
                                    
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
                filename: 'Barangay_Officials.pdf',
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
}else{
    header("Location: index.php");
    exit();
}

?>