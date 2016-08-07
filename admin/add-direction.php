<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objval	=   new validate();
$objgen		=	new general();

$pagehead = "Direction";
$list_url = URLAD."direction";
$add_url  = URLAD."add-direction";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Direction Created Successfully.";
}

if(isset($_POST['Create']))
{
   
   $direction_name      = $objgen->check_input($_POST['direction_name']);
   $direction   	    = $_POST['direction'];
	
   $rules		=	array();
   $rules[] 	= "required,direction_name,Enter the Direction Name";
   $errors  	= $objval->validateFields($_POST, $rules);
   
   if(empty($errors))
	{
		 
		 $msg = $objgen->ins_Row('direction','direction_name,direction',"'".$direction_name."','".$objgen->baseencode($direction)."'");
		 if($msg=="")
		 {
			   header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result   			= $objgen->get_Onerow("direction","AND id=".$id);
	   $direction_name      = $objgen->check_tag($result['direction_name']);
	   $direction     		= $objgen->basedecode($result['direction']);
	

}
if(isset($_POST['Update']))
{    
   
   $direction_name      = $objgen->check_input($_POST['direction_name']);
   $direction   	    = $_POST['direction'];
	
	
   $rules		=	array();
   $rules[] 	= "required,direction_name,Enter the Direction Name";
   $errors  	= $objval->validateFields($_POST, $rules);
   
   if(empty($errors))
	{
		 			 
	  $msg = $objgen->upd_Row('direction',"direction_name='".$direction_name."',direction='".$objgen->baseencode($direction)."'","id=".$id);
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
    <div class="col-md-12 col-lg-12">
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
                              
                         <div class="col-md-12">
							 <div class="form-group">
                                <label for="input3"  class="form-label">Direction Name *</label>
                                 <input name="direction_name" id="direction_name" type="text"  class="form-control" value="<?=$direction_name?>" required /> 		
                             </div>
                         </div> 
                         
                         <div class="col-md-12">
							 <div class="form-group">
                                <label for="input3"  class="form-label">Direction *</label>
                               <textarea name="direction" id="direction" cols="" rows="3" class="form-control ckeditor" required ><?=$direction?></textarea>
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

<script type="text/javascript" src="<?=URLAD?>js/ckeditor4/ckeditor.js"></script>
<script type="text/javascript" src="<?=URLAD?>js/ckfinder/ckfinder.js"></script>

<script type="text/javascript">
 $(function() {
			
			var dd=1;
$(".ckeditor").each(function(){

$(this).attr("id","ckeditor"+dd);

var editor = CKEDITOR.replace( 'ckeditor'+dd, {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[  'EqnEditor', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
/*		'/',	*/																				// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
		{ name: 'insert', items: [ 'Image' ] }
	], height: 100});
	
	CKFinder.setupCKEditor( editor, '<?=URLAD?>js/ckfinder' );
	
dd=dd+1;
});
				

});
</script>
</body>
</html>