<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objval	=   new validate();
$objgen		=	new general();

$pagehead = "Coupon";
$list_url = URLAD."list-coupon";
$add_url  = URLAD."add-coupon";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Discount Code Created Successfully.";
}

if(isset($_POST['Create']))
{
   
   $discount_code 	    = $objgen->check_input($_POST['discount_code']);
   $category 	    	= $objgen->check_input($_POST['category']);
   $purpose 	    	= $objgen->check_input($_POST['purpose']);
   $dis_value_pri 	    = $objgen->check_input($_POST['dis_value_pri']);
   $dis_value_per 	    = $objgen->check_input($_POST['dis_value_per']);
   $exp_date 	        = date("Y-m-d",strtotime($_POST['exp_date']));
   $res_amount 	        = $objgen->check_input($_POST['res_amount']);
   $num_cnt 	        = $objgen->check_input($_POST['num_cnt']);
 
	
   $rules		=	array();
   $rules[] 	= "required,discount_code,Enter the Discount Code";
   $rules[] 	= "required,category,Enter the Category";
   $errors  	= $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("discount","discount_code='$discount_code'");
	if($brd_exit>0)
	{
		$errors[] = "This discount code is already exists.";
	}

   if(empty($errors))
	{
		 
		 $msg = $objgen->ins_Row('discount','discount_code,category,purpose,dis_value_pri,dis_value_per,exp_date,res_amount,num_cnt',"'".$discount_code."','".$category."','".$purpose."','".$dis_value_pri."','".$dis_value_per."','".$exp_date."','".$res_amount."','".$num_cnt."'");
		 if($msg=="")
		 {
			   header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result     		  = $objgen->get_Onerow("discount","AND id=".$id);
	   $discount_code     = $objgen->check_tag($result['discount_code']);
	   $category     	  = $objgen->check_tag($result['category']);
	   $purpose    		  = $objgen->check_tag($result['purpose']);
	   $dis_value_pri     = $objgen->check_tag($result['dis_value_pri']);
	   $dis_value_per     = $objgen->check_tag($result['dis_value_per']);
       $exp_date          = date("d-m-Y",strtotime($result['exp_date']));
	   $res_amount        = $objgen->check_tag($result['res_amount']);
	   $num_cnt            = $objgen->check_tag($result['num_cnt']);
 

}
if(isset($_POST['Update']))
{    
  $discount_code 	    = $objgen->check_input($_POST['discount_code']);
   $category 	    	= $objgen->check_input($_POST['category']);
   $purpose 	    	= $objgen->check_input($_POST['purpose']);
   $dis_value_pri 	    = $objgen->check_input($_POST['dis_value_pri']);
   $dis_value_per 	    = $objgen->check_input($_POST['dis_value_per']);
   $exp_date 	        = date("Y-m-d",strtotime($_POST['exp_date']));
   $res_amount 	        = $objgen->check_input($_POST['res_amount']);
   $num_cnt 	        = $objgen->check_input($_POST['num_cnt']);
	
   $rules		=	array();
   $rules[] 	= "required,discount_code,Enter the Discount Code";
   $rules[] 	= "required,category,Enter the Category";
   $errors  	= $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("discount","discount_code='$discount_code' and id<>".$id);
	if($brd_exit>0)
	{
		$errors[] = "This discount code is already exists.";
	}

		
   
   if(empty($errors))
	{
		 			 
	  $msg = $objgen->upd_Row('discount',"discount_code='".$discount_code."',category='".$category."',purpose='".$purpose."',dis_value_pri='".$dis_value_pri."',dis_value_per='".$dis_value_per."',exp_date='".$exp_date."',res_amount='".$res_amount."',num_cnt='".$num_cnt."'","id=".$id);
	  
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
$cat_count = $objgen->get_AllRowscnt("discount_cat",$where);
if($cat_count>0)
{
  $cat_arr = $objgen->get_AllRows("discount_cat",0,$cat_count,"name asc",$where);
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
    <link href="<?=URLAD?>js/datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
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
                              
                         <div class="col-md-6">
							 <div class="form-group">
                                <label for="input3"  class="form-label">Discount Code *</label>
                                 <input type="text" class="form-control" value="<?=$discount_code?>" name="discount_code"  maxlength="100" required />	
                             </div>
                     
                         
                      
							 <div class="form-group">
                                <label for="input3"  class="form-label">Category *</label>
                              <select class="form-control" name="category" required >
												<option value="">Select</option>
												<?php
												if($cat_count>0)
												{
													foreach($cat_arr as $key=>$val)
													{
												?>
                                                <option value="<?=$val['id']?>" <?php if($val['id']==$category) { ?> selected="selected" <?php } ?> ><?=$objgen->check_tag($val['name']);?></option>
												<?php
													}
												}
												?>
                                             </select>
											 <a href="<?=URLAD?>list-coupon-cat.php" >Add Category</a>
                              </div>
                      
                         
                           
                          <div class="form-group" >
                                           <label>Purpose</label>
                                            <textarea name="purpose" cols="" rows=""  class="form-control" ><?=$purpose?></textarea>
                                        </div>
						
                        
                            <div class="form-group" >
										 <label>Discount Value</label>	
										 <br clear="all">
										 <div class="col-xs-4">
										<div class="input-group">
                                          <span class="input-group-addon">&#8377; </span><input type="text" class="form-control" value="<?=$dis_value_pri?>" name="dis_value_pri" placeholder="Price Value"  />
											 </div>
											 
											 </div>
										<div class="col-xs-1">or</div>
											
											<div class="col-xs-4">
											<div class="input-group">
												<input type="text" class="form-control" value="<?=$dis_value_per?>" name="dis_value_per" placeholder="Percentage"  />  <span class="input-group-addon">%</span> </div>
                                        </div>
										</div>
                                        
                            
                                         <br clear="all">  <br clear="all">
                                         
                                              
										    <div class="form-group" >
                                            <label>Expiry Date</label>
                                            <input type="text" class="form-control" value="<?=$exp_date?>" name="exp_date" id="exp_date"  />
                                        </div>
								
                                        
                           
										   <div class="form-group" >
                                            <label>Restriction Amount</label>
                                            <div class="input-group">
                                          <span class="input-group-addon">&#8377; </span><input type="text" class="form-control" value="<?=$res_amount?>" name="res_amount"   />
										  </div> 
										  
                                        </div>
								
                                        
                     
										<div class="form-group" >
                                            <label>Number of Coupons</label>
                                           
                                          <input type="text" class="form-control" value="<?=$num_cnt?>" name="num_cnt"   />
										
										  
                                        </div>
                                        </div>
										
										 <br clear="all">			
        				
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

<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script src="<?=URLAD?>js/datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
		<script>
		$('#exp_date').datepicker({ format: 'dd-mm-yyyy' });
		  $('#exp_date').on('changeDate', function(ev){
				$(this).datepicker('hide');
			});
		</script>
   </body>
</html>