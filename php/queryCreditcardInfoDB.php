<?php
session_start();
$UID = $_SESSION['UID'];
if (isset($_SESSION['UID'])) {
    $bank_ID = intval($_GET['q']);
    include("./DBconnection.php");
    $querycreditcardinfo = "SELECT C.creditcard_CID,B.name,C.creditcard_category FROM bank B,credit_card C WHERE B.BID='$bank_ID' AND B.BID=C.creditcard_bank AND C.creditcard_CID NOT IN(SELECT UCR.CID FROM user_creditcard_relation UCR WHERE UCR.UID='$UID')";
    $querycreditcardinfo_result = mysqli_query($conn, $querycreditcardinfo);
    if ($querycreditcardinfo_result) {
        $resultcheck = mysqli_num_rows($querycreditcardinfo_result);
        if ($resultcheck > 0) {
            echo '<form action="./addPersonalCreditCardDB.php" method="POST">';
                echo "<select name='creditcard'>";
                echo "<option selected disable>-- select --</option>";
                while ($row = mysqli_fetch_array($querycreditcardinfo_result)) {
                    $creditcard_ID=$row['creditcard_CID'];
                    $creditcard_bank = $row['name'];
                    $creditcard_category = $row['creditcard_category'];
                    echo "<option value='$creditcard_ID'>$creditcard_bank $creditcard_category</option>";
                }
                echo "</select>";
                echo "<input type='submit' value='Submit'>";
            echo '</form>';
        }
    }
}
?>