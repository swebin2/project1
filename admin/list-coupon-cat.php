<?php
require_once "includes/includepath.php";
require_once "chk_login.php";

$objgen		=	new general();
$objval	=   new validate();

$pagehead = "Coupon Cat";
$list_url = URLAD."list-coupon-cat";
$add_url  = URLAD."list-coupon";

$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("discount_cat","id=".$id);
    if($msg=="")
   {
	header("location:".$list_url."/?msg=3&page=".$page);
   }
}

if($_GET['msg']==3)
{
  $msg2 = "Category Deleted Successfully.";
}

if($_GET['msg']==1)
{
  $msg2 = "Category Created Successfully.";
}

if(isset($_POST['Create']))
{
   
   $name   	    = $objgen->check_input($_POST['name']);
	
   $rules		=	array();
   $rules[] 	= "required,name,Enter the Category";

   $errors  	= $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("discount_cat","name='$name'");
	if($brd_exit>0)
	{
		$errors[] = "This category is already exists.";
	}

   if(empty($errors))
	{
		 
		 $msg = $objgen->ins_Row('discount_cat','name',"'".$name."'");
		 if($msg=="")
		 {
			   header("location:".$list_url."/?msg=1");
		 }
	}
}


$where = "";
//echo $where;

$row_count = $objgen->get_AllRowscnt("discount_cat",$where);

if($row_count>0)
{
  
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP');
  $pages = $objPN->get(array(), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  $res_arr = $objgen->get_AllRows("discount_cat",$pagesize*($page-1),$pagesize,"id desc",$where);
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
         Create
        </div>

            <div class="panel-body">
              <form class="form-inline" method="post" enctype="multipart/form-data" >
			    <div class="form-group">
                  <label class="form-label" for="example1">Category</label>
                 <input type="text" class="form-control" value="<?=$name?>" name="name"  />
                </div>

				<button type="submit" class="btn btn-default" name="Create"><span class="fa fa-save"></span>&nbsp;Add</button>
				
              </form>
            </div>

      </div>

	
      <div class="panel panel-default">

             <div class="panel-title">
       <div class="pull-right">
				<button type="buttom" class="btn btn-success" name="Back" onClick="window.location='<?=$add_url?>'"><span class="fa fa-arrow-left"></span>&nbsp;Back</button>
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
                                                <th>Name</th>
                                               <th>Delete</th>
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
                                            <td><?php echo $objgen->check_tag($val['name']); ?></td>
                                            <td><a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Category?')"><span class="fa fa-trash-o"></span></a></td>
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