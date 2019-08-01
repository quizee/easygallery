<form method="post" action="">
      <!--
        결제정보셋팅
      -->
      <input type="text" name="partner_order_id" value="<?=$partner_order_id?>">  <!-- 주문번호 -->
      <input type="text" name="partner_user_id" value="<?=$partner_user_id?>">    <!-- 사이트 주문유저id -->
      <input type="text" name="item_name" value="<?=$item_name?>">                <!-- 상품명 -->
      <input type="text" name="quantity" value="<?=$quantity?>">                  <!-- 수량 -->
      <input type="text" name="total_amount" value="<?=$total_amount?>">          <!-- 상품총액 -->
      <input type="text" name="tax_free_amount" value="<?=$tax_free_amount?>">    <!-- 비과세금액 -->

      <input type="submit" name="submit" value="결제하기">
</form>


<?php
function CallPaymentKakaoPay($orderArr) {


      $adminkey             = $this->strKakaopayAdminkey;       // admin 키
      if( $this->config->item('kakaopay_mode') == 'service' ) {
          $cid            = $this->strkakaopayCID;            // cid
      } else if( $this->config->item('kakaopay_mode') == 'test' ) {
          $cid            = 'TC0ONETIME';
      }

      $req_auth   = 'Authorization: KakaoAK '.$adminkey;
      $req_cont   = 'Content-type: application/x-www-form-urlencoded;charset=utf-8';

      $kakao_header = array( $req_auth, $req_cont );

      $approval_url   = "https://
Viewer
".$this->input->server('HTTP_HOST')."/order/CallPaymentKakaoPaySuccess";
      $cancel_url     = "https://
Viewer
".$this->input->server('HTTP_HOST')."/order/CallPaymentKakaoPayCancle";
      $fail_url       = "https://
Viewer
".$this->input->server('HTTP_HOST')."/order/CallPaymentKakaoPayCancle";

      $kakao_params = array(
          'cid'               => $cid,                                    // 가맹점코드 10자
          'partner_order_id'  => $orderArr['order_id'],                   // 주문번호
          'partner_user_id'   => get_cookie('user_id'),                   // 유저 id
          'item_name'         => $orderArr['order_prd_nm'],               // 상품명
          'quantity'          => $orderArr['ord_row'],                    // 상품 수량
          'total_amount'      => $orderArr['total_price'],                // 상품 총액
          'tax_free_amount'   => '0',                                     // 상품 비과세 금액
          'approval_url'      => $approval_url,                           // 결제성공시 콜백url 최대 255자
          'cancel_url'        => $cancel_url,
          'fail_url'          => $fail_url,
      );

      //pre($kakao_params);

      $strArrResult = request_curl('https://kapi.kakao.com/v1/payment/ready
Viewer
', 1, http_build_query($kakao_params), $kakao_header);

      //pre($strArrResult);

      if( $strArrResult[3] != '200' ) {
               echo "<script>";
               echo "alert('에러입니다. 관리자에게 문의하세요.');";
               echo "</script>";
               return;
      }

      $strArrResult = json_decode($strArrResult[0]);

      set_cookie("kakao_tid", $strArrResult->tid, 0);
      set_cookie("kakao_order_id", $orderArr['order_id'], 0);

      echo "<script>";
      echo "var win = window.open('','','toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=no,width=540,height=700,left=100,top=100');";
      echo "win.document.write('<iframe width=100%, height=650 src=".$strArrResult->next_redirect_pc_url." frameborder=0 allowfullscreen></iframe>')";
      echo "</script>";
  }

 ?>
 <?php
    function CallPaymentKakaoPaySuccess() {

        $adminkey           = $this->strKakaopayAdminkey;
        if( $this->config->item('kakaopay_mode') == 'service' ) {
            $cid            = $this->strkakaopayCID;
        } else if( $this->config->item('kakaopay_mode') == 'test' ) {
            $cid            = 'TC0ONETIME';
        }

        $req_auth   = 'Authorization: KakaoAK '.$adminkey;
        $req_cont   = 'Content-type: application/x-www-form-urlencoded;charset=utf-8';

        $kakao_header = array( $req_auth, $req_cont );

        $kakao_params = array(
            'cid'               => $cid,                            // 가맹점코드 10자
            'tid'               => get_cookie('kakao_tid'),         // 결제 고유번호. 결제준비 API의 응답에서 얻을 수 있음
            'partner_order_id'  => get_cookie('kakao_order_id'),    // 가맹점 주문번호. 결제준비 API에서 요청한 값과 일치해야 함
            'partner_user_id'   => get_cookie('user_id'),           // 가맹점 회원 id. 결제준비 API에서 요청한 값과 일치해야 함
            'pg_token'          => $this->input->get('pg_token')    // 결제승인 요청을 인증하는 토큰. 사용자가 결제수단 선택 완료시 approval_url로 redirection해줄 때 pg_token을 query string으로 넘겨줌
            //'payload'           => ,                              // 해당 Request와 매핑해서 저장하고 싶은 값. 최대 200자
        );

        $strArrResult = request_curl('https://kapi.kakao.com/v1/payment/approve
Viewer
', 1, http_build_query($kakao_params), $kakao_header);

        $IS_PAYMENT_SUCCESS = false;

        if( $strArrResult[3] != '200' ) {
            echo "<script>";
            echo "alert('에러입니다. 관리자에게 문의하세요.');";
            echo "window.parent.close();";
            echo "</script>";
            return;
        }

        $strArrResult = json_decode($strArrResult[0]);

        // LGD 로 쓰는 이유는 기존 table를 활용해서 같이쓰기위함.
        $paymentResultArr = Array (
             'LGD_TID'                => $strArrResult->tid,                     // kakao 거래 고유 번호
             'LGD_MID'                => $strArrResult->cid,                     // 상점아이디
             'LGD_OID'                => $strArrResult->partner_order_id,        // 상점주문번호
             'LGD_AMOUNT'             => $strArrResult->amount->total,           // 결제금액
             'LGD_RESPCODE'           => '0000',                                 // 결과코드
             'LGD_RESPMSG'            => '결제성공',                                       // 결과메세지

             'LGD_FINANCENAME'        => $strArrResult->card_info->purchase_corp,         // 은행명
             'LGD_FINANCECODE'        => $strArrResult->card_info->purchase_corp_code,    // 은행코드

             'LGD_PAYTYPE'            => $strArrResult->payment_method_type,              // 결제 방법 ( CARD, MONEY )

             'LGD_PAYDATE'            => $strArrResult->approved_at,                      // 승인시간 (모든 결제 수단 공통)
             'LGD_FINANCEAUTHNUM'     => $strArrResult->card_info->approved_id,           // 신용카드 승인번호
             'LGD_CARDNOINTYN'        => $strArrResult->card_info->interest_free_install, // 신용카드 무이자 여부 ( Y: 무이자,  N : 일반)
             'LGD_CARDINSTALLMONTH'   => $strArrResult->card_info->install_month,         // 신용카드 할부개월

        );

        // 트랜잭션 시작
        $this->db->trans_begin();

        //결재 정보 갱신
        $this->AfterPaymentSuccess( $paymentResultArr );

        if ($this->db->trans_status() == FALSE) {
             $this->db->trans_rollback();
        } else {
             $IS_PAYMENT_SUCCESS = true;
             $this->db->trans_commit();
        }


        if( $IS_PAYMENT_SUCCESS ) {

            /**
             * TODO
             * 주문 SMS 발송
             */
            $this->ordersms( get_cookie('kakao_order_id') );

            $replace_url = HTTP_GURL . "/order/orderSuccess/".get_cookie('kakao_order_id');

            delete_cookie("kakao_tid");
            delete_cookie("kakao_order_id");

?>
            <script language='javascript'>
                 var childWindow = window.parent;
                 var parentWindow = childWindow.opener;
                 parentWindow.parent.location.replace("<?=$replace_url?>");
                 childWindow.close();
            </script>
<?php
        }

    }
?>
<?php
    function CallPaymentKakaoPayCancle() {

?>
        <script language='javascript'>
            var childWindow = window.parent;
            alert('결제가 취소/실패 하였습니다.\n\n다시시도해주세요!');
            childWindow.close();
        </script>
<?php


    }
?>
<?php
if(isset($_POST['submit'])){
  CallPaymentKakaoPay($orderArr);

}

 ?>
