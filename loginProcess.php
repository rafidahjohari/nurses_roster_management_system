<?php
session_start();
include_once 'connection.php';

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM chief WHERE chiefID = '$username' AND chiefPassword = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['chiefID'];
        $_SESSION['user_type'] = 'chief';
        header("Location: chiefMain.php");
        exit();
    }

    $query = "SELECT * FROM nurses WHERE nursesID = '$username' AND nursesPassword = '$password'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['nursesID'];
        $_SESSION['user_type'] = 'nurses';
        header("Location: nursesMain.php");
        exit();
    }

    $error_message = "Invalid username or password!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            background-color: #f3f3f3;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        h1 {
            text-align: center;
            font-size: 24px;
            margin-top: 50px;
            margin-bottom: 20px;
            color: #333;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        p {
            text-align: center;
            color: red;
        }

        form {
            max-width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            font-weight: bold;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 14px;
            margin-bottom: 15px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            text-transform: uppercase;
        }

        button:hover {
            background-color: #45a049;
        }

        @media (max-width: 480px) {
            form {
                max-width: 90%;
            }
        }
    </style>
    <title>Login</title>
</head>
<body>
    <h1>NURSES ROSTER MANAGEMENT SYSTEM</h1>
    <form action="" method="POST">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit" name="login">Login</button>
    </form>
</body>
</html>
