<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objgen		=	new general();

$pagehead = "Manage Exam";
$list_url = URLAD."manage-exam";
$add_url  = URLAD."add-exam-list";

$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("section_list","exam_list_id=".$id);
   $msg     = $objgen->del_Row("exam_list","id=".$id);
    if($msg=="")
   {
	header("location:".$list_url."/?msg=3&page=".$page);
   }
}



if($_GET['msg']==2)
{

  $msg2 = "Exam Updated Successfully.";
}

if($_GET['msg']==3)
{

  $msg2 = "Exam Deleted Successfully.";
}



$where = "";
if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
  $un = trim($_REQUEST['un']);
  $where .= " and exam_name like '%".$un."%'";
}


$row_count = $objgen->get_AllRowscnt("exam_list",$where);
if($row_count>0)
{
  
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP');
  $pages = $objPN->get(array("un" => $un), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  $res_arr = $objgen->get_AllRows("exam_list",$pagesize*($page-1),$pagesize,"id desc",$where);
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
                  <label class="form-label" for="example1">Exam</label>
                 <input type="text" class="form-control" value="<?=$un?>" name="un" />
                </div>

				<button type="submit" class="btn btn-default" name="Search"><span class="fa fa-search"></span>&nbsp;Search</button>
				<button type="submit" class="btn btn-info" name="Reset"><span class="fa fa-eraser"></span>&nbsp;Reset</button>
			
              </form>
            </div>

      </div>

	
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
                                                <th>ID</th>
                                                <th>Exam Name</th>
												<th>Duration</th>
                                                <th>Questions</th>
                                                <th>Type</th>
                                                <th>Available (from - to)</th>
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
												  
												if($val['exam_assign']=="link")
												{
													$type = "Public";
												}
												else
												{
											
													
													$result   = $objgen->get_Onerow("exam_group","AND id=".$val['group_id']);
													$result2   = $objgen->get_Onerow("exmas","AND id=".$val['exam_id']);
													$type  = "Group :".$objgen->check_tag($result['name']);
													$type .= "<br />Exam :".$objgen->check_tag($result2['exam_name']);
												}
											  
                                          ?>
                                            <tr>
                                                <td><?php echo $objgen->check_tag($val['id']); ?></td>
                                                <td><?php echo $objgen->check_tag($val['exam_name']); ?></td>
												<td><?php echo $objgen->check_tag($val['duration']); ?></td>
                                                <td><?php echo $objgen->check_tag($val['totno_of_qu']); ?></td>
                                                <td><?php echo $type; ?></td>
                                                <td><?php echo ucfirst($val['avaibility']); ?>
                                                <?php
												if($val['avaibility']=="specific")
												{
													 echo "<br />".date("j M Y h:i a",strtotime($val['start_date'])); ?> <br /> <?php echo date("j M Y h:i a",strtotime($val['end_date'])); 
												}
												?>
                                                </td>
                                                <td><a href="<?=$add_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" ><span class="fa fa-edit"></span></a></td>
                                                <td><a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Exam?')"><span class="fa fa-trash-o"></span></a></td>
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