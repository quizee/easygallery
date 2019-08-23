<script type="text/javascript">
  function alertLogin(){
  alert("로그인 후 이용가능합니다.");
  }
</script>
<?php
    if(!isset($_SESSION['email'])) {//아직 로그인상태가 아닐 때
        echo '<div class="header bg-dark py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-5">
                <a href="#" class="text-white">Easy Gallery</a>
              </div>
              <div class="col-md-7 text-right">
                <ul class="nav text-white">
                  <li class="nav-item">
                    <a class="nav-link text-white" href="#LoginModal" data-toggle="modal">로그인</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="#RegisterModal" data-toggle="modal">회원가입</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="baskettest.php">장바구니</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="javascript:alertLogin();">마이컬렉션</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="javascript:alertLogin();">주문조회</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>';
    } else {//로그인 했을 때
        echo '<div class="header bg-dark py-5">
          <div class="container">
            <div class="row">
              <div class="col-md-5">
                <a href="#" class="text-white">Easy Gallery</a>
              </div>
              <div class="col-md-7 text-right">
                <ul class="nav text-white">
                  <li class="nav-item">
                    <a class="nav-link text-white" href="logout.php">로그아웃</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="myinfo.php">내정보</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="baskettest.php">장바구니</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="mycollection.php">마이컬렉션</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link text-white" href="orderlist.php?page=0">주문조회</a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>';
    }
?>

  <!-- Modal for register -->
  <div class="modal fade" id="RegisterModal" tabindex="-1" role="dialog" aria-labelledby="회원가입" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <div class="container">
            <div class="row">
              <div class="col text-center">
                <h5 class="modal-title" id="LoginTitle">이지갤러리 회원가입</h5>
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
              <div class="">
                <p>
                  지금 이지갤러리에 회원으로 가입하시고 다양한 혜택을 누려보세요!<br>
                  1. 신작 출시 소식 및 프로모션 정보를 빠르게 접할 수 있습니다.<br>
                  2. 작품 구매시 사용하실 수 있는 적립금 및 할인쿠폰이 제공됩니다.
                </p>
              </div>
            </div>
          </div>
          <div class="container">
            <div class="row">
              <div class="col text-center">
                <button type="button" class="btn btn-lg btn-light" onclick="location.href='register.php';">이메일 간편 회원가입</button>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">

        </div>
      </div>
    </div>
  </div>

  <!-- Modal for login-->
  <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="로그인" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="LoginTitle">MEMBER LOGIN</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <form action="after_login.php" method="post">
            <div class="form-group">
              <label for="InputEmail">이메일</label>
              <input type="email" class="form-control" name="email" id="InputEmail" placeholder="이메일 입력(예-easygallery@co.kr)">
            </div>
            <div class="form-group">
              <label for="InputPassword">비밀번호</label>
              <input type="password" class="form-control" name="password" id="InputPassword" placeholder="비밀번호 입력(숫자,영문 조합 6자리 이상)">
            </div>
            <div class="container">
              <div class="row">
                <div class="col text-center">
                  <button type="button" id="login_submit" class="btn btn-outline-dark btn-lg">로그인</button>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn">아이디 찾기</button>
          <button type="button" class="btn">비밀번호 찾기</button>
        </div>
      </div>
    </div>
  </div>

  <script type="text/javascript">


  $(function(){
    $("#login_submit").click(function(){
      var userid =  $("#InputEmail").val();
      var userpwd = $("#InputPassword").val();
      var pathname = window.location.pathname;
      var path_id = pathname.substring(1,pathname.length-4);
      //console.log(userid);
      $.ajax({
          async: true,
          type : 'GET',
          data : {'email':  userid, 'password': userpwd, 'pathid' : path_id},
          url : "/after_login.php",
          dataType : "text",
          contentType: "application/json; charset=UTF-8",
          success : function(data) {
            if(data=="success"){
              // var setCookie = function setCookie(cookie_name, value, days) {
              // var exdate = new Date();
              // exdate.setDate(exdate.getDate() + days);
              // // 설정 일수만큼 현재시간에 만료값으로 지정
              //
              // var cookie_value = escape(value) + ((days == null) ? '' : ';    expires=' + exdate.toUTCString());
              // document.cookie = cookie_name + '=' + cookie_value;
              // };
              //  setCookie('cart_items_cookie', '', -1);
              window.location.reload();
              //console.log(userid);
            }else{
              alert(data);
            }
          },
          error : function(error) {
              alert("error : " + error);
          }
        });
    });
  });


  </script>



  <style>
    #easygall {
      width:300px;
      height:300px;
    }
  </style>

  <nav class="navbar navbar-expand-md navbar-light bg-light sticky-top" id="secondbar">
   <div class="container">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse top_menu" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
          <li class="nav-item" id="about">
            <a class="nav-link mr-4" href="about.php">소개</a>
          </li>
          <li class="nav-item" id="collection">
            <a class="nav-link mr-4" href="collection.php">컬렉션</a>
          </li>
          <li class="nav-item" id="consult">
            <a class="nav-link mr-4" href="consult.php">아티스트</a>
          </li>
          <li class="nav-item" id="review">
            <a class="nav-link mr-4" href="totalreview.php">리뷰</a>
          </li>
        </ul>
        <form class="form-inline ml-5 my-2 my-lg-0">
          <input class="form-control mr-sm-2" type="search" placeholder="작가 및 작품명 검색" aria-label="Search">
          <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">검색</button>
        </form>
      </div>
 </div>
  </nav>
  <script type="text/javascript">
  var pathname = window.location.pathname;
  var path_id = pathname.substring(1,pathname.length-4);
  document.getElementById(path_id).classList.add('active');
  //$("a[href="+pathname.substring(1)+"]").closest('li').addClass('active');
  </script>
