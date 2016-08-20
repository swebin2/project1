<?php
require_once "includes/includepath.php";
require_once "phpmailer/class.phpmailer.php";
$objval	=   new validate();
$objgen		=	new general();

if(isset($_POST['Register']))
{
    $email  	    = $objgen->check_input($_POST['email']);
	$full_name  	= $objgen->check_input($_POST['full_name']);
	$mobile  		= $objgen->check_input($_POST['mobile']);
	$password_conf  = $objgen->check_input($_POST['password_conf']);
	
	$year  			= $_POST['year'];

	$password  		= $_POST['password'];
	$status  		= "active";
	$msg = "";
	
   $randomString = rand(1000000,100000000);

	
	$sh_exit = $objgen->chk_Ext("users","email='$email'");
	if($sh_exit>0)
	{
		$msg = "This email is already exists.";

	}
	


   if($msg=="")
   {

		 $msg = $objgen->ins_Row('users','email,password,status,full_name,mobile,otp,otp_verify',"'".$email."','".$objgen->encrypt_pass($password)."','".$status."','".$full_name."','".$mobile."','".$randomString."','no'");
		 $my_id = $objgen->get_insetId();
		 $_SESSION['my_id'] = $my_id;
		 
		 if($msg=="")
		 {
				$smscontent =  urlencode("Trickyscore OTP : ".$randomString);
				
				 $smsurl = 'http://sms.xeoinfotech.com/httpapi/httpapi?token=7a82967d6b5b3e8e30dbcfca4c26aef9&sender=TRICKY&number='.$mobile.'&route=2&type=1&sms='.$smscontent;
			
				  $ch = curl_init();
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL,$smsurl);
						curl_exec($ch);
						
			
				   $mail = new PHPMailer();
				   
				   $message =  'Dear '.$full_name.',<br /><br />

						Congratulations!!!! <br /><br />
						
						By registering with <a href="http://'.ROOT_PATH.'" >www.trickyscore.com</a>, you have taken a very important step towards achieving your career goals. <br />
						
						We sincerely hope that you would use our platform in the most optimum way to achieve your dreams. <br />
						
						Please do ensure that you take all periodical examinations and customized practice tests in real exam environment. Our performance analysis will help guide you on the areas that you need to focus. <br />
						
						Remember practice makes perfect. <br /> <br />
						
						Thank you & Wish you all success <br />
						
						Team Tricky score';
						
				  					 
					// And the absolute required configurations for sending HTML with attachement
					
					$mail->SetFrom(FROMMAIL, ADMINNAME);
					$mail->AddAddress($email);
					$mail->Subject = "Welcome to ".SITE_NAME;
					$mail->MsgHTML($message);
					$mail->Send();
					
					
					$mail->ClearAllRecipients();
					$mail->Subject =  SITE_NAME." - New Member Registered";
					
					$message = 'New member registered on '.WEBSITE."<br /><br />";
					$message .= 'Name : '.$full_name.'<br />';
					$message .= 'Email : '.$email;
					
					$mail->MsgHTML($message);
					$mail->SetFrom(FROMMAIL, ADMINNAME);
					$mail->AddAddress(ADMINMAIL, "Admin");
					$mail->Send();
                     
					$msg2 = "Registartion Process Completed.";
					 
					 
					$_SESSION['ma_log_id']		=  $my_id;
					$_SESSION['ma_usr_name']	=  $email;
					$_SESSION['ma_name']	    =  $full_name ;

					//header("location:".URL."payment");
					unset($_SESSION['attemptotp']);
					unset($_SESSION['attemptchk']);
					header("location:".URL."verify-otp"); 
					
					//header("location:".URLUR);

			
		 }
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
<link rel="icon" href="<?=URL?>images/favicon.ico" type="image/x-icon">
<link href="<?=URL?>css/master.css" rel="stylesheet">
<link rel="stylesheet" href="<?=URL?>css/main2.css">
<link rel="stylesheet" href="<?=URL?>css/styles.css">
<script src="<?=URL?>js/jquery-1.11.3.min.js"></script>
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
      <form class="login" action="" method="post" >
        <p class="title">Register with us</p>
        <div class="abc" style="text-align:center;"> <a class="btn btn-primary btn-effect" href="https://www.facebook.com/" target="_blank" style="background-color:#3B5998; box-shadow:0 4px 0 0 #2C4373; border-color:#3B5998; color:#fff; font-size:14px; border-radius:0px;">Facebook</a> <a class="btn btn-primary btn-effect" href="https://plus.google.com/" target="_blank" style="background:#e74b37; box-shadow:0 4px 0 0 #C13726; border-color:#e74b37; color:#fff; font-size:14px; border-radius:0px;">Google</a>
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
									
    <input type="text" placeholder="Full Name" autofocus name="full_name" required />
    <i class="fa fa-user"></i>
   
    <input type="text" placeholder="Mobile Number" autofocus name="mobile" id="phone" required  />
    <i class="fa fa-mobile"></i>
    
    <input type="email" placeholder="Email id" autofocus name="email" required  />
    <i class="fa fa-envelope"></i>
    
     <input type="password" placeholder="Password" name="password" id="password" required   />
    <i class="fa fa-key"></i>
    
    <input type="password" placeholder="Confirm Password" name="password" id="password_conf" required  />
    <i class="fa fa-key"></i>
    
    Already have account? <a href="<?=URL?>login">Login</a>
    <button name="Register" type="submit" onClick="return validate();">
      <i class="spinner"></i>
      <span class="state">Register</span>
    </button>
      </form>
      <script>
			 
			   
			   function validate()
			   {
				   var m = $('#phone').val();
				   
				    var p1 = $('#password').val();
				  var p2 = $('#password_conf').val();
				  
				   if(p1.length<8)
				  {
					alert("Enter 8 char password");
					return false;
				  }
				  
				  if(p1!=p2)
				  {
					alert("Password did not match.");
					return false;
				  }
				   
				   var isnum = /^\d+$/.test(m);
				   
					if(isnum==false)
					  {
						alert("Enter digit as Mobile Number.");
						 return false;
					  }
				  
				  if(m.length!=10)
				  {
					alert("Enter 10 digit Mobile Number.");
					return false;
				  }
				  
				 
				  
				 
			   }
			   </script> 
      
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
<script src="<?=URL?>js/index1.js"></script>
</body>
</html>