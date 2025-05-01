<?php

include 'components/connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['send'])){
   $name = $_POST['name'];
   $email = $_POST['email'];
   $phone = $_POST['phone'];
   $message = $_POST['message'];

   $insert_message = $conn->prepare("INSERT INTO messages(name, email, phone, message) VALUES(?,?,?,?)");
   $insert_message->execute([$name, $email, $phone, $message]);

   $success_msg[] = 'Message sent successfully!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Beauty Bliss | Contact</title>
   <link rel="stylesheet" href="css/style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="contact">
   <h1 class="heading"> <span>Contact</span> Us </h1>

   <div class="row">

      <form action="" method="post">
         <h3>Get in touch</h3>
         <input type="text" name="name" required placeholder="Your Name" class="box">
         <input type="email" name="email" required placeholder="Your Email" class="box">
         <input type="text" name="phone" required placeholder="Your Phone" class="box">
         <textarea name="message" class="box" required placeholder="Your Message" cols="30" rows="10"></textarea>
         <input type="submit" value="Send Message" name="send" class="btn">
      </form>

      <div class="info">
         <h3>Contact Info</h3>
         <p><i class="fas fa-map-marker-alt"></i> 123 Beauty Lane, City, Country</p>
         <p><i class="fas fa-phone"></i> +123-456-7890</p>
         <p><i class="fas fa-envelope"></i> info@beautybliss.com</p>

         <iframe src="https://www.google.com/maps/embed?..." frameborder="0" style="border:0; width:100%; height:250px;" allowfullscreen></iframe>
      </div>

   </div>
</section>

<?php include 'components/footer.php'; ?>

<script src="js/script.js"></script>

</body>
</html>
