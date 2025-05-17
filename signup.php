<?php
session_start();
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $fname = trim($_POST['firstname']);
    $lname = trim($_POST['lastname']);
    $contno = trim($_POST['mobilenumber']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate email and mobile
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !preg_match('/^[0-9]{10}$/', $contno)) {
        echo "<script>alert('Invalid email or mobile number.');</script>";
        exit;
    }

    // Check for existing user
    $stmt = $con->prepare("SELECT Email FROM tbluser WHERE Email = ? OR MobileNumber = ?");
    $stmt->bind_param("ss", $email, $contno);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('This email or contact number is already associated with another account.');</script>";
    } else {
        // Hash password
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $insert = $con->prepare("INSERT INTO tbluser (FirstName, LastName, MobileNumber, Email, Password) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $fname, $lname, $contno, $email, $hashedPassword);
        if ($insert->execute()) {
            echo "<script>alert('You have successfully registered.'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Something went wrong. Please try again.');</script>";
        }
    }
}
?>
