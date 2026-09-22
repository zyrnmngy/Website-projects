<?php

$servername = "localhost"; 
$username = "root"; 
$password = ""; 
$database = "voter_registration"; 

$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "SELECT * FROM voters";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>{$row['first_name']} {$row['middle_name']} {$row['last_name']}</td>
                <td>{$row['dob']}</td>
                <td>{$row['gender']}</td>
                <td>{$row['nationality']}</td>
                <td>{$row['marital_status']}</td>
                <td>{$row['address']}</td>
                <td>{$row['city']}</td>
                <td>{$row['state']}</td>
                <td>{$row['zip_code']}</td>
                <td>{$row['phone']}</td>
                <td>{$row['email']}</td>
                <td>{$row['status']}</td>
            </tr>";
    }
} else {
    echo "<tr><td colspan='13'>No records found</td></tr>";
}

$conn->close();
?>
