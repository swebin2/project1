<?php
require_once "includes/includepath.php";
session_start();
unset($_SESSION['ma_log_id']);
unset($_SESSION['ma_usr_name']);
unset($_SESSION['ma_name']);

session_destroy(); 


header("location:".URL);
?>