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
    <title>Credit Card Info</title>
</head>

<body>
    <div class="creditContainer">
        <div class="logoContainer">
            <a href="./home.php">
                <img  src="../img/LOGO.png" alt="MaPaY-Logo" class="logo">
            </a>
        </div>
        <h1>My Credit Card</h1>
        <ul>
            <?php
                if (isset($_SESSION['UID'])) {
                    
                    include("./DBconnection.php");
                    $querycreditcardinfo = "SELECT C.creditcard_CID,B.name,C.creditcard_category,C.creditcard_Domestic,C.creditcard_MobilePayment FROM credit_card C,user_creditcard_relation UCR,bank B WHERE UCR.UID='$UID' AND C.creditcard_CID=UCR.CID AND C.creditcard_bank=B.BID ORDER BY C.creditcard_bank";
                    $querycreditcardinfo_result = mysqli_query($conn, $querycreditcardinfo);
                    if($querycreditcardinfo_result){
                        // echo "success";
                        $resultcheck = mysqli_num_rows($querycreditcardinfo_result);
                        if ($resultcheck > 0) {
                            while ($row = mysqli_fetch_array($querycreditcardinfo_result)) {
                                echo '<li class="creditCard creditCard'.$row['creditcard_CID'].'" id="test"><span>'.$row['name'].'<br>'.$row['creditcard_category'].'</span><div class="feedback feedback'.$row['creditcard_CID'].'"><span>國內消費現金回饋: '.$row['creditcard_Domestic'].'<br>行動支付回饋:'.$row['creditcard_MobilePayment'].'</span></div></li>';
                            }
                        }    
                        echo "</ul>";
                    }
                    else{
                        echo "fail";
                    }
                    //mysqli_free_result($querycreditcardinfo_result);
                    $conn->close();
                    echo '<div class="btns"><a href="./deletePersonalCreditCard.php">刪除</a><a href="./addPersonalCreditCard.php">新增</a></div>';
                    // echo "<li><a href='./addPersonalCreditCard.php'>新增</a></li>";
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
<script src="../js/scroll.js"></script>
</html>