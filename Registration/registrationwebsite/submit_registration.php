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


$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$last_name = $_POST['last_name'];
$dob = $_POST['dob'];
$gender = $_POST['gender'];
$nationality = $_POST['nationality'];
$marital_status = $_POST['marital_status'];
$address = $_POST['address'];
$city = $_POST['city'];
$state = $_POST['state'];
$zip_code = $_POST['zip_code'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$status = "Pending"; 


$check_query = "SELECT * FROM voters WHERE first_name = ? AND middle_name = ? AND last_name = ? AND email = ?";
$stmt = $conn->prepare($check_query);
$stmt->bind_param("ssss", $first_name, $middle_name, $last_name, $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<script>
            alert('User with this name and email already exists!');
            window.location.href = 'register.html';
          </script>";
} else {
    
    $insert_query = "INSERT INTO voters (first_name, middle_name, last_name, dob, gender, nationality, marital_status, address, city, state, zip_code, phone, email, status) 
                     VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($insert_query);
    $stmt->bind_param("ssssssssssssss", $first_name, $middle_name, $last_name, $dob, $gender, $nationality, $marital_status, $address, $city, $state, $zip_code, $phone, $email, $status);
    
    if ($stmt->execute()) {
        
        echo "<script>
                alert('Registration successful! Redirecting to voter details page...');
                window.location.href = 'voter_details.php?email=$email';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error in registration. Please try again.');
                window.history.back();
              </script>";
    }
}


$stmt->close();
$conn->close();
?>
