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
    <title>Denied Request List Repor - Sibugay Tech Government Portal</title>
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
                        <h6 class="m-0 font-weight-bold text-primary"> Denied Request List Report</h6>
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