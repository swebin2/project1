<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
$objgen		=	new general();

$pagehead = "Payments";
$list_url = URLAD."payments";


$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("payments","id=".$id);
    if($msg=="")
   {
	header("location:".$list_url."/?msg=3&page=".$page);
   }
}



if($_GET['msg']==3)
{

  $msg2 = "Payment Deleted Successfully.";
}


$where = "";

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

if(isset($_REQUEST['Search']))
{
	
if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
  $un = trim($_REQUEST['un']);
  $where .= " and order_id = '".$un."'";
}

if(isset($_REQUEST['ut']) &&  trim($_REQUEST['ut'])!="")
{
  $ut = trim($_REQUEST['ut']);
  $where .= " and pay_date >= '".date("Y-m-d",strtotime($ut))."'";
}

if(isset($_REQUEST['ut1']) &&  trim($_REQUEST['ut1'])!="")
{
  $ut1 = trim($_REQUEST['ut1']);
  $where .= " and pay_date <= '".date("Y-m-d",strtotime($ut1))."'";
}

$row_count = $objgen->get_AllRowscnt("payments",$where);
if($row_count>0)
{
  $res_arr = $objgen->get_AllRows("payments",0,$row_count,"id desc",$where);
}



}
else
{

//echo $where;

$row_count = $objgen->get_AllRowscnt("payments",$where);
if($row_count>0)
{
  
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP');
  $pages = $objPN->get(array("un" => $un, "ut" => $ut), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  $res_arr = $objgen->get_AllRows("payments",$pagesize*($page-1),$pagesize,"id desc",$where);
}

}

if(isset($_POST['Reset']))
{
	 unset($_REQUEST);
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
    <h1 class="title">List <?=$pagehead?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLAD?>home">Home</a></li>
        <li><a href="javascript:;"> List <?=$pagehead?></a></li>
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
         Search
        </div>

            <div class="panel-body">
              <form class="form-inline" method="post" enctype="multipart/form-data" >
			    <div class="form-group">
                  <label class="form-label" for="example1">Order ID</label>
                 <input type="text" class="form-control" value="<?=$un?>" name="un"  />
                </div>
			
		            <div class="form-group">
                  <label class="form-label" for="example2">Date From</label>
                   <input type="text" class="form-control" value="<?=$ut?>" name="ut"  id="ut" />
                </div>
                
                  <div class="form-group">
                  <label class="form-label" for="example2">Date To</label>
                   <input type="text" class="form-control" value="<?=$ut1?>" name="ut1"  id="ut1" />
                </div>
		
				
				<button type="submit" class="btn btn-default" name="Search"><span class="fa fa-search"></span>&nbsp;Search</button>
				<button type="submit" class="btn btn-info" name="Reset"><span class="fa fa-eraser"></span>&nbsp;Reset</button>
			
              </form>
            </div>

      </div>

	
      <div class="panel panel-default">
            <div class="panel-body">
		
					<div class="row">
                        <div class="col-xs-12">
						   						
														
                           <div class="box">
                                <div class="box-body table-responsive">
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
                                   <table id="example1" class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Order ID</th>
												<th>User</th>
                                                <th>Packages</th>
												<th>Exam</th>
                                                <th>Pay Req. ID</th>
												<th>Payment ID</th>
                                                <th>Pay Status</th>
                                                <th>Date</th>
                                                <th>Amount</th>
                                                <?php
                                                if($_SESSION['MYPR_adm_type']=="admin")
												{
													?>
                                                <th>Delete</th>
                                                <?php
												}
												?>
                                            </tr>
                                        </thead>
                                        <tbody>
										  	<?php
											$tot =0;
										if($row_count>0)
										{
										  foreach($res_arr as $key=>$val)
											  {
												  $pcknmarr = array();
											  
                                                     $result     		= $objgen->get_Onerow("users","AND id=".$val['user_id']);
												
												$allow_exams = array();	
												
												$where = " and order_id='".$val['order_id']."'";
												$packcpunt = $objgen->get_AllRowscnt("exam_permission",$where);
												
												if($packcpunt>0)
												{
												  $pakarr = $objgen->get_AllRows("exam_permission",0,$packcpunt,"id asc",$where);
												  foreach($pakarr as $k=>$v)
												  {
													  $pack  = $objgen->get_Onerow("exam_package","AND id=".$v['package_id']);
													  $exam  = $objgen->get_Onerow("exmas","AND id=".$pack['exam_id']);
													  
													  $pcknmarr[] = $objgen->check_tag($exam['exam_name'])." : Package -".$objgen->check_tag($pack['package_no']);
												  }
												  
												}
											?>
                                            <tr>
                                                <td><?php echo $objgen->check_tag($val['order_id']); ?>
												</td>
												<td><?php echo $objgen->check_tag($result['full_name']); ?></td>
                                                <td><?=implode("<br />",$pcknmarr);?></td>
												<td><?php 
												$where2 = " and order_id=".$val['order_id'];
												
																								
												if($_SESSION['MYPR_adm_type']=="vendor")
												{
													$where2 = " and order_id=".$val['order_id']." and exam_id=".$_SESSION['MYPR_exam_id'];
												}
												$per_count = $objgen->get_AllRowscnt("exam_permission",$where2);
												if($per_count>0)
												{
													$per_arr = $objgen->get_AllRows("exam_permission",0,$per_count,"id asc",$where2);
													foreach($per_arr as $k=>$v)
													{
														$result2     		= $objgen->get_Onerow("exmas","AND id=".$v['exam_id']);
														$allow_exams[] = $objgen->check_tag($result2['exam_name']);
													}
												}
												 
												echo implode(",",$allow_exams); 
												
												?></td>
                                                <td><?php echo $objgen->check_tag($val['payment_request_id']); ?></td>
												<td><?php echo $objgen->check_tag($val['payment_id']); ?></td>
												<td>
												<?php
												if($val['pay_status']=="Completed")
												{
												 echo '<span class="label label-success">'.$objgen->check_tag($val['pay_status']).'</span>'; 
												 }
												 else
												 {
												  echo '<span class="label label-danger">'.$objgen->check_tag($val['pay_status'])."</span>"; 
												 }
												 ?>
												
												</td>
												<td><?php echo date("j M Y",strtotime($val['pay_date'])); ?></td>
                                                <td><?php echo $objgen->check_tag($val['amount']); ?> INR</td>
                                                 <?php
                                                if($_SESSION['MYPR_adm_type']=="admin")
												{
													?>
                                                <td><a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Order?')"><span class="fa fa-trash-o"></span></a></td>
                                                <?php
												}
												?>
                                            </tr>
                                          
                                         <?php
										       $tot += $val['amount'];
												}
											}
											if(isset($_REQUEST['Search']))
											{
											
										 ?>
                                         <tr style="background-color:#CCC">
                                         <td colspan="7">&nbsp;</td>
                                         <td><b>Total</b></td>
                                         <td><b><?=$tot?> INR</b></td>
                                           <?php
                                                if($_SESSION['MYPR_adm_type']=="admin")
												{
													?>
                                              <td>&nbsp;</td>
                                               <?php
                                         }
                                         ?> 
                                         </tr>
                                         <?php
                                         }
                                         ?>
                                         
                                        </tbody>
                                       
                                    </table>
									<?php
									if(($row_count > $pagesize) && !isset($_REQUEST['Search'])) 
									{
									?>
									<div class="row pull-right">
	                                    <div class="col-xs-12">
										
											<div class="dataTables_paginate paging_bootstrap">
											    		
												<?php echo $pages; ?>

												
											</div>
											
									   </div>
									</div>
									<?php
										 }
									?>
									
                                </div><!-- /.box-body -->
                            </div><!-- /.box --> 
                        </div><!-- /.col -->
                    </div>
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
Moment.js
================================================ -->
<script type="text/javascript" src="<?=URLAD?>js/moment/moment.min.js"></script>
<!-- ================================================
Bootstrap Date Range Picker
================================================ -->
<script type="text/javascript" src="<?=URLAD?>js/date-range-picker/daterangepicker.js"></script>
<!-- Basic Single Date Picker -->
<script type="text/javascript">
$(document).ready(function() {
  $('#ut').daterangepicker({ singleDatePicker: true,  showDropdowns: true,     format: 'DD-MM-YYYY' }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
});
$(document).ready(function() {
  $('#ut1').daterangepicker({ singleDatePicker: true,  showDropdowns: true,     format: 'DD-MM-YYYY' }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
});
</script>
</body>
</html>