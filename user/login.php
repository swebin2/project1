<?php
$objgen		=	new general();

if($_COOKIE["swebin_user_ad"]!="")
$username = $_COOKIE["swebin_user_ad"];

if($_COOKIE["swebin_sec_ad"]!="")
$password = $objgen->decrypt_pass($_COOKIE["swebin_sec_ad"]);


if(isset($_POST['Login']))
{
   $email 		= trim($_POST['username']);
   $password 	= trim($_POST['password']);
   $remember_me = $_POST['remember_me'];
  
  if($email!="" && $password!="")
  {
	
	  
	  $msg = $objgen->chk_Login('users',$email,$password,'','id','email','password','active',0,'*',$remember_me);
	  if($msg=="")
	  {
		
		//header("location:".URL."payment");
		header("location:".URLUR);
			
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
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo TITLE; ?></title>

  <!-- ========== Css Files ========== -->
  <link href="<?=URLAD?>css/root.css" rel="stylesheet">
  <style type="text/css">
    body{background: #F5F5F5;}
  </style>
  </head>
  <body>

    <div class="login-form">
      <form action="" method="post">
        <div class="top">
       <!--   <img src="img/kode-icon.png" alt="icon" class="icon">-->
          <h1>Login</h1>
<!--          <h4>Bootstrap Admin Template</h4>-->
  <?php
				if($msg!="")
				{
				?>
				      <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> <?php echo $msg; ?>
                                    </div>
				 
				<?php
				}
				?>
        </div>
        <div class="form-area">
          <div class="group">
            <input type="text" name="username" class="form-control" placeholder="Username" required maxlength="20" value="<?=$username?>"  />
            <i class="fa fa-user"></i>
          </div>
          <div class="group">
            <input type="password" name="password" class="form-control" placeholder="Password" required maxlength="20" value="<?=$password?>" />
            <i class="fa fa-key"></i>
          </div>
          <div class="checkbox checkbox-primary">
              <input type="checkbox" name="remember_me" id="remember_me" value="yes" <?php if($_COOKIE["swebin_user_ad"]!="") { ?> checked="checked" <?php } ?> /> 
            <label for="checkbox101"> Remember Me</label>
          </div>
          <button type="submit" class="btn btn-default btn-block" name="Login">LOGIN</button>
        </div>
      </form>
     <!-- <div class="footer-links row">
        <div class="col-xs-6"><a href="#"><i class="fa fa-external-link"></i> Register Now</a></div>
        <div class="col-xs-6 text-right"><a href="#"><i class="fa fa-lock"></i> Forgot password</a></div>
      </div>-->
    </div>

</body>
</html>