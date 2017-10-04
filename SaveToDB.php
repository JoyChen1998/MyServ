<meta charset="utf-8">
<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/10
 * Time: 19:49
 */
function savetodb($username, $file){
    //获取文件名字
    // $substring = explode('.',$file);
    // $newName = $username.'.'.$substring[count($substring)-1];
    // $suffix = $substring[count($substring)-1];                          //获取文件后缀
    // rename($file,$newName);
    echo $file."<br>".$username."<br>";
    /*
    $servername = 'localhost';
    $dbusername = 'root';
///////////
    $password = 'asdf1234';
//////////   
    $dbname = 'jol';
    */
    $conn =mysqli_connect($servername, $dbusername, $password , $dbname);
    if (!$conn) {
        die("数据库连接失败: " . mysqli_connect_error());
    }
    $sql1 = "SELECT sub_times FROM subinfo WHERE student_id=$username";
//    $count = 0;
    $result = mysqli_query($conn, $sql1);
    $row = mysqli_fetch_array($result);
    $count = $row['sub_times'];

//    echo ".$count."."<br>";
    if(empty($count)){
        $sql2 = "INSERT INTO subinfo (student_id, filename)
        VALUES ($username, '".$file."')";                   //  char类型需要用单引号 双引号 中间加.
        if (mysqli_query($conn, $sql2)) {
            echo "新记录插入成功!"."<br>";
	    return true;
/////////////////////////////////////
        } else {
            echo "Error: " . $sql2 . "<br>" . mysqli_error($conn)."<br>";
        }
    }else {
        $newcount = $count + 1;
//        echo $newcount;
        if ($count >= 5) {
            echo "上传次数已经达到限制次数! 无法再次上传！";
	 } elseif ($count > 0 && $count < 5) {
            $sql_update = "UPDATE subinfo SET sub_times=$newcount WHERE student_id=$username";
            if (mysqli_query($conn, $sql_update) === TRUE) {
                echo "添加记录成功! 当前已提交 $newcount 次，最多可提交5次！"."<br>";
		return true;
///////////////////////////////////////
            }else {
                echo "Error: " . $sql_update . "<br>" . mysqli_error($conn)."<br>";
	    }
        }

    }
    mysqli_close($conn);
}

