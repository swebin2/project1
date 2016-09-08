<?php
ob_start();
session_start();
require_once "../includes/config.php";
if(CACHE=="Enabled")
{
 require_once "includes/phpfastcache.php";
}

if(file_exists("../includes/settings.php"))
{
ini_set("include_path", ROOT_SITE.'/classes' . PATH_SEPARATOR . ROOT_SITE.'/includes' . PATH_SEPARATOR . PATH_SEPARATOR . ROOT_SITE.'/secimp/includes' .ini_get("include_path"));

function __autoload($class_name) { 
	require_once $class_name . '.class.php';
}
}
?>