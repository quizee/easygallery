<?php session_start();
$id = $_GET['artid'];
$quantity = $_GET['count'];
echo $_SESSION['email'];

if(!isset($_SESSION['email'])) {//비회원 장바구니는 쿠키를 이용한다.
  echo "비회원<br>";
  $cookie = $_COOKIE['cart_items_cookie'];
  $cookie = stripslashes($cookie);
  $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
  //
  // if $saved_cart_items is null, prevent null error
  if(!$saved_cart_items){
      $saved_cart_items=array();
  }
  if(!array_key_exists($id, $saved_cart_items)){//장바구니에 담겨있지 않을 때만
    $cart_items[$id]=array(
      'quantity'=> $quantity
    );
  }
  //echo "카운트 ".count($saved_cart_items)."<br>";

  if(count($saved_cart_items)>0){
    foreach($saved_cart_items as $key=>$value){
      if($key == $id){
        $quantity_total = $value['quantity']+$quantity;
        $cart_items[$key] = array(
          'quantity'=>$quantity_total//이미 있는 값이라면 겹쳐쓰지 않고 더한다.
        );
      }
      else{
        $cart_items[$key]= array(
          'quantity'=>$value['quantity']
        );
      }
    }
  }
  //print_r($cart_items);

  $json = json_encode($cart_items, true);
  //echo "json: ".$json."<br>";
  setcookie("cart_items_cookie",$json, time()+86400,'/');
  $_COOKIE['cart_items_cookie']= $json;
  print_r($_COOKIE['cart_items_cookie']);
  // header('Location: basket.php');
}else{//회원인 경우
   echo "회원<br>";

   if(isset($_COOKIE['cart_items_cookie'])){//이미 쿠키가 있었다면
     //쿠키로부터 목록을 받아오고 쿠키는 지운다
     $cookie = $_COOKIE['cart_items_cookie'];
     $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
     //null exception 안나게
     if(!$saved_cart_items){
         $saved_cart_items=array();
     }

     if(!array_key_exists($id, $saved_cart_items)){//장바구니에 담겨있지 않을 때만
       $cart_items[$id]=array(
         'quantity'=> $quantity
       );
     }
     if(count($saved_cart_items)>0){
       foreach($saved_cart_items as $key=>$value){
         if($key == $id){
           $quantity_total = $value['quantity']+$quantity;
           $cart_items[$key] = array(
             'quantity'=>$quantity_total//이미 있는 값이라면 겹쳐쓰지 않고 더한다.
           );
         }
         else{
           $cart_items[$key]= array(
             'quantity'=>$value['quantity']//
           );
         }
       }
     }//마지막으로 쿠키를 받고
     //$json = json_encode($cart_items, true);
      //그것을 세션으로 만든다.
     $_SESSION['shoplist'] = $cart_items;
     setcookie("cart_items_cookie", "", time() - 3600);//로그인 한 이후로는 쿠키가 필요없다.
     unset($_COOKIE['cart_items_cookie']);

   }else{//쿠키가 이미 없는 상태라면
     $saved_cart_items = $_SESSION['shoplist'];//이제 여기다가 추가해야지.

     if(!$saved_cart_items){
         $saved_cart_items=array();//이 상태는 쿠키도 없고 로그인해서 저장한 것도 없는 상태일 것이다.
     }

     if(!array_key_exists($id, $saved_cart_items)){//장바구니에 담겨있지 않을 때만
       $cart_items[$id]=array(
         'quantity'=> $quantity
       );
     }

     if(count($saved_cart_items)>0){
       foreach($saved_cart_items as $key=>$value){
         if($key == $id){
           $quantity_total = $value['quantity']+$quantity;
           $cart_items[$key] = array(
             'quantity'=>$quantity_total//이미 있는 값이라면 겹쳐쓰지 않고 더한다.
           );
         }
         else{
           $cart_items[$key]= array(
             'quantity'=>$value['quantity']
           );
         }
       }
     }
     //$json = json_encode($cart_items, true);
     $_SESSION['shoplist'] = $cart_items;
     print_r($_SESSION['shoplist']);

   }
}

?>
<meta http-equiv="refresh" content="0;url=basket.php" />
