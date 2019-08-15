<!DOCTYPE html>
<?php session_start();
$money_person = $_POST['money_person'];
$phone1 = $_POST['phone1'];
$phone2 = $_POST['phone2'];
$phone3 = $_POST['phone3'];
$phonenumber = $phone1.$phone2.$phone3;
$pay_phonenum = $phone1."-".$phone2."-".$phone3;
$email = $_POST['email'];
$getter = $_POST['getter'];
$getter_phone1 = $_POST['getter_phone1'];
$getter_phone2 = $_POST['getter_phone2'];
$getter_phone3 = $_POST['getter_phone3'];
$getter_phonenum = $getter_phone1."-".$getter_phone2."-".$getter_phone3;
$post_num = $_POST['post_num'];
$address = $_POST['address'];
$detail_address = $_POST['detail_address'];
$total_address= $address." ".$detail_address;
$delivery_require = $_POST['delivery_require'];
$delivery_address = $address." ".$detail_address." (".$post_num.")";

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

$GLOBALS['my_total_price'] = 0;
$send_price = 0;

// $sql = "select price, count from carts left join arts on carts.product_id = arts.id where user_id ='".$_SESSION['email']."';";
// $result = mysqli_query($conn, $sql);
// mysqli_store_result($conn);
//
// if(mysqli_num_rows($result)>0){
//   while($row = mysqli_fetch_assoc($result)){
//     $my_price = $row['count']*$row['price'];
//     amount += $my_price;
//   }
// }


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
  <script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>

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
        주문 확인 페이지 입니다. 정확하게 정보가 입력 되었는지 확인 하시고 <strong>결제하기</strong> 버튼을 클릭 해주세요.
           <br><br>
         </div>
       </div>
       <div class="row">
         <div class="col-md-12">
           <h5>[주문]</h5>
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
             $ids = $_POST['select_item'];
             //넘어온 아이템 목록이 장바구니 디비를 대신한다.
            // print_r($ids);
             foreach ($ids as $key => $id) {
               $sql = "select name, photo, price from arts where id ='".$id."';";//하나의 아이템에 대해 정보를 가져온다.
               $result = mysqli_query($conn, $sql);
               mysqli_store_result($conn);
               $row = mysqli_fetch_assoc($result);//하나밖에 못가져옴

               echo '<tr>
                 <td><img src="./database/images/'.$row['photo'].'" alt="art image" style="width:60px; height:60px;"></td>
                 <td>'.$row['name'].'</td>
                 <td>'.number_format($row['price']).'원</td>
                 <td>1</td>
                 <td>'.number_format($row['price']).'원</td>
                 </tr>';
                $GLOBALS['my_total_price'] += $row['price'];
                //echo '<input type="hidden" name="select_item[]" value="'.$id.'">';
             }

             if($GLOBALS['my_total_price']>1000000){
               $GLOBALS['test_total_price'] = 1000000;
             }else{
               $GLOBALS['test_total_price'] = $GLOBALS['my_total_price'];
             }
             ?>
           </tbody>
         </table>
       </div>
       <script type="text/javascript">

       $(function(){
         $("#kakaopay").click(function(){
         //  alert('kakao!');
           var IMP = window.IMP; // 생략가능
           IMP.init('imp00493624'); // 'iamport' 대신 부여받은 "가맹점 식별코드"를 사용
           var msg;

           IMP.request_pay({
               pg : 'kakaopay',
               pay_method : 'card',
               merchant_uid : 'merchant_' + new Date().getTime(),
               name : 'easygallery 작품 결제',
               amount : <?php echo $GLOBALS['test_total_price']; ?>,
               buyer_email : '<?php echo $email; ?>',
               buyer_name : '<?php echo $money_person; ?>',
               buyer_tel : '<?php echo $phonenumber; ?>',
               buyer_addr : '<?php echo $total_address; ?>',
               buyer_postcode : '<?php echo $post_num; ?>',
               //m_redirect_url : '/paycomplete.php'
           }, function(rsp) {
               if ( rsp.success ) {
                   //[1] 서버단에서 결제정보 조회를 위해 jQuery ajax로 imp_uid 전달하기
                   $.ajax({
                       url: "/partpayment.php", //cross-domain error가 발생하지 않도록 주의해주세요
                       type: 'POST',
                       dataType: 'text',
                       data: {
                           imp_uid : rsp.imp_uid,
                           pay_person : '<?php echo $money_person; ?>',
                           pay_phonenum : '<?php echo $pay_phonenum; ?>',
                           pay_email :'<?php echo $email; ?>',
                           getter:'<?php echo $getter;?>',
                           getter_phonenum : '<?php echo $getter_phonenum; ?>',
                           address : '<?php echo $delivery_address; ?>',
                           delivery_require : '<?php echo $delivery_require; ?>',
                           select_item :
                           <?php
                            $ids = $_POST['select_item'];
                            echo json_encode($ids);?>,
                           //기타 필요한 데이터가 있으면 추가 전달
                       },
                       success: function(data){
                         location.href='paycomplete.php';
                       },
                       error : function(data){
                         console.log('error');
                       }
                   });
                   // .done(function(data) {
                   //     //[2] 서버에서 REST API로 결제정보확인 및 서비스루틴이 정상적인 경우
                   //     if ( everythings_fine ) {
                   //         msg = '결제가 완료되었습니다.';
                   //         msg += '\n고유ID : ' + rsp.imp_uid;
                   //         msg += '\n상점 거래ID : ' + rsp.merchant_uid;
                   //         msg += '\결제 금액 : ' + rsp.paid_amount;
                   //         msg += '카드 승인번호 : ' + rsp.apply_num;
                   //
                   //         alert(msg);
                   //     } else {
                   //         //[3] 아직 제대로 결제가 되지 않았습니다.
                   //         //[4] 결제된 금액이 요청한 금액과 달라 결제를 자동취소처리하였습니다.
                   //     }
                   // });

                   //성공시 이동할 페이지
                   //
               } else {
                   msg = '결제에 실패하였습니다.';
                   msg += '에러내용 : ' + rsp.error_msg;
                   //실패시 이동할 페이지
                   location.href='order.php';
                   alert(msg);
               }
           });

         });
       });


       </script>

       <div class="row">
         <div class="col-md-12">
           <br>
           <h5>[주문자 정보]</h5>
           <hr>
         </div>
       </div>

       <style media="screen">
       /* .attri{
           background-color: #f5f5dc;

         } */
       </style>
       <script type="text/javascript">


       </script>

       <div class="row">
         <div class="col-md-12">

             <table style="width:100%;" class="table">
               <tbody>
             <tr>
               <th class="attri border-right">입금자명</th>
               <td><?php echo $money_person; ?></td>
             </tr>
             <tr>
               <th class="attri border-right">전화번호</th>
               <td><?php echo $phone1; ?> - <?php echo $phone2; ?> - <?php echo $phone3; ?></td>
             </tr>
             <tr class="border-bottom">
               <th class="attri border-right">이메일</th>
               <td><?php echo $email; ?></td>
             </tr>
              </tbody>
              </table>

         </div>
       </div>
       <div class="row">
         <div class="col-md-12">
           <br>
           <h5>[배송지 정보]</h5>
           <hr>
         </div>
       </div>
       <div class="row">
         <div class="col-md-12">
           <div class="text-left table">

             <table class="table" style="width:100%;">
               <tbody>
             <tr>
               <th class="attri border-right">수령인</th>
               <td><?php echo $getter; ?></td>
             </tr>
             <tr>
               <th class="attri border-right">수령인 번호</th>
               <td><?php echo $getter_phone1; ?> - <?php echo $getter_phone2; ?> - <?php echo $getter_phone3; ?></td>
             </tr>
             <tr>
               <th class="attri border-right" rowspan='2'>주소</th>
               <td><?php echo $post_num;?></td>
             </tr>
             <tr>
               <td><?php echo $address;?> <?php echo $detail_address;?></td>
             </tr>
             <tr class="border-bottom">
               <th class="attri border-right">배송시요청</th>
               <td><?php echo $delivery_require; ?></td>
             </tr>
              </tbody>
              </table>

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
       <div class="col-md-8">
         <table style="width:100%;" class="table text-center">
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
               <td><?php echo number_format($GLOBALS['my_total_price'])."원" ?></td>
               <td></td>
               <td><?php if($GLOBALS['my_total_price']<300000 && $GLOBALS['my_total_price']>0){
                      $send_price= 5000;
                    }
                    echo number_format($send_price)."원";
               ?></td>
               <td></td>
               <td><h4><strong><?php echo number_format($GLOBALS['my_total_price']+$send_price)."원";?></strong></h4></td>
             </tr>
           </tbody>
         </table>
       </div>
       <div class="col-md-2">
         <button type="button" name="kakaopay" id="kakaopay" class= "btn btn-dark" style="width:100%; height:100%;"><h4>결제하기</h4></button>
       </div>
     </div>
      <br>
      <div class="row">
        <div class="col-md-12">
          <hr><br>
        </div>
      </div>
     <br><br>

     </div>


<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
