<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen		=	new general();
		
$row_count 		= 0;
$row_count2 	= 0;
$row_count3 	= 0;
$row_count4 	= 0;
$exam_ok		= array();

// Public Exams Start
$where = " and exam_id=0 and exam_assign='link' and avaibility='always'";
$row_count2 = $objgen->get_AllRowscnt("exam_list",$where);
if($row_count2>0)
{
  $res_arr2 = $objgen->get_AllRows("exam_list",0,$row_count2,"id desc",$where);
}
// Public Exams End

// Public Exams Specific
$where = " and exam_id=0 and exam_assign='link' and avaibility='specific' and start_date <= now() and end_date>=now()";
$row_count3 = $objgen->get_AllRowscnt("exam_list",$where);
if($row_count3>0)
{
  $res_arr3 = $objgen->get_AllRows("exam_list",0,$row_count3,"id desc",$where);
}
// Public Exams Specific End

// Private Exams 
$where = " and status='active' and user_id=".$usrid;
$exam_per = $objgen->get_AllRowscnt("exam_permission",$where);
if($exam_per>0)
{
  
   $per_arr = $objgen->get_AllRows("exam_permission",0,$exam_per,"id asc",$where);

	foreach($per_arr as $key=>$val)
	{
		$exam_ok[] = $val['exam_id'];
	}
	
   
 // Private Exams Specific
	
	$where = " and exam_id in ( ".implode(",",$exam_ok).")  and avaibility='specific' and start_date <= now() and end_date>=now()";
	$row_count4 = $objgen->get_AllRowscnt("exam_list",$where);
	if($row_count4>0)
	{
	  $res_arr4 = $objgen->get_AllRows("exam_list",0,$row_count4,"id desc",$where);
	}

// Private Exams Specific End

// Private Exams Start

	$where = " and exam_id in ( ".implode(",",$exam_ok).") and avaibility='always'";
	$row_count = $objgen->get_AllRowscnt("exam_list",$where);
	if($row_count>0)
	{
	  $res_arr = $objgen->get_AllRows("exam_list",0,$row_count,"id desc",$where);
	}

}
// Private Exams End

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
    <h1 class="title">Exams </h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLUR?>home">Home</a></li>
        <li><a href="javascript:;"> Exams</a></li>
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
                                    
      <div class="panel panel-widget">
      
      
       <h3>Special Exams <span class="label label-info"><?=$row_count3+$row_count4?></span></h3>

        <div class="panel-body table-responsive">

          <table class="table table-hover">
            <thead>
              <tr>
                <td>ID</td>
                <td>Exam</td>
                <td>Available (From - To)</td>
                <td>Duration</td>
                <td>Questions</td>
                <td>Start</td>
              </tr>
            </thead>
            <tbody>
            	<?php
				if($row_count3>0)
				{
				 foreach($res_arr3 as $key=>$val)
				 {
			  
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['id']); ?></td>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo date("j M Y h:i A",strtotime($val['start_date'])); ?><br /><?php echo date("j M Y h:i A",strtotime($val['end_date'])); ?></td>
                <td><?php echo $objgen->check_tag($val['duration']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><a href="<?=URLUR?>exam-start/?id=<?=$val['id']?>" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Start</a></td>            
              </tr>
              <?php
				 }
				}
				?>
                	<?php
				if($row_count4>0)
				{
				 foreach($res_arr4 as $key=>$val)
				 {
			  
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['id']); ?></td>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo date("j M Y h:i A",strtotime($val['start_date'])); ?><br /><?php echo date("j M Y h:i A",strtotime($val['end_date'])); ?></td>
                <td><?php echo $objgen->check_tag($val['duration']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><a href="<?=URLUR?>exam-start/?id=<?=$val['id']?>" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Start</a></td>            
              </tr>
              <?php
				 }
				}
				?>
            </tbody>
          </table>

        </div>
        
        
      
      <h3>Available Exams <span class="label label-info"><?=$row_count+$row_count2?></span></h3>

        <div class="panel-body table-responsive">

          <table class="table table-hover">
            <thead>
              <tr>
                <td>ID</td>
                <td>Exam</td>
                <td>Duration</td>
                <td>Questions</td>
                <td>Start</td>
              </tr>
            </thead>
            <tbody>
            	<?php
				if($row_count>0)
				{
				 foreach($res_arr as $key=>$val)
				 {
											  
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['id']); ?></td>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo $objgen->check_tag($val['duration']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><a href="<?=URLUR?>exam-start/?id=<?=$val['id']?>" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Start</a></td>            
              </tr>
              <?php
				 }
				}
				?>
                <?php
				if($row_count2>0)
				{
				 foreach($res_arr2 as $key=>$val)
				 {
											  
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['id']); ?></td>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo $objgen->check_tag($val['duration']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><a href="<?=URLUR?>exam-start/?id=<?=$val['id']?>" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Start</a></td>            
              </tr>
              <?php
				 }
				}
				?>
            </tbody>
          </table>

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
<script type="text/javascript" src="<?=URLUR?>js/datatables/datatables.min.js"></script>

</body>
</html>