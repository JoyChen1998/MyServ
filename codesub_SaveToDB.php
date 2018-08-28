<meta charset="utf-8">
<?php

/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/9/10
 * Time: 19:49
 */
/**
  数据库操作类SaveToMyDB
    实现上传时记录的保存，以及限制提交次数和统计
   */
class SaveToMyDB
{
    /*向数据库保存用户提交记录*/
    function saveToDB($username, $file)
    {
        if ($file == "")
            return -9;
        $serverName = "localhost";
        $usrName = "root";
        $password = "";
        $DBName = "laocha";
        $default = 5;
        $connect = new mysqli($serverName, $usrName, $password, $DBName);           //connect database
        if ($connect->connect_error) {
            return -5;
        }
        $sql = "SELECT sub_times FROM subinfo WHERE student_id = '" . $username . "'";        // first check sub times
        $result = $connect->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($row['sub_times'] >= 5) {
                return -1;
            }
            $newcount = $row['sub_times'] + 1;
            $sql2 = "UPDATE subinfo SET sub_times = $newcount WHERE student_id = '" . $username . "'";     //update sub time
            $sql3 = "UPDATE subinfo SET fileName = '" . $file . "' WHERE student_id = '" . $username . "'";//update sub filename
            if ($connect->query($sql3) === true && $connect->query($sql2) === true) {
                $str = "已提交 $newcount 次,最多提交 $default 次！";
                return $str;
            } else {
                return -2;
            }
        } else {
            $sql1 = "INSERT INTO subinfo (student_id, fileName) VALUES ('" . $username . "', '" . $file . "')";   //new record insert
            if ($connect->query($sql1) === true) {
                return 2;
            } else {
                return -3;
            }
        }

    }

    /*由于提交时出错而需要降低次数*/
    function divTimes($username)
    {
        $serverName = "localhost";
        $usrName = "root";
        $password = "";
        $DBName = "laocha";
        $connect = new mysqli($serverName, $usrName, $password, $DBName);           //connect database
        if ($connect->connect_error) {
            echo "<font color='red'> 连接数据库时失败 </font>";
            return;
        }
        $sql = "SELECT sub_times FROM subinfo WHERE student_id = '" . $username . "'";        // first check sub times
        $result = $connect->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $newcount = $row['sub_times'] - 1;
            $sql2 = "UPDATE subinfo SET sub_times = $newcount WHERE student_id = '" . $username . "'";     //div sub time
            if ($connect->query($sql2) === true) {
                $str = "<font color='red'> 提交失败 </font>";
                return $str;
            } else {
                echo "<font color='red'> 未知错误 </font>";
            }
        }
        $connect->close();
    }

    /*清空数据表*/
    function flushTable()
    {
        $serverName = "localhost";
        $usrName = "root";
        $password = "";
        $DBName = "laocha";
        $connect = new mysqli($serverName, $usrName, $password, $DBName);           //connect database
        if ($connect->connect_error) {
            return -5;
        }
        $sql = "truncate table subinfo";
        if ($connect->query($sql) === true) {                                         //clean table
            return true;
        } else {
            return -4;
        }
    }

    /*获取返回信息*/
    function getMsg($num)
    {
        switch ($num) {
            case  3:
                $str = "清空数据成功！";
                break;
            case  2:
                $str = "新增记录成功！";
                break;
            case -1:
                $str = "已达提交次数上限，不可再次上传！";
                break;
            case -2:
                $str = "更新记录失败";
                break;
            case -3:
                $str = "增加记录失败";
                break;
            case -4:
                $str = "清空数据失败";
                break;
            case -5:
                $str = "连接数据库时失败";
                break;
            case -9:
                $str = "不允许上传空文件";
                break;
            default:
                $str = "未知错误";
                break;
        }
        return $str;
    }
}

?>