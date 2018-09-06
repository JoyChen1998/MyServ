<?php
//require_once("codesub_session.php");
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="./css/WebPage.css" />
    <script src="js/confirm.js"></script>
</head>
<body>
<div class="login">
    <h1>项目提交</h1>
    <form method="post" onsubmit="return confirmsub()" action="codesub_fileupload.php"  enctype="multipart/form-data">
        <h2>请选择你要上传的文件</h2><input type="file" name="p" id="p" required="required"/>
        <button type="submit" value="submit" class="btn btn-primary btn-block btn-large">Let me Submit</button>
    </form>
</div>
<h5>Made By JoyChan</h5>
</body>
</html>
