<style>
  .red{
    color: red;
  }
  .blue{
    color: blue;
  }
  hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 4px solid rgba(0, 0, 0, 1);
  }
</style>

<div class="container-fluid">
  <form action="" id="order_search_frm" method="get">
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
      </td>
    </tr>
    <tr>
      <th>주문 번호</th>
      <td> <input type="text" name="order_id_search" value="" placeholder="주문번호로 검색">
        <button type="button" name="button" class="btn btn-dark" id="search_order" style="margin-left:400px;">조회하기</button> </td>
    </tr>
  </table>
  <input type="hidden" name="stance" value="order">
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
      $('button[name="date_btn"]').click(function(){//오늘, 1주일, 1달 눌렀을 때 날짜 보이는 부분 업데이트하는 리스너
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
        <th>주문자정보(연락처/이메일)</th>
        <th>배송지정보</th>
        <th>주문처리상태</th>
        <th>구매확정</th>
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
        $condition = $_GET['condition'];
        $from = $_GET['from'];
        $to = $_GET['to'];
        $order_id_search = $_GET['order_id_search'];
        $on_one_page = 5;
        if(!isset($_GET['page'])){
          $pages = 0;
        }else{
          $pages = $_GET['page'] * $on_one_page;
        }

        if(isset($order_id_search)){//검색어가 있는 경우
          //echo "from: ".$from."<br>";
          if($order_id_search !=""){//주문번호가 들어온 경우는 이것만 보여줌.
            $sql_search = "select order_id,name,photo,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
            delivery_require,delivery_state,done from orders join arts on orders.product_id = arts.id where order_id = '".$order_id_search."'";
          }else{// 그 외에는 배송 상태와 날짜로
            //배송상태 먼저
            $i = 0;
            foreach ($condition as $key => $value) {
              if($i == 0){//처음일 때
              //  $count_sql = "select count(*) as cnt from orders where (delivery_state = '".$value."'";
                $sql_search = "select order_id,name,photo,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
                delivery_require,delivery_state,done from orders join arts on orders.product_id = arts.id where (delivery_state = '".$value."'";
              }else{
              //  $count_sql .= "or delivery_state = '".$value."'";
                $sql_search .= " or delivery_state = '".$value."'";
              }
              $i++;
            }
            if(isset($from) && isset($to)){
              if(($from == "") && ($to == "")){
                $sql_search .=") order by order_id desc";
              }else{//날짜 제한이 있는 경우
                $sql_search .=")and pay_date <= '".$to."' and pay_date >= '".$from."' order by order_id desc";
              }
            }
          }
        }else{//검색어가없는경우
        //  $count_sql = "select count(*) as cnt from orders;";
          $sql_search = "select order_id,name,photo,user_id,count,pay_price,pay_date,pay_person,pay_phonenum,pay_email,getter,getter_phonenum,address,
          delivery_require,delivery_state,done from orders join arts on orders.product_id = arts.id order by order_id desc";
        }
        //echo $count_sql."<br>";
        //$count_result = mysqli_query($conn, $count_sql);
      //  mysqli_store_result($conn);
        $result = mysqli_query($conn, $sql_search);
        mysqli_store_result($conn);
        $total_order = mysqli_num_rows($result);

        //echo $total_order;
        //echo $sql_search;

        $button_count = ceil($total_order/$on_one_page);
        //echo "total_number: ".$total_order." ";
        //echo "button_count ".$button_count;
        $sql_search .= " LIMIT $pages, $on_one_page;";
        //echo $sql_search;
        $result = mysqli_query($conn, $sql_search);
        mysqli_store_result($conn);

        if(mysqli_num_rows($result)>0){
          while($row = mysqli_fetch_assoc($result)){
            if($row['delivery_state'] == "배송 준비중"){
              $class_red = "red";
              $state_btn = "배송 처리하기";
              $disabled = "";
            }else{
              $class_red = "";
              $state_btn = "처리 완료";
              $disabled = "disabled";
            }
            if($row['done'] == "대기중"){
              $class_blue = "blue";
            }else{
              $class_blue = "";
            }
            echo '  <tr>
                <td>'.$row['pay_date'].'<br>['.$row['order_id'].']</td>
                <td class = "text-center">'.$row['name'].'<br> <img src="../database/images/'.$row['photo'].'" alt="" style="width:80px; height:80px;" class="mt-2"> </td>
                <td class = "text-center" style = "width:100px;"> <br>'.$row['count'].'</td>
                <td>- 입금자: '.$row['pay_person'].'<br><br> - 연락처: '.$row['pay_phonenum'].'<br>- 이메일: '.$row['pay_email'].'</td>
                <td>- 수령인: '.$row['getter'].' <br><br> - 연락처: '.$row['getter_phonenum'].' <br>- 배송지: '.$row['address'].' <br> - 배송시 요청사항: '.$row['delivery_require'].'</td>
                <td class="text-center"><span class ="'.$class_red.'">'.$row['delivery_state'].'</span><br> <button type="button" id ="'.$row['order_id'].'" name="'.$row['user_id'].'" class="btn btn-primary mt-4"'.$disabled.'>'.$state_btn.'</button> </td>
                <td class="text-center"><span class = "'.$class_blue.'">'.$row['done'].'</span></td>
              </tr>';
          }
        }
       ?>
    </tbody>
  </table>
</div>
<div class="container">
  <div class="row">
    <div class="col-md-12 text-center">
      <?php
      for($i=0;$i<$button_count;$i++){
        $y = $i +1;
        echo '<button type="button" name="page_btn" id="'.$i.'"> '.$y.' </button>';
      }
       ?>
    </div>
  </div>
</div>
<input type="hidden" id="hidden_order_num" value="">
<!-- Modal for delivery-->
<div class="modal fade" id="DeliveryModal" tabindex="-1" role="dialog" aria-labelledby="배송처리" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">배송 처리 <span id="order_num"></span> </h5>

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

<script type="text/javascript">
$(function(){
  $('button[name="page_btn"]').click(function(){
    //alert($(this).attr('id'));
    var page_id = $(this).attr('id');
    var something_set = <?php
      if(isset($order_id_search)){
        echo 'true';
      }else{
        echo 'false';
      }?>

    if(something_set){//이미 검색 기록이 있었을 경우
      window.location.href = "index.php?stance=order&page="+page_id+"<?php
      foreach ($condition as $key => $value) {
        echo "&condition[]=".$value;
      }?>
      &from=<?php echo $from; ?>&to=<?php echo $to; ?>&order_id_search=<?php echo $order_id_search;?>";
    }else{
      window.location.href = "index.php?stance=order&page="+page_id;
    }
  });
});

$(function(){
  $('.btn-primary').click(function(){
    var order_id = $(this).attr('id');
    var order_person = $(this).attr('name');
    $('#order_num').text("[주문번호: "+order_id+"]");
    $('#hidden_order_num').val(order_id);

    var order_list = order_id.split('_');
    //결국 필요한건 order_date
    var order_time = order_list[0];

    $.ajax({
        async: true,
        type : 'GET',
        data : {'date': order_time, 'order_id' : order_id, 'buyer': order_person},
        url : "/admin/getgroup.php",
        dataType : "text",
        contentType: "application/json; charset=UTF-8",
        success : function(data) {
            $('#group_list').html(data);
            //alert(data);
        },
        error : function(error) {
            alert("error : " + error);
        }
      });

    $('#DeliveryModal').modal('show');
  });
});

$(function(){
  $('input[name="group_delivery"]').click(function(){
    if($(this).prop("checked") == true){
      $('#group_list').collapse("show");
      $('input[name="group_product"]:checkbox').each(function(){
        $(this).attr("checked", true);
      });
    }else if($(this).prop("checked") == false){
      $('#group_list').collapse("hide");
      $('input[name="group_product"]:checkbox').each(function(){
        $(this).attr("checked", false);
      });
    }
  });
});

$(function(){
  $("#delivery_submit").click(function(){
    var company = $('#company_option option:selected').val();
    var delivery_num =  $("#delivery_num").val();
    var selected = new Array();
    $('input[name="group_product"]:checked').each(function(){
      selected.push($(this).val());
      //console.log(selected);
    });
    selected.push($('#hidden_order_num').val());

    $.ajax({
        async: true,
        type : 'GET',
        data : {'selected_list' : selected, 'company':  company, 'delivery_num': delivery_num},
        url : "/admin/delivery.php",
        dataType : "text",
        contentType: "application/json; charset=UTF-8",
        success : function(data) {
          alert(data)
          $('#DeliveryModal').modal('hide');
          window.location.reload();
        },
        error : function(error) {
            alert("error : " + error);
        }
      });
  });
});


</script>
