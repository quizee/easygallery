<?php
$review_id = $_GET['review_id'];

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");

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
    $comment_depth = $row['depth'];
    array_push($comment_items,array(
      'comment_id'=>$comment_id,
      'writer_name'=>$writer_name,
      'comment_text'=>$comment_text,
      'parent_comment'=>$parent_comment,
      'comment_depth'=>$comment_depth
    ));
  }
}
echo json_encode($comment_items);
 ?>
