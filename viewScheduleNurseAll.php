<?php
session_start();
include_once 'connection.php';

// Check if the user is logged in as a chief
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chief') {
    header("Location: loginProcess.php"); // Redirect to the login page if not logged in as chief
    exit();
}

// Retrieve the schedule of all nurses with their names and job descriptions
$query = "SELECT s.date, n.nursesName, j.jobDescription
          FROM schedule s
          INNER JOIN nurses n ON s.nursesID = n.nursesID
          INNER JOIN job j ON n.jobID = j.jobID";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch all schedule data
    $schedules = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Display an error message if the query fails
    $error_message = "Failed to retrieve schedules.";
}

// Get the selected month from the dropdown
if (isset($_POST['select_month'])) {
    $selectedMonth = $_POST['select_month'];
    // Modify the query to retrieve schedules for the selected month
    $query = "SELECT s.date, n.nursesName, j.jobDescription
              FROM schedule s
              INNER JOIN nurses n ON s.nursesID = n.nursesID
              INNER JOIN job j ON n.jobID = j.jobID
              WHERE MONTH(s.date) = $selectedMonth";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch all schedule data for the selected month
        $schedules = mysqli_fetch_all($result, MYSQLI_ASSOC);
    } else {
        // Display an error message if the query fails
        $error_message = "Failed to retrieve schedules for the selected month.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule - Chief</title>
    <style>
/* CSS for the horizontal navigation bar */
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

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table th,
        table td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        table tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .view-schedule-button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 10px;
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

        .view-month-button {
            background-color: #090203;
            border: none;
            color: white;
            padding: 2px 4px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .view-month-button:hover {
            background-color: #45a049;
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
            <li><a class="active" href="chiefMain.php">Profile</a></li>
            <li><a href="viewScheduleNurseAll.php">Nurses Schedule</a></li>
            <li><a href="viewNursesApplyLeave.php">Nurses Leave Application</a></li>
            <li><a href="addNewNurses.php">Register New Nurses</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>


    <h1 style="margin-top: 80px;">Schedule - All Nurses</h1>

    <form method="POST" action="viewScheduleNurseAll.php" style="margin-top: 20px;">
        <label for="select_month">Select Month:</label>
        <select name="select_month" id="select_month">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>
        <button type="submit" class="view-month-button">Submit</button>
    </form>

    <?php if (isset($error_message)) { ?>
        <p><?php echo $error_message; ?></p>
    <?php } else { ?>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Nurse Name</th>
                    <th>Job Description</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($schedules as $schedule) { ?>
                    <tr>
                        <td><?php echo $schedule['date']; ?></td>
                        <td><?php echo $schedule['nursesName']; ?></td>
                        <td><?php echo $schedule['jobDescription']; ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <form action="viewNursesApplyLeave.php" method="POST">
            <button type="submit" class="view-schedule-button">View All Leave Applied By Nurses</button>
        </form>
    <?php } ?>
</body>
</html>
