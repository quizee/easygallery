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

    <?php

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

      $artist_name = $_POST['artist_name'];
      $artist_introduce = $_POST['artist_introduce'];
      $carrier = $_POST['carrier'];
      $birth = $_POST['birth'];
      $death = $_POST['death'];

      $artist_photo = $_POST['file_name'];

      $servername = "localhost";
      $username = "root";
      $password = "1234";

      // Create connection
      $conn = mysqli_connect($servername, $username, $password,"my_db");

      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }
      if($death == ""){
        $sql = "
        UPDATE artists SET artist_name = '$artist_name', carrier = '$carrier', artist_introduce = '$artist_introduce',
        birth = '$birth', death = NULL, artist_photo = '$artist_photo' where artist_id = '$artist_id';";
      }else{
        $sql = "
        UPDATE artists SET artist_name = '$artist_name', carrier = '$carrier', artist_introduce = '$artist_introduce',
        birth = '$birth', death = '$death', artist_photo = '$artist_photo' where artist_id = '$artist_id';";
      }
    
      if(!mysqli_query($conn, $sql)){
        die("Error: " . $sql . "<br>" . mysqli_error($conn));
      }

      //한장짜리
      $tmpFile = $_FILES['pic']['tmp_name'];
      echo '<script>console.log("'.$tmpFile.'")</script>';
      $newFile = '/var/www/html/database/artists/'.$_FILES['pic']['name'];
      $result = move_uploaded_file($tmpFile, $newFile);

      if ($result) {
          echo '<script>console.log("업로드가 완료되었습니다.")</script>';
      } else {
           echo '<script>console.log("업로드 실패")</script>';
      }

      header('Location: artist.php');
      exit();
      }
      ?>

    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <h2>[신규 작가 등록]
          </h2>
          <br>
        </div>
      </div>
      <div class="row">
        <div class="col-md-3"></div>
        <div class="col-md-6">
          <form method="post" id="art_frm" name="art_frm" action="" enctype="multipart/form-data">
            <div class="form-group">
              <label for="artist_name">작가명:</label>
              <input type="text" value="" class="form-control" id="artist_name" placeholder="ex) Lee Jeeyoon(이지윤)" name="artist_name" required="작가명을 입력해주세요">
            </div>
            <div class="form-group">
              <h4>작가 소개</h4>
              <textarea name="artist_introduce" rows="10" form="art_frm" class= "md-textarea form-control" required wrap="hard" placeholder="작가의 소개글을 남겨주세요"cols="80"></textarea>
            </div>
            <div class="form-group">
              <h4>작가 경력</h4>
              <textarea name="carrier" rows="10" form="art_frm" class= "md-textarea form-control" required wrap="hard" placeholder="ex) 2015 가나아트 컨템포러리 초대전, 서울
2013 인사아트센터 초대전, 서울
2011 가나아트 컨템포러리 초대전, 서울
2009 인사아트센터 초대전, 서울"cols="80"></textarea>
            </div>
            <div class="form-group">
              <label for="art_size">작가 활동시기:</label>
              <div class="input-group" id="art_size">
                <label for="horizontal" class="mr-2">출생년도</label>
                <input type="text" value="" class="form-control" onkeypress="validate(event)" id="horizontal" name="birth"required>
                <label for="vertical" class="ml-2 mr-2">사망년도</label>
                <input type="text" value = "" class="form-control" id="vertical" onkeypress="validate(event)" name="death" placeholder="생존시 빈칸으로">
              </div>
            </div>
            <div class="form-group">
              <label for="art_photo">작가 사진(대표사진):</label>
              <div class="input-group" id="art_photo">
                <div class="custom-file">
                  <input id="file_name" value="" class="form-control readonly" name="file_name" value="작가 사진을 업로드해주세요." style="display:inline;">
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
            <div class="text-center mb-4">
              <button type="submit" id="submit_btn" class="btn btn-dark">작가 등록</button>
            </div>
          </form>
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
