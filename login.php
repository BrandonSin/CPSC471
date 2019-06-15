<?php
  session_start();
  include_once "./includes/dbh.inc.php";
?>
<!DOCTYPE html>
<html>
<head>

 <script>
 function goBack() {
  window.history.back()
}
 </script>
  <script src="https://kit.fontawesome.com/8b234391c4.js"></script>
 <link rel="stylesheet" href="style.css">
<style>
 body, html {
 height: 100%;
 margin: 0;
 }
.bg {
  background-image: url("images/foodBorder.jpg");
  height: 100%;
  background-position: center;
  background-repeat: no-repeat;
  background-size: cover;

 }


</style>
</head>
<body>
 <div class="bg"></div>
 <div class="login-box-wrapper">
   <h1>Garland's Groceries</h1>
 <div class="login-box">
  <h2>Login</h2>
  <form action="includes/login.inc.php" method="post">
    <div class="textbox">
      <i class="fas fa-child"></i>
      <input type="text" placeholder="Username" onfocus="this.placeholder = ''" onBlur="this.placeholder = 'Username'" name="username" value="">
    </div>
    <div class ="textbox">
      <i class="fas fa-unlock"></i>
      <input type ="password" placeholder="Password" onfocus="this.placeholder = ''" onBlur="this.placeholder = 'Password'" name="password" value="">
    </div>
    <input class="btn" type="submit" name="login-submit" value="Sign in">
  </form>

 <p class="error">
   <?php
     if(isset($_GET["error"])) {
       if($_GET["error"] == "nouser") {
         echo 'The username you entered does not exist.';
       }
       else if($_GET["error"] == "emptyfields") {
         echo 'Please enter your username and password.';
       }
       else if($_GET["error"] == "sqlerror") {
         echo 'There was a problem with the database.';
       }
       if($_GET["error"] == "wrongpassword") {
         echo 'Incorrect password.';
       }
     }
   ?>
 </p>
</div>
</div>

</body>
</html>
