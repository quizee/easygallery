<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js" crossorigin="anonymous"></script>
  <?php include ('header.php');?>
  </head>
  <style>
  .bootstrap-tagsinput {
  width: 100%;
  }
  </style>
  <body>
    <div class="container">
      <h4>작품의 진정한 가치는 공유에 있습니다. 당신의 공간을 알려보세요!</h4><br>

    <form action="delivery.php" method="get">
      <div class="form-group">
        <br>
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
      <div class="from-group">

      </div>
      <div class="form-group">
        <textarea name="introduce" rows="3" form="art_frm" class= "md-textarea form-control" autofocus required wrap="hard" placeholder="당신의 공간을 홍보하면서 적립금(5%)도 받아보세요!&#13;&#10;"cols="50"></textarea>
      </div>
      <div class="form-group">
        <input type="text" data-role="tagsinput" class="form-control" name="hashtag" value="easygallery">
      </div>
    </form>
    </div>

<?php include 'footer.php';?>
  </body>

</html>
