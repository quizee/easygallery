<?php
$servername = "localhost";
$username = "root";
$password = "1234";

// Create connection
$conn = mysqli_connect($servername, $username, $password,"user_db");

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}else{
echo "Connected successfully";
}?>
