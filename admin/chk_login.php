<?php
if($_SESSION['MYPR_adm_id']=="" || $_SESSION['MYPR_adm_username']=="")
header("location:".URLAD."login");
?>