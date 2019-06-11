<?php
    $username = "yourusername";
    $pass = "password";
    $host = "yourhost";
    $dbname = "yourdb";
    $date = array();
    // 创建连接
    $conn = new mysqli($host, $username, $pass, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    $conn->query("set names gbk");

    $g_id = "g_id";
    $g_nickname = "g_nickname";
    $g_level = "g_level";
    $sql = "SELECT ".$g_id.", ".$g_nickname." ,".$g_level." FROM jd_comment";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $status = true;
        $msg = "成功";
        $i = 0;
        while($row = mysqli_fetch_array($result)){

            $data [$i]['ID'] = $row['g_id'];
            $data [$i]['Name'] = $row['g_nickname'];
            $data [$i]['level'] = $row['g_level'];
            $i++;
        }
    }else {
        $status = false;
        $msg = "数据查询失败";
        $valuse = array(
            $status,
            $msg
        );
    }
    echo json($status,$msg,$data);
        //封装json 格式
    function json($status, $message = '', $data = array()) {
        if (!is_bool( $status )) {
            return '';
        }
        $result = array (
            'status' => $status,
            'message' =>$message,
            'data' => $data
        );
//        echo json_encode ( $result,JSON_UNESCAPED_UNICODE);
        print_r($result);
    }
    $conn->close();

?>