<?php
  if(isset($_POST["login-submit"])) {
    require "dbh.inc.php";

    $userId = $_POST["username"];
    $password= $_POST["password"];

    if(empty($userId) || empty($password)) {
      header("Location: ../login.php?error=emptyfields");
      exit();
    }
    else {
      $sql = "SELECT * FROM user WHERE user_id=?;";
      $stmt = mysqli_stmt_init($conn);
      if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../login.php?error=sqlerror");
        exit();
      }
      else {

        //bind the question mark in $sql with $userId
        mysqli_stmt_bind_param($stmt, "s", $userId);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if($row = mysqli_fetch_assoc($result)) {
          if($password != $row["password"]) {
            header("Location: ../login.php?error=wrongpassword");
            exit();
          }
          else if ($password == $row["password"]) {
            session_start();
            $_SESSION["userId"] = $row["user_id"];
            $_SESSION["userType"] = $row["member_type"];
            header("Location: ../index.php?login=success");
            exit();
          }
          else {
            header("Location: ../login.php?error=wrongpassword");
            exit();
          }
        }
        else {
          header("Location: ../login.php?error=nouser");
          exit();
        }
      }
    }
  }
  else {
    header("Location: ../login.php");
    exit();
  }

?>
