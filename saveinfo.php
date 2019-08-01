<?php
if($_SERVER["REQUEST_METHOD"]=="POST"){

    $name = $_POST["name"];
    $password = $_POST["pwd"];
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
/*
    echo "name" . $name ."<br>";
    echo "password " . $password . "<br>";
    echo "phone_num" . $phone_num ."<br>";
    echo "look this !!! email_accept " . $mail_accept ."<br>";
    echo "look this !!!agree " . $agree ."<br>";
    echo "post_num" . $post_num ."<br>";
    echo "address" . $address ."<br>";
    echo "detail_address" . $detail_address ."<br>";
*/
    $servername = "localhost";
    $username = "root";
    $password = "1234";

    // Create connection
      $conn = mysqli_connect($servername, $username, $password,"user_db");

    // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }else{
        echo "connection success";
      }

      $sql = "INSERT INTO user_info (email, name, password, phone_num, mail_accept, post_num, address)
      VALUES (" . "'" . $email . "'" . ",'" . $name . "'" . ",'" . $password . "'" . ",'" . $phone_num . "'" . ",'" . $mail_accept . "'" .  ",'" . $post_num ."'". ",'" . $total_address. "'". ")";

      if(!mysqli_query($conn, $sql)){
        die("Error: " . $sql . "<br>" . mysqli_error($conn));
      }

      mysqli_close($conn);
    }

 ?>
