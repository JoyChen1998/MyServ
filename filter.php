<meta charset="utf-8">
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/10
 * Time: 20:09
 */
function filtrate($username, $suffix){
    if(strlen($username)!=12){
        echo "输入学号名不正确！请重新输入";
        exit();
    }
    $file_size = $_FILES["p"]["size"];
    if($file_size>2*1024*1024) {
        echo "文件过大，不能上传大于2M的文件";
        exit();
    }
    if( $suffix!='zip' && $suffix!='c' && $suffix!='cpp' && $suffix!='python' && $suffix!="java" &&$suffix!="txt"&&$suffix!="jpg") {
        echo "文件类型只能为zip/c/c++/java/python格式";
        exit();
    }
}
