<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen		=	new general();

//test 22

$where = "";
$row_count = $objgen->get_AllRowscnt("exam_list",$where);
if($row_count>0)
{
  $res_arr = $objgen->get_AllRows("exam_list",0,$row_count,"id desc",$where);
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