<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("Location:loginpage.php");
    exit(0);     // when add button => come to this page, cancel this annotation.
}
?>
