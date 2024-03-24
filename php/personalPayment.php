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
    <title>Personal Credit Info</title>
</head>

<body>
    <div class="payContainer">
        <div class="logoContainer">
            <a href="./home.php">
                <img  src="../img/LOGO.png" alt="MaPaY-Logo" class="logo">
            </a>
        </div>
        <h1>My Mobile Pay</h1>
        <ul>
            <?php
                if (isset($_SESSION['UID'])) {
                    // echo "<li><span>行動支付</span></li>";
                    include("./DBconnection.php");
                    $queryPersonalPaymentInfo = "SELECT P.payment_template FROM payment P WHERE P.payment_PID IN(SELECT UPR.PID FROM user_payment_relation UPR WHERE UPR.UID='$UID')";
                    $queryPersonalPaymentInfo_result = mysqli_query($conn, $queryPersonalPaymentInfo);
                    
                    if($queryPersonalPaymentInfo_result){
                        $resultcheck = mysqli_num_rows($queryPersonalPaymentInfo_result);
                        if ($resultcheck > 0) {
                            while ($row = mysqli_fetch_array($queryPersonalPaymentInfo_result)) {
                                echo "<li><span>".$row['payment_template']."</span></li>";
                            }
                        }    
                        echo "</ul>";
                    }
                    else{
                        echo "fail";
                    }
                    
                    //mysqli_free_result($querycreditcardinfo_result);
                    $conn->close();
                    echo '<div class="btns"><a href="./deletePersonalPayment.php">刪除</a><a href="./addPersonalPayment.php">新增</a></div>';
                } else {
                    header("Refresh:0;url=./home.php");
                }
            ?>
    </div>
</body>
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/burger.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="../js/all.js"></script>
</html>