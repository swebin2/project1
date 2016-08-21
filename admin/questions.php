<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objgen		=	new general();

$pagehead = "Questions";
$list_url = URLAD."questions";
$add_url  = URLAD."add-question";

$objPN		= 	new page(1);
/** Page Settings  **/
$pagesize	=	20;
$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

$currpage = $page-1;
$serial = ($currpage * $pagesize) + 1;

if(isset($_GET['del']))
{
   $id= $_GET['del'];
   $msg     = $objgen->del_Row("answer","question_id=".$id);
   $msg     = $objgen->del_Row("question","id=".$id);
    if($msg=="")
   {
	header("location:".$list_url."/?msg=3&page=".$page);
   }
}

if(isset($_POST['delall']))
{
	$delarr =  $_POST['check'];
	foreach($delarr as $key=>$val)
	{
	   $msg     = $objgen->del_Row("answer","question_id=".$val);
       $msg     = $objgen->del_Row("question","id=".$val);	
	}
	
if($msg=="")
   {
	header("location:".$list_url."/?msg=3&page=".$page);
   }
	 
}

if(isset($_GET['st']))
{
	 $id = $_GET['id'];
	 $st = $_GET['st'];
	 if($st=='active')
	 {
	   $status = "inactive";
	   $msg	=	$objgen->upd_Row("question","status='$status'","id=".$id);
	 }
	 if($st=='inactive')
	 {
	   $status = "active";
	   $msg	=	$objgen->upd_Row("question","status='$status',img_status='1'","id=".$id);
	 }
	 
	 
	 
	 header('location:'.$list_url.'/?msg=4&page='.$page);
}

if($_GET['msg']==2)
{

  $msg2 = "Question Updated Successfully.";
}

if($_GET['msg']==3)
{

  $msg2 = "Question Deleted Successfully.";
}

if($_GET['msg']==4)
{

  $msg2 = "Status Changed Successfully.";
}

$where = "";
if(isset($_REQUEST['un']) &&  trim($_REQUEST['un'])!="")
{
  $un = trim($_REQUEST['un']);
  $where .= " and (question ='".$objgen->baseencode($un)."' or quest_det ='".$objgen->baseencode($un)."')";
}

if(isset($_REQUEST['exam_group']) &&  trim($_REQUEST['exam_group'])!="")
{
  $exam_group = trim($_REQUEST['exam_group']);
  $where .= " and exam_group ='".$exam_group."'";
}
if(isset($_REQUEST['exam']) &&  trim($_REQUEST['exam'])!="")
{
    $exam = trim($_REQUEST['exam']);
    $where .= " and exam ='".$exam."'";
}
if(isset($_REQUEST['section']) &&  trim($_REQUEST['section'])!="")
{
   $section = trim($_REQUEST['section']);
   $where .= " and section ='".$section."'";
}
if(isset($_REQUEST['subject']) &&  trim($_REQUEST['subject'])!="")
{
   $subject = trim($_REQUEST['subject']);
   $where .= " and subject ='".$subject."'";
}
if(isset($_REQUEST['module']) &&  trim($_REQUEST['module'])!="")
{
   $module = trim($_REQUEST['module']);
   $where .= " and module ='".$module."'";
}
//echo $where;
$row_count = $objgen->get_AllRowscnt("question",$where);
if($row_count>0)
{
  
  $objPN->setCount($row_count);
  $objPN->pageSize($pagesize);
  $objPN->setCurrPage($page);
  $objPN->setDispType('PG_BOOSTRAP');
  $pages = $objPN->get(array("un" => $un,"exam_group" => $exam_group,"exam" => $exam,"section" => $section,"subject" => $subject,"module" => $module), 1, WEBLINKAD."/".$params[0]."/", "", "active");
  $res_arr = $objgen->get_AllRows("question",$pagesize*($page-1),$pagesize,"id asc",$where);
}

if(isset($_POST['Reset']))
{
	 unset($_REQUEST);
	  header("location:".$list_url);
}

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


	
            $section_det = '<select class="form-control" name="section"  >
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
							
			
            $subject_det = '<select class="form-control" name="subject"  >
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
                                        
										
										
				
            $module_det = '<select class="form-control" name=" module"  >
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

  <?php require_once "header-script.php"; ?>
    <style>
  .rcorners1 {
    border-radius: 25px;
    background: #F5F5F5;
    padding: 20px; 
    border:1px solid #000;
}
.dragdrop{
width:200px;
height:120px;
border:1px solid #aaaaaa;
text-align:left;
color:#CCC;

}

.dragdrop2{
width:200px;
height:120px;
border:1px solid #aaaaaa;
text-align:left;
background:#CCC;
color:#000;

}
.form-group
{
	padding-bottom:10px;
}
</style>
<script>
function allowDrop(ev) {
    ev.preventDefault();
}

function drag(ev) {
    ev.dataTransfer.setData("text", ev.target.id);
}
function drop(ev){
	ev.preventDefault();
	
	var data = ev.dataTransfer.getData("text");
	
	//alert(data);
	
	//alert(document.getElementById(data).getAttribute("name"));
	
//	alert(ev.target.getAttribute("id"));
	
	if(ev.target.getAttribute("id") == document.getElementById(data).getAttribute("name")){
			ev.target.appendChild(document.getElementById(data));
			alert("Right Match");
			}
			else{
				alert("Not Right Match");
				}
}

</script>
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
                  <label class="form-label" for="example1">Question</label>
                 <input type="text" class="form-control" value="<?=$un?>" name="un" />
                </div>
              
					
									
									  <div class="form-group">
										  <label for="input3"  class="form-label">Group</label>
										  <select class="form-control" name="exam_group" id="exam_group" >
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
										
								
									
								
									  <div class="form-group">
										  <label for="input3"  class="form-label">Exam </label>
										  <select class="form-control" name="exam" id="exam"  onChange="listdata()" >
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
									
                                        
                                     
									  <div class="form-group">
										  <label for="input3"  class="form-label">Section</label>
                                          <span id="section">
                                          <?php
										  if($exam!="")
											{
												 echo $section_det;
											}
											else
											{
											?>
										   <select class="form-control" name="section"  >
                                              <option value="" selected="selected">Select</option>
										    </select>
                                            <?php
											}
											?>
                                            </span>
										</div>
									
										
							
									  <div class="form-group">
										  <label for="input3"  class="form-label">Subject</label>
                                          <span id="subject">
                                          <?php
										  if($exam!="")
											{
												 echo $subject_det;
											}
											else
											{
											?>
										    <select class="form-control" name="subject"  >
											  <option value="" selected="selected">Select</option>
										    </select>
                                            <?php
											}
											?>
                                           </span>
										</div>
							
										
												
								
									  <div class="form-group">
										  <label for="input3"  class="form-label">Module </label>
                                           <span id="module">
										   <?php
										  if($exam!="")
											{
												 echo $module_det;
											}
											else
											{
											?>
                                              <select class="form-control" name="module"  >
                                                <option value="" selected="selected">Select</option>
                                               </select>
                                               <?php
											}
											?>
                                            </span>
								
										</div>
                                        <br clear="all" />
				<button type="submit" class="btn btn-default" name="Search"><span class="fa fa-search"></span>&nbsp;Search</button>
				<button type="submit" class="btn btn-info" name="Reset"><span class="fa fa-eraser"></span>&nbsp;Reset</button>
			
              </form>
            </div>

      </div>
      
    <form class="form-inline" method="post" enctype="multipart/form-data" > 
	
      <div class="panel panel-default">

             <div class="panel-title">
              <div class="pull-left">
             
		
                <button type="submit" class="btn btn-danger" name="delall" id="delall"><span class="fa fa-trash"></span>&nbsp;Delete </button>
               
				</div>
                
       <div class="pull-right">
				<button type="button" class="btn btn-success" name="Reset" onClick="window.location='<?=$add_url?>'"><span class="fa fa-plus"></span>&nbsp;Add New</button>
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
                                                <th>	<input type="checkbox"   id="selectall" ></th>
                                                <th>Sl.No</th>
                                                <th>Question</th>
                                                <th>Type</th>
												<th>Group</th>
												<th>Exam</th>
                                                <th>Section</th>
                                                <th>Image St</th>
                                                <th>File Name</th>
                                                <th>Preview</th>
                                                <th>Publish</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>
                                        </thead>
                                        <tbody>
										  	<?php
										$alphas = range('A', 'Z');
	

										if($row_count>0)
										{
										  foreach($res_arr as $key=>$val)
											  {
												  
												    $s_num = $serial++;
											  
                                                  $result   = $objgen->get_Onerow("exam_group","AND id=".$val['exam_group']);
												  $result2   = $objgen->get_Onerow("exmas","AND id=".$val['exam']);
												  
												   
												   $result3   		= $objgen->get_Onerow("section","AND id='".$val['section']."'");
												   $result4   		= $objgen->get_Onerow("subject","AND id='".$val['subject']."'");
												   $result5   		= $objgen->get_Onerow("module","AND id='".$val['module']."'");
					   
					   $question_type   = $val['question_type'];
					   
					      $where = " and question_id=".$val['id'];
						  $row_count2 = $objgen->get_AllRowscnt("answer",$where);
						  if($row_count2>0)
						  {
							 $res_arr2 = $objgen->get_AllRows("answer",0,$row_count2,"id asc",$where);
							// $res_arr5 = $objgen->get_AllRows("answer",0,$row_count2,"rand()",$where);
  
												  
							 
						  }
						  
						if($question_type==1)
						{
						   $qtyp='Multiple Choice (Radiobutton)';
						}
						
						
						if($question_type==2)
						{
						   $qtyp='Multiple Choice (Dropdown)';
						}
						
						
						if($question_type==3)
						{
						  $qtyp='Multiple Correct';
						}
						
						
						if($question_type==4)
						{
						   $qtyp='Fill in the Blank';
						}
						
					
						if($question_type==5)
						{
						   	$qtyp='Drag and Match';
						}
						
						if($question_type==6)
						{
						   $qtyp='Matching';
						}
						
						
						if($question_type==7)
						{
						   $qtyp='Essay (Evaluated by Admin)';
						}
						
						
						if($question_type==8)
						{
						   $qtyp='True/False';
						}
						
						
						if($question_type==9)
						{
						   $qtyp='Yes/No';
						}
		  
						?>
                                            <tr>
                                                <td><input name="check[]" type="checkbox" value="<?php echo $val['id']; ?>"  class="case" ></td>
                                                <td><?php echo $s_num; ?></td>
                                                <td><!--<b><?php echo $val['id']; ?>.</b>&nbsp;		-->									<?php echo $objgen->basedecode($val['question']); ?></td>
                                                <td><?=$qtyp?></td>
												<td><?php echo $objgen->check_tag($result['name']); ?></td>
												<td><?php echo $objgen->check_tag($result2['exam_name']); ?></td>
                                                <td><?php echo $objgen->check_tag($result3['name']); ?></td>
                                                <td><?php
												   if($val['img_status']==2)
												   {
													    echo "<span style='color:red'>Need</span>";
												   }
												   else
												   {
													    echo "<span style='color:green'>Nil</span>";
												   }
												 ?></td>
                                                <td><?php echo $objgen->check_tag($val['file_name']); ?></td>
                                                <td><a href="javascript:void(0);" role="button"  data-toggle="modal" data-target="#myModal<?php echo $val['id']; ?>" ><span class="fa fa-search-plus"></span></a>
           
            
               <!-- Modal -->
            <div class="modal fade" id="myModal<?php echo $val['id']; ?>" tabindex="-1" role="dialog" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">QID : <?php echo $val['id']; ?> [<?=$qtyp?>]</h4>
                  </div>
                  <div class="modal-body">
                
                  <?php
				  if($val['direction_id']!=0)
				  {
					  $dir_det   = $objgen->get_Onerow("direction","AND id=".$val['direction_id']);
				 ?>
                   <div class="rcorners1" >
                   <?=$objgen->basedecode($dir_det['direction'])?>
                   </div>
                   <br clear="all" />
                 <?php
				  }
				  ?>
                  
                  <div>
                   <?php echo $val['id']; ?> . <?php echo $objgen->basedecode($val['question']); ?>
                   </div>
                   <br clear="all" />
                   
                   <?php
				if($row_count2>0)
				 {
				   if($question_type==1 || $question_type==8 || $question_type==9)
							  {
								  foreach($res_arr2 as $key2=>$val2)
								  {
																		  
									    $cls = "info";
									    if($val2['right_ans']=='yes')
				     						$cls = "success";
									  
									  								       
								?>
                                 <div class="form-group"> <?=$alphas[$key2]?>&nbsp;&nbsp;
                                     <div class="radio radio-<?=$cls?> radio-inline">
                                           
                                         <input type="radio"  value="" id="answer<?=$key+1?><?=$key2+1?>" name="answerrdo<?=$key+1?>" <?php  if($val2['right_ans']=='yes') { ?> checked="checked" <?php } ?> />
                                         
                                        <label for="answer<?=$key+1?><?=$key2+1?>">
                                          <?=$objgen->basedecode($val2['answer'])?>
                                        </label>
                                      </div>
                                  </div>
                                <?php	   
									  
								
						  }
					 }
					 ?>
               
                      <?php
					 if($question_type==2)
							  {
								 ?>     
                                  <div class="form-group col-md-4">
                                 	<select name="ans" class="form-control" >
                                    <option value="">Select</option>
                                    <?php
								  foreach($res_arr2 as $key2=>$val2)
								  {
																		  
																  								       
								?>
                                   <option value="<?=$objgen->basedecode($val2['answer'])?>"><?=$objgen->basedecode($val2['answer'])?></option>
                                                  
                                <?php	   
								
						  }
						  ?>
                          </select>
                          <?php
						  
						    echo "<br /><b>Corerct Ans : </b> <span class='label label-success'>".$objgen->basedecode($val2['answer'])."</span>";
					
					 ?>
                     </div>
                     <?php
				 }
					?>
                    
                   <?php 
				   if($question_type==3)
							  {
								  foreach($res_arr2 as $key2=>$val2)
								  {
																		  
									    $cls = "info";
									    if($val2['right_ans']=='yes')
				     						$cls = "success";
									  
									  								       
								?>
                                 <div class="form-group"> <?=$alphas[$key2]?>&nbsp;&nbsp;
                                     <div class="checkbox checkbox-<?=$cls?> checkbox-inline">
                                           
                                         <input type="checkbox"  value="" id="chkanswer<?=$key+1?><?=$key2+1?>" name="answerchk<?=$key+1?>" <?php  if($val2['right_ans']=='yes') { ?> checked="checked" <?php } ?> />
                                         
                                        <label for="chkanswer<?=$key+1?><?=$key2+1?>">
                                          <?=$objgen->basedecode($val2['answer'])?>
                                        </label>
                                      </div>
                                  </div>
                                <?php	   
	
						  }
					 }
					 ?>
                     
                       <?php
					 if($question_type==4)
							  {
								 ?>     
                                  <div>
                         
                                    <?php
								  foreach($res_arr2 as $key2=>$val2)
								  {
																		  
						
						  
						    echo "<br /><b>Corerct Ans : </b> <span class='label label-success'>".$objgen->basedecode($val2['answer'])."</span>";
								  }
					
					 ?>
                     </div>
                     <?php
				        }
					?>
                    <?php
						if($question_type==6)
						{
							$answermatch = array();
							$pair = array();
							$corrans = array();
									  
							foreach($res_arr2 as $key2=>$val2)
							{
					
							
								 $ans = $objgen->basedecode($val2['answer']);
								$ansty   				= $objgen->get_Onerow("answer","AND question_id=".$val['id']." and  	curr_order_id =".$val2['match_id']);
								 $corrans[$key2]        = $objgen->basedecode($ansty['answer']);
								 
								 if(!in_array($ans,$corrans))
								 {
								   $pair[$key2] 			=  $ans;
								 }
								 else
								 {
									 $pair2[] 			=  $ans;
								 }
						
						
							}
							
							shuffle($pair2);
							
							foreach($pair as $key3=>$val3)
							{
								 
							?>
                             <div class="row" >
							   <div class="form-group" style="clear:both"> 
                               <div class="col-md-3"  style="margin:5px;" >
							   <?=$alphas[$key3]?>&nbsp;&nbsp;<?=$val3?>
                               </div>
                                <div class="col-md-2" style="margin:5px;">
                                <i class='fa fa-long-arrow-right'></i>
                                </div>
                               <div class="col-md-3" style="margin:5px;">
                               <select name="ans" class="form-control" >
                                    <option value="">Select</option>
                                    <?php
								  foreach($pair2 as $key2=>$val2)
								  {
																		  
																  								       
								?>
                                   <option value="<?=$val2?>"><?=$val2?></option>
                                                  
                                <?php	   
								
								  }
								  ?>
								  </select>
                                  </div>
                                  <div class="col-md-3"  style="margin:5px;" >
                               <b>Correct Ans :</b>&nbsp;<?=$corrans[$key3]?>
                               </div>
                               
                               </div>
                               </div>
                            <?php
							}
						}
                     ?>
                     
                        <?php
						if($question_type==5) // drag & drop
						{
							$answermatch = array();
							$pair = array();
							$pair2 = array();
							$corrans = array();
							
							//  print_r($res_arr2);
							foreach($res_arr2 as $key2=>$val2)
							{
					
							    $ans = $objgen->basedecode($val2['answer']);
								
								$ansty   				= $objgen->get_Onerow("answer","AND question_id=".$val['id']." and  	curr_order_id =".$val2['match_id']);
								$corrans[$key2]        = $objgen->basedecode($ansty['answer']);
								
								//print_r($corrans);
								 
								 if(!in_array($ans,$corrans))
								 {
								   $pair[$key2] =  $ans;
								 }
								 else
								 {
									 $pair2[] 	=  $ans;
								 }
						
							}
							
							//print_r($pair2);
							
							shuffle($pair2);
							
							//print_r($pair2);
							
							//print_r($pair);
							$m=0;
							foreach($pair as $key3=>$val3)
							{
							 	 
							?>
                             <div class="row" >
							   <div class="form-group" style="clear:both"> 
                              		
                                     <div class="col-md-1" style="margin:5px;">
									<?=$alphas[$key3]?>&nbsp;&nbsp;
                                    </div>
                                    <div class="col-md-4"  style="margin:5px;" >
                               			<div class="dragdrop2"  ondragstart="drag(event)" name="<?=$corrans[$key3]?>" draggable="true"  id="drg<?=$key3?>"   >
                                        <div style="position:absolute;padding:5px;">
							   				<?=$val3?>
                                          </div>
                              			 </div>
                               		</div>
                                <div class="col-md-1" style="margin:5px;">
                                	<i class='fa fa-long-arrow-right'></i>
                                </div>
                               <div class="col-md-4" style="margin:5px;">
                               
                                        <div class="dragdrop"  ondrop="drop(event)" ondragover="allowDrop(event)" id="<?=$pair2[$m]?>" >
                                        <div style="position:absolute;padding:5px;">
                                        <?=$pair2[$m]?>
                                         </div>
                                         </div>
                                                    
                                  </div>
                                  <div class="col-md-2"  style="margin:5px;" >
                               <b>Correct Ans :</b>&nbsp;<?=$corrans[$key3]?>
                               </div>
                               
                               </div>
                               </div>
                            <?php
							  $m++;
							}
						}
                     ?>
                     
                     <?php
				 }
				 ?>
                  
                    <hr />
             
                    <?php
                    if($val['quest_det']!="")
					{
                    ?>
                    <div class="row rcorners1" style="clear:both" >
                  <b> Explanation :</b> <?php echo $objgen->basedecode($val['quest_det']); ?>
                   </div>
                    <br />
                   <?php
					}
					?>
                    
                   <div class="row" style="clear:both">
                   
                     <div class="col-md-6 rcorners1"> 
                   
                        <div class="col-md-4">  
                       <b> Group :</b> <?php echo $objgen->check_tag($result['name']); ?> 
                       </div>
                      <div class="col-md-4">   
                       <b> Exam :</b> <?php echo $objgen->check_tag($result2['exam_name']); ?> 
                       </div>
                       <div class="col-md-4">  
                        <b>Section :</b> <?php echo $result3['name']; ?> 
                        </div>
                        <div class="col-md-4">  
                        <b>Subject :</b> <?php echo $result4['name']; ?> 
                        </div>
                        <div class="col-md-4">  
                        <b>Module :</b> <?php echo $result5['name']; ?>
                        </div>
                    
                   </div>
                   	<div class="col-md-2"></div>
          			<div class="col-md-4  rcorners1" >
                    
                        <div class="col-md-6">
                         <b> Mark :</b> <?php echo $val['mark']; ?> 
                       </div>
                        <div class="col-md-6">
                       <b> Negative :</b> <?php echo $val['negative_per']; ?>%
                       </div>
                        <div class="col-md-6">  
                       <b>Difficulty :</b> <?php echo $val['difficulty']; ?>
                       </div>
                   </div>
               
                   
                 
                  </div>
                   
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-white" data-dismiss="modal">Close</button>
                    </div>
                </div>
              </div>
            </div>

          <!-- End Moda Code -->                                    
                                                
                                                </td>
                                                <td>
												<?php
												if($val['status']=='active')
												{
												?>
												<a href="<?=$list_url?>/?id=<?=$val['id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" ><span class="fa fa-unlock"></span></a>
												<?php
												}
												else
												{
												?>
												<a href="<?=$list_url?>/?id=<?=$val['id']?>&page=<?=$page?>&st=<?php echo $val['status']; ?>" role="button" ><span class="fa fa-lock"></span></a>
												<?php
												}
												?>
												</td>
                                                <td><a href="<?=$add_url?>/?edit=<?=$val['id']?>&page=<?=$page?>" role="button" ><span class="fa fa-edit"></span></a></td>
                                                <td><a href="<?=$list_url?>/?del=<?=$val['id']?>&page=<?=$page?>" role="button" onClick="return confirm('Do you want to delete this Question?')"><span class="fa fa-trash-o"></span></a></td>
                                            </tr>
                                          
                                         <?php
												}
											}
										 ?>
                                        </tbody>
                                       
                                    </table>
                                    <br clear="all" />
									<?php
								//	echo $row_count;
									//echo "pz".$pagesize;
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
      
      </form>
      
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
<script>
function listdata() 
{
			  
	 var m = $("#exam").val();
		 $.ajax({
				type: "GET",
				dataType: "json",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 3,  m : m  },
				success: function (result) {
					
				$('#section').html(result["section"]);
				$('#subject').html(result["subject"]);
				$('#module').html(result["module"]);
				
			}
		});
				 
}
</script>
<script language="JavaScript">
$(document).ready(function(){
    $('#selectall').on('click',function(){
        if(this.checked){
            $('.case').each(function(){
                this.checked = true;
            });
        }else{
             $('.case').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.case').on('click',function(){
        if($('.case:checked').length == $('.case').length){
            $('#selectall').prop('checked',true);
        }else{
            $('#selectall').prop('checked',false);
        }
    });
});
</script>

</body>
</html>