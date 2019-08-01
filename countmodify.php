<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$id = $_GET['product'];
$count = $_GET['count'];

$sql = "select price from arts where id='".$id."';";

$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);
$row = mysqli_fetch_assoc($result);
$product_price = $row['price'];//일단 물건의 가격을 뽑고 시작한다.
$total_price = 0;

if(!isset($_SESSION['email'])){//비회원일때
 //echo "yes!".$id." ".$count;
   $cookie = $_COOKIE['cart_items_cookie'];
   $cookie = stripslashes($cookie);
   $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록

   // if $saved_cart_items is null, prevent null error
   if(!$saved_cart_items){
       $saved_cart_items=array();
   }

   if(count($saved_cart_items)>0){
     foreach($saved_cart_items as $key=>$value){
       $sql = "select price from arts where id='".$key."';";
       $result = mysqli_query($conn,$sql);
       mysqli_store_result($conn);
       $row = mysqli_fetch_assoc($result);
       if($key == $id){
         $cart_items[$key] = $count;//해당하는 애만 새로 갱신한다.
         $total_price = $total_price + $count*$product_price;
       }
       else{
         $cart_items[$key]= $value;
         $total_price = $total_price + $value*$row['price'];
       }
     }
   }

   $json = json_encode($cart_items, true);
   setcookie("cart_items_cookie",$json, time()+ 86400,'/');

 }else{//회원일 경우 디비에서 업데이트한다.

    $sql = "update carts set count = ". $count ." where product_id = '".$id ."' and user_id= '".$_SESSION['email']."';";
    mysqli_query($conn,$sql);

    $sql2 = "select user_id, count, price from carts join arts on carts.product_id = arts.id where user_id = '".$_SESSION['email']."';";
    $result = mysqli_query($conn,$sql2);
    mysqli_store_result($conn);
    while($row = mysqli_fetch_assoc($result)){
      //echo "개수: ".$row['count']." 가격: ".$row['price']." ";
      $total_price = $total_price + $row['count']*$row['price'];
    }

}
echo $product_price.",".$total_price;

 ?>
