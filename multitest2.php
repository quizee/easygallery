<!DOCTYPE html>
<html>
<head>
    <title>File API - FileReader as Data URL</title>
</head>
<body>
    <header>
        <h1>File API - FileReader</h1>
    </header>
    <article>
        <label for="files">Select multiple files: </label>
        <input id="files" type="file" multiple/>
        <output id="result" />
    </article>
</body>
</html>

<script type="text/javascript">
window.onload = function(){

      var filesInput = document.getElementById("files");

      filesInput.addEventListener("change", function(event){

          var files = event.target.files; //FileList object
          var output = document.getElementById("result");

          for(var i = 0; i< files.length; i++)
          {
              var file = files[i];

              //Only pics
              if(!file.type.match('image'))
                continue;

              var picReader = new FileReader();

              picReader.addEventListener("load",function(event){

                  var picFile = event.target;

                  var div = document.createElement("div");

                  div.innerHTML = "<img class='thumbnail' src='" + picFile.result + "'" +
                          "title='" + picFile.name + "'/>";

                  output.insertBefore(div,null);

              });

               //Read the image
              picReader.readAsDataURL(file);
          }

      });


}

</script>
<style>
body{
    font-family: 'Segoe UI';
    font-size: 12pt;
}

header h1{
    font-size:12pt;
    color: #fff;
    background-color: #1BA1E2;
    padding: 20px;

}
article
{
    width: 80%;
    margin:auto;
    margin-top:10px;
}


.thumbnail{

    height: 100px;
    margin: 10px;
}

</style>
