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


$sql = "SELECT * FROM voters";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-image: url('img4.png');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            color: white;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            margin: 50px auto;
            padding: 20px;
            background: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.2);
        }

        .userlist-container {
            overflow-x: auto;
            padding: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: center;
            background: rgba(255, 255, 255, 0.2);
        }

        th {
            background: rgba(51, 51, 51, 0.8);
            color: white;
        }

        tr:hover {
            background: rgba(255, 255, 255, 0.3);
            transition: 0.3s ease-in-out;
        }

        select {
            padding: 5px;
            border-radius: 5px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid white;
            color: white;
        }

        .btn {
            padding: 12px 18px;
            color: white;
            background-color: #28a745;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            margin-top: 15px;
            display: inline-block;
        }

        .btn:hover {
            background-color: #218838;
        }

        .update-btn {
            padding: 8px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .update-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Manage Users</h2>
        <div class="userlist-container">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Full Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Nationality</th>
                        <th>Marital Status</th>
                        <th>Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip Code</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= $row['first_name'] . " " . $row['middle_name'] . " " . $row['last_name'] ?></td>
                            <td><?= date("m/d/Y", strtotime($row['dob'])) ?></td>
                            <td><?= $row['gender'] ?></td>
                            <td><?= $row['nationality'] ?></td>
                            <td><?= $row['marital_status'] ?></td>
                            <td><?= $row['address'] ?></td>
                            <td><?= $row['city'] ?></td>
                            <td><?= $row['state'] ?></td>
                            <td><?= $row['zip_code'] ?></td>
                            <td><?= $row['phone'] ?></td>
                            <td><?= $row['email'] ?></td>
                            <td>
                                <form action="update_status.php" method="POST">
                                    <input type="hidden" name="user_id" value="<?= $row['id'] ?>">
                                    <select name="status" onchange="this.form.submit()">
                                        <option value="Pending" <?= ($row['status'] == 'Pending') ? 'selected' : '' ?>>Pending</option>
                                        <option value="Inactive" <?= ($row['status'] == 'Inactive') ? 'selected' : '' ?>>Inactive</option>
                                        <option value="Active" <?= ($row['status'] == 'Active') ? 'selected' : '' ?>>Active</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="update_user.php?id=<?= $row['id'] ?>" class="update-btn">Update</a>
                                </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <button onclick="location.href='register.html'" class="btn">Register New User</button>
        </div>
    </div>
</body>
</html>

<?php $conn->close(); ?>
