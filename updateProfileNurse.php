<?php
session_start();
include_once 'connection.php';

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM nurses WHERE nursesID = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['nursesName'];
            $phone = $row['nursesPhoneNo'];
            $email = $row['nursesEmail'];
            $password = $row['nursesPassword'];
        }
    }
} else {
    echo "Session timed-out. Login again.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewreport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            padding-top: 60px; /* Add padding for the navigation bar */
            box-sizing: border-box;
        }

        h1 {
            color: #333;
        }

        .update-profile {
            width: 300px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #ccc;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .flex {
            display: flex;
            flex-direction: column;
        }

        .inputBox {
            margin-bottom: 10px;
        }

        .inputBox span {
            display: block;
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .box {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .btn {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .delete-btn {
            background-color: #f44336;
            color: #fff;
            border: none;
            padding: 10px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
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
    <div class="navbar">
        <ul>
            <li><a class="active" href="nursesMain.php">Profile</a></li>
            <li><a href="viewScheduleNurse.php?nurseID=<?php echo $nurseID; ?>&jobID=<?php echo $jobs; ?>">View Schedule</a></li>
            <li><a href="nursesleaveApplication.php">Leave Application</a></li>
            <li><a class="logout" href="logout.php">Logout</a></li>
        </ul>
    </div>

    <h1>Update Profile</h1>

    <div class="update-profile">
        <form action="updateProfileProcessNurse.php" method="POST" enctype="multipart/form-data">
            <div class="flex">
                <div class="inputBox">
                    <span>Name:</span>
                    <input type="text" id="update_name" name="update_name" placeholder="<?php echo $name; ?>" class="box">
                </div>
                <div class="inputBox">
                    <span>Email Address:</span>
                    <input type="email" id="update_email" name="update_email" placeholder="<?php echo $email; ?>" class="box">
                </div>
                <div class="inputBox">
                    <span>Phone Number:</span>
                    <input type="text" id="update_phone" name="update_phone" placeholder="<?php echo $phone; ?>" class="box">
                </div>
                <div class="inputBox">
                    <span>Old password:</span>
                    <input type="password" id="current_pass" name="update_pass" placeholder="Current password" class="box">
                </div>
                <div class="inputBox">
                    <span>New password:</span>
                    <input type="password" id="pass1" name="pass1" placeholder="Enter new password" class="box">
                </div>
                <div class="inputBox">
                    <span>Confirm password:</span>
                    <input type="password" id="pass2" name="pass2" placeholder="Confirm new password" class="box">
                </div>
            </div>
            <input type="submit" value="Update profile" name="update_profile" class="btn">
            <a href="nursesMain.php" class="delete-btn">Back</a>
        </form>
    </div>
</body>

</html>
