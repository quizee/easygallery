<?php session_start();
ob_start();
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$user_id = $_SESSION['email'];
$ids = $_GET['select_item'];//체크박스 목록들을 모두 장바구니에 추가시킨다.

foreach ($ids as $key => $id) {
  $sql = "select * from carts where user_id='".$user_id."'and product_id='".$id."';";//해당하는 아이템이 이미 장바구니에 있는지 확인
  $result = mysqli_query($conn, $sql);
  mysqli_store_result($conn);
  $update_sql = "";

  if(mysqli_num_rows($result)>0){//장바구니 에 이미 있다면
    $update_sql = "update carts set count = count + 1 where user_id ='".$user_id."' and product_id='".$id."';";//수량을 1 증가
  }else{//장바구니에 없다면
    $update_sql = "
    INSERT INTO carts (user_id, product_id, count) VALUES ('".$user_id."','". $id . "',1);";//새로 추가
  }
  mysqli_query($conn, $update_sql);
}

mysqli_close($conn);

header('location: baskettest.php');
exit();

?>
