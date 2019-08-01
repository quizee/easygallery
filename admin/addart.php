<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <!-- <link rel="import" href="header.html"> -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
/* .container-fluid{
  width: 100%;
  padding-right: 0px;
  padding-left: 0px;
  margin-right: auto;
  margin-left: auto;
} */
</style>
<script>

</script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

  <?php include "header.php"; ?>
</head>

<body>
<!--여기부터 시작 -->
<div class="content">
  <div class="container-fluid">
    <?php
    ob_start();
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
    <!-- id 작품명, 작가명, 작품 소개글, 등록 날짜, 작품 크기, 가격, 사진 url, 구매 횟수, edition -->
    <style media="screen">
    .fileRegiBtn label {
    display: inline-block;
    padding: .5em .75em;
    color: black;
    font-size: inherit;
    line-height: normal;
    vertical-align: middle;
    cursor: pointer;
    border-radius: .25em;
    }
    </style>

    <style>
      .scrollable{
        height: 200px;
        overflow: scroll;
      }
    </style>

    <br>

    <!-- Modal for artists-->
    <div class="modal fade" id="oldArtist" tabindex="-1" role="dialog" aria-labelledby="등록된 작가 검색" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">등록된 작가 검색</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <div class="input-group">
                <span class="input-group-addon mr-2 mt-1">작가명:</span>
                <input type="text" class="form-control" name="search_artist" id="search_artist" placeholder="작가명을 검색하세요"/>
              </div>
            </div>
            <div class="scrollable">
            <div id="result">

            </div>
          </div>
          </div>
          <div class="modal-footer">
            선택하려는 작가를 클릭하세요
          </div>
        </div>
      </div>
    </div>

    <script type="text/javascript">
      $(document).ready(function(){
        $('#search_artist').keyup(function(){
          var txt=$(this).val();
          if(txt != ''){
            $.ajax({
                async: true,
                type : 'GET',
                data : {'search':  txt},
                url : "/admin/fetch.php",
                dataType : "text",
                contentType: "application/json; charset=UTF-8",
                success : function(data) {
                  $('#result').html(data);
                  console.log(data);
                },
                error : function(error) {
                    console.log("error : " + error);
                }
              });
          }else{
            $('#result').html('');
          }
        });
      });
    </script>
    <script>
      function writeArtistId(artistId, artistName){
        document.getElementById('artistId').value = artistId;
        document.getElementById('artist_name').value = artistName;
        $('#oldArtist').modal('hide');//hide modal
        console.log("선택한 목록"+ document.getElementById('artist_name').value);
      }
    </script>
    <?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
      $art_name = $_POST['art_name'];
      $artist_id= $_POST['artistId'];
      $introduce = $_POST['introduce'];
      $price = $_POST['price'];
      $horizontal = $_POST['horizontal'];
      $vertical= $_POST['vertical'];
      $size = $horizontal * $vertical;

      //echo $art_name." ".$artist_id." ".$introduce." ".$price." ".$size;
      if($size>0 && $size<=500){
        $size_level = 1;
      }else if($size>500 && $size<=1500){
        $size_level = 2;
      }else if($size>1500 && $size<=5000){
        $size_level = 3;
      }else if($size>5000 && $size<=10000){
        $size_level = 4;
      }else if($size>10000){
        $size_level = 5;
      }

      $edition = $_POST['edition'];
      $material = $_POST['material'];

      //echo $art_name." ".$artist_id." ".$introduce." ".$price." ".$size." ".$size_level." ".$edition." ".$material." ".$image;
    //
    $imageName = $_POST['file_name'];//대표 사진
    $count_details = $_POST['input_count'];
    $detail_shots = $_POST['detail_shots'];
    //$details = array();
    //$sqls = array();
    // $photo1 = $_POST['1'];
    // $photo2 = $_POST['2'];
    // $photo3 = $_POST['3'];

    $servername = "localhost";
    $username = "root";
    $password = "1234";

    // Create connection
    $conn = mysqli_connect($servername, $username, $password,"my_db");

    // Check connection
    if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
    }

    $sql = "INSERT INTO arts (name, artist_id, horizontal,vertical, size_level, price, edition, material, photo, introduce)
    VALUES (" . "'" . $art_name . "'" . ",'" . $artist_id . "'" . ",'" . $horizontal . "'" . ",'" . $vertical  . "'" . ",'" . $size_level . "'" . ",'" . $price . "'" .  ",'" . $edition . "'" .  ",'" . $material . "'" . ",'" . $imageName . "'" . ",'" . $introduce. "'". ")";

    if(!mysqli_query($conn, $sql)){
      die("Error: " . $sql . "<br>" . mysqli_error($conn));
    }
    for($i=0; $i<count($detail_shots); $i++){
      $pic = $detail_shots[$i];
      $temp_sql = "INSERT INTO details (detail_photo) VALUES (" ."'" . $pic . "');";
      mysqli_query($conn, $temp_sql);
      //echo "<script>alert(".$temp_sql.");</script>";
      //array_push($sqls,$temp_sql);
    }

    // for($x=0;$x<count($sqls);$x++){
    //   echo "<script>console.log(".$sql[$x].");</script>";
    //   mysqli_query($conn, $sql[$x]);
    // }

    mysqli_close($conn);

    //한장짜리
    $tmpFile = $_FILES['pic']['tmp_name'];
    $newFile = '/var/www/html/database/images/'.$_FILES['pic']['name'];
    $result = move_uploaded_file($tmpFile, $newFile);

    if ($result) {
        echo '<script>alert("업로드가 완료되었습니다.")</script>';
    } else {
         echo '<script>alert("업로드 실패")</script>';
    }
    //여러장짜리
    $total = count($_FILES['pic_detail']['name']);
    // Loop through each file
    for( $i=0 ; $i < $total ; $i++ ) {
      //Get the temp file path
      $tmpFilePath = $_FILES['pic_detail']['tmp_name'][$i];

      //Make sure we have a file path
      if ($tmpFilePath != ""){
        //Setup our new file path
        $newFilePath = "/var/www/html/database/details/" . $_FILES['pic_detail']['name'][$i];
        if(move_uploaded_file($tmpFilePath, $newFilePath)) {
          echo "<script>console.log('success')</script>";
        }else{
          echo "<script>console.log('fail')</script>";
        }
      }

    }

    header('Location: art.php');
    exit();
    }
    //header('Location: art.php');
    ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <h2>[신규 작품 등록]</h2><br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <form method="post" id="art_frm" name="art_frm" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label for="art_name">작품명:</label>
              <input type="text" class="form-control" id="art_name" placeholder="작품명 입력" name="art_name" required="작품명을 입력해주세요">
            </div>
            <div class="form-group">
              <label for="artist_name">작가명:</label>
              <div class="input-group">
              <input type="text" class="form-control" id="artist_name" readonly placeholder="작가명 입력 ex. Hong Gildong (홍길동)" name="artist_name" required="작가명을 입력해주세요">
              <!-- <button type="button" class="btn btn-light ml-2 mr-1" name="new_artist" data-target="#newArtist" data-toggle="modal">신규 등록</button> -->
              <button type="button" class="btn btn-light"name="exist_artist" data-target="#oldArtist" data-toggle="modal">작가 검색</button>
              </div>
            </div>
            <div class="form-group">
              <h4>작품 소개</h4>
              <textarea name="introduce" rows="10" form="art_frm" class= "md-textarea form-control" autofocus required wrap="hard" placeholder="소개글을 남겨주세요"cols="80"></textarea>
            </div>
            <div class="form-group">
              <label for="price">작품 가격:</label>
              <input type="text" class="form-control" id="price" onkeypress="validate(event)" placeholder="가격 입력 ex. 49000" name="price" required="가격을 입력해주세요">
            </div>
            <div class="form-group">
              <label for="art_size">작품 크기:</label>
              <div class="input-group" id="art_size">
                <label for="horizontal" class="mr-2">가로(cm)</label>
                <input type="text" class="form-control" onkeypress="validate(event)" id="horizontal" name="horizontal"required>
                <label for="vertical" class="ml-2 mr-2">세로(cm)</label>
                <input type="text" class="form-control" id="vertical" onkeypress="validate(event)" name="vertical" required>
              </div>
            </div>
            <div class="form-group">
              <label for="art_photo">작품 사진(대표사진):</label>
              <div class="input-group" id="art_photo">
                <div class="custom-file">
                  <input id="file_name" class="form-control readonly" name="file_name" value="작품 사진을 업로드해주세요." style="display:inline;">
                  <div class="fileRegiBtn mt-5">
                  <label for="pic" class="btn btn-light">파일등록하기</label>
                  <input type="file" class="custom-file-input" id="pic"
                  aria-describedby="inputGroupFileAddon01" name="pic" size="25">
                  </div>
                </div>
              </div>
              <br>
              <div class="selectCover">
                <img id="cover" src="https://c-lj.gnst.jp/public/img/common/noimage.jpg?20190112050045" style="width: 100%; height: 500px;"/>
              </div>
            </div>
            <div class="form-group">
              <label for="detail_photo">상세 사진:</label>
              <div class="input-group" id="detail_photo">
                <div class="custom-file">
                  <input id="detail_file_name" class="form-control readonly" name="detail_file_name" value="작품 상세 사진을 업로드해주세요." style="display:inline;">
                  <div class="fileRegiBtn mt-5">
                  <label for="pic_detail" class="btn btn-light">파일등록하기</label>
                  <input name="pic_detail[]" id="pic_detail" class="custom-file-input" type="file" multiple/>
                  </div>
                </div>
              </div>
              <br>
              <ul id="fileList">

              </ul>
              <div class="form-group">
                <div id="detail_photos_input">
                </div>
                <input type="text" id="input_count" name="input_count" value="0" >
              </div>

            <div class="form-group">
              <label for="edition">제한 에디션 수:</label>
              <input type="number" class="form-control" id="price" onkeypress="validate(event)" placeholder="에디션 수 입력" name="edition" required>
            </div>
            <div class="form-group">
              <label for="material">소재:</label>
              <input type="text" class="form-control" id="material" placeholder="소재 입력" name="material" required>
            </div>
            <input type="hidden" id="artistId" name="artistId" value="">
            <div class="text-center mb-4">
              <button type="submit" id="submit_btn" class="btn btn-dark">작품등록</button>
            </div>
          </form>
          </div>
        </div>
      </div>


    <script type="text/javascript">
      function readURL(input) {
        console.log("버튼클릭함1");
        if (input.files && input.files[0]) {
          var reader = new FileReader();
          reader.onload = function (e) {
              $('#cover').attr('src', e.target.result);        //cover src로 붙여지고
              $('#file_name').val(input.files[0].name);    //파일선택 form으로 파일명이 들어온다
          }
        reader.readAsDataURL(input.files[0]);
      }
    }

    var list = document.getElementById('fileList');
    var div = document.getElementById('detail_photos_input');

    function readMulti(input){
      if (list.hasChildNodes()) {
  	     list.innerHTML="";
       }
       if (div.hasChildNodes()) {
   	     div.innerHTML="";
        }

       $('#detail_file_name').val(input.files[0].name+" 외 "+(input.files.length-1)+"장");
      //for every file...
      for (var x = 0; x < input.files.length; x++) {
      //add to list
        var li = document.createElement('li');
        li.innerHTML = 'File ' + (x + 1) + ':  ' + input.files[x].name;
        list.append(li);

      }

      document.getElementById('input_count').value = input.files.length;

      for (var x = 0; x < input.files.length; x++) {
        var hidden_input = document.createElement('input');
        hidden_input.setAttribute("type","text");
        hidden_input.setAttribute("name","detail_shots[]");
        //var y = x+1;
        //var hidden_name = y+"_id";
        //hidden_input.setAttribute("name",hidden_name);
        hidden_input.setAttribute("value",input.files[x].name);
        div.append(hidden_input);

        console.log(input.files[x].name);
        //console.log(hidden_input.id);
        //document.getElementById(y).value = input.files[x].name;
        //console.log(document.getElementById(y).value);
        //console.log(document.getElementById('photo'+x).value);
      }
    }

    $("#pic_detail").change(function(){
      readMulti(this);
    });

    $("#pic").change(function(){
      readURL(this);
      console.log("이미지 바뀜?");
    });


    </script>

</div>
</div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
