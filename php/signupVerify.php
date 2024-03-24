<?php
  session_start();
  $Uname = @$_POST['Uname'];
  $Uemail = @$_POST['Uemail'];
  $Upassword = @$_POST['Upassword'];
  if($Uname==null || $Uemail==null || $Upassword==null){
    header("Refresh:0;url=../signup.html");
  }
  else{
  include("./DBconnection.php");
    $insert = "INSERT INTO `user` (`user_UID`, `user_name`, `user_password`, `user_email`) VALUES (NULL, '$Uname', '$Upassword', '$Uemail');";
    $insert_result = mysqli_query($conn, $insert);

    if ($insert_result) {
      $queryID = "SELECT * FROM `user` WHERE `user_email` = '$Uemail'";
      $queryID_result = mysqli_query($conn, $queryID);
      $row=mysqli_fetch_assoc($queryID_result);
      $_SESSION['UID'] = $row['user_UID'];
      //echo $_SESSION['UID'];
      header("Refresh:0;url=./home.php");
    } 

    $conn->close();
  }
?>