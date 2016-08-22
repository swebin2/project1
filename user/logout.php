<?php
require_once "includes/includepath.php";
session_start();
$usrid = $_SESSION['ma_log_id'];
unset($_SESSION['exam'][$usrid]);
unset($_SESSION['ma_log_id']);
unset($_SESSION['ma_usr_name']);
unset($_SESSION['ma_name']);


if(isset($_SESSION['fb_access_token'])){
		unset($_SESSION['fb_access_token']);
}


session_destroy(); 


header("location:".URL);
?>