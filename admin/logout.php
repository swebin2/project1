<?php
session_start();
unset($_SESSION['MYPR_adm_id']);
unset($_SESSION['MYPR_adm_username']);
unset($_SESSION['MYPR_adm_type']);
unset($_SESSION['MYPR_exam_id']);
header("location:".URLAD."login");
?>