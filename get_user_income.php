<?php
include 'includes/dbconnection.php'; // Ensure $conn is properly set up

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if 'amount_threshold' is passed
    if (isset($_GET['amount_threshold'])) {
        $amount_threshold = floatval($_GET['amount_threshold']);

        $stmt = $conn->prepare("SELECT * FROM user_income WHERE amount > ?");
        $stmt->bind_param("d", $amount_threshold);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = [];

            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }

            echo json_encode([
                "status" => "success",
                "records" => $data
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "No income records found with amount greater than $amount_threshold"
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Missing 'amount_threshold' parameter"
        ]);
    }
}
?>
