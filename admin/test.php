<!-- <?php
// $servername = "localhost";
// $username = "root";
// $password = "1234";
// // Create connection
// $conn = mysqli_connect($servername, $username, $password,"my_db");
// // Check connection
// if (!$conn) {
//   die("Connection failed: " . mysqli_connect_error());
// }

?> -->
<!-- id 작품명, 작가명, 작품 소개글, 등록 날짜, 작품 크기, 가격, 사진 url, 구매 횟수, edition -->

<br>

<div class="container">
  <div class="form-group">
    <div class="input-group">
      <span class="input-group-addon">검색</span>
      <input type="text" class="form-control" name="search_artist" id="search_artist" placeholder="작가명을 검색하세요"/>
    </div>
  </div>
  <br>

  <div id="result">
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#search_artist').keyup(function(){
      var txt=$(this).val();
      if(txt != ''){
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
