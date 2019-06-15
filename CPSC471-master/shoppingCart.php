<?php
  //initiate session with userId and userType
  session_start($options = ["userId", "userType"]);
  include_once "./includes/dbh.inc.php";

  //If userId is empty in the session, redirect back to login
  if(!isset($_SESSION["userId"])) {
    header("Location: ./login.php");
    exit();
  }
?>

<!DOCTYPE html>

<html>
<head>
<style>

#borderImage {

  border: 30px solid transparent;
  padding: 30px;
  border-image-source: url(images/foodBorder.jpg);
  border-image-slice: 20;
  }
    <!-- banner font----------------------->
  h1.verdana {
    font face = "verdana";
    font size = 90px;
  }

  p {
    font face = "verdana";
    font size = 50px;
  }

   ul {
  list-style-type: none;
  padding: 0;
  margin: 0;
  overflow: hidden;
  background-color: #333;
  }

  li {
  float: left;
  }

  li a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  }

 li a:hover:not(.active) {
 background-color: #226b00;
 }
 .active {
  background-color: #226b00;
}

/*Logout Button */

 li2 {
  float: right;
  }

 li2 a {
  display: block;
  color: white;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  }

 li2 a:hover:not(.active) {
 background-color: #226b00;
 }

 </style>
 </head>




<body>
<h1 id="borderImage"><font face = "verdana">CC's Grocery Online Store</h1>
<ul>
  <li><a href="index.php">Home</a></li>
  <li><a href="Discount">Discount</a></li>
  <li><a href="produce.php">Produce</a></li>
  <li><a href="Dairy">Dairy</a></li>
  <li><a href="MnS">Meat & Seafood</a></li>
  <li><a href="Snacks">Snacks</a></li>
  <li><a class="active" href="shoppingCart.php">Shopping Cart</a></li>
  <li><a href="shoppingList.html">Shopping List</a></li>
  <li2><a href="logout.php">Logout</a></li2>

</ul>
</body>
</html>