<?php
 if (isset($_POST['register-submit'])){
   include_once "./dbh.inc.php";
  $username = mysqli_real_escape_string($conn, $_POST['input-username']);
  $password_1 = mysqli_real_escape_string($conn, $_POST['password_1']);
  $password_2 = mysqli_real_escape_string($conn, $_POST['password_2']);
  echo"hi";

  if(empty($username)){
    echo "empty username";
  }

 if(empty($password_1)){
      echo "empty pass1";
 }

 if(empty($password_2)){
     echo "empty pass2";
 }

       if($password_1 != $password_2){
         echo "mismatch pass";

     }

    $result = mysqli_query($conn, "SELECT user_id FROM user WHERE user_id = '$username'");
     if(mysqli_num_rows($result) == 0) {
       $password = $password_1;
       //insert new user
       $sql = "INSERT INTO user (user_id, password) VALUES('$username', '$password')";
       mysqli_query($conn, $sql);

       $newCartId = rand(0, 99999999);

       //create cart for new user
       $sql = "INSERT INTO shopping_cart (cart_id, total_price, user_id, company_id, active) VALUES('$newCartId', 0, `$user_id`, `quik-parcel`, 1)";
       mysqli_query($conn, $sql);

       header("Location: ../login.php?register=success");
       exit();
     } else {
      array_push($errors, "username is already being used");
      header("Location: ../login.php?register=error");
     }

}
?>
