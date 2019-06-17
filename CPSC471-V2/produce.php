<!-- https://www.youtube.com/watch?v=0wYSviHeRbs -->
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
<?php

if(isset($_POST["add_to_cart"]))
{
  if(isset($_SESSION["shopping_cart"]))
  {
    $item_array_id = array_column($_SESSION["shopping_cart"], "id");
    if(!in_array($_GET["item_id"], $item_array_id))
    {
     
      $count = count($_SESSION["shopping_cart"]);
      $item_array = array(
        'id'     =>  $_GET["item_id"],
        'item_name'      =>  $_POST["hidden_name"],
        'item_price'   =>  $_POST["hidden_price"],
        'item_quantity'   =>  $_POST["quantity"]
      );
      array_push($_SESSION['shopping_cart'], $item_array);
    }
    else
    {
           
    }
  }
  else
  {
    $item_array = array(
      'id'     =>  $_GET["item_id"],
      'item_name'     =>  $_POST["hidden_name"],
      'item_price'    =>  $_POST["hidden_price"],
      'item_quantity'   =>  $_POST["quantity"]
    );
    $_SESSION["shopping_cart"][0] = $item_array;
    echo $_SESSION["shopping_cart"];
  }
}

if(isset($_GET["action"]))
{
  if($_GET["action"] == "delete")
  {
    foreach($_SESSION["shopping_cart"] as $keys => $values)
    {
      if($values["id"] == $_GET["item_id"])
      {
        unset($_SESSION["shopping_cart"][$keys]);
        echo '<script>alert("Item Removed")</script>';
      
      }
    }
  }
}

?>



<!DOCTYPE html>

<html>
<head>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js">
  </script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js">
    </script>
<style> 

#borderImage {

  border: 30px solid transparent;
  padding: 30px;
  border-image-source: url(images/foodBorder.jpg);
  border-image-slice: 20;
  }
   
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
  background-color: #226b00;;
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
  <li><a class="active" href="produce.php">Catalog</a></li>
  <li><a href="shoppingCart.php">Shopping Cart</a></li>
  <li><a href="shoppingList.php">Shopping List</a></li>
  <li2><a href="logout.php">Logout</a></li2>
 </ul>
 <br />
<div class="container" style="width:700px;">
  <h3 align="center">Catalog</h3><br/>


<?php
require "includes/dbh.inc.php";
$sql = "SELECT * FROM item ORDER BY item_id ASC";
$result = $conn->query($sql);
if(mysqli_num_rows($result)>0)
{
  while($row = mysqli_fetch_array($result)) {
    $itemImg = $row["image"];
    ?>
    <div class ="mt-4 row item-list-wrapper">
      <form method="post" action="produce.php?action=add&item_id=<?php echo $row["item_id"]; ?>">
      <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
      
      <?php
      echo "<img src =\"data:image/jpeg;base64,".base64_encode($itemImg)."\" height=\"100px\" width=\"100px\"/>";
      ?>

      <h4 class="text-info"><?php echo $row["name"]; ?></h4>
      <h4 class="text-danger">$ <?php echo $row["price"]; ?></h4>
      <h4 class="text-info"><?php echo $row["description"]; ?></h4>
      <h4 class="text-info">Stock:<?php echo $row["stock"]; ?></h4>
      <form action="produce.php" method="post">
      <input type="text" name="quantity" class="form-control" value="1" />
      <input type="hidden" name="username" value= "<?php $_SESSION["userId"]; ?>" />
      <input type="hidden" name="hidden_id" value= "<?php echo $row["item_id"]; ?>" />
      <input type="hidden" name="hidden_name" value="<?php echo $row["name"]; ?>" />
      <input type="hidden" name="hidden_price" value="<?php echo $row["price"]; ?>" />
      <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
      

  	  </form>

  	  <?php
  	 
  	  	if(isset($_POST["add_to_cart"])){
          $name = $_POST["hidden_name"];
          //convert int to string for cart ID
          $var = rand(1,10000);
          $cartid = strval($var);
      		$food = "INSERT INTO is_put_in (item_id, user_id, cart_id, quantity_of_item) VALUES ('".$_POST["hidden_id"]."','".$_SESSION["userId"]."','".$cartid."','".$_POST["quantity"]."')";
		if (mysqli_query($conn, $food)) {
               echo "New record created successfully";
            } else {
               echo "Error: " . $food . "" . mysqli_error($conn);
            }

  	  	}
  	  ?>
  	

      

    </div>
    </form>
    </div>
    <?php
  }
  
}


?>
  <div style="clear:both"></div>
      <br />
      <h3>Order Details</h3>
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th width="40%">Item Name</th>
            <th width="10%">Quantity</th>
      
           
            <th width="20%">Price</th>
            <th width="15%">Total</th>
            <th width="5%">Action</th>
          </tr>
          <?php
          if(!empty($_SESSION["shopping_cart"]))
          {
            $total = 0;
            foreach($_SESSION["shopping_cart"] as $keys => $values)
            {
          ?>
          <tr>
            <td><?php echo $values["item_name"]; ?></td>
            <td><?php echo $values["item_quantity"]; ?></td>
            
            
            <td>$ <?php echo $values["item_price"]; ?></td>
            <td>$ <?php echo number_format($values["item_quantity"] * $values["item_price"], 2);?></td>
            <td><a href="index.php?action=delete&item_id=<?php echo $values["id"]; ?>"><span class="text-danger">Remove</span></a></td>
          </tr>
          <?php
              $total = $total + ($values["item_quantity"] * $values["item_price"]);
            }
          ?>
          <tr>
            <td colspan="3" align="right">Total</td>
            <td align="right">$ <?php echo number_format($total, 2); ?></td>
            <td></td>
          </tr>
          <?php
          }
          ?>
            
        </table>
      </div>
    </div>
  </div>
  <br />
  </body>
</html>







<!--  
if($result->num_rows > 0){
  echo "<table><tr><th>Food</th><th>Price</th></tr>";

  //output data of each row
  while($row = $result->fetch_assoc()) {
     echo "<tr><td>" . $row["name"]. "</td><td>" . $row["price"]. "</td></tr>";
      
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close(); 
-->