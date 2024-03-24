<?php
  session_start();
  if (isset($_SESSION['UID'])) {
    $CID = @$_POST['CID'];
    include("./DBconnection.php");
    $deletecredit = "DELETE FROM user_creditcard_relation WHERE user_creditcard_relation.CID='$CID'";
    $deletecredit_result = mysqli_query($conn, $deletecredit);

    $conn->close();
    header("Refresh:0;url=./personalCreditCard.php");
  }
  else{
    header("Refresh:0;url=./home.php");
  }
?>