<?php
require_once "includes/includepath.php";
$objgen		=	new general();

if($_GET['pid']==1)
{
	
$m = $_GET['m'];
$where = " and exam_id=".$m;
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



	
	
            $section = '<select class="form-control" name="section" required >
											<option value="" selected="selected">Select</option>';
									
											if($section_count>0)
											{
											 foreach($section_arr as $key=>$val)
											 {
										
											$section .= '<option value="'.$val['id'].'"';
											 										 
											$section .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$section .= '</select>';
							
			
            $subject = '<select class="form-control" name="subject" required >
											<option value="" selected="selected">Select</option>';
									
											if($subject_count>0)
											{
											 foreach($subject_arr as $key=>$val)
											 {
										
											$subject .= '<option value="'.$val['id'].'"';
											$subject .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$subject .= '</select>';
                                        
										
										
				
            $module = '<select class="form-control" name=" module" required >
											<option value="" selected="selected">Select</option>';
									
											if($module_count>0)
											{
											 foreach($module_arr as $key=>$val)
											 {
										
											$module .= '<option value="'.$val['id'].'"';
								 
											$module .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$module .= '</select>';
                                        
                                        


   
   $return["section"] = $section;
   $return["subject"] = $subject;
   $return["module"]  = $module;
   echo json_encode($return);
}
if($_POST['pid']==2)
{
    $direction_name	 	= $objgen->check_input($_POST['n']);
	$direction	    	= $_POST['n'];	
	
    $msg = $objgen->ins_Row('direction','direction_name,direction',"'".$direction_name."','".$objgen->baseencode($direction)."'");
	
	$direction_id = $objgen->get_insetId();
	
	$msg = '<div class="alert alert-success alert-dismissable">
               <i class="fa fa-check"></i>
               <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
               <b>Alert!</b> Direction Created Successfully.
             </div>';
   
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
				 
   $dirdiv = $dir_det;
	
   $return["dirdiv"] = $dirdiv;
   $return["msg"]	 = $msg;
 
   echo json_encode($return);
   
}
if($_GET['pid']==3)
{
	
$m = $_GET['m'];
$where = " and exam_id=".$m;
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



	
	
            $section = '<select class="form-control" name="section"  >
											<option value="" selected="selected">Select</option>';
									
											if($section_count>0)
											{
											 foreach($section_arr as $key=>$val)
											 {
										
											$section .= '<option value="'.$val['id'].'"';
											 										 
											$section .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$section .= '</select>';
							
			
            $subject = '<select class="form-control" name="subject"  >
											<option value="" selected="selected">Select</option>';
									
											if($subject_count>0)
											{
											 foreach($subject_arr as $key=>$val)
											 {
										
											$subject .= '<option value="'.$val['id'].'"';
											$subject .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$subject .= '</select>';
                                        
										
										
				
            $module = '<select class="form-control" name=" module"  >
											<option value="" selected="selected">Select</option>';
									
											if($module_count>0)
											{
											 foreach($module_arr as $key=>$val)
											 {
										
											$module .= '<option value="'.$val['id'].'"';
								 
											$module .= '>'.$objgen->check_tag($val['name']).'</option>';
										
											  }
											}
											
							$module .= '</select>';
                                        
                                        


   
   $return["section"] = $section;
   $return["subject"] = $subject;
   $return["module"]  = $module;
   echo json_encode($return);
}
if($_GET['pid']==4)
{

$id = $_GET['id'];	
$where = " and exam_id=".$id;
$section_count = $objgen->get_AllRowscnt("section",$where);
if($section_count>0)
{
  $section_arr = $objgen->get_AllRows("section",0,$section_count,"name asc",$where);
}

?>

<div><div>
<br clear="all" /><br clear="all" />
<div class="col-md-4" >
                                             <input type="text" class="form-control"  name="no_of_qu[]"  placeholder="NO OF QUE."  />
                                             </div>
                                              <div class="col-md-6" >
                                             <select class="form-control" name="section_id[]"   >
											<option value="" selected="selected">SECTION</option>
											<?php
											if($section_count>0)
											{
											 foreach($section_arr as $key=>$val)
											 {
												  $result  = $objgen->get_Onerow("exmas","AND id=".$val['exam_id']);
											?>
											<option value="<?=$val['id']?>" ><?=$objgen->check_tag($val['name'])?> (<?=$objgen->check_tag($result['exam_name'])?>)</option>
											<?php
											  }
											}
											?>
										</select>
                                        
                                        </div>
                                        <div class="col-md-2" >
                                          <a href="javascript:void(0)" class="remove_field"><span class="fa fa-trash"></span></a>
                                          </div>
                                          
</div></div>                                     
<?php
}
if($_GET['pid']==5)
{
	 $id = $_GET['id'];
	 $result  = $objgen->get_Onerow("section_list","AND id=".$id);
	 $exam_list_id 	= $result['exam_list_id']; 	
	 $no_of_qu 	= $result['no_of_qu'];
	 
	 $msg = $objgen->upd_Row('exam_list',"totno_of_qu=totno_of_qu-".$no_of_qu,"id=".$exam_list_id);
	 $msg     = $objgen->del_Row("section_list","id=".$id);
	
}

if($_GET['pid']==6)
{
	
$id = $_GET['id'];
$where = " and group_id=".$id;
$exam_count = $objgen->get_AllRowscnt("exmas",$where);
if($exam_count>0)
{
  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"exam_name asc",$where);
}

            $examsec = '<select class="form-control" name="exam_id"  id="exam_id" onChange="sectionlist(this.value)"  >
											<option value="" selected="selected">Select</option>';
									
											if($exam_count>0)
											{
											 foreach($exam_arr as $key=>$val)
											 {
										
											$examsec .= '<option value="'.$val['id'].'"';
											 										 
											$examsec .= '>'.$objgen->check_tag($val['exam_name']).'</option>';
										
											  }
											}
											
							$examsec .= '</select>';

   echo $examsec;
}
if($_GET['pid']==7)
{
	
$id = $_GET['id'];	
$where = " and exam_id=".$id;
$section_count = $objgen->get_AllRowscnt("section",$where);
if($section_count>0)
{
  $section_arr = $objgen->get_AllRows("section",0,$section_count,"name asc",$where);
}

?>

<div><div>
<br clear="all" /><br clear="all" />
<div class="col-md-4" >
                                             <input type="text" class="form-control"  name="no_of_qu[]"  placeholder="NO OF QUE."  />
                                             </div>
                                              <div class="col-md-6" >
                                             <select class="form-control" name="section_id[]"   >
											<option value="" selected="selected">SECTION</option>
											<?php
											if($section_count>0)
											{
											 foreach($section_arr as $key=>$val)
											 {
												  $result  = $objgen->get_Onerow("exmas","AND id=".$val['exam_id']);
											?>
											<option value="<?=$val['id']?>" ><?=$objgen->check_tag($val['name'])?> (<?=$objgen->check_tag($result['exam_name'])?>)</option>
											<?php
											  }
											}
											?>
										</select>
                                        
                                        </div>
                                        <div class="col-md-2" >
                                          <a href="javascript:void(0)" class="remove_field"><span class="fa fa-trash"></span></a>
                                          </div>
                                          
</div></div>                                     
<?php
}
?>




