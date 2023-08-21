<?php
session_start();
include_once 'connection.php';

// Check if the user is logged in as a chief
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'chief') {
    header("Location: login.php");
    exit();
}

// Retrieve all leave applications submitted by nurses
$query = "SELECT la.leaveID, la.nursesID, n.nursesName, la.dateLeave, la.reason, la.status, n.jobID
          FROM leaveapplication la
          INNER JOIN nurses n ON la.nursesID = n.nursesID";
$result = mysqli_query($conn, $query);

// Check if the query was successful
if ($result) {
    // Fetch all leave applications data
    $leaveApplications = mysqli_fetch_all($result, MYSQLI_ASSOC);
} else {
    // Display an error message if the query fails
    $error_message = "Failed to retrieve leave applications.";
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        // Handle leave application approval or rejection
        $leaveID = $_POST['leaveID'];
        $status = $_POST['status'];

        // Update the status of the leave application
        $updateQuery = "UPDATE leaveapplication SET status = '$status' WHERE leaveID = $leaveID";
        $updateResult = mysqli_query($conn, $updateQuery);

        if ($updateResult) {
            if ($status === 'Approved') {
                // Swap the nurse with the same jobID
                $leaveDataQuery = "SELECT nursesID, jobID FROM leaveapplication WHERE leaveID = $leaveID";
                $leaveDataResult = mysqli_query($conn, $leaveDataQuery);

                if ($leaveDataResult && mysqli_num_rows($leaveDataResult) > 0) {
                    $leaveData = mysqli_fetch_assoc($leaveDataResult);
                    $nursesID = $leaveData['nursesID'];
                    $jobID = $leaveData['jobID'];

                    // Find a replacement nurse with the same jobID
                    $replacementQuery = "SELECT nursesID FROM nurses WHERE jobID = $jobID AND nursesID != $nursesID LIMIT 1";
                    $replacementResult = mysqli_query($conn, $replacementQuery);

                    if ($replacementResult && mysqli_num_rows($replacementResult) > 0) {
                        $replacementData = mysqli_fetch_assoc($replacementResult);
                        $replacementNurseID = $replacementData['nursesID'];

                        // Update the schedule with the replacement nurse
                        $updateScheduleQuery = "UPDATE schedule SET nursesID = $replacementNurseID WHERE nursesID = $nursesID";
                        $updateScheduleResult = mysqli_query($conn, $updateScheduleQuery);

                        if ($updateScheduleResult) {
                            // Redirect to the same page after successful updates
                            header("Location: viewNursesApplyLeave.php");
                            exit();
                        } else {
                            $error_message = "Failed to update schedule.";
                        }
                    } else {
                        $error_message = "No replacement nurse available.";
                    }
                } else {
                    $error_message = "Failed to fetch leave data.";
                }
            } else {
                // Redirect to the same page after successful updates
                header("Location: viewNursesApplyLeave.php");
                exit();
            }
        } else {
            $error_message = "Failed to update leave application.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Leave Applications</title>
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

        table {
            margin: 10px auto;
            border-collapse: collapse;
        }

        th {
            background-color: #ccc;
        }

        th, td {
            padding: 10px;
            border: 1px solid #ccc;
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

    <div style="height: 60px;"></div>
    <h2>Leave Applications</h2>
    <?php if (isset($error_message)) : ?>
        <p class="error-message">Error: <?php echo $error_message; ?></p>
    <?php else : ?>
        <?php if (count($leaveApplications) > 0) : ?>
            <table>
                <tr>
                    <th>Nurse Name</th>
                    <th>Date</th>
                    <th>Reason</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
                <?php foreach ($leaveApplications as $leaveApplication) : ?>
                    <tr>
                        <td><?php echo $leaveApplication['nursesName']; ?></td>
                        <td><?php echo $leaveApplication['dateLeave']; ?></td>
                        <td><?php echo $leaveApplication['reason']; ?></td>
                        <td><?php echo $leaveApplication['status']; ?></td>
                        <td>
                            <?php if ($leaveApplication['status'] === 'Pending') : ?>
                                <form method="POST" action="">
                                    <input type="hidden" name="leaveID" value="<?php echo $leaveApplication['leaveID']; ?>">
                                    <input type="hidden" name="status" value="Approved">
                                    <button type="submit" name="update">Approve</button>
                                </form>
                                <form method="POST" action="">
                                    <input type="hidden" name="leaveID" value="<?php echo $leaveApplication['leaveID']; ?>">
                                    <input type="hidden" name="status" value="Rejected">
                                    <button type="submit" name="update">Reject</button>
                                </form>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        <?php else : ?>
            <p>No leave applications found.</p>
        <?php endif; ?>
    <?php endif; ?>
</body>
</html>
