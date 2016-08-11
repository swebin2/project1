<?php
require_once "includes/includepath.php";
require_once "chk_login.php";
require_once "chk_type.php";
$objval	=   new validate();
$objgen		=	new general();

$pagehead = "Exam";
$list_url = URLAD."manage-exam";
$add_url  = URLAD."add-exam-list";

$hideans = "hideans";
$hideans2 = "";

$avaibility 	= "always";
$exam_assign 	= "group";

$explanation    = "no";

$page	 	= isset($_REQUEST['page'])	?	$_REQUEST['page']	:	"1";

if($_GET['msg']==1)
{
  $msg2 = "Exam Created Successfully.";
}

if(isset($_POST['Create']))
{
   
   $exam_name	 = $objgen->check_input($_POST['exam_name']);
   $group_id	 = $objgen->check_input($_POST['group_id']);
   $exam_id   	 = $objgen->check_input($_POST['exam_id']);
   $duration   	 = $objgen->check_input($_POST['duration']);
   $neagive_mark = $objgen->check_input($_POST['neagive_mark']);
   $avaibility   = $objgen->check_input($_POST['avaibility']);
   $start_date   = $objgen->check_input($_POST['start_date']);
   $end_date 	 = $objgen->check_input($_POST['end_date']);
   $exam_assign  = $objgen->check_input($_POST['exam_assign']);
   $link_add 	 = $objgen->check_input($_POST['link_add']);
   $explanation  = $objgen->check_input($_POST['explanation']);
   
   if($start_date!="")
	{
	   $start_date1   = date("Y-m-d H:i:s",strtotime($_POST['start_date']));
	}
   
    if($end_date!="")
	{
		$end_date1   = date("Y-m-d H:i:s",strtotime($_POST['end_date']));
	}
	
   $rules		=	array();
   $rules[] 	= "required,exam_name,Enter the Exam Name";
   $errors  	= $objval->validateFields($_POST, $rules);
   

   if(empty($errors))
	{
		 
		 $msg = $objgen->ins_Row('exam_list','exam_name,group_id,exam_id,duration,neagive_mark,avaibility,start_date,end_date,exam_assign,link_add,explanation',"'".$exam_name."','".$group_id."','".$exam_id."','".$duration."','".$neagive_mark."','".$avaibility."','".$start_date1."','".$end_date1."','".$exam_assign."','".$link_add."','".$explanation."'");
		 
		  $insrt = $objgen->get_insetId();
		  
		  $totno_of_qu = 0;
		  
		 if($msg=="")
		 {
			  for($i=0; $i < count($_POST['no_of_qu']);$i++)
              {
				$no_of_qu = $objgen->check_input($_POST['no_of_qu'][$i]);
				$section_id = $objgen->check_input($_POST['section_id'][$i]);	
				
				if($no_of_qu!="")
				{
				 $totno_of_qu += $no_of_qu;
					 
				  $msg = $objgen->ins_Row('section_list','section_id,no_of_qu,exam_list_id',"'".$section_id."','".$no_of_qu."','".$insrt."'");	 
				}
			  }
			  
			    $msg = $objgen->upd_Row('exam_list',"totno_of_qu='".$totno_of_qu."'","id=".$insrt);
			   
			   header("location:".$add_url."/?msg=1");
		 }
	}
}

if(isset($_GET['edit']))
{

       $id = $_GET['edit'];
	   $result   = $objgen->get_Onerow("exam_list","AND id=".$id);
	   $exam_name    = $objgen->check_tag($result['exam_name']);
	   $group_id     = $objgen->check_tag($result['group_id']);
	   $exam_id      = $objgen->check_tag($result['exam_id']);
	   $duration     = $objgen->check_tag($result['duration']);
	   $neagive_mark = $objgen->check_tag($result['neagive_mark']);
	   $avaibility   = $objgen->check_tag($result['avaibility']);
	   $explanation  = $objgen->check_tag($result['explanation']);
	   
	   
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
	   
	    $where = " and exam_list_id=".$id;
	    $secli_count = $objgen->get_AllRowscnt("section_list",$where);
		if($secli_count>0)
		{
		  $secli_arr = $objgen->get_AllRows("section_list",0,$secli_count,"id asc",$where);
		}

	

}
if(isset($_POST['Update']))
{  

   $exam_name	 = $objgen->check_input($_POST['exam_name']);
   $group_id	 = $objgen->check_input($_POST['group_id']);
   $exam_id   	 = $objgen->check_input($_POST['exam_id']);
   $duration   	 = $objgen->check_input($_POST['duration']);
   $neagive_mark = $objgen->check_input($_POST['neagive_mark']);
   $avaibility   = $objgen->check_input($_POST['avaibility']);
   $start_date   = $objgen->check_input($_POST['start_date']);
   $end_date 	 = $objgen->check_input($_POST['end_date']);
   $exam_assign  = $objgen->check_input($_POST['exam_assign']);
   $link_add 	 = $objgen->check_input($_POST['link_add']);
    $explanation  = $objgen->check_input($_POST['explanation']);
   
   if($start_date!="")
	{
	   $start_date1   = date("Y-m-d H:i:s",strtotime($_POST['start_date']));
	}
   
    if($end_date!="")
	{
		$end_date1   = date("Y-m-d H:i:s",strtotime($_POST['end_date']));
	}
	
	
   $rules		=	array();
   $rules[] 	= "required,exam_name,Enter the Exam Name";
   $errors  	= $objval->validateFields($_POST, $rules);
   

   if(empty($errors))
	{
		 			 
	  $msg = $objgen->upd_Row('exam_list',"exam_name='".$exam_name."',group_id='".$group_id."',exam_id='".$exam_id."',duration='".$duration."',neagive_mark='".$neagive_mark."',avaibility='".$avaibility."',start_date='".$start_date1."',end_date='".$end_date1."',exam_assign='".$exam_assign."',link_add='".$link_add."',explanation='".$explanation."'","id=".$id);
	  
	  if($msg=="")
	  {
		  
		    for($i=0; $i < count($_POST['no_of_qu']);$i++)
              {
				$no_of_qu = $objgen->check_input($_POST['no_of_qu'][$i]);
				$section_id = $objgen->check_input($_POST['section_id'][$i]);	
				
				if($no_of_qu!="")
				{
				   $totno_of_qu += $no_of_qu;
				  $msg = $objgen->ins_Row('section_list','section_id,no_of_qu,exam_list_id',"'".$section_id."','".$no_of_qu."','".$id."'");
						 
				}
			  }
			  
	      $msg = $objgen->upd_Row('exam_list',"totno_of_qu='".$totno_of_qu."'","id=".$id);
			  
		  header("location:".$list_url."/?msg=2&page=".$page);
	  }
	  
	}
}
if(isset($_POST['Cancel']))
{
	 header("location:".$list_url);

}

$where = "";
$group_count = $objgen->get_AllRowscnt("exam_group",$where);
if($group_count>0)
{
  $group_arr = $objgen->get_AllRows("exam_group",0,$group_count,"name asc",$where);
}

$exam_count = 0;

if($group_id!=0)
{

	$where = " and group_id=".$group_id;
	$exam_count = $objgen->get_AllRowscnt("exmas",$where);
	if($exam_count>0)
	{
	  $exam_arr = $objgen->get_AllRows("exmas",0,$exam_count,"exam_name asc",$where);
	}


	if($exam_id !=0)
	{
		$where = " and exam_id=".$exam_id;
		$section_count = $objgen->get_AllRowscnt("section",$where);
		if($section_count>0)
		{
		  $section_arr = $objgen->get_AllRows("section",0,$section_count,"name asc",$where);
		}
	}


}

if($avaibility=="specific")
 $hideans = "";
 
/*if($exam_assign=="link")
 $hideans2 = "hideans";*/


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

}
.hideans
{
 display:none;
}
</style>
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
  
   <form role="form" action="" method="post" enctype="multipart/form-data" >
   
    <div class="col-md-12 col-lg-6">
      <div class="panel panel-default">

        <div class="panel-title">
        Enter <?=$pagehead?> Informations
         
        </div>

            <div class="panel-body">
               
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
									  <label for="input1" class="form-label">Exam Name *</label>
										<input type="text" class="form-control" value="<?=$exam_name?>" name="exam_name"  required />
									</div>
                               
									
                                        
                                      <div class="form-group">
									  <label for="input1" class="form-label">Duration *</label>
                                      
                                  <select id="duration" name="duration" class="form-control" required >
                                    <option value="">Select</option>
                                    <option value="00:01">00:01</option>
                                    <option value="00:02">00:02</option>
                                    <option value="00:03">00:03</option>
                                    <option value="00:04">00:04</option>
                                    <option value="00:05">00:05</option>
                                    <option value="00:06">00:06</option>
                                    <option value="00:07">00:07</option>
                                    <option value="00:08">00:08</option>
                                    <option value="00:09">00:09</option>
                                    <option value="00:10">00:10</option>
                                    <option value="00:11">00:11</option>
                                    <option value="00:12">00:12</option>
                                    <option value="00:13">00:13</option>
                                    <option value="00:14">00:14</option>
                                    <option value="00:15">00:15</option>
                                    <option value="00:16">00:16</option>
                                    <option value="00:17">00:17</option>
                                    <option value="00:18">00:18</option>
                                    <option value="00:19">00:19</option>
                                    <option value="00:20">00:20</option>
                                    <option value="00:21">00:21</option>
                                    <option value="00:22">00:22</option>
                                    <option value="00:23">00:23</option>
                                    <option value="00:24">00:24</option>
                                    <option value="00:25">00:25</option>
                                    <option value="00:26">00:26</option>
                                    <option value="00:2">00:27</option>
                                    <option value="00:28">00:28</option>
                                    <option value="00:29">00:29</option>
                                    <option value="00:30">00:30</option>
                                    <option value="00:31">00:31</option>
                                    <option value="00:32">00:32</option>
                                    <option value="00:33">00:33</option>
                                    <option value="00:34">00:34</option>
                                    <option value="00:35">00:35</option>
                                    <option value="00:36">00:36</option>
                                    <option value="00:37">00:37</option>
                                    <option value="00:38">00:38</option>
                                    <option value="00:39">00:39</option>
                                    <option value="00:40">00:40</option>
                                    <option value="00:41">00:41</option>
                                    <option value="00:42">00:42</option>
                                    <option value="00:43">00:43</option>
                                    <option value="00:44">00:44</option>
                                    <option value="00:45">00:45</option>
                                    <option value="00:46">00:46</option>
                                    <option value="00:47">00:47</option>
                                    <option value="00:48">00:48</option>
                                    <option value="00:49">00:49</option>
                                    <option value="00:50">00:50</option>
                                    <option value="00:51">00:51</option>
                                    <option value="00:52">00:52</option>
                                    <option value="00:53">00:53</option>
                                    <option value="00:54">00:54</option>
                                    <option value="00:55">00:55</option>
                                    <option value="00:56">00:56</option>
                                    <option value="00:57">00:57</option>
                                    <option value="00:58">00:58</option>
                                    <option value="00:59">00:59</option>
                                    <option value="01:00">01:00</option>
                                    <option value="01:15">01:15</option>
                                    <option value="01:30">01:30</option>
                                    <option value="01:45">01:45</option>
                                    <option value="02:00">02:00</option>
                                    <option value="02:15">02:15</option>
                                    <option value="02:30">02:30</option>
                                    <option value="02:45">02:45</option>
                                    <option value="03:00">03:00</option>
                                    <option value="03:15">03:15</option>
                                    <option value="03:30">03:30</option>
                                    <option value="Untimed">Untimed</option>
                               </select>
                            								
									</div>
                                    
                                     <div class="form-group">
									  <label for="input1" class="form-label">Negative Mark (%)</label>
                                      <select id="neagive_mark" name="neagive_mark" class="form-control">
                                        <option value="0">Do not apply</option>
                                        <option value="-1">Apply from question bank</option>
                                        <option value="10">Apply 10% negative marks for this exam</option>
                                        <option value="25">Apply 25% negative marks for this exam</option>
                                        <option value="33">Apply 33% negative marks for this exam</option>
                                        <option value="50">Apply 50% negative marks for this exam</option>
                                        <option value="75">Apply 75% negative marks for this exam</option>
                                  		</select>
        								
									</div>
                                    
                                      <div class="form-group">
									  <label for="input1" class="form-label">Show Explanation</label><br clear="all" />
                                      <div class="radio radio-info radio-inline">
									  <input name="explanation" id="explanation1" type="radio" value="yes" <?php if($explanation=="yes") { ?> checked="checked" <?php } ?>  > <label for="explanation1">Yes</label>
                                      </div>
                                      <br clear="all" />
                                      <div class="radio radio-info radio-inline">
                                      <input name="explanation" id="explanation2" type="radio" value="no" <?php if($explanation=="no") { ?> checked="checked" <?php } ?> > <label for="explanation2">No</label>
                                      </div>
									</div>
                                    
                                    
                                    <div class="form-group">
									  <label for="input1" class="form-label">Exam Avaibility</label><br clear="all" />
                                      <div class="radio radio-info radio-inline">
									  <input name="avaibility" id="avaibility1" type="radio" value="always" onClick="show_date('always')" <?php if($avaibility=="always") { ?> checked="checked" <?php } ?>  > <label for="avaibility1">Always available</label>
                                      </div>
                                      <br clear="all" />
                                      <div class="radio radio-info radio-inline">
                                      <input name="avaibility" id="avaibility2" type="radio" value="specific" onClick="show_date('specific')" <?php if($avaibility=="specific") { ?> checked="checked" <?php } ?> > <label for="avaibility2">Available on specific time</label>
                                      </div>
									</div>
                                    
                                       <div id="date_show" class="col-md-12 rcorners1 <?=$hideans?>" >
                                           <div class="form-group">
                                             <label class="form-label">Start Date & Time</label>
                                           <input type="text" class="form-control" value="<?=$start_date?>" name="start_date"   id="start_date"   />
                                          </div>
                                           <div class="form-group">
                                             <label class="form-label">End Date & Time</label>
                                           <input type="text" class="form-control" value="<?=$end_date?>" name="end_date"  id="end_date"    />
                                          </div>
                                      </div> 
                                                                    
                                     <div class="form-group">
									  <label for="input1" class="form-label">Assign this exam to</label><br clear="all" />
                                      <div class="radio radio-info radio-inline">
									  <input name="exam_assign" id="exam_assign1" type="radio" value="group"   <?php if($exam_assign=="group") { ?> checked="checked" <?php } ?> > <label for="exam_assign1">Groups (For registered candidates)</label>
                                      </div>
                                      <br clear="all" />
                                      <div class="radio radio-info radio-inline">
                                      <input name="exam_assign" id="exam_assign2" type="radio" value="link"   <?php if($exam_assign=="link") { ?> checked="checked" <?php } ?> > <label for="exam_assign2">Links (Candidate registration not required)</label>
                                      </div>
									</div>
                                    
                                    <div id="group_show" class="col-md-12 rcorners1 <?=$hideans2?>" >
                                    
                                      <div class="form-group">
										  <label for="input3"  class="form-label">Group</label>
										  <select class="form-control" name="group_id" onChange="showexam(this.value)"  >
											<option value="" selected="selected">Select</option>
											<?php
											if($group_count>0)
											{
											 foreach($group_arr as $key=>$val)
											 {
											?>
											<option value="<?=$val['id']?>" <?php if($group_id==$val['id']) { ?> selected="selected" <?php } ?> ><?=$objgen->check_tag($val['name'])?></option>
											<?php
											  }
											}
											?>
										</select>
										</div>
                                        
                                     <div id="examlist">
									  <div class="form-group">
										  <label for="input3"  class="form-label">Exam</label>
										  <select class="form-control" name="exam_id" id="exam_id" onChange="sectionlist(this.id)"   >
											<option value="" selected="selected">Select</option>
											<?php
											if($exam_count>0)
											{
											 foreach($exam_arr as $key=>$val)
											 {
											?>
											<option value="<?=$val['id']?>" <?php if($exam_id==$val['id']) { ?> selected="selected" <?php } ?> ><?=$objgen->check_tag($val['exam_name'])?></option>
											<?php
											  }
											}
											?>
										</select>
										</div>
                                      </div>
								
									</div>	
                        

            </div>

      </div>
    </div>
    
    
    <div class="col-md-12 col-lg-6">
      <div class="panel panel-default">

        <div class="panel-title">
       SpecifyNumber of questions. (From Your Question Bank)
         
        </div>

            <div class="panel-body">
               
			
                                     <div class="col-md-12 rcorners1" >
                                     
									  <div class="form-group">
                                      
                                    <!--    <label for="input3"  class="form-label">SpecifyNumber of questions. (From Your Question Bank)</label>-->
                                       
										<?php
										if($secli_count>0)
										{
											foreach($secli_arr as $key=>$val)
											{
												$result  = $objgen->get_Onerow("section","AND id=".$val['section_id']);
												$result2  = $objgen->get_Onerow("exmas","AND id=".$result['exam_id']);
											?>	
                                             <div style="padding:10px;border-bottom:1px dotted #666" id="sec<?=$val['id']?>">
                                        
                                               <div class="col-md-2" >
                                             <?php
												echo $objgen->check_tag($val['no_of_qu'])." que.";
												?>
                                                </div>
                                                  <div class="col-md-8" >
                                                  <?php
												   echo $objgen->check_tag($result['name'])." (".$objgen->check_tag($result2['exam_name']).")";
												?>
                                                  </div>
                                                    <div class="col-md-2" >
                                                     <a href="javascript:void(0)" onClick="rem_edit('<?=$val['id']?>')" ><span class="fa fa-trash"></span></a>
                                                    </div>
                                                    <br clear="all">
                                                </div>
                                              
                                                <?php
											}
										}
										?>
                                        
                                   <div id="sec_show">
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
                                       </div>
                                       
                                        <br clear="all" />	 <br clear="all" />	
                                       <div class="col-md-12" align="right" >
                                        <button class="btn btn-success btn-xs" type="button" name="add" onClick="addmore()"><span class="fa fa-plus"></span>&nbsp;Add More</button>
                                        </div>
                                         
                                      </div>	
                                     </div>
                                     <br clear="all" />	 <br clear="all" />	
												
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
										
    

             

            </div>

      </div>
    </div>
    
     </form>
     
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


<script>

$("#duration").val('<?=$duration?>');
$("#neagive_mark").val('<?=$neagive_mark?>');

	
	
	$(document).ready(function() {
  $('#start_date').daterangepicker({
    timePicker: true,
    timePickerIncrement: 1,
	 singleDatePicker: true,
    format: 'DD-MM-YYYY HH:mm'
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
  
   $('#end_date').daterangepicker({
    timePicker: true,
    timePickerIncrement: 1,
	 singleDatePicker: true,
     format: 'DD-MM-YYYY HH:mm'
  }, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
  
});
	
/*function show_group(val)
{
	if(val=="link")
	{
		$('#group_show').hide();
	}
	else
	{
		$('#group_show').show();
	}
}
*/
function show_date(val)
{
	if(val=="specific")
	{
		$('#date_show').show();
	}
	else
	{
		$('#date_show').hide();
	}
}

function addmore()
{
	
	var id = $('#exam_id').val();
	 $.ajax({
				type: "GET",
				dataType: "html",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 4, id :id },
				success: function (result) {
					
				$('#sec_show').append(result);
				
			}
		});
												   

								
}

function rem_edit(id)
{
	
	
	 $.ajax({
				type: "GET",
				dataType: "html",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 5, id : id },
				success: function (result) {
					
				$('#sec'+id).hide();
				
			}
		});
}

function showexam(id)
{
	
		 $.ajax({
				type: "GET",
				dataType: "html",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 6, id : id },
				success: function (result) {
					
				$('#examlist').html(result);
				
			}
		});
}

function sectionlist(id)
{
	 $.ajax({
				type: "GET",
				dataType: "html",
				url: "<?=URLAD?>ajax.php",
				data: {pid : 7, id :id },
				success: function (result) {
					
				$('#sec_show').html(result);
				
			}
		});
}

$('#sec_show').on("click",".remove_field", function(e){ //user click on remove text
	e.preventDefault(); $(this).parent('div').parent('div').remove(); 
});
</script>
</body>
</html>