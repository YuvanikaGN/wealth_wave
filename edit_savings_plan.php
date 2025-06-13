<?php

include 'includes/dbconnection.php';
$host = "localhost";
$user = "root";
$password = "";
$database = "app_database"; // Replace with your actual DB name

// Connect to the database
$conn = new mysqli($host, $user, $password, $database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Update the savings plan if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $goal = $_POST['goal'];
    $target_amount = $_POST['target_amount'];
    $income = $_POST['income'];
    $duration = $_POST['duration'];

    $sql = "UPDATE savings_plan 
            SET goal = '$goal', 
                target_amount = '$target_amount', 
                income = '$income', 
                duration = '$duration' 
            WHERE id = '$id'";

    if ($conn->query($sql) === TRUE) {
        echo "Savings plan updated successfully.";
    } else {
        echo "Error updating savings plan: " . $conn->error;
    }
}

// Fetch existing data to pre-fill the form
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = $conn->query("SELECT * FROM savings_plan WHERE id = '$id'");
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "Savings plan not found.";
        exit;
    }
}
?>

<!-- HTML Form -->
<form method="POST" action="">
    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    Goal: <input type="text" name="goal" value="<?php echo $row['goal']; ?>"><br><br>
    Target Amount: <input type="number" name="target_amount" value="<?php echo $row['target_amount']; ?>"><br><br>
    Income: <input type="number" name="income" value="<?php echo $row['income']; ?>"><br><br>
    Duration (months): <input type="number" name="duration" value="<?php echo $row['duration']; ?>"><br><br>

    <input type="submit" value="Update Savings Plan">
</form>
