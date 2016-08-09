<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objval	=   new validate();
$objgen		=	new general();

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "User Edited Successfully.";
  
}

if($_GET['msg']==3)
{
  $msg2 = "Photo Delted Successfully.";
}


if(isset($_GET['delimg']))
{
     $id      = $_GET['delimg'];

	 $result     		= $objgen->get_Onerow("users","AND id=".$usrid);
	 $photo     		= $objgen->check_tag($result['photo']);
   
   	 if(file_exists("../photos/orginal/".stripslashes($photo)))
		unlink("../photos/orginal/".stripslashes($photo));
     
	if(file_exists("../photos/medium/".stripslashes($photo)))
	 	unlink("../photos/medium/".stripslashes($photo));
			
	 if(file_exists("../photos/small/".stripslashes($photo)))
	 	unlink("../photos/small/".stripslashes($photo));
	
	 if(file_exists("../photos/large/".stripslashes($photo)))
	 	unlink("../photos/large/".stripslashes($photo));

	 $msg     = $objgen->upd_Row("users","photo=''","id=".$usrid);
	 
	
	 if($msg=="")
	 {
		header("location:edit-profile/?msg=3&edit=".$edit."&page=".$page);
	 }
}



$result     	= $objgen->get_Onerow("users","AND id=".$usrid);
$full_name     	= $objgen->check_tag($result['full_name']);
$email     		= $objgen->check_tag($result['email']);
$photo     		= $objgen->check_tag($result['photo']);

if(isset($_POST['Change']))
{
    
	$full_name    = $objgen->check_input($_POST['full_name']);
	$email   	  = $objgen->check_input($_POST['email']);
	
	
    $_SESSION['ma_name'] = $full_name;
	
	$brd_exit = $objgen->chk_Ext("users","email='$email' and id<>".$usrid);
	if($brd_exit>0)
	{
		$errors[] = "This email is already exists.";
	}
	
   $errors = array();
   $rules		=	array();
   $rules[] 	= "required,full_name,Enter the Name";
   $errors  	= $objval->validateFields($_POST, $rules);

   if(empty($errors))
	{
		if($_FILES["photo"]["name"]!="" && empty($errors))
		{
			 $upload = $objgen->upload_resize("photo","tricky","image",array('l','m','s'),$photo,"",array(500,500,'auto'),array(250,250,'crop'),array(64,64,'crop'));
			  if($upload[1]!="")
				$errors[] = $upload[1];
			  else
				$photo = $upload[0];
		}
				 
		 			 
	  $msg = $objgen->upd_Row('users',"full_name='".$full_name."',email='".$email."',photo='".$photo."'","id=".$usrid);
	  if($msg=="")
	  {
		  header("location:edit-profile/?msg=1&page=".$page);
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
    <h1 class="title"> Edit Profile</h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLUR?>home">Home</a></li>
        <li><a href="javascript:;">  Edit Profile</a></li>
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
         Edit Profile
         
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
                  <label for="input1" class="form-label">Name</label>
                     <input type="text" class="form-control" value="<?=$full_name?>" name="full_name"  required />
                </div>
                <div class="form-group">
                  <label for="input2" class="form-label">Email</label>
                   <input type="email" class="form-control"  name="email"  value="<?=$email?>" required />
                </div>
                <div class="form-group">
                  <label for="input3"  class="form-label">Photo</label>
                 <input name="photo" id="photo"  type="file">
                 <div style="padding-top:10px;">
                 <div id="imagePreview"></div>
											
											<?php
											if($photo!="")
											{
											?>
											<p class="help-block"><img src="<?=URL?>photos/small/<?php echo $photo; ?>"   />&nbsp;&nbsp;<a href="<?=URLUR?>edit-profile/?delimg=<?=$id?>" role="button" onClick="return confirm('Do you want to delete this Image?')"><span class="fa fa-trash-o"></span></a></p>
											<?php
											}
											?>
                              
                </div>
                </div>
                <button class="btn btn-default" type="submit" name="Change"><span class="fa fa-thumbs-o-up"></span>&nbsp;Save</button>

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