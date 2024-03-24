<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" integrity="sha512-1PKOgIY59xJ8Co8+NE6FZ+LOAZKjy+KY8iq0G4B3CyeY6wYHN3yt9PW0XpSriVlkMXe40PTKnXrLnZ9+fkDaog==" crossorigin="anonymous" />

  <link rel="stylesheet" href="../css/style.css">
  <link rel="icon" href="../img/LOGO.ico" type="image/x-icon" />
  <title>MaPaY</title>
</head>


<body>
  <header>
    <div class="serarchContainer">
      <a id="uLocate1">
        <img class="logo" src="../img/LOGO.png" alt="MaPaY-Logo">
        <h1>MaPaY</h1>
      </a>
      <input id="pac-input" type="text" placeholder="Search"></input>
    </div>
    <a id="uLocate2" class="uLocate">
      <i class="fas fa-compass"></i>
    </a>
    
    <div class="labarContainer">
		  <div class="labarValue" id="labarValue"></div>
		  <input type="range" orient=vertical id="range" min="0" max="10" value="2"step="1" onchange="getValue()">
	  </div>

    <a class="burger">
      <i class="fas fa-bars"></i>
    </a>
    <form class="search">
      <div class="mobileContainer">
        <a id="prev2">
          <i class="fas fa-chevron-left"></i>
        </a>
        <ul class="payUl">
          <?php
            include("./DBconnection.php");
            $userPayment = [];
            if (isset($_SESSION['UID'])) {
              $UID = $_SESSION['UID'];
              $queryUserPayment = "SELECT user_payment_relation.PID FROM user_payment_relation WHERE user_payment_relation.UID='$UID';";
              $queryUserPayment_result = mysqli_query($conn, $queryUserPayment);
              $queryUserPayment_resultcheck = mysqli_num_rows($queryUserPayment_result);
              if ($queryUserPayment_result) {
                if ($queryUserPayment_resultcheck > 0) {
                  $index = 0;
                  while ($row = mysqli_fetch_array($queryUserPayment_result)) {
                    $userPayment[$index] = $row['PID'];
                    $index++;
                  }
                }
              }
            }
            $queryAllPayment = "SELECT P.Payment_template, P.Payment_PID FROM payment P";
            $queryAllPayment_result = mysqli_query($conn, $queryAllPayment);
            $queryAllPayment_resultcheck = mysqli_num_rows($queryAllPayment_result);
            if ($queryAllPayment_result) {
              if ($queryAllPayment_resultcheck > 0) {
                while ($row = mysqli_fetch_array($queryAllPayment_result)) {
                  $template = $row['Payment_template'];
                  $templateID = 'pay'.$row['Payment_PID'];
                  $lightUp = false;
                  for($i = 0; $i<count($userPayment); $i++){
                    if($userPayment[$i]==$row['Payment_PID']){
                      $lightUp = true;
                    }
                  }
                  if($lightUp){
                    echo "<li><input type='button' value='$template' id='$templateID' class='$templateID active'></li>";
                  }else{
                    echo "<li><input type='button' value='$template' id='$templateID' class='$templateID'></li>";
                  }
                  // echo "<li><input type='button' value='$template' id='$templateID' class='$templateID'></li>";
                }
              }
            }
          ?>
        </ul>
        <a id="next2">
          <i class="fas fa-chevron-right"></i>
        </a>
      </div>
      <div class="storeContainer">
        <a id="prev1">
          <i class="fas fa-chevron-left"></i>
        </a>
        <ul class="storeUl">
          <?php
            include("./DBconnection.php");
            $queryAllStoreCategory = "SELECT S.storecategory_category,S.storecategory_SCID FROM store_category S";
            $queryAllStoreCategory_result = mysqli_query($conn, $queryAllStoreCategory);
            $queryAllStoreCategory_resultcheck = mysqli_num_rows($queryAllStoreCategory_result);
            if ($queryAllStoreCategory_result) {
              if ($queryAllStoreCategory_resultcheck > 0) {
                while ($row = mysqli_fetch_array($queryAllStoreCategory_result)) {
                  $storeCategory = $row['storecategory_category'];
                  $storeID = 'store'.$row['storecategory_SCID'];
                  echo "<li>
                <input type='button' value='$storeCategory' id='$storeID' class='$storeID'>
                </li>";
                }
              }
            }
          ?>
          <li>
            <input type='button' value='全選' id='store12' class='store12 active'>
          </li>
        </ul>
        <a id="next1">
          <i class="fas fa-chevron-right"></i>
        </a>
      </div>
    </form>
    <?php
    if (isset($_SESSION['UID'])) {
      $UID = $_SESSION['UID'];
      include("./DBconnection.php");
      $userName = "SELECT U.user_name FROM user U WHERE U.user_UID = '$UID'";
      $userName_result = mysqli_query($conn, $userName);
      $uName;
      if ($userName_result) {
        $resultcheck = mysqli_num_rows($userName_result);
        if ($resultcheck > 0) {
          while ($row = mysqli_fetch_array($userName_result)) {
            $uName = $row['user_name'];
          }
        }
      }
      echo '
      <ul class="burgerlist">
        <li> 
          <a href="./personalInfo.php" class="user">
            <img src="../img/user.png" alt="UserLogo">
            <span>' . $uName . '<br>個人資料</span>
          </a>
        </li>
        <li> 
          <a href="./personalCreditCard.php">
            <span>信用卡設定</span>
          </a> 
        </li>
        <li> 
          <a href="./personalPayment.php">
            <span>行動支付設定</span>
          </a> 
        </li>
        <li> 
          <a href="./logout.php" >
            <span>登出</span>
          </a> 
        </li>
      </ul>';
    } else {
      echo '
      <ul class="burgerlist">
        <li> 
          <a href="../login.html" class="user">
            <img src="../img/NoneUser.png" alt="UserLogo">
            <span>登入</span>
          </a> 
        </li>
        <li> 
          <a href="../signup.html">
            <span>註冊</span>
          </a> 
        </li>
      </ul>';
    }
    ?>
  </header>
  <div id="map"></div>
</body>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAZlmoXeSz14KZ7Tpttw2egBE-BlRkQiOk&libraries=places&callback=createMap" defer></script>
<script src="../js/map.js"></script>
<link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
<script src="../js/jquery-3.5.1.min.js"></script>
<script src="../js/scroll.js"></script>
<script src="../js/burger.js"></script>
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script src="../js/all.js"></script>

</html>