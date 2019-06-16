<?php
  //initiate session with userId and userType
  session_start($options = ["userId", "userType"]);
  require "dbh.inc.php";

  $userId = $_SESSION["userId"];


  //Create the query and turn it to a prepared statement
  $sql1 = "SELECT store_id FROM store_manager WHERE user_id=?;";
  $stmt1 = mysqli_stmt_init($conn);
  if(!mysqli_stmt_prepare($stmt, $sql)) {
    //If this fails redirect back with error
    header("Location: ../login.php?error=sqlerror");
    exit();
  }
  else {
    //bind the variable (?) in the query with $userId and execute query
    mysqli_stmt_bind_param($stmt1, "s", $userId);
    mysqli_stmt_execute($stmt1);
    $result = mysqli_stmt_get_result($stmt1);
    //If the query is succesful, put the result in associative list
    if($storeManagerInfo = mysqli_fetch_assoc($result)) {
      $_SESSION["managedStore"] = $storeManagerInfo["store_id"]
    }
    else {
      //If this fails redirect back with error
      header("Location: ../login.php?error=notconnectedtostore");
      exit();
    }


    $sql = "SELECT * FROM item WHERE store_id=?;";
  }
