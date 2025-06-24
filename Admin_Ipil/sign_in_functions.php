<?php
session_start();
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['username']) && !empty($_POST['password'])) {

    function validate($data) {
        return htmlspecialchars(stripslashes(trim($data)));
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    // Prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        $_SESSION['password'] = $row['password'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['a_id'] = $row['a_id'];

        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Sign in Success!',
                    text: 'Welcome to Barangay Information System, Admin.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location = 'dashboard.php';
                });
            });
        </script>";
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Login Failed!',
                    text: 'Incorrect Username or Password!',
                    icon: 'error',
                    confirmButtonText: 'Try Again'
                }).then(() => {
                    window.location = 'index.php';
                });
            });
        </script>";
    }

    $stmt->close();
    $conn->close();
    exit();

} else {
    header("Location: index.php");
    exit();
}
?>
