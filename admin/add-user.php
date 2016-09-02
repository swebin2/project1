<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objval	=   new validate();
$objgen		=	new general();

$pagehead = "User";
$list_url = URLAD."list-users";
$add_url  = URLAD."add-user";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "User Created Successfully.";
}

if(isset($_POST['Create']))
{
   
   $username   	    = $objgen->check_input($_POST['username']);
   $user_type   	= $objgen->check_input3($_POST['user_type']);
   $password   	    = trim($_POST['password']);
   $conf_password   = trim($_POST['conf_password']);
   $exam_id   	    = $objgen->check_input($_POST['exam_id']);
	
   $rules		=	array();
   $rules[] 	= "required,username,Enter the Username";
   $rules[] 	= "required,password,Enter the Password";
   if($user_type=="vendor")
   {
  	 $rules[] 	= "required,exam_id,Enter the Exam";
   }
   
   $errors  	= $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("admin","username='$username'");
	if($brd_exit>0)
	{
		$errors[] = "This user is already exists.";
	}
	
	$msg = $objgen->match_Pass($password,$conf_password);

   if(empty($errors) && $msg=="")
	{
		 
		 $msg = $objgen->ins_Row('admin','username,password,user_type,exam_id',"'".$username."','".$objgen->encrypt_pass($password)."','".$user_type."','".$exam_id."'");
		 if($msg=="")
		 {
			   header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result     		= $objgen->get_Onerow("admin","AND admin_id=".$id);
	   $username     	= $objgen->check_tag($result['username']);
       $user_type     	= $objgen->check_tag($result['user_type']);
	   $password    	= $objgen->decrypt_pass($result['password']);
	   $conf_password   = $objgen->decrypt_pass($result['password']);
	   $exam_id   	    = $objgen->check_tag($result['exam_id']);


}
if(isset($_POST['Update']))
{    
   $username   	    = $objgen->check_input($_POST['username']);
   $user_type   	= $objgen->check_input3($_POST['user_type']);
   $password   	    = trim($_POST['password']);
    $conf_password   = trim($_POST['conf_password']);
    $exam_id   	    = $objgen->check_input($_POST['exam_id']);
	
	$brd_exit = $objgen->chk_Ext("admin","username='$username' and admin_id<>".$id);
	if($brd_exit>0)
	{
		$errors[] = "This user is already exists.";
	}
	
   $errors = array();
   $rules		=	array();
   $rules[] 	= "required,username,Enter the Username";
   if($user_type=="vendor")
   {
  	 $rules[] 	= "required,exam_id,Enter the Exam";
   }
   $rules[] 	= "required,password,Enter the Password";
   $errors  	= $objval->validateFields($_POST, $rules);
  
   	$msg = $objgen->match_Pass($password,$conf_password);
   if(empty($errors) && $msg=="")
	{
		 			 
	  $msg = $objgen->upd_Row('admin',"username='".$username."',password='".$objgen->encrypt_pass($password)."',user_type='".$user_type."',exam_id='".$exam_id."'","admin_id=".$id);
	  if($msg=="")
	  {
		  header("location:".$list_url."/?msg=2&page=".$page);
	  }
	  
	}
}
if(isset($_POST['Cancel']))
{
	 header("location:".$list_url);

}

$where = "";
$exam_count = $objgen->get_AllRowscnt("exmas",$where);
if($exam_count>0)
{
  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"exam_name asc",$where);
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
    <h1 class="title"><?php if(isset($_GET['edit'])){ echo "Edit"; } else { echo "Add";  } ?> <?=$pagehead?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLAD?>home">Home</a></li>
        <li><a href="javascript:;"> <?php if(isset($_GET['edit'])){ echo "Edit"; } else { echo "Add";  } ?> <?=$pagehead?></a></li>
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
        Enter <?=$pagehead?> Informations
         
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
                  <label for="input1" class="form-label">Username *</label>
				     <input type="text" class="form-control" value="<?=$username?>" name="username"  maxlength="20" required />
                </div>
                <div class="form-group">
                  <label for="input2" class="form-label">Password *</label>
                     <input type="password" class="form-control"  name="password" id="exampleInputPassword1" value="<?=$password?>" required  maxlength="20" />
                </div>
                
                 <div class="form-group">
                  <label for="input3"  class="form-label">Confirm Password *</label>
                 <input type="password" class="form-control"  name="conf_password"  value="<?=$conf_password?>" required  maxlength="20" />
                </div>
                <div class="form-group">
                  <label for="input3"  class="form-label">User Type *</label>
                  <select class="form-control" name="user_type" required >
				                                <option value="" selected="selected">Select</option>
                                                <option value="vendor" <?php if($user_type=='vendor') { ?> selected="selected" <?php } ?> >Vendor</option>
                                                <option value="staff" <?php if($user_type=='staff') { ?> selected="selected" <?php } ?> >Staff</option>
                                                <option value="admin" <?php if($user_type=='admin') { ?> selected="selected" <?php } ?> >Admin</option>
                                            </select>
                </div>
                  <div class="form-group">
										  <label for="input3"  class="form-label">Exam</label>
										  <select class="form-control" name="exam_id">
											<option value="" selected="selected">Select</option>
											<?php
											if($exam_count>0)
											{
											 foreach($exam_arr as $key=>$val)
											 {
											?>
											<option value="<?=$val['id']?>" <?php if($exam_id==$val['id']) { ?> selected="selected" <?php } ?> ><?=$objgen->check_tag($val['exam_name'])?></option>
											<?php
											  }
											}
											?>
										</select>
										</div>
				
				   <?php
                                            if(isset($_GET['edit']))
                                            {
                                            ?>
                                            <button class="btn btn-default" type="submit" name="Update"><span class="fa fa-thumbs-o-up"></span>&nbsp;Update</button>
                                      
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <button type="submit" class="btn btn-default" name="Create"><span class="fa fa-save"></span>&nbsp;Save</button>
                                         
                                         <?php
                                            }
                                            ?>
										<button class="btn btn-danger" type="button" name="Cancel" onClick="window.location='<?=$list_url?>'"><span class="fa fa-undo"></span>&nbsp;Cancel</button>
										
    

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