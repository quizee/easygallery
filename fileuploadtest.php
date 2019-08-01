<?php

    $tmpFile = $_FILES['pic']['tmp_name'];
    $newFile = '/var/www/html/images/'.$_FILES['pic']['name'];
    $result = move_uploaded_file($tmpFile, $newFile);
    echo $_FILES['pic']['name'];
    if ($result) {
        echo '<script>alert("업로드가 완료되었습니다.")</script>';
    } else {
         echo '<script>alert("업로드 실패")</script>';
    }

?>
<form action="" enctype="multipart/form-data" method="POST">
<input type="file" name="pic" id="pic" size="25" />
<input type="submit" value="Upload" />
</form>
