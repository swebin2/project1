<?php
require_once "chk_login.php";
$objgen		=	new general();
//echo $objgen->decrypt_pass("de8EsXT2Oxeb+MnBX3JCEQHwRfBDnqey6pDXMDLg0h4=");

$where = " and status='active' and user_id=".$usrid;
$exam_per = $objgen->get_AllRowscnt("exam_permission",$where);
if($exam_per>0)
{
  $per_arr = $objgen->get_AllRows("exam_permission",0,$exam_per,"id asc",$where);
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
      <span class="title"><i class="fa fa-clock-o"></i>Total Exams</span>
      <h3 <?php if($exam_per>0) { ?> class="color-up" <?php } ?>  ><?=$exam_per?></h3>
       </li>
 
    
  </ul>
  </div>
  <!-- End Top Stats -->
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