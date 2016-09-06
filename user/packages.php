<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen		=	new general();


$where = "";
$exam_count = $objgen->get_AllRowscnt("exmas",$where);
if($exam_count>0)
{
  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"id asc",$where);
}

$where = " and status='active' and user_id=".$usrid;
$exam_per = $objgen->get_AllRowscnt("exam_permission",$where);
if($exam_per>0)
{
  $per_arr = $objgen->get_AllRows("exam_permission",0,$exam_per,"id asc",$where);
}


if(isset($_POST['Buy']))
{
	
$tot_val = $_POST['tot_val'];
$_SESSION['payamnt'][$usrid]  = $tot_val;

$sel_pkgarr = array();

if($exam_count>0)
{
	 foreach($exam_arr as $key=>$val)
	 {
		 $pkg_id = 0;
		 $exam_id = $val['id']; 
		 $radio_chk = $_POST['package'.$exam_id];
		 $pkg_id    = explode("::",$radio_chk);
		 
		 if($_POST['package'.$exam_id]!="")
		 {
		   $sel_pkgarr[$exam_id] = $pkg_id[1];
		 }
	 }
}

$_SESSION['packages'][$usrid] = $sel_pkgarr;

//echo $_SESSION['payamnt'][$usrid];
//print_r($_SESSION['packages'][$usrid]);

if(!empty($sel_pkgarr))
{			 
header("location:".URL."payment");
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
    <h1 class="title">Buy Packages</h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLUR?>home">Home</a></li>
        <li><a href="javascript:;"> Buy Packages</a></li>
      </ol>



  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">

  <div class="row">
  
      <div class="col-md-12 col-lg-12">
      
   
      
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
      
      <form name=""  action="" method="post" >                             
      <div class="panel panel-widget">
     

        <?php
		if($exam_per>0)
		{
			?>
                  <div class="panel-title">Packages Subscribed</div>
                     <div class="col-md-12 col-lg-12">
              <?php
			foreach($per_arr as $key=>$val)
			{
			    $exam   	= $objgen->get_Onerow("exmas","AND id=".$val['exam_id']);
				$package    = $objgen->get_Onerow("exam_package","AND id=".$val['package_id']);								  
          ?>
          <div class="col-md-6 col-lg-4">
           <div class="panel panel-info">
           
           
            <div class="panel-title"><?=$objgen->check_tag($exam['exam_name'])?> <br /> Package <?=$objgen->check_tag($package['package_no'])?></div>
      <div class="panel-body">
      
          <div style="font-weight:bold">No. of Exams : <?=$objgen->check_tag($package['no_of_exam'])?></div>
          <div style="font-weight:bold">No. of Exams Completed : <?=$objgen->check_tag($val['exam_complete'])?></div>
          
          </div>
          
          <div class="panel-footer" style="font-weight:bold;color:#FF9">Purchase Date : <?=date("jS M Y",strtotime($val['per_date']))?><br />Expiry Date : <?=date("jS M Y",strtotime($val['exp_date']))?></div>
          </div>
          </div>
         <?php
			 }
			?>
              </div>
         <?php
		}
		?>
        
       
     

      
     <br clear="all" />
      
         <div class="panel-title">
        You can choose multiple exams
       </div>
  <!-- End Top Stats -->
  <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
    <?php
		if($exam_count>0)
		{
			foreach($exam_arr as $key=>$val)
			{
				$cl ="";
				if($key==0)
				 $cl = "in";
	?>
    <!--<div class="panel panel-default">-->
  <div class="">
    <div class="panel-heading" role="tab" id="heading<?=$key?>" style="padding:0px;">
    
      
         <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$key?>" aria-expanded="true" aria-controls="collapseOne">
         <div class="kode-alert alert1">
          <label  style="font-size:24px">  <?=$key+1?>. <?=$objgen->check_tag($val['exam_name'])?> </label>
          </div>
         </a>
      

    </div>
    <div id="collapse<?=$key?>" class="panel-collapse collapse <?=$cl?>" role="tabpanel" aria-labelledby="heading<?=$key?>">
      <div class="panel-body" style="border:none">
      <?php
		
			$where = " and exam_id=".$val['id'];
			$pkg_count = $objgen->get_AllRowscnt("exam_package",$where);
			if($pkg_count>0)
			{
 			   $pkg_arr = $objgen->get_AllRows("exam_package",0,$pkg_count,"id asc",$where);


				 foreach($pkg_arr as $key1=>$val1)
				 {
					 $class = "panel-success";
					 
					 if($val1['package_no']==2)
					 {
					 	$class = "panel-warning";
					 }
					 if($val1['package_no']==3)
					 {
					 	$class = "panel-danger";
					 }
					 if($val1['package_no']==1)
					 {
					 	$class = "panel-success";
					 }
					 
					 $packcpunt = $objgen->get_AllRowscnt("exam_permission"," and package_id='".$val1['id']."' and status='active'");
											  
                 ?>
      <div class="col-md-6 col-lg-4">
      <div class="panel <?=$class?>">

        <div class="radio radio-inline">
         <input type="radio" name="package<?=$val['id']?>" value="<?=$objgen->check_tag($val1['amount'])?>::<?=$val1['id']?>" id="package<?=$key+1?><?=$key1+1?>" onClick="show_amount()" class="rbl">
           <label for="package<?=$key+1?><?=$key1+1?>"> Package <?=$objgen->check_tag($val1['package_no'])?></label>
        </div>
       
         <div class="panel-heading">
           Rs. <?=$objgen->check_tag($val1['amount'])?>
            </div>
        <div class="panel-body">
         <?=$objgen->check_tag($val1['no_of_exam'])?> exams can run, 
         Duration : <?=$objgen->check_tag($val1['period'])?> Days
        </div>

      
      </div>
    </div>
     <?php
	 
				 }
				}
			?>
      </div>
    </div>
  </div>
  <?php
			}
		}
  ?>

  </div>

      
   
      	
        <div align="center" >
        <div style="font-size:16px" id="tot_amount"></div>
        <input name="tot_val" id="tot_val" type="hidden" value="" >
        <button class="btn btn-danger" type="submit" name="Buy"  ><span class="fa fa-shopping-cart"></span>&nbsp;Buy Now</button>
        </div>
        
      </div>
      
      </form>
      
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
<script type="text/javascript" src="<?=URLUR?>js/datatables/datatables.min.js"></script>
<script>
function show_amount()
{
	
	//var hidval = $('#tot_val').val();
	//var amntval = parseInt(hidval)+parseInt(amnt);
	
    var amntval = 0;
 $('input:radio:checked').each(function() {
     
          //   console.log( $(this).val() );
		  var each_amount = $(this).val();
		  var amntsplit = each_amount.split("::"); 
		  amntval = parseInt(amntval)+parseInt(amntsplit[0]);
       
    });

	$('#tot_amount').html('Rs. '+amntval);
    $('#tot_val').val(amntval);
}
</script>
</body>
</html>