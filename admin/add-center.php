<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objval	=   new validate();
$objgen		=	new general();

$pagehead = "Center";
$list_url = URLAD."list-center";
$add_url  = URLAD."add-center";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Center Created Successfully.";
}

if($_GET['msg']==3)
{
  $msg2 = "Logo Deleted Successfully.";
}


if(isset($_GET['delimg']))
{
     $id      = $_GET['delimg'];

	 $result     		= $objgen->get_Onerow("center","AND id=".$id);
	 $photo     		= $objgen->check_tag($result['photo']);
   
   	 if(file_exists("../photos/orginal/".stripslashes($photo)))
		unlink("../photos/orginal/".stripslashes($photo));
     
	if(file_exists("../photos/medium/".stripslashes($photo)))
	 	unlink("../photos/medium/".stripslashes($photo));
			
	 if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	
	 if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));

	 $msg     = $objgen->upd_Row("center","photo=''","id=".$id);
	 
	
	 if($msg=="")
	 {
		header("location:".URLAD."add-center/?msg=3&edit=".$edit."&page=".$page);
	 }
}


if(isset($_POST['Create']))
{
   
   $username   	    = $objgen->check_input($_POST['username']);
   $password   	    = trim($_POST['password']);
   $conf_password   = trim($_POST['conf_password']);
   $center_name   	= $objgen->check_input($_POST['center_name']);
   $email   		= $objgen->check_input($_POST['email']);
   $phone   		= $objgen->check_input($_POST['phone']);
	
   $rules		=	array();
   $rules[] 	= "required,username,Enter the Username";
   $rules[] 	= "required,password,Enter the Password";
  
   $errors  	= $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("center","username='$username'");
	if($brd_exit>0)
	{
		$errors[] = "This center is already exists.";
	}
	
	$msg = $objgen->match_Pass($password,$conf_password);

   if(empty($errors) && $msg=="")
	{
		
		if($_FILES["photo"]["name"]!="" && empty($errors))
		{
			 $upload = $objgen->upload_resize("photo","center","image",array('l','m','s'),"null","",array(500,500,'auto'),array(250,250,'crop'),array(64,64,'crop'));
			  if($upload[1]!="")
				$errors[] = $upload[1];
			  else
				$photo = $upload[0];
		}
		 
		 $msg = $objgen->ins_Row('center','username,password,center_name,email,phone,photo',"'".$username."','".$objgen->encrypt_pass($password)."','".$center_name."','".$email."','".$phone."','".$photo."'");
		 
		 if($msg=="")
		 {
			   header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result     		= $objgen->get_Onerow("center","AND id=".$id);
	   $username     	= $objgen->check_tag($result['username']);
       $center_name     = $objgen->check_tag($result['center_name']);
	   $email		    = $objgen->check_tag($result['email']);
	   $password    	= $objgen->decrypt_pass($result['password']);
	   $conf_password   = $objgen->decrypt_pass($result['password']);
	   $phone   	    = $objgen->check_tag($result['phone']);
	   $photo   	    = $objgen->check_tag($result['photo']);
}

if(isset($_POST['Update']))
{    
   $username   	    = $objgen->check_input($_POST['username']);
   $password   	    = trim($_POST['password']);
   $conf_password   = trim($_POST['conf_password']);
   $center_name   	= $objgen->check_input($_POST['center_name']);
   $email   		= $objgen->check_input($_POST['email']);
   $phone   		= $objgen->check_input($_POST['phone']);
	
   $rules		=	array();
   $errors      = array();
   $rules[] 	= "required,username,Enter the Username";
   $rules[] 	= "required,password,Enter the Password";
   
   $errors  	= $objval->validateFields($_POST, $rules);
   
	$brd_exit = $objgen->chk_Ext("center","username='$username' and id<>".$id);
	if($brd_exit>0)
	{
		$errors[] = "This center is already exists.";
	}
	
   	$msg = $objgen->match_Pass($password,$conf_password);
   if(empty($errors) && $msg=="")
	{
		
		if($_FILES["photo"]["name"]!="" && empty($errors))
		{
			 $upload = $objgen->upload_resize("photo","center","image",array('l','m','s'),$photo,"",array(500,500,'auto'),array(250,250,'crop'),array(64,64,'crop'));
			  if($upload[1]!="")
				$errors[] = $upload[1];
			  else
				$photo = $upload[0];
		}
		
		 			 
	  $msg = $objgen->upd_Row('center',"username='".$username."',password='".$objgen->encrypt_pass($password)."',center_name='".$center_name."',email='".$email."',phone='".$phone."',photo='".$photo."'","id=".$id);
	  
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
				     <input type="text" class="form-control" value="<?=$username?>" name="username"   required />
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
                  <label for="input1" class="form-label">Center Name *</label>
				     <input type="text" class="form-control" value="<?=$center_name?>" name="center_name"   required />
                 </div>
				 <div class="form-group">
                  <label for="input1" class="form-label">Email</label>
				     <input type="text" class="form-control" value="<?=$email?>" name="email"    />
                 </div>
                  <div class="form-group">
                  <label for="input1" class="form-label">Phone</label>
				     <input type="text" class="form-control" value="<?=$phone?>" name="phone"    />
                 </div>
                  <div class="form-group">
                  <label for="input1" class="form-label">Logo</label>
				     <input type="file"  name="photo" id="photo"    />
                     
                     <div style="padding-top:10px;">
                 <div id="imagePreview"></div>
											
											<?php
											if($photo!="")
											{
											?>
											<p class="help-block"><img src="<?=URL?>photos/small/<?php echo $photo; ?>"   />&nbsp;&nbsp;<a href="<?=URLAD?>edit-center/?delimg=<?=$id?>" role="button" onClick="return confirm('Do you want to delete this Logo?')"><span class="fa fa-trash-o"></span></a></p>
											<?php
											}
											?>
                              
                </div>
                
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
<script type="text/javascript">
		$(function() {
			$("#photo").on("change", function()
			{
	
				var files = !!this.files ? this.files : [];
				if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
		
				if (/^image/.test( files[0].type)){ // only image file
					var reader = new FileReader(); // instance of the FileReader
					reader.readAsDataURL(files[0]); // read the local file
		
					reader.onloadend = function(){ // set image data as background of div
					    $("#imagePreview").css("width", "64px");
						$("#imagePreview").css("height", "64px");
						$("#imagePreview").css(" background-position", "center center");
   						 $("#imagePreview").css("background-size",  "cover");
						$("#imagePreview").css("display",  "inline-block");
						$("#imagePreview").css("background-image", "url("+this.result+")");
					}
				}
			});
		});
		</script>

</body>
</html>