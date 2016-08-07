<?php
  require_once "includes/includepath.php";
  if(URL!="/")
  {
  $request  = str_replace(URL, "", $_SERVER['REQUEST_URI']);
  }
  else
  {
    $request = ltrim($_SERVER['REQUEST_URI'],'/');
  }
  $params     = explode("/", $request);
  $safe_pages = array("user", "search", "thread");
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
	  include("404.php");
  } else {
     include("404.php");
  }
  }
?>