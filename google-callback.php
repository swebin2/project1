<?php
require_once "includes/includepath.php";
ini_set('display_errors', 'On');
$objgen		=	new general();
/*
 * Copyright 2011 Google Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
require_once 'googlelogin/src/apiClient.php';
require_once 'googlelogin/src/contrib/apiOauth2Service.php';
//session_start();

$client = new apiClient();
$client->setApplicationName("Google Account Login");
// Visit https://code.google.com/apis/console?api=plus to generate your
// oauth2_client_id, oauth2_client_secret, and to register your oauth2_redirect_uri.
// $client->setClientId('insert_your_oauth2_client_id');
// $client->setClientSecret('insert_your_oauth2_client_secret');
// $client->setRedirectUri('insert_your_redirect_uri');
// $client->setDeveloperKey('insert_your_developer_key');
$oauth2 = new apiOauth2Service($client);

//print_r($_GET['code']);exit;

if (isset($_GET['code'])) {
  $client->authenticate();
  $_SESSION['token'] = $client->getAccessToken();
  //$redirect = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];
  
  $user = $oauth2->userinfo->get();
  //print_r($user);exit;
  
  $google_id 		 = $user['id'];
 
  
  if($google_id!="")
		{
		   
		    $full_name  = $user['name'];
 		    $email      = $user['email'];
			 
	        
			$sh_exit = $objgen->chk_Ext("users","google_id='$google_id'");
			if($sh_exit>0)
			{
			  $result = $objgen->get_Onerow("users","AND google_id='".$google_id."'");
			  
			  if($result['email']!="" && $result['mobile']!="")
			  {
			  
				  $_SESSION['ma_log_id']		=  $result['id'];
				  $_SESSION['ma_usr_name']	    =  $result['email'];
				  $_SESSION['ma_name']	        =  $result['full_name'];
				  
				  if($result['otp_verify']=="no")
				  {
					header("location:".URL."verify-otp");  
				  }
				  else
				  {
				  
				   header("location:".URLUR);
				   
				  }
			  
			  }
			  else
			  {
				   $_SESSION['ma_log_id']		=  $result['id'];
				   $_SESSION['ma_usr_name']	    =  $email;
				   if($email="")
				    $_SESSION['ma_usr_name']	    =  "Null";
					
				   $_SESSION['ma_name']	        =  $full_name;
				   header("location:".URL."user-signup");
			  }
			
			}
			else
			{
				if($email!="")
				{
					$sh_exit2 = $objgen->chk_Ext("users","email='$email'");
					if($sh_exit2>0)
					{
						 $email = "";
					}
				}
				
				 $status  		= "inactive";
				 $msg = $objgen->ins_Row('users','email,status,full_name,google_id',"'".$email."','".$status."','".$full_name."','".$google_id."'");
				 
				  $my_id = $objgen->get_insetId();
				 
				  $_SESSION['ma_log_id'] = $my_id;
				  header("location:".URL."user-signup");
				 
			}
		
		}
 
 
  
  // $redirect = 'http://buildaholiday.com/beta';
	
  //header('Location: ' . filter_var($redirect, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) {
 $client->setAccessToken($_SESSION['token']);
}

if (isset($_REQUEST['logout'])) {
  unset($_SESSION['token']);
  unset($_SESSION['google_data']); //Google session data unset
  $client->revokeToken();
  header("location:".URL."login");
}

if ($client->getAccessToken()) {
  $user = $oauth2->userinfo->get();
 //print_r($user);exit;

 $_SESSION['google_data']=$user;
//  header("location: ".URL."home");
  // These fields are currently filtered through the PHP sanitize filters.
  // See http://www.php.net/manual/en/filter.filters.sanitize.php
 // $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
 // $img = filter_var($user['picture'], FILTER_VALIDATE_URL);
  //$personMarkup = "$email<div><img src='$img?sz=50'></div>";

  // The access token may have been updated lazily.
  $_SESSION['token'] = $client->getAccessToken();
  
  
  
  
} else {
  $authUrl = $client->createAuthUrl();
}
?>

<?php if(isset($personMarkup)): ?>
<?php print $personMarkup ?>
<?php endif ?>
<?php
  if(isset($authUrl)) {
	    print '<a class="btn btn-primary btn-effect" style="background:#e74b37; box-shadow:0 4px 0 0 #C13726; border-color:#e74b37; color:#fff; font-size:14px; border-radius:0px;"  href='.$authUrl.' >Google</a>';
	  
    //print "<a class='google' href='$authUrl'><i class='fa fa-google-plus-square fa-2x' ></i> Login with Google+</a>";
  } else {
	  
	   print '<a class="btn btn-primary btn-effect" style="background:#e74b37; box-shadow:0 4px 0 0 #C13726; border-color:#e74b37; color:#fff; font-size:14px; border-radius:0px;"  href="'.URL.'google-callback/?logout" > Logout Google</a>';
	  
	  
  // print "<a class='google'  href='".URL."google_login/?logout'><i class='fa fa-google-plus-square fa-2x' ></i> Logout Google+</a>";
  }
?>
