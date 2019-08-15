<?php
session_start();

$writer_id = $_SESSION['email'];

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

$review_id = $_GET['review_id'];
$writer_name = $_GET['writer_name'];
$comment_text = $_GET['comment_text'];
$grp = $_GET['grp'];//바로 상위 댓글의 그룹
$seq = $_GET['seq'];//바로 상위 댓글의 내부 순서
$depth = $_GET['depth'];//바로 상위 댓글의 깊이

$my_grp = $grp;
$my_seq = (int)$seq + 1;
$my_depth = (int)$depth +1;

//$seq보다 큰애들은 1씩 증가시킨다.
$seq_sql = "update comments set seq = seq+1 where grp=$grp and seq>$seq;";
mysqli_query($conn,$seq_sql);

//review_id comment_id writer_id writer_name comment_text depth grp seq
$make_com = "insert into comments (review_id, writer_id, writer_name, comment_text, depth, grp, seq)
  values ('$review_id','$writer_id','$writer_name','$comment_text',$my_depth, $my_grp, $my_seq);";
mysqli_query($conn,$make_com);
//새로 생긴 대댓글을 넣었다.

//새로 넣은 댓글을 포함하는 전체 댓글을 다시 불러온다.
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
