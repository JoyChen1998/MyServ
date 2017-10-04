<?php
   session_start();
   if(!isset($_SESSION['user_id'])){
   header("Location:loginpage.php");
   exit();
}
?>
<html>
<head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/WebPage.css" />
    <script>
        function confirmsub() {
            var getid = document.getElementById("u").value;
            var getfilemsg = document.getElementById("p").value;
            var msg = confirm('你的学号是 '+getid+'\n提交的文件名为 '+getfilemsg+'\n确定提交?');
            if(msg == true){
                return true;
            }else{
                return false;
            }
        }
    </script>
</head>
<body>
<div class="login">
    <h1>项目提交</h1>
    <form method="post" onsubmit="return confirmsub()" action="fileupload.php"  enctype="multipart/form-data">
        <input name="u" id="u" placeholder="请输入学号" required="required" />
        <h2>请选择你要上传的文件</h2><input type="file" name="p" id="p" required="required"/>
        <button type="submit"value="submit" class="btn btn-primary btn-block btn-large">Let me Submit</button>
    </form>
</div>
</body>
</html>
