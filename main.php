<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <style>
 /* Make the image fully responsive */
 .carousel-inner img {
   width: 100%;
   height: 100%;
 }
 .container_img{
   color:white;
   text-align: center;
   width:100%;
   height:500px;
 }
 .centered-bottom{
   position:absolute;
   top:80%;
   left:50%;
   transform: translate(-50%, -50%);
 }
 .title-text{
   position:absolute;
   top:20%;
   left:30%
 }

 .btn-primary-outline {
  background-color: transparent;
  border-color: white;
  color: white;
}

.container {
  width: 100%;
  padding-right: 0px;
  padding-left: 0px;
  margin-right: auto;
  margin-left: auto;
}
 </style>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
  <?php include ('header.php');?>
</head>

<body>
<!--여기부터 시작 -->


<div class="container mt-3 mb-3">
<div id="myCarousel" class="carousel slide">

  <!-- Indicators -->
  <ul class="carousel-indicators">
    <li class="item1 active"></li>
    <li class="item2"></li>
    <li class="item3"></li>
  </ul>

  <!-- The slideshow -->
  <div class="carousel-inner">
    <div class="carousel-item active">
      <div class="container_img">
        <img src="./images/world_pic.jpg" alt="world" width="1100" height="500">
        <div class="title-text text-center">
          <strong><h3><세계를 누비던 그녀, 세계인의 공통을 찾다.></h3></strong>
        </div>
        <div class="centered-bottom">
          <button type="button" name="button" class="btn-lg btn-primary-outline btn-light">자세히 보러가기</button>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="container_img">
        <img src="./images/mom_pic.jpg" alt="mom" width="1100" height="500">
        <div class="title-text text-center">
          <strong><h3><자연 속 비비드함과 촉감이 그대로 느껴지는 듯한 꽃의 얼굴들.></h3></strong>
        </div>
        <div class="centered-bottom">
          <button type="button" name="button" class="btn-lg btn-primary-outline btn-light">자세히 보러가기</button>
        </div>
      </div>
    </div>
    <div class="carousel-item">
      <div class="container_img">
        <img src="./images/lake_pic.jpg" alt="lake" width="1100" height="500">
        <div class="title-text text-center">
          <strong><h3><호수 위 고요함의 테마. 그림으로 시 쓰고 노래하다.></h3></strong>
        </div>
        <div class="centered-bottom">
          <button type="button" name="button" class="btn-lg btn-primary-outline btn-light">자세히 보러가기</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Left and right controls -->
  <a class="carousel-control-prev" href="#myCarousel">
    <span class="carousel-control-prev-icon"></span>
  </a>
  <a class="carousel-control-next" href="#myCarousel">
    <span class="carousel-control-next-icon"></span>
  </a>
</div>
</div>
<!-- best 3-->

<div class="container">
  <div class="">

  </div>

</div>

<script>
$(document).ready(function(){
  // Activate Carousel
  $("#myCarousel").carousel();
  // Enable Carousel Indicators
  $(".item1").click(function(){
    $("#myCarousel").carousel(0);
  });
  $(".item2").click(function(){
    $("#myCarousel").carousel(1);
  });
  $(".item3").click(function(){
    $("#myCarousel").carousel(2);
  });

  // Enable Carousel Controls
  $(".carousel-control-prev").click(function(){
    $("#myCarousel").carousel("prev");
  });
  $(".carousel-control-next").click(function(){
    $("#myCarousel").carousel("next");
  });
});
</script>

<?php include 'footer.php';?>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script> -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
