<?php
//define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/Facebook/');
$objgen		=	new general();

if($_COOKIE["swebin_user"]!="")
$email = $_COOKIE["swebin_user"];

if($_COOKIE["swebin_sec"]!="")
$password = $objgen->decrypt_pass($_COOKIE["swebin_sec"]);

if(isset($_POST['Login']))
{
   $email 		= trim($_POST['email_login']);
   $password 	= trim($_POST['password_login']);
   $remember_me = $_POST['remember_me'];
  
  if($email!="" && $password!="")
  {
	
	  
	  $msg = $objgen->chk_Login('users',$email,$password,'','id','email','password','active',0,'*',$remember_me);
	  if($msg=="")
	  {
		
		//header("location:".URL."payment");
		
		 $result   = $objgen->get_Onerow("users","AND id=".$_SESSION['ma_log_id']);
		 
		 if($result['otp_verify']=='no')
		 {
			header("location:".URL."verify-otp"); 
		 }
		 else
		 {
		   header("location:".URLUR);
		 }
			
	  }
	  else
	  {
	     $msg = "Invalid Email or Password";  
	  }

  }
  else
  {
     $msg = "Enter Email or Password";  
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui">
<title><?=TITLE?></title>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,700' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="<?=URL?>images/favicon.ico" type="image/x-icon">
<link href="<?=URL?>css/master.css" rel="stylesheet">
<script src="<?=URL?>js/jquery-1.11.3.min.js"></script>
<link href="<?=URL?>css/main2.css" rel="stylesheet">
<link href="<?=URL?>css/styles.css" rel="stylesheet">
<style>
body {
	font-family: "Open Sans", sans-serif;
	height: 100vh;
}
 @keyframes spinner {
 0% {
 transform: rotateZ(0deg);
}
 100% {
 transform: rotateZ(359deg);
}
}
* {
	box-sizing: border-box;
}
.wrapper {
	display: flex;
	align-items: center;
	flex-direction: column;
	justify-content: center;
	width: 100%;
	min-height: 100%;
	background: rgba(4, 40, 68, 0.85);
	padding-top: 57px;
	padding-bottom: 62px;
}
.login {
	border-radius: 2px 2px 5px 5px;
	padding: 10px 20px 20px 20px;
	width: 90%;
	max-width: 400px;
	background: #ffffff;
	position: relative;
	padding-bottom: 80px;
	box-shadow: 0px 1px 5px rgba(0, 0, 0, 0.3);
}
.login.loading button {
	max-height: 100%;
	padding-top: 50px;
}
.login.loading button .spinner {
	opacity: 1;
	top: 40%;
}
.login.ok button {
	background-color: #8bc34a;
}
.login.ok button .spinner {
	border-radius: 0;
	border-top-color: transparent;
	border-right-color: transparent;
	height: 20px;
	animation: none;
	transform: rotateZ(-45deg);
}
.login input {
	display: block;
	padding: 15px 10px;
	margin-bottom: 10px;
	width: 100%;
	border: 1px solid #ddd;
	transition: border-width 0.2s ease;
	border-radius: 2px;
	color: #ccc;
}
.login input + i.fa {
	color: #fff;
	font-size: 1em;
	position: absolute;
	margin-top: -47px;
	opacity: 0;
	left: 0;
	transition: all 0.1s ease-in;
}
.login input:focus {
	outline: none;
	color: #444;
	border-color: #2196F3;
	border-left-width: 35px;
}
.login input:focus + i.fa {
	opacity: 1;
	left: 30px;
	transition: all 0.25s ease-out;
}
.login a {
	font-size: 13px;
	color: #2196F3;
	text-decoration: none;
}
.login .title {
	color: #444;
	font-size: 17px;
	;
	font-weight: bold;
	margin: 10px 0 30px 0;
	border-bottom: 1px solid #eee;
	padding-bottom: 20px;
	text-align: center;
}
.login button {
	width: 100%;
	height: 100%;
	padding: 10px 10px;
	background: #2196F3;
	color: #fff;
	display: block;
	border: none;
	margin-top: 20px;
	position: absolute;
	left: 0;
	bottom: 0;
	max-height: 60px;
	border: 0px solid rgba(0, 0, 0, 0.1);
	border-radius: 0 0 2px 2px;
	transform: rotateZ(0deg);
	transition: all 0.1s ease-out;
	border-bottom-width: 7px;
}
.login button .spinner {
	display: block;
	width: 40px;
	height: 40px;
	position: absolute;
	border: 4px solid #ffffff;
	border-top-color: rgba(255, 255, 255, 0.3);
	border-radius: 100%;
	left: 50%;
	top: 0;
	opacity: 0;
	margin-left: -20px;
	margin-top: -20px;
	animation: spinner 0.6s infinite linear;
	transition: top 0.3s 0.3s ease, opacity 0.3s 0.3s ease, border-radius 0.3s ease;
	box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.2);
}
.login:not(.loading) button:hover {
	box-shadow: 0px 1px 3px #2196F3;
}
.login:not(.loading) button:focus {
	border-bottom-width: 4px;
}
.abc a {
	width: 49%;
	margin-bottom: 24px;
}
.email img {
	width: 100%;
}
.btn-primary:after {
	background: none;
}
</style>
<script src="<?=URL?>js/prefixfree.min.js"></script>
</head>
<body>
<!-- Loader -->
<div id="page-preloader" style="display: none;"><span class="spinner"></span></div>
<!-- Loader end -->

<div class="layout-theme animated-css" data-header="sticky" data-header-top="200"> 
  
  <!-- Start Switcher --> 
  
  <!-- End Switcher -->
  
  <div id="wrapper"> 
    
    <!-- HEADER -->
     <?php require_once("header.php"); ?>
    <!-- end header -->
    
    <div class="wrapper">
      <form class="login" action="" method="post">
        <p class="title">Log in to Tricky Score with</p>
        <div class="abc" style="text-align:center;">
        <?php
		require_once 'Facebook/autoload.php';
			$fb = new Facebook\Facebook([
	  'app_id' => '666041090229631', // Replace {app-id} with your app id
	  'app_secret' => '2a00fb5635334f4ab004f1a6217ced5f',
	  'default_graph_version' => 'v2.5',
	  ]);

		$helper = $fb->getRedirectLoginHelper();
		
		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl('http://trickyscore.com/fb-callback.php', $permissions);
		
		//$loginUrl = $helper->getLoginUrl(array('redirect_uri' => $_SERVER['SCRIPT_URI']), $permissions);
		
	//	$_SESSION['curr_url'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";  
	  ?> 
        
        <a class="btn btn-primary btn-effect" href="<?=htmlspecialchars($loginUrl)?>"  style="background-color:#3B5998; box-shadow:0 4px 0 0 #2C4373; border-color:#3B5998; color:#fff; font-size:14px; border-radius:0px;">Facebook</a>
         <?php
		  require_once("google-callback.php");
		?>
				
         
         
         
          <div class="email" style="width:100%;"> <img src="<?=URL?>images/email.png"> </div>
        </div>
        <?php
                                    if($msg2!="")
                                    {
                                    ?>
                                    <div class="notification-msg-cont">
                                       
                                        <b>Alert!</b> <?php echo $msg2; ?>
                                    </div>
                                 
                                    <?php
                                    }
                                    ?>

                                     <?php
                                       if (!empty($errors)) {
                                        ?>
                                         <div class="alert alert-danger alert-dismissable">
                                      
                                        <b>Please fix the following errors:</b> <br>
                                             <?php
                                                    foreach ($errors as $error1)
                                                     echo "<div> - ".$error1." </div>";
                                                ?>
                                    </div>
   
                                      <?php
                                         } 
                                         ?>
                                        
                                    <?php
                                    if($msg!="")
                                    {
                                    ?>
                                   <div class="notification-msg-cont">
                                      
                                        <b>Alert!</b> <?php echo $msg; ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
									
    <input type="email" placeholder="Username" autofocus name="email_login" required value="<?=$email?>"  />
    <i class="fa fa-user"></i>
    <input type="password" placeholder="Password" name="password_login" required value="<?=$password?>" />
    <i class="fa fa-key"></i>
	
	 <div class="check">
   <input type="checkbox" name="remember_me" id="remember_me" value="yes" <?php if($_COOKIE["swebin_user"]!="") { ?> checked="checked" <?php } ?> >
   Remember me
   </div>
	
	
    <br /><a href="<?=URL?>signup">Create new account?</a> | <a href="<?=URL?>forgot-password">Forgot your password?</a>
    <button name="Login" type="submit" >
      <i class="spinner"></i>
      <span class="state">Log in</span>
    </button>
	
      </form>

      </p>
    </div>
    
    <!-- end main-content -->
    
     <?php require_once("footer.php"); ?>
  </div>
  <!-- end wrapper --> 
</div>
<!-- end layout-theme --> 

<!-- SCRIPTS --> 
<script src="<?=URL?>js/jquery-migrate-1.2.1.js"></script> 
<script src="<?=URL?>js/bootstrap.min.js"></script> 
<script src="<?=URL?>js/modernizr.custom.js"></script> 
<script src="<?=URL?>js/waypoints.min.js"></script> 
<script src="<?=URL?>js/jquery.easing.min.js"></script> 

<!--THEME--> 
<script src="<?=URL?>js/jquery.isotope.min.js"></script> 
<script src="<?=URL?>js/jquery.prettyPhoto.js"></script> 
<script src="<?=URL?>js/cssua.min.js"></script>
<script src="<?=URL?>js/wow.min.js"></script> 
<script src="<?=URL?>js/custom.min.js"></script> 

<script src="<?=URL?>js/jquery.jelect.js"></script>

<!--login --> 
<!--<script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script> -->
<script src="<?=URL?>js/index.js"></script>
</body>
</html>