<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
require('excelreader/php-excel-reader/excel_reader2.php');
require('excelreader/SpreadsheetReader.php');

$objval	=   new validate();
$objgen		=	new general();
$pagehead = "Import Questions";
$list_url = URLAD."import-questions";
$add_url  = URLAD."import-questions";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Questions Imported Successfully.";
}


 
if(isset($_POST['Create']))
{

$errors = array();	
$file_name = basename($_FILES["import_file"]["name"]);
$target_dir = "excelreader/file/";
$target_file = $target_dir . basename($_FILES["import_file"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

// Allow certain file formats
if($imageFileType != "xls" && $imageFileType != "xlsx") {
    $errors[] = "Sorry, only XLS, XLSX files are allowed.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $errors[] = "Your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["import_file"]["tmp_name"], $target_file)) {
		
		$import_file = $_FILES['import_file']['tmp_name'];
     	$Reader = new SpreadsheetReader($target_file);
		//$Reader = new SpreadsheetReader($import_file);
		$Sheets = $Reader -> Sheets();

		foreach ($Sheets as $Index => $Name)
		{
		//	echo 'Sheet #'.$Index.': '.$Name;

			$Reader -> ChangeSheet($Index);
             $i=0;
			foreach ($Reader as $Row)
			{
			
			$error_flag = 1;
			
			if($Row[0]=="")
			{
				break;
			}
			
				//print_r($Row);exit;
				if($i>0)
				{
					
					//print_r($Row);
					//echo $Row[1];
					//exit;
					
						if($Row[1]=='Multiple Choice (Radiobutton)')
						{
						   $question_type	= 1;
						}
						
						if($Row[1]=='Multiple Choice (Dropdown)')
						{
						   $question_type	= 2;
						}
						
						if($Row[1]=='Multiple Correct')
						{
						   $question_type	= 3;
						}
						
						if($Row[1]=='Fill in the Blank')
						{
						   $question_type	= 4;
						}
						
						if($Row[1]=='DragandMatch')
						{
						   $question_type	= 5;
						}
						
						if($Row[1]=='Matching')
						{
						   $question_type	= 6;
						}
						
						if($Row[1]=='Essay (Evaluated by Admin)')
						{
						   $question_type	= 7;
						}
						
						if($Row[1]=='True/False')
						{
						   $question_type	= 8;
						}
						
						if($Row[1]=='Yes/No')
						{
						   $question_type	= 9;
						}
					   
					   
					   $result1   		= $objgen->get_Onerow("exam_group","AND code='".$objgen->check_input($Row[2])."'");
					   $result2   		= $objgen->get_Onerow("exmas","AND code='".$objgen->check_input($Row[3])."'");
					   $result3   		= $objgen->get_Onerow("section","AND code='".$objgen->check_input($Row[4])."'");
					   $result4   		= $objgen->get_Onerow("subject","AND code='".$objgen->check_input($Row[5])."'");
					   $result5   		= $objgen->get_Onerow("module","AND code='".$objgen->check_input($Row[6])."'");
					   
					   $exam_group	 	= $result1['id'];
					   $exam	     	= $result2['id'];
					   $section	     	= $result3['id'];
					   $subject	     	= $result4['id'];
					   $module	     	= $result5['id'];
					  
					   $question	    = $objgen->baseencode($Row[7]);
					   $quest_det	    = $objgen->baseencode($Row[20]);
					   $mark	        = $objgen->check_input($Row[21]);
					   $negative_per	= $objgen->check_input($Row[27]);
					   $difficulty	    = $objgen->check_input($Row[23]);
					   $direction_id	= $objgen->check_input($Row[29]);
					   
					  
					   
					   $answers 	= array();
					   $answers[0] 	= $Row[8];
					   $answers[1] 	= $Row[9];
					   $answers[2] 	= $Row[10];
					   $answers[3] 	= $Row[11];
					   $answers[4] 	= $Row[12];
					   
					   $img_status = $objgen->check_input($Row[28]);
					   
					   if($img_status==2)
					    $status	        =  "inactive";
					   else
					    $status	        =  "active";
							
				    if($question=="")
					{
						$errors[] = $Row[0]." - question is empty. Not imported.";
						$error_flag =2;
					}
					else
					{
						$brd_exit = $objgen->chk_Ext("question","question='".$objgen->basedecode($question)."' and exam=$exam");
						if($brd_exit>0)
						{
							$errors[] = $Row[0]." - question is already exists. Not imported.";
							$error_flag =2;
						}
					}
				   
				    if($error_flag==1)
					{
					
					  $msg = $objgen->ins_Row('question','exam_group,exam,section,subject,module,question_type,question,quest_det,mark,negative_per,difficulty,status,img_status,file_name,direction_id',"'".$exam_group."','".$exam."','".$section."','".$subject."','".$module."','".$question_type."','".$question."','".$quest_det."','".$mark."','".$negative_per."','".$difficulty."','".$status."','".$img_status."','".$file_name."','".$direction_id."'");
					  
					 $insrt_id = $objgen->get_insetId();
						 
					if($question_type != 5 && $question_type != 6 && $question_type != 7)
					{
						
						foreach($answers as $key=>$val)
						{
							
							if($val!="")
							{
							 
							  $right_ans ="no";
							  if($Row[13]==($key+1))
							  {	
							   $right_ans ="yes";
							  }
						
						  $msg = $objgen->ins_Row('answer','question_id,answer,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$right_ans."'");
						  
							}
						  
						}
						
					}
				    
					if($question_type == 5 || $question_type == 6)
					{
						foreach($answers as $key=>$val)
						{
							
							if($val!="")
							{
							 
							  $match_id      = $Row[$key+14];
							  $right_ans     = "no";
							  $curr_order_id =  $key+1;
						
						  $msg = $objgen->ins_Row('answer','question_id,answer,right_ans,match_id,curr_order_id',"'".$insrt_id."','".$objgen->baseencode($val)."','".$right_ans."','".$match_id."','".$curr_order_id."'");
						  
							}
						  
						}
						
					}
					  
				  }
				}
				
				$i++;
				
			}
		}
		
       
    } else {
        $msg = "Sorry, there was an error uploading your file.";
    }
}

   
 if($msg=="")
 {
	//header("location:".$add_url."/?msg=1");
	
	 $msg2 = "Questions Imported Successfully.";
 }
   
  // exit;
   
   
}


if(isset($_POST['Cancel']))
{
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
    <h1 class="title"><?=$pagehead?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLAD?>home">Home</a></li>
        <li><a href="javascript:;"><?=$pagehead?></a></li>
      </ol>



  </div>
  <!-- End Page Header -->

 <!-- //////////////////////////////////////////////////////////////////////////// --> 
<!-- START CONTAINER -->
<div class="container-default">

  <div class="row">
    <div class="col-md-12 col-lg-6">
      <div class="panel panel-default">

        <div class="panel-title">
       Upload Excel File
         
        </div>

            <div class="panel-body">
                <form role="form" action="" method="post" enctype="multipart/form-data" >
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

                                     <?php
                                       if (!empty($errors)) {
                                        ?>
                                         <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Please fix the following errors:</b> <br>
                                             <?php
                                                    foreach ($errors as $error1)
                                                     echo "<div> - ".$error1." </div>";
                                                ?>
                                    </div>
   
                                      <?php
                                         } 
                                         ?>
                                        
                                    <?php
                                    if($msg!="")
                                    {
                                    ?>
                                   <div class="alert alert-danger alert-dismissable">
                                        <i class="fa fa-ban"></i>
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                        <b>Alert!</b> <?php echo $msg; ?>
                                    </div>
                                    <?php
                                    }
                                    ?>
									<div class="form-group">
									  <label for="input1" class="form-label">Excel File *</label>
                                      <input name="import_file" type="file"  />
										
									</div>
								
				   <?php
                                            if(isset($_GET['edit']))
                                            {
                                            ?>
                                            <button class="btn btn-default" type="submit" name="Update"><span class="fa fa-thumbs-o-up"></span>&nbsp;Update</button>
                                      
                                            <?php
                                            }
                                            else
                                            {
                                            ?>
                                            <button type="submit" class="btn btn-default" name="Create"><span class="fa fa-save"></span>&nbsp;Save</button>
                                         
                                         <?php
                                            }
                                            ?>
										<button class="btn btn-danger" type="button" name="Cancel" onClick="window.location='<?=$list_url?>'"><span class="fa fa-undo"></span>&nbsp;Cancel</button>
										
    

              </form>

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