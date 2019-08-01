<?php
    session_start();
    session_destroy();
    setcookie("cart_items_cookie", "", time() - 3600);
    unset($_COOKIE['cart_items_cookie']);
?>
<meta http-equiv="refresh" content="0;url=collection.php" />
