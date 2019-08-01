<?php
 $user_email = $_GET['email'];
 $user_pw = $_GET['password'];
 $user_path = $_GET['pathid'];

 $servername = "localhost";
 $username = "root";
 $password = "1234";
 // Create connection
 $conn = mysqli_connect($servername, $username, $password,"user_db");
 $conn2 = mysqli_connect($servername, $username, $password,"my_db");
 // Check connection
 if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }
 $sql = "select password from user_info where email='".$user_email."';";
 $result = mysqli_query($conn,$sql);
 mysqli_store_result($conn);

 if(mysqli_num_rows($result)>0){
   $row = mysqli_fetch_assoc($result);
   $db_password = $row['password'];
   if($db_password == $user_pw){//일치하는 경우
     session_start();
     $_SESSION['email'] = $user_email;
     if(isset($_COOKIE['cart_items_cookie'])){//장바구니로 바로 와서 쿠키가 남아있는 경우를 말한다.
       $cookie = $_COOKIE['cart_items_cookie'];
       $cookie = stripslashes($cookie);
       $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
      // echo "쿠키가 남아있다!!!!";
      // echo "saved_cart_items: ".$saved_cart_items;

       //그냥 저장되어있던 아이템을 쓰면 된다.
       foreach($saved_cart_items as $key=>$value){
         $sql_check = "select * from carts where user_id='".$_SESSION['email']."'and product_id='".$key."';";
         //echo $sql_check."  ";
         $result = mysqli_query($conn2, $sql_check);
         //echo "row count:" .mysqli_num_rows($result)."  ";
         mysqli_store_result($conn2);

         $update_sql = "";
         if(mysqli_num_rows($result)>0){//디비에 이미 있는 물품이라면
           $update_sql = "update carts set count = count + ".$value." where user_id ='".$_SESSION['email']."' and product_id='".$key."';";
           mysqli_query($conn2, $update_sql);
         }else{//디비에 없는 새로운 물품이라면
           $update_sql = "INSERT INTO carts (user_id, product_id, count) VALUES ('".$_SESSION['email']."','". $key. "','" .$value. "');";
           mysqli_query($conn2, $update_sql);
         }
         //echo "updatesql: ".$update_sql;
         //echo "key: ".$key." value: ".$value." ".$update_sql;
         setcookie("cart_items_cookie", "", time()-3600,'/');
         unset($_COOKIE["cart_items_cookie"]);
        }


     }
     // if($user_path == "baskettest"){
     //   $cookie = $_COOKIE['cart_items_cookie'];
     //   //echo "들어왔지?";
     //
     //   if($cookie != ""){//이미 쿠키가 있었다면 쿠키에 대해 마지막으로 연산을 해주고 지운다.
     //     //쿠키로부터 목록을 받아오고 쿠키는 지운다
     //     $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
     //     //null exception 안나게
     //     if(!$saved_cart_items){
     //         $saved_cart_items=array();
     //     }
     //
     //      foreach($saved_cart_items as $key=>$value){
     //        $sql_check = "select * from carts where user_id='".$_SESSION['email']."'and product_id='".$key."';";
     //        $result = mysqli_query($conn2, $sql_check);
     //        mysqli_store_result($conn2);
     //        //$sql2 = "INSERT INTO carts (user_id, product_id, count) VALUES ('".$_SESSION['email']."','". $key. "','" .$value. "');";
     //        $update_sql = "";
     //        if(mysqli_num_rows($result)>0){//디비에 이미 있는 물품이라면
     //          $update_sql = "update carts set count = count + ".$value." where user_id ='".$_SESSION['email']."' and product_id='".$key."';";
     //          mysqli_query($conn2, $update_sql);
     //        }else{//디비에 없는 새로운 물품이라면
     //          $update_sql = "INSERT INTO carts (user_id, product_id, count) VALUES ('".$_SESSION['email']."','". $key. "','" .$value. "');";
     //          mysqli_query($conn2, $update_sql);
     //        }
     //      }
     //      setcookie("cart_items_cookie", "", time() - 3600);
     //      mysqli_close($conn2);
     //    }
     // }
     echo "success";
   }else{//아닌 경우
     echo "비밀번호가 일치하지 않습니다.";
   }
 }else{
   echo "존재하지 않는 이메일입니다.";
 }
 mysqli_close($conn);
 mysqli_close($conn2);


 ?>
