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
$source = $_POST['Source'];
$amount = $_POST['amount'];

// Validate input
if (!empty($source) && !empty($amount)) {
    $stmt = $conn->prepare("INSERT INTO user_income (Source, amount) VALUES (?, ?)");
    $stmt->bind_param("ss", $source, $amount);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Income inserted successfully."]);
    } else {
        echo json_encode(["status" => "error", "message" => "Insertion failed."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "error", "message" => "Missing required fields."]);
}

$conn->close();
?>
