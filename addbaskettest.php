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

$id = $_GET['artid'];
$quantity = $_GET['count'];
$shop = $_GET['shop'];
//echo $_SESSION['email'];

if(!isset($_SESSION['email'])) {//비회원 장바구니는 쿠키를 이용한다.
  //echo "비회원<br>";
  $cookie = $_COOKIE['cart_items_cookie'];
  $cookie = stripslashes($cookie);
  $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
  //
  // if $saved_cart_items is null, prevent null error
  if(!$saved_cart_items){
      $saved_cart_items=array();
  }

  if(!array_key_exists($id, $saved_cart_items)){//장바구니에 담겨있지 않을 때만
    $cart_items[$id]= $quantity;
  }
  //echo "카운트 ".count($saved_cart_items)."<br>";

  if(count($saved_cart_items)>0){
    foreach($saved_cart_items as $key=>$value){
      if($key == $id){
        $quantity_total = $value + $quantity;
        $cart_items[$key] = $quantity_total;
      }
      else{
        $cart_items[$key]= $value;
      }
    }
  }
  //print_r($cart_items);
  $json = json_encode($cart_items, true);
  //echo "json: ".$json."<br>";
  setcookie("cart_items_cookie",$json, time()+ 86400,'/');
  //$_COOKIE['cart_items_cookie']= $json;

  //print_r($_COOKIE['cart_items_cookie']);
  // header('Location: basket.php');
}else{//회원인 경우
   //echo "회원<br>";
   $cookie = $_COOKIE['cart_items_cookie'];

   if(isset($_COOKIE['cart_items_cookie'])){//이미 쿠키가 있었다면 쿠키에 대해 마지막으로 연산을 해주고 지운다.
     //쿠키로부터 목록을 받아오고 쿠키는 지운다
     $cookie = $_COOKIE['cart_items_cookie'];
     $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
     //null exception 안나게
     if(!$saved_cart_items){
         $saved_cart_items=array();
     }
   //
     if(!array_key_exists($id, $saved_cart_items)){//장바구니에 담겨있지 않을 때만
       $cart_items[$id]= $quantity;
     }

     if(count($saved_cart_items)>0){
       foreach($saved_cart_items as $key=>$value){
         if($key == $id){
           $quantity_total = $value + $quantity;
           $cart_items[$key] = $quantity_total;
         }
         else{
           $cart_items[$key]= $value;
         }
       }
     }//새로운 물품을 쿠키에 포함시키고
      //그것을 데이터베이스로 만든다.
      $user_id = $_SESSION['email'];

      foreach($cart_items as $key=>$value){
        $sql_check = "select * from carts where user_id='".$user_id."'and product_id='".$key."';";
        $result = mysqli_query($conn, $sql_check);
        mysqli_store_result($conn);
        $update_sql = "";
        if(mysqli_num_rows($result)>0){//디비에 이미 있는 물품이라면
          $update_sql = "update carts set count = count + ".$value." where user_id ='".$user_id."' and product_id='".$key."';";
          mysqli_query($conn, $update_sql);
        }else{//디비에 없는 새로운 물품이라면
          $update_sql = "INSERT INTO carts (user_id, product_id, count) VALUES ('".$user_id."','". $key. "','" .$value. "');";
          mysqli_query($conn, $update_sql);
        }
      }
      setcookie("cart_items_cookie", null, time() - 3600,'/');
      unset($_COOKIE['cart_items_cookie']);
      //mysqli_close($conn);
    }else{//쿠키가 이미 없는 상태라면
       $user_id = $_SESSION['email'];
       $sql = "select * from carts where user_id='".$user_id."'and product_id='".$id."';";
       $result = mysqli_query($conn, $sql);
       mysqli_store_result($conn);

       $update_sql = "";

       if(mysqli_num_rows($result)>0){//장바구니 에 이미 있다면
         $update_sql = "update carts set count = count + ".$quantity." where user_id ='".$user_id."' and product_id='".$id."';";
       }else{//장바구니에 없다면
         $update_sql = "INSERT INTO carts (user_id, product_id, count) VALUES ('".$user_id."','". $id . "','" .$quantity. "');";

       }
       //echo $update_sql;
       //echo "cookie: ".$_COOKIE['cart_items_cookie'];
       mysqli_query($conn, $update_sql);
       //mysqli_close($conn);
   }
 }

 if($shop == "stay"){//계속 쇼핑할래
   header('location: collection.php');
   exit();
   //echo '<meta http-equiv="refresh" content="0;url=collection.php" />';
 }else if($shop == "stop"){//그만할래요
   header('location: baskettest.php');
   exit();
  //echo '<meta http-equiv="refresh" content="0;url=baskettest.php" />';
 }

?>

<!-- <meta http-equiv="refresh" content="0;url=baskettest.php" /> -->
