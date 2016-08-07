<?php
require_once "includes/includepath.php";
if($_SESSION['ma_log_id']=="" || $_SESSION['ma_usr_name']=="")
header("location:".URL);
$usrid = $_SESSION['ma_log_id'];
?>