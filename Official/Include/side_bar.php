<aside id="sidebar-wrapper">
          <div class="sidebar-brand" style="margin-top: 30px;">
            <a href="dashboard.php">
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

<img src="<?php echo $b_logo; ?>" height="80" width="80" class="align-center">



            </a>
          </div>
          <div class="sidebar-brand sidebar-brand-sm">
            <a href="dashboard.php">
              <!-- <img src="assets/img/ip.png" height="50" width="50" class="align-center"> -->
            </a>
          </div>
          <ul class="sidebar-menu">
            <li class="menu-header">
              <br><br>
            </li>
            <li><a class="nav-link" href="dashboard.php"><i class="fas fa-building"></i> <span>Dashboard</span></a></li>
            <li><a class="nav-link" href="officials.php"><i class="fas fa-users"></i> <span>Barangay Officials</span></a></li>
            <li><a class="nav-link" href="p_s.php"><i class="fas fa-road"></i> <span>Purok/Street</span></a></li>
            <li><a class="nav-link" href="resident.php"><i class="fas fa-users"></i> <span>Residence</span></a></li>
            <li><a class="nav-link" href="household.php"><i class="fas fa-home"></i> <span>Household</span></a></li>
            <!-- <li><a class="nav-link" href="req.php"><i class="fas fa-envelope"></i> <span>Resident Request</span></a></li> -->
            <!-- <li><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li> -->
            <!-- <li class="dropdown">
              <a href="#" class="nav-link has-dropdown"><i class="fas fa-landmark"></i> <span>Barangay</span></a>
              <ul class="dropdown-menu">
                <li><a class="nav-link" href="b_p.php">Barangay Positions</a></li>
                <li><a class="nav-link" href="b_l.php">Barangay List</a></li>
                <li><a class="nav-link" href="b_o.php">Barangay Officials</a></li>
              </ul>
            </li> -->
            <!-- <li class="menu-header">
              <center>
                Reports
              </center>
            </li> -->
            <!-- <li><a class="nav-link" href="r_off.php"><i class="fas fa-file-alt"></i> <span>Officials Report</span></a></li> -->
            <!-- <li><a class="nav-link" href="r_ps.php"><i class="fas fa-file-alt"></i> <span>Purok/Street Report</span></a></li>
            <li><a class="nav-link" href="r_r.php"><i class="fas fa-file-alt"></i> <span>Resident Report</span></a></li>
            <li><a class="nav-link" href="r_h.php"><i class="fas fa-file-alt"></i> <span>Household Report</span></a></li>
            <li><a class="nav-link" href="# "><i class="fas fa-file-alt"></i> <span>Request Report</span></a></li> -->
          </aside>