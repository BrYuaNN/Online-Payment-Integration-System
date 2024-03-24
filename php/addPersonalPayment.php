<?php
    session_start();
    $UID = $_SESSION['UID'];
    // $UID=1;
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
    <title>Add Pay</title>
</head>

<body>
    <div class="payContainer">
        <div class="logoContainer">
            <a href="./home.php">
                <img  src="../img/LOGO.png" alt="MaPaY-Logo" class="logo">
            </a>
        </div>
        <?php
        if (isset($_SESSION['UID'])) {
            include("./DBconnection.php");
            $querypaymentinfo = "SELECT P.payment_PID,P.payment_template FROM payment P WHERE P.payment_PID NOT IN (SELECT UPR.PID FROM user_payment_relation UPR WHERE UPR.UID='$UID')";
            $querypaymentinfo_result = mysqli_query($conn, $querypaymentinfo);
            $querypaymentinfo_resultcheck = mysqli_num_rows($querypaymentinfo_result);
            //echo "$querypaymentinfo_resultcheck";
            echo "<h1>Add A Payment</h1>";
            if ($querypaymentinfo_resultcheck > 0) {
                echo "<form action='./addPersonalPaymentDB.php' method='POST'>";
                echo "<select name='payment'>";
                echo "<option selected disable>--SELECT--</option>";
                while ($row = mysqli_fetch_array($querypaymentinfo_result)) {
                    $PID = $row['payment_PID'];
                    $Payment = $row['payment_template'];
                    //echo "<option value='$creditcardbank'>$creditcardbank</option>";
                    echo "<option value='$PID'>$Payment</option>";
                }
                echo "</select>";
                echo "<input type='submit' value='新增'>";
                echo "</form>";
                // echo "";
            }

            //mysqli_free_result($querycreditcardinfo_result);
            $conn->close();
        } else {
           header("Refresh:0;url=./home.php");
        }
        ?>
    </div>
</body>
</html>