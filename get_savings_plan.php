<?php
include 'includes/dbconnection.php'; // Ensure $conn is set

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if income threshold is passed
    if (isset($_GET['income_threshold'])) {
        $income_threshold = floatval($_GET['income_threshold']);

        $stmt = $conn->prepare("SELECT * FROM savings_plan WHERE income > ?");
        $stmt->bind_param("d", $income_threshold);
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
                "message" => "No records found with income greater than $income_threshold"
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Missing income_threshold parameter"
        ]);
    }
}
?>
