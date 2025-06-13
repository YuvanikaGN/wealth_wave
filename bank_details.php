<?php
include 'includes/dbconnection.php'; // Ensure this sets up $conn

// Check the request method
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    // Get the POST data
    $bank_name = $_POST['bank_name'] ?? '';
    $acc_name = $_POST['acc_name'] ?? '';
    $ifsc = $_POST['ifsc'] ?? '';
    $number = $_POST['number'] ?? '';

    // Validate input (basic check)
    if (empty($bank_name) || empty($acc_name) || empty($ifsc) || empty($number)) {
        echo json_encode([
            "status" => "error",
            "message" => "All fields are required"
        ]);
        exit;
    }

    // Insert into the database
    $stmt = $conn->prepare("INSERT INTO bank_details (bank_name, acc_name, ifsc, number) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $bank_name, $acc_name, $ifsc, $number);

    if ($stmt->execute()) {
        echo json_encode([
            "status" => "success",
            "message" => "Bank details added successfully"
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Database insertion failed"
        ]);
    }

    $stmt->close();

} elseif ($method === 'GET') {
    // Query to fetch all records
    $query = "SELECT * FROM bank_details";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = [
                'id' => $row['id'],
                'bank_name' => $row['bank_name'],
                'acc_name' => $row['acc_name'],
                'ifsc' => $row['ifsc'],
                'number' => $row['number']
            ];
        }

        echo json_encode([
            "status" => "success",
            "records" => $data
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No records found"
        ]);
    }

} else {
    echo json_encode([
        "status" => "error",
        "message" => "Unsupported request method"
    ]);
}
?>
