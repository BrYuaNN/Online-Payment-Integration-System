<?php
$servername = "localhost";
$username = "root";
$password = "lin1073329";
$dbname = "id17841235_nukim107project";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
