<script type="text/javascript">
$(function(){
 $('div[name="reply"]').click(function(){
   var parent_comment = $(this).data('parent');
   var writer = $(this).data('writer');

   $('#parent_comment').val(parent_comment);//대댓을 달려는 자신의 부모를 hidden input 에 넣는다.
   //부모보다 한칸 오른쪽으로 밀어난 input을 만든다.
   //그러기 위해서는 depth 라는 개념이 필요하다.
   var content = "";
   content += '<div class="row" style="margin-left:10px;"><div class="col-md-3 text-center" id="whos_writing_child">';
   content += 'admin</div><div class="col-md-6"><textarea style="width:100%;" name="name" rows="2" cols="30" placeholder="대댓글 달기..." id="comment_text"></textarea>';
   content += '</div><div class="col-md-3" ><button type="button" name="comment" id="comment_btn_child" class="btn btn-info">게시</button></div></div>';
   var $div = $(content);
   //alert(parent_comment);
   //$('#'+parent_comment).append($div);
   //var yu = "yu";
   $("[id='"+parent_comment+"']").append($div);
   //$('#2019-08-08')
 });
});
// var reply_func = function(element){
//   //답글달기 버튼에 해당 댓글 아이디와 글쓴이 데이터가 담겨져 있다.
//   var parent_comment = $(element).data('parent');
//   var writer = $(element).data('writer');
//
//   $('#parent_comment').val(parent_comment);//대댓을 달려는 자신의 부모를 hidden input 에 넣는다.
//   //부모보다 한칸 오른쪽으로 밀어난 input을 만든다.
//   //그러기 위해서는 depth 라는 개념이 필요하다.
//   var content = "";
//   content += '<div class="row" style="margin-left:10px;"><div class="col-md-3 text-center" id="whos_writing_child">';
//   content += 'admin</div><div class="col-md-6"><textarea style="width:100%;" name="name" rows="3" cols="60" placeholder="대댓글 달기..." id="comment_text"></textarea>';
//   content += '</div><div class="col-md-3" ><button type="button" name="comment" id="comment_btn_child" class="btn btn-info">게시</button></div></div>';
//   var $div = $(content);
//   $('#group1').append($div);
// };
</script>

<div class="container">
  <input type="hidden" id ="parent_comment" name="parent_comment" value="">
  <div id="2019-08-08 19:09:51">
    <div class="row">
      <div class="col-md-3 text-center">
        admin
      </div>
      <div class="col-md-6">
        야임마
      </div>
      <div class="col-md-3 reply" name = "reply" data-parent="2019-08-08 19:09:51" data-writer="지윤">
        답글달기
      </div>
    </div>
  </div>
</div>
<table class="table">
  <tr style = "padding-left:10px;">
    <td>아</td>
    <td>dk</td>
  </tr>
  <tr style = "padding-left:20px;">
    <td>아</td>
    <td>dk</td>
  </tr>
</table>
<table class="table">

</table>
