<?php
session_start();
include 'conn.php';

if (isset($_SESSION['email'], $_SESSION['u_id'], $_SESSION['r_id'], $_SESSION['b_list_id'], $_SESSION['user_type']) 
    && $_SESSION['user_type'] === "Residence Account") {
?>



<?php 
} else {
    header("Location: index.php");
    exit();
}
?>