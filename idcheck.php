<?php
//echo "<script>alert(\"idcheck\")</script>";
$id = $_GET['email'];
//echo $id;

$servername = "localhost";
$username = "root";
$password = "1234";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"user_db");

// Check connection
if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

$sql = "select count(*) from user_info where email='$id' ";

$user_query = mysqli_query($conn, $sql);
mysqli_store_result($conn);

if (mysqli_num_rows($user_query) > 0) {
  $data = mysqli_fetch_array($user_query);
}

//echo $sql;
if($data[0] == 0){
  echo "ok";
}else{
  echo "exist";
}
mysqli_close($conn);

?>
