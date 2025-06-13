<?php

include 'includes/dbconnection.php';
// Database configuration
$servername = "localhost";
$username = "root"; // default for XAMPP
$password = "";     // default for XAMPP
$dbname = "app_database"; // Replace with your DB name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get POST data from Postman
$id = $_POST['id']; // ID of the record to update
$source = $_POST['Source'];
$amount = $_POST['amount'];

// Validate input
if (!empty($id) && !empty($source) && !empty($amount)) {
    $stmt = $conn->prepare("UPDATE user_income SET Source = ?, amount = ? WHERE id = ?");
    $stmt->bind_param("ssi", $source, $amount, $id);

    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Income updated successfully."]);
        } else {
            echo json_encode(["status" => "warning", "message" => "No changes made or invalid ID."]);
        }
    } else {
        echo json_encode(["status" => "error", "message" => "Update failed."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields (id, Source, amount)."]);
}

$conn->close();
?>
