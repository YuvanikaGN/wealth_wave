<?php
include 'includes/dbconnection.php'; // Make sure this sets up $conn

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $goal = $_POST['goal'];
    $target_amount = $_POST['target_amount'];
    $income = $_POST['income'];
    $duration = $_POST['duration'];

    // Check if the same goal already exists
    $checkQuery = "SELECT * FROM savings_plan WHERE goal = '$goal'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        echo json_encode([
            "status" => "error",
            "message" => "Savings plan already exists"
        ]);
    } else {
        // Insert if no duplicate
        $insertQuery = "INSERT INTO savings_plan (goal, target_amount, income, duration) 
                        VALUES ('$goal', '$target_amount', '$income', '$duration')";

        if (mysqli_query($conn, $insertQuery)) {
            echo json_encode([
                "status" => "success",
                "message" => "Savings plan saved successfully"
            ]);
        } else {
            echo json_encode([
                "status" => "error",
                "message" => "Failed to save savings plan"
            ]);
        }
    }
}
?>
