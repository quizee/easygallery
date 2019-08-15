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
  mysqli_query($conn,$sql);
  $plus_minus = '-1';

}else if($like == "yes"){//좋아요 신청
  $sql = "insert into likes (product_id,user_id) values ('$item_id','$email');";
  mysqli_query($conn,$sql);
  $plus_minus = '+1';

}
//좋아요 수에도 반영한다.
$update_sql = "update arts set like_count = like_count ".$plus_minus." where id = '$item_id';";
mysqli_query($conn,$update_sql);

//반영한 좋아요 수의 최종 결과를 리턴한다 
$get_like = "select like_count from arts where id='".$item_id."';";
$result = mysqli_query($conn,$get_like);
mysqli_store_result($conn);
$row = mysqli_fetch_assoc($result);
echo $row['like_count'];
 ?>
