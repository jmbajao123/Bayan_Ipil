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
    <title>Barangay Clearance - Barangay Information System</title>
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
        <div class="col-lg-12">
            <div class="row">
                <div class="card-body">
                    <div class="col-lg-12">
                        <div class="row">
                            <div class="col-lg-12 d-flex  justify-content-center">
                                <?php
                                include 'conn.php';

                                $b_logo = "assets/img/default_logo.png"; // Default logo
                                $barangay_name = ""; // Default barangay name

                                if (isset($_SESSION['b_list_id'])) {
                                    $b_list_id = $_SESSION['b_list_id'];

                                    $query = "SELECT b_logo, barangay_name FROM b_list WHERE b_list_id = ?";
                                    $stmt = mysqli_prepare($conn, $query);

                                    if ($stmt) {
                                        mysqli_stmt_bind_param($stmt, "i", $b_list_id);
                                        mysqli_stmt_execute($stmt);
                                        $result = mysqli_stmt_get_result($stmt);

                                        if ($row = mysqli_fetch_assoc($result)) {
                                            if (!empty($row['b_logo'])) {
                                                $b_logo = "../Admin_Ipil/uploads/" . htmlspecialchars($row['b_logo']);
                                            }
                                            $barangay_name = htmlspecialchars($row['barangay_name']);
                                        }

                                        mysqli_stmt_close($stmt);
                                    }
                                }
                                ?>
                                <div class="me-4">
                                    <img src="<?php echo $b_logo; ?>" height="100" width="100" style="margin-left: -200px;">
                                </div>
                                <div class="text-center">
                                    <span>Republic of the Philippines</span><br>
                                    <h6 class="mb-1">PROVINCE OF ZAMBOANGA SIBUGAY</h6>
                                    <h5 class="fw-bold mb-1">Municipality of Ipil</h5>
                                    <h5 class="fw-bold mb-1">Barangay <?php echo $barangay_name; ?></h5>
                                    <span>= o000000o =</span>
                                    <h3>OFFICE OF THE BARANGAY CAPTAIN</h3>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <br>
                            </div>
                            <div class="col-lg-12 d-flex ">
                                <div class="me-2" style="margin-left: -70px">
                                    <?php
                                        // Assuming you have a database connection established
                                        $query = "
                                            SELECT b_officials.first_name, b_officials.middle_name, b_officials.last_name, b_officials.suffix_name, 
                                                   b_positions.position_name
                                            FROM b_officials 
                                            LEFT JOIN b_positions ON b_officials.b_positions_id = b_positions.b_positions_id
                                        ";  
                                        $result = mysqli_query($conn, $query);

                                        $non_kagawads = [];
                                        $kagawads = [];
                                        $secretary = [];
                                        $treasurer = [];

                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $position = strtolower(trim($row['position_name']));

                                            if ($position === 'kagawad') {
                                                $kagawads[] = $row;
                                            } elseif ($position === 'barangay secretary') {
                                                $secretary[] = $row;
                                            } elseif ($position === 'barangay treasurer') {
                                                $treasurer[] = $row;
                                            } else {
                                                $non_kagawads[] = $row;
                                            }
                                        }
                                        ?>

                                        <div class="p-3" style="border: 3px solid black;">
                                            <h6 style="font-weight: bold; text-decoration: underline;">BARANGAY OFFICIALS</h6>

                                            <?php foreach ($non_kagawads as $row): ?>
                                                <center>
                                                    <h6 style="font-weight: bold;">
                                                        HON. 
                                                        <?php
                                                            echo htmlspecialchars($row['first_name']) . ' ' .
                                                                 htmlspecialchars($row['middle_name']) . ' ' .
                                                                 htmlspecialchars($row['last_name']);
                                                            if ($row['suffix_name'] !== 'None' && !empty($row['suffix_name'])) {
                                                                echo ' ' . htmlspecialchars($row['suffix_name']);
                                                            }
                                                        ?>
                                                    </h6>
                                                    <p><?php echo htmlspecialchars($row['position_name']); ?></p>
                                                </center>
                                            <?php endforeach; ?>

                                            <?php if (!empty($kagawads)): ?>
                                                <h6 style="font-weight: bold;">KAGAWADS:</h6>
                                                <center>
                                                    <?php foreach ($kagawads as $row): ?>
                                                        <p>
                                                            <?php
                                                                echo htmlspecialchars($row['first_name']) . ' ' .
                                                                     htmlspecialchars($row['middle_name']) . ' ' .
                                                                     htmlspecialchars($row['last_name']);
                                                                if ($row['suffix_name'] !== 'None' && !empty($row['suffix_name'])) {
                                                                    echo ' ' . htmlspecialchars($row['suffix_name']);
                                                                }
                                                            ?>
                                                        </p>
                                                    <?php endforeach; ?>
                                                </center>
                                                <div class="col-lg-12"><br></div>
                                            <?php endif; ?>

                                            <?php if (!empty($secretary)): ?>
                                                
                                                <center>
                                                    <h6 style="font-weight: bold;">
                                                    <?php foreach ($secretary as $row): ?>
                                                        <p>
                                                            <?php
                                                                echo htmlspecialchars($row['first_name']) . ' ' .
                                                                     htmlspecialchars($row['middle_name']) . ' ' .
                                                                     htmlspecialchars($row['last_name']);
                                                                if ($row['suffix_name'] !== 'None' && !empty($row['suffix_name'])) {
                                                                    echo ' ' . htmlspecialchars($row['suffix_name']);
                                                                }
                                                            ?>
                                                        </p>
                                                    <?php endforeach; ?>
                                                </h6>
                                                    BARANGAY SECRETARY:
                                                    
                                                </center>
                                                <div class="col-lg-12"><br></div>
                                            <?php endif; ?>

                                            <?php if (!empty($treasurer)): ?>
                                                <center>
                                                    <h6 style="font-weight: bold;"><?php foreach ($treasurer as $row): ?>
                                                        <p>
                                                            <?php
                                                                echo htmlspecialchars($row['first_name']) . ' ' .
                                                                     htmlspecialchars($row['middle_name']) . ' ' .
                                                                     htmlspecialchars($row['last_name']);
                                                                if ($row['suffix_name'] !== 'None' && !empty($row['suffix_name'])) {
                                                                    echo ' ' . htmlspecialchars($row['suffix_name']);
                                                                }
                                                            ?>
                                                        </p>
                                                    <?php endforeach; ?></h6>

                                                    BARANGAY TREASURER:
                                                </center>
                                            <?php endif; ?>
                                            <div class="col-lg-12">
                                                <br>
                                            </div>
                                            <h6 style="font-weight: bold;">CTC NO. :  _______________</h6>
                                            <span>Date Issued ____________</span><br>
                                            <span>Place Issued ___________</span>
                                            <div class="col-lg-12">
                                                <br>
                                            </div>
                                            <h6 style="font-weight: bold;">
                                                OR NO. : ________________
                                            </h6>
                                            <span>Amount Paid: ____________</span><br>
                                            <span>Date Paid: _______________</span>
                                        </div>
                                </div>
                                <div class="col-lg-8">
                                    <div class="me-2">
                                    <div class="p-2" style="border: 2px solid black;">
                                        <div class="col-lg-12">
                                            <br>
                                        </div>
                                            <center>
                                                <h4 style="font-weight: bold;"> BARANGAY CLEARANCE</h4>
                                            </center>
                                            <div class="col-lg-12">
                                                <br>
                                            </div>
                                           <?php
                                            $clearance_no_numeric = 1; // Example: you can fetch this from DB
                                            $clearance_no_padded = str_pad($clearance_no_numeric, 10, "0", STR_PAD_LEFT);

                                            // Remove leading zeros (show from the first non-zero digit)
                                            $clearance_no = ltrim($clearance_no_padded, "0");
                                            ?>

                                            <span style="float: right; font-size: 25px;">
                                                Clearance No.:
                                                <span style="text-decoration: underline;"><?php echo $clearance_no; ?></span>
                                            </span>
                                            <div class="col-lg-12">
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                            <?php
                                                // Assume $rc_id is already defined (e.g., from GET or POST)
                                                $rc_id = $_GET['rc_id'];

                                                include 'conn.php';

                                                if (!$conn) {
                                                    die("Connection failed: " . mysqli_connect_error());
                                                }

                                                // Step 1: Fetch r_id from req_cert table
                                                $sql = "SELECT r_id FROM req_cert WHERE rc_id = '$rc_id'";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_assoc($result);

                                                $full_name = '______________________________';
                                                $purok = '_____________';  // default if no ps_list_id found

                                                if ($row) {
                                                    $r_id = $row['r_id'];

                                                    // Step 2: Fetch name fields and ps_list_id from residence table
                                                    $sql2 = "SELECT first_name, middle_name, last_name, suffix_name, ps_list_id FROM residence WHERE r_id = '$r_id'";
                                                    $result2 = mysqli_query($conn, $sql2);
                                                    $resRow = mysqli_fetch_assoc($result2);

                                                    if ($resRow) {
                                                        $first = $resRow['first_name'];
                                                        $middle = $resRow['middle_name'];
                                                        $last = $resRow['last_name'];
                                                        $suffix = trim($resRow['suffix_name']);
                                                        $ps_list_id = $resRow['ps_list_id'];

                                                        // Build full name
                                                        $full_name = $first . ' ' . $middle . ' ' . $last;
                                                        if (strcasecmp($suffix, 'None') !== 0 && $suffix !== '') {
                                                            $full_name .= ' ' . $suffix;
                                                        }

                                                        // Use ps_list_id for Purok
                                                        $purok = htmlspecialchars($ps_list_id);
                                                    }
                                                }
                                            ?>
                                            <span class="text-center" style="font-size: 20px;">
                                                    This is to certify that <u><?php echo htmlspecialchars($full_name); ?></u> of legal age, <br>
                                                    single/married/annuled/separated, a resident of Purok <u><?php echo $purok; ?></u><br>
                                                    Ipil Heights, Ipil, Zamboanga Sibugay is person of good moral character and a law abiding citizen in the community, and as per record of this office, has no DEROGATORY record/s in this Office up to this date.
                                            </span>
                                            <div class="col-lg-12">
                                                <br>
                                                <br>
                                                <br>
                                            </div>
                                            <?php
                                                // Assume $rc_id is already defined (e.g., from GET or POST)
                                                $rc_id = $_GET['rc_id'];

                                                include 'conn.php';

                                                if (!$conn) {
                                                    die("Connection failed: " . mysqli_connect_error());
                                                }

                                                // Step 1: Fetch r_id and purpose from req_cert table based on rc_id
                                                $sql = "SELECT r_id, purpose FROM req_cert WHERE rc_id = '$rc_id'";
                                                $result = mysqli_query($conn, $sql);
                                                $row = mysqli_fetch_assoc($result);

                                                $purpose = '__________________________'; // default if no data

                                                if ($row) {
                                                    $r_id = $row['r_id'];
                                                    if (!empty($row['purpose'])) {
                                                        $purpose = htmlspecialchars($row['purpose']);
                                                    }
                                                }
                                            ?>
                                                <span class="text-center" style="font-size: 20px;">
                                                    Given this <u><?php echo date('j'); ?></u> day of <u><?php echo date('F'); ?></u>, <u><?php echo date('Y'); ?></u> at
                                                    Ipil Heights, Ipil, Zamboanga Sibugay, Philippines.
                                                    <br><br>
                                                    Purpose : <u><?php echo $purpose; ?></u>
                                                </span>

                                            <div class="col-lg-12">
                                                <br><br>
                                            </div>
                                            <span style="float:right;">
                                                <?php
                                                // Assuming you have a database connection established
                                                $query = "
                                                    SELECT b_officials.first_name, b_officials.middle_name, b_officials.last_name, b_officials.suffix_name, 
                                                           b_positions.position_name
                                                    FROM b_officials 
                                                    LEFT JOIN b_positions ON b_officials.b_positions_id = b_positions.b_positions_id
                                                ";  
                                                $result = mysqli_query($conn, $query);

                                                $punong_barangays = [];

                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    $position = strtolower(trim($row['position_name']));
                                                    if ($position === 'punong barangay') {
                                                        $punong_barangays[] = $row;
                                                    }
                                                }
                                                ?>

                                                <!-- Display only Punong Barangay -->
                                                <?php if (!empty($punong_barangays)): ?>
                                                    <div style="text-align:center; margin-bottom: 30px;">
                                                        <?php foreach ($punong_barangays as $row): ?>
                                                            <h6 style="font-weight: bold; margin-bottom: 5px;">
                                                                <u>
                                                                <?php
                                                                    echo htmlspecialchars($row['first_name']) . ' ' .
                                                                         htmlspecialchars($row['middle_name']) . ' ' .
                                                                         htmlspecialchars($row['last_name']);
                                                                    if (strcasecmp($row['suffix_name'], 'None') !== 0 && !empty(trim($row['suffix_name']))) {
                                                                        echo ' ' . htmlspecialchars($row['suffix_name']);
                                                                    }
                                                                ?>
                                                                </u>
                                                            </h6>
                                                            <p style="margin-top: 0; margin-bottom: 20px; font-style: italic;">
                                                                <?php echo htmlspecialchars($row['position_name']); ?>
                                                            </p>
                                                        <?php endforeach; ?>
                                                    </div>
                                                <?php else: ?>
                                                    <p style="text-align:center;">No Punong Barangay found.</p>
                                                <?php endif; ?>
                                            </span>
                                            <div class="col-lg-12">
                                                <br><br>
                                                <br><br>
                                            </div>
                                            <span style="float: left;">
                                                _____________________________<br>
                                                <center>
                                                    Applicant's Signature
                                                </center>   
                                            </span>
                                            <div class="col-lg-12">
                                                <br><br>
                                                <br><br>
                                            </div>
                                            <span class="text-center">
                                                <center>
                                                    (  ) Voter ( ) Non-Voter
                                                </center>    
                                            </span>
                                            <div class="col-lg-12">
                                                <br><br>
                                            </div>
                                        </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <script>
function filterStatus() {
    var status = document.getElementById("statusFilter").value;
    window.location.href = "?status=" + status;
}
</script>
                     <!-- <?php include 'print_script.php'; ?> -->
                    <?php
                    // Close connection
                    mysqli_close($conn);
                    ?>
                    <div class="text-center mt-4" id="printSaveButtonContainer">
            <button class="btn btn-primary" onclick="printAndSave()">Save</button>
        </div>
                </div>

            </div>
        </div>
    </div>




    <script>
        function printAndSave() {
            // Create an HTML element to contain the printable content
            var printableElement = document.getElementById('reports-container');

            // Options for html2pdf
            var options = {
                margin: 10,
                filename: 'clearance.pdf',
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