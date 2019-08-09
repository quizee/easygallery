<?php
ob_start();
session_start();
//리뷰 데이터에 쌓기
$order_id = $_POST['order_id'];
$text = $_POST['txt_review'];
$photo = $_POST['file_name'];
$user_id = $_SESSION['email'];

$tmpFile = $_FILES['pic']['tmp_name'];
echo $tmpFile."<br>";
$newFile = '/var/www/html/database/asset/'.$_FILES['pic']['name'];
echo $newFile."<br>";
$result = move_uploaded_file($tmpFile, $newFile);

if ($result) {
    echo '<script>console.log("업로드가 완료되었습니다.")</script>';
} else {
     echo '<script>console.log("업로드 실패")</script>';
}

$servername = "localhost";
$username = "root";
$password = "1234";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
$conn2 = mysqli_connect($servername, $username, $password,"user_db");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (!$conn2) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "select product_id,pay_price from orders where order_id='".$order_id."';";
echo $sql;
$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);
$row = mysqli_fetch_assoc($result);
$product_id = $row['product_id'];//그 주문에 있는 상품 id를 뽑는다.
echo $product_id;
$price = $row['pay_price'];

$sql = "
INSERT INTO reviews (order_id, user_id, product_id, photo, text) VALUES (" . "'" . $order_id . "'" . ",'" . $user_id . "'" . ",'" . $product_id . "'" . ",'" . $photo  . "'" . ",'" . $text . "');";
//리뷰 테이블에 넣는다.
echo $sql;

mysqli_query($conn, $sql);

//글의 양과 사진 여부에 따라 적립금을 다르게 준다.
$point = 0;
if($photo != ""){//사진이 있다면 10%
  $point = $price*0.1;
}else if(strlen($text)>50){
  $point = $price*0.05;
}
$point = (int)$point;

$sql = "
update user_info set point='$point' where email='$user_id';";
mysqli_query($conn2,$sql);
echo $sql;

$sql = "
update orders set review_done='done' where order_id='$order_id';";
mysqli_query($conn,$sql);
echo $sql;
header('Location: orderlist.php');
exit();
 ?>
