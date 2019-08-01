<?php
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"user_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

?>


<style>
  .scrollable{
    height: 400px;
    overflow: scroll;
  }
</style>

<!-- Search form -->

<!--Navbar-->
<nav class="navbar navbar-expand-lg navbar-dark blue lighten-2 mb-4">

  <!-- Collapsible content -->
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <form class="form-inline mr-auto mt-2" id="frm" method="get" action="">
      <i class="fa fa-search mr-4"></i>
      <input class="form-control" id="search_word" type="text" name="search_word" placeholder="회원명 검색" aria-label="Search">
      <button class="btn btn-light" type="submit">검색</button>
      <!-- <button type="button" name="button"></button> -->
    </form>
  </div>
  <!-- Collapsible content -->
</nav>
<!--/.Navbar-->

<div class="scrollable">
<table class="table table-bordered table-hover">
  <thead>
  <tr>
    <th>No</th>
    <th>이름</th>
    <th>이메일</th>
    <th>연락처</th>
    <th>우편번호</th>
    <th>주소</th>
    <th>비고</th>
  </tr>
  </thead>
  <tbody>
    <?php
    $num = 0;
    //echo "<script>document.getElementById('search_word').value= ".$_REQUEST["search_word"] .";</script>";
    if(empty($_REQUEST["search_word"])){//아직 검색한 것이 없는 경우
      $sql = "SELECT * FROM user_info;";
    }else{
      $search_word =$_REQUEST["search_word"];
      $sql = "
          SELECT *
          FROM user_info
          WHERE name LIKE '%{$search_word}%'
          ";
    }

    $user_query = mysqli_query($conn, $sql);
    mysqli_store_result($conn);

    if (mysqli_num_rows($user_query) > 0) {
      //id, address, name, phone_num, op_time
      while($row = mysqli_fetch_assoc($user_query)){
        $num = $num+1;
        $name = $row["name"];
        $email = $row["email"];
        $phone_num = $row["phone_num"];
        $post_num = $row["post_num"];
        $address = $row["address"];
        $mail_accept = $row["mail_accept"];
        echo "<form method='post' id='frm' name='frm' action='mail.php'>";
        if($mail_accept=="no"){
          echo "
            <tr>
              <td>".$num."</td>
              <td>".$name."</td>
              <td>".$email."</td>
              <td>".$phone_num."</td>
              <td>".$post_num."</td>
              <td>".$address."</td>
              <td><button>수정</button> <button>삭제</button> </td>
            </tr>";
        }else{
          echo "
            <tr>
              <td>".$num."</td>
              <td>".$name."</td>
              <td>".$email."</td>
              <td>".$phone_num."</td>
              <td>".$post_num."</td>
              <td>".$address."</td>
              <td><button>수정</button> <button>삭제</button> <input type='checkbox' class='ml-3' name=" . $email . " id=" . $email . " required>메일 전송
            </tr>";
        }
      }
      echo "</form>";
    }else{
      echo "<script>alert('일치하는 회원명이 없습니다.');</script>";
    }
    ?>
  </tbody>
</table>
</div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-10">

    </div>
  <div class="col-md-1 text-right">
    <button type="button" name="mail_send">선택목록 메일전송</button>
  </div>
  <div class="col-md-1 text-left">
    <button type="button" name="select_all">전체 선택</button>
  </div>
    </div>
</div>
