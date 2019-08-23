<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$pay_person = $_POST['pay_person'];
$pay_phonenum = $_POST['pay_phonenum'];
$pay_email = $_POST['pay_email'];
$getter = $_POST['getter'];
$getter_phonenum = $_POST['getter_phonenum'];
$address = $_POST['address'];
$delivery_require = $_POST['delivery_require'];
$state = "배송 준비중";
$cancel = "";
$done = "";
$ids = $_POST['select_item'];
//echo $pay_person;
//넘겨받은 아이템 배열을 한바퀴 돌면서 주문 리스트를 채운다.
foreach ($ids as $key => $id) {
  $sql = "select id, name, photo, price from arts where id ='".$id."';";//하나의 아이템에 대해 정보를 가져온다.
  $result = mysqli_query($conn, $sql);
  mysqli_store_result($conn);
  $row = mysqli_fetch_assoc($result);//하나밖에 못가져옴

  $order_id = time()."_".rand(0,1000);//주문 번호
  $product_id = $row['id'];//아이템 아이디
  $user_id = $_SESSION['email'];//주문자
  $count = 1;//수량은 1로 고정한다.
  $pay_price = $row['price'];//수량이 1이므로 가격이 곧 pay price
  $pay_date = date("Y-m-d");//구매날짜

  //주문 리스트에 추가하는 쿼리
  $order_sql = "insert into orders (order_id,product_id,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
  delivery_require,delivery_state,cancel,done) values ('$order_id','$product_id','$user_id',$count,$pay_price,'$pay_date',
  '$pay_person','$pay_phonenum','$pay_email','$getter','$getter_phonenum','$address','$delivery_require','$state','$cancel','$done')";
  mysqli_query($conn, $order_sql);

  //재고 관리하는 쿼리
  $update_stock = "update arts set buy_count = buy_count + ".$count." where id='".$product_id."';";
  mysqli_query($conn,$update_stock);
}
mysqli_close($conn);
 ?>
