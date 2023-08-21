<?php
session_start();
include_once 'connection.php';

$user_id = $_SESSION['user_id'];

if (isset($_POST['update_profile'])) {

    $user_id = $_SESSION['user_id'];
    $sql = "SELECT * FROM chief WHERE chiefID = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $name = $row['chiefName'];
            $phone = $row['chiefPhoneNo'];
            $email = $row['chiefEmail'];
            $password = $row['chiefPassword'];
        }
    }

    $current_pass = $_POST['update_pass'];

    if (empty($_POST['update_name'])) {
        $new_name = $name;
    } else {
        $new_name = $_POST['update_name'];
    }

    if (empty($_POST['update_email'])) {
        $new_email = $email;
    } else {
        $new_email = $_POST['update_email'];
    }

    if (empty($_POST['update_phone'])) {
        $new_phone = $phone;
    } else {
        $new_phone = $_POST['update_phone'];
    }

    if (empty($_POST['pass1'])) {
        $new_pass1 = $password;
    } else {
        $new_pass1 = $_POST['pass1'];
    }

    if (empty($_POST['pass2'])) {
        $new_pass2 = $password;
    } else {
        $new_pass2 = $_POST['pass2'];
    }

    if ($new_pass2 != $new_pass1) {
        echo "<script>alert('The two passwords do not match.');</script>";
        echo "<meta http-equiv='refresh' content='0; url=updateProfileChief.php'/>";
    } else {
        $update_profile = "update chief set chiefName = '$new_name', chiefPhoneNo = '$new_phone', chiefEmail = '$new_email', chiefPassword = '$new_pass2' WHERE chiefID = '$user_id'";

        $run_profile = mysqli_query($conn, $update_profile);

        if ($run_profile) {
            echo "<script> alert('Profile has been updated successfully. Redirecting to main page.') </script>";
            echo "<meta http-equiv='refresh' content='0; url=chiefMain.php'/>";
        } else {
            echo "<script> alert('Failed to update image!') </script>";
            echo "<meta http-equiv='refresh' content='0; url=updateProfileChief.php'/>";
        }
    }
} else {
    echo "Try again.";
}
?>
