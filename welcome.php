<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">

<script>
location.replace("about.php?welcome=1");
</script>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <?php include ('header.php');?>
</head>

<body>
<!--여기부터 시작 -->
<br>
<div class="container">
  <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
      <h1>가입을 축하합니다! </h1>
    </div>
    <div class="col-md-3"></div>
  </div>
</div>

<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name = $_POST["name"];
    $user_password = $_POST["pwd"];
    $email = $_POST["email"];
    $phone1 = $_POST["phone1"];
    $phone2 = $_POST["phone2"];
    $phone3 = $_POST["phone3"];
    $phone_num = $phone1.$phone2.$phone3;
    $mail_accept = $_POST["mail_type"];
    $agree = $_POST["agree"];
    $post_num = $_POST["post_num"];
    $address = $_POST["address"];
    $detail_address = $_POST["detail_address"];
    $total_address= $address." ".$detail_address;

    $servername = "localhost";
    $username = "root";
    $password = "1234";

    // Create connection
      $conn = mysqli_connect($servername, $username, $password,"user_db");

    // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      $sql = "INSERT INTO user_info (email, name, password, phone_num, mail_accept, post_num, address, detail_address)
      VALUES (" . "'" . $email . "'" . ",'" . $name . "'" . ",'" . $user_password . "'" . ",'" . $phone_num . "'" . ",'" . $mail_accept . "'" .  ",'" . $post_num ."'". ",'" . $address. "'". ",'" . $detail_address. "'". ")";

      if(!mysqli_query($conn, $sql)){
        die("Error: " . $sql . "<br>" . mysqli_error($conn));
      }

      mysqli_close($conn);
    }
 ?>
<?php include 'footer.php';?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
