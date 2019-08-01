<?php
$id = '1234';
$quantity = 1;

$cookie = $_COOKIE['cart_items_cookie'];
$cookie = stripslashes($cookie);
$saved_cart_items = json_decode($cookie, true);//쿠키로 받아온 목록



 ?>
