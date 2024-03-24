<?php
    session_start();
    if (isset($_SESSION['UID'])){
        $UID = $_SESSION['UID'];
        $PID=$_POST['payment'];      
        include("./DBconnection.php");
        $addPersonalPayment = "INSERT INTO `user_payment_relation` ( `UID`, `PID`) VALUES ( '$UID', '$PID');";
        $addPersonalPayment_result = mysqli_query($conn, $addPersonalPayment);
        header("Refresh:0;url=./personalPayment.php");
    }else{
        header("Refresh:0;url=./home.php");
    }
?>