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

    $sql = "UPDATE voters SET first_name=?, middle_name=?, last_name=?, dob=?, gender=?, nationality=?, marital_status=?, address=?, city=?, state=?, zip_code=?, phone=?, email=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssssssssssi", $first_name, $middle_name, $last_name, $dob, $gender, $nationality, $marital_status, $address, $city, $state, $zip_code, $phone, $email, $user_id);
    
    if ($stmt->execute()) {
        echo "<script>
                alert('User updated successfully!');
                window.location.href = 'manageusers.php';
              </script>";
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }
    $stmt->close();
    $conn->close();
}

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    $sql = "SELECT * FROM voters WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        echo "User not found.";
        exit;
    }
} else {
    echo "No user selected.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('img4.png'); /* Change to preferred image */
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 60%;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            color: white;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }
        .form-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-bottom: 15px;
        }
        .form-group label {
            width: 45%;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 50%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .back-btn {
            background-color: #28a745;
        }
        .back-btn:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Update User Information</h2>
        <form action="update_user.php" method="POST">
            <input type="hidden" name="user_id" value="<?= $row['id'] ?>">

            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="first_name" value="<?= htmlspecialchars($row['first_name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Middle Name:</label>
                <input type="text" name="middle_name" value="<?= htmlspecialchars($row['middle_name']) ?>">
            </div>

            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="last_name" value="<?= htmlspecialchars($row['last_name']) ?>" required>
            </div>

            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="dob" value="<?= $row['dob'] ?>" required>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender">
                    <option value="Male" <?= ($row['gender'] == 'Male') ? 'selected' : '' ?>>Male</option>
                    <option value="Female" <?= ($row['gender'] == 'Female') ? 'selected' : '' ?>>Female</option>
                    <option value="Other" <?= ($row['gender'] == 'Other') ? 'selected' : '' ?>>Other</option>
                </select>
            </div>

            <div class="form-group">
                <label>Nationality:</label>
                <input type="text" name="nationality" value="<?= htmlspecialchars($row['nationality']) ?>" required>
            </div>

            <div class="form-group">
                <label>Marital Status:</label>
                <select name="marital_status">
                    <option value="Single" <?= ($row['marital_status'] == 'Single') ? 'selected' : '' ?>>Single</option>
                    <option value="Married" <?= ($row['marital_status'] == 'Married') ? 'selected' : '' ?>>Married</option>
                    <option value="Divorced" <?= ($row['marital_status'] == 'Divorced') ? 'selected' : '' ?>>Divorced</option>
                </select>
            </div>

            <div class="form-group">
                <label>Address:</label>
                <input type="text" name="address" value="<?= htmlspecialchars($row['address']) ?>" required>
            </div>

            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" value="<?= htmlspecialchars($row['city']) ?>" required>
            </div>

            <div class="form-group">
                <label>State:</label>
                <input type="text" name="state" value="<?= htmlspecialchars($row['state']) ?>" required>
            </div>

            <div class="form-group">
                <label>Zip Code:</label>
                <input type="text" name="zip_code" value="<?= htmlspecialchars($row['zip_code']) ?>" required>
            </div>


            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" value="<?= htmlspecialchars($row['phone']) ?>" required>
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
            </div>

            <button type="submit" class="btn">Update User</button>
            <button type="button" class="btn back-btn" onclick="location.href='userlist.php'">View Registered Users</button>

        </form>
    </div>

</body>
</html>
