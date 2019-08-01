<?php

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$order_id = $_GET['order_id'];
$sql = "update orders set delivery_state='배송 완료', done='확인 완료' where order_id='".$order_id."';";
mysqli_query($conn,$sql);

echo "구매확정 처리가 완료되었습니다.";

?>
