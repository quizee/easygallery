<!DOCTYPE html>
<?php session_start();
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
<div class="container-fluid">
  <form action="" id="order_search_frm" method="post">
  <table class = "table">
    <tr>
      <th>조회 기간</th>
      <td> <input type="date" id = "from" name="from" value=""> ~ <input type="date" id="to" name="to" value="">
        <button type="button" name="date_btn" id="today" class = "ml-5">오늘</button>
        <button type="button" name="date_btn" id="week">1주일</button>
        <button type="button" name="date_btn" id="month">1개월</button>
        <button type="button" name="date_btn" id="wholeday">전체</button>
    </tr>
    <tr>
      <th>주문 상태</th>
      <td> <input type="checkbox" name="all" value="all" id="select_all"> 전체
        <input type="checkbox" name="condition[]" value="배송 준비중" class="ml-5 condition"> 배송 준비중
        <input type="checkbox" name="condition[]" value="배송중" class="ml-2 condition"> 배송중
        <input type="checkbox" name="condition[]" value="배송 완료" class="ml-2 condition"> 배송 완료
        <button type="button" name="button" class="btn btn-dark" id="search_order" style="margin-left:100px;">조회하기</button>
      </td>
    </tr>
  </table>
  </form>

  <script type="text/javascript">
  function valthisform()
  {
  var checkboxs=document.getElementsByName("condition[]");
  var okay=false;
  for(var i=0,l=checkboxs.length;i<l;i++)
  {
      if(checkboxs[i].checked)
      {
          okay=true;
          break;
      }
  }
    return okay;
  }
  function valdate(){
    okay = false;
    if(($('#from').val()=="" && $('#to').val()== "")||($('#from').val() !="" && $('#to').val() != "") ){
      okay = true;
    }
    return okay;
  }
  $(function(){
    $('#search_order').click(function(){
    //  alert('dateok?'+valdate());
      if(valthisform()&& valdate()){
        $('#order_search_frm').submit();
      }else if(valthisform()==false){
        alert('배송 조건을 적어도 하나 선택해주세요.');
      }else if(valdate()==false){
        alert('날짜를 다시 선택해주세요.');
      }
    });
  });

  </script>

  <script type="text/javascript">
  function formatDate(date) {
    var d = new Date(date), month = '' + (d.getMonth() + 1), day = '' + d.getDate(), year = d.getFullYear();
    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    return [year, month, day].join('-');
  }
    $(function(){
      $('button[name="date_btn"]').click(function(){
        var now = new Date();
        var period = $(this).attr('id');

        $('#to').val(formatDate(now));
        if(period == "today"){
          var current = now;
        }else if(period == "week"){
          var current = new Date(now.getTime() - 7 * 24 * 60 * 60 * 1000);
        }else if(period == "month"){
          if(now.getMonth() == 11){
            var current = new Date(now.getFullYear()+1,0,1);
          }else{
            var current = new Date(now.getFullYear(),now.getMonth()-1,now.getDate());
          }
        }else if(period == "wholeday"){
          $('#to').val("");
          var current = "";
        }
        $('#from').val(formatDate(current));
      });
    });

    $(function(){
      $('#select_all').click(function(){
        if($(this).prop("checked") == true){
          $('input[name="condition[]"]:checkbox').each(function(){
            $(this).attr("checked", true);
          });
        }else if($(this).prop("checked") == false){
          $('input[name="condition[]"]:checkbox').each(function(){
            $(this).attr("checked", false);
          });
        }
      });
    });
  </script>

  <hr>
  <table class= "table table-bordered">
    <thead>
      <tr>
        <th>구매날짜[주문번호]</th>
        <th>상품정보</th>
        <th>구매수량</th>
        <th>구매금액</th>
        <th>주문처리상태</th>
      </tr>
    </thead>
    <tbody>
      <?php
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
      <?php
        $condition = $_POST['condition'];
        $from = $_POST['from'];
        $to = $_POST['to'];

        if(isset($from)){//검색어가 있는 경우
            //배송상태 먼저
            $i = 0;
            foreach ($condition as $key => $value) {
              if($i == 0){//처음일 때
                $sql_search = "select order_id,name,photo,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
                delivery_require,delivery_state,done from orders join arts on orders.product_id = arts.id where (delivery_state = '".$value."'";
              }else{
                $sql_search .= " or delivery_state = '".$value."'";
              }
              $i++;
            }
            if(isset($from) && isset($to)){
              if(($from == "") && ($to == "")){
                $sql_search .=")and user_id ='".$_SESSION['email']."' order by order_id desc;";
              }else{//날짜 제한이 있는 경우
                //WHERE DATE(post_date) BETWEEN '2012-01-22' AND '2012-01-23';
                $sql_search .=")and pay_date <= '".$to."' and pay_date >= '".$from."'and user_id ='".$_SESSION['email']."' order by order_id desc;";
              }
            }
        }else{//검색어가없는경우
          $sql_search = "select order_id,name,photo,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
          delivery_require,delivery_state,done from orders join arts on orders.product_id = arts.id where user_id ='".$_SESSION['email']."' order by order_id desc;";
        }
        //echo $sql_search;

        $result = mysqli_query($conn, $sql_search);
        mysqli_store_result($conn);

        if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_assoc($result)){

            $output = '<tr>
                  <td>'.$row['pay_date'].'<br>['.$row['order_id'].']</td>
                  <td class = "text-center">'.$row['name'].'<br> <img src="./database/images/'.$row['photo'].'" alt="" style="width:80px; height:80px;" class="mt-2"> </td>
                  <td class = "text-center" style = "width:10%;"> <br>'.$row['count'].'</td>
                  <td class = "text-center" style = "width:10%;"> <br>'.$row['pay_price'].'</td>
                  <td class="text-center" style="width:25%;"><<'.$row['delivery_state'].'>><br>';

            if($row['delivery_state'] == "배송중"){//배송중일때만 구매확정 버튼이 나온다
              $output .= '<button type="button" id ="'.$row['order_id'].'" name="confirm_btn" class="btn btn-primary mt-4">구매확정</button><br>(배송 완료/반품 의사 없음을 표시해주세요)</td>
             </tr>';
            }else if($row['delivery_state'] == "배송 준비중"){
             $output .= '</td></tr>';
            }else if($row['delivery_state'] == "배송 완료"){
             $output .= '<button type="button" id ="review-'.$row['order_id'].'" name="review_btn" class="btn btn-dark mt-4">리뷰쓰기</button></td></tr>';
            }
            echo $output;
          }
        }
       ?>
    </tbody>
  </table>
</div>
<div class="container">
  <div class="col-md-12 text-center">
    
  </div>
</div>


<script type="text/javascript">
$(function(){
  $('button[name="confirm_btn"]').click(function(){
    var clicked_id = $(this).attr('id');
    $.ajax({
        async: true,
        type : 'GET',
        data : {'order_id' : clicked_id},
        url : "/confirmdelivery.php",
        dataType : "text",
        contentType: "application/json; charset=UTF-8",
        success : function(data) {
          alert(data);
          window.location.reload();
        },
        error : function(error) {
            alert("error : " + error);
        }
      });
  });
});
$(function(){
  $('button[name="review_btn"]').click(function(){
    var clicked_id = $(this).attr('id'); //review-id
    var string_list = clicked_id.split('-');
    clicked_id = string_list[1];
    //alert(clicked_id);
    // $.ajax({
    //     async: true,
    //     type : 'GET',
    //     data : {'order_id' : clicked_id},
    //     url : "/confirmdelivery.php",
    //     dataType : "text",
    //     contentType: "application/json; charset=UTF-8",
    //     success : function(data) {
    //       alert(data);
    //       window.location.reload();
    //     },
    //     error : function(error) {
    //         alert("error : " + error);
    //     }
    //   });
  });
});
</script>
<div class="modal fade" id="ReviewModal" tabindex="-1" role="dialog" aria-labelledby="리뷰쓰기" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">리뷰 쓰기 <span id="order_num"></span> </h5>

        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="delivery.php" method="get">
          <div class="form-group">
            <div class="input-group">
            <input type="checkbox" name="group_delivery" class="mb-2" id="group_delivery">
            <label for="group_delivery" class="ml-2">묶음배송</label>
            </div>
          </div>
          <div class="form-group">
            <div id="group_list" class="collapse">

            </div>
          </div>
          <br>
          <div class="form-group">
            <div class="input-group">
              <select name="company_choice" id="company_option">
                <option value="">택배사 선택</option>
                <option value="한진 택배">한진 택배</option>
                <option value="우체국 택배">우체국 택배</option>
                <option value="로젠 택배">로젠 택배</option>
              </select>
            <input type="text" class="form-control" name="delivery_num" id="delivery_num" placeholder="송장번호 입력">
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" id="delivery_submit" class="btn btn-outline-dark btn-lg">완료</button>
      </div>
    </div>
  </div>
</div>


<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
