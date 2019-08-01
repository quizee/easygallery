<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">


  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <!-- services와 clusterer, drawing 라이브러리 불러오기 -->

  <?php include ('header.php');?>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <br>
      </div>
    </div>
    <div class="row">
      <div id="map" style="width:100%;height:600px;"></div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <br>
      </div>
    </div>
</div>

<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=486e42471d5e1999ab053bf197bfd039&libraries=services,drawing"></script>
<script type="text/javascript">
/*

var drawMap = function(where, name){
  var mapContainer = document.getElementById('map'), // 지도를 표시할 div
    mapOption = {
        center: new kakao.maps.LatLng(33.450701, 126.570667), // 지도의 중심좌표
        level: 3 // 지도의 확대 레벨
    };
    // 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
    var map = new kakao.maps.Map(mapContainer, mapOption);
    var geocoder = new kakao.maps.services.Geocoder();

    geocoder.addressSearch(where, function(result,status){
      if(status == kakao.maps.services.Status.OK){
        var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

        // 결과값으로 받은 위치를 마커로 표시합니다
        var marker = new kakao.maps.Marker({
            map: map,
            position: coords
        });
        // 인포윈도우로 장소에 대한 설명을 표시합니다
        var infowindow = new kakao.maps.InfoWindow({
            content: '<div style="width:150px;text-align:center;padding:6px 0;">'+name+'<br><a href="https://map.kakao.com/link/to/'+where+','+result[0].y+','+result[0].x+'" style="color:blue" target="_blank">길찾기</a></div>'
        });
        infowindow.open(map, marker);

        // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
        map.setCenter(coords);
      }
      });
  }
*/
</script>


<style>
ul{
   list-style:none;
   }
</style>


<div class="container">
  <div class="row">
    <div class="col-md-1">
    </div>
    <div class="col-md-1 mt-2 border-right">
      서울<br><br><br><br><br>
      경기
    </div>
    <div class="col-md-3 border-right text-left">
      <ul>
        <li>
          <a href="store.php?storeid=1" id = "id_1" class="btn">삼청지점 스토어</a>
        </li>
        <li>
          <a href="store.php?storeid=2" id = "id_2" class="btn">명동 롯데 스토어</a>
        </li>
        <br>
        <br>
        <li>
          <a href="store.php?storeid=3" id = "id_3" class="btn">하남 스타필드 스토어</a>
        </li>
      </ul>

    </div>
    <style>
    .bg-graycolor {
      background-color: #e2e2e2 !important;
    }
    </style>

    <div class="col-md-5">
      <div class="container rounded bg-graycolor pt-2 pb-1">
        <p>
          <strong>주소</strong><br>
          <span id="address"></span><br><br>
          <strong>문의</strong><br>
          <span id="phone_num"></span><br><br>
          <strong>운영 시간</strong><br>
          <span id="op_time"></span><br>
        </p>
      </div>
    </div>
    <div class="col-md-1">
    </div>
  </div>
  <div class="row">
    <p><br><br></p>
  </div>

</div>

  <?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <?php
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        $store_id =  $_GET['storeid'];

      // Create connection
        $conn = mysqli_connect($servername, $username, $password,"my_db");
      // Check connection
        if (!$conn) {
          die("Connection failed: " . mysqli_connect_error());
        }
        //id, address, name, phone_num, op_time
        $sql = "SELECT * FROM stores WHERE id=" . $store_id . ";";
        //echo $sql ."<br>";

        $user_query = mysqli_query($conn, $sql);
        mysqli_store_result($conn);

        if (mysqli_num_rows($user_query) > 0) {
          
          $row = mysqli_fetch_assoc($user_query);
          $place_name = $row["name"];
          $address = $row["address"];
          $phone_num = $row["phone_num"];
          $op_time = $row["op_time"];

          echo "
              <script>
              "."
              var mapContainer = document.getElementById('map'); // 지도를 표시할 div

                // 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다

                var geocoder = new kakao.maps.services.Geocoder();

                // var callback = function(result, status) {
                //   if (status === kakao.maps.services.Status.OK) {
                //     console.log(result);
                //   }
                // };
                //
                // geocoder.addressSearch('" .$address.  "', callback);

                 geocoder.addressSearch('". $address ."', function(result,status){
                  if(status == kakao.maps.services.Status.OK){
                    var coords = new kakao.maps.LatLng(result[0].y, result[0].x);

                    var mapOption = {
                        center: new kakao.maps.LatLng(result[0].y, result[0].y), // 지도의 중심좌표
                        level: 3 // 지도의 확대 레벨
                    };
                    var map = new kakao.maps.Map(mapContainer, mapOption);

                    // 결과값으로 받은 위치를 마커로 표시합니다
                    var marker = new kakao.maps.Marker({
                        map: map,
                        position: coords
                    });

                    // 인포윈도우로 장소에 대한 설명을 표시합니다
                    var infowindow = new kakao.maps.InfoWindow({
                        content: '<div style=\"width:200px;text-align:center;padding:6px 0;\">".$place_name ."<br><a href=\"https://map.kakao.com/link/to/". $address ." , '+result[0].y+','+result[0].x+'\" style=\"color:blue\" target=\"_blank\">길찾기</a></div>'
                    });
                    infowindow.open(map, marker);

                    // 지도의 중심을 결과값으로 받은 위치로 이동시킵니다
                    map.setCenter(coords);
                  }
                 });
                ". "</script>";

          echo "
              <script type=\"text/javascript\">
                document.getElementById('address').innerHTML = '".$address."';
                document.getElementById('phone_num').innerHTML = '".$phone_num ."';
                document.getElementById('op_time').innerHTML = '".$op_time ."';
                document.getElementById('id_". $store_id ."').style[\"font-weight\"] = 'bold';
              </script>
          ";

        } else {
          echo "0 results";
        }

        mysqli_close($conn);

        /*
        if(!mysqli_query($conn, $sql)){
          echo "Error: " . $sql . "<br>" . mysqli_error($conn);
        }

        echo "number of rows" . mysqli_num_rows($result);
        /*
        if(mysqli_num_rows($result)>0){
          $row = mysqli_fetch_assoc($result);
          echo $row;
          $place_name = $row["name"];
          $address = $row["address"];
          $phone_num = $row["phone_num"];
          $op_time = $row["op_time"];
          echo $place_name;
        }
        mysqli_close($conn);

        echo "
            <script type=\"text/javascript\">
            drawMap(" . $address . "," . $place_name . ");
            </script>
        ";

        echo "
            <script type=\"text/javascript\">
              document.getElementById('address').innerHTML = ".$address.";
              document.getElementById('phone_num').innerHTML = ".$phone_num .";
              document.getElementById('op_time').innerHTML = ".$op_time .";
            </script>
        ";*/
    }
   ?>

</body>

</html>
