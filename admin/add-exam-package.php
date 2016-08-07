<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objval	=   new validate();
$objgen		=	new general();

$pagehead = "Exam Package";
$list_url = URLAD."exam-package";
$add_url  = URLAD."add-exam-package";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Package Created Successfully.";
}

if(isset($_POST['Create']))
{
   
   $exam_id	 		= $objgen->check_input($_POST['exam_id']);
   $package_no	 	= $objgen->check_input($_POST['package_no']);
   $amount	 		= $objgen->check_input($_POST['amount']);
   $no_of_exam 	    = $objgen->check_input($_POST['no_of_exam']);
	
   $rules		=	array();
   $rules[] 	= "required,amount,Enter the Amount";
   $errors  	= $objval->validateFields($_POST, $rules);
   
   $brd_exit = $objgen->chk_Ext("exam_package","exam_id='$exam_id' and package_no=$package_no");
	if($brd_exit>0)
	{
		$errors[] = "This package is already exists.";
	}

   if(empty($errors))
	{
		 
		 $msg = $objgen->ins_Row('exam_package','package_no,exam_id,amount,no_of_exam',"'".$package_no."','".$exam_id."','".$amount."','".$no_of_exam."'");
		 if($msg=="")
		 {
			   header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result   		= $objgen->get_Onerow("exam_package","AND id=".$id);
	   $package_no     	= $objgen->check_tag($result['package_no']);
	   $exam_id  		= $objgen->check_tag($result['exam_id']);
	   $amount    		= $objgen->check_tag($result['amount']);
	   $no_of_exam      = $objgen->check_tag($result['no_of_exam']);

}
if(isset($_POST['Update']))
{    
   $exam_id	 		= $objgen->check_input($_POST['exam_id']);
   $package_no	 	= $objgen->check_input($_POST['package_no']);
   $amount	 		= $objgen->check_input($_POST['amount']);
   $no_of_exam	    = $objgen->check_input($_POST['no_of_exam']);
   
   $rules		=	array();
   $rules[] 	= "required,amount,Enter the Amount";
   $errors  	= $objval->validateFields($_POST, $rules);
   
   $brd_exit = $objgen->chk_Ext("exam_package","exam_id='$exam_id' and package_no=$package_no and id<>$id");
	if($brd_exit>0)
	{
		$errors[] = "This package is already exists.";
	}
	
   if(empty($errors))
	{
		 			 
	  $msg = $objgen->upd_Row('exam_package',"exam_id='".$exam_id."',package_no='".$package_no."',amount='".$amount."',no_of_exam='".$no_of_exam."'","id=".$id);
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
									  <label for="input1" class="form-label">Package *</label>
									   <select class="form-control" name="package_no" required >
											<option value="" selected="selected">Select</option>
									
											<option value="1" <?php if($package_no==1) { ?> selected="selected" <?php } ?> >Package 1</option>
                                            <option value="2" <?php if($package_no==2) { ?> selected="selected" <?php } ?> >Package 2</option>
                                            <option value="3" <?php if($package_no==3) { ?> selected="selected" <?php } ?> >Package 3</option>
											
										</select>
									</div>
									  <div class="form-group">
										  <label for="input3"  class="form-label">Exam *</label>
										  <select class="form-control" name="exam_id" required >
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
                                        
                                    <div class="form-group">
									    <label for="input1" class="form-label">No. of Exam *</label>
										<input type="text" class="form-control" value="<?=$no_of_exam?>" name="no_of_exam"  required />
									</div>
                                    
                                      <div class="form-group">
									  <label for="input1" class="form-label">Amount (INR) *</label>
										<input type="text" class="form-control" value="<?=$amount?>" name="amount"  required />
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