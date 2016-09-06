<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		=	new general();
//echo $objgen->decrypt_pass("de8EsXT2Oxeb+MnBX3JCEQHwRfBDnqey6pDXMDLg0h4=");

$vistcnt = 0;

$where 		 = "";

if($_SESSION['MYPR_adm_type']=="vendor")
{
	 $allow_id = array();
	 $exam_id = $_SESSION['MYPR_exam_id'];
	 
	$where2 = " and exam_id=".$exam_id;
	$per_count = $objgen->get_AllRowscnt("exam_permission",$where2);
	if($per_count>0)
	{
	    $per_arr = $objgen->get_AllRows("exam_permission",0,$per_count,"id asc",$where2,"user_id");
		foreach($per_arr as $k=>$v)
		{
			$allow_id[] = $v['user_id'];
		}
	}
	
	if(count($allow_id)>0)
	{
		$where = "and id IN (".implode(',',$allow_id).")";
	}
	else
	{
		$where = "and id=0";
	}

}

$reg_users   = $objgen->get_AllRowscnt("users",$where);
$pay         = 0;


$exams       = $objgen->get_AllRowscnt("exam_list",$where);

if($_SESSION['MYPR_adm_type']=="vendor")
{
	 $allow_id = array();
	 $exam_id = $_SESSION['MYPR_exam_id'];
	 
	$where2 = " and exam_id=".$exam_id;
	$per_count = $objgen->get_AllRowscnt("exam_permission",$where2);
	if($per_count>0)
	{
	    $per_arr = $objgen->get_AllRows("exam_permission",0,$per_count,"id asc",$where2,"order_id");
		foreach($per_arr as $k=>$v)
		{
			$allow_id[] = $v['order_id'];
		}
	}
	
	if(count($allow_id)>0)
	{
		$where = "and order_id IN (".implode(',',$allow_id).")";
	}
	else
	{
		$where = "and order_id=0";
	}

}


$pay_count = $objgen->get_AllRowscnt("payments",$where);
if($pay_count>0)
{
  $pay_arr = $objgen->get_AllRows("payments",0,$pay_count,"id desc",$where);
  foreach($pay_arr as $key=>$val)
  {
	   $pay  += $val['amount'];
  }
}

$where = "";

if($_SESSION['MYPR_adm_type']=="vendor")
{
	$exam_id = $_SESSION['MYPR_exam_id'];
	$where = " and id=".$exam_id;
}

$exam_count = $objgen->get_AllRowscnt("exmas",$where);
if($exam_count>0)
{
  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"id asc",$where);
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

<!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START SIDEBAR -->
   <?php require_once "menu.php"; ?>
<!-- END SIDEBAR -->
<!-- //////////////////////////////////////////////////////////////////////////// --> 

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTENT -->
<div class="content">

  <!-- Start Page Header -->
  <div class="page-header">
    <h1 class="title">Dashboard</h1>
      <ol class="breadcrumb">
        <li class="active">This is a quick overview of some features</li>
    </ol>

    <!-- Start Page Header Right Div -->
  <!--  <div class="right">
      <div class="btn-group" role="group" aria-label="...">
        <a href="index.html" class="btn btn-light">Dashboard</a>
        <a href="#" class="btn btn-light"><i class="fa fa-refresh"></i></a>
        <a href="#" class="btn btn-light"><i class="fa fa-search"></i></a>
        <a href="#" class="btn btn-light" id="topstats"><i class="fa fa-line-chart"></i></a>
      </div>
    </div>-->
    <!-- End Page Header Right Div -->

  </div>
  <!-- End Page Header -->


 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-widget">

  <!-- Start Top Stats -->
  <div class="col-md-12">
  <ul class="topstats clearfix">
    <li class="arrow"></li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-users"></i>Total Students</span>
      <h3 <?php if($reg_users>0) { ?> class="color-up" <?php } ?> ><?=$reg_users?></h3>
<!--      <span class="diff"><b class="color-down"><i class="fa fa-caret-down"></i> 26%</b> from yesterday</span>-->
    </li>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-shopping-cart"></i>Total Payments</span>
      <h3 <?php if($pay>0) { ?> class="color-up" <?php } ?> ><?=$pay?></h3>
       <span class="diff"><b class="color-down">INR</b></span>
      </li>
      <?php
	  if($_SESSION['MYPR_adm_type']=="admin")
		{
	?>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-clock-o"></i>Total Exams</span>
      <h3 <?php if($exams>0) { ?> class="color-up" <?php } ?>  ><?=$exams?></h3>
       </li>
      <?php
		}
		?>
    <li class="col-xs-6 col-lg-3">
      <span class="title"><i class="fa fa-eye"></i>Total Visitors</span>
      <h3 <?php if($vistcnt>0) { ?> class="color-up" <?php } ?> ><?=$vistcnt?></h3>
     </li>
    
  </ul>
  </div>
  
  <br clear="all" />
    <div class="panel panel-widget">
     

      
      <br clear="all" />
      
         <div class="panel-title">
        Packages
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

        <div class="panel-title">
  
           <label for="package<?=$key+1?><?=$key1+1?>"> Package <?=$objgen->check_tag($val1['package_no'])?></label>
              
         
        </div>
         <div class="panel-heading">
           Rs. <?=$objgen->check_tag($val1['amount'])?>
            </div>
        <div class="panel-body">
         <?=$objgen->check_tag($val1['no_of_exam'])?> exams can run, 
         Duration : <?=$objgen->check_tag($val1['period'])?> Days
        </div>

        <div class="panel-footer" style="font-weight:bold;color:#FF9" >No of User Subscribed : <?=$packcpunt?></div>

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