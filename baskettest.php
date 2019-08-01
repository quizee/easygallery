<!DOCTYPE html>
<?php session_start();
if($_SESSION['email']){
  setcookie("cart_items_cookie", "", time()-3600,'/');
  unset($_COOKIE["cart_items_cookie"]);
}
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
 .scrollable{
   height: 380px;
   overflow: scroll;
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

         <div class="container" >
           <div class="row">
             <div class="col-md-12">
               <hr>
             </div>
           </div>
           <script type="text/javascript">
           $(function () {
              $('form').bind('submit', function (event) {
                event.preventDefault();// using this page stop being refreshing
                $.ajax({
                  type: 'GET',
                  url: '/removeItems.php',
                  data: $('form').serialize(),
                  dataType : "text",
                  contentType: "application/json; charset=UTF-8",
                  success: function (data) {
                    if(data == "member"){
                      window.location.reload();
                    }else{
                      var today = new Date();
                      var expiry = new Date(today.getTime() +  86400);
                      var setcookie = function (name,value,expires,path,domain,secure) {
                      document.cookie = name + "=" + escape (value) +
                        ((expires) ? "; expires=" + expires.toUTCString() : "") +
                        ((path) ? "; path=" + path : "") +
                        ((domain) ? "; domain=" + domain : "") +
                        ((secure) ? "; secure" : "");
                    }
                      setcookie("cart_items_cookie", data, expiry, '/','','');
                      window.location.reload();
                    }
                  }
                });

              });
            });
           </script>
           <script type="text/javascript">
           function numberWithCommas(x) {
             return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
           }

           function getCookie(cname) {
              var name = cname + "=";
              var decodedCookie = decodeURIComponent(document.cookie);
              var ca = decodedCookie.split(';');
              for(var i = 0; i <ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') {
                  c = c.substring(1);
                }
                if (c.indexOf(name) == 0) {
                  return c.substring(name.length, c.length);
                }
              }
              return "";
            }
            function replaceAll(content,before,after){
              return content.split(before).join(after);
            }
            function numberWithCommas(x) {
              return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            }

          $(document).ready(function(){
            $('input[name=count]').bind('change', function(){
              // handle event
              var product = $(this).attr('id');
              var count = $(this).val();
              var price_name = "price_"+product;
              //alert(document.getElementById(price_name).innerHTML);

              $.ajax({
                type: 'GET',
                url: '/countmodify.php',
                data: {'product': product , 'count': count},
                dataType : "text",
                contentType: "application/json; charset=UTF-8",
                success: function (data) {
                   //$('#result').html(data);
                   //document.getElementById(price_name).innerHTML = "New text!";
                   //alert(data);
                   var strArray = data.split(",");
                   //alert(strArray[0]+" "+strArray[1]);
                   //strArray[0]은 클릭한 애의 가격, strArray[1]은 변경된 가격을 고려한 총 가격
                   var clicked_price = Number(strArray[0]);
                   var total_price = Number(strArray[1]);
                   var send_price = 0;
                   if(total_price<300000 && total_price > 0){
                     send_price = 5000;
                   }
                   document.getElementById(price_name).innerHTML = numberWithCommas(clicked_price*count)+"원";
                   document.getElementById('product_price').innerHTML = numberWithCommas(total_price)+"원";
                   document.getElementById('send_price').innerHTML = numberWithCommas(send_price)+"원";
                   document.getElementById('total_price').innerHTML = numberWithCommas(total_price+send_price)+"원";
                }
              });
            });
          });

           </script>
           <?php
            ?>
           <form id="forselected">
           <div class="row scrollable">
             <table class= "table text-center">
               <thead>
                 <tr>
                   <th>선택</th>
                   <th>이미지</th>
                   <th>작품명</th>
                   <th>판매가</th>
                   <th>수량</th>
                   <th>상품금액</th>
                 </tr>
               </thead>
               <tbody id = "result">
                 <?php
                 $my_total_price = 0;
                 $send_price = 0;
                 if(!isset($_SESSION['email'])){//아직 쿠키가남아있는 경우.
                   //비회원 장바구니는 쿠키라는 점에 주의하자
                   //echo $cookie;
                  // setcookie("cart_items_cookie", "", time()-3600);
                   $cookie = $_COOKIE['cart_items_cookie'];
                   $cookie = stripslashes($cookie);
                   $saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록
                   if(!$saved_cart_items){
                       $saved_cart_items=array();
                   }

                   foreach($saved_cart_items as $key=>$value){
                     //$key가 작품 id 고 $value가 수량이다.
                     $sql = "select id, name, photo, price, artist_name from arts left join artists on arts.artist_id = artists.artist_id where id='".$key."';";

                     $result = mysqli_query($conn,$sql);
                     mysqli_store_result($conn);
                     $row = mysqli_fetch_assoc($result);
                     $my_price = $value*$row['price'];
                     $my_total_price += $my_price;

                     echo '<tr>
                       <td><input type="checkbox" name="select[]" value="'.$row['id'].'"></td>
                       <td><img src="./database/images/'.$row['photo'].'" alt="art image" style="width:60px; height:60px;"></td>
                       <td>'.$row['name'].'</td>
                       <td>'.number_format($row['price']).'원</td>
                       <td><input type="number" class= "count_buy" name="count" id="'.$row['id'].'" value="'.$value.'" min="1"></td>
                       <td><span id="price_'.$row['id'].'">'.number_format($my_price).'원</span></td>
                    </tr>';
                   }
                 }else{
                   //회원용 장바구니
                   //이미 디비에 저장되어있으리라 믿는다....
                   $sql = "select id, name, photo, price, count, user_id from carts left join arts on carts.product_id = arts.id where user_id ='".$_SESSION['email']."';";

                   $result = mysqli_query($conn, $sql);
                   mysqli_store_result($conn);

                   if(mysqli_num_rows($result)>0){
                     while($row = mysqli_fetch_assoc($result)){
                       $my_price = $row['count']*$row['price'];
                       $my_total_price += $my_price;
                       echo '<tr>
                         <td><input type="checkbox" name="select[]" value="'.$row['id'].'"></td>
                         <td><img src="./database/images/'.$row['photo'].'" alt="art image" style="width:60px; height:60px;"></td>
                         <td>'.$row['name'].'</td>
                         <td>'.number_format($row['price']).'원</td>
                         <td><input type="number" name="count" class= "count_buy" id ="'.$row['id'].'" value="'.$row['count'].'" min="1"></td>
                         <td><span id="price_'.$row['id'].'">'.number_format($my_price).'원</span></td>
                      </tr>';
                     }
                   }
                 }

                 ?>
               </tbody>
             </table>

           </div>


           <div class="row">
             <div class="col-md-10"></div>
             <div class="col-md-2">
               <button type="submit" name="delete_selected" class="text-right btn btn-light">선택 상품 삭제하기</button>
             </div>
           </div>
           <div class="row">
             <div class="col-md-12">
               <br><br>
             </div>
           </div>
           </form>
           <div class="row">
             <div class="col-md-2">
             </div>
             <div class="col-md-8 text-center">
               <table style="width:100%;" class="table">
                 <thead>
                   <tr>
                     <td>&emsp;&emsp;상품 금액&emsp;&emsp;</td>
                     <td>+</td>
                     <td>&emsp;&emsp;배송비&emsp;&emsp;</td>
                     <td>=</td>
                     <td>&emsp;&emsp;총 주문 금액&emsp;&emsp;</td>
                   </tr>
                 </thead>
                 <tbody>
                   <tr>
                     <td><h4><span id="product_price"><?php echo number_format($my_total_price)."원" ?></span></h4></td>
                     <td></td>
                     <td><h4><span id="send_price"><?php if($my_total_price<300000 && $my_total_price>0){
                            $send_price= 5000;
                          }
                          echo number_format($send_price)."원";
                     ?></span></h4></td>
                     <td></td>
                     <td><h4><span id="total_price"><?php echo number_format($my_total_price+$send_price)."원";?></span></h4></td>
                   </tr>
                 </tbody>
               </table>
             </div>
             <div class="col-md-2">
             </div>
           </div>

           <div class="row">
             <div class="col-md-12">
               <br><br>
             </div>
           </div>
           <div class="row">
             <div class="col-md-4">
             </div>
             <div class="col-md-4 text-center">
               <button id="go_order_all" type="button" name="button" class="btn btn-dark" style= "width:100%;">상품 주문하기</button>
             </div>
             <div class="col-md-4">
             </div>
           </div>
           <div class="row">
             <div class="col-md-12">
               <br><br>
             </div>
           </div>
         </div>
         <script type="text/javascript">
         $(document).ready(function(){
           $('#go_order_all').click(function(){
             if('<?php echo $_SESSION["email"] ?>' == ""){
               $('#LoginModal').modal('show');
             }else{
               window.location.href = "order.php";
             }
           });
         });
         </script>



<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
