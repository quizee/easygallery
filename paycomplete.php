<!DOCTYPE html>
<?php session_start();?>
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

<body>
<!--여기부터 시작 -->
<style>
.bg-active{
  background-color: #FFA500;
}
</style>
<br><br>

     <ul class="nav justify-content-center">
       <div class="container">
        <div class="row">
          <div class="col-md-2">

          </div>
          <div class="col-md-2 text-center">
            <li class="nav-item ">
              <a class="nav-link btn btn-light disabled" href="#">장바구니</a>
            </li>
          </div>
          <div class="col-md-1 mt-2 text-center">
            <img src="https://cdns.iconmonstr.com/wp-content/assets/preview/2012/240/iconmonstr-arrow-24.png" alt="" style="width:25px; height:25px;">
          </div>
          <div class="col-md-2 text-center">
            <li class="nav-item">
              <a class="nav-link btn btn-light disabled" href="#">주문/결제</a>
            </li>
          </div>
          <div class="col-md-1 mt-2 text-center">
            <img src="https://cdns.iconmonstr.com/wp-content/assets/preview/2012/240/iconmonstr-arrow-24.png" alt="" style="width:25px; height:25px;">
          </div>
          <div class="col-md-2 text-center">
            <li class="nav-item">
              <a class="nav-link btn btn-light bg-active" href="#">주문 완료</a>
            </li>
          </div>
          <div class="col-md-2">
          </div>
        </div>
       </div>
     </ul>
     <br><br>

<div class="contain" style="height:600px;">
  <div class="row">
    <div class="col-md-12">
      <br><br>
    </div>
  </div>
  <div class="row">
    <div class="col-md-3">
    </div>
    <div class="col-md-6 text-center">
      <h4>"고객님의 주문이 접수되었습니다."</h4>
      주문내역은 주문조회에서 확인하실 수 있습니다.
    </div>
    <div class="col-md-3">
    </div>
  </div>

</div>
<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
