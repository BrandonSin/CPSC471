<?php
  //initiate session with userId and userType
  session_start($options = ["userId", "userType"]);
  include_once "./includes/dbh.inc.php";

  //If userId is empty in the session, redirect back to login
  if(!isset($_SESSION["userId"])) {
    header("Location: ./login.php");
    exit();
  }

  $userId = $_SESSION["userId"];
?>

<!DOCTYPE html>

<html>
<head>
  <link rel="stylesheet"
    href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
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

  .store-name{
    border-bottom: 4px solid #ff8f85;
    width: fit-content;
  }

  .new-item-btn{
    border: none;
    background: #ff8f85;
    outline: none !important;
    box-shadow: none;
    border-radius: 15px;
    color: white;
    transition: background-color ease-in-out 0.1s;
    height: 35px;
  }
  .new-item-btn:hover{
    background-color: #f3645c;
  }

  .new-item-btn:active{
    background-color: #eb413d;
  }

  .store-manage-container{
    margin-left: 3% !important;
  }

  .item-list-wrapper{
    width: 750px;
    transform: translateX(-60px);
  }

  .item-wrapper{
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .item-img{
    height: 200px;
    padding: 10px;
  }

  /*================================================================================================*/
  /* THIS CODE IS USED FROM https://www.w3schools.com/howto/tryit.asp?filename=tryhow_css_modal
    /* The Modal (background) */
  .modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
  }

  /* Modal Content */
  .modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
  }

  /* The Close Button */
  .close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
  }

  .close:hover,
  .close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
  }
  /*================================================================================================*/
</style>


</head>

<body>
<h1 id="borderImage"><font face = "verdana">CC's Grocery Online Store</h1>

 <br><br>
 <div class="container store-manage-container">
   <h2 class="mb-4 store-name">
     <?php
      //Create the query and turn it to a prepared statement
      $storeIdQuery = "SELECT name FROM grocery_store WHERE store_id = (SELECT store_id FROM store_manager WHERE user_id='" . $userId . "');";
      $resultStore = mysqli_query($conn, $storeIdQuery);
      if(mysqli_num_rows($resultStore) > 0) {
        $row = mysqli_fetch_array($resultStore);
        $storeName = $row["name"];
        echo $storeName;
      }
      else{
        echo "No name";
      }
     ?>
   </h2>
   <div class="row">
     <h3 class="col-2">Items</h3>
     <button class="col-2 new-item-btn" id="modalBtn">New item</button>
   </div>
   <div class="mt-4 row item-list-wrapper">
     <?php
      $allItemsQuery = "SELECT * FROM item WHERE store_id = (SELECT store_id FROM store_manager WHERE user_id='" . $userId . "');";
      $resultItems = mysqli_query($conn, $allItemsQuery);
      if(mysqli_num_rows($resultItems) > 0) {
        while($row = mysqli_fetch_array($resultItems)){
          $itemName = $row["name"];
          $itemImg = $row["image"];
          echo(
            "<div class=\"col-4 item-img\" >".
              "<div class=\"item-wrapper\">".
                "<img src=\"data:image/jpeg;base64,".base64_encode($itemImg)."\" height=\"100px\" width=\"100px\"/>".
                "$itemName".
                "<button class=\"new-item-btn mt-2\" id=\"deleteItem\">Delete</button>".
              "</div>".
            "</div>"
          );
        }
      }
     ?>
   </div>
  </div>
</body>
</html>
