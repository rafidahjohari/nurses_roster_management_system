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
$query = "SELECT * FROM nurses WHERE nursesID = '$user_id'";
$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $name = $row['nursesName'];
    $email = $row['nursesEmail'];
    $nurseID = $row['nursesID'];
    $phone = $row['nursesPhoneNo'];
    $jobs = $row['jobID'];
} else {
    $error_message = "Failed to retrieve nurse information!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap.min.css">
    <title>Nurse Profile</title>

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

        /* CSS for the horizontal navigation bar */
        .navbar {
            background-color: #333;
            overflow: hidden;
            position: fixed;
            top: 0;
            width: 100%;
            height: 60px; /* Adjust the height as needed */
            z-index: 100;
        }

        .navbar ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            float: right;
        }

        .navbar li {
            float: left;
        }

        .navbar li a {
            display: block;
            color: white;
            text-align: center;
            padding: 16px 16px;
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
        <ul>
            <li><a class="active" href="nursesMain.php">Profile</a></li>
            <li><a href="viewScheduleNurse.php?nurseID=<?php echo $nurseID; ?>&jobID=<?php echo $jobs; ?>">View Schedule</a></li>
            <li><a href="nursesleaveApplication.php">Leave Application</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div style="height: 60px;"></div> <!-- Add some space to prevent content overlap with the fixed navigation bar -->

    <h1>Nurse Profile</h1>
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
            <p class="attribute-name">Nurse ID:</p>
            <p class="attribute-value"><?php echo $nurseID; ?></p>
        </div>
        <div class="attribute-box">
            <p class="attribute-name">Phone Number:</p>
            <p class="attribute-value"><?php echo $phone; ?></p>
        </div>
        <div class="attribute-box">
            <p class="attribute-name">Job ID:</p>
            <p class="attribute-value"><?php echo $jobs; ?></p>
        </div>

        <form action="updateProfileNurse.php" method="POST">
            <button type="submit" class="view-schedule-button">Update Profile</button>
        </form>
    <?php } ?>
</body>
</html>
