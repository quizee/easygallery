<!DOCTYPE html>
<?php session_start();
//로그인할때마다 다른 사람이름으로 바뀐다.
$writer_id = $_SESSION['email'];
//어떤 리뷰 게시물에 들어왔다고 가정하자.
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn2 = mysqli_connect($servername, $username, $password,"user_db");
$get_name = "select name from user_info where email = '".$_SESSION['email']."';";
$result = mysqli_query($conn2,$get_name);
mysqli_store_result($conn2);
$row = mysqli_fetch_assoc($result);
$writer_name = $row['name'];//위의 이메일에 따라 글쓴이 이름을 미리 마련해놓는다.
 ?>

<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">

  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <?php include ('header.php');?>
</head>

<body>
<!--여기부터 시작 -->
<div class="container-fluid">
  <div class="row">
    <div class="col-md-12">
      <h3>다른 회원님들의 감각을 참고해보세요</h3>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <br>
    </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <form action="" id="order_search_frm" method="get">
      <table class = "table">
        <tr>
          <th>상품명</th>
          <td> <input type="text" name="product_search" value="" placeholder="상품명으로 검색">
            <button type="button" name="button" class="btn btn-dark" id="search_order" style="margin-left:400px;">조회하기</button> </td>
        </tr>
      </table>
      </form>
    </div>
  </div>
</div>
<script type="text/javascript">
var comment_num = 0;//전역변수

var cmt_child = function(){//대댓글을 달 때 동일하게 makecomment 로 넘어간다.

  var whos_writing = $('#whos_writing_child').text().trim();//작성자의 이름
  var comment_text = $('#comment_text_child').val();//작성 내용
  var review_id = $('#review_id_modal').val();//댓글을 달려는 게시물
  var parent_comment = $('#parent_comment').val();// 대댓이라면 이 input의 값을 가져온다.
  var content ="";

  //대댓을 달고 나서 디비의 변화를 보여주는 ajax
  //문제 3
  $.ajax({
      async: true,
      type : 'GET',
      data : {'review_id':  review_id, 'whos_writing':whos_writing, 'comment_text':comment_text, 'parent_comment':parent_comment},
      url : "/admin/makecomment.php",
      dataType : "text",
      contentType: "application/json; charset=UTF-8",
      success : function(data) {
        //디비에 있는 것을 보여주도록 한다.
        $('#child_comment').html('');//댓글 달기 textarea를 없앤다
        $('#comment_content').html('');//댓글 전부를 불러오는 div를 비운다.
        content = "";
        var comment_list = JSON.parse(data);
        for(var i = 0; i<comment_list.length; i++){

          if(!comment_list[i].parent_comment){//부모 코멘트가 비어있는 경우
            //대댓이 아닌 경우 이므로 그냥 요소를 더한다.
            content += '<div id="'+comment_list[i].comment_id+'"><div class="row"><div class="col-md-3 text-center">';
            content += comment_list[i].writer_name+'</div><div class="col-md-6">'+comment_list[i].comment_text+'</div>';
            content += '<div class="col-md-3 reply" name="reply" data-parent="'+comment_list[i].comment_id+'" data-writer="'+comment_list[i].writer_name+'" onclick="reply_func(this);">답글달기</div></div></div><br>';
            //하나의 댓글 요소가 완성됨
            var $div = $(content);

            $('#comment_content').append($div);
          }else{//부모 코멘트가 비어있지 않은 경우 부모 아래 append 한다.
            var my_depth = parseInt(comment_list[i].comment_depth)*10;
            content += '<div id="'+comment_list[i].comment_id+'" style="margin-left:'+my_depth+'px;><div class="row"><div class="col-md-3 text-center">';
            content += 'ㄴ '+comment_list[i].writer_name+'</div><div class="col-md-6">'+comment_list[i].comment_text+'</div>';
            content += '<div class="col-md-3 reply" name="reply" data-parent="'+comment_list[i].comment_id+'" data-writer="'+comment_list[i].writer_name+'" onclick="reply_func(this);">답글달기</div></div></div><br>';
            //하나의 댓글 요소가 완성됨
            var $div = $(content);

            var parent_id = comment_list[i].parent_comment;
            $("[id='"+parent_id+"']").append($div);
          }
        }
        //$('#comment_content').html(content);
        comment_num = comment_list.length;
        //$('#comment_is').html(comment_num+"개의 댓글이 있습니다.");
        $('#comment_text').val('');
      },
      error : function(error) {
          console.log("error : " + error);
      }
    });
};

var reply_func = function(element){
  //답글달기 버튼에 해당 댓글 아이디와 글쓴이 데이터가 담겨져 있다.
  var parent_comment = $(element).data('parent');
  var writer = $(element).data('writer');
  var content = "";

  $('#parent_comment').val(parent_comment);//대댓을 달려는 자신의 부모를 hidden input 에 넣는다.
  //부모보다 한칸 오른쪽으로 밀어난 input을 만든다.
  //그러기 위해서는 depth 라는 개념이 필요하다.

  //depth를 가져오기위한 ajax
  $.ajax({
      async: true,
      type : 'GET',
      data : {'parent_comment':parent_comment},
      url : "/admin/fetchdepth.php",
      dataType : "text",
      contentType: "application/json; charset=UTF-8",
      success : function(depth) {
        //부모의 depth를 가져온다.
        //(부모depth+1) * 10
        var my_depth = (parseInt(depth)+1)*10;
        content += '<div class="row" style="margin-left:'+my_depth+'px; id="child_comment""><div class="col-md-3 text-center">';
        content += 'ㄴ <span id="whos_writing_child">admin</span></div><div class="col-md-6"><textarea style="width:100%;" name="name" rows="2" cols="30" placeholder="대댓글 달기..." id="comment_text_child"></textarea>';
        content += '</div><div class="col-md-3" ><button type="button" name="comment" id="comment_btn_child" class="btn btn-info" onclick="cmt_child();">게시</button></div></div>';
        var $div = $(content);
        $("[id='"+parent_comment+"']").append($div);
      },
      error : function(error) {
          console.log("error : " + error);
      }
    });
};

//카드를 눌렀을 때 모달을 초기화시키는 부분
$(function(){
    var content = "";
    $('.card').click(function(){

      var review_id = $(this).data('id');//클릭한 리뷰 아이디
      var review_photo = $(this).data('photo');
      var review_text = $(this).data('text');
      var writer = $(this).data('writer');

      $('#whole_text').html("<br>"+review_text);//모달 텍스트 초기화
      $('#review_id_modal').val(review_id);//모달 아이디 초기화
      $('#whole_photo').attr('src',"../database/asset/"+review_photo);//모달 그림 초기화
      $('#lookBigTitle').html(writer+"님의 구매후기");

      //댓글을 불러온다.
      $.ajax({
          async: true,
          type : 'GET',
          data : {'review_id':  review_id},
          url : "/admin/fetchcomment.php",
          dataType : "text",
          contentType: "application/json; charset=UTF-8",
          success : function(data) {

            $('#comment_div').html('');//일단 비우고
            //새로 뿌려준다.
            $('#comment_div').html(data);
            $('#comment_text').val('');

            comment_num = $('#comment_div').children().length;

            $('#comment_is').html(comment_num+"개의 댓글이 있습니다.");
          },
          error : function(error) {
              console.log("error : " + error);
          }
        });

      $('#lookBigModal').modal('show');
    });

  //댓글을 하나 게시했을 때
    $('#comment_btn').click(function(){
      var whos_writing = $('#whos_writing').text().trim();//작성자의 이름
      var comment_text = $('#comment_text').val();//작성 내용
      var review_id = $('#review_id_modal').val();//댓글을 달려는 게시물
      var parent_comment = "";// 대댓이라면 이 input의 값을 가져온다.
      //alert(comment_text);
      //문제 2
      $.ajax({
          async: true,
          type : 'GET',
          data : {'review_id':  review_id, 'whos_writing':whos_writing, 'comment_text':comment_text, 'parent_comment':parent_comment},
          url : "/admin/makecomment.php",
          dataType : "text",
          contentType: "application/json; charset=UTF-8",
          success : function(data) {
            //디비에 있는 것을 보여주도록 한다.
            $('#comment_content').html('');
            content = "";
            var comment_list = JSON.parse(data);
            for(var i = 0; i<comment_list.length; i++){
              content += '<div id="'+comment_list[i].comment_id+'"><div class="row"><div class="col-md-3 text-center">';
              content += comment_list[i].writer_name+'</div><div class="col-md-6">'+comment_list[i].comment_text+'</div>';
              content += '<div class="col-md-3 reply" name="reply" data-parent="'+comment_list[i].comment_id+'" data-writer="'+comment_list[i].writer_name+'" onclick="reply_func(this);">답글달기</div></div></div><br>';
            }
            //댓글 하나마다 이걸 뿌려줘야함
            $('#comment_content').html(content);
            comment_num = comment_list.length;
            //$('#comment_is').html(comment_num+"개의 댓글이 있습니다.");
            $('#comment_text').val('');
          },
          error : function(error) {
              console.log("error : " + error);
          }
        });
      });

    $('#comment_is').click(function(){
        if($(this).html()=="접기"){
          $('#admin-comment').collapse("hide");
          $(this).html(comment_num+'개의 댓글이 있습니다.');
        }else{
          $('#admin-comment').collapse("show");
          $(this).html('접기');
        }
    });
  });
</script>

<style>
.hidden_words {
  display: inline-block;
  width: 130px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.reply {
  color:gray;
  font-size: small;
  cursor: pointer;
}
</style>
<?php
$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
$conn2 = mysqli_connect($servername, $username, $password,"user_db");
$conn3 = mysqli_connect($servername, $username, $password,"my_db");
// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}
?>
<div class="card-deck">
  <div class="container" id="review_result">
    <input type="hidden" name="review_page" id="review_page" value="0">
    <div class="row">
    <?php
      //이 상품에 대한 리뷰를 가져오고 페이징
      $review_sql = "select * from reviews";
      $review_result = mysqli_query($conn,$review_sql);
      mysqli_store_result($conn);
      $on_one_page = 8;
      $btn_count = ceil(mysqli_num_rows($review_result)/$on_one_page);

      $review_sql .= " LIMIT 0, $on_one_page;";
      $review_result = mysqli_query($conn,$review_sql);
      mysqli_store_result($conn);
      $i = 0;

      if(mysqli_num_rows($review_result)>0){
        while($row = mysqli_fetch_assoc($review_result)){//리뷰하나마다 사용자 이름도 가져와야함
          $i ++;
          $writer_email = $row['user_id'];

          $get_writer = "select name from user_info where email = '$writer_email';";
          $writer_result = mysqli_query($conn2,$get_writer);
          mysqli_store_result($conn2);
          $writer_row = mysqli_fetch_assoc($writer_result);

          $writer_name = $writer_row['name'];
          $review_photo = $row['photo'];
          $review_text = $row['text'];
          $review_id = $row['order_id'];

          //이 리뷰에 댓글이 몇개인지 가져와야함
          $get_comment_count = "select count(*) as cnt from comments where review_id = '$review_id';";
          $comment_count_result = mysqli_query($conn3,$get_comment_count);
          mysqli_store_result($conn3);
          $count_row = mysqli_fetch_assoc($comment_count_result);
          $comment_count = $count_row['cnt'];

          $output = "";
          $output = '<div class="col-md-3">
              <div class="text-right pr-3">'.$comment_count.'개의 댓글</div>
              <div class="card" data-id="'.$review_id.'" data-text="'.$review_text.'" data-photo="'.$review_photo.'" data-writer="'.$writer_name.'">
                <img class="card-img" src="../database/asset/'.$review_photo.'" alt="">
                <div class="card-body">
                  <div class="container">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="hidden_words">'.$review_text.' </div><button type="button" name="button" class="btn" style="color:#0000FF; padding:0px;">자세히</button>
                      </div>
                    </div>
                  <div class="row">
                    <div class="col-md-12 text-right">
                      <small>'.$writer_name.'</small>
                    </div>
                  </div>
                  </div>
                </div>
              </div>
            </div>';

          if($i%4 == 0){//4번째라면 한 행을 닫고 새로운 행을 열어준다.
            $output .= '</div>
            <div class="row">
              <div class="col-md-12">
                <br>
              </div>
            </div>
            <div class="row">';
          }
          echo $output;
        }
      }
     ?>

      </div>
  </div>
</div>
<br><br>
<div class="container">
  <div class="row">
  <div class="col-md-12 text-center">
    <button type="button" data-id="previous" id="prev_btn" name="review_page" class="btn"> << </button>
    <?php
     for($i=0;$i<$btn_count;$i++){
       $y = $i+1;
       echo '<button type="button" id = "'.$i.'" data-id="'.$i.'" name="review_page" class="btn">'.$y.'</button>';
     }
    ?>
    <button type="button" data-id="next" id="next_btn" name="review_page" class="btn"> >> </button>
  </div>
  </div>
  <div class="row">
    <div class="col-md-12">
      <br><br>
    </div>
  </div>
</div>
<!-- 크게 보기 모달 -->
<div class="modal fade" id="lookBigModal" tabindex="-1" role="dialog" aria-labelledby="크게보기" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="lookBigTitle">누가 쓴 상품평</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="container">
          <img id="whole_photo" src="./database/asset/dummy.png" alt="" style="width:100%; height:500px;">
          <p id="whole_text">
            리얼엽떡 먹고싶음 ㅎㅎㅎㅎㅎㅎㅎ
          </p>
          <input type="hidden" name="review_id_modal" value="" id="review_id_modal">
        </div>
      </div>
      <div class="modal-footer">
        <div class="container">
          <div class="row">
            <div class="col-md-12">
              <button type="button" id="comment_is" class="btn" style="color:#800000;">1개의 댓글이 있습니다.</button>
              <br>
            </div>
          </div>
          <div class="row">
            <div id="admin-comment" class="collapse col-md-12">
              <div class="container" id="comment_div">

              </div>
              <div class="container" id="new_comment">
                <div class="row">
                  <table class="table">
                    <tr>
                      <td><?php echo $writer_name;?></td>
                      <td><textarea name="comment_text" id="comment_text" rows="3" cols="40"></textarea></td>
                      <td><button type="button" name="comment" id="comment">게시</button></td>
                    </tr>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
