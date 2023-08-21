<?php
session_start();
include_once 'connection.php';
$user_id = $_SESSION['user_id'];

// Check if the nurseID and jobID session variables are set
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Check if the select_month parameter is set
    if (isset($_GET['select_month'])) {
        $selectedMonth = $_GET['select_month'];

        // SQL query to retrieve the nurse's schedule for the selected month
        $query = "SELECT s.scheduleID, st.nursesName, jt.jobDescription, s.date
                  FROM schedule s
                  JOIN nurses st ON s.nursesID = st.nursesID
                  JOIN job jt ON st.jobID = jt.jobID
                  WHERE st.nursesID = $user_id AND MONTH(s.date) = $selectedMonth";

        $result = mysqli_query($conn, $query);

        // Check if the query was successful and schedule information is available
        if ($result && mysqli_num_rows($result) > 0) {
            $scheduleTable = "<table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Nurse Name</th>
                                        <th>Job Description</th>
                                    </tr>
                                </thead>
                                <tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                $date = $row['date'];
                $nurseName = $row['nursesName'];
                $jobDescription = $row['jobDescription'];

                $scheduleTable .= "<tr>
                                        <td>$date</td>
                                        <td>$nurseName</td>
                                        <td>$jobDescription</td>
                                    </tr>";
            }

            $scheduleTable .= "</tbody>
                                </table>";
        } else {
            $scheduleTable = "<p>No schedule available for the selected month.</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Schedule</title>
    <style>
        /* CSS styles here */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .navbar {
            background-color: #333;
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 60px;
            z-index: 100;
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
            margin-top: 80px;
        }

        form {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
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
            <li><a class="active" href="nursesMain.php">Profile</a></li>
            <li><a href="viewScheduleNurse.php?nurseID=<?php echo $user_id; ?>">View Schedule</a></li>
            <li><a href="nursesleaveApplication.php">Leave Application</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

    <h1>View Schedule</h1>

    <form method="GET" action="viewScheduleNurse.php">
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

    <?php if (isset($scheduleTable)) { echo $scheduleTable; } ?>

</body>
</html>
