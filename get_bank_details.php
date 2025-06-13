<?php
include 'includes/dbconnection.php'; // Ensure $conn is set

// Check if 'id' is passed as a GET parameter
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("SELECT * FROM bank_details WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $record = $result->fetch_assoc();
        echo json_encode([
            "status" => "success",
            "record" => $record
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "No record found for ID $id"
        ]);
    }

    $stmt->close();
} else {
    // Fetch all records
    $query = "SELECT * FROM bank_details";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $data = [];

        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
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
}

$conn->close();
?>
