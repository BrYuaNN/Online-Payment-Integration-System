<?php
    session_start();
    unset($_SESSION['UID']);
    header("Refresh:0;url=./home.php");
?>