<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objgen		=	new general();

$pagehead = "Exam Package";
$list_url = URLAD."exam-package";
$add_url  = URLAD."add-exam-package";

$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("exam_package","id=".$id);
    if($msg=="")
   {
	header("location:".$list_url."/?msg=3&page=".$page);
   }
}



if($_GET['msg']==2)
{

  $msg2 = "Package Updated Successfully.";
}

if($_GET['msg']==3)
{

  $msg2 = "Package Deleted Successfully.";
}



$where = "";
/*if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
  $un = trim($_REQUEST['un']);
  $where .= " and name like '%".$un."%'";
}
*/

$row_count = $objgen->get_AllRowscnt("exam_package",$where);
if($row_count>0)
{
  
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP');
  $pages = $objPN->get(array(), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  $res_arr = $objgen->get_AllRows("exam_package",$pagesize*($page-1),$pagesize,"id desc",$where);
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

      <!--<div class="panel panel-default">

        <div class="panel-title">
         Search
        </div>

            <div class="panel-body">
              <form class="form-inline" method="post" enctype="multipart/form-data" >
			    <div class="form-group">
                  <label class="form-label" for="example1">Section</label>
                 <input type="text" class="form-control" value="<?=$un?>" name="un" />
                </div>

				<button type="submit" class="btn btn-default" name="Search"><span class="fa fa-search"></span>&nbsp;Search</button>
				<button type="submit" class="btn btn-info" name="Reset"><span class="fa fa-eraser"></span>&nbsp;Reset</button>
			
              </form>
            </div>

      </div>-->

	
      <div class="panel panel-default">

             <div class="panel-title">
       <div class="pull-right">
				<button type="buttom" class="btn btn-success" name="Reset" onClick="window.location='<?=$add_url?>'"><span class="fa fa-plus"></span>&nbsp;Add New</button>
				</div>
         
        </div>
          <br clear="all" />
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
                                     <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th>Exam</th>
                                                <th>Package</th>
												<th>Amount</th>
                                                <th>No. of Exam</th>
                                                <th>Duration</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  	<?php
										if($row_count>0)
										{
										  foreach($res_arr as $key=>$val)
											  {
											  
                                                  $result   = $objgen->get_Onerow("exmas","AND id=".$val['exam_id']);
											?>
                                            <tr>
                                                <td><?php echo $objgen->check_tag($result['exam_name']); ?></td>
                                                <td>Package <?php echo $objgen->check_tag($val['package_no']); ?></td>
												<td><?php echo $objgen->check_tag($val['amount']); ?> INR</td>
                                                <td><?php echo $objgen->check_tag($val['no_of_exam']); ?></td>
                                                <td><?php echo $objgen->check_tag($val['period']); ?></td>
                                                <td><a href="<?=$add_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" ><span class="fa fa-edit"></span></a></td>
                                                <td><a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Package?')"><span class="fa fa-trash-o"></span></a></td>
                                            </tr>
                                          
                                         <?php
												}
											}
										 ?>
                                        </tbody>
                                       
                                    </table>
									<?php
									if($row_count > $pagesize) 
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


</body>
</html>