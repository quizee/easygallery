<?php
session_start();
$item_id = $_GET['item_id'];
$like = $_GET['like'];
$email = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

if($like == "no"){//좋아요 취소
  $sql = "delete from likes where product_id = '$item_id' and user_id='$email';";
}else if($like == "yes"){//좋아요 신청
  $sql = "insert into likes (product_id,user_id) values ('$item_id','$email');";
}
mysqli_query($conn,$sql);

 ?>
