<?php
if($_SESSION['MYPR_adm_type']!="admin")
header("location:".URLUR."home");
?>