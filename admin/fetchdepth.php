<?php
$parent_comment = $_GET['parent_comment'];
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

$sql = "select depth from comments where comment_id = '$parent_comment';";
$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);
$row = mysqli_fetch_assoc($result);

//부모 코멘트의 깊이를 돌려준다. 
echo $row['depth'];
 ?>
