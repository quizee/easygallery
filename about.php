<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


  <link rel="import" href="header.html">
  <style>
  <style>
  html {
    scroll-behavior: smooth;
  }

  #section1 {
    height: 550px;
    background-color: pink;
  }

  #section2 {
    height: 550px;
    background-color: yellow;
  }
  </style>
  <script>
  window.smoothScrollTo = function(endX, endY, duration) {
        let startX = window.scrollX || window.pageXOffset,
        startY = window.scrollY || window.pageYOffset,
        distanceX = endX - startX,
        distanceY = endY - startY,
        startTime = new Date().getTime();

        // Easing function
        let easeInOutQuart = function(time, from, distance, duration) {
            if ((time /= duration / 2) < 1) return distance / 2 * time * time * time * time + from;
            return -distance / 2 * ((time -= 2) * time * time * time - 2) + from;
        };

        let timer = window.setInterval(function() {
            let time = new Date().getTime() - startTime,
            newX = easeInOutQuart(time, startX, distanceX, duration),
            newY = easeInOutQuart(time, startY, distanceY, duration);
            if (time >= duration) {
                window.clearInterval(timer);
            }
            window.scrollTo(newX, newY);
        }, 1000 / 60); // 60 fps
    };
    var scroll_smooth = function(){
      let pos = document.querySelector(element).offsetTop;
      smoothScrollTo(0,pos,500)
    }
  </script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>easy, gallery</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <?php include ('header.php');?>
</head>

<body>
<!--starting about-->
<div class="main" id="section1">
  <h2>Section 1</h2>
  <p>Click on the link to see the "smooth" scrolling effect.</p>
  <a href="#section2" onclick="scroll_smooth();">Click Me to Smooth Scroll to Section 2 Below</a>
  <p>Note: Remove the scroll-behavior property to remove smooth scrolling.</p>
</div>

<div class="main" id="section2">
  <h2>Section 2</h2>
  <a href="#section1" onclick="scroll_smooth();">Click Me to Smooth Scroll to Section 1 Above</a>
</div>

<div class="container">
  <div class="row">
  </div>
  <div class="row">
    <div class="col-md-5">

    </div>
    <div class="col-md-4">
      <button type="button" class ="btn btn-outline-dark btn-lg" name="findmarket" onclick="location.href='store.php?storeid=1'">매장 보기</button>
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
