<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objval	=   new validate();
$objgen		=	new general();

$row_count=4;
$question_type=1;
$negative_per=0;

$pagehead = "Question";
$list_url = URLAD."questions";
$add_url  = URLAD."add-question";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Question Created Successfully.";
}

$mark = 1;
$difficulty="Average";

$answertrval[0] 	= "True";
$answertrval[1] 	= "False";
$answerysnoval[0] 	= "Yes";
$answerysnoval[1] 	= "No";


if(isset($_POST['Create1']) || isset($_POST['Create2']))
{
   
   $exam_group	 	= $objgen->check_input($_POST['exam_group']);
   $exam	     	= $objgen->check_input($_POST['exam']);
   $section	     	= $objgen->check_input($_POST['section']);
   $subject	     	= $objgen->check_input($_POST['subject']);
   $module	     	= $objgen->check_input($_POST['module']);
   $question_type	= $objgen->check_input($_POST['question_type']);
   $question	    = $_POST['question'];
   $quest_det	    = $_POST['quest_det'];
   $mark	        = $objgen->check_input($_POST['mark']);
   $negative_per	= $objgen->check_input($_POST['negative_per']);
   $difficulty	    = $objgen->check_input($_POST['difficulty']);
   $direction_id    = $objgen->check_input($_POST['direction_id']);
   
   if(isset($_POST['Create1']))
    $status	        =  "inactive";
   else
    $status	        =  "active";
	
   $rules		= array();
   $rules[] 	= "required,exam,Enter the Exam";
   $errors  	= $objval->validateFields($_POST, $rules);
   
    $brd_exit = $objgen->chk_Ext("question","question='".$objgen->baseencode($question)."' and exam=$exam");
	if($brd_exit>0)
	{
		$errors[] = "This quation is already exists.";
	}

   
   if(empty($errors))
	{
		 
		 $msg = $objgen->ins_Row('question','exam_group,exam,section,subject,module,question_type,question,quest_det,mark,negative_per,difficulty,status,direction_id',"'".$exam_group."','".$exam."','".$section."','".$subject."','".$module."','".$question_type."','".$objgen->baseencode($question)."','".$objgen->baseencode($quest_det)."','".$mark."','".$negative_per."','".$difficulty."','".$status."','".$direction_id."'");
		 
		 $insrt_id = $objgen->get_insetId();
		 
		 if($msg=="")
		 {
			if($question_type==1 || $question_type==2)
			 {
				$answertxt    =  $_POST['answertxt'];
				$answerrdo    =  $_POST['answerrdo'];
				
				foreach($answertxt as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
				  
				  if($answerrdo==($key+1))
				  {
				    $right_ans = "yes";
				  }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==3)
			 {
				$answerchk    =  $_POST['answerchk'];
				$answerbox    =  $_POST['answerbox'];
				//print_r($answerchk);exit;
				
				foreach($answerbox as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
					
					$vchk = $key+1;
				  
				   if(@in_array($vchk,$answerchk))
				   {
					$right_ans = "yes";
				   }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==4)
			 {
			    $match_id = "";
				$right_ans = "no"; 
				
				$answerfill = $_POST['answerfill'];
			   
			   $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($answerfill)."','".$match_id."','".$right_ans."'");
			   
			 }
			 
			 if($question_type==5 || $question_type==6)
			 {
				$pair    		=  $_POST['pair'];
				$answermatch    =  $_POST['answermatch'];
							
				foreach($pair as $key=>$val)
				{
					$vchk 		= $key;
				    $match_id 	= $answermatch[$vchk];
				    $right_ans 	= "no";
					$curr_order_id =  $key+1;
			
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans,curr_order_id',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."','".$curr_order_id."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==8)
			 {
				$answertr       =  $_POST['answertr'];
				$answertrval    =  $_POST['answertrval'];
				//print_r($answerchk);exit;
				
				foreach($answertrval as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
					
					$vchk = $key+1;
				  
				   if(@in_array($vchk,$answertr))
				   {
					$right_ans = "yes";
				   }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==9)
			 {
				$answerysno       =  $_POST['answerysno'];
				$answerysnoval    =  $_POST['answerysnoval'];
				//print_r($answerchk);exit;
				
				foreach($answerysnoval as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
					
					$vchk = $key+1;
				  
				   if(@in_array($vchk,$answerysno))
				   {
					$right_ans = "yes";
				   }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			  
			  
			  header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result   		= $objgen->get_Onerow("question","AND id=".$id);
	   $exam_group     	= $objgen->check_tag($result['exam_group']);
	   $exam     		= $objgen->check_tag($result['exam']);
	   $section     	= $objgen->check_tag($result['section']);
	   $subject     	= $objgen->check_tag($result['subject']);
	   $module     		= $objgen->check_tag($result['module']);
	   $question_type   = $objgen->check_tag($result['question_type']);
	   $question     	= $objgen->basedecode($result['question']);
	   $quest_det     	= $objgen->basedecode($result['quest_det']);
	   $mark     		= $objgen->check_tag($result['mark']);
	   $negative_per    = $objgen->check_tag($result['negative_per']);
	   $difficulty      = $objgen->check_tag($result['difficulty']);
	   $direction_id   = $objgen->check_tag($result['direction_id']);
	  // $status          = $objgen->check_tag($result['status']);
	  
	  $where = " and question_id=".$id;
	  $row_count = $objgen->get_AllRowscnt("answer",$where);
	  if($row_count>0)
	  {
		 $res_arr = $objgen->get_AllRows("answer",0,$row_count,"id asc",$where);
		 
		  if($question_type==1 || $question_type==2)
		  {
			  foreach($res_arr as $key=>$val)
			  {
				   $answertxt[]    =  $objgen->basedecode($val['answer']);
				   
				   if($val['right_ans']=='yes')
				     $answerrdo = $key+1;
			  }
		  }
		  
			
		  if($question_type==3)
		  {
			  $answerchk = array();
			  $answerbox = array();
				
			  foreach($res_arr as $key=>$val)
			  {
			    $answerchk[$key]    =  $val['right_ans'];
			    $answerbox[$key]    =   $objgen->basedecode($val['answer']);
			  }
		  }
		  
		  if($question_type==4)
		  {
			  foreach($res_arr as $key=>$val)
			  {
			   $answerfill = $objgen->basedecode($val['answer']);
			  }
		  }
		  
		  if($question_type==5 || $question_type==6)
		  {
			  $answermatch = array();
			  $pair = array();
			  
			  foreach($res_arr as $key=>$val)
			  {
			   $answermatch[$key] 	= $val['match_id'];
			   $pair[$key] 			= $objgen->basedecode($val['answer']);
			  }
		  }
		  

		  
		  if($question_type==8)
		  {
			  
			  $answertrval  = array();
			  $answertr 	= array();
			  
			  foreach($res_arr as $key=>$val)
			  {
			   $answertr[$key] 	  = $val['right_ans'];
			   $answertrval[$key] = $objgen->basedecode($val['answer']);
			  }
		  }
		  
		  if($question_type==9)
		  {
			  $answerysnoval  = array();
			  $answerysno 	  = array();
			  
			  foreach($res_arr as $key=>$val)
			  {
			   $answerysno[$key] 	  = $val['right_ans'];
			   $answerysnoval[$key] = $objgen->basedecode($val['answer']);
			  }
		  }
	  }
		  
	
}

if(isset($_POST['Update']))
{    
   $exam_group	 	= $objgen->check_input($_POST['exam_group']);
   $exam	     	= $objgen->check_input($_POST['exam']);
   $section	     	= $objgen->check_input($_POST['section']);
   $subject	     	= $objgen->check_input($_POST['subject']);
   $module	     	= $objgen->check_input($_POST['module']);
   $question_type	= $objgen->check_input($_POST['question_type']);
   $question	    = $_POST['question'];
   $quest_det	    = $_POST['quest_det'];
   $mark	        = $objgen->check_input($_POST['mark']);
   $negative_per	= $objgen->check_input($_POST['negative_per']);
   $difficulty	    = $objgen->check_input($_POST['difficulty']);
   $direction_id    = $objgen->check_input($_POST['direction_id']);
   //$status	        = $objgen->check_input($_POST['status']);
	
   $rules		=	array();
   $rules[] 	= "required,exam,Enter the Exam";
   $errors  	= $objval->validateFields($_POST, $rules);
   
   $brd_exit = $objgen->chk_Ext("question","question='".$objgen->baseencode($question)."' and exam=$exam and id<>$id");
	if($brd_exit>0)
	{
		$errors[] = "This quation is already exists.";
	}


   if(empty($errors))
	{

	  $msg = $objgen->upd_Row('question',"exam_group='".$exam_group."',exam='".$exam."',section='".$section."',subject='".$subject."',module='".$module."',question_type='".$question_type."',question='".$objgen->baseencode($question)."',quest_det='".$objgen->baseencode($quest_det)."',mark='".$mark."',negative_per='".$negative_per."',difficulty='".$difficulty."',direction_id='".$direction_id."'","id=".$id);
	  
	  if($msg=="")
	  {
		  $insrt_id = $id;
		  
		  $msg     = $objgen->del_Row("answer","question_id=".$id);
		  
		  if($question_type==1 || $question_type==2)
			 {
				$answertxt    =  $_POST['answertxt'];
				$answerrdo    =  $_POST['answerrdo'];
				
				foreach($answertxt as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
				  
				  if($answerrdo==($key+1))
				  {
				    $right_ans = "yes";
				  }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==3)
			 {
				$answerchk    =  $_POST['answerchk'];
				$answerbox    =  $_POST['answerbox'];
				//print_r($answerchk);exit;
				
				foreach($answerbox as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
					
					$vchk = $key+1;
				  
				   if(@in_array($vchk,$answerchk))
				   {
					$right_ans = "yes";
				   }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==4)
			 {
			    $match_id = "";
				$right_ans = "no"; 
				
				$answerfill = $_POST['answerfill'];
			   
			   $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($answerfill)."','".$match_id."','".$right_ans."'");
			   
			 }
			 
			 if($question_type==5 || $question_type==6)
			 {
				$pair    		=  $_POST['pair'];
				$answermatch    =  $_POST['answermatch'];
							
				foreach($pair as $key=>$val)
				{
					$vchk 		= $key;
				    $match_id 	= $answermatch[$vchk];
				    $right_ans 	= "no";
					$curr_order_id =  $key+1;
			
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans,curr_order_id',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."','".$curr_order_id."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==8)
			 {
				$answertr       =  $_POST['answertr'];
				$answertrval    =  $_POST['answertrval'];
				//print_r($answerchk);exit;
				
				foreach($answertrval as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
					
					$vchk = $key+1;
				  
				   if(@in_array($vchk,$answertr))
				   {
					$right_ans = "yes";
				   }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
			 if($question_type==9)
			 {
				$answerysno       =  $_POST['answerysno'];
				$answerysnoval    =  $_POST['answerysnoval'];
				//print_r($answerchk);exit;
				
				foreach($answerysnoval as $key=>$val)
				{
				    $match_id = "";
				    $right_ans = "no";
					
					$vchk = $key+1;
				  
				   if(@in_array($vchk,$answerysno))
				   {
					$right_ans = "yes";
				   }
				   
				   if($val!="")
				   {
					   
				  $msg = $objgen->ins_Row('answer','question_id,answer,match_id,right_ans',"'".$insrt_id."','".$objgen->baseencode($val)."','".$match_id."','".$right_ans."'");
				   }
				  
				}
			  
			  }
			  
		  header("location:".$list_url."/?msg=2&page=".$page);
	  }
	  
	}
}
if(isset($_POST['Cancel']))
{
	 header("location:".$list_url);

}

$where = "";
$dire_count = $objgen->get_AllRowscnt("direction",$where);
if($dire_count>0)
{
  $dire_arr = $objgen->get_AllRows("direction",0,$dire_count,"direction_name asc",$where);
}

  $dir_det = '<select class="form-control" name="direction_id"  >
				<option value="" selected="selected">Select</option>';
					if($dire_count>0)
					{
						foreach($dire_arr as $key=>$val)
						{
						    $dir_det .= '<option value="'.$val['id'].'"';
								 if($direction_id==$val['id']) {  $dir_det .= 'selected="selected"'; } 
									$dir_det .= '>'.$objgen->check_tag($val['direction_name']).' ('.$val['id'].')</option>';
										
						}
					}
	$dir_det .= '</select>';
	
$where = "";
$group_count = $objgen->get_AllRowscnt("exam_group",$where);
if($group_count>0)
{
  $group_arr = $objgen->get_AllRows("exam_group",0,$group_count,"name asc",$where);
}

$where = "";
$exam_count = $objgen->get_AllRowscnt("exmas",$where);
if($exam_count>0)
{
  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"exam_name asc",$where);
}

if($exam!="")
{
$where = " and exam_id=".$exam;
$section_count = $objgen->get_AllRowscnt("section",$where);
if($section_count>0)
{
  $section_arr = $objgen->get_AllRows("section",0,$section_count,"name asc",$where);
}

$subject_count = $objgen->get_AllRowscnt("subject",$where);
if($subject_count>0)
{
  $subject_arr = $objgen->get_AllRows("subject",0,$subject_count,"name asc",$where);
}


$module_count = $objgen->get_AllRowscnt("module",$where);
if($module_count>0)
{
  $module_arr = $objgen->get_AllRows("module",0,$module_count,"name asc",$where);
}


	
            $section_det = '<select class="form-control" name="section" required >
											<option value="" selected="selected">Select</option>';
									
											if($section_count>0)
											{
											 foreach($section_arr as $key=>$val)
											 {
										
											$section_det .= '<option value="'.$val['id'].'"';
											
											 if($section==$val['id']) {  $section_det .= 'selected="selected"'; } 
											 										 
											$section_det .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$section_det .= '</select>';
							
			
            $subject_det = '<select class="form-control" name="subject" required >
											<option value="" selected="selected">Select</option>';
									
											if($subject_count>0)
											{
											 foreach($subject_arr as $key=>$val)
											 {
										
											$subject_det .= '<option value="'.$val['id'].'"';
											 if($subject==$val['id']) {  $subject_det .= 'selected="selected"'; } 
											$subject_det .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$subject_det .= '</select>';
                                        
										
										
				
            $module_det = '<select class="form-control" name=" module" required >
											<option value="" selected="selected">Select</option>';
									
											if($module_count>0)
											{
											 foreach($module_arr as $key=>$val)
											 {
										
											$module_det .= '<option value="'.$val['id'].'"';
								            if($module==$val['id']) {  $module_det .= 'selected="selected"'; } 
											$module_det .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$module_det .= '</select>';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?php echo TITLE; ?></title>
  <style>
  .rcorners1 {
    border-radius: 25px;
    background: #F5F5F5;
    padding: 20px; 

}
.hideans
{
 display:none;
}
</style>

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
    <h1 class="title"><?php if(isset($_GET['edit'])){ echo "Edit"; } else { echo "Add";  } ?> <?=$pagehead?></h1>
      <ol class="breadcrumb">
        <li><a href="<?=URLAD?>home">Home</a></li>
        <li><a href="javascript:;"> <?php if(isset($_GET['edit'])){ echo "Edit"; } else { echo "Add";  } ?> <?=$pagehead?></a></li>
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
        Enter <?=$pagehead?> Informations
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
								  <div class="row">
    								<div class="col-md-12">
                                    
                                         <div class="col-md-12  rcorners1">
									
								     <div class="col-md-6 col-lg-6">
	
									<div class="form-group">
									  <label for="input1" class="form-label">Question Type *</label>
										<select id="question_type"  name="question_type" class="form-control" onChange="showans(this.value)">
												<option value="1">Multiple Choice (Radiobutton)</option>
												<option value="2">Multiple Choice (Dropdown)</option>
												<option value="3">Multiple Correct</option>
												<option value="4">Fill in the Blank</option>
												<option value="5">Drag and Match</option>
												<option value="6">Matching</option>
												<option value="7">Essay (Evaluted by Admin)</option>
												<option value="8">True / False</option>
												<option value="9">Yes / No</option>
										</select>
									</div>
									
									</div>
						      
									
									<div class="col-md-6 col-lg-6">
									
									  <div class="form-group">
										  <label for="input3"  class="form-label">Group *</label>
										  <select class="form-control" name="exam_group" required >
											<option value="" selected="selected">Select</option>
											<?php
											if($group_count>0)
											{
											 foreach($group_arr as $key=>$val)
											 {
											?>
											<option value="<?=$val['id']?>" <?php if($exam_group==$val['id']) { ?> selected="selected" <?php } ?> ><?=$objgen->check_tag($val['name'])?></option>
											<?php
											  }
											}
											?>
										</select>
										</div>
										
									</div>
									
								<div class="col-md-6 col-lg-6">
									  <div class="form-group">
										  <label for="input3"  class="form-label">Exam *</label>
										  <select class="form-control" name="exam" id="exam" required onChange="listdata()" >
											<option value="" selected="selected">Select</option>
											<?php
											if($exam_count>0)
											{
											 foreach($exam_arr as $key=>$val)
											 {
											?>
											<option value="<?=$val['id']?>" <?php if($exam==$val['id']) { ?> selected="selected" <?php } ?> ><?=$objgen->check_tag($val['exam_name'])?></option>
											<?php
											  }
											}
											?>
										</select>
										</div>
										</div>
                                        
                                        <div class="col-md-6 col-lg-6">
									  <div class="form-group">
										  <label for="input3"  class="form-label">Section *</label>
                                          <div id="section">
                                          <?php
										  if($exam!="")
											{
												 echo $section_det;
											}
											else
											{
											?>
										   <select class="form-control" name="section" required >
                                              <option value="" selected="selected">Select</option>
										    </select>
                                            <?php
											}
											?>
                                            </div>
										</div>
										</div>
										
									<div class="col-md-6 col-lg-6">
									  <div class="form-group">
										  <label for="input3"  class="form-label">Subject *</label>
                                          <div id="subject">
                                          <?php
										  if($exam!="")
											{
												 echo $subject_det;
											}
											else
											{
											?>
										    <select class="form-control" name="subject" required >
											  <option value="" selected="selected">Select</option>
										    </select>
                                            <?php
											}
											?>
                                           </div>
										</div>
										</div>
										
												
									<div class="col-md-6 col-lg-6">
									  <div class="form-group">
										  <label for="input3"  class="form-label">Module *</label>
                                           <div id="module">
										   <?php
										  if($exam!="")
											{
												 echo $module_det;
											}
											else
											{
											?>
                                              <select class="form-control" name="module" required >
                                                <option value="" selected="selected">Select</option>
                                               </select>
                                               <?php
											}
											?>
                                            </div>
										</div>
										</div>
                                        
                                        </div>
                                        
                                        <br clear="all" />	<br clear="all" />   
                       
                                     <div class="col-md-12 col-lg-12 rcorners1">
									  <div class="form-group">
										  <label for="input3"  class="form-label">Question *</label>
                                           <div id="module">
                                             <textarea name="question" cols="" rows="3" class="form-control" ><?=$question?></textarea>
                                            </div>
										</div>
										</div>
                                        
										  <br clear="all" />	<br clear="all" />   
                                          
                                       <div class="col-md-12 rcorners1" >
                                        <div>
                                        <label for="input3"  class="form-label">Question Details</label>
                                        <a href="javascript:;" onClick="$('#qudet').toggle();" class="btn btn-rounded btn-option3 btn-xs">Show</a>
                                        </div>
                                         <div id="qudet" style="display:none;">
                                        <textarea name="quest_det" cols="" rows="3" class="form-control ckeditor" ><?=$quest_det?></textarea>
                                        </div>
                                       </div>
										
                                       <br clear="all" />	<br clear="all" />
                                       <?php
									  // print_r($answertxt);  
									   ?>
                                           
                                           <!-- Ans Start !--> 
                                        <div id="hideans1" class="hideans" <?php if($question_type==1 || $question_type==2){ ?> style="display:block" <?php } ?> >
                                        
                                        
                                           <div class="col-md-12 rcorners1" >
                                               <label for="input3"  class="form-label">Answers</label><br />
                                                <div class="col-md-6 ans1"  <?php if($row_count<1) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                        
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="1" id="answer1" name="answerrdo" <?php if($answerrdo=="1") { ?> checked="checked" <?php } ?> >
                                                            <label for="answer1">
                                                                A
                                                            </label>
                                                        </div>
                                                         <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[0]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans2" <?php if($row_count<2) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="2" id="answer2" name="answerrdo"  <?php if($answerrdo=="2") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer2">
                                                               B
                                                            </label>
                                                        </div>
                                                   
                                                          <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[1]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans3" <?php if($row_count<3) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="3" id="answer3" name="answerrdo"  <?php if($answerrdo=="3") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer3">
                                                                C
                                                            </label>
                                                        </div>
                                                          <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[2]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 
                                                 <div class="col-md-6 ans4"  <?php if($row_count<4) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="4" id="answer4" name="answerrdo"  <?php if($answerrdo=="4") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer4">
                                                                D
                                                            </label>
                                                        </div>
                                                          <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[3]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans5" <?php if($row_count<5) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="5" id="answer5" name="answerrdo"  <?php if($answerrdo=="5") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer5">
                                                                E
                                                            </label>
                                                        </div>
                                                         <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[4]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans6" <?php if($row_count<6) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="6" id="answer6" name="answerrdo"  <?php if($answerrdo=="6") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer6">
                                                                F
                                                            </label>
                                                        </div>
                                                          <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[5]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans7" <?php if($row_count<7) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="7" id="answer7" name="answerrdo"  <?php if($answerrdo=="7") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer7">
                                                                G
                                                            </label>
                                                        </div>
                                                          <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[6]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans8" <?php if($row_count<8) {?> style="display:none" <?php } ?>   >
									               <div class="form-group">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="8" id="answer8" name="answerrdo"  <?php if($answerrdo=="8") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer8">
                                                                H
                                                            </label>
                                                        </div>
                                                       <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[7]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans9" <?php if($row_count<9) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="9" id="answer9" name="answerrdo"  <?php if($answerrdo=="9") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer9">
                                                                I
                                                            </label>
                                                        </div>
                                                        <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[8]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans10" <?php if($row_count<10) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="10" id="answer10" name="answerrdo"  <?php if($answerrdo=="10") { ?> checked="checked" <?php } ?>  >
                                                            <label for="answer10">
                                                               J
                                                            </label>
                                                        </div>
                                                          <textarea name="answertxt[]"  class="form-control ckeditor" ><?=$answertxt[9]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="btn-group" id="showans">
                                                   <label class="btn btn-warning showanscls <?php if($row_count==2) {?> active <?php } ?> " id="chk2"  >
                                                      Two
                                                    </label>
                                                    <label class="btn btn-warning showanscls  <?php if($row_count==3) {?> active <?php } ?> " id="chk3"  >
                                                       Three
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==4) {?> active <?php } ?> " id="chk4" >
                                                       Four
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==5) {?> active <?php } ?> " id="chk5" >
                                                       Five
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==6) {?> active <?php } ?> " id="chk6" >
                                                      Six
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==7) {?> active <?php } ?> " id="chk7" >
                                                      Seven
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==8) {?> active <?php } ?>" id="chk8"  >
                                                      Eight
                                                    </label>
                                                      <label class="btn btn-warning showanscls  <?php if($row_count==9) {?> active <?php } ?> " id="chk9" >
                                                       Nine
                                                    </label>
                                                      <label class="btn btn-warning showanscls  <?php if($row_count==10) {?> active <?php } ?>  " id="chk10" >
                                                       Ten
                                                    </label>
                                                  </div>
                                                  
                                                 
                                                 
                                           </div>
                                       
                                           
                                        </div>	
                                        
                                        <!-- Ans End !--> 
                                        
                                        <!-- Ans Start !--> 
                                        
                                     <div id="hideans2" class="hideans"  <?php if($question_type==3){ ?> style="display:block" <?php } ?>  >
                                        
                                        
                                           <div class="col-md-12 rcorners1" >
                                               <label for="input3"  class="form-label">Answers</label><br />
                                                <div class="col-md-6" class="ans1" <?php if($row_count<1) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                        
                                                       <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="1" id="chkanswer1" name="answerchk[]"  <?php if($answerchk[0]=="yes") { ?> checked="checked" <?php } ?>  >
                                                            <label for="chkanswer1">
                                                                A
                                                            </label>
                                                        </div>
                                                  
                                                            <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[0]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans2"  <?php if($row_count<2) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                       <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="2" id="chkanswer2" name="answerchk[]"  <?php if($answerchk[1]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer2">
                                                               B
                                                            </label>
                                                        </div>
                                                       <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[1]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans3" <?php if($row_count<3) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="3" id="chkanswer3" name="answerchk[]"  <?php if($answerchk[2]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer3">
                                                                C
                                                            </label>
                                                        </div>
                                                     <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[2]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 
                                                 <div class="col-md-6 ans4" <?php if($row_count<4) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                       <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="4" id="chkanswer4" name="answerchk[]"  <?php if($answerchk[3]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer4">
                                                                D
                                                            </label>
                                                        </div>
                                                       <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[3]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans5" <?php if($row_count<5) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                        <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="5" id="chkanswer5" name="answerchk[]"  <?php if($answerchk[4]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer5">
                                                                E
                                                            </label>
                                                        </div>
                                                       <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[4]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans6" <?php if($row_count<6) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="6" id="chkanswer6" name="answerchk[]"  <?php if($answerchk[5]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer6">
                                                                F
                                                            </label>
                                                        </div>
                                                        <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[5]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans7" <?php if($row_count<7) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="7" id="chkanswer7" name="answerchk[]"  <?php if($answerchk[6]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer7">
                                                                G
                                                            </label>
                                                        </div>
                                                        <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[6]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans8" <?php if($row_count<8) {?> style="display:none" <?php } ?>  >
									               <div class="form-group">
                                                        <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="8" id="chkanswer8" name="answerchk[]"  <?php if($answerchk[7]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer8">
                                                                H
                                                            </label>
                                                        </div>
                                                        <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[7]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans9" <?php if($row_count<9) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                       <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="9" id="chkanswer9" name="answerchk[]"  <?php if($answerchk[8]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer9">
                                                                I
                                                            </label>
                                                        </div>
                                                        <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[8]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans10" <?php if($row_count<10) {?> style="display:none" <?php } ?> >
									               <div class="form-group">
                                                        <div class="checkbox checkbox-info checkbox-inline">
                                                            <input type="checkbox"  value="10" id="chkanswer10" name="answerchk[]"  <?php if($answerchk[9]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="chkanswer10">
                                                               J
                                                            </label>
                                                        </div>
                                                       <textarea name="answerbox[]"  class="form-control ckeditor" ><?=$answerbox[9]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="btn-group" id="showans">
                                                   <label class="btn btn-warning showanscls  <?php if($row_count==2) {?> active <?php } ?>  " id="chk2"  >
                                                      Two
                                                    </label>
                                                    <label class="btn btn-warning showanscls  <?php if($row_count==3) {?> active <?php } ?>  " id="chk3"  >
                                                       Three
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==4) {?> active <?php } ?> " id="chk4" >
                                                       Four
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==5) {?> active <?php } ?>  " id="chk5" >
                                                       Five
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==6) {?> active <?php } ?>  " id="chk6" >
                                                      Six
                                                    </label>
                                                     <label class="btn btn-warning showanscls  <?php if($row_count==7) {?> active <?php } ?>  " id="chk7" >
                                                      Seven
                                                    </label>
                                                     <label class="btn btn-warning showanscls <?php if($row_count==8) {?> active <?php } ?>  " id="chk8" >
                                                      Eight
                                                    </label>
                                                      <label class="btn btn-warning showanscls  <?php if($row_count==9) {?> active <?php } ?>  " id="chk9" >
                                                       Nine
                                                    </label>
                                                      <label class="btn btn-warning showanscls  <?php if($row_count==10) {?> active <?php } ?>  " id="chk10" >
                                                       Ten
                                                    </label>
                                                  </div>
                                                  
                                                 
                                                 
                                           </div>
                                       
                                           
                                        </div>
                                        <!-- Ans End !--> 
                                        
                                           <!-- Ans Start !--> 
                                        
                                             <div id="hideans3" class="hideans"   <?php if($question_type==4){ ?> style="display:block" <?php } ?>  >
                                             
                                                <div class="col-md-12 col-lg-12 rcorners1">
                                                      <div class="form-group">
                                                          <label for="input3"  class="form-label">Correct Answer</label>
                                                           <div id="module">
                                                             
                                                               <textarea name="answerfill"  class="form-control ckeditor" ><?=$answerfill?></textarea>
                                                            </div>
                                                        </div>
                                                  </div>

                                             </div>
                                      <!-- Ans End !--> 
                                      
                                      
                                          <!-- Ans Start !--> 
                                        
                                     <div id="hideans4" class="hideans" <?php if($question_type==5 || $question_type==6){ ?> style="display:block" <?php } ?> >
                                        
                                        
                                           <div class="col-md-12 rcorners1" >
                                             
                                                <div class="col-md-6" class="ans1" <?php if($row_count<1) {?> style="display:none" <?php } ?> >
                                                  <label for="input3"  class="form-label">Pair A</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[0]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                                            <select name="answermatch[]" class="form-control" id="answermatch1">
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>
                                							 
                      									 </div>
                                                  
                                                   </div>
                                                </div>
                                                 
                                                 <div class="col-md-6 ans2"  <?php if($row_count<2) {?> style="display:none" <?php } ?> >
									               <label for="input3"  class="form-label">Pair B</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[1]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch2" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans3"  <?php if($row_count<3) {?> style="display:none" <?php } ?> >
									                <label for="input3"  class="form-label">Pair C</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[2]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch3" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select> 
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                 
                                                 <div class="col-md-6 ans4" <?php if($row_count<4) {?> style="display:none" <?php } ?> >
									                <label for="input3"  class="form-label">Pair D</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[3]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch4" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select> 
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans5" <?php if($row_count<5) {?> style="display:none" <?php } ?> >
									               <label for="input3"  class="form-label">Pair E</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[4]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch5" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans6" <?php if($row_count<6) {?> style="display:none" <?php } ?>  >
									                <label for="input3"  class="form-label">Pair F</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[5]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch6" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>  
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans7" <?php if($row_count<7) {?> style="display:none" <?php } ?>  >
									                <label for="input3"  class="form-label">Pair G</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[6]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch7" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>  
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans8" <?php if($row_count<8) {?> style="display:none" <?php } ?> >
									               <label for="input3"  class="form-label">Pair H</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[7]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch8" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans9" <?php if($row_count<9) {?> style="display:none" <?php } ?>  >
									                <label for="input3"  class="form-label">Pair I</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[8]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch9" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                  <div class="col-md-6 ans10" <?php if($row_count<10) {?> style="display:none" <?php } ?> >
									                <label for="input3"  class="form-label">Pair J</label><br />
									               <div class="form-group">
                                                        <textarea name="pair[]" cols="" rows="3" class="form-control ckeditor" ><?=$pair[9]?></textarea><br />
                                                        <div class="input-prepend input-group">
                         									<span class="add-on input-group-addon">Answer</span>
                                							 <select name="answermatch[]" class="form-control" id="answermatch10" >
                                                                <option value="">Select</option>
                                                            	<option value="1">Pair A</option>
                                                                <option value="2">Pair B</option>
                                                                <option value="3">Pair C</option>
                                                                <option value="4">Pair D</option>
                                                                <option value="5">Pair E</option>
                                                                <option value="6">Pair F</option>
                                                                <option value="7">Pair G</option>
                                                                <option value="8">Pair H</option>
                                                                <option value="9">Pair I</option>
                                                                <option value="10">Pair J</option>
                                                            </select>  
                      									 </div>
                                                  
                                                   </div>
                                                 </div>
                                                 
                                                 
                                                 <div  class="btn-group" id="showans">
                                                   <label class="btn btn-warning showanscls <?php if($row_count==2) {?> active <?php } ?>  " id="chk2"  >
                                                      Two
                                                    </label>
                                                    <label class="btn btn-warning showanscls <?php if($row_count==3) {?> active <?php } ?> " id="chk3"  >
                                                       Three
                                                    </label>
                                                     <label class="btn btn-warning showanscls <?php if($row_count==4) {?> active <?php } ?> " id="chk4" >
                                                       Four
                                                    </label>
                                                     <label class="btn btn-warning showanscls <?php if($row_count==5) {?> active <?php } ?> " id="chk5" >
                                                       Five
                                                    </label>
                                                     <label class="btn btn-warning showanscls <?php if($row_count==6) {?> active <?php } ?> " id="chk6" >
                                                      Six
                                                    </label>
                                                     <label class="btn btn-warning showanscls <?php if($row_count==7) {?> active <?php } ?> " id="chk7" >
                                                      Seven
                                                    </label>
                                                     <label class="btn btn-warning showanscls <?php if($row_count==8) {?> active <?php } ?> " id="chk8" >
                                                      Eight
                                                    </label>
                                                      <label class="btn btn-warning showanscls <?php if($row_count==9) {?> active <?php } ?> " id="chk9" >
                                                       Nine
                                                    </label>
                                                      <label class="btn btn-warning showanscls <?php if($row_count==10) {?> active <?php } ?>  " id="chk10" >
                                                       Ten
                                                    </label>
                                                  </div>
                                                  
                                                 
                                                 
                                           </div>
                                       
                                           
                                        </div>
                                        <!-- Ans End !--> 
                                        
                                       <!-- Ans Start !--> 
                                        
                                             <div id="hideans5" class="hideans" <?php if($question_type==7){ ?> style="display:block" <?php } ?> >
                                             
                                                <div class="col-md-12 col-lg-12 rcorners1">
                                                      <div class="form-group">
                                                         No answer required to enter. Admin needs to evalute this type of question manually.
                                                        </div>
                                                  </div>

                                             </div>
                                      <!-- Ans End !--> 
                                      
                                         <!-- Ans Start !--> 
                                        
                                             <div id="hideans6" class="hideans" <?php if($question_type==8){ ?> style="display:block" <?php } ?> >
                                             
                                                <div class="col-md-12 rcorners1" >
                                               <label for="input3"  class="form-label">Answers</label><br />
                                                <div class="col-md-6" class="ans1">
									               <div class="form-group">
                                                        
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="1" id="transwer1" name="answertr[]" <?php if($answertr[0]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="transwer1">
                                                                A
                                                            </label>
                                                        </div>
  
                                                             <textarea name="answertrval[]" cols="" rows="3" class="form-control ckeditor" ><?=$answertrval[0]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans2"  >
									               <div class="form-group">
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="2" id="transwer2" name="answertr[]" <?php if($answertr[1]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="transwer2">
                                                               B
                                                            </label>
                                                        </div>
                                                   <textarea name="answertrval[]" cols="" rows="3" class="form-control ckeditor" ><?=$answertrval[1]?></textarea>
                                                   </div>
                                                 </div>
                                                 </div>

                                             </div>
                                      <!-- Ans End !--> 
                                      
                                       <!-- Ans Start !--> 
                                        
                                             <div id="hideans7" class="hideans" <?php if($question_type==9){ ?> style="display:block" <?php } ?> >
                                             
                                                <div class="col-md-12 rcorners1" >
                                               <label for="input3"  class="form-label">Answers</label><br />
                                                <div class="col-md-6" class="ans1">
									               <div class="form-group">
                                                        
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="1" id="ysanswer1" name="answerysno[]" <?php if($answerysno[0]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="ysanswer1">
                                                                A
                                                            </label>
                                                        </div>
                                                          <textarea name="answerysnoval[]" cols="" rows="3" class="form-control ckeditor" ><?=$answerysnoval[0]?></textarea>
                                                   </div>
                                                 </div>
                                                 
                                                 <div class="col-md-6 ans2"  >
									               <div class="form-group">
                                                       <div class="radio radio-info radio-inline">
                                                            <input type="radio"  value="2" id="ysanswer2" name="answerysno[]" <?php if($answerysno[1]=="yes") { ?> checked="checked" <?php } ?> >
                                                            <label for="ysanswer2">
                                                               B
                                                            </label>
                                                        </div>
                                                         <textarea name="answerysnoval[]" cols="" rows="3" class="form-control ckeditor" ><?=$answerysnoval[1]?></textarea>                        </div>
                                                 </div>
                                                 </div>

                                             </div>
                                      <!-- Ans End !--> 
                                  
                                  	<br clear="all" />	<br clear="all" />
                                        <div class="col-md-12 rcorners1"  >
                                          <div>
                                        <label for="input3"  class="form-label">Advance Options</label>
                                        <a href="javascript:;" onClick="$('#advop').toggle();" class="btn btn-rounded btn-option3 btn-xs">Show</a>
                                        </div>
                                         <div id="advop" style="display:none;">
                                         <div align="right">
                                         <a href="javascript:void(0);" role="button"  data-toggle="modal" data-target="#myModal" ><span class="fa fa-edit"></span> Create New Direction</a>
                                        </div> 
                                           <span id="msg"></span>  
                                                                            
                                        <div class="col-md-12">
                                         <div class="form-group">
                                           <label for="input3"  class="form-label">Direction</label>
                                           
                                           <span id="dirdiv">
                                             <?=$dir_det?>
                                             </span>
                                             
                                           </div>
                                        </div>                     
                                         
                                          <div class="col-md-4">
									               <div class="form-group">
                                                       <label for="input3"  class="form-label">Mark</label>
                                                       <input name="mark" type="text"  class="form-control" value="<?=$mark?>" /> 
                                                   </div>
                                           </div>
                                           
                                            <div class="col-md-4">
									               <div class="form-group">
                                                       <label for="input3"  class="form-label">Negative Marks (%)</label>
                                                        <input name="negative_per" type="text"  class="form-control" value="<?=$negative_per?>" /> 
                                                    
                                                   </div>
                                           </div>
                                           
                                           
                                            <div class="col-md-4">
									               <div class="form-group">
                                                       <label for="input3"  class="form-label">Difficulty Level</label>
                                                       <select class="form-control" name="difficulty"  >
                                                        <option value="Easy" <?php if($difficulty=="Easy") { ?> selected="selected" <?php } ?> >Easy</option>
                                                        <option value="Average" <?php if($difficulty=="Average") { ?> selected="selected" <?php } ?>  >Average</option> 
                                                        <option value="Hard" <?php if($difficulty=="Hard") { ?> selected="selected" <?php } ?>  >Hard</option> 
                                                       </select> 
                                                   </div>
                                           </div>
                                        </div>
                                        
                                        </div>	
									
									<br clear="all" />	<br clear="all" />
									
									<div class="col-md-6 col-lg-6">
												
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
                                            <button type="submit" class="btn btn-default" name="Create1"><span class="fa fa-save"></span>&nbsp;Save as Draft</button>
                                            
                                            <button type="submit" class="btn btn-default" name="Create2"><span class="fa fa-save"></span>&nbsp;Save & Publish</button>
                                         
                                         <?php
                                            }
                                            ?>
										<button class="btn btn-danger" type="button" name="Cancel" onClick="window.location='<?=$list_url?>'"><span class="fa fa-undo"></span>&nbsp;Cancel</button>
										</div>
										
											<br clear="all" />
										
                                      </div>
									  </div>

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
   <!-- Modal -->
            <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog">
                <form role="form" action="" method="post" enctype="multipart/form-data" >
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Add Direction</h4>
                   </div>
              
                      <div class="modal-body">
                            
                         <div class="col-md-12">
							 <div class="form-group">
                                <label for="input3"  class="form-label">Direction Name *</label>
                                 <input name="direction_name" id="direction_name" type="text"  class="form-control" value="<?=$direction_name?>" required /> 		
                             </div>
                         </div> 
                         
                         <div class="col-md-12">
							 <div class="form-group">
                                <label for="input3"  class="form-label">Direction *</label>
                               <textarea name="direction" id="direction" cols="" rows="3" class="form-control ckeditor" required ><?=$direction?></textarea>
                              </div>
                         </div> 
                         
                              <br clear="all" />                  
                      </div>
                       <div class="modal-footer">
                         <button type="button" class="btn btn-default" name="CreateDir" onClick="subdir()"><span class="fa fa-save"></span>&nbsp;Save</button>
                                          
                        <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                      </div>
                    
                </div>
                  </form>
              </div>
            </div>

          <!-- End Moda Code --> 

<?php require_once "footer-script.php"; ?>
<script type="text/javascript" src="<?=URLAD?>js/ckeditor4/ckeditor.js"></script>
<script type="text/javascript" src="<?=URLAD?>js/ckfinder/ckfinder.js"></script>

<script type="text/javascript">
 $(function() {
                var editor = CKEDITOR.replace('question', {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[  'EqnEditor', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
/*		'/',	*/																				// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
		{ name: 'insert', items: [ 'Image' ] }
	], height: 100});

				CKFinder.setupCKEditor( editor, '<?=URLAD?>js/ckfinder' );
		//CKEDITOR.replaceClass = 'ckeditor';
				
				// var editor1 = CKEDITOR.replace('answertxt[]');
			//	CKFinder.setupCKEditor( editor1, '<?=URLAD?>js/ckfinder' );
			
			//ckeditor
			
			var dd=1;
$(".ckeditor").each(function(){

$(this).attr("id","ckeditor"+dd);

var editor = CKEDITOR.replace( 'ckeditor'+dd, {
	toolbar: [
		{ name: 'document', items: [ 'Source', '-', 'NewPage', 'Preview', '-', 'Templates' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
		[  'EqnEditor', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],			// Defines toolbar group without name.
/*		'/',	*/																				// Line break - next group will be placed in new line.
		{ name: 'basicstyles', items: [ 'Bold', 'Italic' ] },
		{ name: 'insert', items: [ 'Image' ] }
	], height: 100});
	
	CKFinder.setupCKEditor( editor, '<?=URLAD?>js/ckfinder' );
	
dd=dd+1;
});
				

});
</script>
<script>
function showans(id)
{
	 $('.hideans').hide();
	 if(id==1 || id==2)
	 {
		$('#hideans1').show();
	 }
	 if(id==3)
	 {
		$('#hideans2').show();
	 }
	 if(id==4)
	 {
		$('#hideans3').show();
	 }
	 if(id==5 || id==6)
	 {
		$('#hideans4').show();
	 }
	 if(id==7)
	 {
		$('#hideans5').show();
	 }
	 if(id==8)
	 {
		$('#hideans6').show();
	 }
	  if(id==9)
	 {
		$('#hideans7').show();
	 }
}
function listdata() 
{
			  
	 var m = $("#exam").val();
		 $.ajax({
				type: "GET",
				dataType: "json",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 1,  m : m  },
				success: function (result) {
					
				$('#section').html(result["section"]);
				$('#subject').html(result["subject"]);
				$('#module').html(result["module"]);
				
			}
		});
				 
}
function subdir() 
{
			  
	 var n = $("#direction_name").val();
	 var d = $("#direction").val();
		 $.ajax({
				type: "POST",
				dataType: "json",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 2,  n : n,  d : d  },
				success: function (result) {
					
				$('#dirdiv').html(result["dirdiv"]);
				$('#msg').html(result["msg"]);
				
				 $('#myModal').modal('toggle');
				
			}
		});
				 
}
</script>
<script>

$(".showanscls").click(function(){
	
	$(".showanscls").removeClass( "active" );
	var id = this.id;
	$(this).addClass("active");
	
	 $('.ans1').hide();
	 $('.ans2').hide();
	 $('.ans3').hide();
	 $('.ans4').hide();
	 $('.ans5').hide();
	 $('.ans6').hide();
	 $('.ans7').hide();
	 $('.ans8').hide();
	 $('.ans9').hide();
	 $('.ans10').hide();
	
	if(id=="chk2")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	}
	
	if(id=="chk3")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	}
	
	if(id=="chk4")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	}
	
	if(id=="chk5")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	  $('.ans5').show();
	}
	if(id=="chk6")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	  $('.ans5').show();
	  $('.ans6').show();
	}
	if(id=="chk7")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	  $('.ans5').show();
	  $('.ans6').show();
	  $('.ans7').show();
	  
	}
	if(id=="chk8")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	  $('.ans5').show();
	  $('.ans6').show();
	  $('.ans7').show();
	  $('.ans8').show();
	}
	if(id=="chk9")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	  $('.ans5').show();
	  $('.ans6').show();
	  $('.ans7').show();
	  $('.ans8').show();
	  $('.ans9').show();
	}
	if(id=="chk10")
	{
	  $('.ans1').show();
	  $('.ans2').show();
	  $('.ans3').show();
	  $('.ans4').show();
	  $('.ans5').show();
	  $('.ans6').show();
	  $('.ans7').show();
	  $('.ans8').show();
	  $('.ans9').show();
	  $('.ans10').show();
	}
	

});
		

$('#question_type').val('<?=$question_type?>');

$('#answermatch1').val('<?=$answermatch[0]?>');
$('#answermatch2').val('<?=$answermatch[1]?>');
$('#answermatch3').val('<?=$answermatch[2]?>');
$('#answermatch4').val('<?=$answermatch[3]?>');
$('#answermatch5').val('<?=$answermatch[4]?>');
$('#answermatch6').val('<?=$answermatch[5]?>');
$('#answermatch7').val('<?=$answermatch[6]?>');
$('#answermatch8').val('<?=$answermatch[7]?>');
$('#answermatch9').val('<?=$answermatch[8]?>');
$('#answermatch10').val('<?=$answermatch[9]?>');
</script>
</body>
</html>