<?php ?>
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
    <title>Barangay List - Sibugay Tech Government Portal</title>
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
                        <h6 class="m-0 font-weight-bold text-primary">Barangay List Report</h6>
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
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php
include 'conn.php';

// Fetch data from b_list table
$sql = "SELECT b_list_id, barangay_name, b_code, email, status, b_logo FROM b_list";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0):
    while ($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['b_list_id']); ?></td>
            <td><?php echo htmlspecialchars($row['barangay_name']); ?></td>
            <td><?php echo htmlspecialchars($row['b_code']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td>
                <img src="uploads/<?php echo htmlspecialchars($row['b_logo']); ?>" 
                     alt="Barangay Logo" 
                     style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
            </td>
            <td>
                <div class="badge 
                    <?php echo ($row['status'] === 'Active') ? 'badge-success' : 'badge-danger'; ?>">
                    <?php echo htmlspecialchars($row['status']); ?>
                </div>
            </td>
            
        </tr>
    <?php endwhile;
else: ?>
    <tr>
        <td colspan="6" class="text-center">No positions found</td>
    </tr>
<?php endif;

// Close connection
mysqli_close($conn);
?>

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
                filename: 'Barangay_List.pdf',
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