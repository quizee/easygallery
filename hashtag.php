<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <style>
    #example-one {
  padding: 2px; outline: 1px solid black;
}
.highlight{
  color:blue;
}
    </style>
  </head>
  <body>
    <div id="example-one" contenteditable="true">
Type something here
</div>
<input type="hidden" name="text"/>
<button onclick="logHashList();">Alert List of Hashtags</button>
  </body>
  <script>
  var hashTagList = [];

function logHashList(){
  hashTagList = [];
  $('.highlight').each(function(){
      hashTagList.push(this.innerHTML);
  });
  for(var i=0;i<hashTagList.length;i++){
      alert(hashTagList[i]);
  }
  if(hashTagList.length==0){
      alert('You have not typed any hashtags');
  }
}
$(function() {

  var hashtags = false;

  $(document).on('keyup', '#example-one', function (e) {
      arrow = {
          hashtag: 51,
          space: 32
      };

      var input_field = $(this);
      var id = 0;

      switch (e.which) {
          case arrow.hashtag:
              e.preventDefault();
              input_field.html(input_field.html() + "<span id='span_"+id+"' class='highlight'>#");
              placeCaretAtEnd(this);
              hashtags = true;
              break;
          case arrow.space:
              if(hashtags) {
                  e.preventDefault();
                  input_field.html(input_field.html() + "</span>&nbsp;");
                  placeCaretAtEnd(this);
                  hashtags = false;
                  id++;
              }
              break;
          default:
             //console.log(e.which);
            if(hashtags == true && e.which != 8){
              e.preventDefault();
              var txt = $('#span_'+id).text();
              //input_field.html(input_field.html() + "<span id='span_"+id+"' class='highlight'>"+txt+ String.fromCharCode(e.which));
              $('#span_'+id).text(txt+ String.fromCharCode(e.which));
              placeCaretAtEnd(this);
            }else if(hashtags == t){

            }break;
      }

  });

});


function placeCaretAtEnd(el) {
  el.focus();
  if (typeof window.getSelection != "undefined"
          && typeof document.createRange != "undefined") {
      var range = document.createRange();
      range.selectNodeContents(el);
      range.collapse(false);
      var sel = window.getSelection();
      sel.removeAllRanges();
      sel.addRange(range);
  } else if (typeof document.body.createTextRange != "undefined") {
      var textRange = document.body.createTextRange();
      textRange.moveToElementText(el);
      textRange.collapse(false);
      textRange.select();
  }
}
  </script>
</html>
