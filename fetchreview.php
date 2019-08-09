<?php
$index = $_GET['index'];
$art_id = $_GET['art_id'];
$one_page = $_GET['one_page'];
$start = $index * $one_page;

$servername = "localhost";
$username = "root";
$password = "1234";
// Create connection
$conn = mysqli_connect($servername, $username, $password,"my_db");
$conn2 = mysqli_connect($servername, $username, $password,"user_db");

$review_sql = "select * from reviews where product_id='$art_id' limit $start, $one_page;";
$review_result = mysqli_query($conn,$review_sql);
mysqli_store_result($conn);
echo '<input type="hidden" name="review_page" id="review_page" value="'.$index.'">';

if(mysqli_num_rows($review_result)>0){
  while($row = mysqli_fetch_assoc($review_result)){//리뷰하나마다 사용자 이름도 가져와야함
    $writer_email = $row['user_id'];
    $get_writer = "select name from user_info where email = '$writer_email';";
    $writer_result = mysqli_query($conn2,$get_writer);
    mysqli_store_result($conn2);
    $writer_row = mysqli_fetch_assoc($writer_result);
    $writer_name = $writer_row['name'];
    $review_photo = $row['photo'];
    $review_text = $row['text'];
    // if(strlen($review_text)>33){
    //   $show_text = substr($review_text,0,33)."...";
    // }else{
    //   $show_text = $review_text;
    // }
    $review_like = $row['like_review'];
    $review_id = $row['order_id'];

    echo '<div class="col-md-3">
        <div class="card" data-id="'.$review_id.'" data-text="'.$review_text.'" data-photo="'.$review_photo.'" data-writer="'.$writer_name.'">
          <img class="card-img" src="./database/asset/'.$review_photo.'" alt="">
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
  }
}

?>
