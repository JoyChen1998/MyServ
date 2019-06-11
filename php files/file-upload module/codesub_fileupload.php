<?php
error_reporting(0);
include "codesub_SaveToDB.php";
//require_once("codesub_session.php");
header("Content-type:text/html;charset=utf-8");
date_default_timezone_set("Asia/Shanghai");
include "codesub_uploadClass.php";
include "codesub.php";
//if(!isset($_SESSION['user_id'])){
//    header("Location:loginpage.php");
//    exit(0);     // when add button => come to this page, cancel this annotation.
//}
$up = new FileUpload();
//设置属性（上传的位置、大小、类型、设置文件名是否要随机生成）
$up->set("sessionID", $_SESSION['user_id']);
$up->set("path", "./upload/");
$up->set("maxsize", 1000000); //bytes
$up->set("allowtype", array("zip", "docx", "txt"));//可以是"doc"、"docx"、"xls"、"xlsx"、"csv"和"txt"等文件，注意设置其文件大小
$up->set("setname", true);//true:由系统命名；false：保留原文件名
//使用对象中的upload方法，上传文件，方法需要传一个上传表单的名字name
//如果成功返回true，失败返回false
//先判断数据库记录
$username = 'test11jjjj';
$db = new SaveToMyDB();
if ($_FILES['p']['name'] == "")
    header("Location:codesub.php");
$result = $db->saveToDB($username, $_FILES['p']['name']);
$msg_str = "";
if (strlen($result) == 2) {
    $msg_str = $db->getMsg($result);
//    print_r($msg_str);
    echo "<div class=\"login\"><h3>$msg_str</h3></div>";
    header("Refresh:3;url='./codesub.php'");
} else {
    $msg_str = $result == '2' ? $db->getMsg($result) : $result;
    if ($up->upload("p")) {
        echo '<script>alert("上传成功");</script>';
        echo "<div class=\"login\"><h3>$msg_str</h3></div>";
        header("Refresh:2;url='./codesub.php'");
    } else {
        $error_msg = $up->getErrorMsg();
        echo "<div class=\"login\"><h3>$error_msg</h3></div>";
        header("Refresh:3;url='./codesub.php'");
    }
}
?>