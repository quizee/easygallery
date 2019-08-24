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
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
  <?php include ('header.php');?>
</head>

<body>
<!--여기부터 회원가입 폼 시작 -->
<!--
<div class = "shadow-lg p-4 mb-4 bg-light">Try programming examples</div>-->

<style>
   .card-img{
    width: 100%!important;
    height: 310px!important;
    object-fit:cover;
  }

  .artist-img{
    width: 60px;
    height: 60px;
  }
  .prd-price{
    position: relative;
    float: right;
    text-align: right;
  }
  .to-cart-btn{
    background: url(https://www.printbakery.com/images/button/prd_cart_btn.png) no-repeat;
    width:35px;
    height:35px;
    border: none;
    opacity: 0.7;
    outline: none;
    background-position: 10px center;
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
  .textdecoration2 { text-decoration: underline; }

  a.custom-card,
  a.custom-card:hover {
  color: inherit;
}

</style>
<script type="text/javascript">
  function clickinner(target,order){
    location.href='collection.php?order='+order;
  }
</script>
<script type="text/javascript">
function getParam(sname) {
    var params = location.search.substr(location.search.indexOf("?") + 1);
    var sval = "";
    params = params.split("&");
    for (var i = 0; i < params.length; i++) {
        temp = params[i].split("=");
        if ([temp[0]] == sname) { sval = temp[1]; }
    }
    return sval;
}
var param = getParam("order");
//alert(param);
document.getElementById(param).classList.add('textdecoration2');



//$("a[href="+pathname.substring(1)+"]").closest('li').addClass('active');
</script>
<!-- script for sorting-->
<?php
// if($_SERVER["REQUEST_METHOD"]=="GET"){
//   $order_id =  $_GET['order'];
//
// }
?>

<br><br>
<div class="container">
  <ul class="list-inline ">
    <li class="list-inline-item"><button class="btn border-right" type="button" id="recent" name="button" onclick="javascript:clickinner(this,'recent');">최신순</button></li>
    <li class="list-inline-item"><button class="btn border-right" type="button"  id="best" name="button" onclick="javascript:clickinner(this,'best');">인기순</button></li>
    <li class="list-inline-item"><button class="btn" type="button"  id="price"name="button" onclick="javascript:clickinner(this,'price');">낮은 가격순</button></li>
  </ul>
</div>
<div class="card-deck">
  <div class="container">
    <div class="row">
    <div class="col-md-12">
      <br>
    </div>
    </div>


    <!---->
    <div class="row" id= "load_data">
      <?php
      //echo $_GET['order'];
      $servername = "localhost";
      $username = "root";
      $password = "1234";
      // Create connection
      $conn = mysqli_connect($servername, $username, $password,"my_db");
      //$conn2 = mysqli_connect($servername, $username, $password,"my_db");
      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      //디비에 일단 연결한다.
      switch($_GET['order']){
        case "recent":
          $sql = "select id, name, photo, price, like_count, buy_count, edition, arts.artist_id,
          artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id order by id desc;";
          break;
        case "best":
          $sql = "select id, name, photo, price, buy_count, like_count, edition, arts.artist_id, artist_name, artist_photo
          from arts left join artists on arts.artist_id = artists.artist_id order by buy_count+like_count desc;";
          break;
        case "price":
          $sql = "select id, name, photo, price, buy_count, like_count, edition, arts.artist_id,
          artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id order by price;";
          break;
        default :
          $sql = "select id, name, photo, price, buy_count, like_count, edition, arts.artist_id,
          artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id order by id desc;";
          break;
      }

      $result = mysqli_query($conn,$sql);
      mysqli_store_result($conn);
      $output = '';

      if(mysqli_num_rows($result)>0){
        $num = 0;
        while($row = mysqli_fetch_assoc($result)){
          $num = $num +1;
          $art_id = $row["id"];
          $art_name = $row["name"];
          $art_photo = $row["photo"];
          $price = $row["price"];
          $buy_count = $row["buy_count"];
          $like_count = $row["like_count"];
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
                      <small style="padding:0px; margin-top:5px;" data-id="'.$art_id.'">'.$like_count.'</small>
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
        echo "".$output;
      }
      //
       ?>
      </div>
      <div class="row" id="load_data_msg">

      </div>
      <div class="row">
        <div class="col-md-12">
          <br>
        </div>
      </div>
    </div>
  </div>
  <button type="button" class="button btn-info" name="button">등록된 작품이 없습니다.</button>
  <script type="text/javascript">
    $(document).ready(funtion(){
      var limit = 16;
      var start = 0;
      var action = 'inactive';

      function load_art_data(limit,start){
        $.ajax({


        });
      }

    });
  </script>
  <script type="text/javascript">
  $('button[name="good_btn"]').click(function(){
    var login =
    <?php
    if(isset($_SESSION['email'])){
      echo 'true';
    }else{
      echo 'false';
    }
    ?>;
    if(login){
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
            $('small[data-id="'+item_id+'"]').text(data);
          },
          error : function(error) {
              console.log("error : " + error);
          }
        });
    }else{
      alert('좋아요는 로그인 후 이용할 수 있습니다.')
    }

  });
  </script>
<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
