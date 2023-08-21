<?php
session_start();
include_once 'connection.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: loginProcess.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Retrieve nurse information from the database
$query = "SELECT * FROM chief WHERE chiefID = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['chiefName'];
    $email = $row['chiefEmail'];
    $nurseID = $row['chiefID'];
    $phone = $row['chiefPhoneNo'];
} else {
    $error_message = "Failed to retrieve chief information!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Chief Nurse Profile</title>

    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }

        h1 {
            color: #333;
        }

        .attribute-box {
            width: 200px;
            border: 1px solid #ccc;
            background-color: #fff;
            padding: 10px;
            margin: 10px auto;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .attribute-name {
            font-weight: bold;
            font-size: 16px;
            color: #333;
            margin: 0;
        }

        .attribute-value {
            color: #666;
            margin: 0;
        }

        .view-schedule-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .view-schedule-button:hover {
            background-color: #45a049;
        }

        .error-message {
            color: #FF0000;
        }

        .navbar {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
        }

        .navbar-logo {
            display: flex;
            align-items: center;
            color: white;
            text-decoration: none;
        }

        .navbar-logo img {
            width: 40px;
            height: 40px;
            margin-right: 10px;
        }

        .navbar-title {
            font-weight: bold;
            font-size: 20px;
            line-height: 60px;
            margin: 0;
            padding: 0;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        .navbar li {
            float: left;
            margin-left: 16px;
        }

        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 16px;
            text-decoration: none;
        }

        .navbar li a:hover {
            background-color: #111;
        }


        .logout {
            color: red;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
<div class="navbar">
        <a href="#" class="navbar-logo">
            <img src="nurseslogo.png" alt="Logo">
            <h1 class="navbar-title">Nurses Roster Management System</h1>
        </a>
        <ul>
            <li><a class="active" href="chiefMain.php">Profile</a></li>
            <li><a href="viewScheduleNurseAll.php">Nurses Schedule</a></li>
            <li><a href="viewNursesApplyLeave.php">Nurses Leave Application</a></li>
            <li><a href="addNewNurses.php">Register New Nurses</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div style="height: 60px;"></div> <!-- Add some space to prevent content overlap with the fixed navigation bar -->

    <h1>Chief Nurse Profile</h1>
    <img src="profilenew.png" alt="Profile Image" class="profile-image">
    <?php if (isset($error_message)) { ?>
        <p class="error-message"><?php echo $error_message; ?></p>
    <?php } else { ?>
        <div class="attribute-box">
            <p class="attribute-name">Name:</p>
            <p class="attribute-value"><?php echo $name; ?></p>
        </div>
        <div class="attribute-box">
            <p class="attribute-name">Email:</p>
            <p class="attribute-value"><?php echo $email; ?></p>
        </div>
        <div class="attribute-box">
            <p class="attribute-name">Chief Nurse ID:</p>
            <p class="attribute-value"><?php echo $nurseID; ?></p>
        </div>
        <div class="attribute-box">
            <p class="attribute-name">Phone Number:</p>
            <p class="attribute-value"><?php echo $phone; ?></p>
        </div>

        <form action="updateProfileChief.php" method="POST">
            <button type="submit" class="view-schedule-button">Update Profile</button>
        </form>
    <?php } ?>
</body>
</html>
