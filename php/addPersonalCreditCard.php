<?php
    session_start();
    $UID = $_SESSION['UID'];
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
    <title>Add Credit Card</title>
</head>

<body>
    <div class="creditContainer">
        <div class="logoContainer">
            <a href="./home.php">
                <img  src="../img/LOGO.png" alt="MaPaY-Logo" class="logo">
            </a>
        </div>
            <?php
                if (isset($_SESSION['UID'])) {
                    include("./DBconnection.php");
                    $queryCreditcardBank="SELECT B.BID,B.name FROM bank B";
                    $queryCreditcardBank_result = mysqli_query($conn, $queryCreditcardBank);
                    $queryCreditcardBank_resultcheck = mysqli_num_rows($queryCreditcardBank_result);
                    echo "<h1>請選擇銀行</h1>";
                    echo '<div class="bankSelect">';
                    if ($queryCreditcardBank_resultcheck > 0) {
                        echo "<select id='bankID' onchange='queryCreditcardInfo(this.value)'>
                        <option selected disable>--SELECT--</option>;
                        <option value='1'>test1</option>";
                        while ($row = mysqli_fetch_array($queryCreditcardBank_result)) {
                            $bank_ID=$row['BID'];
                            $bank_name=$row['name'];
                            echo "<option value='$bank_ID'>$bank_name</option>";
                        }
                        echo "</select></div>";
                    }
                    $conn->close();
                }
                else {
                    header("Refresh:0;url=./home.php");
                }
            ?>
        <div class="cardSelect"id="txtHint"></div>
    </div>
    <script src="../js/addCreditCard.js"></script>
</body>
</html>