<?php
session_start();
include_once 'connection.php';

// Check if the user_id is set in the session
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $date = $_POST["dateLeave"];
        $reason = $_POST["reason"];

        // Validate form data (you can add more validation if needed)
        if (empty($date) || empty($reason)) {
            $error = "Please fill in all fields.";
        } else {
            // Perform necessary database operations to save the leave application
            $leaveId = saveLeaveApplication($user_id, $date, $reason);

            if ($leaveId) {
                // Leave application saved successfully
                $successMessage = "Leave application submitted successfully.";
            } else {
                $error = "An error occurred while submitting the leave application.";
            }
        }
    }
} else {
    // Handle the case when 'user_id' is not set in the session
    $error = "User ID is not set.";
}

function saveLeaveApplication($user_id, $date, $reason) {
    global $conn; // Use the global $conn variable

    // Validate and sanitize input values

    // Check if the user exists in the nurses table
    $query = "SELECT * FROM nurses WHERE nursesID = '$user_id'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        // The user exists, get the job ID
        $row = mysqli_fetch_assoc($result);
        $jobID = $row['jobID'];

        // Set the status to "Pending"
        $status = "Pending";

        // Insert the leave application
        $insertQuery = "INSERT INTO leaveapplication (nursesID, jobID, dateLeave, reason, status) VALUES ('$user_id', '$jobID', '$date', '$reason', '$status')";
        mysqli_query($conn, $insertQuery);

        // Check if the leave application was successfully inserted
        if (mysqli_affected_rows($conn) > 0) {
            return mysqli_insert_id($conn); // Return the leave ID
        }
    }
    
    return false; // An error occurred while submitting the leave application
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Leave Application</title>
    <style>
        body {
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
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
            font-size: 24px;
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

        .error-message {
            color: #FF0000;
        }

        h1 {
            text-align: center;
            margin-top: 50px;
            color: #333;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        input[type="date"],
        textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 15px;
        }

        textarea {
            resize: vertical;
            height: 100px;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .success-message {
            color: green;
            text-align: center;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <a href="#" class="navbar-logo">
            <img src="nurseslogo.png" alt="Logo">
            <h1 class="navbar-title">Nurses Roster Management System</h1>
        </a>
        <ul>
            <li><a class="active" href="nursesMain.php">Profile</a></li>
            <li><a href="viewScheduleNurse.php?nurseID=<?php echo $user_id; ?>">View Schedule</a></li>
            <li><a href="nursesleaveApplication.php">Leave Application</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

    <h1>Leave Application Form</h1>

    <?php if (isset($successMessage)) { ?>
        <p class="success-message"><?php echo $successMessage; ?></p>
    <?php } ?>

    <?php if (isset($error)) { ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php } ?>

    <div class="form-container">
        <form method="POST" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <label for="dateLeave">Date Apply For Leave:</label>
            <input type="date" name="dateLeave" required>

            <label for="reason">Reason:</label>
            <textarea name="reason" rows="5" required></textarea>

            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
