<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('includes/dbconnection.php');

if (isset($_POST['submit'])) {
    $contactno = $_POST['contactno'] ?? '';
    $email = $_POST['email'] ?? '';
    $newpassword = $_POST['newpassword'] ?? '';
    $confirmpassword = $_POST['confirmpassword'] ?? '';

    if ($newpassword !== $confirmpassword) {
        echo "<script>alert('New Password and Confirm Password field do not match.');</script>";
    } else {
        // Check if user exists
        $stmt = $con->prepare("SELECT ID FROM tbluser WHERE Email = ? AND MobileNumber = ?");
        $stmt->bind_param("ss", $email, $contactno);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $newHashed = password_hash($newpassword, PASSWORD_DEFAULT);
            $stmt->close();

            $update = $con->prepare("UPDATE tbluser SET Password = ? WHERE Email = ? AND MobileNumber = ?");
            $update->bind_param("sss", $newHashed, $email, $contactno);
            if ($update->execute()) {
                echo "<script>alert('Password successfully changed');</script>";
            } else {
                echo "<script>alert('Something went wrong. Please try again.');</script>";
            }
            $update->close();
        } else {
            echo "<script>alert('Invalid Details. Please try again.');</script>";
        }
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Beauty Parlour Management System | Forgot Password Page</title>
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
    if(document.forgot.newpassword.value != document.forgot.confirmpassword.value) {
        alert('New Password and Confirm Password field do not match');
        document.forgot.confirmpassword.focus();
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
                Forgot Password
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
        Forgot Password</li>
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
                            <p class="para"><a href="tel:+44 99 555 42">+<?= htmlspecialchars($row['MobileNumber']); ?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-envelope-o text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Email Us</h6>
                            <p class="para"><a href="mailto:<?= htmlspecialchars($row['Email']); ?>" class="mail"><?= htmlspecialchars($row['Email']); ?></a></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Address</h6>
                            <p class="para"><?= htmlspecialchars($row['PageDescription']); ?></p>
                        </div>
                    </div>
                    <div class="cont-top margin-up">
                        <div class="cont-left text-center">
                            <span class="fa fa-map-marker text-primary"></span>
                        </div>
                        <div class="cont-right">
                            <h6>Time</h6>
                            <p class="para"><?= htmlspecialchars($row['Timing']); ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
                <div class="map-content-9 mt-lg-0 mt-4">
                    <h3 style="padding-bottom: 10px;">Reset your password and Fill below details</h3>
                    <form method="post" name="forgot" onsubmit="return checkpass();">
                        <div>
                            <input type="text" class="form-control" name="email" placeholder="Enter Your Email" required>
                        </div>
                        <div style="padding-top: 30px;">
                            <input type="text" class="form-control" name="contactno" placeholder="Contact Number" required pattern="[0-9]+">
                        </div>
                        <div style="padding-top: 30px;">
                            <input type="password" class="form-control" id="newpassword" name="newpassword" placeholder="New Password" required>
                        </div>
                        <div style="padding-top: 30px;">
                            <input type="password" class="form-control" id="confirmpassword" name="confirmpassword" placeholder="Confirm Password" required>
                        </div>
                        <div class="twice-two" style="padding-top: 30px;">
                            <a class="link--gray" style="color: blue;" href="login.php">signin</a>
                        </div>
                        <button type="submit" class="btn btn-contact" name="submit">Reset</button>
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