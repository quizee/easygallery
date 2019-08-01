<?php
$url ="https://kapi.kakao.com/v1/payment/ready";

$cServiceUrl = 'kapi.kakao.com';
$cAdminKey = 'cc0696d496aeb01d576c2f683752a0f1';
$headers = array(
    'POST /v1/payment/ready HTTP/1.1',
    'Host: '.$cServiceUrl,
    'Authorization: KakaoAK '.$cAdminKey,
    'Content-type: application/x-www-form-urlencoded;charset=utf-8'
);

$data = array(
    'cid'=>'TC0ONETIME',
    'partner_order_id'=>time(),
    'partner_user_id'=>'userid',
    'item_code'=>'T000001',
    'item_name'=>'초코파이',
    'quantity'=>'1',
    'total_amount'=>'2200',
    'vat_amount'=>'200',
    'tax_free_amount'=>'0',
    'approval_url'=>urlencode('https://developers.kakao.com/success'),
    'cancel_url'=>urlencode('https://developers.kakao.com/cancel'),
    'fail_url'=>urlencode('https://developers.kakao.com/fail')
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);			#접속할 URL 주소
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);	#인증서 체크같은데 true 시 안되는 경우가 많다.
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, 0);			# 헤더 출력 여부
curl_setopt($ch, CURLOPT_POST, 1);				# Post Get 접속 여부
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);	# Post 값 Get 방식처럼적는다.
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);	# 결과값을 받을것인지
$result = curl_exec($ch);
echo $result;
?>
