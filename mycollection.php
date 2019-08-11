<!DOCTYPE html>
<?php session_start(); ?>
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
  <style>
  hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 2px solid rgba(0, 0, 0, 1);
  }
  .good-btn-off{
    background: url(https://www.printbakery.com/images/button/prd_good_off_btn.png) no-repeat;
    width:35px;
    height:35px;
    border: none;
    opacity: 0.7;
    outline: none;
    background-position: 10px center;
  }

  .good-btn-on{
    background: url(https://www.printbakery.com/images/button/prd_good_on_btn.png) no-repeat;
    width:35px;
    height:35px;
    border: none;
    opacity: 0.7;
    outline: none;
    background-position: 10px center;
  }
  a.custom-card,
  a.custom-card:hover {
  color: inherit;
}
.card-img{
 width: 100%!important;
 height: 310px!important;
 object-fit:cover;
}

.artist-img{
 width: 60px;
 height: 60px;
}
.custom-control-label::before,
.custom-control-label::after {
top: .8rem;
width: 1.25rem;
height: 1.25rem;
}
  </style>
</head>

<body>


<!--여기부터 시작 -->
<div class="container">
  <div class="row">
    <div class="col-md-12">
      <br>
    </div>
  </div>
  <div class="row">
    <div class="col-md-4">
    </div>
    <div class="col-md-2 text-right">
      <button type="button" name="button" class="btn btn-outline-secondary" id="select_all">전체 선택</button>
    </div>
    <div class="col-md-2 text-left">
        <button type="button" name="button" class="btn btn-outline-secondary" id="delete_all">전체 해제</button>
    </div>
    <div class="col-md-4">
    </div>
  </div>
</div>

<div class="card-deck">
  <div class="container">
    <div class="row">
    <div class="col-md-12">
      <br>
    </div>
    </div>

    <!---->
<form class="" action="partorder.php" id="partbuy_frm" method="get">
<div class="row">
<?php
$servername = "localhost";
$username = "root";
$password = "1234";
$conn = mysqli_connect($servername, $username, $password,"my_db");
//$conn2 = mysqli_connect($servername, $username, $password,"my_db");

$sql = "select product_id from likes where user_id = '".$_SESSION['email']."';";//로그인한 아이디에 해당하는 좋아요 목록을 가져온다.
$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);

if(mysqli_num_rows($result)>0){
  $num = 0;
  while($row = mysqli_fetch_assoc($result)){
    $product_id = $row['product_id'];//하나의 좋아요 물품을 가져온 경우
    $sql_product = "select id, name, photo, price, edition, arts.artist_id,
    artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id where id='".$product_id."';";
    //그 물품 아이디에 대한 정보를 전부 가져온다.
    if(mysqli_query($conn,$sql_product)>0){//아직 삭제되지 않은 물품인 경우에만
      $row = mysqli_fetch_assoc(mysqli_query($conn,$sql_product));
      $num++;
      $art_id = $row["id"];
      $art_name = $row["name"];
      $art_photo = $row["photo"];
      $price = $row["price"];
      $edition = $row["edition"];
      $artist_id= $row["artist_id"];
      $artist_name = $row["artist_name"];
      $artist_photo = $row["artist_photo"];
      $href_link = "view.php?artid=".$art_id."&artistid=".$artist_id;

      $good_class ="";
      $good_sql = "select * from likes where user_id ='".$_SESSION['email']."' and product_id='$art_id';";
      if(mysqli_num_rows(mysqli_query($conn,$good_sql))>0){
        $good_class="good-btn-on";
      }else{
        $good_class="good-btn-off";
      }
      $output .='
      <div class="col-md-4">
      <strong>[선택]</strong> <input type="checkbox" name="select_item[]" value="'.$art_id.'">
      <a href="'.$href_link.'" class="custom-card">
        <div class="card shadow">
          <img class="card-img" src="./database/images/'.$art_photo.'" alt="'. $art_photo .'">
          <div class="card-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-2 mr-2 pr-2 pl-1 mt-1">
                  <img src="./database/artists/'. $artist_photo .'" class="artist-img rounded-circle card-text" alt="'.$artist_name.'">
                </div>
                <div class="col-md-9 ml-2">
                  <h6 class="card-title">'. $art_name. '</h6>
                  <p class="card-text">'.$artist_name.'<br><small class="text-muted">Limited edition: '.$edition .'</small></p>
                </div>
              </div>
              </a>
              <div class="row">
                <div class="col-md-6 text-center mt-1" style="font-size:x-large; color:gray;">
                &#8361 '.$price.'
                </div>
                <div class="col-md-6 text-right">
                  <button type="button" name="good_btn" data-id="'.$art_id.'" class="'.$good_class.'" style="margin-top:5px;"></button>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
        ';

      if($num%3 ==0){
        $output .='</div>
        <div class="row">
          <div class="col-md-12">
            <br>
          </div>
        </div>
        <div class="row">
        ';//3번째 애는 row를 닫고 여는 역할을 해야한다.
      }
    }
  }
  echo $output;
}else{
  echo "아직 좋아요를 누른 목록이 없습니다. ";
}
 ?>
</div>
<div class="row">
  <div class="col-md-12">
    <br>
  </div>
</div>
</div>
</div>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <hr>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-3">
    </div>
    <div class="col-md-3 text-right">
      <button type="submit" name="button" class="btn" style="background:gray; color:white;" id="buy_btn">선택한 작품 구매하기</button>
    </div>
    </form>
    <div class="col-md-3">
      <button type="button" name="button" class="btn btn-dark" id="cart_btn">선택한 작품 장바구니에 담기</button>
    </div>
  </div>
</div>

<br><br>
<script type="text/javascript">
$('button[name="good_btn"]').click(function(){
    var item_id = $(this).data('id');
    var like = "" //ajax를 통해 바뀌었으면 하는 값(바뀐 결과)을 저장한다.
    //alert(item_id);
    if($(this).hasClass('good-btn-off')){
      $(this).attr('class','good-btn-on');
      like = "yes";
    }else{
      $(this).attr('class','good-btn-off');
      like = "no";
    }//클래스를 바꾸어 색깔을 바꾼다.

    $.ajax({//아이템 아이디와 바뀌었으면 하는 결과를 받아서 반영하는 ajax
        async: true,
        type : 'GET',
        data : {'item_id':  item_id, 'like': like},
        url : "/likeprocess.php",
        dataType : "text",
        contentType: "application/json; charset=UTF-8",
        success : function(data) {
          //alert(data);
          location.reload();
        },
        error : function(error) {
            console.log("error : " + error);
        }
      });
  });

$('#select_all').click(function(){
  $('input:checkbox[name="select_item[]"]').each(function() {
      this.checked = true; //checked 처리
    });
});
$('#delete_all').click(function(){
  $('input:checkbox[name="select_item[]"]').each(function() {
      this.checked = false; //unchecked 처리
    });
});
$('#cart_btn').click(function(){
  $('#partbuy_frm').attr('action', "likebasket.php");
  $('#partbuy_frm').submit();
});


</script>

<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
