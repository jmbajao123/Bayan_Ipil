<nav class="navbar navbar-expand-lg main-navbar">
        <form class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
          </ul>
          <div class="search-element">
            <!-- <div class="search-backdrop"></div>
            <div class="search-result">
              <div class="search-header">
                Histories
              </div>
              <div class="search-item">
                <a href="#">How to hack NASA using CSS</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">Kodinger.com</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-item">
                <a href="#">#Stisla</a>
                <a href="#" class="search-close"><i class="fas fa-times"></i></a>
              </div>
              <div class="search-header">
                Result
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png" alt="product">
                  oPhone S9 Limited Edition
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png" alt="product">
                  Drone X2 New Gen-7
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <img class="mr-3 rounded" width="30" src="assets/img/products/product-1-50.png" alt="product">
                  Headphone Blitz
                </a>
              </div>
              <div class="search-header">
                Projects
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-danger text-white mr-3">
                    <i class="fas fa-code"></i>
                  </div>
                  Stisla Admin Template
                </a>
              </div>
              <div class="search-item">
                <a href="#">
                  <div class="search-icon bg-primary text-white mr-3">
                    <i class="fas fa-laptop"></i>
                  </div>
                  Create a new Homepage Design
                </a>
              </div>
            </div> -->
          </div>
        </form>
        <ul class="navbar-nav navbar-right">
          <!-- <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
            <div class="dropdown-menu dropdown-list dropdown-menu-right">
              <div class="dropdown-header">Messages
                <div class="float-right">
                  <a href="#">Mark All As Read</a>
                </div>
              </div>
              <div class="dropdown-list-content dropdown-list-message">
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Kusnaedi</b>
                    <p>Hello, Bro!</p>
                    <div class="time">10 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Dedik Sugiharto</b>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item dropdown-item-unread">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="assets/img/avatar/avatar-3.png" class="rounded-circle">
                    <div class="is-online"></div>
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Agung Ardiansyah</b>
                    <p>Sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
                    <div class="time">12 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="assets/img/avatar/avatar-4.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Ardian Rahardiansyah</b>
                    <p>Duis aute irure dolor in reprehenderit in voluptate velit ess</p>
                    <div class="time">16 Hours Ago</div>
                  </div>
                </a>
                <a href="#" class="dropdown-item">
                  <div class="dropdown-item-avatar">
                    <img alt="image" src="assets/img/avatar/avatar-5.png" class="rounded-circle">
                  </div>
                  <div class="dropdown-item-desc">
                    <b>Alfa Zulkarnain</b>
                    <p>Exercitation ullamco laboris nisi ut aliquip ex ea commodo</p>
                    <div class="time">Yesterday</div>
                  </div>
                </a>
              </div>
              <div class="dropdown-footer text-center">
                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
              </div>
            </div>
          </li> -->
          <?php
include 'conn.php'; // Include database connection

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if session variable r_id exists
if (!isset($_SESSION['r_id'])) {
    echo '<div class="alert alert-danger">Session expired. Please log in again.</div>';
    exit();
}

// Retrieve session variable
$r_id = $_SESSION['r_id']; // Use r_id for the signed-in user

// Fetch all notifications based on approved or denied status for the logged-in r_id
$query = "SELECT r.first_name, r.middle_name, r.last_name, r.suffix_name, rc.status 
          FROM req_cert rc
          JOIN residence r ON rc.r_id = r.r_id
          WHERE rc.r_id = '$r_id' AND rc.status IN ('Approved', 'Denied')
          ORDER BY rc.rc_id DESC";

$result = mysqli_query($conn, $query);
$notification_count = mysqli_num_rows($result);
?>

<li class="dropdown dropdown-list-toggle">
    <a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg">
        <i class="far fa-bell"></i>
        <?php if ($notification_count > 0): ?>
            <span class="badge badge-danger"><?php echo $notification_count; ?></span>
        <?php endif; ?>
    </a>
    <div class="dropdown-menu dropdown-list dropdown-menu-right" style="width: 320px; max-height: 400px; overflow-y: auto;">
        <div class="dropdown-header">Notifications</div>
        <div class="dropdown-list-content dropdown-list-icons">
            <?php if ($notification_count > 0): ?>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <?php
                    // Set the notification message based on status
                    $status_message = ($row['status'] == 'Approved') ? 'Your certificate request has been Approved.' : 'Your certificate request has been Denied.';
                    
                    // Set background color based on status
                    $bg_class = ($row['status'] == 'Approved') ? 'bg-success' : 'bg-danger';
                    ?>
                    <a href="c_c.php" class="dropdown-item dropdown-item-unread">
                        <div class="dropdown-item-icon <?php echo $bg_class; ?> text-white">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="dropdown-item-desc">
                            <?php echo $status_message; ?>
                            <div class="time text-primary">Just Now</div>
                        </div>
                    </a>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="dropdown-item text-center">
                    No new notifications.
                </div>
            <?php endif; ?>
        </div>
    </div>
</li>

<?php
// Close database connection
mysqli_close($conn);
?>

          <li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
            <?php
// Include database connection
include 'conn.php';

// Check if the user is signed in and `r_id` is set in the session
if (isset($_SESSION['r_id'])) {
    $r_id = $_SESSION['r_id']; // Get the currently signed-in user's `r_id`

    // Query to fetch the user's profile picture (`profile`) from the `residence` table
    $query = "SELECT profile FROM residence WHERE r_id = ?";
    $stmt = mysqli_prepare($conn, $query);
    
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $r_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        $row = mysqli_fetch_assoc($result);
        
        // Set the profile image path; if no picture is found, use a default avatar
        $profile = !empty($row['profile']) ? "Barangay/uploads/" . htmlspecialchars($row['profile']) : "assets/img/default_avatar.png";
        
        mysqli_stmt_close($stmt);
    } else {
        $profile = "assets/img/default_avatar.png"; // Fallback if query fails
    }
} else {
    $profile = "assets/img/default_avatar.png"; // Fallback if session is not set
}

// Close database connection
mysqli_close($conn);
?>

<img src="<?php echo $profile; ?>" class="rounded-circle mr-1" alt="User Profile" height="35" width="60">
            <div class="d-sm-none d-lg-inline-block">
              <?php echo $_SESSION['email'] ?>
            </div></a>
            <div class="dropdown-menu dropdown-menu-right">
              <a href="profile.php" class="dropdown-item has-icon">
                <i class="far fa-user"></i> Profile
              </a>
              <div class="dropdown-divider"></div>
              <a href="#" class="dropdown-item has-icon text-danger" id="logoutBtn">
                  <i class="fas fa-sign-out-alt"></i> Sign Out
              </a>
              <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
              <script>
                  document.getElementById("logoutBtn").addEventListener("click", function(event) {
                      event.preventDefault(); // Prevent default link action

                      Swal.fire({
                          title: "Are you sure?",
                          text: "You will be signed out!",
                          icon: "warning",
                          showCancelButton: true,
                          confirmButtonColor: "#d33",
                          cancelButtonColor: "#3085d6",
                          confirmButtonText: "Sign Out",
                          cancelButtonText: "Cancel"
                      }).then((result) => {
                          if (result.isConfirmed) {
                              window.location.href = "sign_out.php"; // Redirect if confirmed
                          }
                      });
                  });
              </script>
            </div>
          </li>
        </ul>
      </nav>