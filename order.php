<!DOCTYPE html>
<?php session_start();
//미리 연결시켜놓는다.
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
$user_conn = mysqli_connect($servername, $username, $password,"user_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
if (!$user_conn) {
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
              <a class="nav-link btn btn-light disabled" href="#">장바구니</a>
            </li>
          </div>
          <div class="col-md-1 mt-2 text-center">
            <img src="https://cdns.iconmonstr.com/wp-content/assets/preview/2012/240/iconmonstr-arrow-24.png" alt="" style="width:25px; height:25px;">
          </div>
          <div class="col-md-2 text-center">
            <li class="nav-item">
              <a class="nav-link btn btn-light bg-active" href="#">주문/결제</a>
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
           <h4>[주문 목록]</h4>
           <hr>
         </div>
       </div>
       <div class="row">
         <table class= "table text-center">
           <thead>
             <tr>
               <th>이미지</th>
               <th>작품명</th>
               <th>판매가</th>
               <th>수량</th>
               <th>상품금액</th>
             </tr>
           </thead>
           <tbody>
             <?php
             $my_total_price = 0;
             $send_price = 0;
             //주문 결제 부터는 무조건 회원용(디비) 장바구니
             $sql = "select name, photo, price, count from carts left join arts on carts.product_id = arts.id where user_id ='".$_SESSION['email']."';";
             $result = mysqli_query($conn, $sql);
             mysqli_store_result($conn);

             if(mysqli_num_rows($result)>0){
               while($row = mysqli_fetch_assoc($result)){
                 $my_price = $row['count']*$row['price'];
                 $my_total_price += $my_price;
                 echo '<tr>
                   <td><img src="./database/images/'.$row['photo'].'" alt="art image" style="width:60px; height:60px;"></td>
                   <td>'.$row['name'].'</td>
                   <td>'.number_format($row['price']).'원</td>
                   <td>'.$row['count'].'</td>
                   <td>'.number_format($my_price).'원</td>
                </tr>';
               }
             }
             ?>
           </tbody>
         </table>
       </div>
       <div class="row">
         <div class="col-md-12">
           <br>
           <h4>[주문자 정보]</h4>
           <hr>
         </div>
       </div>
       <?php
       //회원의 정보를 가져오는 부분
       $user_sql = "select name, email, phone_num, post_num, address, detail_address from user_info where email ='".$_SESSION['email']."';";
       $result = mysqli_query($user_conn, $user_sql);
       mysqli_store_result($user_conn);

       if(mysqli_num_rows($result)>0){
         $row = mysqli_fetch_assoc($result);
         $name = $row['name'];
         $email = $row['email'];
         $phone_num = $row['phone_num'];
         $phone1 = substr($phone_num, 0, 3);
         $phone = substr($phone_num, 3, strlen($phone_num)-3);
         $string = str_split($phone,4);
         $phone2 = $string[0];
         $phone3 = $string[1];
         $post_num = $row['post_num'];
         $address = $row['address'];
         $detail_address = $row['detail_address'];
       }
       ?>
       <script type="text/javascript">
        var name = '<?php echo $name; ?>';
        var phone1 = '<?php echo $phone1; ?>';
        var phone2 = '<?php echo $phone2; ?>';
        var phone3 = '<?php echo $phone3; ?>';
        var post_num = '<?php echo $post_num; ?>';
        var address = '<?php echo $address; ?>';
        var detail_address = '<?php echo $detail_address; ?>';
        //console.log(name+" "+phone1+" "+phone2+" "+phone3+" "+post_num+" "+address);
        $(document).ready(function(){
          $('input[name=delivery_radio]').bind('change', function(){
            var option = $(this).val();
            if(option == "same"){
              $('#getter').val(name);
              $('#getter_phone1').val(phone1);
              $('#getter_phone2').val(phone2);
              $('#getter_phone3').val(phone3);
              $('#getter_post').val(post_num);
              $('#getter_add').val(address);
              $('#getter_detail').val(detail_address);
            }else if(option == "new"){
              $('#getter').val('');
              $('#getter_phone1').val('');
              $('#getter_phone2').val('');
              $('#getter_phone3').val('');
              $('#getter_post').val('');
              $('#getter_add').val('');
              $('#getter_detail').val('');
            }
          });
        });
       </script>
       <style media="screen">
       .attri{
           background-color: #f5f5dc;

         }
       </style>
       <script type="text/javascript">


       </script>
       <form method="post" id="delivery_frm" name="frm" action="confirm.php">
       <div class="row">
         <div class="col-md-12">
           <div class="text-left table">
             <div class="form-group">
             <table style="width:100%;" class="text-center">
               <tbody>
             <tr>
               <th class="attri border-right">입금자명</th>
               <td colspan='2'><input type="text" name="money_person" value="<?php echo $name; ?>" class="form-control"></td>
               <td colspan='3'></td>
             </tr>
             <tr>
               <th class="attri border-right">전화번호</th>
               <td><input type="text" name="phone1" onkeypress="validate(event)" value="<?php echo $phone1; ?>" class="form-control"></td>
               <td>-</td>
               <td><input type="text" name="phone2" onkeypress="validate(event)" value="<?php echo $phone2; ?>" class="form-control"></td>
               <td>-</td>
               <td><input type="text" name="phone3" onkeypress="validate(event)" value="<?php echo $phone3; ?>" class="form-control"></td>
             </tr>
             <tr class="border-bottom">
               <th class="attri border-right">이메일</th>
               <td colspan='2'><input type="text" name="email" value="<?php echo $email; ?>" class="form-control"></td>
               <td colspan='3'></td>
             </tr>
              </tbody>
              </table>
              </div>
           </div>
         </div>
       </div>
       <div class="row">
         <div class="col-md-12">
           <br>
           <h4>[배송지 정보]</h4>
           <hr>
         </div>
       </div>
       <div class="row">
         <div class="col-md-12">
           <div class="text-left table">
             <div class="form-group">
             <table class="text-center" style="width:100%;">
               <tbody>
             <tr>
               <th class="attri border-right">배송지 선택</th>
               <td> <input type="radio" name="delivery_radio" value="same" checked ="checked" class="mr-2">주문자 정보와 동일 </td>
               <td> <input type="radio" name="delivery_radio" value="new"  class="mr-2">새로 입력 </td>
               <td colspan='3'></td>
             </tr>
             <tr>
               <th class="attri border-right">수령인</th>
               <td><input type="text" name="getter" id ="getter" value="<?php echo $name; ?>" class="form-control"></td>
               <td colspan='4'></td>
             </tr>
             <tr>
               <th class="attri border-right">수령인 번호</th>
               <td><input type="text" id="getter_phone1" name="getter_phone1" value="<?php echo $phone1; ?>" class="form-control"></td>
               <td>-</td>
               <td><input type="text" id="getter_phone2" name="getter_phone2" value="<?php echo $phone2; ?>" class="form-control"></td>
               <td>-</td>
               <td><input type="text" id="getter_phone3" name="getter_phone3" value="<?php echo $phone3; ?>" class="form-control"></td>
             </tr>
             <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
             <script>
             //load함수를 이용하여 core스크립트의 로딩이 완료된 후, 우편번호 서비스를 실행합니다.
             function execPostCode() {
             //alert("post post");
               new daum.Postcode({
               oncomplete: function(data) {
                 // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                 // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                 // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                 var addr = ''; // 주소 변수
                 var extraAddr = ''; // 참고항목 변수

                 //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
                 if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                     addr = data.roadAddress;
                 } else { // 사용자가 지번 주소를 선택했을 경우(J)
                     addr = data.jibunAddress;
                 }
                 // 우편번호와 주소 정보를 해당 필드에 넣는다.
                 document.getElementById('getter_post').value = data.zonecode;
                 document.getElementById("getter_add").value = addr;
                 // 커서를 상세주소 필드로 이동한다.
                 document.getElementById("getter_detail").focus();
               }
             }).open();
           }
           </script>
             <tr>
               <th class="attri border-right" rowspan='3'>주소</th>
               <td colspan='3'><div class="input-group">
                 <input type="text" class="form-control" onkeypress= "validate(event)" id="getter_post" value = "<?php echo $post_num;?>"name="post_num">
                 <span class="input-group-btn">
                   <button type="button" class="btn btn-dark" onclick="execPostCode();">우편번호 검색</button>
                 </span>
               </div></td>
             </tr>
             <tr>
               <td colspan="4"><input type="text" class="form-control mb-2" name="address" id="getter_add" placeholder="주소" value = "<?php echo $address;?>"></td>
               <td colspan='1'></td>
             </tr>
             <tr>
               <td colspan='4'><input type="text" class="form-control" name="detail_address" id="getter_detail" placeholder="나머지 상세주소" value = "<?php echo $detail_address;?>"></td>
               <td colspan='1'></td>
             </tr>
             <tr class="border-bottom">
               <th class="attri border-right">배송시요청</th>
               <td colspan='5'><textarea name="delivery_require" rows="5" form="delivery_frm" class= "md-textarea form-control" wrap="hard" placeholder="배송시 요청사항을 남겨주세요."cols="40"></textarea></td>
             </tr>
              </tbody>
              </table>
              </div>
           </div>
         </div>
       </div>

     <br>
     <div class="row">
       <div class="col-md-12">
         <hr><br>
       </div>
     </div>
     <div class="row" >
       <div class="col-md-1">

       </div>
       <div class="col-md-8 text-center" style="background:#f5f5dc">
         <table style="width:100%;" class="table">
           <thead>
             <tr>
               <td>&emsp;&emsp;상품 금액&emsp;&emsp;</td>
               <td>+</td>
               <td>&emsp;&emsp;배송비&emsp;&emsp;</td>
               <td>=</td>
               <td>&emsp;&emsp;총 결제 금액&emsp;&emsp;</td>
             </tr>
           </thead>
           <tbody>
             <tr>
               <td><?php echo number_format($my_total_price)."원" ?></td>
               <td></td>
               <td><?php if($my_total_price<300000 && $my_total_price>0){
                      $send_price= 5000;
                    }
                    echo number_format($send_price)."원";
               ?></td>
               <td></td>
               <td><h4><strong><?php echo number_format($my_total_price+$send_price)."원";?></strong></h4></td>
             </tr>
           </tbody>
         </table>
       </div>
       <div class="col-md-2">
         <button type="submit" name="button" class= "btn btn-dark" style="width:100%; height:100%;"><h4>다음단계</h4></button>
       </div>
     </div>
      </form>
      <br>
      <div class="row">
        <div class="col-md-12">
          <hr><br>
        </div>
      </div>
     <br><br>

     </div>
     <script type="text/javascript">
       function validate(evt) {
         var theEvent = evt || window.event;

         // Handle paste
         if (theEvent.type === 'paste') {
             key = event.clipboardData.getData('text/plain');
         } else {
         // Handle key press
             var key = theEvent.keyCode || theEvent.which;
             key = String.fromCharCode(key);
         }
         var regex = /[0-9]|\./;
         if( !regex.test(key) ) {
           alert("숫자만 기입할 수 있습니다.");
           theEvent.returnValue = false;
           if(theEvent.preventDefault) theEvent.preventDefault();
         }
       }

     </script>

<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
