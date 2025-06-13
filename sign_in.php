<?php
include 'includes/dbconnection.php'; // Make sure this connects properly to your DB

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id']; // If you want manual ID, otherwise make it AUTO_INCREMENT
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hashed for security

    // Check if email already exists
    $check = mysqli_query($conn, "SELECT * FROM sign_in WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        echo json_encode(["status" => "error", "message" => "Email already signed in"]);
    } else {
        $sql = "INSERT INTO sign_in (id, email, password)
                VALUES ('$id', '$email', '$password')";
        if (mysqli_query($conn, $sql)) {
            echo json_encode(["status" => "success", "message" => "Sign-in successful"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Sign-in failed"]);
        }
    }
}
?>
