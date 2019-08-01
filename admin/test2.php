<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>tutorial</title>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <link rel="import" href="header.html"> -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  </head>
  <body>
    <div class="container">
      <br>
      <div class="form-group">
        <div class="input-group">
          <span class="input-group-addon">검색</span>
          <input type="text" name="search_text" id="search_text" class="form-control" placeholder="작가이름검색">
        </div>
        <br>
      </div>
      <div id="test">

      </div>
        <div id="result"></div>
    </div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#search_text').keyup(function(){
      var txt=$(this).val();
      if(txt != ''){
        $('#test').html(txt);
        $.ajax({
            async: true,
            type : 'GET',
            data : {'search':  txt},
            url : "/admin/fetch.php",
            dataType : "text",
            contentType: "application/json; charset=UTF-8",
            success : function(data) {
              $('#result').html(data);
              console.log(data);
            },
            error : function(error) {
                console.log("error : " + error);
            }
          });
      }else{
        $('#result').html('');
      }
    });
  });
</script>
  </body>
</html>
