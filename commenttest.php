<!DOCTYPE html>
<?php session_start();
//$_SESSION['email']='kkk@naver.com';
//이부분은 로그인했다치고 다른 이메일을 넣어보자
$writer_id = $_SESSION['email'];
$review_id = "1";
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

<script>

</script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  <?php include ('header.php');?>
</head>

<body>
  <style>
    .modify{
      color:blue;
      cursor: pointer;
    }
    .delete{
      color:#8B0000;
      cursor: pointer;
    }
  </style>

<!--여기부터 시작 -->
 <div class="container" id="comment_div">
   <script>
   //대댓을 달기 위한 버튼
   var cmt_child = function(element){
     var id = $(element).data('id');
     var depth = $(element).data('depth');
     var grp = $(element).data('grp');
     var seq = $(element).data('seq');
     var content = $('#com_com_text').val();
     var review_id = '<?php echo $review_id;?>';
     var writer_name = '<?php echo $writer_name;?>';
     //alert(id);

     $.ajax({
         async: true,
         type : 'GET',
         data : {'review_id':  review_id, 'writer_name' : writer_name, 'comment_text' : content, 'grp' : grp, 'seq' : seq, 'depth':depth},
         url : "/comcom.php",
         dataType : "text",
         contentType: "application/json; charset=UTF-8",
         success : function(data) {
           //$('#comcom_textarea').remove();
           //대댓창을 없앤다.
           $('#comment_div').html('');//일단 비우고
           //새로 뿌려준다.
           $('#comment_div').html(data);
           $('#comment_text').val('');
           //alert(data);

         },
         error : function(error) {
             console.log("error : " + error);
         }
       });
   };
     var del_comment = function(element){
       var comment_id = $(element).data('id');
       var review_id = '<?php echo $review_id;?>';
       $.ajax({
           async: true,
           type : 'GET',
           data : {'comment_id':comment_id, 'review_id': review_id},
           url : "/delcomment.php",
           dataType : "text",
           contentType: "application/json; charset=UTF-8",
           success : function(data) {
             //$('#comcom_textarea').remove();
             //대댓창을 없앤다.
             $('#comment_div').html('');//일단 비우고
             //새로 뿌려준다.
             $('#comment_div').html(data);
             $('#comment_text').val('');
             //alert(data);

           },
           error : function(error) {
               console.log("error : " + error);
           }
         });
     };
     var mod_complete = function(element){
       //수정완료 버튼을 눌렀을 때
       //수정된 내용으로 다시 뿌려준다.
       var comment_id = $(element).data('id');
       var modified_text = $(element).parent().prev().children().first().val();
       var review_id = '<?php echo $review_id;?>';
       //alert(modified_text);
       $.ajax({
           async: true,
           type : 'GET',
           data : {'comment_id':comment_id, 'comment_text': modified_text, 'review_id': review_id},
           url : "/modcomment.php",
           dataType : "text",
           contentType: "application/json; charset=UTF-8",
           success : function(data) {
             //대댓창을 없앤다.
             $('#comment_div').html('');//일단 비우고
             //새로 뿌려준다.
             $('#comment_div').html(data);
             $('#comment_text').val('');
             //alert(data);

           },
           error : function(error) {
               console.log("error : " + error);
           }
         });
     };

     var mod_comment = function(element){
       var comment_id = $(element).data('id');
       var review_id = '<?php echo $review_id;?>';
       //var depth = $(element).data('depth');
       var writer_name = '<?php echo $writer_name;?>';

       //그자리에 있었던 내용을 textarea에 담아야 한다.
       //grp seq depth 등은 건드리지 않고 딱 description만 건든다.
       var content_text = $(element).parent().prev().text().trim();

       var content = "";
       content += '<div class="col-md-3 text-center" id="whos_writing_child">';
       content += writer_name+'</div><div class="col-md-6"><textarea style="width:100%;" name="modify_text" rows="2" cols="30" id="modify_text">';
       content += content_text+'</textarea>';
       content += '</div><div class="col-md-3"><button type="button" data-id="'+comment_id+'" name="mod_complete_btn" id="mod_complete_btn"';
       content += 'class="btn" onclick="mod_complete(this)">수정완료</button></div>';
       var $div = $(content);
       $('div[id="'+comment_id+'"]').html('');
       //해당 댓글을 지우고 그자리에 textarea를 위치시킨다.
       $('div[id="'+comment_id+'"]').append($div);
     };

     //답글을 위한 textarea가 만들어진다.
     var reply_func = function(element){
       var id = $(element).data('id');
       var depth = $(element).data('depth');
       var grp = $(element).data('grp');
       var seq = $(element).data('seq');
       var my_depth = (Number(depth) +1)*12;
       var writer_name = '<?php echo $writer_name;?>';

       //부모보다 한칸 오른쪽으로 밀어난 input을 만든다.
       //그러기 위해서는 depth 라는 개념이 필요하다.
       var content = "";
       content += '<div class="row" id="comcom_textarea" style="margin-left:'+my_depth+'px;"><div class="col-md-3 text-center" id="whos_writing_child">';
       content += writer_name+'</div><div class="col-md-6"><textarea style="width:100%;" name="com_com_text" rows="2" cols="30" placeholder="대댓글 달기..." id="com_com_text"></textarea>';
       content += '</div><div class="col-md-3" ><button type="button" name="comment" id="comment_btn_child"';
       content += 'data-id="'+id+'" data-depth="'+depth+'" data-grp="'+grp+'" data-seq="'+seq+'" class="btn btn-info" onclick="cmt_child(this)">게시</button></div></div>';
       var $div = $(content);
       $('#comcom_textarea').remove();
       $div.insertAfter('div[id="'+id+'"]');
     };

   </script>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "1234";
    // Create connection
    $conn = mysqli_connect($servername, $username, $password,"my_db");
    $get_comment = "select * from comments where review_id='".$review_id."' order by grp asc, seq asc, depth desc;";
    //grp으로 먼저 정렬하고 grp이 같으면 seq로 정렬한다.
    $result = mysqli_query($conn,$get_comment);
    mysqli_store_result($conn);
    if(mysqli_num_rows($result)>0){
      while($row = mysqli_fetch_assoc($result)){
        //review_id, comment_id, writer_id, writer_name, comment_text, parent_comment, depth, grp, seq
        $my_depth = $row['depth']*16;
        if($my_depth != 0){
          $arrow = "ㄴ";
        }else{
          $arrow = "";
        }
        $output = "";
        if($row['writer_name']=="" && $row['comment_text']==""){//삭제된 댓글일 경우
          $output .= '<div class="row mb-2" id="'.$row['comment_id'].'" style="margin-left:'.$my_depth.'px;">
          <div class="col-md-3 text-center">
          </div>
              <div class="col-md-8">
                -- 삭제된 댓글입니다. -- </div>
              <div class="col-md-4"></div></div>';
        }else{
          $output .= '<div class="row mb-2" id="'.$row['comment_id'].'" style="margin-left:'.$my_depth.'px;">
              <div class="col-md-3 text-center">
                '.$arrow." ".$row['writer_name'].'
              </div>
              <div class="col-md-6">
                '.$row['comment_text'].'
              </div>
              <div class="col-md-3">
                <span class="reply" onclick="reply_func(this)" data-id="'.$row['comment_id'].'" data-depth = "'.$row['depth'].'" data-grp="'.$row['grp'].'" data-seq="'.$row['seq'].'">답글달기</span>';
                //답글달기라는 span에 자식 답글을 위한 정보들이 담겨있다.
                //id는 이 태그를 접근하기 위한 정보
                //depth, grp, seq: 그 자식 답글이 부모 댓글부터 depth가 하나더 깊어야하고, grp이 그 부모와 같아야하고, seq가 부모보다 하나더 커야
          if($row['writer_id']==$_SESSION['email']){
            $output .= '<span class="ml-1 modify" data-id="'.$row['comment_id'].'" onclick="mod_comment(this)">수정</span>
            <span class="ml-1 delete" data-id="'.$row['comment_id'].'" onclick="del_comment(this)">삭제</span>';
          }
          $output .= '</div></div>';
        }
        echo $output;
      }
    }
   ?>
</div>
<div class="container">
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
<script type="text/javascript">

//원 댓글을 달기 위한 버튼
  $('#comment').click(function(){
    //원댓글이라면 grp 만 늘어나고 seq는 무조건 1, depth는 무조건 0
    //마지막 grp을 가져와서 +1한 댓글을 형성하는게 관건
    var review_id = '<?php echo $review_id;?>';
    var writer_name = '<?php echo $writer_name;?>';
    var comment_text = $('#comment_text').val();

    $.ajax({
        async: true,
        type : 'GET',
        data : {'review_id':  review_id, 'writer_name' : writer_name, 'comment_text' : comment_text},
        url : "/originalcom.php",
        dataType : "text",
        contentType: "application/json; charset=UTF-8",
        success : function(data) {
          $('#comment_div').html('');//일단 비우고
          //새로 뿌려준다.
          $('#comment_div').html(data);
          $('#comment_text').val('');
          //alert(data);
        },
        error : function(error) {
            console.log("error : " + error);
        }
      });
    });


</script>

<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
