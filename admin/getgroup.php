<?php
 $order_time = $_GET['date'];
 $buyer = $_GET['buyer'];
 $order_id = $_GET['order_id'];
//$order_time = '1564396626';
//$buyer = 'k2k2@naver.com';

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql = "select order_id,name,user_id,count from orders join arts on orders.product_id = arts.id
where user_id = '$buyer' and order_id like '%$order_time%';";

$result = mysqli_query($conn, $sql);
mysqli_store_result($conn);
$output = "&emsp;&emsp;&nbsp; <strong>함께 주문하신 목록</strong><br>";
$output .= '<ul style="list-style-type:none;">';

 if(mysqli_num_rows($result)>0){
   while($row = mysqli_fetch_assoc($result)){
     if($row['order_id'] != $order_id){
       $output .= '<li><input type="checkbox" name="group_product" value="'.$row['order_id'].'" checked = "checked"> ['.$row['order_id'].'] '.$row['name'].'(수량:'.$row['count'].')</li>';
     }
    }
 }
$output .='</ul>';
//echo $order_time;
echo $output;

?>
