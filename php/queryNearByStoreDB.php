<?php
session_start();
$UID;

$user_lng = floatval($_GET['lng']);
$user_lat = floatval($_GET['lat']);
$range = intval($_GET['range']);
$storeCategory = intval($_GET['storeCategory']); //0:unassign >0:assign
$payment = intval($_GET['payment']); //0:unassign >0:assign
$result = []; //存結果matrix(二維陣列)

//echo $user_lng." ".$user_lat;
include("./DBconnection.php");
$queryNearByStore;
if (isset($_SESSION['UID'])) { //登入狀態
  $UID = $_SESSION['UID'];
  if ($storeCategory) { //distinct store category
    if ($payment) { //distinct payment
      $queryNearByStore = "SELECT S.name,SC.storecategory_category,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store S,payment P,store_category SC WHERE SC.storecategory_SCID=S.category AND P.payment_PID='$payment' AND P.payment_PID=S.payment AND S.category='$storeCategory' AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    } else { //non distinct payment
      $queryNearByStore = "SELECT S.name,SC.storecategory_category,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store S,store_category SC,payment P,user_payment_relation UPR WHERE UPR.UID='1' AND UPR.PID=S.payment AND S.payment=P.payment_PID AND S.category=SC.storecategory_SCID AND S.category='$storeCategory' AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-' $user_lat')/0.009,2),0.5)<='$range'";
    }
  } else { //non distinct store category
    if ($payment) { //distinct payment
      $queryNearByStore = "SELECT S.name,SC.storecategory_category,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store S,payment P,store_category SC WHERE P.payment_PID='$payment' AND P.payment_PID=S.payment AND SC.storecategory_SCID=S.category AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    } else { //non distinct payment
      $queryNearByStore = "SELECT S.name,SC.storecategory_category,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store_category SC,store S,payment P,user_payment_relation UPR WHERE UPR.UID='$UID' AND P.payment_PID=UPR.PID AND S.payment=P.payment_PID AND SC.storecategory_SCID=S.category AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    }
  }
} else { //非登入狀態
  if ($storeCategory) { //distinct store category
    if ($payment) { //distinct payment
      $queryNearByStore = "SELECT S.ID,SC.storecategory_category,S.name,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store S,store_category SC,payment P WHERE S.payment='$payment' AND S.category='$storeCategory' AND S.category=SC.storecategory_SCID AND  S.payment=P.payment_PID AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    } else { //non distinct payment
      $queryNearByStore = "SELECT S.name,SC.storecategory_category,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store S,store_category SC,payment P WHERE S.category='$storeCategory'AND S.payment=P.payment_PID AND S.category=SC.storecategory_SCID AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    }
  } else { //non distinct store category
    if ($payment) { //distinct payment
      $queryNearByStore = "SELECT S.name,SC.storecategory_category,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template,P.payment_PID FROM store S,store_category SC,payment P,user_payment_relation UPR WHERE  SC.storecategory_SCID=S.category AND P.payment_PID='$payment' AND S.payment=P.payment_PID AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    } else { //non distinct payment
      // $queryNearByStore = "SELECT S.name,S.address,S.address_Longtitude,S.address_Latitude,P.payment_template FROM store S,payment P WHERE S.payment=P.payment_PID AND power(power((S.address_Longtitude-'$user_lng')/0.0099,2)+power((S.address_Latitude-'$user_lat')/0.009,2),0.5)<='$range'";
    }
  }
}
$queryNearByStore_result = mysqli_query($conn, $queryNearByStore);
$queryNearByStore_resultcheck = mysqli_num_rows($queryNearByStore_result);

if ($queryNearByStore_result) {
  if ($queryNearByStore_resultcheck > 0) {
    $index = 0;
    while ($row = mysqli_fetch_array($queryNearByStore_result)) {
      $info = [
        $row['name'], $row['storecategory_category'], $row['address'], $row['address_Longtitude'], $row['address_Latitude'], $row['payment_template'], $row['payment_PID']
      ];
      $result[$index] = $info;
      $index++;
    }
  }
}
echo json_encode($result, JSON_UNESCAPED_UNICODE);
