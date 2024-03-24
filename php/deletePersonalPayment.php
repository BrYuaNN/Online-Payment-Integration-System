<?php
    session_start();
    $UID=$_SESSION['UID'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.4/dist/leaflet.css" integrity="sha512-puBpdR0798OZvTTbP4A8Ix/l+A4dHDD0DGqYW6RQ+9jxkRFclaxxQb/SJAWZfWAkuyeQUytO7+7N4QKrDh+drA==" crossorigin=""/>
  
    <link rel="stylesheet" href="../css/style.css">
    <link rel="icon" href="../img/LOGO.ico" type="image/x-icon"/>
    <title>Personal Credit Delete</title>
</head>

<body>
    <div class="payContainer">
        <div class="logoContainer">
            <a href="./home.php">
                <img  src="../img/LOGO.png" alt="MaPaY-Logo" class="logo">
            </a>
        </div>
        <h1>Delete Mobile Pay</h1>
        <ul>
            <?php
                if (isset($_SESSION['UID'])) {
                    // echo "<li><span>行動支付</span></li>";
                    include("./DBconnection.php");
                    $queryPersonalPaymentInfo = "SELECT P.payment_PID,P.payment_template FROM payment P WHERE P.payment_PID IN(SELECT UPR.PID FROM user_payment_relation UPR WHERE UPR.UID='$UID')";
                    $queryPersonalPaymentInfo_result = mysqli_query($conn, $queryPersonalPaymentInfo);
                    $resultcheck = mysqli_num_rows($queryPersonalPaymentInfo_result);
                    if($queryPersonalPaymentInfo_result){
                        if ($resultcheck > 0) {
                            while ($row = mysqli_fetch_array($queryPersonalPaymentInfo_result)) {
                                $PID=$row['payment_PID'];
                                echo "<li><span><form action='deletePersonalPaymentDB.php' method='POST'>".$row['payment_template']."</span><input type='hidden' name='PID' value='$PID'><br><input type='submit' name='submit' value='刪除'></form></span></li>";
                            }
                        }
                        echo "</ul>";
                    }
                    else{
                    }

                    //mysqli_free_result($querycreditcardinfo_result);
                    $conn->close();
                    echo '<div class="btns"><a href="./personalPayment.php">取消</a></div>';
                } else {
                    header("Refresh:0;url=./home.php");
                }
            ?>
    </div>
</body>

</html>