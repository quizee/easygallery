<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <link rel="import" href="header.html">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
  
<script>
(function($) {
	$.fn.hashtags = function() {
		$(this).wrap('<div class="jqueryHashtags"><div class="highlighter"></div></div>').unwrap().before('<div class="highlighter"></div>').wrap('<div class="typehead"></div></div>');
		$(this).addClass("theSelector");
		autosize($(this));
		$(this).on("keyup", function() {
			var str = $(this).val();
			$(this).parent().parent().find(".highlighter").css("width",$(this).css("width"));
			str = str.replace(/\n/g, '<br>');
			if(!str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?#([a-zA-Z0-9]+)/g) && !str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?@([a-zA-Z0-9]+)/g) && !str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?#([\u0600-\u06FF]+)/g) && !str.match(/(http|ftp|https):\/\/[\w-]+(\.[\w-]+)+([\w.,@?^=%&amp;:\/~+#-]*[\w@?^=%&amp;\/~+#-])?@([\u0600-\u06FF]+)/g)) {
                if(!str.match(/#(([_a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))#/g)) { //arabic support, CJK support
					str = str.replace(/#(([_a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))/g,'<span class="hashtag">#$1</span>');
				}else{
					str = str.replace(/#(([_a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))#(([_a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))/g,'<span class="hashtag">#$1</span>');
				}
				if(!str.match(/@(([a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))@/g)) {
					str = str.replace(/@(([a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))/g,'<span class="hashtag">@$1</span>');
				}else{
					str = str.replace(/@(([a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))@(([a-zA-Z0-9]+)|([\u0600-\u06FF]+)|([ㄱ-ㅎㅏ-ㅣ가-힣]+)|([ぁ-んァ-ン]+)|([一-龯]+))/g,'<span class="hashtag">@$1</span>');
				}
			}
			$(this).parent().parent().find(".highlighter").html(str);
		});
		$(this).parent().prev().on('click', function() {
			$(this).parent().find(".theSelector").focus();
		});

  	};
})(jQuery);
</script>
<style>
.jqueryHashtags .highlighter{
white-space: pre-wrap;
color:transparent;
overflow: hidden;
position: absolute;
padding-left:7px;
padding-top:5px;
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
font-size:14px;
line-height:20px;
}

.jqueryHashtags .theSelector{
background-color: transparent;
position: relative;
direction: ltr;
font-size:14px;
font-family: "Helvetica Neue",Helvetica,Arial,sans-serif;
resize:none !important;
-webkit-transition: height 0.2s;
border: 1px solid #cccccc;
-webkit-border-radius: 4px;
-moz-border-radius: 4px;
border-radius: 4px;
padding: 4px 6px;
vertical-align:middle;
min-height:48px !important;
line-height:20px; type="text/javascript"
}

.jqueryHashtags .hashtag{
background: -webkit-linear-gradient(#dce6f8, #bdcff1);
border-radius: 2px;
box-shadow: 0 0 0 1px #a3bcea;
font-size:14px;
white-space: pre-wrap;
word-break: break-word;
line-height:20px;
}
</style>
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>title</title>

</head>

<body>
<!--여기부터 시작 -->
<textarea name="name" rows="8" cols="80"></textarea>
<script type="text/javascript">
$(document).ready(function() {
  $("textarea").hashtags();
});
</script>


  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>
