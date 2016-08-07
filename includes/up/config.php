<?php 

	define("DB_TYPE","mysqli");

	define("DB_HOST","localhost");

	define("DB_USER","brokkers_tricky");

	define("DB_PASSWORD","J]n,Ffh}ROvX");

	define("DB_NAME","brokkers_tricky");

	define("SMTPHOST", "");

	define("FOLDER_PATH", "");

	define("URL", FOLDER_PATH."/");

	define("URLAD", FOLDER_PATH."/admin/");
	
	define("URLUR", FOLDER_PATH."/user/");

	define("ROOT_PATH",$_SERVER["HTTP_HOST"].FOLDER_PATH);

	define("ROOT_SITE",$_SERVER["DOCUMENT_ROOT"].FOLDER_PATH);

	define("WEBLINK","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH);

	define("WEBLINKAD","http://".$_SERVER["HTTP_HOST"].FOLDER_PATH."/admin");

	define("FROMMAIL", "info@phpwebsites.in");

	define("FROMNAME", "Admin"); 

	define("ADMINMAIL", "sumeshtg@gmail.com");

	define("ADMINNAME", "Admin"); 

	define("TITLE", "Tricky Score");

	define("SITE_NAME", "Tricky Score");

	define("SHORT_NAME", "Tricky Score");

	define("WEBSITE", "www.trickyscore.com");

	define("DESCRIP", " an online travel agency that offers a unique, interactive way to build your own holiday based on your budget.");

	define("CACHE", "Disabled");//Enabled, Disabled

	define("SETTINGS", "tricky");

	define("WATERMARK", "");

	//ini_set('display_errors', 'On');

	error_reporting (E_ALL ^ E_NOTICE);

	ini_set( 'date.timezone', 'Asia/Calcutta' );

    @setcookie( "sweb", SETTINGS, (time() + (10 * 365 * 24 * 60 * 60)));



