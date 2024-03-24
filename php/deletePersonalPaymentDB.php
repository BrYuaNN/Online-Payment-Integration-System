<?php
  session_start();
  if (isset($_SESSION['UID'])) {
    $UID=$_SESSION['UID'];  
    $PID = $_POST['PID'];
    
    // echo "$UID";
    // echo "$PID";
    
    include("./DBconnection.php");
    $deletePersonalPayment = "DELETE FROM user_payment_relation WHERE user_payment_relation.UID='$UID' AND user_payment_relation.PID='$PID'";
    $deletePersonalPayment_result = mysqli_query($conn, $deletePersonalPayment);
    
    if($deletePersonalPayment_result){
      $conn->close();
      header("Refresh:0;url=./personalPayment.php");
    }else{
      echo "fail";
    }
  }
  else{
    header("Refresh:0;url=./home.php");
  }
?>