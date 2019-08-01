<!DOCTYPE html>
<?php session_start();
//미리 연결시켜놓는다.
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">

<script>

</script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <?php include ('header.php');?>
</head>

<body>
<!--여기부터 시작 -->
<style>
 .bg-active{
   background-color: #FFA500;
 }

 hr {
 margin-top: 1rem;
 margin-bottom: 1rem;
 border: 0;
 border-top: 4px solid rgba(0, 0, 0, 1);
 }

</style>
<br><br>

         <ul class="nav justify-content-center">
           <div class="container">
            <div class="row">
              <div class="col-md-2">

              </div>
              <div class="col-md-2 text-center">
                <li class="nav-item ">
                  <a class="nav-link btn btn-light bg-active" href="#">장바구니</a>
                </li>
              </div>
              <div class="col-md-1 mt-2 text-center">
                <img src="https://cdns.iconmonstr.com/wp-content/assets/preview/2012/240/iconmonstr-arrow-24.png" alt="" style="width:25px; height:25px;">
              </div>
              <div class="col-md-2 text-center">
                <li class="nav-item">
                  <a class="nav-link btn btn-light disabled" href="#">주문/결제</a>
                </li>
              </div>
              <div class="col-md-1 mt-2 text-center">
                <img src="https://cdns.iconmonstr.com/wp-content/assets/preview/2012/240/iconmonstr-arrow-24.png" alt="" style="width:25px; height:25px;">
              </div>
              <div class="col-md-2 text-center">
                <li class="nav-item">
                  <a class="nav-link btn btn-light disabled" href="#">주문 완료</a>
                </li>
              </div>
              <div class="col-md-2">
              </div>
            </div>
           </div>
         </ul>
         <br><br>

         <div class="container">
           <div class="row">
             <div class="col-md-12">
               <hr>
             </div>
           </div>
           <div class="row">
             <table class= "table">
               <thead>
                 <tr>
                   <th>선택</th>
                   <th>이미지</th>
                   <th>작품명</th>
                   <th>판매가</th>
                   <th>수량</th>
                   <th>적립금</th>
                 </tr>
               </thead>
               <tbody>
                 <?php
                 if(!isset($_SESSION['email'])){//비회원 장바구니
                   //비회원 장바구니는 쿠키라는 점에 주의하자
                   $cookie = $_COOKIE['cart_items_cookie'];
                   $cookie = stripslashes($cookie);
                   $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
                   if(!$saved_cart_items){
                       $saved_cart_items=array();
                   }

                   $i= 0;
                   foreach($saved_cart_items as $key=>$value){
                     //$key가 작품 id 고 $value['quantity']가 수량이다.

                     $sql = "select id, name, photo, price, artist_name from arts left join artists on arts.artist_id = artists.artist_id where id='".$key."';";

                     $result = mysqli_query($conn,$sql);
                     mysqli_store_result($conn);
                     $row = mysqli_fetch_assoc($result);
                     $point = (int)$row['price']*0.01;

                     $i = $i +1;
                     echo '<tr>
                       <td><input type="checkbox" name="select" id="'.$i.'" value=""></td>
                       <td><img src="./database/images/'.$row['photo'].'" alt="art image" style="width:60px; height:60px;"></td>
                       <td>'.$row['name'].'</td>
                       <td>'.number_format($row['price']).'원</td>
                       <td><input type="number" id="'.$i.'" name="count" value="'.$value['quantity'].'"></td>
                       <td>'.(int)$point.'원</td>
                    </tr>';

                   }

                 }else{
                   //회원용 장바구니
                   $saved_cart_items = $_SESSION['shoplist'];//이제 여기다가 추가해야지.

                   if(!$saved_cart_items){
                       $saved_cart_items=array();//이 상태는 쿠키도 없고 로그인해서 저장한 것도 없는 상태일 것이다.
                   }

                   $i= 0;
                   foreach($saved_cart_items as $key=>$value){
                     //$key가 작품 id 고 $value['quantity']가 수량이다.

                     $sql = "select id, name, photo, price, artist_name from arts left join artists on arts.artist_id = artists.artist_id where id='".$key."';";

                     $result = mysqli_query($conn,$sql);
                     mysqli_store_result($conn);
                     $row = mysqli_fetch_assoc($result);
                     $point = (int)$row['price']*0.01;

                     $i = $i +1;
                     echo '<tr>
                       <td><input type="checkbox" name="select" id="'.$i.'" value=""></td>
                       <td><img src="./database/images/'.$row['photo'].'" alt="art image" style="width:60px; height:60px;"></td>
                       <td>'.$row['name'].'</td>
                       <td>'.number_format($row['price']).'원</td>
                       <td><input type="number" id="'.$i.'" name="count" value="'.$value['quantity'].'"></td>
                       <td>'.number_format((int)$point).'원</td>
                    </tr>';
                   }
                 }
                 ?>
               </tbody>
             </table>
           </div>

         </div>




<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
