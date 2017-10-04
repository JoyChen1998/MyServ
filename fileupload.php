
<?php
require_once("filter.php");
require_once("SaveToDB.php");
////////////////////
	echo $_SESSION['user_id']."<br>";

////////////////////
error_reporting(0);
$username = $_POST["u"];

$file = $_FILES['p']['name'];                                       //获取文件名字
$substring = explode('.', $file);
$newName = $username . '.' . $substring[count($substring) - 1];
$suffix = $substring[count($substring) - 1];                          //获取文件后缀
rename($file, $newName);
/*
 * function filter
 * last upload this file
 */
filtrate($username, $suffix);                                       //引用filter中的方法过滤文件属性
$class = $username[2] . $username[3] . $username[8].'-'.$username[9];                    //提取班级或专业信息
//判断是否上传成功（是否使用post方式上传）
if (is_uploaded_file($_FILES['p']["tmp_name"])) {
    $uploaded_file = $_FILES['p']["tmp_name"];
    $user_path = $_SERVER['DOCUMENT_ROOT'] . "/uploads/" . $class;
//    $user_path1=$_SERVER['DOCUMENT_ROOT']."/uploads/";
    //判断该用户文件夹是否已经有这个文件夹
    if (!file_exists($user_path)) {
        mkdir($user_path);
    }
    $file_true_name = $_FILES['p']["name"];
    $move_to_file = $user_path . "/" . $newName;
//    $move_to_file1=$user_path1."/".$newName;
    if (savetodb($username, $file) == true) {
        if (move_uploaded_file($uploaded_file, iconv("utf-8", "gb2312", $move_to_file))) {
//     move_uploaded_file($uploaded_file,iconv("utf-8","gb2312",$move_to_file1));
            echo $_FILES['p']["name"] . " " . "上传成功!";
        } else {
            echo "上传失败!";
        }
    } else {
        echo "上传失败!";
    }
} else {
    echo "上传失败!";
}
