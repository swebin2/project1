<?php
require_once "includes/includepath.php";
require('../admin/excelreader/php-excel-reader/excel_reader2.php');
require('../admin/excelreader/SpreadsheetReader.php');


$objgen		=	new general();


     	$Reader = new SpreadsheetReader("sections.xlsx");
		//$Reader = new SpreadsheetReader($import_file);
		$Sheets = $Reader -> Sheets();

		foreach ($Sheets as $Index => $Name)
		{
		//	echo 'Sheet #'.$Index.': '.$Name;

			$Reader -> ChangeSheet($Index);
             $i=0;
			foreach ($Reader as $Row)
			{
			
			    //print_r($Row);
							
				//print_r($Row);exit;
				if($i>0)
				{
					$old_secid   = $Row[3];
					$exam_id     = $Row[5];
					$new_secid   = $Row[7];
					
					$where = " and section='$old_secid'";
					$row_count = $objgen->get_AllRowscnt("question",$where);
					if($row_count>0)
					{
		 			    
						
					 $res_arr = $objgen->get_AllRows("question",0,$row_count,"id asc",$where);
					 
					 foreach($res_arr as $key=>$val)
					 {
					   $msg = $objgen->upd_Row('question',"exam='".$exam_id."',section='".$new_secid."',update_flag=1","id=".$val['id']);
					 }
					 
					  //print_r($res_arr);exit;
					}
				}
							
				$i++;
				
			}
		}
?>