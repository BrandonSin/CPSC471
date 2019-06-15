<?php
  session_start($options = ["userId", "userType"]);
  include_once "./includes/dbh.inc.php";
  if(!isset($_SESSION["userId"])) {
    header("Location: ./login.php");
    exit();
  }
?>

<!DOCTYPE html>

<html>
<head>
<style>

  .slideShows {display: none;}

  #borderImage {

  border: 30px solid transparent;
  padding: 30px;
  border-image-source: url(images/foodBorder.jpg);
  border-image-slice: 20;
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

  <!-- banner font----------------------->
  h1.verdana {
    font face = "verdana";
    font size = 90px;
  }

  p {
    font face = "verdana";
    font size = 50px;
  }



</style>


</head>

<body>
<h1 id="borderImage"><font face = "verdana">CC's Grocery Online Store</h1>
<ul>
  <li><a href="index.html">Home</a></li>
  <li><a href="Discount">Discount</a></li>
  <li><a href="Produce">Produce</a></li>
  <li><a href="Dairy">Dairy</a></li>
  <li><a href="MnS">Meat & Seafood</a></li>
  <li><a href="Snacks">Snacks</a></li>
  <li><a href="shoppingCart.html">Shopping Cart</a></li>
  <li><a href="shoppingList.html">Shopping List</a></li>
  <li><a href ="login.html">Login</a></li>
</ul>

<!-- Slide Show ------------------------------------------------------------------------------->
<div class = "pictureShow">
  <img class="slideShows" img src= "images/fresh-vegetables.jpg" style="width:100%">
  <img class="slideShows" img src= "images/fresh.jpg" style="width:100%">
  <img class="slideShows" img src= "images/veggies.jpg" style="width:100%">
  </div>

<!-- Script for SlideShow ------------------------------------------------------------------------------>
  <script>
var slideIndex = 0;
slideShow();

function slideShow() {
  var i;
  var x = document.getElementsByClassName("slideShows");
  for (i = 0; i < x.length; i++) {
    x[i].style.display = "none";
  }
  slideIndex++;
  if (slideIndex > x.length) {slideIndex = 1}
  x[slideIndex-1].style.display = "block";
  setTimeout(slideShow, 2000);
}
</script>
 <br><br><br>
<p>CC's Grocer is a certified Online Grocery Store that provides fresh food and fast shipping for our beloved community.</p>

</body>
</html>
