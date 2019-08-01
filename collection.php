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

  .good-btn{
    background: url(https://www.printbakery.com/images/button/prd_good_off_btn.png) no-repeat;
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
    <li class="list-inline-item"><button class="btn border-right" type="button"  id="price"name="button" onclick="javascript:clickinner(this,'price');">낮은 가격순</button></li>
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
    <div class="row">
      <?php
      //echo $_GET['order'];
      $servername = "localhost";
      $username = "root";
      $password = "1234";
      // Create connection
      $conn = mysqli_connect($servername, $username, $password,"my_db");
      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      //디비에 일단 연결한다.
      switch($_GET['order']){
        case "recent":
          $sql = "select id, name, photo, price, buy_count, edition, arts.artist_id,
          artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id order by id desc;";
          break;
        case "best":
          $sql = "select id, name, photo, price, buy_count, like_count, edition, arts.artist_id, artist_name, artist_photo
          from arts left join artists on arts.artist_id = artists.artist_id order by buy_count desc;";
          break;
        case "price":
          $sql = "select id, name, photo, price, buy_count, like_count, edition, arts.artist_id,
          artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id order by price;";
          break;
        default :
          $sql = "select id, name, photo, price, buy_count, edition, arts.artist_id,
          artist_name, artist_photo from arts left join artists on arts.artist_id = artists.artist_id order by id desc;";
          break;
      }
      //$sql = "select * from artists";
      //echo "sql: ".$sql." ";
      $result = mysqli_query($conn,$sql);
      mysqli_store_result($conn);
      $output = '';
      //echo "result: ".$result;
      //echo $sql;

     //
      if(mysqli_num_rows($result)>0){
        $num = 0;
        while($row = mysqli_fetch_assoc($result)){
          $num = $num +1;
          $art_id = $row["id"];
          $art_name = $row["name"];
          $art_photo = $row["photo"];
          $price = $row["price"];
          $buy_count = $row["buy_count"];
          $edition = $row["edition"];
          $artist_id= $row["artist_id"];
          $artist_name = $row["artist_name"];
          $artist_photo = $row["artist_photo"];
          $href_link = "view.php?artid=".$art_id."&artistid=".$artist_id;
          //$isitclickable = "isitClickable?";
          //echo $art_name." ".$artist_name;
          $output .='
          <div class="col-md-4">
          <a href="'.$href_link.'" class="custom-card">
            <div class="card shadow">
              <img class="card-img" src="./database/images/'.$art_photo.'" alt="'. $art_photo .'">
              <div class="card-body">
                <div class="container-fluid">
                  <div class="row">
                    <div class="col-md-2 mr-2 pr-2 pl-1">
                      <img src="./database/artists/'. $artist_photo .'" class="artist-img rounded-circle card-text" alt="'.$artist_name.'">
                    </div>
                    <div class="col-md-9 ml-2">
                      <h6 class="card-title">'. $art_name. '</h6>
                      <p class="card-text">'.$artist_name.'<br><small class="text-muted">Limited edition: '.$edition .'</small></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 text-right">
                    </div>
                    <div class="col-md-6 text-right">
                      <button type="button" name="'.$art_id.'" id="cart_'.$art_id.'" class="to-cart-btn"></button>
                      <button type="button" name="'.$art_id.'" id="good_'.$art_id.'" class="good-btn"></button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            </a>
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
      //   }
      // }
      //
        }
        echo "".$output;
      }
      //
       ?>



      <!-- one card start -->
      <!-- <div class="col-md-4">
        <div class="card shadow">
          <img class="card-img" src="./images/dummy_picture.png" alt="Card image cap">
          <div class="card-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-2 mr-2 pr-2 pl-1">
                  <img src="https://i.ibb.co/yqVK65H/image.png" class="artist-img rounded-circle card-text" alt="ahn sohyun">
                </div>
                <div class="col-md-9 ml-2">
                  <h6 class="card-title">모과와 선인장</h6>
                  <p class="card-text">Ahn Sohuyun (안소현) <br><small class="text-muted">Limited edition: 99</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right">
                </div>
                <div class="col-md-6 text-right">
                  <button type="button" name="button" class="to-cart-btn"></button>
                  <button type="button" name="button" class="good-btn"></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- one card end -->

      <!-- one card start -->
      <!-- <div class="col-md-4">
        <div class="card shadow">
          <img class="card-img" src="https://i.ibb.co/CwNhKNj/20190717-183034.png" alt="Card image cap">
          <div class="card-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-2 mr-2 pr-2 pl-1">
                  <img src="https://i.ibb.co/yR6MMX8/image.png" class="artist-img rounded-circle card-text" alt="ahn sohyun">
                </div>
                <div class="col-md-9 ml-2">
                  <h6 class="card-title">Hidden Place</h6>
                  <p class="card-text">Jang Koal (장콸) <br><small class="text-muted">Limited edition: 99</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right">
                </div>
                <div class="col-md-6 text-right">
                  <button type="button" name="button" class="to-cart-btn"></button>
                  <button type="button" name="button" class="good-btn"></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- one card end -->

      <!-- one card start -->
      <!-- <div class="col-md-4">
        <div class="card shadow">
          <img class="card-img" src="https://i.ibb.co/fQ9ZdN9/20190717-183239.png" alt="Card image cap">
          <div class="card-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-md-2 mr-2 pr-2 pl-1">
                  <img src="https://i.ibb.co/ngBvNDG/image.png" class="artist-img rounded-circle card-text" alt="ahn sohyun">
                </div>
                <div class="col-md-9 ml-2">
                  <h6 class="card-title">말과 글12- 나의 아뜰리에</h6>
                  <p class="card-text">You SunTai (유선태) <br><small class="text-muted">Limited edition: 99</small></p>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6 text-right">
                </div>
                <div class="col-md-6 text-right">
                  <button type="button" name="button" class="to-cart-btn"></button>
                  <button type="button" name="button" class="good-btn"></button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- one card end -->

      </div>
      <div class="row">
        <div class="col-md-12">
          <br>
        </div>
      </div>
    </div>
  </div>

<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
