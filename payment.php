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

//장바구니에 있는 것들 한바퀴 돌면서 주문 리스트를 채운다.
$select_sql = "select id, name, photo, price, count from carts left join arts on carts.product_id = arts.id where user_id ='".$_SESSION['email']."';";
$result = mysqli_query($conn, $select_sql);

mysqli_store_result($conn);

if(mysqli_num_rows($result)>0){
  while($row = mysqli_fetch_assoc($result)){
    $order_id = time()."_".rand(0,1000);
    $product_id = $row['id'];
    $user_id = $_SESSION['email'];
    $count = $row['count'];
    $pay_price = $row['price']*$row['count'];
    $pay_date = date("Y-m-d");
    $order_sql = "insert into orders (order_id,product_id,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
    delivery_require,delivery_state,cancel,done) values ('$order_id','$product_id','$user_id',$count,$pay_price,'$pay_date',
    '$pay_person','$pay_phonenum','$pay_email','$getter','$getter_phonenum','$address','$delivery_require','$state','$cancel','$done')";
    mysqli_query($conn, $order_sql);
  }
}

//장바구니에 있던 것 삭제
$delete_sql = "delete from carts where user_id = '".$_SESSION['email']."';";
mysqli_query($conn, $delete_sql);

mysqli_close($conn);

 ?>
