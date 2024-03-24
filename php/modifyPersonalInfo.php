<?php
    session_start();
    $UID=$_SESSION['UID'];
    // echo $UID;
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
    <title>Personal Info</title>
</head>

<body>
    <div class="InfoContainer">
        <div class="info">
        <div class="logoContainer">
                <a href="./home.php">
                    <img  src="../img/LOGO.png" alt="MaPaY-Logo" class="logo">
                </a>
            </div>
            <ul>
                <?php
                    if (isset($_SESSION['UID'])) {
                        include("./DBconnection.php");
                        $querycreditcardinfo = "SELECT * FROM `user` WHERE `user_UID` = $UID";
                        $querycreditcardinfo_result = mysqli_query($conn, $querycreditcardinfo);
                        $resultcheck = mysqli_num_rows($querycreditcardinfo_result);

                        echo '<form action="./modifyPersonalInfoDB.php" method="POST">';
                            while ($row = mysqli_fetch_array($querycreditcardinfo_result)) {
                                // echo '<li>Username</li>';
                                $Uname=$row['user_name'];
                                echo "<li>Username<input type='text' name='Uname' value='$Uname'></li>";
                                // echo '<li>Email</li>';
                                echo '<li>Email<span class="cantEdit">'.$row['user_email'].'</span></li>';
                                // echo '<li>Password</li>';
                                $Upassword=$row['user_password'];
                                echo "<li>Password<input type='password' name='Upassword' value='$Upassword'></li>";
                            }
                        echo '<li class="btns"><input type="submit" name="submit" value="修改" class="modify"><a href="./personalInfo.php" class="cancel">取消</a></li>';
                        echo '</form>';

                        mysqli_free_result($querycreditcardinfo_result);
                        $conn->close();
                    } else {
                        header("Refresh:0;url=./home.php");
                    }
                ?>
            </ul>
        </div>
    </div>
</body>
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/burger.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="../js/all.js"></script>
</html>