<?php

$product  = $_GET[p_num];
global $s_c;

session_start();

if(!$_SESSION["p_num"][0]) { //생성된 세션이 없으면

$_SESSION["p_num"][0] = $product; //세션 array변수에 제품을 담는다.

}



else //생성된 세션(장바구니) 가 있으면

{

   $s_c = count($_SESSION["p_num"]); //총 장바구니의 크기를 구한다.

for($i=0;$i<$s_c;$i++) //장바구니에 추가한 제품이 있는지 찾기 위한 for문

{

 if($_SESSION["p_num"][$i] == $product) //저장된 제품이 있는지 검사

 {

  $is_p_num = 1; //이미 장바구니에 추가된 제품이라면 1을 저장

  //echo "장바구니에 추가한 제품이 이미 존재합니다.<br>";
 }

}

if($is_p_num != 1) { //장바구니에 추가된 제품이 아니라면
 $_SESSION["p_num"][$s_c] = $product;  //세션변수에 새로 제품 등록
}
}


for($i=0;$i<$s_c;$i++) {
 echo "귀하가 장바구니 추가한 제품은";
 echo $_SESSION["p_num"][$i] . "<br>";
}
?>


<!DOCTYPE html>
<html>
<head>
<title>php session을 이용한 장바구니</title>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
</head>
<body>

<br />

<div class="container" style="width:700px;">
<h3 align="center">php session을 이용한 장바구니</h3>
<br>
<?php
$query = "SELECT * FROM tbl_product ORDER BY id ASC";
$result = mysqli_query($connect,$query);

if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_array($result))
{
?>
<!-- =============반복 되는 상품 리스트 부분=============== -->
<div class="col-md-4">
<!-- action 속성에 주소와 상품 id 번호 담는다 -->
<form method="post" action="index.php?action=add&id=<?php echo $row["id"]; ?> ">
<div style="border:1px solid #333; background-color:#f1f1f1; border-radius:5px; padding:16px;" align="center">
<img src="<?php echo $row["image"]; ?>" class="img-responsive" /> </br>
<h4 class="text-info"> <?php echo $row["name"]; ?> </h4>
<h4 class="text-danger"> <?php echo $row["price"]; ?> </h4>

<!-- submit 버튼을 누를때 name 속성의 값이 url로 넘어간다. post 방식으로 -->
<input type="text" name="quantity" class="form-control" value="1" />
<input type="hidden" name="hidden_name" value="<?php echo $row["name"] ?>" />
<input type="hidden" name="hidden_price" value="<?php echo $row["price"] ?>" />
<input type="submit" name="add_to_cart" style="margin-top:5px;" class="btn btn-success" value="추가"/>
</div>
</form>
</div>
<!-- 반복 되는 상품 리스트 부분 종료-->
<?php
}

}
?>
<div style="clear:both"></div>
<br>

<h3>주문내역</h3>
<div class="table-responsive">
<table class="table table-bordered">
<tr>
<th width="40%">상품</th>
<th width="10%">수량</th>
<th width="20%">가격</th>
<th width="15%">총금액</th>
<th width="5%">옵션</th>
</tr>


<?php
//쇼핑카트에 물건이 존재하면!
if(!empty($_SESSION["shopping_cart"]))
{
$total = 0;
foreach($_SESSION["shopping_cart"] as $keys => $values)
{
?>

<tr>
<td><?php echo $values["item_name"]; ?></td>
<td><?php echo $values["item_quantity"]; ?></td>
<td><?php echo $values["item_price"]; ?></td>
<td><?php echo number_format($values["item_quantity"] * $values["item_price"],2);?></td>
<td><a href="index.php?action=delete&id=<?php echo $values["item_id"]?>"> <span class="text-danger">삭제</span> </a></td>

</tr>

<?php
$total = $total + ($values["item_quantity"] * $values["item_price"]);
} //foreach 끝
?>

<tr>
<td colspan="3" align="right">총금액</td>
<td align="right"><?php echo number_format($total,2);?> </td>
<td></td>
</tr>


<?php
} //if문 끝
?>

</table>
</div>



</div>


</body>
</html>
