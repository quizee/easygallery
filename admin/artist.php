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
<script type="text/javascript">



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
          <input class="form-control" id="search_art" type="text" name="search_art" placeholder="작가 검색" aria-label="Search">
          <button class="btn btn-light" type="submit">검색</button>
          <!-- <button type="button" name="button"></button> -->
        </form>
      </div>
      <!-- Collapsible content -->
    </nav>
    <!--/.Navbar-->

    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="회원가입" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">

          <div class="modal-body">
            <div class="container">
              <div class="row">
                <div class="col-md-12 text-center">
                  <h5>
                    해당 작가를 삭제하시겠습니까?
                  </h5>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12">
                  <input type="hidden" name="ArtId" id="ArtId" value=""/>
                  <br>
                </div>
              </div>
            </div>
            <script type="text/javascript">
            function stay(){
              $('#deleteModal').modal('hide');
            }
            </script>
            <script type="text/javascript">
            function del(){
              var deleteId = $("#ArtId").val();
              alert('등록된 작가의 정보가 삭제되었습니다.')
              window.location.href = "/admin/artist.php?delete="+deleteId;
            }
            </script>

            <div class="container">
              <div class="row">
                <div class="col-md-12 text-center">
                  <button type="button" class="btn btn-sm btn-light ml-3 mr-1" onclick="del();">예</button>
                  <button type="button" class="btn btn-sm btn-light" onclick="stay();">아니오</button>
                </div>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="scrollable">
    <table class="table table-bordered table-hover">
      <thead>
      <tr>
        <th>No</th>
        <!-- <th>등록일</th> -->
        <th>작가명</th>
        <th>작가 프로필</th>
        <th>비고</th>
      </tr>
      </thead>
      <tbody>

        <?php
        $num = 0;
        if(!empty($_REQUEST["delete"])){
          $sql = "DELETE FROM artists where artist_id='".$_REQUEST['delete']."';";
          mysqli_query($conn, $sql);
        }//삭제한게 있는 경우 그것부터 처리한다.
        //echo "<script>document.getElementById('search_word').value= ".$_REQUEST["search_word"] .";</script>";
        if(empty($_REQUEST["search_art"])){//아직 검색한 것이 없는 경우
          $sql = "SELECT * FROM artists;";

        }else{
          $search_word =$_REQUEST["search_art"];
          $sql = "
              SELECT *
              FROM artists
              WHERE artist_name LIKE '%{$search_word}%'
              ";
        }


        $user_query = mysqli_query($conn, $sql);
        mysqli_store_result($conn);

        if (mysqli_num_rows($user_query) > 0) {
          //id, address, name, phone_num, op_time
          while($row = mysqli_fetch_assoc($user_query)){
            $num = $num+1;
            $name = $row["artist_name"];
            $id = $row['artist_id'];
            //$date = date('Y-m-d',$row["id"]);
            $profile = $row['artist_photo'];
            echo '
              <tr>
                <td>' .$num. '</td>
                <td>'.$name.'</td>
                <td><img src="../database/artists/'.$profile.'" alt="picture1" border=3 height=50 width=50 class="rounded-circle"></img></td>
                <td><button data-id="'.$id.'" class = "btn btn-light edit-art">수정</button> <button data-id="'.$id.'" data-toggle="modal" class = "btn btn-light open-deleteDialog" data-target="#deleteModal">삭제</button></td>
              </tr>';
          }
        }else{
          echo "<script>alert('검색어와 일치하는 작가명이 없습니다.');</script>";
        }
        ?>
      </tbody>
    </table>
    </div>
    <div class="container">
      <div class="col text-center">
      <a href="/admin/addartist.php">
      <button type="button" class= "btn btn-light" name="select_all" onclick="location.href('/admin/addartist.php')">신규 작가 등록하기</button>
      </a>
      </div>
    </div>

</div>
</div>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
<script type="text/javascript">
$(document).on("click", ".open-deleteDialog", function () {
   var myArtId = $(this).data('id');
   $("#ArtId").val( myArtId );
});

$(document).on("click",".edit-art",function(){
  var artId = $(this).data('id');
  location.href = "editartist.php?artistid="+artId;
});

</script>

</html>
