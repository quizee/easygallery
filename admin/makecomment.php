<?php
$review_id = $_GET['review_id'];
$whos_writing = $_GET['whos_writing'];
$comment_text = $_GET['comment_text'];
//관리자 버전이 아닐 때는 writer id 를 세션으로 확인하면 된다.
$parent_comment = $_GET['parent_comment'];//빈 항목이라면 대댓이 아닌경우

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

if($parent_comment == ""){//대댓이 아닌경우
  $parent_comment = NULL;//null 처리를 해준다.
  $comment_depth = 0;//깊이는 0 으로 처리한다.
}else{//대댓인 경우
  //부모 코멘트의 깊이를 가져와서 그보다 하나 깊어야 함.
  $get_parent_depth = "select depth from comments where comment_id = '$parent_comment';";
  $parent_depth_result = mysqli_query($conn,$get_parent_depth);
  mysqli_store_result($conn);
  $row = mysqli_fetch_assoc($parent_depth_result);
  $parent_depth = $row['depth'];
  $comment_depth = (int)$parent_depth + 1;
}
//깊이와 부모 코멘트가 확보되었다. 이를 바탕으로 삽입한다.

//일단 삽입하는 부분
$sql = "insert into comments (review_id, writer_id, writer_name, comment_text, parent_comment, depth) values ('$review_id', 'admin' ,'$whos_writing','$comment_text','$parent_comment','$comment_depth');";
mysqli_query($conn,$sql);

//삽입한 결과를 다시 가져오는 부분
$sql = "select * from comments where review_id='".$review_id."' order by comment_id;";
$result = mysqli_query($conn,$sql);
mysqli_store_result($conn);
$comment_items = array();
if(mysqli_num_rows($result)>0){//댓글이 한개 이상 있는 경우
  //댓글 row 자체를 배열로 만들어서 보낸다.
  while ($row= mysqli_fetch_assoc($result)) {
    $comment_id = $row['comment_id'];
    $writer_name = $row['writer_name'];
    $parent_comment = $row['partent_comment'];
    $comment_text = $row['comment_text'];
    $depth = $row['depth'];
    array_push($comment_items,array(
      'comment_id'=>$comment_id,
      'writer_name'=>$writer_name,
      'comment_text'=>$comment_text,
      'parent_comment'=>$parent_comment,
      'comment_depth'=>$depth
    ));
  }
}
echo json_encode($comment_items);
?>
