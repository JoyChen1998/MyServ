<?php
$username = "username";
$pass = "password";
$host = "localhost";
$dbname = "node";

// 创建连接
$conn = new mysqli($host, $username, $pass, $dbname);
// 检测连接
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$conn->query("set names utf8");

$g_id = "g_id";
$g_nickname = "g_nickname";
$g_level = "g_level";
$g_name = "g_name";
$sql = "SELECT g_id, g_name, g_price, g_shop FROM jd_gooditems";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 输出数据
    $count=0;
    while($row = $result->fetch_assoc()) {
        echo "<button class='item-btn' title= \"".$row['g_name']."\" name=".$row['g_id']." id=".$row['price']." >".$row['g_name']."</button>";
        $count++;
        if($count % 5 == 0)
            echo "<br>";
    }
    $count=0;
}
else {
    echo "0 结果";
}

?>
