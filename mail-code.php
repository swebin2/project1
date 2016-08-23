<?php
require_once "../phpmailer/class.phpmailer.php";

    $score = "";
	$full_name = "";
	$email = "";
	
	$smscontent =  urlencode("Trickyscore Score : ".$score);
				
				 $smsurl = 'http://sms.xeoinfotech.com/httpapi/httpapi?token=7a82967d6b5b3e8e30dbcfca4c26aef9&sender=TRICKY&number='.$mobile.'&route=2&type=1&sms='.$smscontent;
			
				  $ch = curl_init();
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_URL,$smsurl);
						curl_exec($ch);
						
			
				   $mail = new PHPMailer();
				   
				   $message =  'Dear '.$full_name.',<br /><br />

									Thank you for choosing www.trickyscore.com as a tool and practice partner to further your career/ your son’s/daughter’s career.<br />
			
			We are happy to announce the results of the exams held on mm/dd/yyyy.<br />
			
			<score>
			
			To view your performance score & analysis click here Or log on to www.trickyscore.com.<br />
			
			Thank you once again.<br /><br />
			
			 
			
			With regards,<br />
			
			Team Trickyscore.';
						
				  					 
					// And the absolute required configurations for sending HTML with attachement
					
					$mail->SetFrom(FROMMAIL, ADMINNAME);
					$mail->AddAddress($email);
					$mail->Subject = "Score details from ".SITE_NAME;
					$mail->MsgHTML($message);
					$mail->Send();
					
			
                     
?>