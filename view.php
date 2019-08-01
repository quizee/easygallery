<?php session_start(); ?>
<?php
$art_id =  $_GET['artid'];
$artist_id = $_GET['artistid'];
//echo $art_id." ".$artist_id;

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
$sql= "select * from arts left join artists on arts.artist_id = artists.artist_id where id='".$art_id."';";
$sql2= "select detail_photo from details where art_id = '".$art_id."';";

$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);

if(mysqli_num_rows($result)>0){
  $row = mysqli_fetch_assoc($result);
  $image_file = "./database/images/".$row['photo'];//사진
  $art_name = $row['name'];
  $horizontal = $row['horizontal'];//가로
  $vertical = $row['vertical'];//세로
  $price = $row['price'];
  $buy_count = $row['buy_count'];
  $edition = $row['edition'];
  $material = $row['material'];
  $artist_name = $row['artist_name'];
  $artist_photo = "./database/artists/".$row['artist_photo'];
  $artist_introduce = $row['artist_introduce'];
  $birth = $row['birth'];
  $death = $row['death'];
}

$result2 = mysqli_query($conn,$sql2);
mysqli_store_result($conn);
$detail_photos = array();

if(mysqli_num_rows($result2)>0){
  while($row = mysqli_fetch_assoc($result2)){
    array_push($detail_photos, $row['detail_photo']);
  }
}

?>

<!DOCTYPE html>
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

<body data-spy="scroll" data-target="#navbar-detail" data-offset="70">
<!--여기부터 시작 -->
<style>
  hr {
  margin-top: 1rem;
  margin-bottom: 1rem;
  border: 0;
  border-top: 1px solid rgba(0, 0, 0, 0.5);
  }
  .container {
    width: 100%;
    padding-right: 0px;
    padding-left: 0px;
    margin-right: auto;
    margin-left: auto;
  }

</style>

<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <br> <br>
    </div>
  </div>
  <div class="row">
    <div class="col-md-6 ml-5 mr-1">
      <img src="<?php echo $image_file ?>" alt="art image" style="width: 100%; height: 510px;">
    </div>
    <div class="col-md-5">
      <div class="container-fluid">

        <div class="row mb-2">
          <div class="col-md-12">
            <h4 class="ml-1"><?php echo $art_name?></h4>
            <hr/>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
          <strong>작가명</strong>
          </div>
          <div class="col-md-6">
            <?php echo $artist_name?>
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>작품크기</strong>
          </div>
          <div class="col-md-6">
            (Frame) <?php echo $horizontal."*".$vertical."cm"?>
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>소재</strong>
          </div>
          <div class="col-md-6">
            <?php echo $material ?>
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>에디션</strong>
          </div>
          <div class="col-md-6">
            Limited edition number: <?php $my_count =$buy_count +1; echo $my_count ." / ".$edition ?>
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-12">
            <hr/>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>가격</strong>
          </div>
          <div class="col-md-6">
            <?php echo "KRW ".number_format($price) ?>
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>배송안내</strong>
          </div>
          <div class="col-md-6">
            <a href="#">배송유형 확인하기</a>
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>구매수량</strong>
          </div>
          <div class="col-md-6">
            <input type="number" name="count_buy" id="count_buy" value="1" min="1" max="<?php $max=$edition-$buy_count; echo $max;?>">
          </div>
          <div class="col-md-2">
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-12">
            <hr>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-4">
            <strong>결제예정금액</strong>
          </div>
          <div class="col-md-6 font-weight-bold text-info">
            <strong><h4>KRW <span id="total_price"><?php echo number_format($price) ?></span></h4></strong>
          </div>
          <div class="col-md-2">
          </div>
        </div>
        <script type="text/javascript">
        function numberWithCommas(x) {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        $("#count_buy").bind('keyup input', function(){
          // handle event
          var my_price = Number($("#count_buy").val()*Number(<?php echo $price ?>));
          console.log(my_price);
          $("#total_price").text(numberWithCommas(my_price));
        });


        </script>
        <!--장바구니 이동할까 모달-->
        <div class="modal fade" id="gocart" tabindex="-1" role="dialog" aria-labelledby="회원가입" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <div class="container">
                  <div class="row">
                    <div class="col text-center">
                      <h5 class="modal-title" id="cart">장바구니에 상품이 담겼습니다.</h5>
                    </div>
                  </div>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <div class="container">
                  <div class="row">
                    <div class="col-md-3">

                    </div>
                    <div class="col-md-6 text-center">
                      <p>
                        장바구니로 이동하시겠습니까?
                      </p>
                    </div>
                  </div>
                </div>

                <script type="text/javascript">
                function stay(){
                  $('#gocart').modal('hide');
                  var count = $('#count_buy').val();
                  window.location.href = 'addbaskettest.php?artid=<?php echo $art_id; ?>&count='+count+'&shop=stay';
                }

                function addcart(){
                  var count = $('#count_buy').val();
                  window.location.href = 'addbaskettest.php?artid=<?php echo $art_id; ?>&count='+count+'&shop=stop';
                }

                </script>

                <div class="container">
                  <div class="row">
                    <div class="col-md-1">

                    </div>
                    <div class="col-md-11">
                      <button type="button" class="btn btn-lg btn-light ml-3 mr-1" onclick="addcart();">장바구니로 이동</button>
                      <button type="button" class="btn btn-lg btn-light" onclick="stay();">계속 쇼핑하기</button>
                    </div>
                    <!-- <div class="col-md-6 text-center"> -->

                    <!-- </div> -->
                    <!-- <div class="col-md-6 text-center"> -->
                    <!-- </div> -->
                  </div>
                </div>
              </div>
              <div class="modal-footer">

              </div>
            </div>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-8 text-left">
            <button type="button" name="button" class="btn btn-dark" style="display: block; width:100%; text-align: center;">구매하기</button>
          </div>
          <div class="col-md-4 font-weight-bold text-info">
            <button type="button" name="button" class="btn btn-dark">상품문의</button>
          </div>
        </div>

        <div class="row mb-2">
          <div class="col-md-5 text-left">
            <button type="button" name="button" class="btn btn-light" style="display: block; width:100%; text-align: center;">마이컬렉션에 추가</button>
          </div>
          <div class="col-md-4 font-weight-bold text-info">
            <button type="button" name="button" class="btn btn-light" data-toggle = "modal" data-target="#gocart" style="display: block; width:100%; text-align: center;">장바구니</button>
          </div>
        </div>
      </div><!-- 가격 표시까지 완료-->
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <br>
    </div>
  </div>
  <style>

  </style>

  <nav id="navbar-detail" class="navbar navbar-expand-lg sticky-top navbar-light" style="position:sticky; top:56px; background-color:#e3f2fd;">

    <ul class="nav nav-pills">
      <li class="nav-item">
        <a class="nav-link" href="#about_artist">작가 소개</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#about_art">작품 소개</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#about_caution">주의 사항</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="#about_recommend">추천 작품</a>
      </li>
    </ul>
  </nav>

  <div class="row">
    <div class="col-md-12">
      <br><br>
    </div>
  </div>
<!--네비게이션 바 끝나고 내용 본격적으로 시작하려고 띄는거임-->

  <div class="row">
    <div class="col-md-12">
      <div class="container">

        <div class="row" id="about_artist">
          <div class="col-md-12">
            <img src="<?php echo $artist_photo; ?>" alt="artist image" style="width: 100%; height: 510px;">
            <br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12 text-center">
            <br> <br><strong> <h2>작가소개</h2> </strong><br>  <br>
            <?php echo $artist_introduce; ?>
            <br><br>
            <strong><h5><?php
            $artist_explode = explode('(',$artist_name);
            $english_name = $artist_explode[0];
            $korean_name = $artist_explode[1];
            $korean_name = substr($korean_name, 0, -1);
            echo $korean_name." ".strtoupper($english_name);
             ?></h5></strong>
             <?php if($death == NULL){
               $death="";
             }
               echo "[".$birth."~".$death."]"; ?>
              <br><br><br>
          </div>
        </div>

        <div class="row">
          <div class="col-md-4">
          </div>
          <div class="col-md-4 text-center">
            <button type="button" name="button" class="btn btn-light" style="border: 2px solid black; background-color: white;
  color: black;display: block; text-align: center; padding:14px 28px; width:100%;" >작가 정보 더보기</button><br><br><br>
          </div>
          <div class="col-md-4">
          </div>
        </div>

        <div class="row" id="about_art">
          <div class="col-md-2"></div>
          <div class="col-md-8 text-center">
            <br> <br><strong> <h2>작품소개</h2> </strong><br>  <br>
            <p style="width:100%;">
              <?php
              echo $artist_introduce;
               ?>
            </p>
            <br><br>
          </div>
          <div class="col-md-2"></div>
        </div>

        <?php
          $array_length = count($detail_photos);

          for($x = 0; $x < $array_length ; $x++){
            //echo $detail_photos[$x];
            echo '<div class="row">
              <div class="col-md-12">
                <img src="./database/details/'. $detail_photos[$x] .'" alt="detail image" style="width: 100%; height: 510px;">
                <br><br><br>
              </div>
            </div>';
          }
         ?>

        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8 text-center">
            <br> <br><strong> <h2>전문 아트 컨설턴트에게 상담받아보세요</h2> </strong><br>  <br>
              <p style="width:100%;">
            작품을 고르시기 막막하신가요? 방문신청을 하시면 전문 아트 컨설턴트가 직접 방문하여 고객님의 취향 및 공간을 고려한 작품을 추천해 드립니다.
              <br><br>
            </p>
          </div>
          <div class="col-md-2"></div>
        </div>

        <div class="row">
          <div class="col-md-4">
          </div>
          <div class="col-md-4 text-center">
            <button type="button" name="button" class="btn btn-light" style="border: 2px solid black; background-color: white;
  color: black;display: block; text-align: center; padding:14px 28px; width:100%;" >방문신청하러 가기</button><br><br><br>
          </div>
          <div class="col-md-4">
          </div>
        </div>

      </div>
    </div>
  </div>

  <div class="row" id="about_caution">
    <div class="col-md-12 text-center">
      <br> <br><strong> <h2>작품 취급 시 주의사항</h2> </strong><br>  <br>
      <br>
    </div>
  </div>

  <div class="row">
    <div class="col-md-1"></div>
    <div class="col-md-3 ml-5">
      <img src="./database/asset/glass.png" alt="glass" style="width: 100%; height:300px;">
      <p><br>작품 전면은글라스로 제작되어 긁힘에 민감하오니 작품 표면에 손상이 가지 않도록 주의해주십시오.<br></p>
    </div>
    <div class="col-md-3 ml-3">
      <img src="./database/asset/temp.png" alt="temp" style="width: 100%; height:300px;">
      <br>
      <p><br>직사광선이 들어오는 곳, 온도나 습도가 높거나 급격한 변화가 발생하는 곳에 설치하지 마십시오.<br></p>
    </div>
    <div class="col-md-3 ml-3">
      <img src="./database/asset/water.png" alt="water" style="width: 100%; height:300px;">
      <br>
      <p><br>작품 표면을 닦을 시 물걸레 또는 유리 세정제 등을 사용하여 닦을 경우, 습기에 의한 작품 손상이 발생할 수 있습니다.<br></p>
    </div>
    <div class="col-md-1"></div>
  </div>
  <br><br>

  <div class="row" id="about_recommend">
    <div class="col-md-12 text-center">
      <br> <br><strong> <h4>이 작품을 구입한 회원님들이 선택한 작품들</h4> </strong><br>  <br>
      <br>
    </div>
  </div>


</div>


<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
