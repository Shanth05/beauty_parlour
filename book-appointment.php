<?php
declare(strict_types=1);
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('includes/dbconnection.php');

if (empty($_SESSION['bpmsuid'])) {
    header('location:logout.php');
    exit();
}

if (isset($_POST['submit'])) {
    $uid = $_SESSION['bpmsuid'];
    $adate = $_POST['adate'] ?? '';
    $atime = $_POST['atime'] ?? '';
    $msg = $_POST['message'] ?? '';
    $aptnumber = mt_rand(100000000, 999999999);

    // Use prepared statement for security
    $stmt = $con->prepare("INSERT INTO tblbook (UserID, AptNumber, AptDate, AptTime, Message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $uid, $aptnumber, $adate, $atime, $msg);

    if ($stmt->execute()) {
        $ret = $con->prepare("SELECT AptNumber FROM tblbook WHERE UserID = ? ORDER BY ID DESC LIMIT 1");
        $ret->bind_param("s", $uid);
        $ret->execute();
        $result = $ret->get_result();
        $row = $result->fetch_assoc();
        $_SESSION['aptno'] = $row['AptNumber'] ?? $aptnumber;
        echo "<script>window.location.href='thank-you.php'</script>";
    } else {
        echo '<script>alert("Something Went Wrong. Please try again")</script>';
    }
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Beauty Parlour Management System | Appointment Page</title>
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
</script>

<!-- breadcrumbs -->
<section class="w3l-inner-banner-main">
    <div class="about-inner contact ">
        <div class="container">   
            <div class="main-titles-head text-center">
            <h3 class="header-name ">
                Book Appointment
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
        Book Appointment</li>
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
                    <form method="post">
                        <div style="padding-top: 30px;">
                            <label>Appointment Date</label>
                            <input type="date" class="form-control appointment_date" placeholder="Date" name="adate" id="adate" required>
                        </div>
                        <div style="padding-top: 30px;">
                            <label>Appointment Time</label>
                            <input type="time" class="form-control appointment_time" placeholder="Time" name="atime" id="atime" required>
                        </div>
                        <div style="padding-top: 30px;">
                            <textarea class="form-control" id="message" name="message" placeholder="Message" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-contact" name="submit">Make an Appointment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include_once('includes/footer.php'); ?>
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
$(function(){
    var dtToday = new Date();
    var month = dtToday.getMonth() + 1;
    var day = dtToday.getDate();
    var year = dtToday.getFullYear();
    if(month < 10)
        month = '0' + month.toString();
    if(day < 10)
        day = '0' + day.toString();
    var maxDate = year + '-' + month + '-' + day;
    $('#adate').attr('min', maxDate);
});
</script>
<!-- /move top -->
</body>
</html>