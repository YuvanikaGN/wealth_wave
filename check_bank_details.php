<?php
include 'includes/dbconnection.php'; // Ensure this sets up $conn

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the POST data
    $bank_name = $_POST['bank_name'] ?? '';
    $acc_name = $_POST['acc_name'] ?? '';
    $ifsc = $_POST['ifsc'] ?? '';
    $number = $_POST['number'] ?? '';

    // Validate input
    if (empty($bank_name) || empty($acc_name) || empty($ifsc) || empty($number)) {
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required"
        ]);
        exit;
    }

    // Prepare a SELECT query to check if the record exists
    $stmt = $conn->prepare("SELECT * FROM bank_details WHERE bank_name = ? AND acc_name = ? AND ifsc = ? AND number = ?");
    $stmt->bind_param("ssss", $bank_name, $acc_name, $ifsc, $number);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if any rows returned
    if ($result->num_rows > 0) {
        echo json_encode([
            "status" => "exists",
            "message" => "Bank details already exist"
        ]);
    } else {
        echo json_encode([
            "status" => "not_found",
            "message" => "Bank details do not exist"
        ]);
    }

    $stmt->close();

} else {
    // Handle other request types
    echo json_encode([
        "status" => "error",
        "message" => "Invalid request method. Use POST."
    ]);
}
?>
