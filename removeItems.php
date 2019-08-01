<?php
  session_start();
 $selected_ornot = $_GET['select'];//여기에 포함된 값인지 봐야겠군
 if(!isset($_SESSION['email'])){//비회원일때
   //echo count($selected_ornot);
   for($i=0; $i<count($selected_ornot);$i++){
     //비회원모드일때는 쿠키에서 지운다.
       $cookie = $_COOKIE['cart_items_cookie'];
       $cookie = stripslashes($cookie);
       $saved_cart_items2 = json_decode($cookie, true);

       if(!$saved_cart_items2){
           $saved_cart_items2=array();
       }
       //print_r($saved_cart_items2);


       if(count($saved_cart_items2)>0){
         foreach($saved_cart_items2 as $key=>$value){
           if(in_array($key, $selected_ornot)){
             unset($saved_cart_items2[$key]);//해당하는 아이를 삭제한다.
           }
         }

         // delete cookie value
         //setcookie('cookiename', FALSE, -1, '/', './addbaskettest.php');
         //setcookie('cart_items_cookie', '', 1, '/addbaskettest.php');
        // setcookie('cart_items_cookie', FALSE, -1, '/', '/');
         // setcookie("cart_items_cookie", "", time()-3600,'/');
         // unset($_COOKIE["cart_items_cookie"]);
         //일단 수정한 후에는 쿠키를 한번 버려야하는 모양이다.
         // enter new value
         $json2 = json_encode($saved_cart_items2, true);
       }
    }

    setcookie("cart_items_cookie", "", time()-3600,'/');
    unset($_COOKIE["cart_items_cookie"]);

    echo $json2;
  //  echo "json: ".$json."<br>";
//    echo "cookie: ".$_COOKIE['cart_items_cookie']."<br>";

  }else{//회원일 경우 디비에서 지운다.
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,"my_db");
    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

     for($i=0; $i<count($selected_ornot);$i++){
       $sql = "delete from carts where user_id='".$_SESSION['email']."' and product_id='".$selected_ornot[$i]."';";
       echo $sql;
       mysqli_query($conn,$sql);
     }
     setcookie("cart_items_cookie", "", time()-3600,'/');
     unset($_COOKIE["cart_items_cookie"]);

     //echo "member";
   }


 ?>
