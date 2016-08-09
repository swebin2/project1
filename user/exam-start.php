<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		=	new general();

unset($_SESSION['exam'][$usrid]);

if(isset($_GET['id']))
{

           $id = $_GET['id'];
           if($_GET['cat']=='user'){
               $_SESSION['exam'][$usrid]['exam_creator']  = 'user';
               $result   = $objgen->get_Onerow("user_exam_list","AND id=".$id);
           }else{
			   
               $examPermArr = $objgen->get_Onerow("exam_permission"," AND (user_id='$usrid' AND exam_id='$id' AND status='active')", " ");
               $_SESSION['exam'][$usrid]['exam_package'] = $examPermArr['package_id'];
			   
               $result   = $objgen->get_Onerow("exam_list","AND id=".$id);
			   
           }
	   $exam_name    = $objgen->check_tag($result['exam_name']);
	   $group_id     = $objgen->check_tag($result['group_id']);
	   $exam_id      = $objgen->check_tag($result['exam_id']);
	   $duration     = $objgen->check_tag($result['duration']);
	   $neagive_mark = $objgen->check_tag($result['neagive_mark']);
	   $avaibility   = $objgen->check_tag($result['avaibility']);
           $_SESSION['exam'][$usrid]['exam_duration'] = $duration;
	   
	   if($result['start_date']!="0000-00-00 00:00:00")
	   {
	     $start_date   = date("d-m-Y H:i",strtotime($result['start_date']));
	   }
		 
	    if($result['end_date']!="0000-00-00 00:00:00")
		{
	     $end_date     = date("d-m-Y H:i",strtotime($result['end_date']));
		}
	   
	   $exam_assign  = $objgen->check_tag($result['exam_assign']);
	   $link_add 	 = $objgen->check_tag($result['link_add']);
	   
	   $totno_of_qu = $objgen->check_tag($result['totno_of_qu']);
	   if($_GET['cat']=='user'){
               $where = " and user_exam_list_id=".$id;
                $secli_count = $objgen->get_AllRowscnt("user_section_list",$where);
		if($secli_count>0)
		{
		  $secli_arr = $objgen->get_AllRows("user_section_list",0,$secli_count,"id asc",$where);
		}
           }else{
                $where = " and exam_list_id=".$id;
                $secli_count = $objgen->get_AllRowscnt("section_list",$where);
		if($secli_count>0)
		{
		  $secli_arr = $objgen->get_AllRows("section_list",0,$secli_count,"id asc",$where);
		}
           }

	  $_SESSION['exam'][$usrid]['id']  = $id;
	  

}else{
    header('Location: '.URLUR.'exam-list.php');
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
    <h1 class="title">Exams <span class="label label-info"><?=$row_count?></span></h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLAD?>home">Home</a></li>
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

        <div class="panel-body table-responsive" align="center">
         <h3><?=$exam_name?></h3>
         <div>Duartion <?=$duration?> hr</div>
          <div>Questions <?=$totno_of_qu?></div>
          <a href="#" onclick="start_exam()" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Start Now</a>

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

<?php
    $examDuration = $_SESSION['exam'][$usrid]['exam_duration'];
    sscanf($examDuration, "%d:%d:%d", $hours, $minutes, $seconds);
    $time_seconds = isset($seconds) ? $hours * 3600 + $minutes * 60 + $seconds : $hours * 60 + $minutes;
?>
<?php require_once "footer-script.php"; ?>
<script type="text/javascript" src="<?=URLUR?>js/datatables/datatables.min.js"></script>
<script type="text/javascript" src="<?=URLUR?>js/jquery.cookie.js"></script>
<script  type="text/javascript">
    function start_exam()
        {
            window.location.replace("<?= URLUR . "exam-window" ?>");

        }
</script>

</body>
</html>