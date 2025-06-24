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

<body >
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
                            <div class="col-lg-12">
                                <center>
                                    <h4 style="font-weight: bold;"> Barangay Business Permit</h4>
                                </center>
                                <br><br>
                                <div class="row">
                                    <div class="col-lg-4">
                                        <?php
                                            // Assume $rc_id is already defined (e.g., from GET or POST)
                                            $rc_id = $_GET['rc_id'];

                                            include 'conn.php';

                                            if (!$conn) {
                                                die("Connection failed: " . mysqli_connect_error());
                                            }

                                            // Initialize default placeholders
                                            $full_name = '______________________________';
                                            $purok = '_____________';
                                            $barangay = '________________';
                                            $date_birth_formatted = '____________________';
                                            $nationality = '________________';
                                            $purpose = '____________________';

                                            // Step 1: Fetch r_id and purpose from req_cert table
                                            $sql = "SELECT r_id, purpose FROM req_cert WHERE rc_id = '$rc_id'";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);

                                            if ($row) {
                                                $r_id = $row['r_id'];
                                                $purpose = htmlspecialchars($row['purpose']); // sanitize purpose output

                                                // Step 2: Fetch data from residence table
                                                $sql2 = "SELECT first_name, middle_name, last_name, suffix_name, date_birth, nationality, ps_list_id, b_list_id FROM residence WHERE r_id = '$r_id'";
                                                $result2 = mysqli_query($conn, $sql2);
                                                $resRow = mysqli_fetch_assoc($result2);

                                                if ($resRow) {
                                                    $first = $resRow['first_name'];
                                                    $middle = $resRow['middle_name'];
                                                    $last = $resRow['last_name'];
                                                    $suffix = trim($resRow['suffix_name']);
                                                    $date_birth = trim($resRow['date_birth']);
                                                    $nationality = trim($resRow['nationality']);
                                                    $ps_list_id = $resRow['ps_list_id'];
                                                    $b_list_id = $resRow['b_list_id'];

                                                    // Build full name
                                                    $full_name = $first . ' ' . $middle . ' ' . $last;
                                                    if (strcasecmp($suffix, 'None') !== 0 && $suffix !== '') {
                                                        $full_name .= ' ' . $suffix;
                                                    }

                                                    // Format date of birth
                                                    if (!empty($date_birth)) {
                                                        $date_birth_formatted = date("F j, Y", strtotime($date_birth));
                                                    }

                                                    // Step 3: Fetch ps_name from ps_list
                                                    $sql3 = "SELECT ps_name FROM ps_list WHERE ps_list_id = '$ps_list_id'";
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    $psRow = mysqli_fetch_assoc($result3);
                                                    if ($psRow && !empty($psRow['ps_name'])) {
                                                        $purok = htmlspecialchars($psRow['ps_name']);
                                                    }

                                                    // Step 4: Fetch barangay_name from b_list
                                                    $sql4 = "SELECT barangay_name FROM b_list WHERE b_list_id = '$b_list_id'";
                                                    $result4 = mysqli_query($conn, $sql4);
                                                    $bRow = mysqli_fetch_assoc($result4);
                                                    if ($bRow && !empty($bRow['barangay_name'])) {
                                                        $barangay = htmlspecialchars($bRow['barangay_name']);
                                                    }
                                                }
                                            }
                                            ?>
                                        <span>
                                            Nature of Business: 
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                         <center><span style="align-content: center; font-weight: bold;"><?php echo $purpose; ?></span></center>
                                    </div>
                                    <div class="col-lg-12">
                                        <br>
                                    </div>
                                    <div class="col-lg-4">
                                        <span>
                                            Proprietor: 
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <center>
                                            <span style="align-content: center; font-weight: bold;"><?php echo $full_name; ?></span>
                                        </center>
                                    </div>
                                    <div class="col-lg-4">
                                        <br>
                                    </div>
                                    <div class="col-lg-4">
                                        <?php
                                    include 'conn.php';
                                    $barangay_id = $_SESSION['b_list_id']; // current barangay ID
                                    $current_year_suffix = date("y"); // e.g., '25' for year 2025

                                    // Get the last permit number for this barangay
                                    $query = "SELECT COUNT(*) as total FROM req_cert WHERE b_list_id = ?";
                                    $stmt = mysqli_prepare($conn, $query);
                                    mysqli_stmt_bind_param($stmt, "i", $barangay_id);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    $next_number = 1;
                                    if ($row = mysqli_fetch_assoc($result)) {
                                        $next_number = $row['total'] + 1; // Increment for new request
                                    }

                                    $permit_number = str_pad($next_number, 3, '0', STR_PAD_LEFT) . '-' . $current_year_suffix;
                                    ?>

                                    <!-- Output -->
                                    <span>
                                        Permit Number: 
                                    </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <center>
                                            <span style="align-content: center; font-weight: bold;"><?php echo $permit_number; ?></span>
                                        </center>
                                    </div>
                                    <div class="col-lg-4">
                                        <br>
                                    </div>
                                    <div class="col-lg-4">
                                        <span>
                                            Address: 
                                        </span> 
                                    </div>
                                    <div class="col-lg-4">
                                        <center>
                                            <span style="align-content: center; font-weight: bold;"><?php echo $barangay_name; ?></span>
                                        </center>
                                    </div>
                                    <div class="col-lg-4">
                                        <span>
                                            Valid Unit: 
                                           <span style="align-content: center; font-weight: bold;"><?php echo $barangay_name; ?></span> 
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <span>
                                            Business Location: 
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <center><span style="align-content: center; font-weight: bold;"><?php echo $barangay_name; ?></span></center>
                                    </div>
                                    <div class="col-lg-4">
                                        <span>
                                            Amount Paid: <span style="align-content: center; font-weight: bold;">Php 100.00</span>
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <span>
                                            Status: 
                                        </span>
                                    </div>
                                    <div class="col-lg-4">
                                        <center>
                                            <span style="align-content: center; font-weight: bold;">
                                            Operating
                                        </span>
                                        </center>
                                    </div>
                                </div>
								<br><br>
                                <p>
                                    <?php
                                    // Assume $rc_id is already defined (e.g., from GET or POST)
                                    $rc_id = $_GET['rc_id'];

                                    include 'conn.php';

                                    if (!$conn) {
                                        die("Connection failed: " . mysqli_connect_error());
                                    }

                                    // Initialize default placeholders
                                    $full_name = '______________________________';
                                    $purok = '_____________';
                                    $barangay = '________________';
                                    $date_birth_formatted = '____________________';
                                    $nationality = '________________';
                                    $purpose = '____________________';

                                    // Step 1: Fetch r_id and purpose from req_cert table
                                    $sql = "SELECT r_id, purpose FROM req_cert WHERE rc_id = '$rc_id'";
                                    $result = mysqli_query($conn, $sql);
                                    $row = mysqli_fetch_assoc($result);

                                    if ($row) {
                                        $r_id = $row['r_id'];
                                        $purpose = htmlspecialchars($row['purpose']); // sanitize purpose output

                                        // Step 2: Fetch data from residence table
                                        $sql2 = "SELECT first_name, middle_name, last_name, suffix_name, date_birth, nationality, ps_list_id, b_list_id FROM residence WHERE r_id = '$r_id'";
                                        $result2 = mysqli_query($conn, $sql2);
                                        $resRow = mysqli_fetch_assoc($result2);

                                        if ($resRow) {
                                            $first = $resRow['first_name'];
                                            $middle = $resRow['middle_name'];
                                            $last = $resRow['last_name'];
                                            $suffix = trim($resRow['suffix_name']);
                                            $date_birth = trim($resRow['date_birth']);
                                            $nationality = trim($resRow['nationality']);
                                            $ps_list_id = $resRow['ps_list_id'];
                                            $b_list_id = $resRow['b_list_id'];

                                            // Build full name
                                            $full_name = $first . ' ' . $middle . ' ' . $last;
                                            if (strcasecmp($suffix, 'None') !== 0 && $suffix !== '') {
                                                $full_name .= ' ' . $suffix;
                                            }

                                            // Format date of birth
                                            if (!empty($date_birth)) {
                                                $date_birth_formatted = date("F j, Y", strtotime($date_birth));
                                            }

                                            // Step 3: Fetch ps_name from ps_list
                                            $sql3 = "SELECT ps_name FROM ps_list WHERE ps_list_id = '$ps_list_id'";
                                            $result3 = mysqli_query($conn, $sql3);
                                            $psRow = mysqli_fetch_assoc($result3);
                                            if ($psRow && !empty($psRow['ps_name'])) {
                                                $purok = htmlspecialchars($psRow['ps_name']);
                                            }

                                            // Step 4: Fetch barangay_name from b_list
                                            $sql4 = "SELECT barangay_name FROM b_list WHERE b_list_id = '$b_list_id'";
                                            $result4 = mysqli_query($conn, $sql4);
                                            $bRow = mysqli_fetch_assoc($result4);
                                            if ($bRow && !empty($bRow['barangay_name'])) {
                                                $barangay = htmlspecialchars($bRow['barangay_name']);
                                            }
                                        }
                                    }
                                    ?>
                                    <span style="margin-left: 100px">
                                        This Permit is being issued subject to existing rules and regulations, provided however, that the necessary fees are paid to the Treasurer of the Barangay as assessed. 
                                    </span>
                                    </p>
                                    <br>
                                    <p>
                                        <span style="margin-left: 50px"> 
                                           This is non-transferable and shall be deemed null and void upon failure by the owner to follow the said rules and regulations set forth by the Local Government Unitof Basey.
                                        </span>
                                    </p>
                                    <br>
                                    <p>
                                        <span style="margin-left: 50px;">
                                            <?php
                                            // Function to add ordinal suffix to day
                                            function ordinal_suffix($num) {
                                                if (!in_array(($num % 100), array(11,12,13))){
                                                    switch ($num % 10){
                                                        case 1:  return $num.'st';
                                                        case 2:  return $num.'nd';
                                                        case 3:  return $num.'rd';
                                                    }
                                                }
                                                return $num.'th';
                                            }

                                            $day = ordinal_suffix(date('j'));
                                            $month = date('F');
                                            $year = date('Y');
                                            echo "Given this {$day} day of {$month}, {$year}, at Barangay {$barangay}, Ipil, Zamboanga Sibugay.";
                                            ?>
                                        </span>
                                    </p>
                                    <br><br>
                                    <p>
                                        <div style="text-align: center; margin-left: 550px;">
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

                                            <?php if (!empty($punong_barangays)): ?>
                                                <?php foreach ($punong_barangays as $row): ?>
                                                    <p style="font-weight: bold; margin-bottom: 5px;">
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
                                                    </p>
                                                    <p style="margin-top: 0; font-style: italic;">
                                                        <?php echo htmlspecialchars($row['position_name']); ?>
                                                    </p>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </div>
                                    </p>
                                    <p>
                                        <div style="margin-left: 100px;">
                                            <?php
                                            // Assume $rc_id is already defined (e.g., from GET or POST)
                                            $rc_id = $_GET['rc_id'];

                                            include 'conn.php';

                                            if (!$conn) {
                                                die("Connection failed: " . mysqli_connect_error());
                                            }

                                            // Initialize default placeholders
                                            $full_name = '______________________________';
                                            $purok = '_____________';
                                            $barangay = '________________';
                                            $date_birth_formatted = '____________________';
                                            $nationality = '________________';
                                            $purpose = '____________________';

                                            // Step 1: Fetch r_id and purpose from req_cert table
                                            $sql = "SELECT r_id, purpose FROM req_cert WHERE rc_id = '$rc_id'";
                                            $result = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($result);

                                            if ($row) {
                                                $r_id = $row['r_id'];
                                                $purpose = htmlspecialchars($row['purpose']); // sanitize purpose output

                                                // Step 2: Fetch data from residence table
                                                $sql2 = "SELECT first_name, middle_name, last_name, suffix_name, date_birth, nationality, ps_list_id, b_list_id FROM residence WHERE r_id = '$r_id'";
                                                $result2 = mysqli_query($conn, $sql2);
                                                $resRow = mysqli_fetch_assoc($result2);

                                                if ($resRow) {
                                                    $first = $resRow['first_name'];
                                                    $middle = $resRow['middle_name'];
                                                    $last = $resRow['last_name'];
                                                    $suffix = trim($resRow['suffix_name']);
                                                    $date_birth = trim($resRow['date_birth']);
                                                    $nationality = trim($resRow['nationality']);
                                                    $ps_list_id = $resRow['ps_list_id'];
                                                    $b_list_id = $resRow['b_list_id'];

                                                    // Build full name
                                                    $full_name = $first . ' ' . $middle . ' ' . $last;
                                                    if (strcasecmp($suffix, 'None') !== 0 && $suffix !== '') {
                                                        $full_name .= ' ' . $suffix;
                                                    }

                                                    // Format date of birth
                                                    if (!empty($date_birth)) {
                                                        $date_birth_formatted = date("F j, Y", strtotime($date_birth));
                                                    }

                                                    // Step 3: Fetch ps_name from ps_list
                                                    $sql3 = "SELECT ps_name FROM ps_list WHERE ps_list_id = '$ps_list_id'";
                                                    $result3 = mysqli_query($conn, $sql3);
                                                    $psRow = mysqli_fetch_assoc($result3);
                                                    if ($psRow && !empty($psRow['ps_name'])) {
                                                        $purok = htmlspecialchars($psRow['ps_name']);
                                                    }

                                                    // Step 4: Fetch barangay_name from b_list
                                                    $sql4 = "SELECT barangay_name FROM b_list WHERE b_list_id = '$b_list_id'";
                                                    $result4 = mysqli_query($conn, $sql4);
                                                    $bRow = mysqli_fetch_assoc($result4);
                                                    if ($bRow && !empty($bRow['barangay_name'])) {
                                                        $barangay = htmlspecialchars($bRow['barangay_name']);
                                                    }
                                                }
                                            }
                                            ?>
                                                    <p style="font-weight: bold; margin-bottom: 5px;">
                                                        <u>
                                                        <?php echo $full_name; ?>
                                                        </u>
                                                    </p>
                                                    <p style="margin-top: 0; font-style: italic;">
                                                        Owner
                                                    </p>
                                                     <br><br>
                                                    <p>
                                                        <span>
                                                            CTC # : 
                                                        </span>
                                                        <br>
                                                        <span>
                                                            Issued on : 
                                                        </span>
                                                        <br>
                                                        <span>
                                                           Issued at : 
                                                        </span>
                                                        <br>
                                                        <span>
                                                            OR # : 
                                                        </span>
                                                        <br>
                                                        <span>
                                                            Issued on : 
                                                        </span> 
                                                    </p>
                                        </div>
                                        <center>
                                            <p>(This License, while in force, shall be posted in a conspicous place in the business premisses)</p>
                                        </center>
                                    </p>
                            </div>
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