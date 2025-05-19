<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
include('includes/dbconnection.php');

if (empty($_SESSION['bpmsuid'])) {
    header('location:logout.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <title>Beauty Parlour Management System | Invoice History</title>
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
                Invoice History
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
        Invoice History</li>
</ul>
</div>
</div>
    </div>
</section>
<!-- breadcrumbs //-->
<section class="w3l-contact-info-main" id="contact">
    <div class="contact-sec">
        <div class="container">
            <div>
                <div class="cont-details">
                   <div class="table-content table-responsive cart-table-content">
                    <h4 style="padding-bottom: 20px;text-align: center;color: blue;">Invoice History</h4>
                        <table class="table" border="1">
                            <thead>
                                <tr> 
                                    <th>#</th> 
                                    <th>Invoice Id</th> 
                                    <th>Customer Name</th>
                                    <th>Customer Mobile Number</th>
                                    <th>Invoice Date</th> 
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
<?php
$userid = $_SESSION['bpmsuid'];
$stmt = $con->prepare(
    "SELECT DISTINCT tbluser.ID as uid, tbluser.FirstName, tbluser.LastName, tbluser.Email, tbluser.MobileNumber, tblinvoice.BillingId, DATE(tblinvoice.PostingDate) as PostingDate
     FROM tbluser
     JOIN tblinvoice ON tbluser.ID = tblinvoice.Userid
     WHERE tbluser.ID = ?
     ORDER BY tblinvoice.ID DESC"
);
$stmt->bind_param("s", $userid);
$stmt->execute();
$result = $stmt->get_result();
$cnt = 1;
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
?>
                                <tr>
                                    <th scope="row"><?= $cnt; ?></th>
                                    <td><?= htmlspecialchars($row['BillingId']); ?></td>
                                    <td><?= htmlspecialchars($row['FirstName'] . ' ' . $row['LastName']); ?></td>
                                    <td><?= htmlspecialchars($row['MobileNumber']); ?></td>
                                    <td><?= htmlspecialchars($row['PostingDate']); ?></td>
                                    <td><a href="view-invoice.php?invoiceid=<?= urlencode($row['BillingId']); ?>" class="btn btn-info">View</a></td>
                                </tr>
<?php
        $cnt++;
    }
} else {
?>
                                <tr>
                                    <th colspan="6" style="color:red">No Record Found</th>
                                </tr>
<?php } $stmt->close(); ?>
                            </tbody>
                        </table>
                    </div>
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
window.onscroll = function () {
    scrollFunction()
};
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