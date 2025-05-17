<?php
session_start();
require_once('includes/dbconnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $emailcon = trim($_POST['emailcont']);
    $password = $_POST['password'];

    $stmt = $con->prepare("SELECT ID, Password FROM tbluser WHERE (Email = ? OR MobileNumber = ?)");
    $stmt->bind_param("ss", $emailcon, $emailcon);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        if (password_verify($password, $row['Password'])) {
            $_SESSION['bpmsuid'] = $row['ID'];
            header('Location: index.php');
            exit();
        } else {
            echo "<script>alert('Invalid Password.');</script>";
        }
    } else {
        echo "<script>alert('Invalid Email or Contact Number.');</script>";
    }
    $stmt->close();
}
?>
