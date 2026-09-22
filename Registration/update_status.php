<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = "localhost";
$user = "root";
$pass = "";
$dbname = "voter_registration";


$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $status = $_POST['status'];

    
    $sql = "UPDATE voters SET status = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $user_id);

    if ($stmt->execute()) {
        header("Location: manageusers.php?status=updated");
    } else {
        echo "Error updating status: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
