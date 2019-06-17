<?php
  if(isset($_POST["delete-btn"])) {
    //import the file with the sql connection
    require "dbh.inc.php";

    $itemId = $_POST["delete-item-id"];

    $sql = "DELETE FROM item WHERE item_id=\"$itemId\"";
    if(mysqli_query($conn, $sql)) {
      header("Location: ../storemanage.php?delete=success");
      exit();
    }
    else {
      header("Location: ../storemanage.php?error=cannotdelete");
      exit();
    }
  }
  else{
    echo"fuck";
  }
?>
