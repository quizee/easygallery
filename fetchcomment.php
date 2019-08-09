<?php
$review_id = $_GET['review_id'];

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

$sql = "select comment from reviews where order_id='".$review_id."';";
$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);
mysqli_num_rows($result);
 ?>
