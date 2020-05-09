
<?php
/**
 * Created by PhpStorm.
 * User: anboy
 * Date: 2020/5/1
 * Time: 8:25 PM
 */

$name = "localhost";
$user = "root";
$pass = "";
$dbname = "test";

$conn = new mysqli($name, $user, $pass, $dbname);


if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}

$select_sql = "SELECT uid, get_recom FROM rs WHERE uid=".$_SEESSION['user'];
$result = $conn->query($select_sql);
$recomendation = array();
if($result->num_rows >0) {
    while($row = $result->fetch_assoc()) {
        $recomendation = explode(",", trim($row["get_recom"], "[]"));
    }
}
$conn->close();
$cnt = count($recomendation);
?>

<link rel="stylesheet" href="bootstrap.min.css">
<script src="jquery.min.js"></script>
<script src="bootstrap.min.js"></script>


<?php echo "<a class=\"popover-options btn-success\" href=\"#\" title=\"<h5>当前推荐题目</h5>\"
   data-container=\"body\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"";
$i=0;
while($i < $cnt/2) {
    $id = trim($recomendation[$i], " ");
    echo "<h4><a href='http://202.194.119.110/problem.php?id=$id'>" .$id."</a></h4>";
    $i++;
}

echo "\">Recommend</a>"

?>



<script>
    $(function () { $(".popover-options").popover({html : true });});
</script>

