<?php
require_once "includes/includepath.php";
  #remove the directory path we don't want
  $request  = str_replace(URLAD, "", $_SERVER['REQUEST_URI']);
 //$request = $_SERVER['REQUEST_URI'];
 
  #split the path by '/'
  $params     = explode("/", $request);
  
 // print_r($params);

  #keeps users from requesting any file they want
  $safe_pages = array("user");
  
  if($params[0]=="")
  {
    include("home.php");
  }
  else
  {
   
  if(!in_array($params[0], $safe_pages)) {
    if(file_exists($params[0].".php"))
	 include($params[0].".php");
	else
	  include("../404.php");
  } else {
    include("../404.php");
  }
  
  }
?>