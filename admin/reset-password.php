<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objval	=   new validate();
$objgen		=	new general();

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "User Created Successfully.";
}

if(isset($_POST['Change']))
{
   $old 		= trim($_POST['old_pwd']);
   $pass 		= trim($_POST['new_pwd']);
   $conf_pass 	= trim($_POST['conf_password']);
   
   $rules		=	array();
   $rules[] 	= "required,old_pwd,Enter the Old Password";
   $rules[] 	= "required,new_pwd,Enter the New Password";
   $rules[] 	= "required,conf_password,Enter the Conf. Password";
   
   $errors  	= $objval->validateFields($_POST, $rules);

	if(empty($errors))
	{
   
	   $msg = $objgen->match_Pass($pass,$conf_pass);
	   if($msg=="")
	   {
		 $msg = $objgen->chng_password('admin','password',$_POST,'admin_id',$_SESSION['MYPR_adm_id']);
		 if($msg=="")
		 {
		   $msg2 = "Password Changed Successfully.";
		 }
	   }
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

  <?php require_once "header-script.php"; ?>
  </head>
  <body>
 <?php require_once "header.php"; ?>

   <?php require_once "menu.php"; ?>


 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title"> Reset Password</h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLAD?>home">Home</a></li>
        <li><a href="javascript:;"> Reset Password</a></li>
      </ol>



  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">

  <div class="row">
    <div class="col-md-12 col-lg-6">
      <div class="panel panel-default">

        <div class="panel-title">
         Reset Password
         
        </div>

            <div class="panel-body">
                <form role="form" action="" method="post" enctype="multipart/form-data" >
                                     <?php
                                    if($msg2!="")
                                    {
                                    ?>
                                    <div class="alert alert-success alert-dismissable">
                                        <i class="fa fa-check"></i>
                                        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
                                        <b>Alert!</b> <?php echo $msg2; ?>
                                    </div>
                                 
                                    <?php
                                    }
                                    ?>

                                     <?php
                                       if (!empty($errors)) {
                                        ?>
                                         <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
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
                                   <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> <?php echo $msg; ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
                <div class="form-group">
                  <label for="input1" class="form-label">Old Password</label>
                     <input type="password" class="form-control" value="<?=$old?>" name="old_pwd"  maxlength="20" required />
                </div>
                <div class="form-group">
                  <label for="input2" class="form-label">New Password</label>
                   <input type="password" class="form-control"  name="new_pwd"  value="<?=$pass?>" required  maxlength="20" />
                </div>
                <div class="form-group">
                  <label for="input3"  class="form-label">Confirm Password</label>
                 <input type="password" class="form-control"  name="conf_password"  value="<?=$conf_pass?>" required  maxlength="20" />
                </div>
                <button class="btn btn-default" type="submit" name="Change"><span class="fa fa-thumbs-o-up"></span>&nbsp;Change</button>

              </form>

            </div>

      </div>
    </div>
  </div>

</div>
<!-- END CONTAINER -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<!-- Start Footer -->
<?php require_once "footer.php"; ?>
<!-- End Footer -->


</div>
<!-- End Content -->
 <!-- //////////////////////////////////////////////////////////////////////////// --> 


<?php require_once "footer-script.php"; ?>


</body>
</html>