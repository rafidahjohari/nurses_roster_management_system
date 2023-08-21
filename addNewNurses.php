<?php
session_start();
include_once 'connection.php';

// Check if the user is logged in as a chief
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chief') {
    header("Location: loginProcess.php"); // Redirect to the login page if not logged in as chief
    exit();
}

// Define variables to hold error and success messages
$error_message = '';
$success_message = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nursesName = isset($_POST['name']) ? $_POST['name'] : '';
    $nursesPhoneNo = isset($_POST['nursesPhoneNo']) ? $_POST['nursesPhoneNo'] : '';
    $nursesEmail = isset($_POST['email']) ? $_POST['email'] : '';
    $nursesPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $user_type = isset($_POST['usertype']) ? $_POST['usertype'] : '';
    $jobID = isset($_POST['jobID']) ? $_POST['jobID'] : '';

    // Validate and sanitize the input
    if (empty($nursesName) || empty($nursesPhoneNo) || empty($nursesEmail) || empty($nursesPassword) || empty($user_type) || empty($jobID)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($nursesEmail, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Insert the new nurse into the database
        $insertQuery = "INSERT INTO nurses (nursesName, nursesPhoneNo, nursesEmail, nursesPassword, user_type, jobID)
                        VALUES ('$nursesName', '$nursesPhoneNo', '$nursesEmail', '$nursesPassword', '$user_type', '$jobID')";

    if (mysqli_query($conn, $insertQuery)) {
        $success_message = "New nurse added successfully.";
    echo '<script>alert("New nurse added successfully.");</script>';
    } else {
        $error_message = "Failed to add new nurse. Please try again.";
}

    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Add New Nurses</title>
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

        .container {
            max-width: 500px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 10px;
        }

        .form-group label {
            display: inline-block;
            width: 120px;
            text-align: left;
            font-weight: bold;
        }

        .form-group input {
            width: 250px;
            padding: 5px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .form-group .error-message {
            color: #FF0000;
        }

        .form-group .success-message {
            color: #008000;
        }

        .form-group button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-group button:hover {
            background-color: #45a049;
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
            <li><a href="chiefMain.php">Profile</a></li>
            <li><a href="viewScheduleNurseAll.php">Nurses Schedule</a></li>
            <li><a href="viewNursesApplyLeave.php">Nurses Leave Application</a></li>
            <li><a class="active" href="addNewNurses.php">Register New Nurses</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

    <div style="height: 60px;"></div>
    <h2>Add New Nurses</h2>
    <div class="container">
        <?php if (!empty($error_message)) : ?>
            <p class="error-message"><?php echo $error_message; ?></p>
        <?php endif; ?>
        <?php if (!empty($success_message)) : ?>
            <p class="success-message"><?php echo $success_message; ?></p>
        <?php endif; ?>
        <form method="post">
            <div class="form-group">
                <label for="name">Nurse Name:</label>
                <input type="text" name="name" id="name" required>
            </div>
            <div class="form-group">
                <label for="jobID">Phone Number:</label>
                <input type="text" name="nursesPhoneNo" id="nursesPhoneNo" required>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="text" name="email" id="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <div class="form-group">
                <label for="usertype">User Type:</label>
                <input type="text" name="usertype" id="usertype" required>
            </div>
            <div class="form-group">
                <label for="jobID">Job ID:</label>
                <input type="text" name="jobID" id="jobID" required>
            </div>
            <div class="form-group">
                <button type="submit">Add Nurse</button>
            </div>
        </form>
    </div>
</body>
</html>
