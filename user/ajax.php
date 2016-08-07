<?php
require_once "includes/includepath.php";
$objgen		=	new general();

if($_GET['pid']==1)
{
	
?>
<div class="panel panel-widget">

        <div class="panel-body table-responsive">
        
        <?php
		if(count($_SESSION['exam'][$usrid]['qid'])>0)
		{
		
		
			  $result   		= $objgen->get_Onerow("question","AND id=".$_SESSION['exam'][$usrid]['qid'][0]);
			  
			  
			              $question_type   = $result['question_type'];
					   
					      $where = " and question_id=".$result['id'];
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
               <?php
				  if($result['direction_id']!=0)
				  {
					  $dir_det   = $objgen->get_Onerow("direction","AND id=".$result['direction_id']);
				 ?>
                   <div class="rcorners1" >
                   <?=$objgen->basedecode($dir_det['direction'])?>
                   </div>
                   <br clear="all" />
                 <?php
				  }
				  ?>
          <div><?php echo "<b>1.</b> ".$objgen->basedecode($result['question']); ?></div>
          
           <br />
                   
                   <?php
				if($row_count2>0)
				 {
				   if($question_type==1 || $question_type==8 || $question_type==9)
							  {
								  foreach($res_arr2 as $key2=>$val2)
								  {
																		  
									    $cls = "info";
									  
									  
									  								       
								?>
                                 <div class="form-group"> <?=$alphas[$key2]?>&nbsp;&nbsp;
                                     <div class="radio radio-<?=$cls?> radio-inline">
                                           
                                         <input type="radio"  value="<?=$objgen->basedecode($val2['answer'])?>" id="answer<?=$key+1?><?=$key2+1?>" name="answerrdo<?=$key+1?>"  />
                                         
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
																		  
									  								       
								?>
                                 <div class="form-group"> <?=$alphas[$key2]?>&nbsp;&nbsp;
                                     <div class="checkbox checkbox-<?=$cls?> checkbox-inline">
                                           
                                         <input type="checkbox"  value="<?=$objgen->basedecode($val2['answer'])?>" id="chkanswer<?=$key+1?><?=$key2+1?>" name="answerchk<?=$key+1?>"  />
                                         
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
                         
                                     <input name="answerfill"  class="form-control" value="" >
                     </div>
                     <?php
				        }
					?>
                    <?php
						if($question_type==6)
						{
							$answermatch = array();
							$pair = array();
							$pair2 = array();
									  
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
							
							@shuffle($pair2);
							
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
                                
                               
                               </div>
                               </div>
                            <?php
							}
						}
                     ?>
                     
                        <?php
						if($question_type==5)
						{
							$answermatch = array();
							$pair = array();
							$pair2 = array();
									  
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
							
							//print_r($pair2);
							
							@shuffle($pair2);
							
							//print_r($pair2);
							$m=0;
							foreach($pair as $key3=>$val3)
							{
							 	 
							?>
                             <div class="row" >
							   <div class="form-group" style="clear:both"> 
                              		
                                     <div class="col-md-1" style="margin:5px;">
									<?=$alphas[$key3]?>&nbsp;&nbsp;
                                    </div>
                                    <div class="col-md-3"  style="margin:5px;" >
                               			<div class="dragdrop2"  ondragstart="drag(event)" name="<?=$corrans[$key3]?>" draggable="true"  id="drg<?=$key3?>"   >
                                        <div style="position:absolute;padding:5px;">
							   				<?=$val3?>
                                          </div>
                              			 </div>
                               		</div>
                                <div class="col-md-1" style="margin:5px;">
                                	<i class='fa fa-long-arrow-right'></i>
                                </div>
                               <div class="col-md-3" style="margin:5px;">
                               
                                        <div class="dragdrop"  ondrop="drop(event)" ondragover="allowDrop(event)" id="<?=$pair2[$m]?>" >
                                        <div style="position:absolute;padding:5px;">
                                        <?=$pair2[$m]?>
                                         </div>
                                         </div>
                                                    
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
                  
                  
             
                    <?php
                    if($val['quest_det']!="")
					{
                    ?> 
                     <hr />
                    <div class="row rcorners1" style="clear:both" >
                  <b> Explanation :</b> <?php echo $objgen->check_tag($val['quest_det']); ?>
                   </div>
                    <br />
                   <?php
					}
					?>
        <?php
		
        }
        ?>
       
        </div>
      </div>
   <br clear="all" />
       <div align="right">
          <a href="javascript:void(0);" role="button" class="btn btn-danger" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Previous</a>
          <a href="javascript:void(0);" role="button" class="btn btn-success" ><span class="fa fa-clock-o"></span>&nbsp;&nbsp;Next</a>
          </div>   
 <?php
}
?>




