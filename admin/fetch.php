<?php
//echo "okfetch";
 $servername = "localhost";
 $username = "root";
 $password = "1234";
 // Create connection
 $conn = mysqli_connect($servername, $username, $password,"my_db");
// // Check connection
 if (!$conn) {
   die("Connection failed: " . mysqli_connect_error());
 }
 $output = '';
 $sql = "select * from artists where artist_name like '%".$_GET["search"]."%'";
 //$sql = "select * from artists;";
 $result = mysqli_query($conn,$sql);
 mysqli_store_result($conn);
//
 if(mysqli_num_rows($result)>0){
   //$row = mysqli_fetch_assoc($result);
   //echo "<h1>".$row["name"]."</h1>";
   $output .='<div class="table-responsive">
       <table class="table table-bordered">
         <tr>
           <th></th>
           <th>작가명</th>
           <th>선택</th>
         </tr>';
  while($row = mysqli_fetch_assoc($result)){
    $output .='
      <tr>
      <td><img src="../database/artists/'.$row["artist_photo"].'" alt="picture1" border=3 height=50 width=50 class="rounded-circle"></img></td>
      <td>'.$row["artist_name"].'</td>
      <td><button type="button" onclick= "writeArtistId(\''.$row["artist_id"].'\', \''.$row["artist_name"]. '\')"class= "btn btn-light" name="button">선택</button></td>
      </tr>
      ';
  }
   echo $output;

}

 ?>
