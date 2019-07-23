<?php
    header("Content-Type: text/html;charset=utf-8");
    $username = "username";
    $pass = "password";
    $host = "localhost";
    $dbname = "node";
    $date = array();
    // 创建连接
    $conn = new mysqli($host, $username, $pass, $dbname);
    // 检测连接
    if ($conn->connect_error) {
        die("连接失败: " . $conn->connect_error);
    }
    $conn->query("set names utf8");
    $sql = "SELECT * FROM jd_comment";
    // set check box

    $g_nickname = true;
    $g_level = true;
    $g_id = true;
    $g_num = true;
    $g_score = true;
    $g_content = false;
    $g_client = true;

    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $status = true;
        $msg = "成功";
        $i = 0;
        while($row = mysqli_fetch_array($result)){
            $data [$i]['num'] = $g_num == false ? null : $row['num'];
            $data [$i]['id'] = $g_id == false ? null : $row['g_id'];
            $data [$i]['name'] = $g_nickname == false ? null : $row['g_nickname'];
            $data [$i]['level'] = $g_level == false ? null : $row['g_level'];
            $data [$i]['client'] = $g_id == false ? null : $row['g_client'];
            $data [$i]['score'] = $g_score == false ? null : $row['g_score'];
            $data [$i]['content'] = $g_content == false ? null : $row['g_content'];
            $i++;
        }
    }else {
        $status = false;
        $msg = "msg error";
        $valuse = array(
            $status,
            $msg
        );
    }
    echo json($status, $msg, $data);
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
        echo json_encode ( $result,JSON_UNESCAPED_UNICODE);
//        print_r($result);
    }
    $conn->close();

?>