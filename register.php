<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">

  <script>

var check = function() {
  if (document.getElementById('pwd_id').value ==
    document.getElementById('pwd_confirm_id').value) {
    document.getElementById('message').style.color = 'green';
    document.getElementById('message').innerHTML = '일치';
  } else {
    document.getElementById('message').style.color = 'red';
    document.getElementById('message').innerHTML = '불일치';
  }
}

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
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>회원가입</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js" ></script>
  <?php include ('header.php');?>
</head>

<body onload="noBack();" onpageshow="if(event.persisted) noBack();" onunload="">
<!--여기부터 회원가입 폼 시작 -->
  <div class="container">
    <div class="row">
      <div class="col text-center">
        <br>
        <h2>이지 갤러리 회원가입</h2>
        <br>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  //아이디 체크여부 확인 (아이디 중복일 경우 = 0 , 중복이 아닐경우 = 1 )
  var idck = 0;
  $(function() {
    //idck 버튼을 클릭했을 때
    $("#idck").click(function() {
        //userid 를 param.
        idck = 0;
        var userid =  $("#email_id").val();
        //var pass_data = {'email': $("#email_id").val()};
        if(userid==""){
            alert("아이디를 입력해주세요.");
        }else{

          $.ajax({
              async: true,
              type : 'GET',
              data : {'email':  userid},
              url : "/idcheck.php",
              dataType : "html",
              contentType: "application/json; charset=UTF-8",
              success : function(data) {
                //alert(data);
                console.log("id : " + data)
                  if (data=="exist") {
                      alert("아이디가 존재합니다. 다른 아이디를 입력해주세요.");
                      $("#email_id").focus();
                  } else if (data=="ok"){
                      alert("사용가능한 아이디입니다.");
                      $("#pwd_id").focus();
                      //아이디가 중복하지 않으면  idck = 1
                      idck = 1;
                  }
              },
              error : function(error) {
                  alert("error : " + error);
              }
            });
        }
        });
      });

      // Disable form submissions if there are invalid fields
      (function() {
        'use strict';
        window.addEventListener('load', function() {
          // Get the forms we want to add validation styles to
          var forms = document.getElementsByClassName('needs-validation');
          // Loop over them and prevent submission
          var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
              if (form.checkValidity() === false || idck == 0) {
                event.preventDefault();
                //submit cancel
                event.stopPropagation();
                if(idck == 0){
                  alert("이메일 중복체크를 해주세요");
                }
              }
              form.classList.add('was-validated');
            }, false);
          });
        }, false);
      })();

    window.history.forward();
	  function noBack() {
			window.history.forward();
		}

// $('#frm').submit(function(e){
//   $('#messages').removeclass('hide').addClass('alert alert-success alert-dismissible').slideDown().show();
//   $('#messages_content').html('<h4>가입을 축하합니다!</h4>');
//   $('#modal').modal('show');
//   e.preventDefault();
// });
      // $(function(){
      //   $("#submit_btn").click(function(){
      //     if(idck==0){
      //       alert("이메일 중복체크를 해주세요");
      //     }else{
      //       alert("가입을 축하합니다!")
      //       $("#frm").submit();
      //       location.replace("about.php");
      //     }
      //   });
      // });



</script>

  <div class="container">
    <!-- <div id="messages" class="hide" role="alert">
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          <div id="messages_content"></div>
    </div> -->
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <!-- <form method="post" id="frm" name="frm" action="<?php //echo $SERVER['PHP_SELF'];?>" class="needs-validated"> -->
          <form method="post" id="frm" name="frm" action="welcome.php" class="needs-validated">
          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" id="email_id" placeholder="이메일 입력(예-eg@gallery.com)" name="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required>
              <span class="input-group-btn">
                <button type="button" class="btn btn-dark" id="idck">중복 확인</button>
              </span>
            </div>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">잘못된 형식입니다.</div>
          </div>

          <div class="form-group">
            <input type="password" class="form-control" onkeyup='check();' id="pwd_id" placeholder="비밀번호 입력(숫자,영문 조합 6자리 이상)" name="pwd" pattern = "^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{6,}$" required>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">잘못된 형식입니다.</div>
          </div>
          <div class="form-group">
            <div class="input-group">
            <input type="password" class="form-control" onkeyup='check();' id="pwd_confirm_id" placeholder="비밀번호 확인" name="pwd_confirm" required>
            <div class="input-group-append">
            <span class = "input-group-text" id="message"></span>
            </div>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">이 항목을 필수로 입력해주십시오.</div>
            </div>
          </div>

          <div class="form-group">
            <input type="text" class="form-control" id="name_id" placeholder="이름" name="name" required>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">이 항목을 필수로 입력해주십시오.</div>
          </div>

          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" onkeypress="validate(event)" id="phone1_id" name="phone1" value="010" required>
              <div class="input-group-prepend">
                <span class="input-group-text"> - </span>
              </div>
              <input type="text" class="form-control" id="phone2_id" onkeypress="validate(event)" name="phone2" required>
              <div class="input-group-prepend">
                <span class="input-group-text"> - </span>
              </div>
              <input type="text" class="form-control" id="phone3_id" onkeypress="validate(event)" name="phone3" required>
              <div class="valid-feedback"></div>
              <div class="invalid-feedback">이 항목을 필수로 입력해주십시오.</div>
            </div>
          </div>

          <div class="form-group form-inline">
            <div class="container">
              <div id="input_mail" class="row">
                <div class="pl-2">
                <label for="input_mail">정보메일 수신:</label>
                </div>
                <div class="col-md-4 ">
                  <label class="radio-inline pl-4">
                    <input name="mail_type" id="input_yes_mail" value="yes" type="radio" required>예
                  </label>
                </div>
                <div class="col-md-4 pl-5">
                  <label class="radio-inline">
                    <input name="mail_type" id="input_no_mail" value="no" type="radio" required>아니오
                  </label>
                </div>
              </div>
            </div>
          </div>

          <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
          <script>
          //load함수를 이용하여 core스크립트의 로딩이 완료된 후, 우편번호 서비스를 실행합니다.
          function execPostCode() {
          //alert("post post");
            new daum.Postcode({
            oncomplete: function(data) {
              // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

              // 각 주소의 노출 규칙에 따라 주소를 조합한다.
              // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
              var addr = ''; // 주소 변수
              var extraAddr = ''; // 참고항목 변수

              //사용자가 선택한 주소 타입에 따라 해당 주소 값을 가져온다.
              if (data.userSelectedType === 'R') { // 사용자가 도로명 주소를 선택했을 경우
                  addr = data.roadAddress;
              } else { // 사용자가 지번 주소를 선택했을 경우(J)
                  addr = data.jibunAddress;
              }
              // 우편번호와 주소 정보를 해당 필드에 넣는다.
              document.getElementById('post_id').value = data.zonecode;
              document.getElementById("addr").value = addr;
              // 커서를 상세주소 필드로 이동한다.
              document.getElementById("detail_addr").focus();
            }
          }).open();
        }
        </script>

          <div class="form-group">
            <div class="input-group">
              <input type="text" class="form-control" onkeypress= "validate(event)" id="post_id" name="post_num" readonly required>
              <span class="input-group-btn">
                <button type="button" class="btn btn-dark" onclick="execPostCode();">우편번호 검색</button>
              </span>
            </div>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">이 항목을 필수로 입력해주십시오.</div>
          </div>

          <div class="form-group">
            <input type="text" class="form-control mb-2" name="address" id="addr" placeholder="주소" readonly required>
            <input type="text" class="form-control" name="detail_address" id="detail_addr" placeholder="나머지 상세주소" required>
            <div class="valid-feedback"></div>
            <div class="invalid-feedback">이 항목을 필수로 입력해주십시오.</div>
          </div>

          <div class="form-group form-check">
            <label class="form-check-label">
              <input class="form-check-input" type="checkbox" name="agree" id="agreement" required> 개인정보취급방침 및 이용약관에 동의
              <div class="valid-feedback"></div>
              <div class="invalid-feedback">약관에 동의해주세요.</div>
            </label>
          </div>
          <div class="text-center mb-4">
            <button type="submit" id="submit_btn" class="btn btn-dark float-">회원가입</button>
          </div>
        </form>
      </div>
      <div class="col-md-3"></div>
    </div>
  </div>

<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>


</body>

</html>
