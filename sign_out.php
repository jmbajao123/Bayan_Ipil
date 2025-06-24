<?php
    session_start();
    $_SESSION = array();
    session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logging Out</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <script>
        Swal.fire({
            title: "Signed Out!",
            html: "You have been signed out successfully.<br><b>Thank you and Come Again.</b>",
            icon: "success",
            showConfirmButton: false,
            timer: 2500, // Auto close after 2.5 seconds
            timerProgressBar: true
        }).then(() => {
            window.location = "index.php"; // Redirect after SweetAlert
        });
    </script>
</body>
</html>
