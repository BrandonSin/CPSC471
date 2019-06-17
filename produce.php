<!-- https://www.youtube.com/watch?v=0wYSviHeRbs -->
<?php
  //initiate session with userId and userType
  session_start($options = ["userId", "userType", "cartId"]);
  include_once "./includes/dbh.inc.php";

  //If userId is empty in the session, redirect back to login
  if(!isset($_SESSION["userId"])) {
    header("Location: ./login.php");
    exit();
  }
  $userId = $_SESSION["userId"];
  $cartId = "";
  $cartQuery = "SELECT cart_id FROM shopping_cart WHERE active=1 AND user_id=\"$userId\"";
  $cartResult = mysqli_query($conn, $cartQuery);
  if(mysqli_num_rows($cartResult) > 0) {
    $row = mysqli_fetch_array($cartResult);
    $cartId = $row["cart_id"];
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

  .remove-item{
    background: none;
    outline: none;
    border: none;
    color: #e60000;
  }
  .remove-item:hover{
    color: #f3645c;
  }

  .remove-item:active{
    color: #eb413d;
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
    padding: 0 10px 0 10px;
  }
  .new-item-btn:hover{
    background-color: #f3645c;
  }

  .new-item-btn:active{
    background-color: #eb413d;
  }
 </style>
 </head>




<body>
<h1 id="borderImage"><font face = "verdana">GrocerEasy</h1>
<ul>
  <li><a href="index.php">Home</a></li>
  
  <li><a class="active" href="produce.php">Catalog</a></li>
  <li><a href="shoppingCart.php">Shopping Cart</a></li>
  
  <li2><a href="logout.php">Logout</a></li2>
 </ul>
 <br />
<div class="container" style="width:700px;">
  <h3 align="center">Catalog</h3><br/>


<?php
  if(isset($_GET["error"])){
    if($_GET["error"] == "noitems"){
      echo "<div style=\"color: red;\">Error: Please add an item to your cart.</div>";
    }
    if($_GET["error"] == "couponnotexist"){
      echo "<div style=\"color: red;\">Error: That is an invalid coupon code.</div>";
    }
    if($_GET["error"] == "usedcoupon"){
      echo "<div style=\"color: red;\">Error: That coupon is already used.</div>";
    }
  }

require "includes/dbh.inc.php";
$sql = "SELECT * FROM item ORDER BY item_id ASC";
$result = $conn->query($sql);
if(mysqli_num_rows($result)>0)
{
  while($row = mysqli_fetch_array($result)) {
    $itemImg = $row["image"];
    $itemId = $row["item_id"];
    ?>
    <div class ="mt-4 row item-list-wrapper">
      <div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">

      <?php
      echo "<img src =\"data:image/jpeg;base64,".base64_encode($itemImg)."\" height=\"100px\" width=\"100px\"/>";
      ?>

      <h4 class="text-info"><?php echo $row["name"]; ?></h4>
      <?php
        if($row["is_on_sale"] == 1) {
          echo(
            "<h4 style=\"color: red;\">SALE: ".$row["percent_off"]."% OFF</h4>".
            "<h4 class=\"text-danger\" style=\"text-decoration: line-through\">".$row["price"]."</h4>".
            "<h4 class=\"text-danger\">".$row["sale_price"]."</h4>"
          );
        }
        else {
          echo(
            "<h4 class=\"text-danger\">".$row["price"]."</h4>"
          );
        }
      ?>
      <h4 class="text-info"><?php echo $row["description"]; ?></h4>
      <h4 class="text-info">Stock:<?php echo $row["stock"]; ?></h4>
      <form action="includes/addtocart.inc.php" method="post">
      <input type="text" name="quantity" class="form-control" value="1" />
      <input type="hidden" name="item-id" value= "<?php echo $itemId ?>" />
      <input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="Add to Cart" />
  	  </form>

  	  <?php

  	  	if(isset($_POST["add_to_cart"])){
          $itemId = $_POST["item-id"];
          $quantity = $_POST["quantity"];
          $sql = "SELECT * FROM is_put_in WHERE user_id=$userId AND cart_id=$cartId AND item_id=$itemId";
          $result = mysqli_query($conn, $sql);
          if(mysqli_num_rows($result) > 0) {
            $sql = "UPDATE is_put_in SET quantity_of_item=quantity_of_item+$quantity WHERE cart_id=$cartId AND user_id=\"$userId\" AND item_id=\"$itemId\"";
            if (mysqli_query($conn, $sql)) {
              header("Location: ../produce.php?addtocart=success");
              exit();
            } else {
              header("Location: ../produce.php?addtocart=error");
              exit();
            }
          }
          else {
            $sql = "INSERT INTO is_put_in (item_id, user_id, cart_id, quantity_of_item) VALUES ('$itemId','$userId','$cartId','$quantity')";
            if (mysqli_query($conn, $sql)) {
              header("Location: ../produce.php?addtocart=success");
              exit();
            } else {
              header("Location: ../produce.php?addtocart=error");
              exit();
            }
          }
  	  	}
  	  ?>
    </div>
    </div>
    <?php
  }

}


?>
  <div style="clear:both"></div>
      <br />
      <h3>Shopping Cart</h3>
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
            $total = 0;
            $sql = "SELECT S.item_id, S.name, S.price, S.is_on_sale, S.sale_price, I.quantity_of_item FROM item S INNER JOIN is_put_in I ON I.item_id=S.item_id AND I.user_id=\"$userId\" AND I.cart_id=$cartId";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
              while($row = mysqli_fetch_array($result)){
          ?>
              <tr>
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["quantity_of_item"]; ?></td>
                <td>$
                  <?php
                    if($row["is_on_sale"] == 1) {
                      echo $row["sale_price"];
                    }
                    else {
                      echo $row["price"];
                    }
                  ?>
                </td>
                <td>$
                  <?php
                    if($row["is_on_sale"] == 1) {
                      echo $row["sale_price"] * $row["quantity_of_item"];
                    }
                    else {
                      echo $row["price"] * $row["quantity_of_item"];
                    }
                  ?>
                </td>
                <td>
                  <form action="includes/removefromcart.php" method="post">
                    <input class="remove-item" type="submit" name="remove-item" value="Remove">
                    <input type="hidden" name="item-id" value="<?php echo $row["item_id"]; ?>">
                  </form>
                </td>
              </tr>
          <?php
              }
            }

            $sql="SELECT * FROM shopping_cart WHERE user_id=\"$userId\" AND cart_id=$cartId";
            $result = mysqli_query($conn, $sql);
            if(mysqli_num_rows($result) > 0) {
              $row = mysqli_fetch_array($result);
              $total = $row["total_price"];
            }
          ?>
          <tr>
            <td colspan="5" align="left">
              <?php
                $sql = "SELECT * FROM is_applied_to WHERE cart_id='$cartId' AND user_id='$userId'";
                $result = mysqli_query($conn, $sql);
                if(mysqli_num_rows($result) > 0) {
                  $row = mysqli_fetch_assoc($result);
                  echo "Coupon code ".$row["coupon_code"]." is already applied.";
                }
                else{
              ?>
              <div>Apply Coupon Code: </div>
              <form action="includes/applycoupon.inc.php" method="post" style="text-align: end;">
                <input type="text" placeholder="coupon code" name="coupon-code">
                <input type="submit" class="new-item-btn" name="apply-coupon" value="Apply">
              </form>
              <?php
                }
              ?>
            </td>
          </tr>
          <tr>

            <td colspan="3" align="right">Total</td>
            <td align="right">
              <?php
                $sql = "SELECT * FROM shopping_cart WHERE cart_id='$cartId' AND user_id='$userId'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                if($row["discounted_price"] != NULL) {
                  echo(
                    "<div style=\"text-decoration: line-through\">$".$row["total_price"]." </div>".
                    "<div>$".$row["discounted_price"]."</div>"
                  );
                }
                else {
                  echo("\$$total");
                }
              ?>
            </td>
            <td></td>
          </tr>
        </table>

        <form action="includes/placeorder.inc.php" method="post" style="text-align: end;">
          <input type="submit" class="new-item-btn" name="generate-order" value="Place Order">
        </form>
      </div>
    </div>
  </div>
  <br />
  </body>
</html>
