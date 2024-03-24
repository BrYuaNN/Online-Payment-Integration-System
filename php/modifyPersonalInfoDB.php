<?php
  session_start();
  $UID=$_SESSION['UID'];
  if (isset($_SESSION['UID'])) {
    $Uname = @$_POST['Uname'];
    $Upassword = @$_POST['Upassword'];

    include("./DBconnection.php");
    $UpdateUserInfo = "UPDATE user SET user_name='$Uname' ,user_password = '$Upassword' WHERE user.user_UID ='$UID' ;";
    $UpdateUserInfo_result = mysqli_query($conn, $UpdateUserInfo);

    //mysqli_free_result($UpdateUserInfo_result);
    $conn->close();

    header("Refresh:0;url=./personalInfo.php");
  }
  else{
    header("Refresh:0;url=./home.php");
  }
?>