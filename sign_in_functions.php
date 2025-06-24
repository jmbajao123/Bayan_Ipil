<?php
session_start();
include 'conn.php'; // Database connection

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>"; // Include SweetAlert

    // Retrieve and sanitize user input
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email) || empty($password)) {
        echo "<script>
            Swal.fire({
                icon: 'warning',
                title: 'Missing Fields',
                text: 'Please enter both email and password!',
                confirmButtonColor: '#ffc107'
            }).then(() => window.history.back());
        </script>";
        exit();
    }

    // Query to fetch user details
    $query = "SELECT u_id, email, password, user_type, b_list_id FROM user_type WHERE email = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verify the password
        if (password_verify($password, $row['password'])) {
            $_SESSION['u_id'] = $row['u_id'];
            $_SESSION['b_list_id'] = $row['b_list_id'];
            $_SESSION['email'] = $row['email'];
            $_SESSION['user_type'] = $row['user_type'];

            // Redirect based on user type with SweetAlert
            if ($row['user_type'] == "Barangay Account") {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        text: 'Welcome, Barangay Official!',
                        confirmButtonColor: '#28a745'
                    }).then(() => window.location.href='Barangay/dashboard.php');
                </script>";
            } elseif ($row['user_type'] == "Residence") {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Successful!',
                        text: 'Welcome, Resident!',
                        confirmButtonColor: '#28a745'
                    }).then(() => window.location.href='dashboard.php');
                </script>";
            } else {
                echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Access Denied!',
                        text: 'Invalid user type detected!',
                        confirmButtonColor: '#dc3545'
                    }).then(() => window.history.back());
                </script>";
            }
        } else {
            echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Incorrect Password!',
                    text: 'Please try again.',
                    confirmButtonColor: '#dc3545'
                }).then(() => window.history.back());
            </script>";
        }
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Account Not Found!',
                text: 'No user registered with this email.',
                confirmButtonColor: '#dc3545'
            }).then(() => window.history.back());
        </script>";
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
