<?php
$company = $_GET['company'];
$delivery_num = $_GET['delivery_num'];
$selected_list = $_GET['selected_list'];

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
//해당하는 주문번호에 배송처리 상태, 구매확정대기, 배송회사, 송장 번호를 업데이트 한다.
foreach ($selected_list as $key => $value) {
  //echo $value;
  $sql = "update orders set delivery_state = '배송중',done='대기중',delivery_comp = '$company',
  delivery_num='$delivery_num' where order_id='$value';";
  mysqli_query($conn, $sql);
}
echo "주문 ".count($selected_list)."건이 처리되었습니다.";

mysqli_close($conn);
?>
