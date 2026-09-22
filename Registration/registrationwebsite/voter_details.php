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

$email = $_GET['email']; 

$query = "SELECT * FROM voters WHERE email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    die("Voter not found.");
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voter Details</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Voter Registration Details</h2>
        <p><strong>Full Name:</strong> <?php echo $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name']; ?></p>
        <p><strong>Date of Birth:</strong> <?php echo date("m/d/Y", strtotime($row['dob'])); ?></p>
        <p><strong>Gender:</strong> <?php echo $row['gender']; ?></p>
        <p><strong>Nationality:</strong> <?php echo $row['nationality']; ?></p>
        <p><strong>Marital Status:</strong> <?php echo $row['marital_status']; ?></p>
        <p><strong>Residential Address:</strong> <?php echo $row['address']; ?></p>
        <p><strong>City/Town:</strong> <?php echo $row['city']; ?></p>
        <p><strong>State/Province:</strong> <?php echo $row['state']; ?></p>
        <p><strong>Zip/Postal Code:</strong> <?php echo $row['zip_code']; ?></p>
        <p><strong>Phone Number:</strong> <?php echo $row['phone']; ?></p>
        <p><strong>Email Address:</strong> <?php echo $row['email']; ?></p>
        <p><strong>Status:</strong> <?php echo $row['status']; ?></p>
        <button onclick="location.href='index.html'" class="btn">Back to Homepage</button>
    </div>
</body>
</html>

<style>
    body {
        font-family: Arial, sans-serif;
        background-image: url(img4.png); 
        background-size: cover;
        color: white;
        text-align: center;
    }
    .container {
        width: 60%;
        margin: 50px auto;
        padding: 20px;
        background: rgba(0, 0, 0, 0.7);
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
    }
    p {
        font-size: 18px;
        margin: 10px 0;
    }
    .btn {
        margin-top: 20px;
        padding: 10px 15px;
        color: white;
        font-size: 14px;
        background-color: #f1683a;
        border: none;
        border-radius: 5px;
        cursor: pointer;
    }
</style>
