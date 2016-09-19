<?php
require_once "chk_login.php";
$objgen		=	new general();
//echo $objgen->decrypt_pass("de8EsXT2Oxeb+MnBX3JCEQHwRfBDnqey6pDXMDLg0h4=");

/*$where = " and status='active' and user_id=".$usrid;
$exam_per = $objgen->get_AllRowscnt("exam_permission",$where);
if($exam_per>0)
{
  $per_arr = $objgen->get_AllRows("exam_permission",0,$exam_per,"id asc",$where);
}
*/
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
// Private Exams End
}

$where = " AND user_id='$usrid'";
$chkexatt_count = $objgen->get_AllRowscnt("user_exam_score", $where);

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
  
  <div class="container-default">

  <div class="row">
  
      <div class="col-md-12 col-lg-12">
      
                                         
      <div class="panel panel-default">
      
      
       <h3>Group Analysis</h3>

        <div class="panel-body">
              <?php
			  if($chkexatt_count>0)
			  {
				  ?>
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <td>Exam</td>
                <td>No. of Questions</td>
                <td>Total Attended</td>
                <td>Correct Answers</td>
                <td>Wrong Answers</td>
                <td>Unanswered</td>
                <td>Your Score</td>
                <td>Highest User Score</td>
              </tr>
            </thead>
            <tbody>
            	<?php
				if($row_count3>0)
				{
				 foreach($res_arr3 as $key=>$val)
				 {
					 
					    $where = " AND user_id='$usrid' and exam_id=".$val['id'];
						$exatt_count = $objgen->get_AllRowscnt("user_exam_score", $where);
						if ($exatt_count > 0) {
							
							$exatt_arr = $objgen->get_AllRows("user_exam_score", 0, 1, "id desc", $where);
						
						foreach($exatt_arr as $k=>$v)
						{	
							 $correctAnsCount 	= $v['correct_answer_num'];
                             $wrongAnsCount		= $v['wrong_answer_num'];
                             $unansCount		= $v['unanswered_num'];
						}
						
						$maxscore = $objgen->get_MAxVal("user_exam_score","exam_mark","max_exam_mark","exam_id=".$val['id']);
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><?=($correctAnsCount+$wrongAnsCount)?></td>
                <td><?=$correctAnsCount?></td>
                <td><?=$wrongAnsCount?></td>
                <td><?=$unansCount?></td>
                <td><?php echo $v['exam_mark']; ?></td>
                <td><?php echo $maxscore['max_exam_mark']; ?></td>         
              </tr>
              <?php
			  
				   }
				 }
				}
				?>
                	<?php
				if($row_count4>0)
				{
				 foreach($res_arr4 as $key=>$val)
				 {
			   
			   
			     $where = " AND user_id='$usrid' and exam_id=".$val['id'];
						$exatt_count = $objgen->get_AllRowscnt("user_exam_score", $where);
						if ($exatt_count > 0) {
							
							$exatt_arr = $objgen->get_AllRows("user_exam_score", 0, 1, "id desc", $where);
						
						foreach($exatt_arr as $k=>$v)
						{	
							 $correctAnsCount 	= $v['correct_answer_num'];
                             $wrongAnsCount		= $v['wrong_answer_num'];
                             $unansCount		= $v['unanswered_num'];
						}
						$maxscore = $objgen->get_MAxVal("user_exam_score","exam_mark","max_exam_mark","exam_id=".$val['id']);
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><?=($correctAnsCount+$wrongAnsCount)?></td>
                <td><?=$correctAnsCount?></td>
                <td><?=$wrongAnsCount?></td>
                <td><?=$unansCount?></td>
                <td><?php echo $v['exam_mark']; ?></td>
                <td><?php echo $maxscore['max_exam_mark']; ?></td>                
              </tr>
              <?php
						}
				 }
				}
				?>
                	<?php
				if($row_count>0)
				{
				 foreach($res_arr as $key=>$val)
				 {
					 
			     $where = " AND user_id='$usrid' and exam_id=".$val['id'];
						$exatt_count = $objgen->get_AllRowscnt("user_exam_score", $where);
						if ($exatt_count > 0) {
							
							$exatt_arr = $objgen->get_AllRows("user_exam_score", 0, 1, "id desc", $where);
						
						foreach($exatt_arr as $k=>$v)
						{	
							 $correctAnsCount 	= $v['correct_answer_num'];
                             $wrongAnsCount		= $v['wrong_answer_num'];
                             $unansCount		= $v['unanswered_num'];
						}
					$maxscore = $objgen->get_MAxVal("user_exam_score","exam_mark","max_exam_mark","exam_id=".$val['id']);						  
                 ?>
              <tr>
                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><?=($correctAnsCount+$wrongAnsCount)?></td>
                <td><?=$correctAnsCount?></td>
                <td><?=$wrongAnsCount?></td>
                <td><?=$unansCount?></td>
                <td><?php echo $v['exam_mark']; ?></td>
                <td><?php echo $maxscore['max_exam_mark']; ?></td>                   
              </tr>
              <?php
				 }
				 }
				}
				?>
                <?php
				if($row_count2>0)
				{
				 foreach($res_arr2 as $key=>$val)
				 {
					 
			     $where = " AND user_id='$usrid' and exam_id=".$val['id'];
						$exatt_count = $objgen->get_AllRowscnt("user_exam_score", $where);
						if ($exatt_count > 0) {
							
							$exatt_arr = $objgen->get_AllRows("user_exam_score", 0, 1, "id desc", $where);
						
						foreach($exatt_arr as $k=>$v)
						{	
							 $correctAnsCount 	= $v['correct_answer_num'];
                             $wrongAnsCount		= $v['wrong_answer_num'];
                             $unansCount		= $v['unanswered_num'];
						}
					$maxscore = $objgen->get_MAxVal("user_exam_score","exam_mark","max_exam_mark","exam_id=".$val['id']);						  
                 ?>
              <tr>
                 <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                <td><?=($correctAnsCount+$wrongAnsCount)?></td>
                <td><?=$correctAnsCount?></td>
                <td><?=$wrongAnsCount?></td>
                <td><?=$unansCount?></td>
                <td><?php echo $v['exam_mark']; ?></td>
                <td><?php echo $maxscore['max_exam_mark']; ?></td>                  
              </tr>
              <?php
				 }
				 }
				}
				?>
            </tbody>
          </table>
             <?php
			  }
			  ?>
        </div>
        

        
        
      </div>
    </div>



	
      
    </div>
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