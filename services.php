<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

include 'components/wishlist_cart.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Beauty Bliss | Services</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="services">
   <h1 class="heading"> our <span>services</span> </h1>

   <div class="box-container">

      <div class="box">
         <img src="images/haircut.png" alt="Haircut">
         <h3>Hair Styling</h3>
         <p>Trendy haircuts, styling, and blow-dry services by professionals.</p>
      </div>

      <div class="box">
         <img src="images/makeup.png" alt="Makeup">
         <h3>Bridal & Party Makeup</h3>
         <p>Perfect look for your big day with our bridal & party makeup services.</p>
      </div>

      <div class="box">
         <img src="images/spa.png" alt="Spa">
         <h3>Spa & Facial</h3>
         <p>Relax with our luxury spa and facial treatment packages.</p>
      </div>

      <div class="box">
         <img src="images/nails.png" alt="Nail Art">
         <h3>Manicure & Pedicure</h3>
         <p>Pamper your hands and feet with our nail care services.</p>
      </div>

   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
