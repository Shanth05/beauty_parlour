<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('includes/dbconnection.php');

if (empty($_SESSION['bpmsuid'])) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['change'])) {
    $userid = $_SESSION['bpmsuid'];
    $currentpassword = $_POST['currentpassword'] ?? '';
    $newpassword = $_POST['newpassword'] ?? '';

    // Fetch current hashed password
    $stmt = $con->prepare("SELECT Password FROM tbluser WHERE ID = ?");
    $stmt->bind_param("s", $userid);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    if ($stmt->fetch()) {
        if (password_verify($currentpassword, $hashedPassword)) {
            $stmt->close();
            $newHashed = password_hash($newpassword, PASSWORD_DEFAULT);
            $update = $con->prepare("UPDATE tbluser SET Password = ? WHERE ID = ?");
            $update->bind_param("ss", $newHashed, $userid);
            if ($update->execute()) {
                echo '<script>alert("Your password successfully changed.")</script>';
            } else {
                echo '<script>alert("Something went wrong. Please try again.")</script>';
            }
            $update->close();
        } else {
            echo '<script>alert("Your current password is wrong.")</script>';
        }
    } else {
        echo '<script>alert("User not found.")</script>';
    }
    $stmt->close();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Beauty Parlour Management System | Change Password</title>
    <!-- Template CSS -->
    <link rel="stylesheet" href="assets/css/style-starter.css">
    <link href="https://fonts.googleapis.com/css?family=Josefin+Slab:400,700,700i&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
  </head>
  <body id="home">
<?php include_once('includes/header.php');?>

<script src="assets/js/jquery-3.3.1.min.js"></script>
<script src="assets/js/bootstrap.min.js"></script>
<script>
$(function () {
  $('.navbar-toggler').click(function () {
    $('body').toggleClass('noscroll');
  })
});
function checkpass() {
    if(document.changepassword.newpassword.value != document.changepassword.confirmpassword.value) {
        alert('New Password and Confirm Password field does not match');
        document.changepassword.confirmpassword.focus();
        return false;
    }
    return true;
}
</script>

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                Change Password
            </h3>
            <p class="tiltle-para ">Lorem ipsum dolor sit amet consectetur, adipisicing elit. Hic fuga sit illo modi aut aspernatur tempore laboriosam saepe dolores eveniet.</p>
        </div>
</div>
</div>
<div class="breadcrumbs-sub">
<div class="container">   
<ul class="breadcrumbs-custom-path">
    <li class="right-side propClone"><a href="index.php" class="">Home <span class="fa fa-angle-right" aria-hidden="true"></span></a> <p></li>
    <li class="active ">
        Change Password</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec">
        <div class="container">
            <div class="d-grid contact-view">
                <div class="cont-details">
                    <?php
                    $ret = mysqli_query($con, "SELECT * FROM tblpage WHERE PageType='contactus'");
                    while ($row = mysqli_fetch_array($ret)) {
                    ?>
                    <div class="cont-top">
                        <div class="cont-left text-center">
                            <span class="fa fa-phone text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Call Us</h6>
                            <p class="para"><a href="tel:+44 99 555 42">+<?php echo htmlspecialchars($row['MobileNumber']); ?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-envelope-o text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Email Us</h6>
                            <p class="para"><a href="mailto:example@mail.com" class="mail"><?php echo htmlspecialchars($row['Email']); ?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Address</h6>
                            <p class="para"><?php echo htmlspecialchars($row['PageDescription']); ?></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Time</h6>
                            <p class="para"><?php echo htmlspecialchars($row['Timing']); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="map-content-9 mt-lg-0 mt-4">
                    <h3>Password change!!</h3>
                    <form method="post" name="changepassword" onsubmit="return checkpass();">
                        <div style="padding-top: 30px;">
                            <label>Current Password</label>
                            <input type="password" class="form-control" placeholder="Current Password" id="currentpassword" name="currentpassword" required>
                        </div>
                        <div style="padding-top: 30px;">
                            <label>New Password</label>
                            <input type="password" class="form-control" placeholder="New Password" id="newpassword" name="newpassword" required>
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Confirm Password</label>
                            <input type="password" class="form-control" placeholder="Confirm Password" id="confirmpassword" name="confirmpassword" required>
                        </div>
                        <button type="submit" class="btn btn-contact" name="change">Save Change</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php');?>
<!-- move top -->
<button onclick="topFunction()" id="movetop" title="Go to top">
    <span class="fa fa-long-arrow-up"></span>
</button>
<script>
window.onscroll = function () { scrollFunction(); };
function scrollFunction() {
    if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
        document.getElementById("movetop").style.display = "block";
    } else {
        document.getElementById("movetop").style.display = "none";
    }
}
function topFunction() {
    document.body.scrollTop = 0;
    document.documentElement.scrollTop = 0;
}
</script>
<!-- /move top -->
</body>
</html>