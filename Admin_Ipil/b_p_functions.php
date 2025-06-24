<?php
include 'conn.php'; // Ensure you have a database connection file
session_start(); // Start session to retrieve logged-in user data

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $position_name = isset($_POST['position_name']) ? trim($_POST['position_name']) : '';
    $status = isset($_POST['status']) ? trim($_POST['status']) : '';
    $a_id = isset($_SESSION['a_id']) ? $_SESSION['a_id'] : null; // Retrieve currently signed-in admin ID
    
    // Validate required fields
    if (!empty($position_name) && !empty($status) && !empty($a_id)) {
        // Prepare SQL query to insert data into the b_positions table
        $sql = "INSERT INTO b_positions (position_name, status, a_id) VALUES (?, ?, ?)";
        
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssi", $position_name, $status, $a_id);
            
            if ($stmt->execute()) {
                echo "<script>alert('Barangay position added successfully!'); window.location.href='b_p.php';</script>";
            } else {
                echo "<script>alert('Error adding barangay position.'); window.history.back();</script>";
            }
            
            $stmt->close();
        } else {
            echo "<script>alert('Database error.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('All fields are required.'); window.history.back();</script>";
    }
    
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.history.back();</script>";
}
?>
